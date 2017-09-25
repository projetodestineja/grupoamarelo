<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {
    
    public function gravar($dados){
        $this->db->insert('empresas',$dados);
    }
    
    public function gravar_area_atuacao($dados2){
        $this->db->insert('empresas_areas_atuacao',$dados2);
    }
    
}