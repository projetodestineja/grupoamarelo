<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');

$tipo_login ="";
$cnpj = "";
$email = "";
$cpf="";
$senha = "";

if (isset($_COOKIE['tipo_login'])) $tipo_login = $_COOKIE['tipo_login'];
if (isset($_COOKIE['email'])) $email = $_COOKIE['email'];
if (isset($_COOKIE['cnpj'])) $cnpj = $_COOKIE['cnpj'];
if (isset($_COOKIE['cpf'])) $cpf = $_COOKIE['cpf'];
if (isset($_COOKIE['senha'])) $senha = $_COOKIE['senha'];

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Destine Já - Login</title>

    <!-- Bootstrap core CSS >
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"-->

    <!-- Custom fonts for this template >
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"-->

    <!-- Custom styles for this template >
    <link href="css/sb-admin.css" rel="stylesheet"-->

    <link rel="stylesheet" href="<?php echo base_url('painel/assets/css/css.css') ?>">

    <style type="text/css">
      #col_cnpj, #col_cpf{display: none;}
    </style>

  </head>

  <body class="bg-light">

    <div class="container">

      <div class="card card-login mx-auto mt-5">
        <div class="card-header">
          <center>
          <img width="200px" src="<?php echo base_url('painel/assets/img/destinejalogo.png') ?>"/>
          <br>
          <?php  if (!empty($this->session->flashdata('msg')))
                        echo "<div class=\"alert alert-success\" style=\"width:100%;margin-top:5px;\">".$this->session->flashdata('msg')." </div>"; ?>

          <h3 style="margin:20px 0;">Acesse seu painel</h3>
          </center>
          <?php  if (!empty($this->session->flashdata('erro')))
                        echo "<div class=\"alert alert-danger\" style=\"width:100%;margin-top:5px;\">".$this->session->flashdata('erro')." </div>"; ?>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo site_url('login') ?>">

            <div class="form-row">
            Tipo de login:&nbsp;
            <div class="form-check form-check-inline">
              <label class="form-check-label">
                  <input required class="form-check-input" type="radio" name="tipo_login" id="tipo_email" value="email" <?php if (($tipo_login=='email') || ($tipo_login=='')) echo "checked"; ?> > E-mail</input>
              </label>
            </div>
            <div class="form-check form-check-inline">
              <label class="form-check-label">
              <input required class="form-check-input" type="radio" name="tipo_login" id="tipo_cnpj" value="cnpj" <?php if ($tipo_login=='cnpj') echo "checked"; ?>> CNPJ</input>
              </label>
            </div>
            <div class="form-check form-check-inline">
              <label class="form-check-label">
              <input required class="form-check-input" type="radio" name="tipo_login" id="tipo_cpf" value="cpf" <?php if ($tipo_login=='cpf') echo "checked"; ?>> CPF</input>
              </label>
            </div>
            </div>
           
            <div class="form-group" id="col_email">
              <label for="email">E-mail</label>
              <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="nome@dominio.com" value="<?php if ($tipo_login=='email') echo $email; ?>">
            </div>
 
            <div class="form-group" id="col_cnpj">
              <label for="cnpj">CNPJ</label>
              <input type="text" class="form-control cnpj" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00" value="<?php if ($tipo_login=='cnpj') echo $cnpj; ?>">
            </div>
  
            <div class="form-group" id="col_cpf">
              <label for="cpf">CPF</label>
              <input type="text" class="form-control cpf" id="cpf" name="cpf" placeholder="000.000.000-00" value="<?php if ($tipo_login=='cpf') echo $cpf; ?>">
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">Senha</label>
              <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" value="<?php echo $senha; ?>">
            </div>
            
            <div class="form-group">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input" id="lembrar" name="lembrar" >
                  Lembrar minhas credenciais
                </label>
              </div>
            </div>
                
              <input type="submit" class="btn btn-success btn-block">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="<?php echo site_url('') ?>">Efetue seu cadastro</a>
            <a class="d-block small" href="#">Esqueceu a senha?</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript >
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script-->

    <script src="<?php echo base_url('painel/assets/pluguins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('painel/assets/pluguins/popper/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('painel/assets/pluguins/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo base_url('painel/assets/pluguins/jquery.mask.js') ?>"></script>
    <script src="<?php echo base_url('painel/assets/js/js.js') ?>"></script>

    <script type="text/javascript">
      $( "#tipo_email" ).click(function() {
        $( "#col_email" ).show();
        $( "#col_cnpj" ).hide();
        $( "#col_cpf" ).hide();
        document.getElementById('cnpj').value="";
        document.getElementById('cpf').value="";
      });

      $( "#tipo_cnpj" ).click(function() {
        $( "#col_email" ).hide();
        $( "#col_cnpj" ).show();
        $( "#col_cpf" ).hide();
        document.getElementById('email').value="";
        document.getElementById('cpf').value="";
      });

      $( "#tipo_cpf" ).click(function() {
        $( "#col_email" ).hide();
        $( "#col_cnpj" ).hide();
        $( "#col_cpf" ).show();
        document.getElementById('cnpj').value="";
        document.getElementById('email').value="";
                
      });
      
      if ('<?php echo $tipo_login; ?>'=='cnpj') document.getElementById("tipo_cnpj").click();
      if ('<?php echo $tipo_login; ?>'=='cpf') document.getElementById("tipo_cpf").click();
      
    </script>

  </body>

</html>
