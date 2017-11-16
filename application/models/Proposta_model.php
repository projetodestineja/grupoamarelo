<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposta_model extends CI_Model {
    
    public function salvar($dados){
        $this->db->insert('propostas',$dados);
    }

}