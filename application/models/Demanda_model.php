<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demanda_model extends CI_Model {

    public function lista_demandasbyid($id_geradora) {
      return $query = $this->db->query("select * 
                            from demandas d
                                    join demandas_status ds on d.status = ds.id
                                    left join cidades c on c.id = d.col_id_cidade
                            where ger_id_empresa = $id_geradora 
                            and removido is null    
                            and ds.descricao not like 'Finalizado'
               order by status" )->result();
    }
    
    public function lista_demandasbyuf($uf) {
      return $query = $this->db->query("select * 
                            from demandas d
                                    join demandas_status ds on d.status = ds.id
                                    left join cidades c on c.id = d.col_id_cidade
                            where ger_uf_estado like '$uf'
                            and removido is null   
                            and ds.descricao not like 'Aguardando %'
                            and ds.descricao not like 'Finalizado'
               order by status" )->result();
    }
    
    public function lista_demandasbycidade($id_cidade) {
      return $query = $this->db->query("select * 
                            from demandas d
                                    join demandas_status ds on d.status = ds.id
                                    left join cidades c on c.id = d.col_id_cidade
                            where ger_id_cidade like '$id_cidade'
                            and removido is null   
                            and ds.descricao not like 'Aguardando %'
                            and ds.descricao not like 'Finalizado'
               order by status" )->result();
    }
    
    function add($data){
        $this->db->insert('demandas',$data);
    }

}
