<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('empresa_model', 'endereco_model'));
        $this->load->library(array('form_validation', 'util'));
        $this->_init();
    }

    private function _init() {
        $this->output->set_template('default');
        $this->load->js('assets/pluguins/datatables/datatables.min.js');
        $this->load->js('assets/pluguins/datatables/dataTables.bootstrap4.js');
    }

    public function index() {

        $data['menu_opcao_direita'][] = anchor('empresa/index/1', '<i class="fa fa-fw fa-trash"></i> Listar Somente Geradora', 'class="btn btn-warning btn-sm not-focusable"  data-toggle="tooltip" title="Listar Somente Geradora"');
        $data['menu_opcao_direita'][] = anchor('empresa/index/2', '<i class="fa fa-fw fa-truck"></i> Listar Somente Coletora', 'class="btn btn-info btn-sm not-focusable"  data-toggle="tooltip" title="Listar Somente Coletora"');

        $data['menu_opcao_direita'][] = anchor('empresa/add/2', '<i class="fa fa-fw fa-plus-circle"></i> Nova Coletora', 'class="btn btn-primary btn-sm not-focusable"  data-toggle="tooltip" title="Clique aqui para realizar um novo cadastro"');
        $data['menu_opcao_direita'][] = anchor('empresa/add/1', '<i class="fa fa-fw fa-plus-circle"></i> Nova Geradora', 'class="btn btn-primary btn-sm not-focusable"  data-toggle="tooltip" title="Clique aqui para realizar um novo cadastro"');
        $data['menu_opcao_direita'][] = anchor('#', '<i class="fa fa-fw fa-trash"></i> Remover', 'class="btn btn-danger btn-sm not-focusable" id="deletar_row_table"');


        if ($this->uri->segment(3)) { // Existe o filtro
            $funcoes_empresa = $this->uri->segment(3); // Pega a 3º posicao na URL amigavel	
            $row_funcao = $this->empresa_model->get_funcao_row($funcoes_empresa);
            $title = 'Empresa ' . $row_funcao->funcao;
            $array_navegacao = array(
                'Empresas' => 'empresa',
                $title => ''
            );
        } else {
            $funcoes_empresa = false;
            $array_navegacao = array(
                'Empresas' => ''
            );
            $title = 'Empresas ';
        }

        $this->output->set_common_meta($title, '', ''); //Title / Description / Tags
        $data['menu_mapa'] = $array_navegacao;

        $data['result'] = $this->empresa_model->get_result_all($funcoes_empresa); //Passe o tipo se quiser 1 ou 2

        $this->load->view('empresas/listar', $data);
    }

    public function add($id_funcao) {

        // Verifica se existe o POST se existir, faz a validação e sobrescreve as varivaveis passadas para o VALUE no form
        if ($this->input->post()) {
            if ($this->input->post('tipo_cadastro')) {
                $resposta = $this->post_geradora($this->input->post(), false, $id_funcao); // POST / ID EDIT / FUNCAO
            } else {
                $resposta = $this->post_coletora($this->input->post(), false, $id_funcao); // POST / ID EDIT / FUNCAO
            }
            $data = $resposta['data']; // recupera o data da chamada do método acima
            if ($resposta['retorno'] == true) {
                $this->session->set_flashdata('resposta_ok', $resposta['resposta']);
                redirect(site_url('empresa'));
            } else {
                $data['resposta_erro'] = $resposta['resposta'];
            }
        } else {

            //Config
            $data['tipo_cadastro'] = $this->input->post('tipo_cadastro');

            //dados empresa
            $data['cnpj'] = ($this->input->post('tipo_cadastro') == 'J' ? $this->input->post('cnpj') : ''); // Deixa em branco se for pessoa física
            $data['cpf'] = ($this->input->post('tipo_cadastro') == 'F' ? $this->input->post('cpf') : ''); //Deixa em branco se for PJ
            $data['razao_social'] = ($this->input->post('tipo_cadastro') == 'J' ? $this->input->post('rsocial') : ''); // Deixa em branco se for pessoa física
            $data['nome_fantasia'] = ($this->input->post('tipo_cadastro') == 'J' ? $this->input->post('nfantasia') : ''); // Deixa em branco se for pessoa física
            $data['nome_responsavel'] = $this->input->post('nresponsavel');

            //Contato
            $data['telefone1'] = $this->input->post('telefone1');
            $data['telefone2'] = $this->input->post('telefone2');
            $data['email'] = $this->input->post('email');

            //Endereço
            $data['cep'] = $this->input->post('cep');
            $data['logradouro'] = $this->input->post('logradouro');
            $data['numero'] = $this->input->post('numero');
            $data['complemento'] = $this->input->post('complemento');
            $data['bairro'] = $this->input->post('bairro');
            $data['id_cidade'] = $this->input->post('cidade');
            $data['uf_estado'] = $this->input->post('estado');
        }

        //Buscamos a área de atuação para exibição
        $data['row_atuacao_principal'] = $this->empresa_model->consultar_area_Id(false);
        $data['result_atuacoes'] = $this->empresa_model->consultar_area_secundaria_Id(false);
        $data['areas_atuacoes'] = $this->empresa_model->get_all_area_atuacao();

        //Trabalho o select no form
        $uf = ($this->input->post('estado') ? $this->input->post('estado') : '');
        $data['estados'] = $this->endereco_model->get_all_estados(); // Listamos todos estados normalmente
        $data['cidades'] = $this->endereco_model->get_all_cidades($uf); //<-UF no EDIT pra listar apenas a cidades do estado selecionado
        $data['id_funcao'] = $id_funcao;

        $data['menu_opcao_direita'][] = anchor(site_url('empresa'), '<i class="fa fa-fw fa-undo"></i> Voltar', 'class="btn btn-info btn-sm not-focusable"');

        $row_funcao = $this->empresa_model->get_funcao_row($id_funcao);

        $title = 'Atualizar Cadastro - ' . $row_funcao->funcao;
        $this->output->set_common_meta($title, '', ''); //Title / Description / Tags
        $data['menu_mapa'] = array(
            'Empresas' => 'empresa',
            'Cadastrar ' . $row_funcao->funcao => ''
        );

        $this->load->view('empresas/form_' . $row_funcao->controller, $data);
    }

    public function edit($id) {
        
        $row = $this->empresa_model->consultar_coletoraId($id);
        if (!$row) {
            $this->session->set_flashdata('resposta_erro', 'Empresa não identificada.');
            redirect(site_url('empresa'));
        }

        $data['id'] = $row->id;
        //Config
        $data['ativo'] = $row->ativo;
        $data['tipo_cadastro'] = $row->tipo_cadastro;
        $data['id_funcao'] = $row->id_funcao;
        $row_funcao = $this->empresa_model->get_funcao_row($row->id_funcao);

        //Dados empresa
        $data['cnpj'] = $row->cnpj;
        $data['cpf'] = $row->cpf;
        $data['razao_social'] = $row->razao_social;
        $data['nome_fantasia'] = $row->nome_fantasia;
        $data['nome_responsavel'] = $row->nome_responsavel;

        //Contato
        $data['telefone1'] = $row->telefone1;
        $data['telefone2'] = $row->telefone2;
        $data['email'] = $row->email;
        ;

        //Endereço
        $data['cep'] = $row->cep;
        $data['logradouro'] = $row->logradouro;
        $data['numero'] = $row->numero;
        $data['complemento'] = $row->complemento;
        $data['bairro'] = $row->bairro;
        $data['id_cidade'] = $row->id_cidade;
        $data['uf_estado'] = $row->uf_estado;

        $data['senha'] = '';
        $data['senha2'] = '';

        // Verifica se existe o POST se existir, faz a validação e sobrescreve as varivaveis passadas para o VALUE no form
        if ($this->input->post()) {
            if ($this->input->post('tipo_cadastro')) {
                $resposta = $this->post_geradora($this->input->post(), $id, false); // POST / ID EDIT / FUNCAO
            } else {
                $resposta = $this->post_coletora($this->input->post(), $id, false); // POST / ID EDIT / FUNCAO
            }
            $data = $resposta['data']; // recupera o data da chamada do método acima
            if ($resposta['retorno'] == true) {
                $this->session->set_flashdata('resposta_ok', $resposta['resposta']);
                redirect(site_url('empresa'));
            } else {
                $data['resposta_erro'] = $resposta['resposta'];
            }
        }

        //Buscamos a área de atuação para exibição
        $data['row_atuacao_principal'] = $this->empresa_model->consultar_area_Id($id);
        $data['result_atuacoes'] = $this->empresa_model->consultar_area_secundaria_Id($id);
        $data['areas_atuacoes'] = $this->empresa_model->get_all_area_atuacao();

        //Trabalho o select no form
        $uf = ($this->input->post('estado') ? $this->input->post('estado') : $row->uf_estado);
        $data['estados'] = $this->endereco_model->get_all_estados(); // Listamos todos estados normalmente
        $data['cidades'] = $this->endereco_model->get_all_cidades($uf); //<-UF no EDIT pra listar apenas a cidades do estado selecionado
        //Trabalhamos os botões superior a direita
        if ($row->ativo == 0) {
            $data['menu_opcao_direita'][] = anchor(site_url('empresa/desbloquear/' . $id . '/1'), '<i class="fa fa-fw fa-unlock"></i> Desbloquear Cadastro', 'class="btn btn-info btn-sm not-focusable" ');
        } else {
            $data['menu_opcao_direita'][] = anchor(site_url('empresa/desbloquear/' . $id . '/0'), '<i class="fa fa-fw fa-lock"></i> Bloquear Cadastro', 'class="btn btn-warning btn-sm not-focusable" ');
        }
        $data['menu_opcao_direita'][] = anchor(site_url('empresa'), '<i class="fa fa-fw fa-undo"></i> Voltar', 'class="btn btn-info btn-sm not-focusable"');

        $title = 'Atualizar Cadastro - ' . $row_funcao->funcao;
        $this->output->set_common_meta($title, '', ''); //Title / Description / Tags
        $data['menu_mapa'] = array(
            'Empresas' => 'empresa',
            'Empresa ' . $row_funcao->funcao => 'empresa/index/' . $row->id_funcao,
            $title => ''
        );

        $this->load->view('empresas/form_' . $row_funcao->controller, $data);
    }

    private function post_coletora($post, $id) { // somente PJ
        $data = array(
            //Config
            'tipo_cadastro' => 'J',
            //dados empresa
            'cnpj' => $post['cnpj'], // Deixa em branco se for pessoa física
            'cpf' => NULL, //Deixa em branco se for PJ
            'razao_social' => $post['rsocial'], // Deixa em branco se for pessoa física
            'nome_fantasia' => $post['nfantasia'], // Deixa em branco se for pessoa física
            'nome_responsavel' => $post['nresponsavel'],
            //Contato
            'telefone1' => $post['telefone1'],
            'telefone2' => $post['telefone2'],
            'email' => $post['email'],
            //Endereço
            'cep' => $post['cep'],
            'logradouro' => $post['logradouro'],
            'numero' => $post['numero'],
            'complemento' => $post['complemento'],
            'bairro' => $post['bairro'],
            'id_cidade' => $post['cidade'],
            'uf_estado' => $post['estado']
        );

        $this->form_validation->set_rules('cnpj', 'CNPJ', 'required');
        $this->form_validation->set_rules('rsocial', 'razão social', 'required');
        $this->form_validation->set_rules('nfantasia', 'nome fantasia', 'required');

        $this->form_validation->set_rules('nresponsavel', 'nome completo do responsável', 'required');
        $this->form_validation->set_rules('telefone1', 'telefone', 'required');
        $this->form_validation->set_rules('email', 'e-mail', 'required|valid_email');

        $this->form_validation->set_rules('cep', 'CEP', 'required');
        $this->form_validation->set_rules('logradouro', 'lagradouro', 'required');
        $this->form_validation->set_rules('numero', 'número do endereço', 'required');
        $this->form_validation->set_rules('complemento', 'complemento do endereço', 'required');
        $this->form_validation->set_rules('bairro', 'bairro', 'required');
        $this->form_validation->set_rules('cidade', 'cidade', 'required');
        $this->form_validation->set_rules('estado', 'estado', 'required');

        if ($post['senha'] or $id == false) {
            $this->form_validation->set_rules('senha', 'senha', 'required');
            $this->form_validation->set_rules('senha2', 'senha', 'required|matches[senha]', array('required' => 'Confirme a %s.'));
        }
        if ($this->form_validation->run() == FALSE) {
            $resposta = validation_errors('<div class="error">* ', '</div>');
            $retorno = false;
        } else {

            if ($post['senha']) {
                $this->db->set('senha', $this->util->SenhaEncode($post['senha']));
            }
            if ($id_funcao) {
                $this->db->set('id_funcao', (int) $id_funcao);
            }
            if ($id == false) {// Não tem ID, então faz insert
                $this->db->insert('empresas', $data);
                $id = $this->db->insert_id();
                $this->empresa_model->atuacao($id);//Atualizar o tabela atuacao
             
                $resposta = 'Empresa coletora cadastrada com sucesso.';
            } else {
                $this->db->where('id', (int) $id);
                $this->db->update('empresas', $data);
                
                $this->empresa_model->atuacao((int)$id);//Atualizar o tabela atuacao
             
                
                $resposta = 'Empresa coletora atualizada com sucesso.';
            }
            $retorno = true;
        }

        return array('resposta' => $resposta, 'retorno' => $retorno, 'data' => $data);
    }

    private function post_geradora($post, $id, $id_funcao) { // PF e PJ
        $data = array(
            //Config
            'tipo_cadastro' => $post['tipo_cadastro'],
            //dados empresa
            'cnpj' => ($post['tipo_cadastro'] == 'J' ? $post['cnpj'] : ''), // Deixa em branco se for pessoa física
            'cpf' => ($post['tipo_cadastro'] == 'F' ? $post['cpf'] : ''), //Deixa em branco se for PJ
            'razao_social' => ($post['tipo_cadastro'] == 'J' ? $post['rsocial'] : ''), // Deixa em branco se for pessoa física
            'nome_fantasia' => ($post['tipo_cadastro'] == 'J' ? $post['nfantasia'] : ''), // Deixa em branco se for pessoa física
            'nome_responsavel' => $post['nresponsavel'],
            //Contato
            'telefone1' => $post['telefone1'],
            'telefone2' => $post['telefone2'],
            'email' => $post['email'],
            //Endereço
            'cep' => $post['cep'],
            'logradouro' => $post['logradouro'],
            'numero' => $post['numero'],
            'complemento' => $post['complemento'],
            'bairro' => $post['bairro'],
            'id_cidade' => $post['cidade'],
            'uf_estado' => $post['estado']
        );

        if ($post['tipo_cadastro'] == 'F') {
            $this->form_validation->set_rules('cpf', 'CPF', 'required');
        } else {
            $this->form_validation->set_rules('cnpj', 'CNPJ', 'required');
            $this->form_validation->set_rules('rsocial', 'razão social', 'required');
            $this->form_validation->set_rules('nfantasia', 'nome fantasia', 'required');
        }
        $this->form_validation->set_rules('nresponsavel', 'nome completo do responsável', 'required');
        $this->form_validation->set_rules('telefone1', 'telefone', 'required');
        $this->form_validation->set_rules('email', 'e-mail', 'required|valid_email');

        $this->form_validation->set_rules('cep', 'CEP', 'required');
        $this->form_validation->set_rules('logradouro', 'lagradouro', 'required');
        $this->form_validation->set_rules('numero', 'número do endereço', 'required');
        $this->form_validation->set_rules('complemento', 'complemento do endereço', 'required');
        $this->form_validation->set_rules('bairro', 'bairro', 'required');
        $this->form_validation->set_rules('cidade', 'cidade', 'required');
        $this->form_validation->set_rules('estado', 'estado', 'required');

        if ($post['senha'] or $id == false) {
            $this->form_validation->set_rules('senha', 'senha', 'required');
            $this->form_validation->set_rules('senha2', 'senha', 'required|matches[senha]', array('required' => 'Confirme a %s.'));
        }
        if ($this->form_validation->run() == FALSE) {
            $resposta = validation_errors('<div class="error">* ', '</div>');
            $retorno = false;
        } else {
            if ($post['senha']) {
                $this->db->set('senha', $this->util->SenhaEncode($post['senha']));
            }
            if ($id_funcao) {
                $this->db->set('id_funcao', (int) $id_funcao);
            }
            if ($id == false) {// Não tem ID, então faz insert
                $this->db->insert('empresas', $data);
                $resposta = 'Empresa geradora cadastrada com sucesso.';
            } else {
                $this->db->where('id', (int) $id);
                $this->db->update('empresas', $data);
                
                $resposta = 'Empresa geradora atualizada com sucesso.';
            }
            $retorno = true;
        }

        return array('resposta' => $resposta, 'retorno' => $retorno, 'data' => $data);
    }
    

    public function desbloquear($id, $acao) {
        $this->empresa_model->desbloquear($acao, $id);
        redirect(site_url('empresa/edit/' . $id));
    }

}
