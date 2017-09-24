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

	public function coletor(){
		$dados['titulo'] = "Destine Já - Cadastro";
		$this->load->view('empresas/coletor', $dados);
	}

	public function consultar($tipo){
		if ($tipo == "2"){
			$data['title'] = 'Coletoras';
			$form_edicao = 'edt_coletor';
		} elseif ($tipo == "1"){
			$data['title'] = 'Geradoras';
			$form_edicao = 'edt_gerador';
		}

		$this->output->set_common_meta($data['title'],'',''); //Title / Description / Tags

		$data['result'] = $this->empresa_model->consultar($tipo);
		$data['form_edicao'] = $form_edicao;

		$this->load->view('empresas/listar',$data);
	}

	public function atualizar(){
	    $erro = '';
			$tipo = $this->input->post('tipo');

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
          $dados['id'] = $this->input->post('id');
          $dados['senha'] = $this->input->post('senha1');
	        $this->empresa_model->atualizar($dados);
	    } else{
	        $dados['erro'] = $erro;
	    }

			$this->consultar($tipo);
	}

	public function edt_coletor($id){
		$data['title'] = 'Cadastro - Coletor de Resíduos';
		$this->output->set_common_meta($data['title'],'',''); //Title / Description / Tags

		$this->load->js('assets/js/jquery-3.2.1.min.js');
		$this->load->js('assets/js/popper.min.js');
		$this->load->js('assets/js/bootstrap.min.js');
		$this->load->js('assets/pluguins/jquery.mask.js');
		$this->load->js('assets/js/js.js');
		$this->load->js('assets/pluguins/buscacep.js');
		$this->load->js('assets/pluguins/buscacnpj.js');

		$this->load->model('../../../application/models/cidade_model');

		$this->load->model('../../../application/models/funcao_empresa_model');
		$data['funcoes'] = $this->funcao_empresa_model->lista_funcao('Coletor');

		$this->load->model('../../../application/models/area_atuacao_model');
		$data['areas'] = $this->area_atuacao_model->lista_area_atuacao('C');

		$this->load->model('../../../application/models/estado_model');
		$data['estados'] = $this->estado_model->lista_estados();


		$data['result'] = $this->empresa_model->consultar_coletoraId($id);

		if ('ativo' == 0){
			$data['bt_ativo'] = 'info';
			$data['icon_ativo'] = 'unlock';
			$data['texto_ativo'] = 'Desbloquear Cadastro';
			$data['acao_ativo'] = '1';
		} else{
			$data['bt_ativo'] = 'warning';
			$data['icon_ativo'] = 'lock';
			$data['texto_ativo'] = 'Bloquear Cadastro';
			$data['acao_ativo'] = '0';
		}

		$this->load->view('empresas/edt_coletor',$data);
	}

	public function desbloquear($acao,$id){
		$this->empresa_model->desbloquear($acao,$id);
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
