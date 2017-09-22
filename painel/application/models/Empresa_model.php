<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {

    public function gravar($dados){
      $this->db->insert('empresas',$dados);
    }

    public function consultar_geradoras(){
      $this->db->where('tipo =','g');
      return $data['result'] = $this->db->get('empresas')->result();
    }

    public function consultar_coletoras(){
      $this->db->where('tipo =','c');
      return $data['result'] = $this->db->get('empresas')->result();
    }

}
