<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends CI_Controller {

	function __construct(){
            parent::__construct();
            $this->login_model->restrito(); 
	}

	public function index(){
		$this->load->view('welcome_message');
	}

}
