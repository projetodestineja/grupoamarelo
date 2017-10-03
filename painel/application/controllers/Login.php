<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
	parent::__construct();
    }

    public function index(){
        if($this->session->has_userdata('user')){
           redirect(site_url('painel')); 
        }else{
            $dados['titulo'] = "Login";
            $this->session->unset_userdata('user');
            $this->load->view('login/index', $dados);
        }
    }
    
    public function validar_login_post(){
   
        $login = $this->input->post('login');
	$senha = $this->input->post('senha');		
		
	if( $login && $senha ) {
            
            $this->load->model('login_model'); // carregamos o model
            $this->load->library('util'); // carregamos o model
            
            $senha = $this->util->SenhaEncode($senha); // Codifica a senha informada, para validar a codificação no banco
             
            $verifica = $this->login_model->verifica($login,$senha);
            if( $verifica->num_rows()==1) {
               
                $user_info = array(
                    'logado' => true,
                    'nome'   => $verifica->row()->nome,
                    'id'     => $verifica->row()->id
                );
                $this->session->set_userdata('user',$user_info);
                
                $redirect = site_url("painel");
                
                $erro ="";
                
            }else{
                $erro = "Erro ao indenticar usuário!";
                $redirect = false;
	    }
        }else{
            $erro = "Preencha o login e senha corretamente";
	}
	echo json_encode(array("redirect"=>$redirect,"erro"=>$erro));  
    }
    
    public function sair() {
	
        $this->session->unset_userdata('user');
	
	redirect(site_url('login'));
    }

}
