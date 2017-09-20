<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {
    
    public function gravar($dados){
        $this->db->insert('empresas',$dados);
    }
    
}