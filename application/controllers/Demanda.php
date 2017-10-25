<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demanda extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->load->model(array('empresa_model', 'demanda_model', 'endereco_model','estado_model'));
		$this->load->library(array('form_validation','util','upload'));
                $this->_init();
	}

        private function _init()
	{   //Carregando plugins auxiliares para listar a tabela
            $this->load->js('painel/assets/pluguins/datatables/datatables.min.js');
            $this->load->js('painel/assets/pluguins/datatables/dataTables.bootstrap4.js');
            $this->load->js('https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js');
            $this->load->js('painel/assets/pluguins/datatables/script.js');
            $this->load->js('painel/assets/js/js.js');
            /****** Pluguin Calendário Input **************/
            $this->load->css('painel/assets/pluguins/datepicker/css/bootstrap-datepicker.min.css');
            $this->load->js('painel/assets/pluguins/datepicker/js/bootstrap-datepicker.min.js');
            $this->load->js('painel/assets/pluguins/datepicker/locales/bootstrap-datepicker.pt-BR.min.js');
		
            /****** Busca cep **************/
            $this->load->js('painel/assets/pluguins/buscacep.js');
            
                if($this->session->has_userdata('empresa') ) { 
                    $this->output->set_template('default');
                }
                else {
                    $this->session->set_flashdata("erro","Faça o Login");
                    redirect(base_url('login'));
                }  
	}
        
	public function lista_demandas(){
            
            if ($this->session->userdata['empresa']['funcao']==1){
                $dados['demandas'] = $this->demanda_model->lista_demandasbyid($this->session->userdata['empresa']['id']);
                $this->output->set_common_meta('Demandas da Geradora de Resíduos','',''); 
                $dados['menu_opcao_direita'][] = anchor('demanda/add', '<i class="fa fa-fw fa-plus"></i> Nova Demanda', 'class="btn btn-primary btn-sm not-focusable" data-toggle="tooltip" title="Clique aqui para cadastrar uma demanda"');
            }
            else{
               if ($this->session->userdata['empresa']['funcao']==2){
                  $uf = $this->session->userdata['empresa']['uf'];
                  $nome_estado = $this->estado_model->busca_nomeestadobyuf($uf);
                  $data['local'] = $nome_estado;
                  
                  $this->output->set_common_meta('Demandas para Coleta em '.$nome_estado,'',''); 
                  $dados['menu_opcao_direita'][] = anchor('demanda/lista_demandas?btcidade=1', '<i class="fa fa-fw fa-map-marker"></i> da Minha Cidade', 'class="btn btn-primary btn-sm not-focusable" data-toggle="tooltip" title="Clique para listar as demandas da sua cidade"');
                  $dados['menu_opcao_direita'][] = anchor('demanda/lista_demandas', '<i class="fa fa-fw fa-map-marker"></i> do meu Estado', 'class="btn btn-primary btn-sm not-focusable" data-toggle="tooltip" title="Clique para listar as demandas do meu Estado"');
                  
                  if ($this->input->get('btcidade')){
                     $this->load->model('cidade_model');
                     $data['local'] = $this->cidade_model->getcidadebyid($this->session->userdata['empresa']['id_cidade']);
                     $dados['demandas'] = $this->demanda_model->lista_demandasbycidade($this->session->userdata['empresa']['id_cidade']);
                    $this->output->set_common_meta('Demandas para Coleta em '.$data['local'],'',''); 
                     //$this->load->view('demanda/nav_lista_demandas',$data);
                  }
                  else{
                      $dados['demandas'] = $this->demanda_model->lista_demandasbyuf($uf);
                  }

               } 
            }
            
            $this->load->view('demanda/lista_demandas',$dados);
	}
        
        public function add(){
		$this->output->set_common_meta('Cadastrar Demanda','',''); //Title / Description / Tags
		$data_inicio = ($this->input->post('data_inicio')?date('Y-m-d', strtotime(str_replace("/","-",$this->input->post('data_inicio')))):'');
		$data_validade = ($this->input->post('data_validade')?date('Y-m-d', strtotime(str_replace("/","-",$this->input->post('data_validade')))):'');
		$data = array(
			//duração da demanda
			'data_inicio' => $data_inicio,
			'data_validade' => $data_validade,
			//informações do resíduo
			'residuo' => $this->input->post('residuo'),
			'condicionado' => $this->input->post('condicionado'),
			'qtd' => $this->input->post('qtd'),
			'uni_medida' => $this->input->post('uni_medida'),
			//observações
			'obs' => $this->input->post('obs')
		);
		
		// dados da empresa geradora
		$id = (int) $this->session->userdata['empresa']['id'];
		
		$row = $this->empresa_model->consultar_coletoraId($id);
		if (!$row) {
			$this->session->set_flashdata('resposta_erro', 'Empresa não identificada.');
			redirect(site_url('demanda/lista_demandas'));
		}
                
		$data['ger_id_empresa'] = $row->id;
		$data['ger_cep'] = $row->cep;
		$data['ger_logradouro'] = $row->logradouro;
		$data['ger_numero'] = $row->numero;
		$data['ger_complemento'] = $row->complemento;
		$data['ger_bairro'] = $row->bairro;
		$data['ger_id_cidade'] = $row->id_cidade;
		$data['ger_uf_estado'] = $row->uf_estado;
		// dados da empresa geradora
		
		// validação dos campos
		if($this->input->post()){
			$this->form_validation->set_rules('data_inicio', 'data de início da demanda', 'required');
			$this->form_validation->set_rules('data_validade', 'data de expiração da demanda', 'required');
			$this->form_validation->set_rules('residuo', 'descrição do resíduo', 'required');
			$this->form_validation->set_rules('condicionado', 'como está acondicionado', 'required');
			$this->form_validation->set_rules('qtd', 'quantidade', 'required');
			$this->form_validation->set_rules('uni_medida', 'unidade de medida', 'required');
			/*$this->form_validation->set_rules('img1', 'imagem (1)', 'required');*/
			$this->form_validation->set_rules('obs', 'observação', 'required');
			$this->form_validation->set_rules('cep', 'CEP', 'required');
			$this->form_validation->set_rules('logradouro', 'logradouro', 'required');
			$this->form_validation->set_rules('numero', 'número', 'required');
			/*$this->form_validation->set_rules('complemento', 'complemento', 'required');*/	
			$this->form_validation->set_rules('bairro', 'bairro', 'required');
			$this->form_validation->set_rules('cidade', 'cidade', 'required');
			$this->form_validation->set_rules('estado', 'estado', 'required');
			
			if($this->form_validation->run()==FALSE){
				$this->session->set_flashdata('resposta_erro',validation_errors('<div class="error">* ', '</div>'));
			}else{
				$this->demanda_model->add($data);
				$this->session->set_flashdata('resposta_ok', 'Demanda <strong>'.$this->input->post('residuo').'</strong> cadastrada com sucesso.');
				redirect(site_url('demanda/lista_demandas'));
			}
			
		}
		// validação dos campos

		$data['responsavel'] = $row->nome_responsavel;
		$data['ger_email'] = $row->email;
		$data['ger_telefone1'] = $row->telefone1;
		$data['ger_telefone2'] = $row->telefone2;
		$uf = ($this->input->post('estado') ? $this->input->post('estado') : $row->uf_estado);
		$data['estados'] = $this->endereco_model->get_all_estados(); // Listamos todos estados normalmente
		$data['cidades'] = $this->endereco_model->get_all_cidades($uf); //<-UF no EDIT pra listar apenas a cidades do estado selecionado
		
		$data['menu_mapa'] = array(
			'Demandas' => $this->uri->segment(1),
			'Cadastrar' => ''
		);

		$data['menu_opcao_direita'][] = anchor('demanda/lista_demandas', '<i class="fa fa-fw fa-undo"></i> Voltar', 'class="btn btn-info btn-sm not-focusable"');
		$this->load->view('demanda/form_cad_demanda',$data);
	}

}
