<div class="col-md-12" >

    <?php if($this->session->userdata['empresa']['funcao'] ==2){ ?>
    <form class="form_ajax"  onSubmit="send_form(); return false" action="<?php echo site_url('demanda/comprovante_arquivo_add/'.$id_demanda); ?>" method="POST" enctype="multipart/form-data"  >
        <div class="row" > 
              <div class="col-md-12" >
                <div class="erro_envio" ></div>
            </div> 
            <div class="form-group col-md-6 required">
                <label for="titulo" class="col-form-label">Titulo do Arquivo</label>
                <input name="titulo" class="form-control" value="" id="input-titulo" >
            </div>
            <div class="form-group col-md-6 required">
                <label for="licenca" class="col-form-label">Arquivo (Somente arquivo PDF,Tamanho Máx. 10MB)</label>
                <input type="file" accept=".pdf" class="form-control" id="input-licenca" name="licenca" >
            </div>
            <div class="form-group col-md-12">
                <button class="btn btn-success btn-md btn-salvar" type="botton" >Cadastrar Arquivo</button>
            </div>
        </div> 
        <div class="loading_form" ></div>
    </form>
    <?php } ?>
    <div id="comprovante_arquivo" ></div>

<hr>

</div>

<script>

function send_form(){
	
	var form_ind = '.form_ajax';
	$(form_ind+' .btn-salvar').attr('disabled',true);
	$(form_ind+' .required').removeClass('has-error');
	$(form_ind+' .alert-danger').remove();
	$(form_ind+' .loading_form').css("display","block");
				
	var data;
	var contentType = "application/x-www-form-urlencoded";
	var processData = true;
	if ($(form_ind).attr('enctype') == 'multipart/form-data') {
		data = new FormData($(form_ind).get(0));
		contentType = false;
		processData = false;
	} else {
		data = $(form_ind).serialize();
	}
	
	$.ajax({
		data: data,
		type: $(form_ind).attr('method'),
		url: $(form_ind).attr('action'),
		contentType: contentType,
		dataType: 'json',
		processData: processData,
		success: function (json) {
						
			if (json['error_status']) {
				$(form_ind+' .input-status').parent().parent().addClass('has-error');
				$(form_ind+' .input-status').focus();
			}
			if (json['error_licenca']) {
				$(form_ind+' #input-licenca').parent().addClass('has-error');
				$(form_ind+' #input-licenca').focus();
			}
			if (json['error_validade']) {
				$(form_ind+' #input-validade').parent().addClass('has-error');
			}
			if (json['error_titulo']) {
				$(form_ind+' #input-titulo').parent().addClass('has-error');
				$(form_ind+' #input-titulo').focus();
			}
			if (json['error']) {
				$(form_ind+' .erro_envio').after('<div class="alert alert-danger" ><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			if (json['ok']==true) {
				$(form_ind).each(function(){ this.reset(); });
				comprovante_arquivo_list(json['id_demanda'])
				alert(json['resposta']);
			}
				
			$(form_ind+' .loading_form').css("display","none");
			$(form_ind+' .btn-salvar').attr('disabled',false);
			 
			return false;
	},
	error: function (exr, sender) {
		alert('Erro ao carregar pagina');
		$(form_ind+' .btn-salvar').attr('disabled',false);
		$(form_ind+' .loading_form').css("display","none");
		return false;
	}
	});
}

function comprovante_arquivo_list(id_demanda){
	$("#comprovante_arquivo").load("<?php echo site_url('demanda/comprovante_arquivo_list/'); ?>"+id_demanda); 	
}
	
$(document).ready(function () {
	comprovante_arquivo_list(<?php echo $id_demanda; ?>);
	$('#modal_add_edit #title_modal').html('<?php echo $title; ?>');
});		
</script> 

    
 