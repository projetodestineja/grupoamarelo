<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_Model extends CI_Model {
	
    public function verifica($login = '', $senha = ''){
	
        if(!$login && !$senha ) {
            return false;
        }else{
            $this->db->where(array('email'=>$login, 'senha'=>$senha, 'habilitado'=>1));
            return $this->db->get('usuarios'); 
        }
    }
	
	public function recuperar_senha($email){
		 $this->db->where('email',$email);
         return $this->db->get('usuarios'); 
    }
	
    public function restrito(){
        if(!$this->session->has_userdata('user')){
           redirect(site_url('login')); 
        }
    }
	
}

