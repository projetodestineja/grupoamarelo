<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->load->model('login_model');
                $this->load->library('util');
	}

	public function index(){
            
            if ( ($this->input->post('cnpj')) || ($this->input->post('cpf')) || ($this->input->post('email')) && ($this->input->post('senha'))){
                $tipo_login = $cnpj = ($this->input->post('tipo_login'));
                $cnpj = ($this->input->post('cnpj'));
                $cpf = ($this->input->post('cpf'));
                $email = ($this->input->post('email'));
                $senha = $this->util->SenhaEncode($this->input->post('senha')); 
                
                switch ($tipo_login) {
                    case 'email': $verifica = $this->login_model->verifica_email($email,$senha); break;
                    case 'cnpj': $verifica = $this->login_model->verifica_cnpj($cnpj,$senha); break;
                    case 'cpf': $verifica = $this->login_model->verifica_cpf($cpf,$senha); break;
                }
                if( $verifica->num_rows()>0) {

                    $empresa_info = array(
                        'logado' => true,
                        'cnpj'   => $verifica->row()->cnpj,
                        'cpf'   => $verifica->row()->cpf,
                        'nome_responsavel'   => $verifica->row()->nome_responsavel,
                        'funcao'   => $verifica->row()->id_funcao,
                        'email'   => $verifica->row()->email,
                        'id'     => $verifica->row()->id
                    );
                    $this->session->set_userdata('empresa',$empresa_info);

                    $redirect = redirect(base_url('painelempresa'));
                }
                else{
                    $this->session->set_flashdata("erro","Não foi possível fazer login com os dados informados.");
                    $this->load->view('login');
                }    
                
            }else
		$this->load->view('login');
	}

}
