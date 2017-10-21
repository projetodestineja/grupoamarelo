<!DOCTYPE html>
<html lang="pt-br">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $title; ?></title>
        <?php
        if (!empty($meta)) {
            foreach ($meta as $name => $content) {
                echo '<meta name="' . $name . '" content="' . $content . '" />';
            }
        }
        if (!empty($canonical)) {
            echo '<link rel="canonical" href="' . $canonical . '" />';
        }
        ?>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url('painel/assets/pluguins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <!-- Custom fonts for this template -->
        <link href="<?php echo base_url('painel/assets/pluguins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
        <!-- Plugin CSS -->
        <link href="<?php echo base_url('painel/assets/pluguins/datatables/dataTables.bootstrap4.css'); ?>" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?php echo base_url('painel/assets/css/sb-admin.css'); ?>" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>


    </head>

    <body class="fixed-nav sticky-footer bg-light <?php echo ((isset($_COOKIE['menu-vertital-cliente']) and $_COOKIE['menu-vertital-cliente'] == 'sim') ? 'sidenav-toggled' : ''); ?>" id="page-top">

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="mainNav">
            <a class="navbar-brand" href="<?php echo site_url('painelempresa'); ?>" ><i class="fa fa-fw fa-lock"></i> Painel <?php echo $this->session->userdata['empresa']['funcao_titulo']; ?></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <?php $this->load->view('theme/menu'); ?>
            </div>
        </nav>





        <!--div class="content-wrapper">

            <div class="container-fluid">

                <?php if (isset($menu_mapa)) { ?>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo site_url(); ?>">Painel</a>
                        </li>
                        <?php
                        foreach ($menu_mapa as $key => $item) {
                            if (empty($item)) {
                                echo '<li class="breadcrumb-item active" >' . $key . '</li>';
                            } else {
                                echo '<li class="breadcrumb-item" ><a href="' . site_url($item) . '" >' . $key . '</a></li>';
                            }
                        }
                        ?>
                    </ol>
                <?php } ?>

                <h1><?php echo $title; ?></h1>

                <?php if ($this->session->flashdata('resposta_erro') or isset($resposta_erro)) { ?>
                    <div class="alert alert-danger" >
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo ($this->session->flashdata('resposta_erro') ? $this->session->flashdata('resposta_erro') : ''); ?>
                        <?php echo ($resposta_erro ? $resposta_erro : ''); ?>
                    </div>
                <?php }
                if ($this->session->flashdata('resposta_ok')) {
                    ?>
                    <div class="alert alert-success " >
                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo $this->session->flashdata('resposta_ok'); ?>
                    </div>
                <?php } ?>

                <div class="conteudo">
                    <?php echo $output; ?>
                </div>

            </div>
        </div-->

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
                    <small>&copy; <?php echo $this->config->item('title') . ' ' . date('Y'); ?> - Load {elapsed_time} Seg. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter V <strong>' . CI_VERSION . '</strong>' : '' ?></small>
                </div>
            </div>
        </footer>

        <!-- Ir para o Topo -->
        <a class="scroll-to-top rounded" href="#page-top" rel="menu_vertital-cliente">
            <i class="fa fa-angle-up"></i>
        </a>

        <!-- Modal sair do painel-->
        <?php $this->load->view('modal/sair'); ?>

        <!-- Modal Ajax-->
        <?php $this->load->view('modal/ajax'); ?>

        <!-- Bootstrap core JavaScript -->
        <script src="<?php echo base_url('painel/assets/pluguins/popper/popper.min.js'); ?>"></script>
        <script src="<?php echo base_url('painel/assets/pluguins/bootstrap/js/bootstrap.min.js'); ?>"></script>

        <!-- Plugin JavaScript -->
        <script src="<?php echo base_url('painel/assets/pluguins/jquery-easing/jquery.easing.min.js'); ?>"></script>

        <?php
        foreach ($css as $file) {
            echo "<link rel=\"stylesheet\" href=\"" . $file . "\" type=\"text/css\" />\n";
        }
        foreach ($js as $file) {
            echo "<script src=\"" . $file . "\" ></script>\n";
        }
        ?>

        <!-- Custom scripts for this template -->
        <script src="<?php echo base_url('painel/assets/js/sb-admin.js'); ?>"></script>

        <script>
            $(document).ready(function () {

                $('[data-toggle="tooltip"]').tooltip();
                $('.menu-vertical-principal .menu-v-<?php echo $this->uri->segment(1); ?>').addClass("active");

                $('a[rel=modal_add_edit]').on('click', function (evt) {
                    evt.preventDefault();
                    var modal = $('#modal_add_edit').modal({backdrop: 'static', keyboard: false});

                    modal.find('#modal_add_edit .modal-body').load($(this).attr('href'), function (responseText, textStatus) {
                        if (textStatus === 'success' || textStatus === 'notmodified') {
                            modal.show();
                        }
                    });
                    return false;
                });

            });
        </script>

        <?php
        //Carregamento javascript datatables JS
        if (isset($datagrid_js)) {
            echo $datagrid_js;
        }
        ?>
    </body>
</html>
