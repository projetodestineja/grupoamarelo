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
          $dados['cnpj'] = $this->input->post('cnpj');
          $dados['cpf'] = $this->input->post('cpf');
          $dados['razao_social'] = $this->input->post('rsocial');
          $dados['nome_fantasia'] = $this->input->post('nfantasia');
          $dados['nome_responsavel'] = $this->input->post('nresponsavel');
          $dados['telefone1'] = $this->input->post('tel1');
          $dados['telefone2'] = $this->input->post('tel2');
          $dados['email'] = $this->input->post('email');;
          $dados['cep'] = $this->input->post('cep');
          $dados['logradouro'] = $this->input->post('rua');
          $dados['numero'] = $this->input->post('numero');
          $dados['complemento'] = $this->input->post('complemento');
          $dados['bairro'] = $this->input->post('bairro');
          $dados['id_cidade'] = $this->input->post('cidade');
          $dados['id_estado'] = $this->input->post('estado');
          $dados['senha'] = $this->input->post('senha1');
          $dados['tipo'] = $this->input->post('tipo');
	        $this->empresa_model->gravar($dados);
	    } else{
	        $dados['erro'] = $erro;
	    }

			$dados['titulo'] = "Destine Já - Login";
			$this->load->view('painel/login', $dados);
	}

}