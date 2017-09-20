<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		
		$this->_init();
	}

	private function _init()
	{
		$this->output->set_template('default');

		$this->load->js('painel/assets/pluguins/datatables/jquery.dataTables.js');
		$this->load->js('painel/assets/pluguins/datatables/dataTables.bootstrap4.js');
		
	}
	
	public function index()
	{
		
		$data['title'] = 'Usuários';
		$this->output->set_common_meta($data['title'],'',''); //Title / Description / Tags
		
		//$this->session->set_flashdata('resposta_erro', 'Dados inválidos');
		//$this->session->set_flashdata('resposta_ok', 'É sucesso...');
		
		$data['texto'] = '';
		
		$this->load->view('usuarios/index',$data);
		
	}
}
