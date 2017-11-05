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
       return $this->db->insert_id();
    }

    function update($data,$img,$id,$id_empresa){
        $this->db->where('ger_id_empresa',(int)$id_empresa);
        $this->db->where('id',(int)$id);
        if($img!=NULL){
            $this->db->set('img',$img);
        } 
        $this->db->update('demandas',$data);
     }

    function get_row_demanda($id){
        $this->db->where('id',$id);
        return $this->db->get('demandas')->row();
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
        
}
