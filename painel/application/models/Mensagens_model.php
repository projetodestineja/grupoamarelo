<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensagens_model extends CI_Model {
	
	var $table = "mensagens";
    

    /*
    *   Insert mesagem
    */
    function insert_mensagem($post, $id_demanda, $id_empresa, $alert_email){
		
		$data = array(
			'assunto' 	 => $post['assunto'],
			'msg' 		 => $post['msg'],
			'alert_email'=> $post['alert_email'],
			'id_empresa' => (int)$id_empresa,
			'id_demanda' => (int)$id_demanda,
			'grupo' 	 => 'demanda',
			'atualizada' => date('Y-m-d H:i:s')
		);
		
        $this->db->insert('mensagens',$data);
		
		$id_mensagem = $this->db->insert_id();
    }
	
	
	/*
    *   Update mesagem
    */
    function update_mensagem($post, $id_demanda, $id_empresa, $id_mensagem, $alert_email ){
		
		$data = array(
			'assunto' 	 => $post['assunto'],
			'msg' 		 => $post['msg'],
			'alert_email'=> $alert_email,
			'atualizada' => date('Y-m-d H:i:s')
		);
		
		$this->db->where('id',(int)$id_mensagem);	
        $this->db->update('mensagens',$data);
		
		// Enviar mensagem
		if($alert_email==true){
			$this->enviar_email($post, $id_demanda, $id_empresa, $id_mensagem);
		}
    }
	
	/*
    *  Enviar por e-mail
    */
	private function enviar_email($post = array(), $id_demanda, $id_empresa, $id_mensagem){
		
		$this->load->library('email');
		
		$data = array();
		
		$this->load->model('config_model');	
		$config = $this->config_model->get('smtp');
			
		$config_email['protocol'] = 'smtp';
		$config_email['smtp_host'] = $config['smtp_servidor'];
		$config_email['smtp_user'] = $config['smtp_email'];
		$config_email['smtp_pass'] = $config['smtp_senha'];
		$config_email['smtp_port'] = $config['smtp_porta'];
		$config_email['bcc_batch_mode'] = true;
		$config_email['mailtype'] = 'html';
		$this->email->initialize($config_email);
		
		$email_remetente = $config['smtp_email'];
		$nome_remente = $this->config->item('title');
		
		// Info para envio html
		$data['id_demanda'] = $id_demanda;
		$data['assunto'] 	= $post['assunto'];
		$data['msg'] 		= $post['msg'];
		
		$this->email->from($email_remetente,$nome_remente);
		$this->email->to('onerio@tribo.ppg.br');
		$this->email->reply_to($email_remetente,$nome_remente);
 		$this->email->subject('Nova Mensagem Demanda #'.$id_demanda.' - '.$post['assunto']);
		$this->email->message($this->load->view('mensagens/html_email_mensagem',$data,true));
		
		$this->email->send();
	}

    /*
    *   Listar mensagens histórico demanda
    */
    function get_result_mensagens_demanda($id_demanda){

        $sql = 'select 
                m.id, 
                m.assunto,
                m.msg,
				m.alert_email,
                m.id_empresa,
                m.id_demanda,
                m.cadastrada,
                e.razao_social,
                e.nome_responsavel
            from 
                mensagens as m 
            join 
                empresas as e 
                ON
            m.id_empresa=e.id 
                and 
            m.removida is NULL 
                and     
            id_demanda='.$id_demanda.' order  by m.id desc';
       
        return $this->db->query($sql)->result();
    }


    /*
    *  Remover Mensagem
    */
    function remover($id_delete){
        $this->db->where('id',$id_delete);
        $this->db->set('removida',date('Y-m-d H:i:s'));
        $this->db->update($this->table);
    }
    
	
	/*
    *  Get row mensagem
    */
    function get_row_mensagem($id_mensagem){
        $this->db->where('id',(int)$id_mensagem);
        return $this->db->get($this->table)->row();
    }
}
