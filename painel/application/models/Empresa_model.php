<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {
	
	public function get_result_all($funcoes_empresa){
	  if($funcoes_empresa){
		$this->db->where('id_funcao',(int)$funcoes_empresa);  
	  }	
      return $this->db->get('empresas')->result();
    }
	
	public function get_funcao_row($id){
	  $this->db->where('id',(int)$id);  
	  return $this->db->get('funcoes_empresas')->row();
    }
	
    public function gravar($dados){
      $this->db->insert('empresas',$dados);
    }

    public function desbloquear($acao,$id){
      $this->db->query("UPDATE empresas SET ativo = $acao WHERE empresas.id = ".(int)$id."");
    }

	
    public function atualizar($dados){
      $this->db->where('id',$dados['id']);
      $this->db->update('empresas',$dados);
    }

    public function consultar($tipo){
      $this->db->where('id_funcao',$tipo);
      $this->db->order_by("id", "desc");
      return $data['result'] = $this->db->get('empresas')->result();
    }

    public function consultar_coletoraId($id){
      $this->db->where('id',(int)$id);
      return $this->db->get('empresas')->row();
    }

    public function consultar_area_Id($id){
      $this->db->where('id_empresa',$id);
      $this->db->where('principal',1);
      return $this->db->get('empresas_areas_atuacao')->row();
    }

    public function consultar_area_secundaria_Id($id){
      return $data['result3'] = $this->db->query("SELECT * FROM areas_atuacao JOIN (empresas_areas_atuacao) ON (empresas_areas_atuacao.id_empresa = ".(int)$id." AND areas_atuacao.codigo = empresas_areas_atuacao.codigo_area_atuacao AND empresas_areas_atuacao.principal=2) ")->result();
    }

    public function get_all_area_atuacao(){
        $this->db->order_by('area_atuacao','asc');
		//$this->db->limit(50);
        return $this->db->get('areas_atuacao')->result();
    }
	
	

}
