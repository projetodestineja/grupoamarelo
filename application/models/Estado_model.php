<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_model extends CI_Model {
    
    public function lista_estados(){
       return $this->db->get('estados')->result(); 
    }
    public function busca_nomeestadobyuf($uf){
       $this->db->where('uf',$uf);
       return $this->db->get('estados')->row()->nome_estado; 
    }
}