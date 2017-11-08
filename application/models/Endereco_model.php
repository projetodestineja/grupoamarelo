<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Endereco_model extends CI_Model {
    
    public function get_all_estados(){
       return $this->db->get('estados')->result();
        
    }
    
	public function get_all_cidades($uf='ES') {
       $this->db->where('uf',$uf);
       return $this->db->get('cidades')->result();
    }
	
	public function get_row_cidade($id) {
       $this->db->where('id',$id);
       return $this->db->get('cidades')->row();
    }
	
}