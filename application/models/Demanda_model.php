<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demanda_model extends CI_Model {

    public function lista_demandasbyid($id_geradora) {
      return $query = $this->db->query("select * 
                            from demandas d
                                    join demandas_status ds on d.status = ds.id
                                    left join cidades c on c.id = d.col_id_cidade
                            where ger_id_empresa = $id_geradora order by status" )->result();
    }

}