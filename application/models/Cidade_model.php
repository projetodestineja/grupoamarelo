<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cidade_model extends CI_Model {

    public function getcidades($uf) {
       $this->db->where('uf',$uf);
       return $this->db->get('cidades')->result();
    }
    
    public function getcidadebyid($id_cidade) {
       $this->db->where('id',$id_cidade);
       return $this->db->get('cidades')->row();
    }
    
    public function getnomecidadebyid($id_cidade) {
       $this->db->where('id',$id_cidade);
       return $this->db->get('cidades')->row()->nome_cidade;
    }

}
