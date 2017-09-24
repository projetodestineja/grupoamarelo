<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {

    public function gravar($dados){
      $this->db->insert('empresas',$dados);
    }

    public function desbloquear($acao,$id){
      $this->db->query("UPDATE empresas SET ativo = $acao WHERE empresas.id = $id");
    }

    public function atualizar($dados){
      $this->db->where('id =',$dados['id']);
      $this->db->update('empresas',$dados);
    }

    public function consultar($tipo){
      $this->db->where('id_funcao =',$tipo);
      $this->db->order_by("id", "desc");
      return $data['result'] = $this->db->get('empresas')->result();
    }

    public function consultar_coletoraId($id){
      $this->db->where('id =',$id);
      return $data = $this->db->get('empresas')->row();
    }

    /*public function consultar_geradoras(){
      $this->db->where('tipo =','g');
      return $data['result'] = $this->db->get('empresas')->result();
    }

    public function consultar_coletoras(){
      $this->db->where('tipo =','c');
      return $data['result'] = $this->db->get('empresas')->result();
    }*/

}
