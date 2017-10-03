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
		<?php if(isset($menu_mapa)){ ?>	
        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>">Painel</a>
          </li>
          <?php 
          
            foreach($menu_mapa as $key => $item) { 
              if(empty($item)){  
                echo '<li class="breadcrumb-item active" >'.$key.'</li>';
              }else{
                echo '<li class="breadcrumb-item" ><a href="'.site_url($item).'" >'.$key.'</a></li>';  
              }
            }
          
          ?>
        </ol>
        <?php } ?>
        <div class="row" >
            <div class="col-md-4">
                <h1 style="font-size:27px;"><?php echo $title; ?></h1>
            </div>
            <div class="col-md-8 text-right">  
                <span id="colvis"></span>
                <?php 
		if(isset($menu_opcao_direita)){
                    foreach($menu_opcao_direita as $menu_r){
                        echo ' '.$menu_r;
                    } 
		} 
		?>
            </div>
        </div>
        
        <?php 
	if($this->session->flashdata('resposta_erro') or isset($resposta_erro)){ ?>
            <div class="alert alert-danger" > 
             <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<?php echo ($this->session->flashdata('resposta_erro')?$this->session->flashdata('resposta_erro'):''); ?>
            <?php echo ($resposta_erro?$resposta_erro:''); ?>
        </div>
	<?php }
        if($this->session->flashdata('resposta_ok')){ ?>
            <div class="alert alert-success " >
           <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php echo $this->session->flashdata('resposta_ok'); ?>
                
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

	
    <!-- Modal sair do painel-->
    <?php $this->load->view('modal/sair'); ?>
    

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
    /*
    <script src="http://livedemo.mbahcoding.com/assets/datatables.colvis/dataTables.colVis.js"></script>
    <link href="http://livedemo.mbahcoding.com/assets/datatables.colvis/dataTables.colVis.css" rel="stylesheet">
     */
    ?>
    <script src="<?php echo site_url('assets/pluguins/buscacep.js') ?>"></script>           
    <script src="<?php echo site_url('assets/pluguins/jquery.mask.js') ?>"></script>
	<script src="<?php echo site_url('assets/js/js.js') ?>"></script>
   
    
    <!-- Custom scripts for this template -->
    <script src="<?php echo base_url('assets/js/sb-admin.js'); ?>"></script>
    
    <script>
	
	function form_empresa(value){
		
		if(value=='F'){
			$('.col-pjuridica').hide();
			$('.col-pfisica').show();
			document.getElementById("cnpj").required = false;
			document.getElementById("cpf").required = true;
		 }else{
			$('.col-pfisica').hide();
			$('.col-pjuridica').show();
			document.getElementById("cpf").required = false;
			document.getElementById("cnpj").required = true;
		}	
	}
	
	function load_cidades(estado,cidade=NUll){
		   	
           $.getJSON( '<?php echo site_url(); ?>' + 'endereco/getcidades/' + estado+'?cidade='+cidade, function (data){
		      var option = new Array();
			     $.each(data, function(i, obj){
                   option[i] = document.createElement('option');
                   $( option[i] ).attr( {value : obj.id} );
                   if(obj.selected!=''){
                       $( option[i] ).attr( {selected : obj.selected} );
                    }
                   $(option[i]).append( obj.nome_cidade );
                    $("select[name=cidade]").append( option[i] );
                 }); 
           });  
       
    }

    function resetaCombo( el ) {
           $("select[name='"+el+"']").empty();
           var option = document.createElement('option');                                  
           $(option).attr( {value : ''} );
           $(option).append( 'Selecione a Cidade' );
           $("select[name='"+el+"']").append( option );
    }
	
	$(document).ready(function(){
		
			if($('input[name=tipo_cadastro]:checked').val()){
				form_empresa($('input[name=tipo_cadastro]:checked').val());
			}
			
			$("input[name=tipo_cadastro]" ).click(function() {
				form_empresa($(this).val());
			});
			
		
			$( "#rnegocio" ).change(function() {
				if (this.value == "outro"){
					$( "#outro_ramo_option" ).show();
					//alert('teste');
				} else{
					$( "#outro_ramo_option" ).hide();
				}
			});
	
			
			$('[data-toggle="tooltip"]').tooltip(); 
			$('.menu-vertical-principal .menu-v-<?php echo $this->uri->segment(1); ?>').addClass("active");
			
			$("select[name=estado]").change(function(){
	           var estado = $(this).val();
			      resetaCombo('cidade');
                load_cidades(estado,'');
            });
			
			
		});
	    
       
    </script>
    
	<?php 
	//Carregamento javascript datatables JS
	if(isset($datagrid_js)){echo $datagrid_js;}
	?>
  

  </body>

</html>
