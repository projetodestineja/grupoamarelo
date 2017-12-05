<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposta extends CI_Controller {

	function __construct(){
    parent::__construct();
    $this->login_model->restrito();
		$this->load->model('proposta_model');
		$this->_init();
	}

	private function _init(){
		$this->output->set_template('default');
	}

	public function index(){

    }

    public function listar_propostas($id_demanda=false){
        $this->output->unset_template();
		$data = array();
        $data['hoje'] = date("Y-m-d");
        
		$data['propostas'] = $this->proposta_model->get_propostas($id_demanda);
		
		$this->load->view('proposta/ver',$data);
    }

}