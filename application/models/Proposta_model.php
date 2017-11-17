<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposta_model extends CI_Model {

    public function get_proposta($id_demanda) {
        $this->db->where('id_demanda', $id_demanda);
        return $this->db->get('propostas')->result();
    }
    
    public function get_proposta_id($id_proposta) {
        $this->db->where('id', $id_proposta);
        return $this->db->get('propostas')->row();
    }

    public function aceitar_proposta($data) {
        $this->db->where('id', $data->id);
        return $this->db->update('propostas',$data);
    }

}