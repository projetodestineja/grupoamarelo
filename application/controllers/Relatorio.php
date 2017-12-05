<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->load->library('fpdf');
                $this->load->model(array('proposta_model','demanda_model','login_model'));
                $this->login_model->restrito();
	}

	public function lista_propostas($id_demanda){
            
            //carrega dados da demanda do relatório
            $row = $this->demanda_model->get_row_demanda_ver($id_demanda);
            $data['row'] = $row;
            
            if ($data['row']['ger_id_empresa']== $this->session->userdata['empresa']['id']) {
            
            //verifica se tem proposta aceita. se não tiver, carrega todas as propostas válidas
            $proposta_aceita = $this->proposta_model->consultar_proposta_aceita($id_demanda);
            if (!$proposta_aceita) {
                $data['propostas'] = $this->proposta_model->get_proposta($id_demanda);
            }else {
                $data['propostas'] = $proposta_aceita;
            }
            
            $this->load->view('relatorio/relatorio_propostas',$data);
            
            } else $this->load->view('errors/acesso_negado');;

	}

}
