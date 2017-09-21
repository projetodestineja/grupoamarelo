<!DOCTYPE html>
<html lang="pt-br">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    
    	<?php
		/** -- Copy from here -- */
		if(!empty($meta))
		foreach($meta as $name=>$content){
			echo "\n\t\t";
			?><meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" /><?php
				 }
		echo "\n";
	
		if(!empty($canonical))
		{
			echo "\n\t\t";
			?><link rel="canonical" href="<?php echo $canonical?>" /><?php
	
		}
		echo "\n\t";
		/** -- to here -- */
	?>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/pluguins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?php echo base_url('assets/pluguins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">

    <!-- Plugin CSS -->
    <link href="<?php echo base_url('assets/pluguins/datatables/dataTables.bootstrap4.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/sb-admin.css'); ?>" rel="stylesheet">

  </head>

  <body class="fixed-nav sticky-footer bg-dark <?php echo ((isset($_COOKIE['menu-vertital-painel']) and $_COOKIE['menu-vertital-painel']=='sim')?'sidenav-toggled':''); ?>" id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <a class="navbar-brand" href="<?php echo site_url('painel'); ?>" >
            <i class="fa fa-fw fa-lock"></i> <?php echo $this->config->item('title'); ?>
      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
          
        <?php $this->load->view('theme/menu');?>
      </div>
    </nav>
   
   
   
   
    
    <div class="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>">Painel</a>
          </li>
          <li class="breadcrumb-item active">My Dashboard</li>
        </ol>
        <h1><?php echo $title; ?></h1>
        
        <?php 
		if($this->session->flashdata('resposta_erro')){ ?>
            <div class="alert alert-danger" >
				<?php echo $this->session->flashdata('resposta_erro'); ?>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
		<?php }
         if($this->session->flashdata('resposta_ok')){ ?>
            <div class="alert alert-success" >
				<?php echo $this->session->flashdata('resposta_ok'); ?>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
        <?php } ?>
        
        <div class="conteudo">
           
        <?php echo $output;?>
        </div>
        
     </div>
    </div>
    
    
    
    
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>&copy; <?php echo $this->config->item('title').' '.date('Y'); ?> - Load {elapsed_time} Seg. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter V <strong>' . CI_VERSION . '</strong>' : '' ?></small>
        </div>
      </div>
    </footer>

    <!-- Ir para o Topo -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

    <!-- Modal Logout-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           Dseja sair do painel?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
            <a class="btn btn-primary" href="<?php echo site_url('login')?>">Sim</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url('assets/pluguins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/pluguins/popper/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/pluguins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    
    <!-- Plugin JavaScript -->
    <script src="<?php echo base_url('assets/pluguins/jquery-easing/jquery.easing.min.js'); ?>"></script>
  
  
    <?php
	// Load CSS Controller
	foreach($css as $file){
	echo "\n\t\t";
	?>
    	<link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" />
	<?php
	} 
	echo "\n\t";
	
	// Load JS Controller
	foreach($js as $file){
		echo "\n\t\t";
	?>
		<script src="<?php echo $file; ?>"></script>
	<?php
	} 
	echo "\n\t";
	?>
                

    <!-- Custom scripts for this template -->
    <script src="<?php echo base_url('assets/js/sb-admin.js'); ?>"></script>
    
    <script>
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip(); 
            $('.menu-vertical-principal .menu-v-<?php echo $this->uri->segment(1); ?>').addClass("active");
  	});
    </script>

  </body>

</html>
