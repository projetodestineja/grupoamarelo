<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_model extends CI_Model {
    
    public function lista_estados(){
       return $this->db->get('estados')->result();
        
    }
    
}