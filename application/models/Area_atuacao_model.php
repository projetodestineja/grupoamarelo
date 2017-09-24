<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_atuacao_model extends CI_Model {
    
    public function lista_area_atuacao($funcao){
        $this->db->where('visivel_para_funcao',$funcao);
        $this->db->order_by('area_atuacao','asc');
        return $this->db->get('areas_atuacao')->result();
        
    }
    
}