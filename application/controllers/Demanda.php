<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demanda extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->_init();
	}

        private function _init()
	{
                if($this->session->has_userdata('empresa') ) { 
                    $this->output->set_template('default');
                }
                else {
                    $this->session->set_flashdata("erro","Faça o Login");
                    redirect(base_url('login'));
                }  
	}
        
	public function lista_demandas(){
                
            //Carregando plugins auxiliares para listar a tabela
            $this->load->js('painel/assets/pluguins/datatables/datatables.min.js');
            $this->load->js('painel/assets/pluguins/datatables/dataTables.bootstrap4.js');
            $this->load->js('painel/assets/pluguins/datatables/script.js');
            
            if ($this->session->userdata['empresa']['funcao']==1){
                $this->load->model('demanda_model');
                $dados['demandas'] = $this->demanda_model->lista_demandasbyid($this->session->userdata['empresa']['id']);
            }
            $this->output->set_common_meta('Lista de Demandas','',''); //Title / Description / Tags
            $this->load->view('demanda/lista_demandas',$dados);
	}

}
