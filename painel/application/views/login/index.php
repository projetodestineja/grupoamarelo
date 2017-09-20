<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Destine Já - Login</title>

    <link rel="stylesheet" href="<?php echo base_url('assets/css/css.css') ?>">

    <style type="text/css">
      #col_cnpj, #col_cpf{display: none;}
    </style>

  </head>

  <body class="bg-dark">

    <div class="container">

      <div class="card card-login mx-auto mt-5">
        <div class="card-header">
          <center>
          <img width="200px" src="<?php echo base_url('assets/img/destinejalogo.png') ?>"/>
          <h3 style="margin:20px 0;">Acesse seu painel</h3>
          </center>
        </div>
        <div class="card-body">
          <form>

           

            <div class="form-group" id="col_email">
              <label for="exampleInputEmail1">E-mail</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="nome@dominio.com">
            </div>

            <div class="form-group" id="col_cnpj">
              <label for="exampleInputEmail1">CNPJ</label>
              <input type="text" class="form-control cnpj" id="" placeholder="00.000.000/0000-00">
            </div>

            <div class="form-group" id="col_cpf">
              <label for="exampleInputEmail1">CPF</label>
              <input type="text" class="form-control cpf" id="" placeholder="000.000.000-00">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Senha</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Digite sua senha">
            </div>
            <div class="form-group">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input">
                  Lembrar minhas credenciais
                </label>
              </div>
            </div>
            <a class="btn btn-success btn-block" href="painel">Login</a>
          </form>
          <div class="text-center">
            <a class="d-block small" href="#">Esqueceu a senha?</a>
          </div>
        </div>
      </div>
    </div>


    <script src="<?php echo base_url('assets/pluguins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/pluguins/popper/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/pluguins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    
    <script type="text/javascript" src="<?php echo base_url('assets/pluguins/jquery.mask.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/js.js') ?>"></script>

    <script type="text/javascript">
      $( "#email" ).click(function() {
        $( "#col_email" ).show();
        $( "#col_cnpj" ).hide();
        $( "#col_cpf" ).hide();
        //alert("1");
      });

      $( "#cnpj" ).click(function() {
        $( "#col_email" ).hide();
        $( "#col_cnpj" ).show();
        $( "#col_cpf" ).hide();
        //alert("1");
      });

      $( "#cpf" ).click(function() {
        $( "#col_email" ).hide();
        $( "#col_cnpj" ).hide();
        $( "#col_cpf" ).show();
      });
    </script>

  </body>

</html>
