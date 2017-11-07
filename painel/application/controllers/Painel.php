<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->login_model->restrito();    
		$this->_init();
                $this->load->model('empresa_model');
                $this->load->model('demandas_model');
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
                
                $data['total_geradoras'] = $this->empresa_model->count_all(1);
                $data['total_coletoras'] = $this->empresa_model->count_all(2);
                $data['total_geradoras_coletoras'] = $this->empresa_model->count_all(3);
                $data['empresas_bloqueadas'] = $this->empresa_model->count_all_bloqueadas();
                
                $data['total_demandas'] = $this->demandas_model->count_all(0);
                $data['demandas_aguardando'] = $this->demandas_model->count_all(1);
                
		$this->load->view('painel',$data);
		
	}
}
