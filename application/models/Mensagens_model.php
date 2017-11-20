<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensagens_model extends CI_Model {
	
	 private function _get_datatables_query(){
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item){ // loop column 
            if($_POST['search']['value']){  // if datatable send POST for search
                if($i===0){ // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if(isset($_POST['order'])){  // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else 
		if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
 
    function get_datatables(){
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('removida',NULL);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered(){
        $this->_get_datatables_query();
        $this->db->where('removida',NULL);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all(){
        $this->db->where('removida',NULL);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
	public function get_all(){
		$this->db->where('removida',NULL);
		return $this->db->get($this->table)->result();
	}
	

    /*
    *   Listar mensagens histórico demanda
    */
    function get_result_mensagens_demanda($id_demanda){

        $sql = 'select 
                m.id, 
                m.assunto,
                m.msg,
				m.alert_email,
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
            id_demanda='.$id_demanda.' 
			 	and     
             m.id_empresa='.(int)$this->session->userdata['empresa']['id'].' 
			order  by m.id desc';
       
        return $this->db->query($sql)->result();
    }

 
	/*
    *  Get row mensagem
    */
    function get_row_mensagem($id_mensagem){
        $this->db->where('id',(int)$id_mensagem);
		$this->db->where('id_empresa',(int)$this->session->userdata['empresa']['id']);
        return $this->db->get($this->table)->row();
    }
	
	/*
	*	Update Msg visulizada
	*/
	function get_update_visualizado($id_mensagem){
        $this->db->where('id',(int)$id_mensagem);
		$this->db->where('id_empresa',(int)$this->session->userdata['empresa']['id']);
		$this->db->set('destinatario_visualizou',date('Y-m-d H:i:s'));
        return $this->db->update($this->table);
    }
	
	
	/*
	* Mensagens top visulizada
	*/
	function get_novas_mensagens_result(){
		$this->db->where('destinatario_visualizou',NULL);
		$this->db->where('id_empresa',(int)$this->session->userdata['empresa']['id']);
		$this->db->where('removida',NULL);
        $this->db->order_by('id','desc');
		return $this->db->get('mensagens')->result();	
	}
}
