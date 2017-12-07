<?php
header('Content-Type: text/html; charset=utf-8');
defined('BASEPATH') OR exit('No direct script access allowed');

class Demanda extends CI_Controller {

    function __construct() {
        parent::__construct();

        // ACESSO RESTRITO
        $this->login_model->restrito();

        $this->load->model(array('empresa_model', 'demanda_model', 'endereco_model', 'estado_model', 'proposta_model', 'destinacao_model', 'cidade_model'));
        $this->load->library(array('form_validation', 'util', 'upload', 'pagination'));
        $this->_init();
    }

    private function _init() {

        /*         * **** Pluguin Calendário Input ************* */
        $this->load->css('painel/assets/pluguins/datepicker/css/bootstrap-datepicker.min.css');
        $this->load->js('painel/assets/pluguins/datepicker/js/bootstrap-datepicker.min.js');
        $this->load->js('painel/assets/pluguins/datepicker/locales/bootstrap-datepicker.pt-BR.min.js');

        $this->load->css('painel/assets/pluguins/jasny-bootstrap/css/jasny-bootstrap.min.css');
        $this->load->js('painel/assets/pluguins/jasny-bootstrap/js/jasny-bootstrap.min.js');
		
		//fancybox
		$this->load->js('painel/assets/pluguins/fancybox/source/jquery.fancybox.js');
		$this->load->css('painel/assets/pluguins/fancybox/source/jquery.fancybox.css');

        /*         * **** Busca cep ************* */
        $this->load->js('painel/assets/pluguins/buscacep.js');


        $this->output->set_template('default');
    }

    public function index() {

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
				 
			 }else if ($this->input->get('estado')){
				 
				 $this->output->set_common_meta('Demandas para Coleta em '.$this->input->get('estado'),'',''); 
				 
			 }else if ($this->input->get('propostas')){
				 
				 $this->output->set_common_meta('Demandas que Enviei Proposta','','');
 
			 } else if ($this->input->get('propostas_aceitas')){
 
				 $this->output->set_common_meta('Demandas com Proposta Aceita','','');
 
			 } else{
				 
				 $this->output->set_common_meta('Demandas para Coleta','',''); 
				 
			 }
			 
			 /*
			 * Montamos a url para o ajax
			 */
			 $url_ajax = 'demanda/get_list/?';
			 if($this->input->get('cidade')){
				 $url_ajax.='&cidade='.$this->input->get('cidade');
			 }
			 if($this->input->get('estado')){
				 $url_ajax.='&estado='.$this->input->get('estado');
			 }
			 if($this->input->get('status')){
				 $url_ajax.='&status='.$this->input->get('status');
			 }
			 if($this->input->get('categoria')){
				 $url_ajax.='&categoria='.$this->input->get('categoria');
			 }
			 if($this->input->get('propostas')){
				 $url_ajax.='&propostas='.$this->input->get('propostas');
			 }if($this->input->get('propostas_aceitas')){
				 $url_ajax.='&propostas_aceitas='.$this->input->get('propostas_aceitas');
			 }
			 $dados['url_ajax'] = site_url($url_ajax);
			 
			 $dados['menu_opcao_direita'][] = anchor(
				 'demanda?propostas=1',
				 '<i class="fa fa-fw fa-handshake-o"></i> Propostas Enviadas',
				 'class="btn btn-info btn-sm not-focusable" data-toggle="tooltip" title="Listar as demandas que enviei proposta"'
			 );
 
			 $dados['menu_opcao_direita'][] = anchor(
				 'demanda?propostas_aceitas=1',
				 '<i class="fa fa-fw fa-thumbs-o-up"></i> Propostas Aceitas',
				 'class="btn btn-info btn-sm not-focusable" data-toggle="tooltip" title="Listar as demandas que minha proposta foi aceita"'
			 );
 
