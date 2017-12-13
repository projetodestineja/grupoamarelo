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
        
        $sql =  "
                   select p.*,e.razao_social,e.telefone1,e.telefone2,e.nome_responsavel,e.email
                   from propostas p
                    join empresas e on e.id = p.id_empresa_coletora
                   where id_demanda = $id_demanda
                   order by aceita desc    
            ";
        //echo $sql;
        return $this->db->query($sql)->result();
        
        
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
