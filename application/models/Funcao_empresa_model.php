<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcao_empresa_model extends CI_Model {
    
    public function lista_funcao($tipo=NULL){
        $this->db->where('funcao',$tipo);
        return $this->db->get('funcoes_empresas')->result();
    }
    
}