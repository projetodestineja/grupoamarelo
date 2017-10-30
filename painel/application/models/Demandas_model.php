<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demandas_model extends CI_Model {
	
	var $table = "demandas";
	
    function get_result($sort = 'id', $order = 'asc', $limit = null, $offset = null) {
		$this->db->order_by($sort, $order);
		if($limit)
		  $this->db->limit($limit,$offset);
		  $query = $this->db->get('demandas');
		  if ($query->num_rows() > 0) {
		  	return $query->result();
		  } else {
		    return null;
		  }
	}

  	public function get_count(){
	     return $this->db->count_all($this->table);
  	}

    
}
