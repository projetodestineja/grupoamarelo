
<form class="form_ajax"  onSubmit="send_form(); return false" action="<?php echo $action; ?>" method="POST" enctype="multipart/form-data"  >
    <div class="row" > 
          <div class="col-md-12" >
            <div class="erro_envio" ></div>
        </div> 
        <div class="form-group col-md-8 required">
            <label for="titulo" class="col-form-label">Titulo do Arquivo</label>
            <input name="titulo" class="form-control" value="<?php echo $titulo;?>" id="input-titulo" >
        </div>
        <div class="form-group col-md-4 required ">
            <label for="valdiade" class="col-form-label">Data de Validade</label>
            <input name="validade" class="form-control date" value="<?php echo $validade;?>" id="input-validade" style="position:relative" >
        </div>
        
        <div class="form-group col-md-12 required">
            <label for="licenca" class="col-form-label">Arquivo (Somente arquivo PDF,Tamanho Máx. 10MB)</label>
            <input type="file" accept=".pdf" class="form-control" id="input-licenca" name="licenca" >
        </div>
        
        <div class="form-group col-md-12">
            <button class="btn btn-success btn-md btn-salvar" type="botton" >
				<?php echo (isset($id_licenca)?'Atualizar':'Cadastrar'); ?>
            </button>
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
				
				var data;
				var contentType = "application/x-www-form-urlencoded";
				var processData = true;
				if ($(form_ind).attr('enctype') == 'multipart/form-data') {
					data = new FormData($(form_ind).get(0));//seleciona classe form-horizontal adicionada na tag form do html
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
							
							$('#modal_add_edit').modal('toggle');
							alert(json['resposta']);
							$("#result_licenca").load("<?php echo site_url('cadastro/licenca_list/'); ?>", function () {
								/*alert( "carregouuuuu...." );*/
							});
						}
						
						$(form_ind+' .loading_form').css("display","none");
						$(form_ind+' .btn-salvar').attr('disabled',false);
			 
						return false;
					},
					error: function (exr, sender) {
							alert('Erro ao carregar pagina');
							return false;
					}
				});
		
}	
$(document).ready(function () {
  		$('#modal_add_edit #title_modal').html('<?php echo $title; ?>');
  
		$('input[name=validade]').datepicker({
            format: "dd/mm/yyyy",
			autoclose: true,
			    startView: 2,
    			maxViewMode: 2,
            language: "pt-BR",
			orientation: "botton left"
        });
});		
</script> 

    
 