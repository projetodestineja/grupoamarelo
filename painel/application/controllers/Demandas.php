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


	public function visualizar($id_demanda){
		$data = array();
		$data['row'] = $this->demandas_model->get_row_demanda($id_demanda);	
		$data['status_result'] = $this->demandas_model->get_result_status();
		$this->load->view('demandas/ver',$data);
	}
	

	public function deletar(){
		$this->output->unset_template();
		$array_itens = explode(",",$this->input->post('ids_bloquear'));

		foreach($array_itens as $index => $id){
			if (is_numeric($id) && $id >= 1){
				$this->demandas_status_model->bloquear($id); /* model bloquear */
			}
		}

		$error = "Selected countries (id's: ".$this->input->post('ids_bloquear').") blocked with success";
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($error);
	}

}
