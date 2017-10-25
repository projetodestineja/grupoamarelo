<form class="form_ajax"  onSubmit="send_form(); return false" action="<?php echo site_url('empresa/post_valid_cpf_cnpj'); ?>" method="POST"  >
    <div class="row" > 
        
        <div class="col-md-12" >
            <div class="erro_envio" ></div>
        </div> 
        
        <div class="form-group col-md-12">
            <label for="titulo" class="col-form-label">Tipo de Cadastro</label><br>
            <input name="tipo" type="radio" value="coletora" checked="checked" /> Coletora 
            <input name="tipo" type="radio" value="geradora" /> Geradora 
        </div>
        
        <div class="form-group col-md-12 required">
            <label for="titulo" class="col-form-label">CPF ou CNPJ</label>
            <input name="cpf_cnpj" class="form-control " onkeypress="mascaraMutuario(this,cpfCnpj)" maxlength="18" onblur="clearTimeout()"  value="" id="input-cpf-cnpj" >
        </div>
        
        <div class="form-group col-md-12">
            <button class="btn btn-success btn-md btn-salvar" type="botton" >Cadastrar</button>
        </div>
        
    </div> 
    <div class="loading_form" ></div>
</form>

<script>

 function send_form(){
	
	var form_ind = '.form_ajax';
	$(form_ind+' .btn-salvar').attr('disabled',true);
	$(form_ind+' .required').removeClass('has-error');
	$(form_ind+' .alert-danger').remove();
	$(form_ind+' .loading_form').css("display","block");
	
	$.ajax({
		data: $(form_ind).serialize(),
		type: $(form_ind).attr('method'),
		url: $(form_ind).attr('action'),
		dataType: 'json',
		success: function (json) {
						
			if (json['error_cpf_cnpj']) {
				$(form_ind+' #input-cpf-cnpj').parent().addClass('has-error');
				$(form_ind+' #input-cpf-cnpj').focus();
			}
	
			if (json['redirect']) {
				location.href= json['redirect'];
			}
			
			if (json['error']) {
				$(form_ind+' .erro_envio').after('<div class="alert alert-danger" ><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
						
			$(form_ind+' .loading_form').css("display","none");
			$(form_ind+' .btn-salvar').attr('disabled',false);
			
			return false;
			
		},
		error: function (exr, sender) {
			
			alert('Erro ao carregar pagina');
			
			$(form_ind+' .loading_form').css("display","none");
			$(form_ind+' .btn-salvar').attr('disabled',false);
			
			return false;
		}
	});
}


$(document).ready(function () {
	$('#modal_add_edit #title_modal').html('<?php echo $title; ?>');
});	

	
</script> 

    
 