<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->login_model->restrito();    
		
		$this->_init();
	}

	private function _init(){
		$this->output->set_template('default');

		$this->load->js('assets/pluguins/jquery-easing/jquery.easing.min.js');
		$this->load->js('assets/pluguins/chart.js/Chart.min.js');
		$this->load->js('assets/pluguins/chart.js/script.js');
		
	}
	
	public function index(){
		
		$this->output->set_common_meta('Painel Administrativo','',''); //Title / Description / Tags
		
		$data = array();
		$this->load->view('painel',$data);
		
	}
}
