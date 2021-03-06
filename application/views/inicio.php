<?php
defined('BASEPATH') OR exit('No direct script access allowed'); //teste
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>

<html lang="pt-br">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <link rel="stylesheet" href="<?php echo base_url('painel/assets/pluguins/bootstrap/css/bootstrap.min.css') ?>">
		<link rel="stylesheet" href="<?php echo base_url('painel/assets/css/css.css') ?>">
		<title><?php echo $titulo; ?></title>
	</head>

	<body>

            <div class="container-fluid">

                <div class="row" >
                    <div class="col-sm-12 text-center" >

                        <div style="width:230px; margin:0 auto;">
                            <img width="230px" src="<?php echo base_url('painel/assets/img/destinejalogo.png') ?>"/>
                        </div>
                        <hr>

                        <?php  if (!empty($this->session->flashdata('msg'))) 
                        echo "<div class=\"alert alert-danger\" style=\"width:100%;\">".$this->session->flashdata('msg')." </div>"; ?>
                        
                        <div class="text-center"  >
                            <h1>Efetue seu cadastro:</h1><br/>
                            <a href="<?php echo site_url('empresa/gerador') ?>" class="btn btn-success btn-lg" style="background-color: darkorange;">
                                <i class="fa fa-trash" ></i> Gerador de Resíduo
                            </a>
                            <br><br>
                            <a href="<?php echo site_url('empresa/coletor') ?>" class="btn btn-success btn-lg" >
                                <i class="fa fa-truck" ></i> Coletor de Resíduo
                            </a>
                            <br/><br/></br>
                            
                            <h1><div style="color:#008ae6">Já é cadastrado?</div></h1><br/>
                            <a href="<?php echo site_url('login') ?>" class="btn btn-info btn-lg" >
                                <i class="fa fa-lock" ></i> Efetue Seu Login
                            </a>
                        </div>
                        <br><br>
                        <h1><div style="color:	#da0b0b;">Área Restrita</div></h1><br/>
                                    <div class="text-center">
                                        <a href="<?php echo site_url('painel') ?>" target="_blank" class="btn btn-danger btn-lg" >
                                            <i class="fa fa-lock" ></i> Login Destine Já
                                                </a>
                                    </div>
                    </div>
                </div>
	    <hr>
            
            </div>

	<script src="<?php echo base_url('painel/assets/pluguins/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('painel/assets/pluguins/popper/popper.min.js'); ?>"></script>
  <script src="<?php echo base_url('painel/assets/pluguins/bootstrap/js/bootstrap.min.js'); ?>"></script>

	</body>
</html>
