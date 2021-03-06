<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painelempresa extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->_init();
                $this->load->model(array('empresa_model','demanda_model','proposta_model'));
                $this->load->library('session'); 
	}

	private function _init()
	{
            
                if($this->session->has_userdata('empresa') ) { 
                    $this->output->set_template('default');
                    $this->load->js('painel/assets/pluguins/jquery-easing/jquery.easing.min.js');
                    $this->load->js('painel/assets/pluguins/chart.js/Chart.min.js');
                }
                else {
                    $this->session->set_flashdata("erro","Faça o Login");
                    redirect(base_url('login'));
                }  
	}
	
	public function index()
	{
		
                switch ($this->session->userdata['empresa']['funcao']){
                    
                    case 1:
                        $this->output->set_common_meta('Painel Administrativo Geradora','',''); 
                        $data['demandas_cadastradas'] = $this->demanda_model->countdemandas($this->session->userdata['empresa']['id']);
                        $data['propostas_recebidas'] = $this->proposta_model->countpropostas_id_geradora($this->session->userdata['empresa']['id']);
                        $data['propostas_aceitas'] = $this->proposta_model->countpropostasaceitas_id_geradora($this->session->userdata['empresa']['id']);
                        if ($data['demandas_cadastradas']==0)
                            $this->load->view('dashboard/bemvindo_geradora');
                        else{
                            $this->load->view('dashboard/adm_geradora',$data);
                        }
                        $this->load->view('dashboard/faq_geradora');
                        break;
                    case 2:
                        $this->output->set_common_meta('Painel Administrativo Coletora','',''); 
                        $data['ativo'] = $this->empresa_model->verificaliberacao($this->session->userdata['empresa']['id']);
                        $data['propostas_realizadas'] = $this->proposta_model->countpropostas_id_coletora($this->session->userdata['empresa']['id']);
                        $data['propostas_aceitas'] = $this->proposta_model->countpropostasaceitas_id_coletora($this->session->userdata['empresa']['id']);
                        if ($data['ativo']==0)
                            $this->load->view('dashboard/bemvindo_coletora',$data);
                        else {
                            $data['certificados_ativos'] = $this->empresa_model->countcertificados($this->session->userdata['empresa']['id']);
                            $data['demandas_meu_estado'] = $this->demanda_model->countdemandasbyuf($this->session->userdata['empresa']['uf_estado']);
                            
                            if ($data['certificados_ativos']>0){
                               $data['licencas'] =  $this->empresa_model->listacertificados($this->session->userdata['empresa']['id']);
                            }
                            
                            $this->load->view('dashboard/adm_coletora',$data);
                        }
                        $this->load->view('dashboard/faq_coletora');
                        break;
                    case 3:
                        $this->output->set_common_meta('Painel Administrativo Geradora e Coletora','',''); 
                        $this->load->view('dashboard/painel_coletora');
                        break;
                }
                
		$data = array();
		//$this->load->view('painel',$data);
		
	}
}
