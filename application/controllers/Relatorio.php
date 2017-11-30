<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->load->library('fpdf');
	}

	public function lista_propostas($id_demanda){
            
              $this->load->view('relatorio/relatorio_propostas');

	}

}
