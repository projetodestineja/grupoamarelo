<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demandas extends CI_Controller {

	function __construct(){
    parent::__construct();
    $this->login_model->restrito();
		$this->load->model('demandas_model');
		$this->load->library(array('pagination'));
		$this->_init();
	}

	private function _init(){
		$this->output->set_template('default');
	}

	public function index(){
		
		$data = array();
		
		$title = 'Demandas';
        $this->output->set_common_meta($title, '', ''); //Title / Description / Tags
        $data['menu_mapa'] = array(
            $title => 'demandas'
        );

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
		
		$data['menu_opcao_direita'][] = anchor(
			'demandas/mensagem_demanda/'.$id_demanda, '<i class="fa fa-fw fa-plus-circle"></i> Enviar Mensagem', 
			' rel="modal_add_edit" class="btn btn-primary btn-sm not-focusable"  data-toggle="tooltip" '
		);
		
		$title = 'Visualizar Demanda #'.$id_demanda;
		
		//Title / Description / Tags
        $this->output->set_common_meta($title, '', ''); 
		
		$data['menu_mapa'] = array(
			'Demandas' => $this->uri->segment(1),
			'Visualizar' => ''
		);
		
		$this->load->model('demandas_status_model');
		$data['result_status'] = $this->demandas_status_model->get_all();
		
		$data['row'] = $this->demandas_model->get_row_demanda_ver($id_demanda);	
		$data['status_result'] = $this->demandas_model->get_result_status();
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

}
