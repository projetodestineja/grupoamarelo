<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demandas_model extends CI_Model {
	
	var $table = "demandas";
	
  public function get_result_demandas($where, $num_rows=false, $sort = 'd.cadastrada', $order = 'asc', $limit = null, $offset = null) {
		
		 if($num_rows==true){
				 $filtro = "";
		 }else{
				 $filtro = "order by ".$sort." ".$order." limit ".$limit." offset ".$offset."";
		 } 
		 
		 $sql =  "
				 select 
						 d.id, d.residuo, d.img, d.qtd, d.data_inicio, d.data_validade, d.obs, d.ger_id_empresa, d.ger_uf_estado,
						 ds.descricao as status, ds.cor,
						 c.nome_cidade,
						 um.nome as medida,
						 ac.nome as acondicionado
				 from demandas as d
				 inner join demandas_status as ds on (d.status = ds.id)
				 inner join cidades as c 
				 inner join uni_medida as um 
				 inner join acondicionado as ac ON  
						 (c.id = d.ger_id_cidade)  
				 and
						 (ac.id = d.acondicionado)
				 and 
						 (um.id = d.uni_medida)
				 and 
						 ".$where."
						 removido is null 
				 ".$filtro."
		 ";
		 return $this->db->query($sql);
	}


	public function get_row_demanda($id) {

		$data = array(); 

		$sql =  "
				 select 
						 d.id, d.residuo, d.img, d.qtd, d.data_inicio, d.data_validade, d.obs, d.ger_id_empresa, d.ger_uf_estado,
						 ds.descricao as status, ds.cor,
						 c.nome_cidade,
						 um.nome as medida,
						 ac.nome as acondicionado
				 from demandas as d
				 inner join demandas_status as ds on (d.status = ds.id)
				 inner join cidades as c 
				 inner join uni_medida as um 
				 inner join acondicionado as ac ON  
						 (c.id = d.ger_id_cidade)  
				 and
						 (ac.id = d.acondicionado)
				 and 
						 (um.id = d.uni_medida)
				 and 
						d.id= ".(int)$id."
				limit 1
		";
		
		$row = $this->db->query($sql)->row();

		//print_r($row);

		$capa = '../uploads/empresa/'.$row->ger_id_empresa.'/demanda/mini/'.$row->img;

		$img = (is_file( $capa)?base_url($capa):base_url('assets/img/demanda_sem_img.jpg')); 

		$data = array(
			//'id' => $row->id,
			'residuo' => $row->residuo,
			'img' => $img,
			'qtd' => $row->qtd,
			'acondicionado' => $row->acondicionado,
			'data_inicio' => $row->data_inicio,
			'data_validade' => $row->data_validade,
			'obs' => $row->obs,
			// Geradora
			'ger_id_empresa' => $row->ger_id_empresa,
			'ger_uf_estado' => $row->ger_uf_estado,
			// Demanda
			'status' => $row->status,
			'cor' => $row->cor,
			'nome_cidade' => $row->nome_cidade,
			'medida' => $row->medida
		);

		return $data;

	}

	public function get_result_status(){
		$this->db->order_by('descricao','asc');
	  return $this->db->get('demandas_status')->result();
  }

  public function get_count(){
	  return $this->db->count_all($this->table);
  }

    
}
