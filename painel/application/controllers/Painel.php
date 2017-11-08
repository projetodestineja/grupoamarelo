<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->login_model->restrito();    
		$this->_init();
                $this->load->model('empresa_model');
                $this->load->model('demandas_model');
	}

	private function _init(){
		$this->output->set_template('default');

		$this->load->js('assets/pluguins/jquery-easing/jquery.easing.min.js');
		$this->load->js('assets/pluguins/chart.js/Chart.min.js');
		$this->load->js('assets/pluguins/chart.js/script.js');
		
	}
	
	public function index(){
		
		$this->output->set_common_meta('Painel Administrativo','',''); //Title / Description / Tags
		
		$data = array();
                
                //dados dos contabilizadores do painel
                $data['total_geradoras'] = $this->empresa_model->count_all(1);
                $data['total_coletoras'] = $this->empresa_model->count_all(2);
                $data['total_geradoras_coletoras'] = $this->empresa_model->count_all(3);
                $data['empresas_bloqueadas'] = $this->empresa_model->count_all_bloqueadas();
                
                $data['total_demandas'] = $this->demandas_model->count_all(0);
                $data['demandas_aguardando'] = $this->demandas_model->count_all(1);
                
                //dados do grafico empresas
                $ano = date('Y');
                
                $data['gjan'] = $this->empresa_model->conta_por_mes($ano,1,'1,3')->qtde;
                $data['gfev'] = $this->empresa_model->conta_por_mes($ano,2,'1,3')->qtde;
                $data['gmar'] = $this->empresa_model->conta_por_mes($ano,3,'1,3')->qtde;
                $data['gabr'] = $this->empresa_model->conta_por_mes($ano,4,'1,3')->qtde;
                $data['gmai'] = $this->empresa_model->conta_por_mes($ano,5,'1,3')->qtde;
                $data['gjun'] = $this->empresa_model->conta_por_mes($ano,6,'1,3')->qtde;
                $data['gjul'] = $this->empresa_model->conta_por_mes($ano,7,'1,3')->qtde;
                $data['gago'] = $this->empresa_model->conta_por_mes($ano,8,'1,3')->qtde;
                $data['gset'] = $this->empresa_model->conta_por_mes($ano,9,'1,3')->qtde;
                $data['gout'] = $this->empresa_model->conta_por_mes($ano,10,'1,3')->qtde;
                $data['gnov'] = $this->empresa_model->conta_por_mes($ano,11,'1,3')->qtde;
                $data['gdez'] = $this->empresa_model->conta_por_mes($ano,12,'1,3')->qtde;
                $max_geradoras = max($data['gjan'], $data['gfev'], $data['gmar'], $data['gabr'], $data['gmai'],$data['gjun'],$data['gjul'],$data['gago'],$data['gset'],$data['gout'],$data['gnov'],$data['gdez']);
                
                $data['cjan'] = $this->empresa_model->conta_por_mes($ano,1,'2,3')->qtde;
                $data['cfev'] = $this->empresa_model->conta_por_mes($ano,2,'2,3')->qtde;
                $data['cmar'] = $this->empresa_model->conta_por_mes($ano,3,'2,3')->qtde;
                $data['cabr'] = $this->empresa_model->conta_por_mes($ano,4,'2,3')->qtde;
                $data['cmai'] = $this->empresa_model->conta_por_mes($ano,5,'2,3')->qtde;
                $data['cjun'] = $this->empresa_model->conta_por_mes($ano,6,'2,3')->qtde;
                $data['cjul'] = $this->empresa_model->conta_por_mes($ano,7,'2,3')->qtde;
                $data['cago'] = $this->empresa_model->conta_por_mes($ano,8,'2,3')->qtde;
                $data['cset'] = $this->empresa_model->conta_por_mes($ano,9,'2,3')->qtde;
                $data['cout'] = $this->empresa_model->conta_por_mes($ano,10,'2,3')->qtde;
                $data['cnov'] = $this->empresa_model->conta_por_mes($ano,11,'2,3')->qtde;
                $data['cdez'] = $this->empresa_model->conta_por_mes($ano,12,'2,3')->qtde;
                $max_coletoras = max($data['cjan'], $data['cfev'], $data['cmar'], $data['cabr'], $data['cmai'],$data['cjun'],$data['cjul'],$data['cago'],$data['cset'],$data['cout'],$data['cnov'],$data['cdez']);
                
                $data['limite_chart_empresas'] = max($max_geradoras,$max_coletoras);
                
                //dados do grafico demandas
                $ano = date('Y');
                
                $data['djan'] = $this->demandas_model->conta_por_mes($ano,1)->qtde;
                $data['dfev'] = $this->demandas_model->conta_por_mes($ano,2)->qtde;
                $data['dmar'] = $this->demandas_model->conta_por_mes($ano,3)->qtde;
                $data['dabr'] = $this->demandas_model->conta_por_mes($ano,4)->qtde;
                $data['dmai'] = $this->demandas_model->conta_por_mes($ano,5)->qtde;
                $data['djun'] = $this->demandas_model->conta_por_mes($ano,6)->qtde;
                $data['djul'] = $this->demandas_model->conta_por_mes($ano,7)->qtde;
                $data['dago'] = $this->demandas_model->conta_por_mes($ano,8)->qtde;
                $data['dset'] = $this->demandas_model->conta_por_mes($ano,9)->qtde;
                $data['dout'] = $this->demandas_model->conta_por_mes($ano,10)->qtde;
                $data['dnov'] = $this->demandas_model->conta_por_mes($ano,11)->qtde;
                $data['ddez'] = $this->demandas_model->conta_por_mes($ano,12)->qtde;
                $max_demandas = max($data['djan'], $data['dfev'], $data['dmar'], $data['dabr'], $data['dmai'],$data['djun'],$data['djul'],$data['dago'],$data['dset'],$data['dout'],$data['dnov'],$data['ddez']);
                
                /*
                $data['cjan'] = $this->empresa_model->conta_por_mes($ano,1,'2,3')->qtde;
                $data['cfev'] = $this->empresa_model->conta_por_mes($ano,2,'2,3')->qtde;
                $data['cmar'] = $this->empresa_model->conta_por_mes($ano,3,'2,3')->qtde;
                $data['cabr'] = $this->empresa_model->conta_por_mes($ano,4,'2,3')->qtde;
                $data['cmai'] = $this->empresa_model->conta_por_mes($ano,5,'2,3')->qtde;
                $data['cjun'] = $this->empresa_model->conta_por_mes($ano,6,'2,3')->qtde;
                $data['cjul'] = $this->empresa_model->conta_por_mes($ano,7,'2,3')->qtde;
                $data['cago'] = $this->empresa_model->conta_por_mes($ano,8,'2,3')->qtde;
                $data['cset'] = $this->empresa_model->conta_por_mes($ano,9,'2,3')->qtde;
                $data['cout'] = $this->empresa_model->conta_por_mes($ano,10,'2,3')->qtde;
                $data['cnov'] = $this->empresa_model->conta_por_mes($ano,11,'2,3')->qtde;
                $data['cdez'] = $this->empresa_model->conta_por_mes($ano,12,'2,3')->qtde;
                $max_propostas = max($data['cjan'], $data['cfev'], $data['cmar'], $data['cabr'], $data['cmai'],$data['cjun'],$data['cjul'],$data['cago'],$data['cset'],$data['cout'],$data['cnov'],$data['cdez']);
                */
                $data['limite_chart_demandas'] = $max_demandas;
                
		$this->load->view('painel',$data);
		
	}
}
