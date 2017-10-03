<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

    function __construct(){
	parent::__construct();
        
        $this->login_model->restrito();
        
        $this->load->model('config_model');
        $this->_init();
    }

    private function _init(){
		
        $this->output->set_template('default');
    
    }

    public function index(){
	
        $this->output->set_common_meta('Configurações','',''); //Title / Description / Tags
        $data['menu_mapa'] = array(
           'Configurações' => ''
        );
        
        if($this->input->post()){
          $this->config_model->edit('smtp',$this->input->post());
	  $data['resposta'] = "Atualizado com sucesso";
	}
		 
	$row = $this->config_model->get('smtp');
        
        //Configurações SMTP para o envio de E-mail:
	$data['smtp_email'] 	= (isset($row['smtp_email'])?$row['smtp_email']:'');
        $data['smtp_senha'] 	= (isset($row['smtp_senha'])?$row['smtp_senha']:'');
        $data['smtp_porta'] 	= (isset($row['smtp_porta'])?$row['smtp_porta']:'');
        $data['smtp_servidor'] 	= (isset($row['smtp_servidor'])?$row['smtp_servidor']:'');
        
        //Quem Vai Receber Alerta de Demanda por E-mail:
        $data['smtp_send_email_demanda'] 	= (isset($row['smtp_send_email_demanda'])?$row['smtp_send_email_demanda']:'');
       
        
        $this->load->view('config/form',$data);
    }

}
