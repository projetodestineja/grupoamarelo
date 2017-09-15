<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->load->model('empresa_model');
	}

	public function index(){
		$this->load->view('welcome_message');
	}
        
        public function gerador(){
		$dados['titulo'] = "Destine Já - Cadastro";
                
                /*$this->db->where('id',1);
                $rows = $this->db->get('empresas')->row();
                $dados['cnpj'] = $rows->cnpj;*/
                
		$this->load->view('empresas/gerador', $dados);
	}

	public function coletor(){
		$dados['titulo'] = "Destine Já - Cadastro";
		$this->load->view('empresas/coletor', $dados);
	}
        
        public function cadastrar(){
            
            
            
            $erro = '';   
           
            if(empty($erro)){
                $dados = array(
                    'cnpj'=> $this->input->post('cnpj')
                );
                 
                $this->empresa_model->gravar($dados);
            }else{
                $dados['erro'] = $erro; 
            }
            
            $dados['titulo'] = "Cadastro - Gerador de Resíduo";
            
            $this->load->view('empresas/gerador', $dados);
            
            
	}
}
