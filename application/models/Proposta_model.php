<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposta_model extends CI_Model {

    public function get_proposta($id_demanda) {
        $this->db->where('id_demanda', $id_demanda);
        $this->db->where('removido', null,true);
        return $this->db->get('propostas')->result();
    }
    
    public function get_proposta_id($id_proposta) {
        $this->db->where('id', $id_proposta);
        return $this->db->get('propostas')->row();
    }

    public function consultar_proposta_aceita($id_demanda) {
        $this->db->where('id_demanda', $id_demanda);
        $this->db->where('aceita', 'Sim');
        return $this->db->get('propostas')->result();
    }

    public function aceitar_proposta($data) {
        $this->db->where('id', $data->id);
        return $this->db->update('propostas',$data);
    }
    
    public function salvar($dados){
        $this->db->insert('propostas',$dados);
    }
    
    public function getrow($id_demanda,$id_coletora){
       $this->db->where('id_demanda',$id_demanda);
       $this->db->where('id_empresa_coletora',$id_coletora);
       $this->db->where('removido', null, true);
       return $this->db->get('propostas')->row_array(); 
    }
    
    public function delete($id_proposta,$motivo_remocao){
       $this->db->set('removido', date('Y-m-d H:i:s') );
       $this->db->set('motivo_remocao', $motivo_remocao );
       $this->db->where('id',$id_proposta);
       return $this->db->update('propostas');
    }
    
    function countpropostas_id_geradora($id_geradora){
        
        $sql =  "
                   select distinct p.id
                   from demandas d
                        join propostas p on p.id_demanda = d.id
                    where d.ger_id_empresa = $id_geradora	
                          and p.removido is null
            ";
        //echo $sql;
        return $this->db->query($sql)->num_rows();
    }
    
    function countpropostasaceitas_id_geradora($id_geradora){
        
        $sql =  "
                   select distinct p.id
                   from demandas d
                        join propostas p on p.id_demanda = d.id
                    where d.ger_id_empresa = $id_geradora	
                          and p.removido is null
                          and p.aceita like 'Sim'
            ";
        //echo $sql;
        return $this->db->query($sql)->num_rows();
    }
    
        function countpropostas_id_coletora($id_coletora){
        
        $sql =  "
                   select distinct p.id
                   from demandas d
                        join propostas p on p.id_demanda = d.id
                    where p.id_empresa_coletora = $id_coletora	
                          and p.removido is null
            ";
        //echo $sql;
        return $this->db->query($sql)->num_rows();
    }
    
    function countpropostasaceitas_id_coletora($id_coletora){
        
        $sql =  "
                   select distinct p.id
                   from demandas d
                        join propostas p on p.id_demanda = d.id
                    where p.id_empresa_coletora = $id_coletora	
                          and p.removido is null
                          and p.aceita like 'Sim'
            ";
        //echo $sql;
        return $this->db->query($sql)->num_rows();
    }

}