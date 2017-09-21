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

		$this->load->js('assets/pluguins/datatables/jquery.dataTables.js');
		$this->load->js('assets/pluguins/datatables/dataTables.bootstrap4.js');
		
	}
	
	public function index()
	{
		
		$data['title'] = 'Usuários';
		$this->output->set_common_meta($data['title'],'',''); //Title / Description / Tags
		
		//$this->session->set_flashdata('resposta_erro', 'Dados inválidos');
		//$this->session->set_flashdata('resposta_ok', 'É sucesso...');
                
                $this->db->where('id',2); 
                $this->db->delete('usuarios');
                
                $this->db->where('id',3); 
                $data['user_row'] = $this->db->get('usuarios')->row();
                
                
               // $this->db->order_by('id','desc');
                //$this->db->where('id <= ',9); 
                $data['result'] = $this->db->query('select * from usuarios')->result();
		
		
		$this->load->view('usuarios/index',$data);
		
	}
}
