<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painelempresa extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->_init();
                $this->load->model('empresa_model');
                $this->load->library('session'); 
	}

	private function _init()
	{
            
                if($this->session->has_userdata('empresa') ) { 
                    $this->output->set_template('default');
                    $this->load->js('painel/assets/pluguins/jquery-easing/jquery.easing.min.js');
                    $this->load->js('painel/assets/pluguins/chart.js/Chart.min.js');
                }
                else {
                    $this->session->set_flashdata("erro","Faça o Login");
                    redirect(base_url('login'));
                }  
	}
	
	public function index()
	{
		
                switch ($this->session->userdata['empresa']['funcao']){
                    
                    case 1:
                        $this->output->set_common_meta('Painel Administrativo Geradora','',''); 
                        $this->load->view('dashboard/bemvindo_geradora');
                        $this->load->view('dashboard/faq_geradora');
                        break;
                    case 2:
                        $this->output->set_common_meta('Painel Administrativo Coletora','',''); 
                        $this->load->view('dashboard/painel_coletora');
                        break;
                    case 3:
                        $this->output->set_common_meta('Painel Administrativo Geradora e Coletora','',''); 
                        $this->load->view('dashboard/painel_coletora');
                        break;
                }
                
		$data = array();
		//$this->load->view('painel',$data);
		
	}
}
