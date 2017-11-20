<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensagens extends CI_Controller {
	
	var $table = 'mensagens';
    var $column_order = array('id', 'assunto', 'cadastrada', 'alert_email'); //Campos da tabela para ordernar coluna
    var $column_search = array('id', 'assunto', 'cadastrada', 'alert_email'); //campos da tabela para fazer pesquisa no banco
    var $order = array('id' => 'desc'); // Ordem padrão do datagrid
	
	function __construct(){
    parent::__construct();
    	$this->login_model->restrito();
		$this->load->model('mensagens_model');
		$this->load->helper('text');
		$this->_init();
	}

	private function _init() {

        $this->output->set_template('default');

        $this->load->js('assets/pluguins/datatables/datatables.min.js');
        $this->load->js('assets/pluguins/datatables/dataTables.bootstrap4.js');
        $this->load->js('assets/pluguins/datatables/script.js');
    }

    public function index() {
        $this->load->helper('datatables');
		
		//Title / Description / Tags
        $this->output->set_common_meta('Mensagens Enviadas', '', ''); 

        $data['menu_mapa'] = array(
            'Mensagens' => ''
        );

        $data['menu_opcao_direita'][] = anchor(
			'#', 
			'<i class="fa fa-fw fa-trash"></i> Remover', 
			'class="btn btn-danger btn-sm not-focusable" id="deletar_row_table"'
		);

        //Nome Coluna / Width Coluna em PX 
        $table_th = array(
            array('col_name' => '<input name="select_all" value="1" id="example-select-all" type="checkbox" />', 'col_width' => 18, 'col_order' => false),
            array('col_name' => 'Assunto', 'col_width' => NULL, 'col_order' => true),
            array('col_name' => 'Cadastrada', 'col_width' => NULL, 'col_order' => true),
            array('col_name' => 'E-mail', 'col_width' => NULL, 'col_order' => true),
            array('col_name' => '--', 'col_width' => 18, 'col_order' => false)
        );
        $datagrid = array(
            'grid_id' => 'table', // ID tabela html carregamento
            'load_ajax' => site_url("mensagens/ajax_list"), // URL carregamento ajax Json
            'delete_ajax' => site_url("mensagens/deletar"), // URL deletar registro
            'columns' => $table_th
        );

        $data['table_th'] = $table_th;
        $data['datagrid_js'] = datagrid_js($datagrid);

        $this->load->view('theme/listar', $data);
    }
	
	
	/*
	*	Listagem de registro ajax
	*/
	public function ajax_list() {

        $this->output->unset_template();

        $list = $this->mensagens_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
		
        foreach ($list as $dados) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" value="' . $dados->id . '" rel="' . $dados->assunto . '" >';
            $row[] = $dados->assunto;
            $row[] = date('d/m/y H:i',strtotime($dados->cadastrada)).'h';
            $row[] = ($dados->alert_email == true ? 'SIM' : 'NÂO');
            $row[] = '
			<a href="'.site_url('mensagens/visualizar/'.$dados->id).'"  class="btn btn-sm btn-warning" >
			<i class="fa fa-fw fa-pencil-square-o"></i>
			</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mensagens_model->count_all(),
            "recordsFiltered" => $this->mensagens_model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }


	/*
	*	Chamada modal demanda
	*/
	public function mensagem_demanda($id_demanda=0,$id_empresa=NULL,$id_mensagem=NULL){
		
		$this->output->unset_template();
		
		$data = array();
		
		$data['title'] = ($id_mensagem == NULL ? 'Cadastrar Mensagem' : 'Atualizar Mensagem').': Demanda #'.$id_demanda;
		
		if($id_mensagem!=NULL){
			$row = $this->mensagens_model->get_row_mensagem($id_mensagem);
		}
		if(isset($row)){
			$data['assunto'] = $row->assunto;
		}else{
			$data['assunto'] = '';
		}
		if(isset($row)){
			$data['msg'] = $row->msg;
		}else{
			$data['msg'] = '';
		}
		
		$data['action'] = site_url('mensagens/mensagem_demanda_post/'.$id_demanda.'/'.$id_empresa.'/'.$id_mensagem);
		
		$this->load->view('mensagens/form_mensagem_demanda',$data);	
	}
	

	/*
	*	Cadastra Mensagem para demanda no BD
	*/
	public function mensagem_demanda_post($id_demanda=0,$id_empresa=NULL,$id_mensagem=NULL){
		
		$this->output->unset_template();

        $json = array();

		if($id_demanda==0){
            $json['error'] = $json['error_n_demanda'] = 'Erro ao identificar número da demanda';
		}

		if($id_empresa==NULL){
            $json['error'] = $json['error_id_empresa'] = 'Erro ao identificar id da empresa';
		}

		if(!$this->input->post('msg')){
            $json['error'] = $json['error_msg'] = 'Digite a mensagem';
        }
		
        if(!$this->input->post('assunto')){
            $json['error'] = $json['error_assunto'] = 'Digite o assunto da mensagem';
		}
		
		if (!$json) { 
		
			if($this->input->post('alert_email')){
				$alert_email = true;
			}else{
				$alert_email = false;
			}
			
			if(is_numeric($id_mensagem)){
				$this->mensagens_model->update_mensagem($this->input->post(),  $id_demanda, $id_empresa, $id_mensagem, $alert_email);
				$json['resposta'] = 'Mensagem atualizada com sucesso.';
			}else{
				$this->mensagens_model->insert_mensagem($this->input->post(), $id_demanda, $id_empresa, $alert_email);
				$json['resposta'] = 'Mensagem enviada com sucesso.';
			}
			
			$json['close_modal'] = true;
			$json['load'] = site_url('mensagens/mensagens_demanda/'.(int)$id_demanda);
	    }

        echo json_encode($json);	
	}

	
	/*
	*	Visualiar mensagem
	*/
	public function visualizar($id_mensagem=NULL){
		
		$data = array();
		
		$this->output->set_common_meta('Visualizar mensagem', '', ''); //Title / Description / Tags
		
		$row = $this->mensagens_model->get_row_mensagem($id_mensagem);
		
		if(!$row){
			$this->session->set_flashdata('resposta_erro', 'Mensagem não identificada');
			redirect(site_url('mensagens'));	
		}
		
		$data['assunto'] = $row->assunto;
		$data['msg'] = $row->msg;
		$data['alert_email'] = ($row->alert_email==true?'SIM':'NÂO');
		$data['cadastrada'] = date('d/m/y H:i',strtotime($row->cadastrada)).'h';
		$data['atualizada'] = date('d/m/y H:i',strtotime($row->atualizada)).'h';
		
		
		$data['menu_mapa'] = array(
            'Mensagens' => $this->uri->segment(1),
            'Visualizar' => ''
        );
		
        $data['menu_opcao_direita'][] = anchor(
			'mensagens', 
			'<i class="fa fa-fw fa-undo"></i> Voltar', 
			'class="btn btn-info btn-sm not-focusable"'
		);
		
		$this->load->view('mensagens/visualizar_mensagem_demanda',$data);	
	}
	
	/*
	*	Listar Mensagens demanda id X
	*/
	public function mensagens_demanda($id_demanda=0){
		$this->output->unset_template();
		
		$data = array();
		
		$data['result'] = $this->mensagens_model->get_result_mensagens_demanda($id_demanda);
		
		$this->load->view('mensagens/list_mensagens_demanda',$data);	
	}


	/*
	*	Remover mensagem forma simples
	*/
	function remover(){

		$this->output->unset_template();

		if($this->input->get('id_delete')){
			$this->mensagens_model->remover($this->input->get('id_delete'));
			$json['resposta'] = 'Mensagem removida com sucesso';
			$json['ok'] = true;
		}else{
			$json['resposta'] = 'Erro ao identificar mensagem';
			$json['ok'] = false;
		}
		echo json_encode($json);	
	}
	
	/*
	*	Remover mensagem via listagem
	*/
	function deletar() {
        $this->output->unset_template();
        $array_itens = explode(",", $this->input->post('ids_delete'));
        foreach ($array_itens as $index => $id) {
            if (is_numeric($id) && $id >= 1) {
                $this->mensagens_model->deletar($id);
            }
        }
        $error = "Selected countries (id's: " . $this->input->post('ids_delete') . ") deleted with success";
        $this->output->set_header($this->config->item('ajax_header'));
        $this->output->set_output($error);
    }
	
	

}
