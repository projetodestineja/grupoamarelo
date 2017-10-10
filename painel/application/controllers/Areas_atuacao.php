<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas_atuacao extends CI_Controller {

	var $table = 'areas_atuacao';
	var $column_order = array('id','codigo','area_atuacao','ativo'); //Campos da tabela para ordernar coluna
	var $column_search = array('id','codigo','area_atuacao','ativo'); //campos da tabela para fazer pesquisa no banco
	var $order = array('id' => 'desc'); // Ordem padrão do datagrid

	function __construct(){
    parent::__construct();
    $this->login_model->restrito();
		$this->load->model('areas_atuacao_model');
		$this->load->library(array('form_validation','util'));
		$this->_init();
	}

	private function _init(){
		$this->output->set_template('default');
		$this->load->js('assets/pluguins/datatables/datatables.min.js');
		$this->load->js('assets/pluguins/datatables/dataTables.bootstrap4.js');
		$this->load->js('assets/pluguins/datatables/script.js');
	}

	public function index(){
		$this->load->helper('datatables');
		$this->output->set_common_meta('Áreas de Atuação','',''); //Title / Description / Tags
		$data['menu_mapa'] = array(
			'Áreas de Atuação' => ''
		);

		$data['menu_opcao_direita'][] = anchor('areas_atuacao/add', '<i class="fa fa-fw fa-building-o"></i> Nova Área de Atuação', 'class="btn btn-primary btn-sm not-focusable" data-toggle="tooltip" title="Clique aqui para realizar um novo cadastro"');

		/*$data['menu_opcao_direita'][] = anchor('#', '<i class="fa fa-fw fa-ban"></i> Desabilitar', 'class="btn btn-danger btn-sm not-focusable" id="deletar_row_table"');*/

		//Nome Coluna / Width Coluna em PX
		$table_th = array(
			array('col_name' => '<input name="select_all" value="1" id="example-select-all" type="checkbox" />','col_width' => 18,'col_order' => false),
			array('col_name' => 'Código', 'col_width' => NULL,'col_order' => true),
			array('col_name' => 'Descrição','col_width' => NULL,'col_order' => true),
			array('col_name' => 'Ativo','col_width' => NULL,'col_order' => true),
			array('col_name' => '--' ,'col_width' => 18,'col_order' => false)
		);

		$datagrid = array(
			'grid_id' => 'table', // ID tabela html carregamento
			'load_ajax' => site_url("areas_atuacao/ajax_list"), // URL carregamento ajax Json
			'delete_ajax' => site_url("areas_atuacao/deletar"), // URL deletar registro
			'columns' => $table_th
		);

		$data['table_th'] = $table_th;
		$data['datagrid_js'] = datagrid_js($datagrid);

		$this->load->view('theme/listar',$data);
	}

	public function ajax_list(){

			$this->output->unset_template();

			$list = $this->areas_atuacao_model->get_datatables();
			$data = array();
			$no = $_POST['start'];

			foreach ($list as $dados) {
					$no++;
					$row = array();
					$row[] = '<input type="checkbox" value="'.$dados->id.'" rel="'.$dados->area_atuacao.'" >';
					$row[] = $dados->codigo;
					$row[] = $dados->area_atuacao;
					$row[] = ($dados->ativo==1?'SIM':'NÂO');
					$row[] = '<a href="'.site_url('areas_atuacao/edit/'.$dados->id).'" class="btn btn-sm btn-warning" ><i class="fa fa-fw fa-pencil-square-o"></i></a>';
					$data[] = $row;
			}

			$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->areas_atuacao_model->count_all(),
					"recordsFiltered" => $this->areas_atuacao_model->count_filtered(),
					"data" => $data,
			);

			echo json_encode($output);
	}

	function add(){
      $this->output->set_common_meta('Cadastrar Área de Atuação','',''); //Title / Description / Tags

		  $data = array(
					'area_atuacao' => $this->input->post('area_atuacao'),
					'codigo' => $this->input->post('codigo'),
					// Opções
					'ativo' => $this->input->post('ativo')
      );

      if($this->input->post()){
					$this->form_validation->set_rules('area_atuacao', 'descrição da área de atuação', 'required');
					$this->form_validation->set_rules('codigo', 'código', 'required');

					if($this->form_validation->run()==FALSE){
			        $this->session->set_flashdata('resposta_erro',validation_errors('<div class="error">* ', '</div>'));
					}else{
			        $this->areas_atuacao_model->add($data);
			        $this->session->set_flashdata('resposta_ok', 'Área de atuação <strong>'.$this->input->post('area_atuacao').'</strong> cadastrada com sucesso.');
			        redirect(site_url('areas_atuacao'));
					}
      }

      $data['menu_mapa'] = array(
          'Áreas de Atuação' => $this->uri->segment(1),
          'Cadastrar' => ''
      );

      $data['menu_opcao_direita'][] = anchor('areas_atuacao', '<i class="fa fa-fw fa-undo"></i> Voltar', 'class="btn btn-info btn-sm not-focusable"');
      $this->load->view('areas_atuacao/form',$data);
	}

	function edit($id){

		$data['menu_mapa'] = array(
      'Áreas de Atuação' => $this->uri->segment(1),
      'Atualizar' => ''
    );

		$row = $this->areas_atuacao_model->get_row($id);

		if($row){
			$data['area_atuacao'] = $row->area_atuacao;
			$data['codigo'] = $row->codigo;
			$data['ativo'] = $row->ativo;
		}

		if($this->input->post()){

			$data = array(
				'area_atuacao' => $this->input->post('area_atuacao'),
				'codigo' => $this->input->post('codigo'),
				// opções
				'ativo' => $this->input->post('ativo')
			);

			$this->form_validation->set_rules('area_atuacao', 'descrição da área de atuação', 'required');
			$this->form_validation->set_rules('codigo', 'código', 'required');

			if($this->form_validation->run()==FALSE){
			   $data['resposta_erro'] = validation_errors('<div class="error">* ', '</div>');
			}else{
				$this->areas_atuacao_model->edt($id,$data);
				$this->session->set_flashdata('resposta_ok', 'Área de atuação <strong>'.$this->input->post('nome').'</strong> atualizada com sucesso.');
				redirect(site_url('areas_atuacao'));
			}
		}

		$data['id'] = $id;

		$this->output->set_common_meta('Átualizar Área de Atuação','',''); //Title / Description / Tags

		$data['menu_opcao_direita'][] = anchor('areas_atuacao', '<i class="fa fa-fw fa-undo"></i> Voltar', 'class="btn btn-info btn-sm not-focusable"');
		$this->load->view('areas_atuacao/form',$data);
	}

	function deletar(){
		$this->output->unset_template();
		$array_itens = explode(",",$this->input->post('ids_bloquear'));

		foreach($array_itens as $index => $id){
				if (is_numeric($id) && $id >= 1){
					$this->areas_atuacao_model->bloquear($id); /* model bloquear */
				}
		}

		$error = "Selected countries (id's: ".$this->input->post('ids_bloquear').") blocked with success";
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($error);
	}

}