			 $dados['menu_opcao_direita'][] = anchor(
				 'demanda/',
				 '<i class="fa fa-fw fa-list"></i>',
				 'class="btn btn-primary btn-sm not-focusable" data-toggle="tooltip" title="Listar todas as demandas"'
			 );
 
			 $dados['menu_opcao_direita'][] = anchor(
				 'demanda/modal_filtro',
				 '<i class="fa fa-fw fa-filter"></i>',
				 'class="btn btn-primary btn-sm not-focusable" rel="modal_add_edit" data-toggle="tooltip" title="Filtrar as demandas"'
			 );
			 
		 } 
		 
		   $this->load->view('demanda/index',$dados);
    }

    public function get_list() {

        $this->output->unset_template();
		
				$data = array();
				$result = array();
				$where = '';
				$prefix = '';
				$id_empresa = $this->session->userdata['empresa']['id'];
				$list_propostas = '';
		
				if($this->session->userdata['empresa']['funcao']==1){ // 1 Geradora
					$where.= " d.ger_id_empresa = '".(int)$id_empresa."' and  ";
				}else
				if($this->session->userdata['empresa']['funcao']==2){ // 2 Coletora
					if($this->input->get('cidade')){
						$where.= " d.ger_id_cidade = '".(int)$this->input->get('cidade')."' and  ";
						$prefix = '&estado='.$this->input->get('estado').'&cidade='.$this->input->get('cidade');
					}
					/*if($this->input->get('status')){
						$where.= " d.status = ".$this->input->get('status')." and  ";
						$prefix = '&status='.$this->input->get('status');
					}*/
					if($this->input->get('estado')){
						$where.= " d.ger_uf_estado = '".$this->input->get('estado')."' and  ";
						$prefix = '&estado='.$this->input->get('estado');
					}
					if($this->input->get('categoria')){
						$where.= " d.id_cat_residuo = ".$this->input->get('categoria')." and  ";
						$prefix = '&categoria='.$this->input->get('categoria');
					}
					//caso o gerador queira listar somente demandas que ele enviou proposta
					if($this->input->get('propostas')){
						$list_propostas = " join propostas as prp on (d.id = prp.id_demanda) and (prp.id_empresa_coletora = ".$id_empresa.") ";
						$where.= " d.status = 2 and  ";
						$prefix = '&propostas='.$this->input->get('propostas');
					} else if($this->input->get('propostas_aceitas')){
						$list_propostas = " join propostas as prp on (d.id = prp.id_demanda) and (prp.id_empresa_coletora = ".$id_empresa.") and (prp.aceita = 'Sim') ";
						$prefix = '&propostas_aceitas='.$this->input->get('propostas_aceitas');
					}else{
						$where.= " d.status = 2 and ";
					}
				}
				
				$config = array(
					"base_url" => base_url('demanda/get_list/'),
					"reuse_query_string" => true,
					"per_page" => 5, //Quantiade de registros litados
					"uri_segment" => 3, //URI a ser pegado para identificar a página a ser visualizada
					"total_rows" => $this->demanda_model->get_result_demandas_empresa_id($id_empresa,$where,true,$list_propostas)->num_rows(),
					"first_link" => TRUE,
					"last_link" => TRUE
				);
		
				$this->pagination->initialize($config);
				$data['pagination'] = $this->pagination->create_links();
				$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				$data['result'] = $this->demanda_model->get_result_demandas_empresa_id($id_empresa,$where,false,$list_propostas,'d.cadastrada','desc',$config['per_page'],$offset)->result();
				
				$this->load->view('demanda/list',$data);
    }

    /*
	*	Página Adicionar Demanda
	*/
	public function add(){
		
		//Title / Description / Tags
		$data['title'] = 'Cadastrar Demanda';
		$this->output->set_common_meta($data['title'],'',''); 
		
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
		
		$data['data_inicio'] = date('d/m/Y');
		$data['data_validade'] = '';
		$data['status'] = '';
		$data['img_capa'] = base_url('painel/assets/img/demanda_sem_img.jpg');
		$data['responsavel'] = $row->nome_responsavel;
		$data['residuo'] = '';
		$data['categoria_residuo'] = '';
		$data['acondicionado'] = '';
		$data['acondicionado_outro'] = '';
		$data['qtd'] = '';
		$data['uni_medida'] = '';
		$data['uni_medida_outro'] = '';
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

		// Listar categorias 
		$data['categorias_residuos'] = $this->demanda_model->get_result_categorias_residuos();
		
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
		$data['title'] = 'Atualizar Demanda #'.$id;
		$this->output->set_common_meta($data['title'],'',''); 
		
		$id_empresa = (int) $this->session->userdata['empresa']['id'];
		
		$row = $this->demanda_model->get_row_demanda($id);

		if($id_empresa!=$row->ger_id_empresa || $row->status!=6){
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
			$data['img_media'] = base_url('uploads/empresa/'.$row->ger_id_empresa.'/demanda/media/'.$row->img);
		}else{
			$data['img_capa'] = base_url('painel/assets/img/demanda_sem_img.jpg');
			$data['img_media'] = '';
		}
		$data['responsavel'] =  $row->responsavel;
		$data['residuo'] =  $row->residuo;
		$data['categoria_residuo'] = $row->categoria_residuo;
		$data['acondicionado'] =  $row->acondicionado;
		$data['acondicionado_outro'] =  $row->acondicionado_outro;
		$data['qtd'] =  $row->qtd;
		$data['uni_medida'] =  $row->uni_medida;
		$data['uni_medida_outro'] =  $row->uni_medida_outro;
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

		// Listar categorias 
		$data['categorias_residuos'] = $this->demanda_model->get_result_categorias_residuos();
		
		$uf = ($this->input->post('estado') ? $this->input->post('estado') : $row->ger_uf_estado);
		$data['cidades'] = $this->endereco_model->get_all_cidades($uf); //<-UF no EDIT pra listar apenas a cidades do estado selecionado
		
		$data['menu_mapa'] = array(
			'Demandas' => $this->uri->segment(1),
			'Cadastrar' => ''
		);
			  
		$data['menu_opcao_direita'][] = '
		<a href="javascript:window.history.go(-1)" class="btn btn-info btn-sm not-focusable" >
			<i class="fa fa-fw fa-undo"></i> Voltar
		</a>';

		$data['action'] = site_url('demanda/form_post/'.$id);

		$this->load->view('demanda/form_cad_demanda',$data);
	}

    public function modal_filtro() {
        $this->output->unset_template();
        $data = array();
        $data['title'] = "Filtrar Demandas";

        // dados da empresa geradora
        $id_empresa = (int) $this->session->userdata['empresa']['id'];

        $row = $this->empresa_model->consultar_coletoraId($id_empresa);
        if (!$row) {
            $this->session->set_flashdata('resposta_erro', 'Empresa não identificada.');
            redirect(site_url('demanda'));
        }

        $data['col_id_cidade'] = $row->id_cidade;
        $data['col_uf_estado'] = $row->uf_estado;

        // Listamos todos estados normalmente
        $data['estados'] = $this->endereco_model->get_all_estados();

        $uf = ($this->input->post('estado') ? $this->input->post('estado') : $row->uf_estado);
        $data['cidades'] = $this->endereco_model->get_all_cidades($uf); //<-UF no EDIT pra listar apenas a cidades do estado selecionado
        // Categorias de resíduos 
        $data['categorias_residuos'] = $this->demanda_model->get_categorias_residuos();

        // Status de demandas 
        $data['demandas_status'] = $this->demanda_model->get_demandas_status();

        $this->load->view('demanda/filtro', $data);
    }

   public function form_post($id_update=''){
		
		$this->output->unset_template();
		$json = array();
		if($this->input->post()){
			
			$id_empresa = (int) $this->session->userdata['empresa']['id'];
			
			$nome_imagem_server = NULL;

			$redirect = false;
			$erro = false;
			
			// validação dos campos
			$json = $this->validar_form_demanda($id_update);
			
			// Não temos Erro / Vamos fazer upload da imagem
			if(!$json and $_FILES['img']['tmp_name']) {
				// Config upload
				$valid = array();

				$upload_path = './uploads/empresa/'.(int)$id_empresa.'/demanda';

				//Verifica se a pasta da empresa existe
				if(!is_dir('uploads/empresa/'.(int)$id_empresa)){
					mkdir('uploads/empresa/'.(int)$id_empresa);
				}

				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';
				$config['file_name'] = date('YmdHi') . '_' . rand(1000, 9999); // Data Upload / ID empresa / Rand entre 1000 e 9999 
				$config['max_filename_increment'] = 300;
				$config['max_size'] = 10240; //(10*1024kb) = 10MB
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
				
				$acondicionado_outro = ($this->input->post('acondicionado')==0?$this->input->post('acondicionado_outro'):NULL);
				$uni_medida_outro = ($this->input->post('uni_medida')==0?$this->input->post('uni_medida_outro'):NULL);
				
				$data = array(
					//informações do resíduo
					'atualizada' => date('Y-m-d H:i:s'),
					'data_inicio' => $data_inicio,
					'data_validade' => $data_validade,
					'status' => 2,
					
					'responsavel' => $this->input->post('responsavel'), 
					'residuo' => $this->input->post('residuo'),
					'categoria_residuo' => $this->input->post('categoria_residuo'),
					'acondicionado' => $this->input->post('acondicionado'),
					'acondicionado_outro' => $acondicionado_outro,
					'qtd' => $this->input->post('qtd'),
					'uni_medida' => $this->input->post('uni_medida'),
					'uni_medida_outro' => $uni_medida_outro,
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
					if(isset($_FILES['img']['tmp_name'])){
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

    /*
     * 	Visualizar demanda
     */

    public function visualizar($id_demanda) {
//teste
        $data = array();
        $data['title'] = 'Demanda #' . $id_demanda;

        //Title / Description / Tags
        $this->output->set_common_meta($data['title'], '', '');

        $data['menu_mapa'] = array(
            'Demandas' => $this->uri->segment(1),
            'Visualizar' => ''
        );

        $data['hoje'] = date("Y-m-d");

        $row = $this->demanda_model->get_row_demanda_ver($id_demanda);
        $data['row'] = $row;

        if ($this->input->post('validade'))
            $data['tab_ativa'] = 'proposta';
        else
            $data['tab_ativa'] = 'demanda';

        $data['menu_opcao_direita'][] = '
			<a href="javascript:window.history.go(-1)" class="btn btn-info btn-sm not-focusable" >
				<i class="fa fa-fw fa-undo"></i> Voltar
			</a>';

        // mostra os botoes de controle de demanda somente se for geradora
        if ($this->session->userdata['empresa']['funcao'] == 1) {

            if ($row['status'] == 6) {
                $data['menu_opcao_direita'][] = '
                            <a href="' . site_url('demanda/edit/' . $row['id']) . '" class="btn btn-warning btn-sm not-focusable" >
                                    <i class="fa fa-fw fa-pencil-square-o"></i> Atualizar
                            </a>';
			}

			
			
			$data['menu_opcao_direita'][] = '
			<a rel="modal_add_edit" data-target="" data-toggle="tooltip" title="Remover Demanda" class="btn btn-sm btn-danger" href="'.site_url('demanda/delete/'.$row['id']).'">
					<i class="fa fa-close" ></i> Remover 
			</a>';

            /*$data['menu_opcao_direita'][] = '
				<a href="javascript:vid(0)" title="Remover Demanda ' . $row['residuo'] . ' ? " rel="' . site_url('demanda/delete/' . $row['id']) . '" class="btn btn-sm btn-danger remover" >
						<i class="fa fa-close" ></i> Remover 
				</a>';*/
        }

        if ($this->session->userdata['empresa']['funcao'] == 2) {

            $data['tab_proposta'] = 'Enviar Proposta';

            // salva local de destinação final se o post for do btsalvalocal
            if ($this->input->post('btsalvarlocal')) {
                $data4['id_demanda'] = $this->input->post('id_demanda');
                $data4['id_empresa_coletora'] = $this->input->post('id_empresa_coletora');
                $data4['cep'] = $this->input->post('cep');
                $data4['rua'] = $this->input->post('rua');
                $data4['numero'] = $this->input->post('numero');
                $data4['complemento'] = $this->input->post('complemento');
                $data4['bairro'] = $this->input->post('bairro');
                $data4['uf_estado'] = $this->input->post('estado');
                $data4['id_cidade'] = $this->input->post('cidade');
                $data4['obs'] = $this->input->post('obs');

                $this->destinacao_model->gravar($data4);
            }

            // se estiver cancelando uma proposta
            if ($this->input->post('btcancelar')) {
                $id_proposta = $this->input->post('id_proposta');
                $motivo_remocao = $this->input->post('motivo_cancelamento');
                $this->proposta_model->delete($id_proposta, $motivo_remocao);
                $this->session->set_flashdata('msg_proposta', "Proposta cancelada com sucesso.");
            } else {
                // caso o formulário de proposta esteja setado no post
                if ($this->input->post('validade')) {

                    $dados['cobranca'] = $this->input->post('cobranca');
                    $dados['id_empresa_coletora'] = $this->session->userdata['empresa']['id'];
                    $dados['id_demanda'] = $id_demanda;
                    $dados['valor'] = str_replace('.','',$this->input->post('valor_coleta'));
                    $dados['valor'] = floatval(str_replace(',','.',$dados['valor']));
                    $dados['frete'] = str_replace('.','',$this->input->post('valor_frete'));
                    $dados['frete'] = floatval(str_replace(',','.',$dados['frete']));
                    $dados['qtde_viagens'] = $this->input->post('qtde_viagens');
                    $dados['total'] = str_replace('.','',$this->input->post('valor_total'));
                    $dados['total'] = floatval(str_replace(',','.',$dados['total']));
                    $dados['condicoes_pagamento'] = $this->input->post('condicoes');
                    $dados['prazo_coleta'] = $this->input->post('prazo');
                    $validade = str_replace("/", "-", $this->input->post('validade'));
                    $validade = date('Y-m-d', strtotime($validade));
                    $dados['validade_proposta'] = $validade;
                    $dados['observacoes'] = $this->input->post('obs');
                    $dados['aceita'] = 'Não';

                    $this->form_validation->set_rules('cobranca', 'cobranca', 'required');

                    if ($this->form_validation->run() == TRUE) {
                        $this->proposta_model->salvar($dados);
                        $this->session->set_flashdata('msg_proposta', "Proposta cadastrada com sucesso.");
                    } else
                        $this->session->set_flashdata('msg_proposta', "Erro ao cadastrar proposta.");
                }
            }


            $data2 = $this->proposta_model->getrow($id_demanda, $this->session->userdata['empresa']['id']);
            $data2['qtd'] = $data['row']['qtd']; // pega quantidade cadastrada na demanda para usar no formulário proposta
            $data2['uni_medida'] = $this->demanda_model->get_abrev_unidade_medida($data['row']['uni_medida']); // pega unidade de medida do banco para usar no formulário proposta
            if (isset($data2['aceita']) && ($data2['aceita'] == 'Sim')){
                $data['tab_proposta'] = 'Proposta Aceita';
                $this->session->set_flashdata('msg_proposta', "<b>Parabéns!</b> A proposta foi aceita.");
            }    
            $this->load->view('demanda/ver', $data);
            $this->load->view('proposta/proposta', $data2);
        }else {
            //verifica se demanda já tem proposta aceita
            $proposta_aceita = $this->proposta_model->consultar_proposta_aceita($id_demanda);
            if (!$proposta_aceita) {
                //listar as propostas recebidas se ainda nenhuma foi aceita
                $data['propostas'] = $this->proposta_model->get_proposta($id_demanda);
                $data['tab_proposta'] = 'Propostas Recebidas';
                $this->load->view('demanda/ver', $data);
                $this->load->view('proposta/lista_propostas', $data);
            } else {
                //listar somente a proposta aceita
                $data['propostas'] = $proposta_aceita;
                $data['tab_proposta'] = 'Proposta Aceita';
                $this->load->view('demanda/ver', $data);
                $this->load->view('proposta/lista_propostas', $data);
            }
        }


        $data3 = $this->destinacao_model->getrow($id_demanda);
        if ($data3['id_cidade'])
            $data3['nome_cidade'] = $this->cidade_model->getnomecidadebyid($data3['id_cidade']);
        $data3['estados'] = $this->estado_model->lista_estados();
        $data3['id_demanda'] = $id_demanda;

        
        if ((isset($data2['aceita']) && ($data2['aceita'] == 'Sim')) || (isset($proposta_aceita)) )
            $this->load->view('coleta/inf_coleta', $data3);
    }

    public function delete($id) {
        $this->output->unset_template();

        $id_empresa = $this->session->userdata['empresa']['id'];
        $row = $this->demanda_model->get_row_demanda($id);

        if ($id_empresa != $row->ger_id_empresa) {

            $this->session->set_flashdata('resposta_erro', 'Acesso negado para remover demanda.');
            redirect(site_url('demanda'));
        } else {

			$data = array();
			$data['title'] = "Deseja remover a demanda?";
			$data['id'] = $id;

			$this->load->view('demanda/cancelar',$data);
        }
	}
	
	public function delete_motivo() {
        $this->output->unset_template();
		
		$motivo = $this->input->post('motivo_cancela');
		$id = $this->input->post('id');
        $id_empresa = $this->session->userdata['empresa']['id'];
        $row = $this->demanda_model->get_row_demanda($id);
			
		$this->demanda_model->delete($id, $id_empresa, $motivo);

		$this->session->set_flashdata('resposta_erro', 'Demanda removida com sucesso.');
		redirect(site_url('demanda'));
    }

	
	/*
	*	Listar histórico de modificações de histórico
	*/
	public function status_demanda_historico($id_demanda=false){
		$this->output->unset_template();
		
		$data = array();
		
		$data['result'] = $this->demanda_model->get_result_status_historico($id_demanda);
		
		$this->load->view('demanda/status_historico',$data);	
		
	}
	
    private function validar_form_demanda($id_update=''){
		
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
		if(date('Y-m-d', strtotime(str_replace("/","-",$this->input->post('data_inicio'))) ) < date('Y-m-d') && empty($id_update) ){
			$json['error'] = $json['error_data_inicio'] = 'A data de início não pode ser menor que a data de hoje: '.date('d/m/Y');
		}
		
		if($this->input->post('acondicionado')=='') {
           $json['error'] = $json['error_acondicionado'] = 'Selecione opção de como o resíduo está acondidionado';
		}else
		if($this->input->post('acondicionado')==0 && $this->input->post('acondicionado_outro')=='') {
           $json['error'] = $json['error_acondicionado_outro'] = 'Digite como o resíduo está acondidionado';
		}
		
		if($this->input->post('uni_medida')=='') {
           $json['error'] = $json['error_uni_medida'] = 'Selecione a undiade de medida';
		}else
		if($this->input->post('uni_medida')==0 && $this->input->post('uni_medida_outro')=='') {
           $json['error'] = $json['error_uni_medida_outro'] = 'Digite a unidade de medida';
		}
		
		if(!$this->input->post('qtd')) {
           $json['error'] = $json['error_qtd'] = 'Digite a quantidade';
		}
				
		if(!$this->input->post('residuo')) {
           $json['error'] = $json['error_residuo'] = 'Especifique o resíduo';
		}
			
		return $json;
		
	}

}
?>

