<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposta_model extends CI_Model {

    public function get_proposta($id_demanda) {
        $this->db->where('id_demanda', $id_demanda);
        return $this->db->get('propostas')->result();
   }

}