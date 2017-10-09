<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painelempresa extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		
		$this->_init();
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
		
		$this->output->set_common_meta('Painel Administrativo','',''); //Title / Description / Tags
		
		//$this->session->set_flashdata('resposta_erro', 'Dados inválidos');
		//$this->session->set_flashdata('resposta_ok', 'É sucesso...');
		
		//$data['texto'] = 'AAAAAAAAAA';
		$data = array();
		//$this->load->view('painel',$data);
		
	}
}
