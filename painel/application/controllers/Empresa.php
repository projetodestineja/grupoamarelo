<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

	function __construct(){
		parent::__construct();
    $this->load->model('empresa_model');
		$this->_init();
	}

	private function _init()
	{
		$this->output->set_template('default');
		$this->load->js('assets/pluguins/datatables/jquery.dataTables.js');
		$this->load->js('assets/pluguins/datatables/dataTables.bootstrap4.js');
	}

	public function index(){
		$this->load->view('welcome_message');
	}

  public function gerador(){
		$dados['titulo'] = "Destine Já - Cadastro";
		$this->load->view('empresas/gerador', $dados);
	}

	public function consultar_g()
	{
		$data['title'] = 'Geradoras';
		$this->output->set_common_meta($data['title'],'',''); //Title / Description / Tags

		$data['result'] = $this->empresa_model->consultar_geradoras();

		$this->load->view('empresas/lst_geradoras',$data);
	}

	public function coletor(){
		$dados['titulo'] = "Destine Já - Cadastro";
		$this->load->view('empresas/coletor', $dados);
	}

	public function consultar_c()
	{
		$data['title'] = 'Coletoras';
		$this->output->set_common_meta($data['title'],'',''); //Title / Description / Tags

		$data['result'] = $this->empresa_model->consultar_coletoras();

		$this->load->view('empresas/lst_coletoras',$data);
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
