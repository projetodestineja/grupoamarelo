<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensagens_model extends CI_Model {
	
	var $table = "mensagens";
    

    /*
    *   Insert mesagem
    */
    function insert_mensagem($data){
        $this->db->insert('mensagens',$data);
    }

    /*
    *   Listar mensagens histórico demanda
    */
    function get_result_mensagens_demanda($id_demanda){

        $sql = 'select 

                m.id, 
                m.assunto,
                m.msg,
                m.id_empresa,
                m.id_demanda,
                m.cadastrada,
                e.razao_social,
                e.nome_responsavel

            from 
                mensagens as m 
            join 
                empresas as e 
                ON
            m.id_empresa=e.id 
                and 
            m.removida is NULL 
                and     
            id_demanda='.$id_demanda.' order  by m.id desc';
       
        return $this->db->query($sql)->result();
    }

    /*
    *  Remover Mensagem
    */
    function remover($id_delete){
        $this->db->where('id',$id_delete);
        $this->db->set('removida',date('Y-m-d H:i:s'));
        $this->db->update($this->table);
    }
    
}
