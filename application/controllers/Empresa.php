<?php
//teste
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('empresa_model');
    }

    public function login() {
        $this->load->view('empresa/login');
    }

    public function gerador() {
        $dados['titulo'] = "Destine Já - Cadastro";

        $this->load->model('funcao_empresa_model');
        $dados['funcoes'] = $this->funcao_empresa_model->lista_funcao('Gerador');

        $this->load->model('area_atuacao_model');
        $dados['areas'] = $this->area_atuacao_model->lista_area_atuacao();

        $this->load->model('estado_model');
        $dados['estados'] = $this->estado_model->lista_estados();

        $this->load->view('empresa/gerador', $dados);
    }

    public function coletor() {
        $dados['titulo'] = "Destine Já - Cadastro";

        $this->load->model('funcao_empresa_model');
        $dados['funcoes'] = $this->funcao_empresa_model->lista_funcao('Coletor');

        $this->load->model('area_atuacao_model');
        $dados['areas'] = $this->area_atuacao_model->lista_area_atuacao();

        $this->load->model('estado_model');
        $dados['estados'] = $this->estado_model->lista_estados();

        $this->load->view('empresa/coletor', $dados);
    }

    public function cadastrar() {
        $erro = '';

        if (empty($erro)) {
            $dados['cnpj'] = $this->input->post('cnpj');
            $dados['cpf'] = $this->input->post('cpf');
            $dados['ativo'] = $this->input->post('ativo');
            $dados['razao_social'] = $this->input->post('rsocial');
            $dados['nome_fantasia'] = $this->input->post('nfantasia');
            $dados['nome_responsavel'] = $this->input->post('nresponsavel');
            $dados['telefone1'] = $this->input->post('tel1');
            $dados['telefone2'] = $this->input->post('tel2');
            $dados['email'] = $this->input->post('email');
            $dados['cep'] = $this->input->post('cep');
            $dados['logradouro'] = $this->input->post('rua');
            $dados['numero'] = $this->input->post('numero');
            $dados['complemento'] = $this->input->post('complemento');
            $dados['bairro'] = $this->input->post('bairro');
            $dados['id_cidade'] = $this->input->post('cidade');
            $dados['uf_estado'] = $this->input->post('estado');
            $dados['senha'] = $this->input->post('senha1');
            $dados['tipo_cadastro'] = $this->input->post('tipo_cadastro');
            $dados['id_funcao'] = $this->input->post('funcao');

            $this->empresa_model->gravar($dados);
            
            $dados2["id_empresa"] = $this->db->insert_id();
            $dados2['codigo_area_atuacao'] = $this->input->post('area_atuacao');
            $dados2['principal'] = 1;
            $dados2["outra_area_atuacao"] = $this->input->post('digite_area');
            $this->empresa_model->gravar_area_atuacao($dados2);

            for ($i = 0; $i <= 50; $i++) {
                if (!empty($this->input->post("area_atuacao_secundaria$i"))) {
                    $dados3["id_empresa"] = $dados2["id_empresa"];
                    $dados3["codigo_area_atuacao"] = $this->input->post("area_atuacao_secundaria$i");
                    $dados3["principal"] = 2;
                    if ($dados3["codigo_area_atuacao"] > 0)
                        $this->empresa_model->gravar_area_atuacao($dados3);
                }
            }
        } else {
            $dados['erro'] = $erro;
        }
        $dados['mensagem'] = "Cadastro inserido com sucesso. Faça o Login";
        $dados['titulo'] = "Destine Já - Login";
        $this->load->view('empresa/login', $dados);
    }

    function getcidades($id_uf) {
        $cidade = $this->input->get('cidade');
        $retorno = array();
        $this->load->model('cidade_model');

        $cidades = $this->cidade_model->getcidades($id_uf);
        foreach ($cidades as $row) {

            $cidade = strtoupper($cidade);
            $cidade2 = strtoupper($row->nome_cidade);

            $selected = ($cidade == $cidade2 ? 'selected' : '');

            $retorno[] = array('nome_cidade' => $row->nome_cidade, 'id' => $row->id, 'selected' => $selected);
        }

        echo json_encode($retorno);

        return;
    }

    function retira_acentos($texto) {
        return strtr($texto, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC");
    }

}
