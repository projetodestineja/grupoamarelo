<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Endereco extends CI_Controller {

	function __construct(){
		parent::__construct();
                $this->login_model->restrito(); 
                $this->load->model('endereco_model');
	}
        
    function getcidades($uf) {
        
	   if($this->input->get('cidade')){	
	   	  $cidade = $this->input->get('cidade');
	   }else{
		  $cidade = '';
	   }
	   
	   $retorno = array();
	  
			
	   $cidades = $this->endereco_model->get_all_cidades($uf);
	   
	   foreach($cidades as $row){
		  $selected = (strtoupper($cidade)==strtoupper($row->nome_cidade)?'selected':'');
		  $retorno[] = array('nome_cidade'=>$row->nome_cidade,'id'=>$row->id,'selected'=>$selected); 
	   }        
	   echo json_encode($retorno);
   }

}
