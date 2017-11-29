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
					d.id, d.residuo, d.img, d.qtd, d.data_inicio, d.data_validade, d.obs, d.ger_id_empresa, d.ger_uf_estado,d.uni_medida_outro,d.uni_medida, d.acondicionado_outro,
					ds.descricao as status, 
					ds.cor,
					c.nome_cidade,
					(select abreviacao from uni_medida  where id = d.uni_medida) as medida ,
					(select abreviacao from acondicionado where id = d.acondicionado) as acondicionado
				
				 from demandas as d
				 inner join demandas_status as ds on (d.status = ds.id)
				 inner join cidades as c  ON  
				
						 (c.id = d.ger_id_cidade)  
					 and 
						 ".$where."
						 removido is null 
				 ".$filtro."
		 ";
		 return $this->db->query($sql);
	}



	public function get_row_demanda_ver($id) {

		$data = array(); 

		$sql =  "
				 select 
						 d.id,
						 d.cadastrada,
						 d.atualizada,
						 d.residuo,
						 d.responsavel,
						 ds.descricao as status, 
						 ds.cor,
						 (select nome from uni_medida where id = d.uni_medida) as uni_medida_nome,
						 (select nome  from acondicionado where id = d.acondicionado) as acondicionado,
						 d.acondicionado_outro,
						 d.uni_medida,
						 d.uni_medida_outro,	
						 d.status,					 
						 d.img,
						 d.qtd,
						 d.data_inicio,
						 d.data_validade,
						 d.obs, 
						 
						 d.ger_id_empresa,
						 d.ger_telefone1,
						 d.ger_telefone2,
						 d.ger_email,
						 d.ger_cep,
						 d.ger_logradouro,
						 d.ger_numero,
						 d.ger_complemento,
						 d.ger_bairro,
						 d.ger_id_cidade,
						 d.ger_uf_estado,
						 
						 d.col_id_empresa,
						 d.col_telefone1,
						 d.col_telefone2,
						 d.col_email,
						 d.col_cep,
						 d.col_logradouro,
						 d.col_numero,
						 d.col_complemento,
						 d.col_bairro,
						 d.col_id_cidade,
						 d.col_uf_estado
						 
				 from demandas as d
				 inner join demandas_status as ds on (d.status = ds.id)
				 and 
					d.id= ".(int)$id."
				limit 1
		";
		
		$row = $this->db->query($sql)->row();
		
		$this->load->model('cidades_model');
		$ger_nome_cidade = $this->cidades_model->get_row_cidade($row->ger_id_cidade)->nome_cidade;
		if($row->col_id_cidade!=NULL){
			$col_nome_cidade = $this->cidades_model->get_row_cidade($row->col_id_cidade)->nome_cidade;
		}else{
			$col_nome_cidade = '';
		}
		//print_r($row);

		$capa = '../uploads/empresa/'.$row->ger_id_empresa.'/demanda/mini/'.$row->img;

		$img = (is_file( $capa)?base_url($capa):base_url('assets/img/demanda_sem_img.jpg')); 
		
		if(empty($row->acondicionado)){
			$acondicionado = $row->acondicionado_outro;
		}else{
			$acondicionado = $row->acondicionado;	
		}
		
		if(empty($row->uni_medida_nome)){
			$uni_medida_nome = $row->uni_medida_outro;	
		}else{
			$uni_medida_nome = $row->uni_medida_nome;
		}

		$data = array(
			/* Dados Demanda ********************/
			'id' => $id,
			
			'cadastrada' => date('d/m/Y H:i', strtotime($row->cadastrada)),
			'atualizada' => date('d/m/Y H:i', strtotime($row->atualizada)),
			
			'data_inicio' => date('d/m/Y', strtotime($row->data_inicio)),
			'data_validade' => date('d/m/Y', strtotime($row->data_validade)),
			
			'status' => $row->status,
			'cor' => $row->cor,
			'responsavel' =>  $row->responsavel,
			'residuo' =>  $row->residuo,
			'img' => $img,
			'acondicionado' =>  $acondicionado,
			'qtd' =>  $row->qtd,
			'uni_medida' =>  $row->uni_medida,
			'uni_medida_nome' =>  $uni_medida_nome,
			'obs' => $row->obs,
			
			/* Dados Empresa Geradora ********************/
			'ger_id_empresa' => $row->ger_id_empresa,
			'ger_telefone1' => $row->ger_telefone1,
			'ger_telefone2' => $row->ger_telefone2,
			'ger_email' => $row->ger_email,
			
			'ger_cep' => $row->ger_cep,
			'ger_logradouro' => $row->ger_logradouro,
			'ger_numero' => $row->ger_numero,
			'ger_complemento' => $row->ger_complemento,
			'ger_bairro' => $row->ger_bairro,
			'ger_id_cidade' => $row->ger_id_cidade,
			'ger_nome_cidade' => $ger_nome_cidade,
			'ger_uf_estado' => $row->ger_uf_estado,
			
			/* Dados Empresa Coletora ********************/
			'col_id_empresa' => $row->col_id_empresa,
			'col_telefone1' => $row->col_telefone1,
			'col_telefone2' => $row->col_telefone2,
			'col_email' => $row->col_email,
			
			'col_cep' => $row->col_cep,
			'col_logradouro' => $row->col_logradouro,
			'col_numero' => $row->col_numero,
			'col_complemento' => $row->col_complemento,
			'col_bairro' => $row->col_bairro,
			'col_id_cidade' => $row->col_id_cidade,
			'col_nome_cidade' => $col_nome_cidade,
			'col_uf_estado' => $row->col_uf_estado
		);

		return $data;
	}
	
	function get_row_demanda($id_demanda){
		$this->db->where('id',$id_demanda);
		return $this->db->get('demandas')->row();
	}

	public function updade_status($status, $id_demanda){
		$this->db->set('status',(int)$status);
		$this->db->set('atualizada',date('Y-m-d H:i:s'));
		$this->db->where('id',(int)$id_demanda);
		$this->db->update('demandas');
		
		$this->db->set('status',(int)$status);
		$this->db->set('id_demanda',(int)$id_demanda);
		$this->db->insert('demandas_status_historico');
	}
	
	public  function get_result_status_historico($id_demanda=false){
		$where = '';
		if($id_demanda){
			$where.= ' and dsh.id_demanda = '.(int)$id_demanda.' ';	
		}
		$sql = 'SELECT dsh.datahora,ds.descricao FROM demandas_status_historico as dsh INNER JOIN demandas_status as ds ON (dsh.status=ds.id) '.$where.' order by dsh.datahora desc';
		return $this->db->query($sql)->result();	
	}

	function get_categorias_residuos(){
        return $this->db->get('categorias_residuos')->result();
    }

	public function get_result_status(){
		$this->db->order_by('descricao','asc');
	  	return $this->db->get('demandas_status')->result();
  	}

	public function get_count(){
		return $this->db->count_all($this->table);
	}

	public function count_all($status){
		if($status!=0)
            $this->db->where('status',(int)$status);	
            
        $this->db->where('removido',NULL);
        $this->db->from('demandas');
        return $this->db->count_all_results();
    }


    public function conta_por_mes($ano,$mes){
        if (($ano>0) && ($mes>0)){
        return 
        $this->db->query("SELECT COUNT(id) as qtde
                                FROM demandas  
                                WHERE 
                                    removido is null
                                    and YEAR(cadastrada) = $ano  
                                    and MONTH(cadastrada) = $mes")->row();
        } else return 0;
	}
    
}
