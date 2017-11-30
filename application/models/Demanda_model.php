<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demanda_model extends CI_Model {

    var $table = "demandas";

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
    
    /*
    * Listamos demandas Geradora do Mesmo Estado
    */
    public function lista_demandasbyuf($uf, $sort = 'status', $order = 'asc', $limit = null, $offset = null) {
         $sql =  "
            select * 
                from demandas d
                    join demandas_status ds on d.status = ds.id
                    left join cidades c on c.id = d.col_id_cidade
                where ger_uf_estado = '".$uf."'
                    and removido is null   
                    and ds.descricao not like 'Aguardando %'
                    and ds.descricao not like 'Finalizado'
             order by ".$sort." ".$order." limit ".$limit." , ".$offset." 
            ";
        //echo $sql;
        return $this->db->query($sql)->result();
    }
    

    /*
    * Listamos demandas demandas da empresa
    */
    public function get_result_demandas_empresa_id($ger_id_empresa, $where, $num_rows=false, $sort = 'd.cadastrada', $order = 'asc', $limit = null, $offset = null) {
       
        if($num_rows==true){
            $filtro = "";
        }else{
            $filtro = "order by ".$sort." ".$order." limit ".$limit." offset ".$offset."";
        } 
        
        $sql =  "
            select 
                d.id, d.residuo, d.img, d.qtd, d.data_inicio, d.data_validade, d.obs, d.ger_id_empresa, d.ger_uf_estado, d.acondicionado_outro, d.uni_medida_outro,
                ds.descricao as status, ds.cor,
                c.nome_cidade,
				(select abreviacao from uni_medida  where id = d.uni_medida) as medida ,
				(select abreviacao  from acondicionado where id = d.acondicionado) as acondicionado
 
            from demandas as d
            inner join demandas_status as ds on (d.status = ds.id)
            inner join cidades as c  ON  (c.id = d.ger_id_cidade)  
			
            	and
				
                ".$where."
            
                removido is null 
            ".$filtro."
        ";
        return $this->db->query($sql);
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
						 ds.descricao as status_nome,					 
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
		
		$this->load->model('endereco_model');
		if($row->ger_id_cidade!=NULL){
			$ger_nome_cidade = $this->endereco_model->get_row_cidade($row->ger_id_cidade)->nome_cidade;
		}else{
			$ger_nome_cidade = '';
		}
		if($row->col_id_cidade!=NULL){
			$col_nome_cidade = $this->endereco_model->get_row_cidade($row->col_id_cidade)->nome_cidade;
		}else{
			$col_nome_cidade = '';
		}
		//print_r($row);

		$capa = 'uploads/empresa/'.$row->ger_id_empresa.'/demanda/mini/'.$row->img;

		$img = (is_file( $capa)?base_url($capa):base_url('painel/assets/img/demanda_sem_img.jpg')); 
		
		// Empresa Coletora com FUNCAO = 2 (não pode visualizar tudo)
		if($this->session->userdata['empresa']['funcao']==2){ 
			$info_completa = false;	
		}else{
			$info_completa = true;	
		}
		
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
			
			'info_completa' => $info_completa,

			'status' => $row->status,
			'status_nome' => $row->status_nome,
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
	
	function get_result_categorias_residuos(){
		return $this->db->get('categorias_residuos')->result();
	}
    
	function get_all_medidas(){
		$this->db->order_by('nome','asc');
	    return $this->db->get('uni_medida')->result();
    }
	
	function get_all_acondicionamentos(){
		$this->db->order_by('nome','asc');
        return $this->db->get('acondicionado')->result();
    }
	
    function insert($data,$img){
       if($img!=NULL){
           $this->db->set('img',$img);
       } 
       $this->db->insert('demandas',$data);
	   
	   $id_demanda = $this->db->insert_id();
	   
	   // Adiciona 1º status no hitórico
	   $this->db->set('status',1);
	   $this->db->set('id_demanda',(int)$id_demanda);
	   $this->db->insert('demandas_status_historico');

	   // Adiciona 2º status no hitórico
	   $this->db->set('status',2);
	   $this->db->set('id_demanda',(int)$id_demanda);
	   $this->db->insert('demandas_status_historico');
		
       return $id_demanda;
    }

    function update($data,$img,$id,$id_empresa){
        $this->db->where('ger_id_empresa',(int)$id_empresa);
        $this->db->where('id',(int)$id);
        if($img!=NULL){
            $this->db->set('img',$img);
        } 
		$this->db->set('atualizada',date('Y-m-d H:i:s'));
        $this->db->update('demandas',$data);
     }

    function get_row_demanda($id){
        $this->db->where('id',$id);
        return $this->db->get('demandas')->row();
    }
    
    function get_categorias_residuos(){
        return $this->db->get('categorias_residuos')->result();
    }

    function get_demandas_status(){
        $this->db->where('ativo','1');
        return $this->db->get('demandas_status')->result();
    }
	
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

    public function delete($id, $id_empresa){
             
        //$this->delete_img($id); * Não deletar imagem, essa demanda pode ser consultada depois

        $this->db->where('ger_id_empresa',(int)$id_empresa);
        $this->db->where('id',(int)$id);
        $this->db->set('removido',date('Y-m-d H:i:s'));
        $this->db->update('demandas');
    }
      
    public function delete_img($id_demanda){

        $demanda =  $this->get_row_demanda($id_demanda);
        
        $dir_base = "./uploads/empresa/".$demanda->ger_id_empresa."/demanda/";
        
        if(is_file($dir_base.$demanda->img)){
            unlink($dir_base.$demanda->img);
        }
        if(is_file($dir_base."mini/".$demanda->img)){
            unlink($dir_base."mini/".$demanda->img);
        }
        if(is_file($dir_base."media/".$demanda->img)){
            unlink($dir_base."media/".$demanda->img);
        }
    }

    function valid_upload_img($config_upload,$id_demanda=false){
		
		$erro = false;
		$img = NULL;
			
		if(!is_dir($config_upload['upload_path'])){
			mkdir($config_upload['upload_path']);
		}

		$this->load->library('upload', $config_upload);
		
		$this->upload->initialize($config_upload);

		// Tratamos se existe erro para o upload
		if (!$this->upload->do_upload('img')) {
			
			$erro = $this->upload->display_errors('', '');
        
        } else {

			$upload_data = $this->upload->data();
				
			// Validar Pasta MINI
			$dir_mini = $config_upload['upload_path'].'/mini';
			if(!is_dir($dir_mini)){
				mkdir($dir_mini);
			}
            
            //Validar Pasta MÉDIA
			$dir_media = $config_upload['upload_path'].'/media';
			if(!is_dir($dir_media)){
				mkdir($dir_media);
			}

			$this->load->library('image_lib'); 

            /******************************************************
                Config para redimensionar para o tamanho MINI
            *******************************************************/
			$config_mini = array(
                'source_image' => $upload_data['full_path'],
                'new_image' => $dir_mini,
                'maintain_ratio' => true,
                'master_dim' => 'width',
                'quality' => '82%',
			    'width' => 250,
                'height' => 160
            );
            $this->image_lib->initialize($config_mini);
                        
            if(!$this->image_lib->resize()){
                $erro = 'Redimensionar imagem pequena: '.$this->image_lib->display_errors('','');
            } 
            $this->image_lib->clear();
            

			/******************************************************
                Config para redimensionar para o tamanho MÉDIA
            *******************************************************/
			$config_media = array(
				'source_image' => $upload_data['full_path'],
				'new_image' => $dir_media,
                'maintain_ratio' => TRUE,
                'quality' => '85%',
				'width' => 1000,
				'height' => 1000
            );
            $this->image_lib->initialize($config_media);
			if(!$this->image_lib->resize()){
                $erro = 'Redimensionar imagem média: '.$this->image_lib->display_errors('','');
            } 
            $this->image_lib->clear();
			
			// Recuperamos o nome da imagem no upload
			$img = $upload_data['file_name']; 
		}
	    
		return array('img' => $img ,'erro' => $erro);
	}
        
	function countdemandas($id_empresa){
		$this->db->where('ger_id_empresa',$id_empresa);
		return $this->db->count_all_results('demandas');
	}
	
	function countdemandasbyuf($uf){
		$this->db->where('ger_uf_estado',$uf);
		$this->db->where_in('status', array(3,6));
		return $this->db->count_all_results('demandas');
	}

	function set_status($data){
		$this->db->where('id',$data->id_demanda);
		$this->db->set('atualizada',date('Y-m-d H:i:s'));
		$this->db->set('status',5);
		$this->db->update('demandas');
		$this->set_historico(5,$data->id_demanda);
	}

	function set_historico($status,$id_demanda){
		$this->db->set('status',$status);
		$this->db->set('id_demanda',$id_demanda);
		$this->db->set('datahora',date('Y-m-d H:i:s'));
		$this->db->insert('demandas_status_historico');
	}
	
	public  function get_result_status_historico($id_demanda=false){
		
		$sql = 'SELECT 
			dsh.datahora,ds.descricao FROM demandas_status_historico as dsh 
			INNER JOIN demandas_status as ds 
			INNER JOIN demandas as dem 
					ON 
				(dsh.status=ds.id) 
					and 
				(dsh.id_demanda=dem.id) 
					and
				dem.ger_id_empresa='.(int) $this->session->userdata['empresa']['id'].'	
					and
				dsh.id_demanda = '.(int)$id_demanda.' 
				 order by dsh.datahora desc';
		return $this->db->query($sql)->result();	
	}
        
}
