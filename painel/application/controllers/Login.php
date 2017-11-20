<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
		parent::__construct();
		// carregamos o model
        $this->load->model(array('login_model','config_model')); 
		
		// carregamos úteis
        $this->load->library('util'); 
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
         	
			
            
			// Codifica a senha informada, para validar a codificação no banco
            $senha = $this->util->SenhaEncode($senha); 
             
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
    
	
	public function recuperar_senha(){
		
		$email = $this->input->post('email');	
			
		if(!$this->input->post('email')){
			$resposta = 'Digite seu e-mail';	
		}else{
			
			$row = $this->login_model->recuperar_senha($email);
            if($row->num_rows()==1) {
				
				$usuarios = $row->row();
				$resposta = $this->enviar_email($usuarios);
				
			}else{
				$resposta = 'Erro interno';	
			}
		}
		echo json_encode(array("resposta"=>$resposta));  	
			
	}
	
	private function enviar_email($row){
		
		$this->load->library('email');
				
		$data = array();
			
		$config = $this->config_model->get('smtp');
			
		$config_email['protocol'] = 'smtp';
		$config_email['smtp_host'] = $config['smtp_servidor'];
		$config_email['smtp_user'] = $config['smtp_email'];
		$config_email['smtp_pass'] = $config['smtp_senha'];
		$config_email['smtp_port'] = $config['smtp_porta'];
		$config_email['bcc_batch_mode'] = true;
		$config_email['mailtype'] = 'html';
			
		$this->email->initialize($config_email);
		
		$email_remetente = $config['smtp_email'];
		$nome_remente = $this->config->item('title');
		
		$this->email->from($email_remetente,$nome_remente);
		$this->email->to($row->email,$row->nome);
		$this->email->reply_to($email_remetente,$nome_remente);
 		$this->email->subject('Recuperação de Senha - '.$this->config->item('title'));
		
		$nome = explode(" ",$row->nome);
		
		$data['nome'] = $nome[0];
		$data['email'] = $row->email;
		$data['senha'] = $this->util->SenhaDecode($row->senha);
		
		$this->email->message($this->load->view('login/email_recuperar_senha',$data,true));
		
		if($this->email->send()){
			return "A senha foi enviada para seu e-mail";
		}else{
			return "Erro ao enviar senha";
		}
	}
	
	
    public function sair() {
	
        $this->session->unset_userdata('user');
	
		redirect(site_url('login'));
    }

}
