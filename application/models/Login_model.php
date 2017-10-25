<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function verifica_email($email = '', $senha = '') {
        if (!$email && !$senha) {
            return false;
        } else {
            $this->db->where(array('email' => $email, 'senha' => $senha));
            return $this->db->get('empresas');
        }
    }

    public function verifica_cnpj($cnpj = '', $senha = '') {
        if (!$cnpj && !$senha) {
            return false;
        } else {
            $this->db->where(array('cnpj' => $cnpj, 'senha' => $senha));
            return $this->db->get('empresas');
        }
    }

    public function verifica_cpf($cpf = '', $senha = '') {
        if (!$cpf && !$senha) {
            return false;
        } else {
            $this->db->where(array('cpf' => $cpf, 'senha' => $senha));
            return $this->db->get('empresas');
        }
    }

    public function recuperar_senha($email){
        $this->db->where('email',$email);
        return $this->db->get('empresas'); 
    }

    public function restrito() {
        if (!$this->session->has_userdata('empresa')) {
            redirect(site_url('login'));
        }
    }

}
