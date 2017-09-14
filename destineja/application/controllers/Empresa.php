<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->view('welcome_message');
	}
        
        public function gerador(){
		$dados['titulo'] = "Destine Já - Cadastro";
		$this->load->view('empresas/gerador', $dados);
	}

	public function coletor(){
		$dados['titulo'] = "Destine Já - Cadastro";
		$this->load->view('empresas/coletor', $dados);
	}
        
        public function cadastrar(){
		echo "cadastrar";
	}
}
