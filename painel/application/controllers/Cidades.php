<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cidades extends CI_Controller {

	 
    var $table = 'cidades';
    var $column_order = array('null','null','nome_cidade','codigo_cidade_ibge','uf'); //Campos da tabela para ordernar coluna
    var $column_search = array('codigo_cidade_ibge','nome_cidade','uf'); //campos da tabela para fazer pesquisa no banco
    var $order = array('nome_cidade' => 'asc'); // Ordem padrão do datagrid
	
    function __construct(){
	parent::__construct();
	$this->login_model->restrito(); 
        $this->load->helper('datatables');
	$this->load->model('cidades_model');
	$this->_init();
    }

    private function _init(){
		
	$this->output->set_template('default');

	$this->load->js('assets/pluguins/datatables/datatables.min.js');
	$this->load->js('assets/pluguins/datatables/dataTables.bootstrap4.js');
        $this->load->js('assets/pluguins/datatables/script.js');
		
    }
	
    public function index(){
            
        $this->output->set_common_meta('Cidades','',''); //Title / Description / Tags
        $data['menu_mapa'] = array(
            'Cidades' => ''
        );
		
	$data['menu_opcao_direita'][] = anchor('cidades/add', '<i class="fa fa-fw fa-user-plus"></i> Nova Cidade', 'class="btn btn-primary btn-sm not-focusable"');
	$data['menu_opcao_direita'][] = anchor('#', '<i class="fa fa-fw fa-trash"></i> Remover', 'class="btn btn-danger btn-sm not-focusable" id="deletar_row_table"');
		
	//Nome Coluna / Width Coluna em PX 
        $table_th = array(
            array('col_name' => '<input name="select_all" value="1" id="example-select-all" type="checkbox" />','col_width' => 18,'col_order' => false),
            array('col_name' => '--' ,'col_width' => 18,'col_order' => false),
            array('col_name' => 'Cidade', 'col_width' => NULL,'col_order' => true),
            array('col_name' => 'Cód. IBGE', 'col_width' => 80,'col_order' => true),
            array('col_name' => 'UF','col_width' => 30,'col_order' => true)
        );
	
        $datagrid = array(
            'grid_id' => 'table', // ID tabela html carregamento
            'load_ajax' => site_url("cidades/ajax_list"), // URL carregamento ajax Json
            'delete_ajax' => site_url("cidades/deletar"), // URL deletar registro
            'columns' => $table_th
	);
	
        $data['table_th'] = $table_th;
	$data['datagrid_js'] = datagrid_js($datagrid);
		
        $this->load->view('theme/listar',$data);
    }
        
        
    public function ajax_list(){
        
        $this->output->unset_template();
             
        $list = $this->cidades_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dados) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" value="'.$dados->id.'" rel="'.$dados->nome_cidade.'" >';
            $row[] = '<a href="'.site_url('cidades/edit').'" class="btn btn-sm btn-warning" ><i class="fa fa-fw fa-pencil-square-o"></i></a>';
			$row[] = $dados->nome_cidade;
			$row[] = $dados->codigo_cidade_ibge;
			$row[] = $dados->uf;
            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cidades_model->count_all(),
            "recordsFiltered" => $this->cidades_model->count_filtered(),
            "data" => $data,
        );
       
        echo json_encode($output);
    }
    
	function add(){
		$this->output->set_common_meta('Cadastrar Usuário','',''); //Title / Description / Tags
		$data['menu_mapa'] = array(
            'Usuários' => $this->uri->segment(1),
			'Cadastrar' => ''
        );
		
		$this->load->view('cidades/form',$data); 
	}
	
	function edit(){
		 
	}
	
	
    function deletar(){
         $this->output->unset_template();
		$array_itens = explode(",",$this->input->post('ids_delete'));
		foreach($array_itens as $index => $id){
				if (is_numeric($id) && $id >= 1){ 
					$this->cidades_model->deletar($id); /* model deletar noticia*/
				}
		} 
		$error = "Selected countries (id's: ".$this->input->post('ids_delete').") deleted with success";
		$this->output->set_header($this->config->item('ajax_header'));
		$this->output->set_output($error);
    }
        
       
      
        
}
