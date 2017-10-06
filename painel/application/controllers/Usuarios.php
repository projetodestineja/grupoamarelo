<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    var $table = 'usuarios';
    var $column_order = array('id','nome','email','celular','telefone','habilitado'); //Campos da tabela para ordernar coluna
    var $column_search = array('id','Nome','email','celular','telefone','complemento'); //campos da tabela para fazer pesquisa no banco
    var $order = array('id' => 'desc'); // Ordem padrão do datagrid

    function __construct(){
	parent::__construct();

	$this->login_model->restrito();

        $this->load->model(array('endereco_model','usuarios_model'));

		$this->load->library(array('form_validation','util'));


		$this->_init();
    }

    private function _init(){

        $this->output->set_template('default');

        $this->load->js('assets/pluguins/datatables/datatables.min.js');
		$this->load->js('assets/pluguins/datatables/dataTables.bootstrap4.js');
        $this->load->js('assets/pluguins/datatables/script.js');
    }

    public function index(){
        $this->load->helper('datatables');

        $this->output->set_common_meta('Usuários','',''); //Title / Description / Tags

        $data['menu_mapa'] = array(
            'Usuários' => ''
        );

	$data['menu_opcao_direita'][] = anchor('usuarios/add', '<i class="fa fa-fw fa-user-plus"></i> Novo Usuário', 'class="btn btn-primary btn-sm not-focusable"  data-toggle="tooltip" title="Clique aqui para realizar um novo cadastro"');
	$data['menu_opcao_direita'][] = anchor('#', '<i class="fa fa-fw fa-trash"></i> Remover', 'class="btn btn-danger btn-sm not-focusable" id="deletar_row_table"');

        //Nome Coluna / Width Coluna em PX
        $table_th = array(
            array('col_name' => '<input name="select_all" value="1" id="example-select-all" type="checkbox" />','col_width' => 18,'col_order' => false),
            array('col_name' => 'Nome','col_width' => NULL,'col_order' => true),
            array('col_name' => 'E-mail', 'col_width' => NULL,'col_order' => true),
            array('col_name' => 'Celular','col_width' => NULL,'col_order' => true),
            array('col_name' => 'Telefone','col_width' => NULL,'col_order' => true),
            array('col_name' => 'Habilitado' ,'col_width' => 100,'col_order' => true),
            array('col_name' => '--' ,'col_width' => 18,'col_order' => false)
        );
	$datagrid = array(
            'grid_id' => 'table', // ID tabela html carregamento
            'load_ajax' => site_url("usuarios/ajax_list"), // URL carregamento ajax Json
            'delete_ajax' => site_url("usuarios/deletar"), // URL deletar registro
            'columns' => $table_th
	);

        $data['table_th'] = $table_th;
	$data['datagrid_js'] = datagrid_js($datagrid);

        $this->load->view('theme/listar',$data);
    }


    public function ajax_list(){

        $this->output->unset_template();

        $list = $this->usuarios_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
				
        foreach ($list as $dados) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" value="'.$dados->id.'" rel="'.$dados->nome.'" >';
            $row[] = $dados->nome;
            $row[] = $dados->email;
            $row[] = $dados->telefone;
            $row[] = $dados->celular;
            $row[] = ($dados->habilitado==1?'SIM':'NÂO');
	    $row[] = '<a href="'.site_url('usuarios/edit/'.$dados->id).'" class="btn btn-sm btn-warning" ><i class="fa fa-fw fa-pencil-square-o"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->usuarios_model->count_all(),
            "recordsFiltered" => $this->usuarios_model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }

	function add(){
            $this->output->set_common_meta('Cadastrar Usuário','',''); //Title / Description / Tags


            $data = array(
		'nome' => $this->input->post('nome'),
		// Contato
		'telefone' => $this->input->post('telefone'),
		'celular' => $this->input->post('celular'),
		'email' => $this->input->post('email'),

		// Endereço
		'cep' => $this->input->post('cep'),
		'logradouro'=> $this->input->post('logradouro'),
		'numero' => $this->input->post('numero'),
		'complemento' => $this->input->post('complemento'),
		'bairro' => $this->input->post('bairro'),
		'cidade' => $this->input->post('cidade'),
		'estado' => $this->input->post('estado'),

		// Opções
		'habilitado' => $this->input->post('habilitado')
            );

            if($this->input->post()){

		$this->form_validation->set_rules('nome', 'nome completo', 'required');
		$this->form_validation->set_rules('telefone', 'telefone', 'required');
		$this->form_validation->set_rules('email', 'e-mail', 'required|valid_email');

		$this->form_validation->set_rules('cep', 'CEP', 'required');
		$this->form_validation->set_rules('logradouro', 'logradouro', 'required');
		$this->form_validation->set_rules('numero', 'número do endereço', 'required');
		$this->form_validation->set_rules('complemento', 'complemento do endereço', 'required');
		$this->form_validation->set_rules('bairro', 'bairro', 'required');
		$this->form_validation->set_rules('cidade', 'cidade', 'required');
		$this->form_validation->set_rules('estado', 'estado', 'required');

		$this->form_validation->set_rules('senha', 'senha', 'required');
		$this->form_validation->set_rules('senha2', 'senha', 'required|matches[senha]',array('required' => 'Confirme a %s.'));

		if($this->form_validation->run()==FALSE){

                    $this->session->set_flashdata('resposta_erro',validation_errors('<div class="error">* ', '</div>'));

		}else{

                    $this->db->set('senha',$this->util->SenhaEncode($this->input->post('senha')));

                    $this->db->insert('usuarios',$data);

                    $this->session->set_flashdata('resposta_ok', 'Usuário <strong>'.$this->input->post('nome').'</strong> Cadastrado com Sucesso.');
                    redirect(site_url('usuarios'));
		}
            }
            $data['estados'] = $this->endereco_model->get_all_estados();
            $data['cidades'] = $this->endereco_model->get_all_cidades();

            $data['menu_mapa'] = array(
                'Usuários' => $this->uri->segment(1),
                'Cadastrar' => ''
            );
            $data['menu_opcao_direita'][] = anchor('usuarios', '<i class="fa fa-fw fa-undo"></i> Voltar', 'class="btn btn-info btn-sm not-focusable"');
            $this->load->view('usuarios/form',$data);
	}

	function edit($id){

		$data['menu_mapa'] = array(
            'Usuários' => $this->uri->segment(1),
            'Atualizar' => ''
        );

		$row = $this->usuarios_model->get_row($id);
		if($row){

			$data['nome'] 	    = $row->nome;

			$data['telefone']   = $row->telefone;
			$data['celular']    = $row->celular;
			$data['email'] 	    = $row->email;

			$data['cep'] 	    = $row->cep;
			$data['logradouro'] = $row->logradouro;
			$data['numero'] 	= $row->numero;
			$data['complemento']= $row->complemento;
			$data['bairro'] 	= $row->bairro;
			$data['cidade'] 	= $row->cidade;
			$data['estado'] 	= $row->estado;

			$data['habilitado'] = $row->habilitado;
			$data['senha'] = '';
		}


		if($this->input->post()){

			$data = array(
				'nome' => $this->input->post('nome'),
				// Contato
				'telefone' => $this->input->post('telefone'),
				'celular' => $this->input->post('celular'),
				'email' => $this->input->post('email'),

				// endereço
				'cep' => $this->input->post('cep'),
				'logradouro'=> $this->input->post('logradouro'),
				'numero' => $this->input->post('numero'),
				'complemento' => $this->input->post('complemento'),
				'bairro' => $this->input->post('bairro'),
				'cidade' => $this->input->post('cidade'),
				'estado' => $this->input->post('estado'),

				// opções
				'habilitado' => $this->input->post('habilitado')
			);

			$this->form_validation->set_rules('nome', 'nome completo', 'required');
			$this->form_validation->set_rules('telefone', 'telefone', 'required');
			$this->form_validation->set_rules('email', 'e-mail', 'required|valid_email');

			$this->form_validation->set_rules('cep', 'CEP', 'required');
			$this->form_validation->set_rules('logradouro', 'logradouro', 'required');
			$this->form_validation->set_rules('numero', 'número do endereço', 'required');
			$this->form_validation->set_rules('complemento', 'complemento do endereço', 'required');
			$this->form_validation->set_rules('bairro', 'bairro', 'required');
			$this->form_validation->set_rules('cidade', 'cidade', 'required');
			$this->form_validation->set_rules('estado', 'estado', 'required');

			if($this->input->post('senha')){
				$this->form_validation->set_rules('senha', 'senha', 'required');
				$this->form_validation->set_rules('senha2', 'senha', 'required|matches[senha]',array('required' => 'Confirme a %s.'));
			}
			if($this->form_validation->run()==FALSE){

			   $data['resposta_erro'] = validation_errors('<div class="error">* ', '</div>');

			}else{

				if($this->input->post('senha')){
					$this->db->set('senha',$this->util->SenhaEncode($this->input->post('senha')));
				}
				$this->db->where('id',(int)$id);
				$this->db->update('usuarios',$data);

				$this->session->set_flashdata('resposta_ok', 'Usuário <strong>'.$this->input->post('nome').'</strong> Atualizado com Sucesso.');
				redirect(site_url('usuarios'));
			}
		}
		$data['id'] = $id;
		$data['estados'] = $this->endereco_model->get_all_estados();
		$data['cidades'] = $this->endereco_model->get_all_cidades($row->estado);

		$this->output->set_common_meta('Atualizar Usuário','',''); //Title / Description / Tags

		$data['menu_opcao_direita'][] = anchor('usuarios', '<i class="fa fa-fw fa-undo"></i> Voltar', 'class="btn btn-info btn-sm not-focusable"');
		$this->load->view('usuarios/form',$data);
	}



    function deletar(){
         $this->output->unset_template();
		$array_itens = explode(",",$this->input->post('ids_delete'));
		foreach($array_itens as $index => $id){
		  if (is_numeric($id) && $id >= 1){
			$this->usuarios_model->deletar($id); /* model deletar noticia*/
		  }
	}
	$error = "Selected countries (id's: ".$this->input->post('ids_delete').") deleted with success";
	$this->output->set_header($this->config->item('ajax_header'));
        $this->output->set_output($error);

    }




}
