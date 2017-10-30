<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demanda extends CI_Controller {

	function __construct(){
		parent::__construct();
		
		// ACESSO RESTRITO
		$this->login_model->restrito();

        $this->load->model(array('empresa_model', 'demanda_model', 'endereco_model','estado_model'));
		$this->load->library(array('form_validation','util','upload','pagination'));
		$this->_init();
	}

    private function _init(){  
		     
		/****** Pluguin Calendário Input **************/
        $this->load->css('painel/assets/pluguins/datepicker/css/bootstrap-datepicker.min.css');
        $this->load->js('painel/assets/pluguins/datepicker/js/bootstrap-datepicker.min.js');
        $this->load->js('painel/assets/pluguins/datepicker/locales/bootstrap-datepicker.pt-BR.min.js');
			
		$this->load->css('painel/assets/pluguins/jasny-bootstrap/css/jasny-bootstrap.min.css');
		$this->load->js('painel/assets/pluguins/jasny-bootstrap/js/jasny-bootstrap.min.js');
		
        /****** Busca cep **************/
        $this->load->js('painel/assets/pluguins/buscacep.js');
           
        
         $this->output->set_template('default');
       
	}
        
	public function index(){
	   
		// Geradora
        if ($this->session->userdata['empresa']['funcao']==1){ 
		   
			$dados['demandas'] = $this->demanda_model->lista_demandasbyid($this->session->userdata['empresa']['id']);
			
			$this->output->set_common_meta('Demandas da Geradora de Resíduos','',''); 
            $dados['menu_opcao_direita'][] = anchor(
				'demanda/add',
				'<i class="fa fa-fw fa-plus"></i> Nova Demanda',
				'class="btn btn-primary btn-sm not-focusable" data-toggle="tooltip" title="Clique aqui para cadastrar uma demanda"'
			);

			$dados['url_ajax'] = site_url('demanda/get_list');

        } else
        if ($this->session->userdata['empresa']['funcao']==2){

			$row = $this->empresa_model->get_row_empresa($this->session->userdata['empresa']['id']);
			
            $nome_estado = $this->estado_model->busca_nomeestadobyuf($row->uf_estado);
            $data['local'] = $nome_estado;
                  
                  
            if ($this->input->get('cidade')){
			   
				$this->load->model('cidade_model');
				$cidade = $this->cidade_model->getcidadebyid($this->input->get('cidade'));
				
				//$dados['demandas'] = $this->demanda_model->lista_demandasbycidade($this->session->userdata['empresa']['id_cidade']);
				
				$this->output->set_common_meta('Demandas para Coleta em '.$cidade->nome_cidade.'/'.$cidade->uf,'',''); 
				
            }else{

				$this->output->set_common_meta('Demandas para Coleta em '.$nome_estado,'',''); 

			}

			/*
			* Montamos a url para o ajax
			*/
			$url_ajax = 'demanda/get_list';
			if($this->input->get('estado')){
				$url_ajax.='?estado='.$this->input->get('estado');
			}
			if($this->input->get('cidade')){
				$url_ajax.='&cidade='.$this->input->get('cidade');
			}
			$dados['url_ajax'] = site_url($url_ajax);
			

            $dados['menu_opcao_direita'][] = anchor(
				'demanda/?estado='.$row->uf_estado.'&cidade='.$row->id_cidade, 
				'<i class="fa fa-fw fa-map-marker"></i> da Minha Cidade', 
				'class="btn btn-primary btn-sm not-focusable" data-toggle="tooltip" title="Clique para listar as demandas da sua cidade"'
			);
            $dados['menu_opcao_direita'][] = anchor(
				'demanda/?estado='.$row->uf_estado,
				'<i class="fa fa-fw fa-map-marker"></i> do meu Estado',
				'class="btn btn-primary btn-sm not-focusable" data-toggle="tooltip" title="Clique para listar as demandas do meu Estado"'
			);
        } 
            
      	$this->load->view('demanda/index',$dados);
	}


	public function get_list(){
		
		$this->output->unset_template();

		$data = array();
		$result = array();
		$where = '';
		$prefix = '';
		$id_empresa = $this->session->userdata['empresa']['id'];

		if($this->session->userdata['empresa']['funcao']==1){ // 1 Geradora
			$where.= " d.ger_id_empresa = '".(int)$id_empresa."' and  ";
		}else
		if($this->session->userdata['empresa']['funcao']==2){ // 2 Coletora

			if($this->input->get('cidade')){
				$where.= " d.ger_id_cidade = '".(int)$this->input->get('cidade')."' and  ";
				$prefix = '?estado='.$this->input->get('estado').'&cidade='.$this->input->get('cidade');
			}else
			if($this->input->get('estado')){
				$where.= " d.ger_uf_estado = '".$this->input->get('estado')."' and  ";
				$prefix = '/?estado='.$this->input->get('estado');
			}
		}
		
		$config = array(
			"base_url" => base_url('demanda/get_list/'),
			"reuse_query_string" => true,
			"per_page" => 5, //Quantiade de registros litados
			"uri_segment" => 3, //URI a ser pegado para identificar a página a ser visualizada
			"total_rows" => $this->demanda_model->get_result_demandas_empresa_id($id_empresa,$where,true)->num_rows(),
			"first_link" => TRUE,
			"last_link" => TRUE
		);

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['result'] = $this->demanda_model->get_result_demandas_empresa_id($id_empresa,$where,false,'d.cadastrada','desc',$config['per_page'],$offset)->result();
		
		$this->load->view('demanda/list',$data);
	}
        
    
	public function add(){
		
		//Title / Description / Tags
		$this->output->set_common_meta('Cadastrar Demanda','',''); 
		
		// dados da empresa geradora
		$id_empresa = (int) $this->session->userdata['empresa']['id'];
		
		$row = $this->empresa_model->consultar_coletoraId($id_empresa);
		if (!$row) {
			$this->session->set_flashdata('resposta_erro', 'Empresa não identificada.');
			redirect(site_url('demanda'));
		}
	            
		/* Dados Demanda ********************/
		$data['atualizada'] = '';
		$data['removida'] = '';
		
		$data['data_inicio'] = '';
		$data['data_validade'] = '';
		$data['status'] = '';
		$data['img_capa'] = base_url('painel/assets/img/demanda_sem_img.jpg');
		$data['responsavel'] = $row->nome_responsavel;
		$data['residuo'] = '';
		$data['acondicionado'] = '';
		$data['qtd'] = '';
		$data['uni_medida'] = '';
		$data['obs'] = '';
		
		/* Dados Empresa Geradora ********************/
		$data['ger_telefone1'] = $row->telefone1;
		$data['ger_telefone2'] = $row->telefone2;
		$data['ger_email'] = $row->email;
		
		$data['ger_cep'] = $row->cep;
		$data['ger_logradouro'] = $row->logradouro;
		$data['ger_numero'] = $row->numero;
		$data['ger_complemento'] = $row->complemento;
		$data['ger_bairro'] = $row->bairro;
		$data['ger_id_cidade'] = $row->id_cidade;
		$data['ger_uf_estado'] = $row->uf_estado;	
		
		// Buscamos medidas para montar o select
		$data['medidas'] = $this->demanda_model->get_all_medidas(); 
		
		// Buscamos acondifionamento para montar o select
		$data['acondicionamentos'] = $this->demanda_model->get_all_acondicionamentos();
		
		// Listamos todos estados normalmente
		$data['estados'] = $this->endereco_model->get_all_estados(); 
		
		$uf = ($this->input->post('estado') ? $this->input->post('estado') : $row->uf_estado);
		$data['cidades'] = $this->endereco_model->get_all_cidades($uf); //<-UF no EDIT pra listar apenas a cidades do estado selecionado

		$data['action'] = site_url('demanda/form_post');
		
		$data['menu_mapa'] = array(
			'Demandas' => $this->uri->segment(1),
			'Cadastrar' => ''
		);

		$data['menu_opcao_direita'][] = anchor(
			'demanda', 
			'<i class="fa fa-fw fa-undo"></i> Voltar', 
			'class="btn btn-info btn-sm not-focusable"'
		);
		$this->load->view('demanda/form_cad_demanda',$data);
	}


	
	public function edit($id){
		
		//Title / Description / Tags
		$this->output->set_common_meta('Cadastrar Demanda','',''); 
		
		$id_empresa = (int) $this->session->userdata['empresa']['id'];
		
		$row = $this->demanda_model->get_row_demanda($id);

		if($id_empresa!=$row->ger_id_empresa){
			$this->session->set_flashdata('resposta_erro', 'Acesso negado para atualizar demanda.');
			redirect(site_url('demanda'));
		}
	            
		/* Dados Demanda ********************/
		$data['id'] = $id;
		$data['data_inicio'] = date('d/m/Y', strtotime(str_replace("/","-",$row->data_inicio)));
		$data['data_validade'] = date('d/m/Y', strtotime(str_replace("/","-",$row->data_validade)));
		$data['status'] = $row->status;
		$img = 'uploads/empresa/'.$row->ger_id_empresa.'/demanda/mini/'.$row->img;
		if(is_file($img)){
			$data['img_capa'] = base_url($img);
		}else{
			$data['img_capa'] = base_url('painel/assets/img/demanda_sem_img.jpg');
		}
		$data['responsavel'] =  $row->responsavel;
		$data['residuo'] =  $row->residuo;
		$data['acondicionado'] =  $row->acondicionado;
		$data['qtd'] =  $row->qtd;
		$data['uni_medida'] =  $row->uni_medida;
		$data['obs'] = $row->obs;
		
		/* Dados Empresa Geradora ********************/
		$data['ger_telefone1'] = $row->ger_telefone1;
		$data['ger_telefone2'] = $row->ger_telefone2;
		$data['ger_email'] = $row->ger_email;
		
		$data['ger_cep'] = $row->ger_cep;
		$data['ger_logradouro'] = $row->ger_logradouro;
		$data['ger_numero'] = $row->ger_numero;;
		$data['ger_complemento'] = $row->ger_complemento;;
		$data['ger_bairro'] = $row->ger_bairro;
		$data['ger_id_cidade'] = $row->ger_id_cidade;
		$data['ger_uf_estado'] = $row->ger_uf_estado;	
		

		// Buscamos medidas para montar o select
		$data['medidas'] = $this->demanda_model->get_all_medidas(); 
		
		// Buscamos acondifionamento para montar o select
		$data['acondicionamentos'] = $this->demanda_model->get_all_acondicionamentos();

		// Listamos todos estados normalmente
		$data['estados'] = $this->endereco_model->get_all_estados(); 
		
		$uf = ($this->input->post('estado') ? $this->input->post('estado') : $row->ger_uf_estado);
		$data['cidades'] = $this->endereco_model->get_all_cidades($uf); //<-UF no EDIT pra listar apenas a cidades do estado selecionado
		
		$data['menu_mapa'] = array(
			'Demandas' => $this->uri->segment(1),
			'Cadastrar' => ''
		);

		$data['menu_opcao_direita'][] = anchor(
			'demanda', 
			'<i class="fa fa-fw fa-undo"></i> Voltar', 
			'class="btn btn-info btn-sm not-focusable"'
		);

		$data['action'] = site_url('demanda/form_post/'.$id);

		$this->load->view('demanda/form_cad_demanda',$data);
	}
	
	
	public function form_post($id_update=''){
		
		$this->output->unset_template();
		
		if($this->input->post()){
			
			$id_empresa = (int) $this->session->userdata['empresa']['id'];
			
			$nome_imagem_server = NULL;

			$redirect = false;
			$erro = false;
			
			// validação dos campos
			$json = $this->validar_form_demanda();
			
			// Não temos Erro / Vamos fazer upload da imagem
			if(!$json && $_FILES['img']['tmp_name']) {
				// Config upload
				$valid = array();

				$upload_path = './uploads/empresa/'.$id_empresa.'/demanda';

				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
				$config['file_name'] = date('YmdHi') . '_' . rand(1000, 9999); // Data Upload / ID empresa / Rand entre 1000 e 9999 
				$config['max_filename_increment'] = 300;
				$config['max_size'] = 5120; //(5*5120kb) = 5MB
				$config['max_width'] = 5024;
				$config['max_height'] = 5068;
				
				$upload_img = $this->demanda_model->valid_upload_img($config);
				
				if($upload_img['erro']){	
					$json['error'] = $json['error_img']  = $upload_img['erro'];
				}else{
				 	$nome_imagem_server = $upload_img['img'];		
				}
			}
			
        	if(!$json) {
				
				$data_inicio = ($this->input->post('data_inicio')?date('Y-m-d', strtotime(str_replace("/","-",$this->input->post('data_inicio')))):'');
				$data_validade = ($this->input->post('data_validade')?date('Y-m-d', strtotime(str_replace("/","-",$this->input->post('data_validade')))):'');
				
				$data = array(
					//informações do resíduo
					'atualizada' => date('Y-m-d H:i:s'),
					'data_inicio' => $data_inicio,
					'data_validade' => $data_validade,
					
					'responsavel' => $this->input->post('responsavel'), 
					'residuo' => $this->input->post('residuo'),
					'acondicionado' => $this->input->post('acondicionado'),
					'qtd' => $this->input->post('qtd'),
					'uni_medida' => $this->input->post('uni_medida'),
					'obs' => $this->input->post('obs'),
					
					// Dados da empresa Geradora (solicitou demanda)
					'ger_id_empresa' => $id_empresa,
					'ger_telefone1' => $this->input->post('ger_telefone1'),
					'ger_telefone2' => $this->input->post('ger_telefone2'),
					'ger_email' => $this->input->post('ger_email'),
					
					'ger_cep' => $this->input->post('ger_cep'),
					'ger_logradouro' => $this->input->post('ger_logradouro'),
					'ger_numero' => $this->input->post('ger_numero'),
					'ger_complemento' => $this->input->post('ger_complemento'),
					'ger_bairro' => $this->input->post('ger_bairro'),
					'ger_id_cidade' => $this->input->post('ger_id_cidade'),
					'ger_uf_estado' => $this->input->post('ger_uf_estado')
				);
				
				if($id_update){
					//Deletar Imagem atual da demanda
					if($_FILES['img']['tmp_name']){
						$this->demanda_model->delete_img($id_update);
					}
					$this->demanda_model->update($data, $nome_imagem_server, $id_update, $id_empresa);
					/*********************************************************************
					 *		Aqui podemos fazer o envio de email Demanda Atualizada 		 *
					* ********************************************************************/
					$this->session->set_flashdata('resposta_ok','Demanda <strong>'.$this->input->post('residuo').'</strong> atualizada com sucesso.');	
				}else{	
					$id_demanda = $this->demanda_model->insert($data,$nome_imagem_server);
					/********************************************************************
					 *		Aqui podemos fazer o envio de email	Demanda Cadastrada		*
					* *******************************************************************/
					$this->session->set_flashdata('resposta_ok','Demanda <strong>'.$this->input->post('residuo').'</strong> cadastrada com sucesso.');
				}	
				$json['ok'] = true;
				$json['redirect'] = site_url('demanda');

			}
		}
		
		echo json_encode($json);
	}


	public function delete($id){
		$this->output->unset_template();

		$id_empresa = $this->session->userdata['empresa']['id'];
		$row = $this->demanda_model->get_row_demanda($id);

		if($id_empresa!=$row->ger_id_empresa){
			
			$this->session->set_flashdata('resposta_erro', 'Acesso negado para remover demanda.');
			redirect(site_url('demanda'));
		
		}else{

			$this->demanda_model->delete($id,$id_empresa);

			$this->session->set_flashdata('resposta_erro','Demanda removida com sucesso.');
			redirect(site_url('demanda'));
		}
	}
	
	
	private function validar_form_demanda(){
		
		$json = array();
		$this->load->library(array('util'));
		
		if(!$this->input->post('ger_uf_estado')) {
           $json['error'] = $json['error_ger_uf_estado'] = 'Selecione o estado';
		}
		
		if(!$this->input->post('ger_id_cidade')) {
           $json['error'] = $json['error_ger_id_cidade'] = 'Selecione a cidade';
		}
		
		if(!$this->input->post('ger_bairro')) {
           $json['error'] = $json['error_ger_bairro'] = 'Digite o nome do bairro';
		}
		
		if(!$this->input->post('ger_numero')) {
           $json['error'] = $json['error_ger_numero'] = 'Digite o número do endereço';
		}
		
		if(!$this->input->post('ger_logradouro')) {
           $json['error'] = $json['error_ger_logradouro'] = 'Digite o nome da rua';
		}
		
		if(!$this->input->post('ger_cep')) {
            $json['error'] = $json['error_ger_cep'] = 'Digite o CEP';
		}else
		if(strlen(preg_replace("/[^0-9]/", "",$this->input->post('ger_cep')))<8){
		 	$json['error'] = $json['error_ger_cep'] = 'Digite o CEP com 8 digitos';
   		}
		
		if(!$this->input->post('ger_telefone1')) {
           $json['error'] = $json['error_ger_telefone1'] = 'Um número de telefone de contato';
		}
		
		if(!$this->input->post('ger_email')) {
           $json['error'] = $json['error_ger_email'] = 'Digite seu e-mail para notificação';
		}
		
		$nome_responsavel = explode(' ',$this->input->post('responsavel'));

		if(!$this->input->post('responsavel')) {
           $json['error'] = $json['error_responsavel'] = 'Digite o nome do responsável pela demanda';
		}else
		if(empty($nome_responsavel[1])){
			$json['error'] = $json['error_responsavel'] = 'Digite o nome completo do responsável pela demanda';	
		}
		
		if(!$this->input->post('obs')) {
           $json['error'] = $json['error_obs'] = 'Digite uma informação complementar';
		}
		
		if(!$this->input->post('data_validade') or strlen(preg_replace("/[^0-9]/", "",$this->input->post('data_validade')))<8) {
           $json['error'] = $json['error_data_validade'] = 'Digite a data de validade';
		}else
		if($this->util->ValidaData($this->input->post('data_validade'))==false){
			$json['error'] = $json['error_data_validade'] = 'Data de validade inválida';
		}else
		if(date('Y-m-d', strtotime(str_replace("/","-",$this->input->post('data_inicio')))) > date('Y-m-d', strtotime(str_replace("/","-",$this->input->post('data_validade')))) ){
			$json['error'] = $json['error_data_validade'] = 'A data de início não pode ser maior que a data de expiração';
		}
		
		if(!$this->input->post('data_inicio') or strlen(preg_replace("/[^0-9]/", "",$this->input->post('data_inicio')))<8) {
           $json['error'] = $json['error_data_inicio'] = 'Digite a data para o início da divulgação';
		}else
		if($this->util->ValidaData($this->input->post('data_inicio'))==false){
			$json['error'] = $json['error_data_inicio'] = 'Data início inválida';
		}else
		if(date('Y-m-d', strtotime(str_replace("/","-",$this->input->post('data_inicio'))) ) < date('Y-m-d') ){
			$json['error'] = $json['error_data_inicio'] = 'A data de início não pode ser menor que a data de hoje: '.date('d/m/Y');
		}
		
		if(!$this->input->post('uni_medida')) {
           $json['error'] = $json['error_uni_medida'] = 'Selecione a undiade de medida';
		}
		
		if(!$this->input->post('qtd')) {
           $json['error'] = $json['error_qtd'] = 'Digite a quantidade';
		}
		
		if(!$this->input->post('acondicionado')) {
           $json['error'] = $json['error_acondicionado'] = 'Selecione opção de como o resíduo está condidionado';
		}
		
		if(!$this->input->post('residuo')) {
           $json['error'] = $json['error_residuo'] = 'Especifique o resíduo';
		}
			
		return $json;
		
	}

	

}