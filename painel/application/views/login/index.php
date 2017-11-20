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

  <body class="bg-light">

    <div class="container">

      <div class="card card-login mx-auto mt-5">
        <div class="card-header">
          <center>
          <img width="200px" src="<?php echo base_url('assets/img/destinejalogo.png') ?>"/>
          <h3 style="margin:20px 0;">Acesse seu painel</h3>
          </center>
        </div>
        <div class="card-body">
        
            <form class="form-login" id="form-login" action="<?php echo site_url('login/validar_login_post'); ?>" method="post" >

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
            <button type="submit" class="btn btn-success btn-block  botao" ><i class="fa fa-lock" aria-hidden="true"></i> Entrar</button>
            <div class="text-center" style="margin-top:5px;">
            	<a class="d-block small" id="btn-rec-senha" href="javascript:void(0)">Esqueceu a senha?</a>
            </div>
           </form>
          
          	
            <form method="post" id="form_rec_senha" action="<?php echo site_url('login/recuperar_senha');?>" style="display:none" >
              
              <div class="form-group" id="col_email">
              <h3>Recuperar Senha</h3>
              <label for="login">Digite seu E-mail</label>
              <input type="email" name="email" class="form-control" id="email" aria-describedby="email" placeholder="nome@dominio.com">
             </div>
             <div class="form-group">
             	<button type="submit" class="btn btn-warning btn-block  botao"  ><i class="fa fa-send" aria-hidden="true"></i> Enviar</button>
             </div>
             
             <div class="form-group">
             	<button type="button" class="btn btn-danger btn-block botao" id="btn-rec-senha-close" ><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</button>
             </div>
            </form>
            
         
        </div>
      </div>
    </div>


    <script src="<?php echo base_url('assets/pluguins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/pluguins/popper/popper.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/pluguins/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <script>
    $(document).ready(function(){
		
      $('#btn-rec-senha,#btn-rec-senha-close').on("click", function() {
        $('#form_rec_senha,#form-login').slideToggle();
      });

      /* carrega o focus no campo login no load da pagina */
      $('input[name=login]').focus();

      $('#form-login').submit(function(){
		  
		  $('#form-login .botao').attr("disabled",true);
		  
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
		  $('#form-login .botao').attr("disabled",false);
          return false;
       });
	   
	   
	   $('#form_rec_senha').submit(function(){
		   
		  $('.botao').attr("disabled",true);
		   
          var email = $('input[name=email]').val();
          var erro = '';

          if(email==''){
			  
              alert('Digite seu e-mail!');
              $('input[name=email]').focus();
			  
          }else{
             $.ajax({
              url: $(this).attr("action"),
              dataType: "json",
              type: "POST",
              data: $(this).serialize(),
              success: function(json){
				  
                  alert(json.resposta);
                  return false;
                }
             });
			    }
		      $('.botao').attr("disabled",false);
          return false;
       });
	   
    });
    </script>

  </body>

</html>
