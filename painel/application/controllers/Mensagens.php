<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensagens extends CI_Controller {

	function __construct(){
    parent::__construct();
    $this->login_model->restrito();
		$this->load->model('mensagens_model');
		$this->_init();
	}

	private function _init(){
		$this->output->set_template('default');
	}

	

	/*
	*	Chamada modal demanda
	*/
	public function mensagem_demanda($id_demanda=0,$id_empresa=NULL,$id_mensagem=NULL){
		
		$this->output->unset_template();
		
		$data = array();
		
		$data['title'] = ($id_mensagem == NULL ? 'Cadastrar Mensagem' : 'Atualizar Mensagem').': Demanda #'.$id_demanda;

		$data['action'] = site_url('mensagens/mensagem_demanda_post/'.$id_demanda.'/'.$id_empresa.'/'.$id_mensagem);
		
		$this->load->view('mensagens/form_mensagem_demanda',$data);	
	}
	

	/*
	*	Cadastra Mensagem para demanda no BD
	*/
	public function mensagem_demanda_post($id_demanda=0,$id_empresa=NULL,$id_mensagem=NULL){
		
		$this->output->unset_template();

        $json = array();

		if($id_demanda==0){
            $json['error'] = $json['error_n_demanda'] = 'Erro ao identificar número da demanda';
		}

		if($id_empresa==NULL){
            $json['error'] = $json['error_id_empresa'] = 'Erro ao identificar id da empresa';
		}

		if(!$this->input->post('msg')){
            $json['error'] = $json['error_msg'] = 'Digite a mensagem';
        }
		
        if(!$this->input->post('assunto')){
            $json['error'] = $json['error_assunto'] = 'Digite o assunto da mensagem';
		}
		
		if (!$json) { 

			$data = array(
				'assunto' 	 => $this->input->post('assunto'),
				'msg' 		 => $this->input->post('msg'),
				'id_empresa' => (int)$id_empresa,
				'id_demanda' => (int)$id_demanda,
				'grupo' 	 => 'demanda',
				'atualizada' => date('Y-m-d H:i:s')
			);
			$this->mensagens_model->insert_mensagem($data);
			
			//$this->mensagens_model->mensagem_insert($this->input->post);
			$json['close_modal'] = true;
			$json['load'] = site_url('mensagens/mensagens_demanda/'.(int)$id_demanda);
	    }

        echo json_encode($json);	
	}

	/*
	*	Listar Mensagens demanda id X
	*/
	public function mensagens_demanda($id_demanda=0){
		$this->output->unset_template();
		
		$data = array();
		
		$data['result'] = $this->mensagens_model->get_result_mensagens_demanda($id_demanda);
		
		$this->load->view('mensagens/list_mensagens_demanda',$data);	
	}

	/*
	*	Remover mensagem
	*/
	function remover(){

		$this->output->unset_template();

		if($this->input->get('id_delete')){
			$this->mensagens_model->remover($this->input->get('id_delete'));
			$json['resposta'] = 'Mensagem removida com sucesso';
			$json['ok'] = true;
		}else{
			$json['resposta'] = 'Erro ao identificar mensagem';
			$json['ok'] = false;
		}
		echo json_encode($json);	
	}
	
	

}
