<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {
	
	var $table = 'empresas';
	//Campos da tabela para ordernar coluna
    var $column_order = array('id', 'cpf', 'cnpj', 'telefone1', 'telefone2'); 
	//campos da tabela para fazer pesquisa no banco
    var $column_search = array('id','cpf', 'cnpj', 'razao_social', 'nome_fantasia', 'nome_responsavel', 'email', 'telefone1', 'telefone2'); 
	// Ordem padrão do datagrid
    var $order = array('id' => 'desc'); 


    function __construct() {
        parent::__construct();

        $this->login_model->restrito();

        $this->load->model(array('empresa_model', 'endereco_model'));
        $this->load->library(array('form_validation', 'util'));
        $this->_init();
    }

    private function _init() {
		
        $this->output->set_template('default');
		
		/****** Data Tables **************/
        $this->load->js('assets/pluguins/datatables/datatables.min.js');
        $this->load->js('assets/pluguins/datatables/dataTables.bootstrap4.js');
        $this->load->js('assets/pluguins/datatables/script.js');
		
		/****** Pluguin Calendário Input **************/
		$this->load->css('assets/pluguins/datepicker/css/bootstrap-datepicker.min.css');
		$this->load->js('assets/pluguins/datepicker/js/bootstrap-datepicker.min.js');
		$this->load->js('assets/pluguins/datepicker/locales/bootstrap-datepicker.pt-BR.min.js');
		
		/****** Busca CNPJ Global **************/
		$this->load->js('assets/pluguins/buscacnpj.js');
		
    }
	
	
    public function index($id_funcao=0) {
		
		 $this->load->helper('datatables');

        $data['menu_opcao_direita'][] = anchor(
			site_url('empresa/index/?ativo=0'), 
			'<i class="fa fa-fw fa-lock"></i> Bloqueadas', 
			'class="btn btn-info btn-sm not-focusable filtrar_empresa"  data-toggle="tooltip" title="Empresas Bloqueadas"'
		);
		$data['menu_opcao_direita'][] = anchor(
			site_url('empresa/index/1'), 
			'<i class="fa fa-fw fa-trash"></i> Geradora', 
			'class="btn btn-warning btn-sm not-focusable filtrar_empresa"  data-toggle="tooltip" title="Listar Geradora"'
		);
        $data['menu_opcao_direita'][] = anchor(
			site_url('empresa/index/2'), 
			'<i class="fa fa-fw fa-truck"></i> Coletora', 
			'class="btn btn-info btn-sm not-focusable filtrar_empresa"  data-toggle="tooltip" title="Listar Coletora"'
		);
        $data['menu_opcao_direita'][] = anchor(
			'empresa/add_empresa_modal', '<i class="fa fa-fw fa-plus-circle"></i> Nova Empresa', 
			' rel="modal_add_edit" class="btn btn-primary btn-sm not-focusable"  data-toggle="tooltip" title="Clique aqui para realizar um novo cadastro"'
		);
		
        $data['menu_opcao_direita'][] = anchor('#', '<i class="fa fa-fw fa-trash"></i> Remover', 'class="btn btn-danger btn-sm not-focusable" id="deletar_row_table"');


		$funcoes_empresa = false;
		
		// Existe o filtro
		if ($this->input->get()) {
			
			$title = 'Empresa ';
			if($this->input->get('ativo')!=''){
				$array_navegacao = array(
					'Empresas' => 'empresa',
					'Desabilitados' => ''
				);
				$url_ajax = site_url("empresa/ajax_list/?ativo=".$this->input->get('ativo'));
			}
		}else
        if ($this->uri->segment(3)) { 
            $funcoes_empresa = $this->uri->segment(3); // Pega a 3º posicao na URL amigavel	
            $row_funcao = $this->empresa_model->get_funcao_row($funcoes_empresa);
            $title = 'Empresa ' . $row_funcao->funcao;
            $array_navegacao = array(
                'Empresas' => 'empresa',
                $title => ''
            );
			$url_ajax = site_url("empresa/ajax_list/".$id_funcao);
        } else {
            
            $array_navegacao = array(
                'Empresas' => ''
            );
            $title = 'Empresas ';
			$url_ajax = site_url("empresa/ajax_list/");
        }

        $this->output->set_common_meta($title, '', ''); //Title / Description / Tags
        $data['menu_mapa'] = $array_navegacao;
		
		//Nome Coluna / Width Coluna em PX 
        $table_th = array(
            array('col_name' => '<input name="select_all" value="1" id="example-select-all" type="checkbox" />', 'col_width' => 18, 'col_order' => false),
            array('col_name' => 'CPF / CNPJ', 'col_width' => NULL, 'col_order' => true),
            array('col_name' => 'Razão Social / Nome Fantasia / Responsável', 'col_width' => NULL, 'col_order' => true),
            array('col_name' => 'Contatos', 'col_width' => NULL, 'col_order' => true),
            array('col_name' => '--', 'col_width' => 18, 'col_order' => false)
        );
		
        $datagrid = array(
            'grid_id' => 'table', // ID tabela html carregamento
            'load_ajax' => $url_ajax, // URL carregamento ajax Json
            'delete_ajax' => site_url("empresa/deletar"), // URL deletar registro
            'columns' => $table_th
        );

        $data['table_th'] = $table_th;
        $data['datagrid_js'] = datagrid_js($datagrid);

        $this->load->view('theme/listar', $data);
    }
	
	public function ajax_list($id_funcao='') {

        $this->output->unset_template();

        $list = $this->empresa_model->get_datatables($id_funcao,$this->input->get());
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dados) {
            $no++;
            $row = array();
			
			$empresa=(!empty($dados->razao_social)?$dados->razao_social.'<br>':'');
            $empresa.= (!empty($dados->nome_fantasia)?$dados->nome_fantasia.'<br>':'');
            $empresa.=(!empty($dados->nome_responsavel)?$dados->nome_responsavel.'<br>':''); 
          	
			$documento = (!empty($dados->cnpj)?$dados->cnpj:$dados->cpf);
            
			$row[] = '<input type="checkbox" value="' . $dados->id . '" rel="' . $dados->nome_responsavel . '" >';
		    $row[] = $documento.'<br>'.($dados->id_funcao=='1'?'Geradora':'Coletora').'<br>'.($dados->ativo=='1'?'Habilitada':'Bloqueada');
            $row[] = $empresa;
            $row[] = $dados->telefone1.'<br>'.$dados->telefone2;
            $row[] = '<a href="' . site_url('empresa/edit/' . $dados->id) . '" class="btn btn-sm btn-warning" ><i class="fa fa-fw fa-pencil-square-o"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->empresa_model->count_all($id_funcao,$this->input->get()),
            "recordsFiltered" => $this->empresa_model->count_filtered($id_funcao,$this->input->get()),
            "data" => $data,
        );

        echo json_encode($output);
    }


    public function add($funcao=false) {
		
		$id_funcao = false;
		
		if($funcao==false){
			 $data['resposta_erro'] = 'Não foi identificado o tipo de cadastro';
			  redirect(site_url('empresa'));
		}else{
			$id_funcao = $this->empresa_model->funcoes_empresas_row($funcao)->id;
		}
		
		if(!$this->session->userdata('cpf_cnpj')){
			$data['resposta_erro'] = 'Não foi identificado o CPF ou CNPJ de quem está sendo cadastrado';
			redirect(site_url('empresa'));
		}

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
			
			$data['outra_area_atuacao'] = $this->input->post('digite_area');
        }
		
		if($this->session->userdata('cpf_cnpj')){
			$data['cnpj'] = $this->session->userdata('cpf_cnpj');
		}
		
		
        //Buscamos a área de atuação para exibição
        $data['row_atuacao_principal'] = $this->empresa_model->consultar_area_Id(false);
        $data['result_atuacoes'] = false;
        $data['areas_atuacoes'] = $this->empresa_model->get_all_area_atuacao();

        //Buscando categorias de residuos coletados
        $data['categorias_residuos'] = $this->empresa_model->get_all_categorias_residuos(0);
        
        
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
        $data['removido'] = $row->removido;
        
        //Dados empresa
        $data['cnpj'] = (!empty($row->cnpj)?$row->cnpj:$row->cpf);
        
        $data['razao_social'] = $row->razao_social;
        $data['nome_fantasia'] = $row->nome_fantasia;
        $data['nome_responsavel'] = $row->nome_responsavel;

        //Contato
        $data['telefone1'] = $row->telefone1;
        $data['telefone2'] = $row->telefone2;
        $data['email'] = $row->email;
       
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

        if($data['row_atuacao_principal']){
          $data['outra_area_atuacao'] = $data['row_atuacao_principal']->outra_area_atuacao;
        }

        if ($data['id_funcao']==2){
            //Buscando categorias de residuos coletados
            $data['categorias_residuos'] = $this->empresa_model->get_all_categorias_residuos($data['id']);
        }

        //Trabalho o select no form
        $uf = ($this->input->post('estado') ? $this->input->post('estado') : $row->uf_estado);
        $data['estados'] = $this->endereco_model->get_all_estados(); // Listamos todos estados normalmente
        $data['cidades'] = $this->endereco_model->get_all_cidades($uf); //<-UF no EDIT pra listar apenas a cidades do estado selecionado
        
		//Trabalhamos os botões superior a direita
        if (!empty($row->removido)){
            $data['menu_opcao_direita'][] = anchor(
				site_url('empresa/cancelar_remocao/' . $id . '/1'), 
				'<i class="fa fa-fw fa-unlock"></i> Cancelar Remoção', 
				'class="btn btn-danger btn-sm not-focusable" '
			);
        }
        
        
        if ($row->ativo == 0) {
            $data['menu_opcao_direita'][] = anchor(
				site_url('empresa/desbloquear/' . $id . '/1'), 
				'<i class="fa fa-fw fa-user-o"></i> Desbloquear Cadastro', 
				'class="btn btn-info btn-sm not-focusable" '
			);
        } else {
            $data['menu_opcao_direita'][] = anchor(
				site_url('empresa/desbloquear/' . $id . '/0'), 
				'<i class="fa fa-fw fa-lock"></i> Bloquear Cadastro', 
				'class="btn btn-warning btn-sm not-focusable" '
			);
        }
        $data['menu_opcao_direita'][] = anchor(
			site_url('empresa'), 
			'<i class="fa fa-fw fa-undo"></i> Voltar',
			'class="btn btn-info btn-sm not-focusable"'
		);

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
            'id_funcao' => $post['id_funcao'],
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

            if ($id == false) {// Não tem ID, então faz insert
                $id = $this->empresa_model->empresa_insert($data, $post); // retorna o insert_id
                $this->empresa_model->update_categorias_residuos((int) $id);
                $this->empresa_model->atuacao($id); //Atualizar o tabela atuacao
				
				$this->session->unset_userdata('cpf_cnpj');
				
                $resposta = 'Empresa coletora cadastrada com sucesso.';
            } else {
                
				$this->empresa_model->empresa_update($id, $data, $post);

                $this->empresa_model->atuacao((int) $id); //Atualizar o tabela atuacao
                $this->empresa_model->update_categorias_residuos((int) $id);
                $resposta = 'Empresa coletora atualizada com sucesso.';
            }
            $retorno = true;
        }

        return array('resposta' => $resposta, 'retorno' => $retorno, 'data' => $data);
    }

    private function post_geradora($post, $id) { // PF e PJ
        $data = array(
            //Config
            'tipo_cadastro' => $post['tipo_cadastro'],
            'id_funcao' => $post['id_funcao'],
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

            if ($id == false) {// Não tem ID, então faz insert
                $this->empresa_model->empresa_insert($data, $post); // retorna o insert_id

				$this->session->unset_userdata('cpf_cnpj');

                $resposta = 'Empresa geradora cadastrada com sucesso.';
            } else {

                $this->empresa_model->empresa_update($id, $data, $post);

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

    public function licenca_form($id_empresa = 0, $id_licenca = 0) {

        $this->output->unset_template();

        $data = array();

        if ($id_licenca == 0) {

            $data['titulo'] = '';
            $data['validade'] = '';
            $data['status'] = '';
            $data['action'] = site_url('empresa/licenca_upload/' . $id_empresa);
        } else
        if ($id_licenca != 0) { // recebemos o id do arquivo, então exibe
            $row = $this->empresa_model->empresa_licenca_row($id_licenca);

            $data['id_licenca'] = $row->id;
            $data['titulo'] = $row->titulo;
            $data['validade'] = date('d/m/Y', strtotime($row->validade));
            $data['status'] = $row->status;
            $data['action'] = site_url('empresa/licenca_upload/' . $id_empresa . '/' . $id_licenca);
        }
        $data['id_empresa'] = $id_empresa;
        $data['result_status'] = $this->empresa_model->empresa_licenca_status_result(); // result com todo status possiveis

        $data['title'] = ($id_empresa == 0 ? 'Cadastrar Arquivo' : 'Atualizar Arquivo');

        $this->load->view('empresas/licenca_form', $data);
    }

    public function licenca_list($id_empresa) {
        $this->output->unset_template();
        $data['result'] = $this->empresa_model->empresa_licenca_result($id_empresa);

        $this->load->view('empresas/licenca_list', $data);
    }

    public function licenca_download($id_licenca) {

        $this->output->unset_template();

        $row = $this->empresa_model->empresa_licenca_row($id_licenca);

        $arquivo = '../uploads/empresa/' . $row->id_empresa . '/' . $row->certificado;
        $nome_saida = $row->titulo;
        if (is_file($arquivo)) {
            $this->util->ArquivoVer($arquivo, $nome_saida);
        } else {
            echo 'arquivo não encontrado';
            exit;
        }
    }

	
	public function add_empresa_modal(){
	 	$this->output->unset_template();
		
		$data = array();
		$data['title'] = 'Cadastrar Nova Empresa';
		
		$this->load->view('empresas/add_modal',$data);
	}

	
	public function post_valid_cpf_cnpj() {
        $this->output->unset_template();

        $json = array();

        if(!$this->input->post('cpf_cnpj')){
            $json['error'] = $json['error_cpf_cnpj'] = 'Digite o CPF ou CNPJ da empresa';
        }else
		if($this->input->post('tipo')=='geradora' && $this->util->ValidaCpf($this->input->post('cpf_cnpj')) == false && strlen($this->input->post('cpf_cnpj'))<14){
            // Validamos Geradora com CPF DOC com menos de 14 digitos
			$json['error'] = $json['error_cpf_cnpj'] = 'CPF inválido para geradar';
        }else
		if($this->input->post('tipo')=='geradora' && $this->util->ValidaCnpj($this->input->post('cpf_cnpj')) == false && strlen($this->input->post('cpf_cnpj'))>14){
            // Validamos Geradora com CPF DOC com mais de 14 Digitos
			$json['error'] = $json['error_cpf_cnpj'] = 'CNPJ inválido para empresa geradora';
        }else
		if($this->input->post('tipo')=='coletora' && $this->util->ValidaCnpj($this->input->post('cpf_cnpj')) == false){
			// Somente CNPJ para Coletora
			$json['error'] = $json['error_cpf_cnpj'] = 'CNPJ inválido para empresa coletora';	
		}else
		if($this->empresa_model->valid_doc_empresas($this->input->post('cpf_cnpj'))!=0){
			// Somente CNPJ para Coletora
			$json['error'] = $json['error_cpf_cnpj'] = 'Documento já está cadastrado em nosso sistema';	
		}

		if (!$json) { 
		
        	$tipo_cadastro = $this->input->post('tipo');
			$cpf_cnpj = $this->input->post('cpf_cnpj');
			
			$this->session->set_userdata('cpf_cnpj',$cpf_cnpj);
			
		 	$json['redirect'] = site_url('empresa/add/'.$tipo_cadastro);
	    }

        echo json_encode($json);
	}
	
	

    public function licenca_upload($id_empresa = 0, $id_licenca = 0) {
        $this->output->unset_template();

        $json = array();

        $nome_arquivo = NULL; //Não temos o nome do arquivo

        if ($id_empresa == 0) {
            $json['error'] = $json['error_empresa'] = 'Erro interno ao identificar o ID da empresa';
        }

        if (!$this->input->post('status')) {
            $json['error'] = $json['error_status'] = 'Selecione o status do arquivo';
        }

        // Cadastradndo ou já estamos editando e foi selecionado o arquivo para upload, então temos que validar novamente
        if ($id_licenca == 0 or $id_licenca != 0 and is_uploaded_file($_FILES['licenca']['tmp_name'])) {

            $dir_upload = '../uploads/empresa/' . (int) $id_empresa; //diretório para upload
            if (!is_dir($dir_upload)) { // verificamos se ele existe
                mkdir($dir_upload); // não existe, então vamos criar...           
            }

            // Config upload
            $config['upload_path'] = $dir_upload;
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = date('Y-m-d_H-i') . '_ID' . $id_empresa . '_' . rand(1000, 9999); // Data Upload / ID empresa / Rand entre 1000 e 9999 
            $config['max_filename_increment'] = 300;
            $config['max_size'] = 10240; //(10*1024kb) = 10MB
            $config['max_width'] = 5024;
            $config['max_height'] = 5068;

            $this->load->library('upload', $config);

            
            // Tratamos se existe erro para o upload
            if (!$this->upload->do_upload('licenca')) {
                $json['error'] = $json['error_licenca'] = $this->upload->display_errors('', '');
            } else {
                $upload = $this->upload->data();
                $nome_arquivo = $upload['file_name'];
            }
        }

        if (!$this->input->post('validade')) {
            $json['error'] = $json['error_validade'] = 'Digite a valida do documento';
        } else
        if ($this->util->ValidaData($this->input->post('validade')) == false) {
            $json['error'] = $json['error_validade'] = 'Data inválida';
        } else
        if (date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('validade')))) <= date('Y-m-d')) {
            $json['error'] = $json['error_validade'] = 'A data tem que ser maior que a data de hoje';
        }

        if (!$this->input->post('titulo')) {
            $json['error'] = $json['error_titulo'] = 'Digite o nome do arquivo';
        }

        if (!$json) { // Não existe erro, então faz o insert ou update
            
			$data = array(
                'titulo' => $this->input->post('titulo'),
                'validade' => date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('validade')))),
                'status' => (int)$this->input->post('status'),
                'atualizado' => date('Y-m-d H:i:s')
            );

            if ($id_licenca == 0) {
                $this->empresa_model->upload_licenca_insert($data, $id_empresa, $nome_arquivo);
                $json['resposta'] = 'Arquivo cadastrado com sucesso';
            } else {
                $this->empresa_model->upload_licenca_update($data, $id_empresa, $nome_arquivo, $id_licenca);
                $json['resposta'] = 'Arquivo atualizado com sucesso';
            }

            $json['id_empresa'] = $id_empresa; // passamos o id da empresa para atualizar o grid
            $json['ok'] = true;
        }

        echo json_encode($json);
    }
	
	 function deletar() {
        $this->output->unset_template();
        $array_itens = explode(",", $this->input->post('ids_delete'));
        foreach ($array_itens as $index => $id) {
            if (is_numeric($id) && $id >= 1) {
                $this->empresa_model->deletar($id); /* model deletar noticia */
            }
        }
        $error = "Selected countries (id's: " . $this->input->post('ids_delete') . ") deleted with success";
        $this->output->set_header($this->config->item('ajax_header'));
        $this->output->set_output($error);
    }

    function getcidades($id_uf) {
        $this->output->unset_template();
        $cidade = $this->input->get('cidade');
        $retorno = array();
        $this->load->model('cidades_model');

        $cidades = $this->cidades_model->getcidades($id_uf);
        foreach ($cidades as $row) {

            $cidade = strtoupper($cidade);
            $cidade2 = strtoupper($row->nome_cidade);

            $selected = ($cidade == $cidade2 ? 'selected' : '');

            $retorno[] = array('nome_cidade' => $row->nome_cidade, 'id' => $row->id, 'selected' => $selected);
        }

        echo json_encode($retorno);

        return;
    }
    
    public function cancelar_remocao($id) {
        $this->empresa_model->cancelar_remocao($id);
        redirect(site_url('empresa/edit/' . $id));
    }
	
}
