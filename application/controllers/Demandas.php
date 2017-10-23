<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demandas extends CI_Controller {

	var $table = 'demandas';
	var $column_order = array('id','residuo','status','data_validade'); //Campos da tabela para ordernar coluna
	var $column_search = array('id','residuo','status','data_validade'); //campos da tabela para fazer pesquisa no banco
	var $order = array('data_validade' => 'desc'); // Ordem padrão do datagrid

	function __construct(){
		parent::__construct();
		$this->login_model->restrito();
		$this->load->model(array('empresa_model', 'demandas_model', 'endereco_model'));
		$this->load->library(array('form_validation','util','upload'));
		$this->_init();
	}

	private function _init(){
		$this->output->set_template('default');
		$this->load->js('painel/assets/pluguins/datatables/datatables.min.js');
		$this->load->js('painel/assets/pluguins/datatables/dataTables.bootstrap4.js');
		$this->load->js('painel/assets/pluguins/datatables/script.js');
	}

	public function index(){
		$this->load->helper('datatables');
		$this->output->set_common_meta('Demandas','',''); //Title / Description / Tags
		$data['menu_mapa'] = array(
			'Demandas' => ''
		);

		$data['menu_opcao_direita'][] = anchor('demandas/add', '<i class="fa fa-fw fa-plus"></i> Nova Demanda', 'class="btn btn-primary btn-sm not-focusable" data-toggle="tooltip" title="Clique aqui para cadastrar uma demanda"');

		/*$data['menu_opcao_direita'][] = anchor('#', '<i class="fa fa-fw fa-ban"></i> Desabilitar', 'class="btn btn-danger btn-sm not-focusable" id="deletar_row_table"');*/

		//Nome Coluna / Width Coluna em PX
		$table_th = array(
			array('col_name' => '<input name="select_all" value="1" id="example-select-all" type="checkbox" />','col_width' => 18,'col_order' => false),
			array('col_name' => 'Resíduo', 'col_width' => NULL,'col_order' => true),
			array('col_name' => 'Status','col_width' => NULL,'col_order' => true),
			array('col_name' => 'Data de Expiração','col_width' => NULL,'col_order' => true),
			array('col_name' => '--' ,'col_width' => 18,'col_order' => false)
		);

		$datagrid = array(
			'grid_id' => 'table', // ID tabela html carregamento
			'load_ajax' => site_url("demandas/ajax_list"), // URL carregamento ajax Json
			'delete_ajax' => site_url("demandas/deletar"), // URL deletar registro
			'columns' => $table_th
		);

		$data['table_th'] = $table_th;
		$data['datagrid_js'] = datagrid_js($datagrid);

		$this->load->view('theme/listar',$data);
	}

	public function ajax_list(){

			$this->output->unset_template();

			$list = $this->demandas_model->get_datatables();
			$data = array();
			$no = $_POST['start'];

			foreach ($list as $dados) {
					$no++;
					$row = array();
					$row[] = '<input type="checkbox" value="'.$dados->id.'" rel="'.$dados->demandas.'" >';
					$row[] = $dados->residuo;
					$row[] = $dados->status;
                    /*$row[] = ($dados->ativo==1?'SIM':'NÂO');*/
                    $row[] = ($dados->data_validade);
					$row[] = '<a href="'.site_url('demandas/edit/'.$dados->id).'" class="btn btn-sm btn-warning" ><i class="fa fa-fw fa-pencil-square-o"></i></a>';
					$data[] = $row;
			}

			$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->demandas_model->count_all(),
					"recordsFiltered" => $this->demandas_model->count_filtered(),
					"data" => $data,
			);

			echo json_encode($output);
	}

	public function do_upload(){
		$dire_upload = './uploads/empresa/72/'; //diretório para upload
		if (!is_dir($dire_upload)) { // verificamos se ele existe
			mkdir($dire_upload); // não existe, então vamos criar...           
		}
		$config['upload_path'] = $dire_upload;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['file_name'] = date('Y-m-d_H-i') . '_asdasdsaID_' . rand(1000, 9999); // Data Upload / ID empresa / Rand entre 1000 e 9999 
		$config['max_filename_increment'] = 300;
		$config['max_size'] = 5120; //(10*1024kb) = 10MB
		$config['max_width'] = 5024;
		$config['max_height'] = 5068;

		//$config['upload_path']          = '../uploads/demandas/';
		/*$config['upload_path']          = $dir_upload;
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 5120;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;*/

		$this->load->library('upload', $config);
	}

	public function add(){
		$this->output->set_common_meta('Cadastrar Demanda','',''); //Title / Description / Tags
		$data = array(
			//duração da demanda
			'data_inicio' => $this->input->post('data_inicio'),
			'data_validade' => $this->input->post('data_validade'),
			//informações do resíduo
			'residuo' => $this->input->post('residuo'),
			'condicionado' => $this->input->post('condicionado'),
			'qtd' => $this->input->post('qtd'),
			'uni_medida' => $this->input->post('uni_medida'),
			//img
			'img' => $this->input->post('img1'),
			//observações
			'obs' => $this->input->post('obs')
		);
		
		// dados da empresa geradora
		$id = (int) $this->session->userdata['empresa']['id'];
		
		$row = $this->empresa_model->consultar_coletoraId($id);
		if (!$row) {
			$this->session->set_flashdata('resposta_erro', 'Empresa não identificada.');
			redirect(site_url('demandas'));
		}
		
		$data['id'] = $row->id;
		$data['cep'] = $row->cep;
		$data['logradouro'] = $row->logradouro;
		$data['numero'] = $row->numero;
		$data['complemento'] = $row->complemento;
		$data['bairro'] = $row->bairro;
		$data['id_cidade'] = $row->id_cidade;
		$data['uf_estado'] = $row->uf_estado;
		$uf = ($this->input->post('estado') ? $this->input->post('estado') : $row->uf_estado);
        $data['estados'] = $this->endereco_model->get_all_estados(); // Listamos todos estados normalmente
        $data['cidades'] = $this->endereco_model->get_all_cidades($uf); //<-UF no EDIT pra listar apenas a cidades do estado selecionado
		// dados da empresa geradora
		
		// validação dos campos
		if($this->input->post()){
			$this->form_validation->set_rules('data_inicio', 'data de início da demanda', 'required');
			$this->form_validation->set_rules('data_validade', 'data de expiração da demanda', 'required');
			$this->form_validation->set_rules('residuo', 'descrição do resíduo', 'required');
			$this->form_validation->set_rules('condicionado', 'como está acondicionado', 'required');
			$this->form_validation->set_rules('qtd', 'quantidade', 'required');
			$this->form_validation->set_rules('uni_medida', 'unidade de medida', 'required');
			/*$this->form_validation->set_rules('img1', 'imagem (1)', 'required');*/
			$this->form_validation->set_rules('obs', 'observação', 'required');
			$this->form_validation->set_rules('cep', 'CEP', 'required');
			$this->form_validation->set_rules('logradouro', 'logradouro', 'required');
			$this->form_validation->set_rules('numero', 'número', 'required');
			/*$this->form_validation->set_rules('complemento', 'complemento', 'required');*/	
			$this->form_validation->set_rules('bairro', 'bairro', 'required');
			$this->form_validation->set_rules('cidade', 'cidade', 'required');
			$this->form_validation->set_rules('estado', 'estado', 'required');

			if($this->form_validation->run()==FALSE){
				$this->session->set_flashdata('resposta_erro',validation_errors('<div class="error">* ', '</div>'));
			}else{
				//upload img
				if ( ! $this->upload->do_upload('img1')){
					$error = array('error' => $this->upload->display_errors());
					$this->load->view('demandas/form_cad_demanda', $error);
					/*redirect(site_url('demandas'));*/
				} else{
					$data = array('upload_data' => $this->upload->data());
					/*$this->load->view('upload_success', $data);*/
					
					$this->demandas_model->add($data);
					$this->session->set_flashdata('resposta_ok', 'Demanda <strong>'.$this->input->post('residuo').'</strong> cadastrada com sucesso.');
					redirect(site_url('demandas'));

				}
				//upload img
			}

		}
		// validação dos campos
		
		$data['menu_mapa'] = array(
			'Demandas' => $this->uri->segment(1),
			'Cadastrar' => ''
		);

		$data['menu_opcao_direita'][] = anchor('demandas', '<i class="fa fa-fw fa-undo"></i> Voltar', 'class="btn btn-info btn-sm not-focusable"');
		$this->load->view('demandas/form_cad_demanda',$data);
	}

	function edit($id){

		$data['menu_mapa'] = array(
      'Áreas de Atuação' => $this->uri->segment(1),
      'Atualizar' => ''
    );

		$row = $this->demandas_model->get_row($id);

		if($row){
			$data['data_inicio'] = $row->data_inicio;
			$data['data_validade'] = $row->data_validade;
            $data['residuo'] = $row->residuo;
            $data['condicionado'] = $row->condicionado;
            $data['qtd'] = $row->qtd;
            $data['uni_medida'] = $row->uni_medida;
            $data['obs'] = $row->obs;
		}

		if($this->input->post()){

			$data = array(
				//duração da demanda
                'data_inicio' => $this->input->post('data_inicio'),
                'data_validade' => $this->input->post('data_validade'),
                //informações do resíduo
                'residuo' => $this->input->post('residuo'),
                'condicionado' => $this->input->post('condicionado'),
                'qtd' => $this->input->post('qtd'),
                'uni_medida' => $this->input->post('uni_medida'),
                //observações
                'obs' => $this->input->post('obs')
			);

			$this->form_validation->set_rules('data_inicio', 'data de início da demanda', 'required');
            $this->form_validation->set_rules('data_validade', 'data de expiração da demanda', 'required');
            $this->form_validation->set_rules('residuo', 'descrição do resíduo', 'required');
            $this->form_validation->set_rules('condicionado', 'como está acondicionado', 'required');
            $this->form_validation->set_rules('qtd', 'quantidade', 'required');
            $this->form_validation->set_rules('uni_medida', 'unidade de medida', 'required');
            $this->form_validation->set_rules('obs', 'observação', 'required');

			if($this->form_validation->run()==FALSE){
			   $data['resposta_erro'] = validation_errors('<div class="error">* ', '</div>');
			}else{
				$this->demandas_model->edt($id,$data);
				$this->session->set_flashdata('resposta_ok', 'Demanda <strong>'.$this->input->post('residuo').'</strong> atualizada com sucesso.');
				redirect(site_url('demandas'));
			}
		}

		$data['id'] = $id;

		$this->output->set_common_meta('Átualizar Demanda','',''); //Title / Description / Tags

		$data['menu_opcao_direita'][] = anchor('demandas', '<i class="fa fa-fw fa-undo"></i> Voltar', 'class="btn btn-info btn-sm not-focusable"');
		$this->load->view('demandas/form_cad_demanda',$data);
	}

}
