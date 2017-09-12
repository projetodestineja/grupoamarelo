<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
		$dados['titulo'] = "Destine Já - Login";
		$this->load->view('painel/login', $dados);
	}

}
