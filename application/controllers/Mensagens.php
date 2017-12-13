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
		$this->load->model(array('mensagens_model','demanda_model'));
		$this->_init();
	}

	private function _init() {

        $this->output->set_template('default');

        $this->load->js('painel/assets/pluguins/datatables/datatables.min.js');
        $this->load->js('painel/assets/pluguins/datatables/dataTables.bootstrap4.js');
        $this->load->js('painel/assets/pluguins/datatables/script.js');
    }

    public function index() {
        $this->load->helper('datatables');
		
		//Title / Description / Tags
        $this->output->set_common_meta('Mensagens Recebidas', '', ''); 

        $data['menu_mapa'] = array(
            'Mensagens' => ''
        );

        //Nome Coluna / Width Coluna em PX 
        $table_th = array(
			array('col_name' => '--', 'col_width' => 18, 'col_order' => false),
            array('col_name' => 'Assunto', 'col_width' => NULL, 'col_order' => true),
            array('col_name' => 'Recebida', 'col_width' => 100, 'col_order' => true)
        );
        $datagrid = array(
            'grid_id' => 'table', // ID tabela html carregamento
            'load_ajax' => site_url("mensagens/ajax_list"), // URL carregamento ajax Json
            'delete_ajax' => site_url("mensagens/deletar"), // URL deletar registro
			'dir_traducao' => 'painel',
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
			$row[] = '
			<a href="'.site_url('mensagens/visualizar/'.$dados->id).'"  class="btn btn-sm btn-primary" >
				<i class="fa fa-fw fa-search-plus"></i>
			</a>';
            $row[] = $dados->assunto;
            $row[] = date('d/m/y H:i',strtotime($dados->cadastrada)).'h';
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
	*	Visualiar mensagem
	*/
	public function visualizar($id_mensagem=NULL){
		
		$data = array();
		
		$this->output->set_common_meta('Visualizar Mensagem', '', ''); //Title / Description / Tags
		
		$row = $this->mensagens_model->get_row_mensagem($id_mensagem);
		
		if(!$row){
			$this->session->set_flashdata('resposta_erro', 'Mensagem não identificada');
			redirect(site_url('mensagens'));	
		}
		
		$this->mensagens_model->get_update_visualizado($id_mensagem);
		
		$data['assunto'] = $row->assunto;
		$data['msg'] = $row->msg;
		$data['alert_email'] = ($row->alert_email==true?'SIM':'NÂO');
		$data['cadastrada'] = date('d/m/y H:i',strtotime($row->cadastrada)).'h';
		$data['atualizada'] = date('d/m/y H:i',strtotime($row->atualizada)).'h';
		
		if($row->id_demanda!=0){
			$row_demanda = $this->demanda_model->get_row_demanda($row->id_demanda);
			if($row_demanda->status==6){
				$data['menu_opcao_direita'][] = '
				<a href="'.site_url('demanda/edit/'.$row->id_demanda).'" class="btn btn-warning btn-sm not-focusable" >
					<i class="fa fa-fw fa-pencil-square-o"></i> Atualizar
				</a>';
			}
		}
		
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
	*	Json mensagens de resumo
	*/
	function novas_mensagens(){
		
		$this->output->unset_template();
		
		$result  = $this->mensagens_model->get_novas_mensagens_result();
		foreach($result as $n){
			$data[] = array(
				'assunto' => $n->assunto,
				'msg' => character_limiter($n->msg,50),
				'href' => site_url('mensagens/visualizar/'.$n->id)
			);
		}
		
		echo json_encode($data);
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
	

}
