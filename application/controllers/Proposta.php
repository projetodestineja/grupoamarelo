<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposta extends CI_Controller {

	function __construct(){
        parent::__construct();
        
        // ACESSO RESTRITO
		$this->login_model->restrito();
        
        $this->load->model(array('proposta_model'));
        $this->load->library(array());
        $this->_init();
    }
    
    private function _init(){
        $this->output->set_template('default');
    }

	public function index(){
    }
    
    public function visualizar(){
        $this->output->unset_template();
		$data = array();
        $data['title'] = "Deseja aceitar a proposta?";

        $id_proposta = $this->input->get('id');
        $data['proposta'] = $this->proposta_model->get_proposta_id($id_proposta);
        
        $this->load->view('proposta/visualizar',$data);
    }
    
    public function aceitar(){
		$data = array();

        $id_proposta = $this->input->get('id');
        $data = $this->proposta_model->get_proposta_id($id_proposta);

        $data->aceita = "Sim";
        $this->proposta_model->aceitar_proposta($data);
        
        redirect('demanda');
	}

}
