<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {

    public function get_result_all($funcoes_empresa) {
        if ($funcoes_empresa) {
            $this->db->where('id_funcao', (int) $funcoes_empresa);
        }
        return $this->db->get('empresas')->result();
    }

    public function get_funcao_row($id) {
        $this->db->where('id', (int) $id);
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
        $data[] = array(
            'principal' => 1,
            'id_empresa' => (int) $id_empresa,
            'codigo_area_atuacao' => $this->input->post('area_atuacao'),
            'outra_area_atuacao' => $this->input->post('digite_area')
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

}
