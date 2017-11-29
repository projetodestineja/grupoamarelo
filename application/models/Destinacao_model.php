<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destinacao_model extends CI_Model {
    
    public function gravar($data){
        $this->db->insert('destinacao_final_residuo',$data);
    }
    
    public function getrow($id_demanda){
        $this->db->where('id_demanda',$id_demanda);
        return $this->db->get('destinacao_final_residuo')->row_array();
    }
    
    
}