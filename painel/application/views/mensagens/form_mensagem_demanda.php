<form class="form_ajax_msg"  onSubmit="send_form_mensagem(); return false" action="<?php echo $action; ?>" method="POST"  >
    <div class="row" > 
        <div class="col-md-12" >
            <div class="erro_envio" ></div>
        </div> 
        <div class="form-group col-md-12 required">
            <label for="titulo" class="col-form-label">Assunto</label>
            <input name="assunto" type="text" value="<?php echo $assunto; ?>"  id="input-assunto" class="form-control" />
        </div>
        <div class="form-group col-md-12 required">
            <label for="msg" class="col-form-label">Mensagem</label>
            <textarea name="msg" cols="" rows="5" class="form-control" id="input-msg" ><?php echo $msg; ?></textarea>
        </div>
        <div class="form-group col-md-12 required">
        	<input name="alert_email" type="checkbox" value="1" checked /> Também notificar por e-mail
        </div>
        <div class="form-group col-md-12">
		    <button class="btn btn-success btn-md btn-salvar" type="botton" >Enviar Mensagem</button>
        </div>
    </div> 
    <div class="loading_form" style="display:block" ></div>
</form>

<script>

 function send_form_mensagem(){
	
	var form_ind = '.form_ajax_msg';
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
						
			if (json['error_msg']) {
				$(form_ind+' #input-msg').parent().addClass('has-error');
				$(form_ind+' #input-msg').focus();
			}
			
			if (json['error_assunto']) {
				$(form_ind+' #input-assunto').parent().addClass('has-error');
				$(form_ind+' #input-assunto').focus();
			}
	
			if (json['close_modal']) {
				alert(json['resposta']);
				$('#modal_add_edit').modal('hide')
			}

			if(json['load']){
				$("#list_hitorico_mensagens").load(json['load']);
			}
			
			if (json['error']) {
				$(form_ind+' .erro_envio').html('<div class="alert alert-danger" ><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
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
	$('.loading_form').hide();
});	
		
</script> 

    
 