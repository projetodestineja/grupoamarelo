<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('empresa_model');
    }
	
	

    public function gerador() {
        $dados['titulo'] = "Destine Já - Cadastro";

        $this->load->model('funcao_empresa_model');
        $dados['funcoes'] = $this->funcao_empresa_model->lista_funcao('Geradora');

        $this->load->model('area_atuacao_model');
        $dados['areas'] = $this->area_atuacao_model->lista_area_atuacao();

        $this->load->model('estado_model');
        $dados['estados'] = $this->estado_model->lista_estados();

        $this->load->view('empresa/gerador', $dados);
    }

    public function coletor() {
        $dados['titulo'] = "Destine Já - Cadastro";

        $this->load->model('funcao_empresa_model');
        $dados['funcoes'] = $this->funcao_empresa_model->lista_funcao('Coletora');

        $this->load->model('area_atuacao_model');
        $dados['areas'] = $this->area_atuacao_model->lista_area_atuacao();

        $this->load->model('estado_model');
        $dados['estados'] = $this->estado_model->lista_estados();

        $this->load->view('empresa/coletor', $dados);
    }

    public function cadastrar() {
        $erro = '';
        
        $this->load->library(array('form_validation','util'));
        
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
        $dados['senha'] = $this->util->SenhaEncode($this->input->post('senha1'));
        $dados['tipo_cadastro'] = $this->input->post('tipo_cadastro');
        $dados['id_funcao'] = $this->input->post('funcao');
        
        $this->form_validation->set_rules('cnpj', 'CNPJ', "is_unique[empresas.cnpj]");
        $this->form_validation->set_rules('nresponsavel', 'Nome Responsável', 'required');
        $this->form_validation->set_rules('tel1', 'Telefone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required');
        $this->form_validation->set_rules('estado', 'Estado', 'required');
        $this->form_validation->set_rules('senha1', 'Senha', 'required');

        
        if ($this->form_validation->run() == TRUE){

            $this->empresa_model->gravar($dados);
            
            $dados2["id_empresa"] = $this->db->insert_id();
            $dados2['codigo_area_atuacao'] = $this->input->post('area_atuacao');
            $dados2['principal'] = 1;
            $dados2["outra_area_atuacao"] = $this->input->post('digite_area');
            $this->empresa_model->gravar_area_atuacao($dados2);

            foreach ($this->input->post("area_atuacao_secundaria[]") as $key){
                if (!empty($this->input->post("area_atuacao_secundaria[]"))) {
                    $dados3["id_empresa"] = $dados2["id_empresa"];
                    $dados3["codigo_area_atuacao"] = $key;
                    $dados3["principal"] = 2;
                    $dados3["outra_area_atuacao"] = NULL;
                    if ($dados3["codigo_area_atuacao"] > 0)
                        $this->empresa_model->gravar_area_atuacao($dados3);
                }
            }

        $this->session->set_flashdata("msg","Cadastro inserido com sucesso. Faça o login");
        
        redirect(base_url('login'));
        
        } else {
            if (form_error('cnpj')){
                $erro = "CNPJ já existente na base de dados. Entre em contato com a Destine Já.";
            } else if ((form_error('nresponsavel')) || (form_error('tel1')) || (form_error('email')) ||(form_error('bairro')) || (form_error('cidade')) || (form_error('estado')) || (form_error('senha1')) ){
                $erro = "Campos Obrigatórios não preenchidos. Tente cadastrar novamente."; 
            }
            
            $this->session->set_flashdata("msg",$erro);
            redirect(base_url());
        }
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
