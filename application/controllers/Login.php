<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->load->model(array('login_model','empresa_model','config_model'));
                $this->load->library('util');
                $this->load->helper('cookie');
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
                
                $num_registros = $verifica->num_rows();
                
                if( $num_registros==1) {
                      
                   $row_funcao = $this->empresa_model->get_funcao_row($verifica->row()->id_funcao);
                      
                    $empresa_info = array(
                        'logado' => true,
                        'cnpj'   => $verifica->row()->cnpj,
                        'cpf'   => $verifica->row()->cpf,
                        'funcao_titulo' => $row_funcao->funcao,
                        'nome_responsavel'   => $verifica->row()->nome_responsavel,
                        'funcao'   => $verifica->row()->id_funcao,
                        'email'   => $verifica->row()->email,
                        'id'     => $verifica->row()->id,
                        'razao_social' => $verifica->row()->razao_social,
                        'uf'=> $verifica->row()->uf_estado,
                        'id_cidade'=> $verifica->row()->id_cidade  
                    );
                    $this->session->set_userdata('empresa',$empresa_info);

                    if ($this->input->post('lembrar')){
                        
                        unset($_COOKIE["tipo_login"]);
                        unset($_COOKIE["email"]);
                        unset($_COOKIE["cnpj"]);
                        unset($_COOKIE["cpf"]);
                        unset($_COOKIE["senha"]);
                        
                        //Grava dados no cookie para lembrar login e senha
                        setcookie("tipo_login",$tipo_login);
                        switch ($tipo_login) {
                            case 'email': setcookie("email",$this->input->post('email')); break;
                            case 'cnpj':  setcookie("cnpj",$this->input->post('cnpj')) ; break;
                            case 'cpf':   setcookie("cpf",$this->input->post('cpf')); break;
                        }
                        setcookie("senha",$this->input->post('senha'));
                    }
                    
                    $redirect = redirect(base_url('painelempresa'));
                }
                else 
                    if ($num_registros==0) {
                        $this->session->set_flashdata("erro","Login e senha incorretos.");
                        $this->load->view('login');
                    }
                    else 
                        if ($num_registros>1){
                            $this->session->set_flashdata("erro","Login existente em mais de um cadastro. Faça o login por CNPJ ou CPF.");
                            $this->load->view('login'); 
                        }
                
            }else{
                $this->session->unset_userdata('empresa');
		$this->load->view('login');
            }    
	}
   
    
    public function recuperar_senha(){
		
		$email = $this->input->post('email_rec_senha');	
			
		if(!$this->input->post('email_rec_senha')){
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
		$this->email->to('onerio@tribo.ppg.br',$row->nome_responsavel);
		$this->email->reply_to($email_remetente,$nome_remente);
 		$this->email->subject('Recuperação de Senha - '.$this->config->item('title'));
		
		$nome = explode(" ",$row->nome_responsavel);
		
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
	
        $this->session->unset_userdata('empresa');
	
	    redirect(site_url('login'));
    }    

}
