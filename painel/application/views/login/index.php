<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Destine Já - Login</title>

    <link rel="stylesheet" href="<?php echo base_url('assets/css/css.css') ?>">

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
            <form class="form-login" action="<?php echo site_url('login/validar_login_post'); ?>" method="post" >
             
            <div class="form-group" id="col_email">
              <label for="login">E-mail</label>
              <input type="email" name="login" class="form-control" id="login" aria-describedby="login" placeholder="nome@dominio.com">
            </div>

            <div class="form-group">
              <label for="senha">Senha</label>
              <input type="password" name="senha" class="form-control" id="senha" placeholder="Digite sua senha">
            </div>
           <!--     
            <div class="form-group">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input">
                  Lembrar minhas credenciais
                </label>
              </div>
            </div>
            -->    
            <button type="submit" class="btn btn-success btn-block" ><i class="fa fa-lock" aria-hidden="true"></i> Entrar</button>     
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
  
    <script>
    $(document).ready(function(){
      /* carrega o focus no campo login no load da pagina */  
      $('input[name=login]').focus();
      
      $('.form-login').submit(function(){
          var login = $('input[name=login]').val();
          var senha = $('input[name=senha]').val();
          var erro = '';
          
          if(login==''){
              alert('Digite seu e-mail de login!');
              $('input[name=login]').focus();
          }else
          if(senha==''){
              alert('Digite sua senha!');
              $('input[name=login]').focus();
          }else{
             $.ajax({
              url: $(this).attr("action"), 
              dataType: "json",
              type: "POST",  
              data: $(this).serialize(),
              success: function(json){ 
                   if(json.erro!=""){
                     alert(json.erro);
                   }else{
                     location.href=json.redirect;
                   }
                   return false;
                }
             });
          }
          return false;
       });
    });
    </script>

  </body>

</html>
