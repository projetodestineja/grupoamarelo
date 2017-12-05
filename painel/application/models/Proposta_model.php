<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposta_model extends CI_Model {

    public function conta_por_mes($ano,$mes){
        if (($ano>0) && ($mes>0)){
        return 
        $this->db->query("SELECT COUNT(id) as qtde
                                FROM propostas  
                                WHERE 
                                    YEAR(cadastrada) = $ano  
                                    and MONTH(cadastrada) = $mes")->row();
        } else return 0;
    }
    
    public function get_propostas($id_demanda){
        $this->db->where('id_demanda', $id_demanda);
        return $this->db->get('propostas')->result();
	}
    
    function countpropostas(){
        
        $sql =  "
                   select distinct p.id
                   from demandas d
                        join propostas p on p.id_demanda = d.id
                    where 	
                        p.removido is null
            ";
        //echo $sql;
        return $this->db->query($sql)->num_rows();
    }
}
