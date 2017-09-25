<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_atuacao_model extends CI_Model {
    
    public function lista_area_atuacao(){
        $this->db->order_by('area_atuacao','asc');
        return $this->db->get('areas_atuacao')->result();
        
    }
    
}