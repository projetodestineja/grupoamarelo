<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {
	
	private function _get_datatables_query($id_funcao,$get=''){
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
		if($id_funcao!=0){
			$this->db->where('id_funcao',(int)$id_funcao);	
		}
		if(isset($get['ativo'])){
			$this->db->where('ativo',(int)$get['ativo']);	
		}
        if(isset($_POST['order'])){  // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
 
    function get_datatables($id_funcao,$get=''){
        $this->_get_datatables_query($id_funcao,$get);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
		if($id_funcao!=0){
			$this->db->where('id_funcao',(int)$id_funcao);	
		}
		if(isset($get['ativo'])){
			$this->db->where('ativo',(int)$get['ativo']);	
		}
        $this->db->where('removido',NULL);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($id_funcao,$get=''){
        $this->_get_datatables_query($id_funcao,$get);
		if($id_funcao!=0){
			$this->db->where('id_funcao',(int)$id_funcao);	
		}
		if(isset($get['ativo'])){
			$this->db->where('ativo',(int)$get['ativo']);	
		}
        $this->db->where('removido',NULL);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($id_funcao,$get=''){
		if($id_funcao!=0){
			$this->db->where('id_funcao',(int)$id_funcao);	
		}
		if(isset($get['ativo'])){
			$this->db->where('ativo',(int)$get['ativo']);	
		}
        $this->db->where('removido',NULL);
        $this->db->from('empresas');
        return $this->db->count_all_results();
    }
	
	
    public function get_result_all($funcoes_empresa) {
        if ($funcoes_empresa) {
            $this->db->where('id_funcao', (int) $funcoes_empresa);
        }
        return $this->db->get('empresas')->result();
    }

    public function get_funcao_row($id) {
        $this->db->where('id', $id);
        return $this->db->get('funcoes_empresas')->row();
    }

    public function gravar($dados) {
        $this->db->insert('empresas', $dados);
    }

    public function desbloquear($acao, $id) {
        $this->db->query("UPDATE empresas SET ativo = $acao WHERE empresas.id = " . (int) $id . "");
    }

    public function atualizar($dados) {
        $this->db->where('id', $dados['id']);
        $this->db->update('empresas', $dados);
    }

    public function consultar($tipo) {
        $this->db->where('id_funcao', $tipo);
        $this->db->order_by("id", "desc");
        return $data['result'] = $this->db->get('empresas')->result();
    }

    public function consultar_coletoraId($id) {
        $this->db->where('id', (int) $id);
        return $this->db->get('empresas')->row();
    }

    public function consultar_area_Id($id) {
        $this->db->where('id_empresa', $id);
        $this->db->where('principal', 1);
        return $this->db->get('empresas_areas_atuacao')->row();
    }

    public function consultar_area_secundaria_Id($id) {
        return $data['result3'] = $this->db->query("SELECT * FROM areas_atuacao JOIN (empresas_areas_atuacao) ON (empresas_areas_atuacao.id_empresa = " . (int) $id . " AND areas_atuacao.codigo = empresas_areas_atuacao.codigo_area_atuacao AND empresas_areas_atuacao.principal=2) ")->result();
    }

    public function get_all_area_atuacao() {
        $this->db->order_by('area_atuacao', 'asc');
        //$this->db->limit(50);
        return $this->db->get('areas_atuacao')->result();
    }

    public function empresa_insert($data, $post) {
        if ($post['senha']) {
            $this->db->set('senha', $this->util->SenhaEncode($post['senha']));
        }
        $this->db->insert('empresas', $data);
        return $this->db->insert_id();
    }

    public function empresa_update($id, $data, $post) {
        if ($post['senha']) {
            $this->db->set('senha', $this->util->SenhaEncode($post['senha']));
        }
        $this->db->where('id', (int) $id);
        $this->db->update('empresas', $data);
    }

    public function atuacao($id_empresa) {
        // Limpamos tudo
        $this->db->where('id_empresa', (int) $id_empresa);
        $this->db->delete('empresas_areas_atuacao');

        //Montamos a primeira array com a atividade principal
		
		$digite_area = ($this->input->post('area_atuacao')==0?$this->input->post('digite_area'):NULL);
		
        $data[] = array(
            'principal' => 1,
            'id_empresa' => (int) $id_empresa,
            'codigo_area_atuacao' => $this->input->post('area_atuacao'),
            'outra_area_atuacao' => $digite_area
        );

        //Montamos as demais arrays com as secundarias
        foreach ($this->input->post('area_atuacao_secundaria') as $codigo) {
            $data[] = array(
                'principal' => 2,
                'id_empresa' => (int) $id_empresa,
                'codigo_area_atuacao' => $codigo,
                'outra_area_atuacao' => NULL
            );
        }

        //Fazemos o insert pegando a array montada acima
        $this->db->insert_batch('empresas_areas_atuacao', $data);
    }

    public function empresa_licenca_row($id_licenca) {
        $this->db->where('id', $id_licenca);
        return $this->db->get('empresas_certificados')->row();
    }

    public function upload_licenca_update($data, $id_empresa, $nome_arquivo, $id_licenca) {
        $this->db->where('id_empresa', $id_empresa);
        $this->db->where('id', $id_licenca);
        if ($nome_arquivo != NULL) {
            $this->db->set('certificado', $nome_arquivo);
        }
        return $this->db->update('empresas_certificados', $data);
    }

    public function upload_licenca_insert($data, $id_empresa, $nome_arquivo) {
        $this->db->set('id_empresa', $id_empresa);
        $this->db->set('certificado', $nome_arquivo);
        return $this->db->insert('empresas_certificados', $data);
    }

    public function empresa_licenca_result($id_empresa) {
        $sql = 'SELECT 
		c.id,
		c.titulo,
		c.cadastrado,
		c.validade,
		c.certificado,
		c.id_empresa,
		s.titulo as  status
			FROM 
		' . $this->db->dbprefix('empresas_certificados') . ' c 
			INNER JOIN 
		' . $this->db->dbprefix('empresas_certificados_status') . ' s  
		ON (c.status = s.id)
			and
		c.id_empresa = ' . $id_empresa . '
		';

        return $this->db->query($sql)->result();
    }

    public function empresa_licenca_status_result() {
        $this->db->order_by('id', 'asc');
        return $this->db->get('empresas_certificados_status')->result();
    }
	
	public function funcoes_empresas_row($funcao) {
        $this->db->where('funcao',$funcao);
        return $this->db->get('funcoes_empresas')->row();
    }
	
	public function valid_doc_empresas($cpf_cnpj) {
        $this->db->where('removido is NULL');
		$this->db->where('cpf',$cpf_cnpj);
		$this->db->or_where('cnpj',$cpf_cnpj);
		 $this->db->where('removido is NULL');
        return $this->db->get('empresas')->num_rows();
    }
	
	public function deletar($id){
		$this->db->where('id',$id);
        $this->db->set('removido',date('Y-m-d H:i:s'));
		$this->db->update('empresas'); 
    }

    public function get_all_categorias_residuos($id_empresa) {
      $sql = "select 
      id, categoria ,
      (select 1 from empresas_categorias_residuos ecr where ecr.id_categoria_residuo = cr.id and id_empresa = $id_empresa) as faz
    from 
      categorias_residuos cr
    order by cr.id";
      
     return   $this->db->query($sql)->result();
    }
    
    public function update_categorias_residuos($id_empresa) {
        //Limpando tabela
        $this->db->where('id_empresa', (int) $id_empresa);
        $this->db->delete('empresas_categorias_residuos');

        foreach ($this->input->post('categoria') as $codigo) {
            $data[] = array(
                'id_empresa' => (int) $id_empresa,
                'id_categoria_residuo' => $codigo
            );
        }

        //Fazemos o insert pegando a array montada acima
        $this->db->insert_batch('empresas_categorias_residuos', $data);
    }
    
    
    public function count_all_bloqueadas(){
        $this->db->where('ativo',0);
        $this->db->where('removido',NULL);
        $this->db->from('empresas');
        return $this->db->count_all_results();
    }
    
    public function conta_por_mes($ano,$mes,$funcao){
        if (($ano>0) && ($mes>0)){
        return 
        $this->db->query("SELECT COUNT(id) as qtde
                                FROM empresas  
                                WHERE 
                                    id_funcao in ($funcao)
                                    and YEAR(data_cadastro) = $ano  
                                    and MONTH(data_cadastro) = $mes")->row();
        } else return 0;
    }
	
	
	public function get_relatorio_empresas($post){
		
		$where = '';
		
		if(!empty($post['data_inicio'])){
			$data_inicio = date('Y-m-d',strtotime(str_replace('/','-',$post['data_inicio'])));
		}
		
		if(!empty($post['data_final'])){
			$data_final = date('Y-m-d',strtotime(str_replace('/','-',$post['data_final'])));
		}
		
		if(!empty($post['data_inicio']) && !empty($post['data_final'])){
			
			$where = ' data_cadastro BETWEEN "'.$data_inicio.' 00:00:00" and "'.$data_final.' 23:59:59" and  ';	
			
		}else
		if(!empty($post['data_inicio'])){
			
			$where = ' date(data_cadastro) = "'.$data_inicio.'" and  ';	
			
		}else
		if(!empty($post['data_final'])){
			
			$where = ' date(data_cadastro) = "'.$data_final.'" and  ';	
			
		}
		
		$sql = "SELECT 
			id, 
			ativo, 
			tipo_cadastro,
			id_funcao, 
			(select funcao from funcoes_empresas where id = id_funcao) as perfil, 
			cnpj, 
			cpf, 
			razao_social, 
			nome_fantasia, 
			nome_responsavel, 
			telefone1, 
			telefone2, 
			email, 
			cep, 
			logradouro, 
			numero, 
			complemento, 
			bairro, 
			id_cidade,
			(select nome_cidade from cidades where id = id_cidade) as cidade,  
			uf_estado, 
			senha, 
			data_cadastro, 
			removido
		 FROM empresas WHERE ".$where." removido is null ";
				 
        return $this->db->query($sql)->result_array();
    }
	
}
