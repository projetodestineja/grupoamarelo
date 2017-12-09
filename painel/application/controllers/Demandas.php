<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demandas extends CI_Controller {

	function __construct(){
    parent::__construct();
    $this->login_model->restrito();
		$this->load->model('demandas_model');
		$this->load->model('endereco_model');
		$this->load->library(array('pagination','util'));
		$this->_init();
	}

	private function _init(){
		
		//fancybox
		$this->load->js('assets/pluguins/fancybox/source/jquery.fancybox.js');
		$this->load->css('assets/pluguins/fancybox/source/jquery.fancybox.css');
		
		$this->output->set_template('default');
	}

	public function index(){
		
		$data = array();
		
		$title = 'Demandas';
        $this->output->set_common_meta($title, '', ''); //Title / Description / Tags
        $data['menu_mapa'] = array(
            $title => 'demandas'
		);

		$data['menu_opcao_direita'][] = anchor(
			'demandas/modal_filtro',
			'<i class="fa fa-fw fa-filter"></i> Filtro',
			'class="btn btn-primary btn-sm not-focusable" rel="modal_add_edit" data-toggle="tooltip" title="Fazer Filtro"'
		);

		if ($this->input->get('cidade')){
			
			$this->load->model('cidades_model');
			$cidade = $this->cidades_model->get_row_cidade($this->input->get('cidade'));
			
			//$dados['demandas'] = $this->demanda_model->lista_demandasbycidade($this->session->userdata['empresa']['id_cidade']);
			
			$this->output->set_common_meta('Demandas para Coleta em '.$cidade->nome_cidade.'/'.$cidade->uf,'',''); 
			
		}else if ($this->input->get('estado')){
			
			$this->output->set_common_meta('Demandas para Coleta em '.$this->input->get('estado'),'',''); 
			
		}else{
			
			$this->output->set_common_meta('Demandas para Coleta','',''); 
			
		}
		
		/*
		* Montamos a url para o ajax
		*/
		$url_ajax = 'demandas/get_list/?';
		if($this->input->get('cidade')){
			$url_ajax.='&cidade='.$this->input->get('cidade');
		}
		if($this->input->get('estado')){
			$url_ajax.='&estado='.$this->input->get('estado');
		}
		if($this->input->get('status')){
			$url_ajax.='&status='.$this->input->get('status');
		}
		if($this->input->get('categoria')){
			$url_ajax.='&categoria='.$this->input->get('categoria');
		}
		$data['url_ajax'] = site_url($url_ajax);

		$this->load->view('demandas/index',$data);
	}
	
	
	/*
	*	Lista Demandas Ajax
	*/
	public function get_list(){
		
		$this->output->unset_template();

		$data = array();
		$result = array();
		$where = '';
		$prefix = '';

		if($this->input->get('cidade')){
			$where.= " d.ger_id_cidade = '".(int)$this->input->get('cidade')."' and  ";
			$prefix = '&estado='.$this->input->get('estado').'&cidade='.$this->input->get('cidade');
		}
		if($this->input->get('status')){
			$where.= " d.status = ".$this->input->get('status')." and  ";
			$prefix = '&status='.$this->input->get('status');
		}
		if($this->input->get('estado')){
			$where.= " d.ger_uf_estado = '".$this->input->get('estado')."' and  ";
			$prefix = '&estado='.$this->input->get('estado');
		}
		if($this->input->get('categoria')){
			$where.= " d.id_cat_residuo = ".$this->input->get('categoria')." and  ";
			$prefix = '&categoria='.$this->input->get('categoria');
		}

		$config = array(
			"base_url" => base_url('demandas/get_list/'),
			"reuse_query_string" => true,
			"per_page" => 5, //Quantiade de registros litados
			"uri_segment" => 3, //URI a ser pegado para identificar a página a ser visualizada
			"total_rows" => $this->demandas_model->get_result_demandas($where,true)->num_rows(),
			"first_link" => TRUE,
			"last_link" => TRUE
		);

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['result'] = $this->demandas_model->get_result_demandas($where,false,'d.cadastrada','desc',$config['per_page'],$offset)->result();
		
		$this->load->view('demandas/list',$data);
	}

	
	/*
	*	Visualizar demanda
	*/
	public function visualizar($id_demanda){
		
		$data = array();
		
		$data['row'] = $this->demandas_model->get_row_demanda_ver($id_demanda);	
		$this->load->model('demandas_status_model');
		$data['result_status'] = $this->demandas_status_model->get_all();
	
		$data['status_result'] = $this->demandas_model->get_result_status();

		$data['menu_opcao_direita'][] = anchor(
			'mensagens/mensagem_demanda/'.$id_demanda.'/'.$data['row']['ger_id_empresa'], '<i class="fa fa-fw fa-plus-circle"></i> Enviar Mensagem', 
			' rel="modal_add_edit" class="btn btn-primary btn-sm not-focusable"  data-toggle="tooltip" '
		);
		
		$title = 'Visualizar Demanda #'.$id_demanda;
		
		//Title / Description / Tags
        $this->output->set_common_meta($title, '', ''); 
		
		$data['menu_mapa'] = array(
			'Demandas' => $this->uri->segment(1),
			'Visualizar' => ''
		);
		
		$this->load->view('demandas/ver',$data);
	}
	
	/*
	*	Atualiza Status da demanda
	*/
	public function post_update_status(){
		
		$this->output->unset_template();
		$this->load->model('demandas_status_model');

        $json = array();

        if(!$this->input->post('status')){
            $json['error'] = $json['error_status'] = 'Selecione o status';
        }
		if(!$this->input->post('id_demanda')){
            $json['error'] = $json['error_demanda'] = 'Erro ao identificar demanda';
        }

		if (!$json) { 
			
			$this->demandas_model->updade_status($this->input->post('status'),$this->input->post('id_demanda'));
			
			$status = $this->demandas_status_model->get_row($this->input->post('status'));
			
			$json['ok'] = 'Status atualizado para: <b>'.$status->descricao.'</b>';
			$json['data_update'] = date('d/m/Y H:i');
			$json['load'] = site_url('demandas/status_demanda_historico/'.$this->input->post('id_demanda'));
		}

        echo json_encode($json);
	}
	
	/*
	*	Chamda modal demanda
	*/
	public function mensagem_demanda($id_demanda=0){
		
		$this->output->unset_template();
		
		$data = array();
		
		$data['id_demanda'] = $id_demanda;
		$data['title'] = ($id_demanda == 0 ? 'Cadastrar Mensagem' : 'Atualizar Mensagem').': Demanda #'.$id_demanda;
		
		$this->load->view('demandas/form_mensagem',$data);	
	}
	
	/*
	*	Cadastra Mensagem para demanda no BD
	*/
	public function mensagem_demanda_post($id_demanda=0){
		
		$this->output->unset_template();

        $json = array();

		if(!$this->input->post('msg')){
            $json['error'] = $json['error_msg'] = 'Digite a mensagem';
        }
		
        if(!$this->input->post('assunto')){
            $json['error'] = $json['error_assunto'] = 'Digite o assunto da mensagem';
        }
		
		if (!$json) { 
			/*
			* Arqui fazemos o insert ou Upldate Há
			*/
			$json['close_modal'] = true;
	    }

        echo json_encode($json);	
	}
	
	/*
	*	Listar histórico de modificações de histórico
	*/
	public function status_demanda_historico($id_demanda=false){
		$this->output->unset_template();
		
		$data = array();
		
		$data['result'] = $this->demandas_model->get_result_status_historico($id_demanda);
		
		$this->load->view('demandas/status_historico',$data);	
		
	}
	
	/*
	*	Remover Demanda	
	*/
	public function deletar(){
		$this->output->unset_template();
		$array_itens = explode(",",$this->input->post('ids_bloquear'));

		foreach($array_itens as $index => $id){
			if (is_numeric($id) && $id >= 1){
				$this->demandas_status_model->bloquear($id); 
			}
		}

		$error = "Selected countries (id's: ".$this->input->post('ids_bloquear').") blocked with success";
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($error);
	}

	public function modal_filtro(){
		$this->output->unset_template();
		$data = array();
		$data['title'] = "Filtrar Demandas";
		
		// Listamos todos estados normalmente
		$data['estados'] = $this->endereco_model->get_all_estados(); 
		
		/*$uf = ($this->input->post('estado') ? $this->input->post('estado') : $row->uf_estado);
		$data['cidades'] = $this->endereco_model->get_all_cidades($uf); //<-UF no EDIT pra listar apenas a cidades do estado selecionado*/
		
		// Categorias de resíduos 
		$data['categorias_residuos'] = $this->demandas_model->get_categorias_residuos();

		// Status de demandas 
		$data['demandas_status'] = $this->demandas_model->get_result_status();
		
		$this->load->view('demandas/filtro',$data);
	}
	
	
	/*
	*	Cadastrar arquivo comprovante demanda
	*/
	public function comprovante_arquivo_add($id_demanda = 0) {
		
        $this->output->unset_template();

        $json = array();

        if ($id_demanda == 0) {
            $json['error'] = $json['error_empresa'] = 'Erro o identificar demanda';
        }
       
        if (!is_uploaded_file($_FILES['licenca']['tmp_name'])) {
			
			 $json['error'] = $json['error_empresa'] = 'Selecione o arquivo a ser cadastrado';	
			
		}else{
			
			$this->load->library('upload');
			
            $dir_upload = '../uploads/demandas/'.$id_demanda; //diretório para upload
            
			if (!is_dir($dir_upload)) { 
                mkdir($dir_upload, 0777, true);   
            }

            // Config upload
			$config['upload_path'] = $dir_upload;
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = date('Y-m-d_H-i') . '_ID' . $id_demanda . '_' . rand(1000, 9999); // Data Upload / ID empresa / Rand entre 1000 e 9999 
            $config['max_filename_increment'] = 300;
            $config['max_size'] = 10240; //(10*1024kb) = 10MB
            $config['max_width'] = 5024;
            $config['max_height'] = 5068;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('licenca')) {
                $json['error'] = $json['error_licenca'] = $this->upload->display_errors('', '');
            } else {
                $upload = $this->upload->data();
                $nome_arquivo = $upload['file_name'];
            }
        }

        if (!$this->input->post('titulo')) {
            $json['error'] = $json['error_titulo'] = 'Digite o nome do arquivo';
        }

        if (!$json) {
			
            $this->demandas_model->comprovante_arquivo_insert($this->input->post(), $nome_arquivo, $id_demanda);
            $json['resposta'] = 'Arquivo cadastrado com sucesso';
            $json['id_demanda'] = $id_demanda;
			$json['ok'] = true;
        }

        echo json_encode($json);
    }
	
	
	 public function arquivo_download($id_arquivo) {

        $this->output->unset_template();

        $row = $this->demandas_model->comprovante_arquivo_list_row($id_arquivo);
		
		if(isset($row)){
			
			$arquivo = '../uploads/demandas/' . $row->id_demanda. '/' . $row->arquivo;
			
			$nome_saida = $row->titulo;
			
			if (is_file($arquivo)) {
				$this->util->ArquivoVer($arquivo, $nome_saida);
			} else {
				echo 'arquivo não encontrado';
				exit;
			}
		}else{
			echo 'Erro interno';
			exit;
		}
    }
	
	public function comprovante_arquivo_list($id_demanda) {
		
		$this->output->unset_template();
		
        $id_empresa = (int) $this->session->userdata['empresa']['id'];
        
        $data['result'] = $this->demandas_model->comprovante_arquivo_list_result($id_demanda);

        $this->load->view('coleta/comprovante_arquivo_list', $data);
    }

}
