<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposta_model extends CI_Model {
    
    public function salvar($dados){
        $this->db->insert('propostas',$dados);
    }
    
    public function getrow($id_demanda){
       $this->db->where('id_demanda',$id_demanda);
       return $this->db->get('propostas')->row(); 
    }
    
    public function delete($id_demanda,$id_coletora){
       $this->db->where('id_demanda',$id_demanda);
       $this->db->where('id_empresa_coletora',$id_coletora);
       $this->db->delete('propostas');
    }

}