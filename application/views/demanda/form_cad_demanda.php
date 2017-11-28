<form id="form_cad_demanda" class="form_ajax"  onSubmit="send_form(); return false" action="<?php echo $action; ?>" method="POST" enctype="multipart/form-data"  >
	
    <div class="erro_envio" ></div>
    
   
    <div class="card">
      <h5 class="card-header"><i class="fa fa-list" ></i> Informações da Demanda</h5>
      <div class="card-block">
      <div class="col-md-12" >
      
       	<div class="form-row">
        
		<div class="form-group col-md-4 required">
			<label for="residuo" class="col-form-label">Especifique o resíduo:</label>
			<input type="text" class="form-control" id="input-residuo" value="<?php echo $residuo; ?>" name="residuo" placeholder="Ex.: Oléo de cozinha usado">
		</div>
      
		<div class="form-group col-md-4 required">
			<label for="acondicionado" class="col-form-label">Como o resíduo está acondicionado?</label>
			<select class="form-control" id="input-acondicionado" name="acondicionado" >
            <option value="">Selecione</option>
            <?php foreach($acondicionamentos as $n){?>
                <option value="<?php echo $n->id; ?>" <?php echo ($n->id==$acondicionado?'selected':''); ?>  ><?php echo $n->abreviacao;?> - <?php echo $n->nome;?></option>
            <?php } ?>
		 </select>
    	</div>
    
       <div class="form-group col-md-2 required">
			<label for="qtd" class="col-form-label">Quantidade:</label>
			<input type="tel" class="form-control" id="input-qtd" value="<?php echo $qtd; ?>" name="qtd" placeholder="Ex.: 11,5">
       </div>
       
	   <div class="form-group col-md-2 required">
        <label for="uni_medida" class="col-form-label">Uni. de medida:</label>
         <select class="form-control" name="uni_medida" id="input-uni-medida" >
            <option value="">Selecione</option>
            <?php foreach($medidas as $n){?>
                <option value="<?php echo $n->id; ?>" <?php echo ($n->id==$uni_medida?'selected':''); ?>  ><?php echo $n->abreviacao;?> - <?php echo $n->nome;?></option>
            <?php } ?>
		 </select>
	  </div>


	  <div class="form-group col-md-12">
			<label for="acondicionado" class="col-form-label">Categoria resíduo:</label>
			<select class="form-control" id="input-categoria-residuo" name="categoria_residuo" >
            <option value="0">Indefinido</option>
            <?php foreach($categorias_residuos as $n){?>
                <option value="<?php echo $n->id; ?>" <?php echo ($n->id==$categoria_residuo?'selected':''); ?>  >
					<?php echo $n->categoria;?>
				</option>
            <?php } ?>
         </select>
      </div>

    </div>
    
     

	<div class="form-row">
    	
    	<div class="col-md-3">
			<label for="data_inicio" class="col-form-label">Imagem Capa do Anúncio</label><br>	
		    <div class="fileinput fileinput-new" data-provides="fileinput">
            
				<div class="fileinput-new thumbnail" style="width: 210px; height: 160px; border:1px #CCC solid">
					<img src="<?php echo $img_capa; ?>" alt="..." class="img-fluid" >
				</div>
				
				<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 210px; max-height: 160px; border:1px #CCC solid"></div>
              
			  <div >
			  <span class="badge badge-info" >* Tamanho Máx: 10MB</span>
			  </div>	
              <div style="padding:0">
			    
                <span class="btn btn-default btn-file" style="padding-left:0;">
                    <span class="fileinput-new btn-sm btn btn-primary btn-block">
						<i class="fa fa-picture-o" aria-hidden="true"></i> Selecionar Imagem
					</span>
                    <span class="fileinput-exists btn btn-sm btn-warning ">
						<i class="fa fa-refresh" aria-hidden="true"></i> Atualizar
					</span>
                    <input type="file" class="form-control" id="img" name="img">
                </span>

                <a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">
					<i class="fa fa-close" aria-hidden="true"></i> Remover
				</a>

              </div>
              
            </div>
        </div>
        <div class="col-md-9">
        	<div class="row">
            <div class="form-group col-md-6 required" >
			<label for="data_inicio" class="col-form-label">Data início</label>
            <div class="input-group" >
			<input name="data_inicio" class="form-control date" value="<?php echo $data_inicio;?>" placeholder="dd/mm/aaaa" id="input-data-inicio" >
            <label class="input-group-addon btn" for="testdate">
               <span class="fa fa-calendar" ></span>
            </label>
           </div>    
		</div>
		<div class="form-group col-md-6  required" style="padding-left:0" >
			<label for="data_validade" class="col-form-label">Data de expiração</label>
            <div class="input-group" >
			<input name="data_validade" class="form-control date" value="<?php echo $data_validade;?>" placeholder="dd/mm/aaaa" id="input-data-validade"  >
            <label class="input-group-addon btn" for="testdate">
               <span class="fa fa-calendar"></span>
            </label>  
            </div> 
        </div>
        <div class="form-group col-md-12">
            <label for="obs" class="col-form-label">Observações:</label>
             <textarea class="form-control" id="input-obs"  name="obs" rows="5" placeholder="Utilize este campo para observações tais como: dificuldade para entrada de veículos grandes, disponibilidade de horário, etc."><?php echo $obs; ?></textarea>
              </div>
           </div>   
        </div>
   	   </div>
   	  </div>
    </div>
    </div>

	<br />

	<div class="alert alert-info" role="alert">
		<i class="fa fa-asterisk"></i> Altere os campos abaixo caso os dados de contato e/ou endereço sejam diferentes do cadastro.
	</div>

	<div class="card">
      <h5 class="card-header"><i class="fa fa-comment" ></i> Contato para Demanda</h5>
      <div class="card-block">
      <div class="col-md-12" >
      	<div class="form-row">
            <div class="form-group col-md-12 required">
                <label for="responsavel" class="col-form-label">Responsável:</label>
                <input type="text" class="form-control" id="input-responsavel" value="<?php echo $responsavel; ?>" name="responsavel" >
            </div>
            <div class="form-group col-md-6 required">
                <label for="ger_email" class="col-form-label">E-mail:</label>
                <input type="text" class="form-control" id="input-ger-email" value="<?php echo $ger_email; ?>" name="ger_email" >
            </div>
            <div class="form-group col-md-3 required">
                <label for="ger_telefone1" class="col-form-label">Telefone 1:</label>
                <input type="text" class="form-control phone" id="input-ger-telefone1" value="<?php echo $ger_telefone1; ?>" name="ger_telefone1" >
            </div>
            <div class="form-group col-md-3">
                <label for="ger_telefone2" class="col-form-label">Telefone 2:</label>
                <input type="text" class="form-control phone" id="input-ger-telefone2" value="<?php echo $ger_telefone2; ?>" name="ger_telefone2" >
            </div>
        </div>
       </div> 
	  </div>
	</div>
    
    <br />

    
    <div class="card">
      <h5 class="card-header"><i class="fa fa-truck" ></i> Local da Coleta</h5>
      <div class="card-block">
      <div class="col-md-12" >
      	
        <div class="form-row">
    	    <div class="form-group col-md-2 required">
                <label for="cep" class="col-form-label">CEP</label>
                <input type="text" class="form-control cep novo_endereco" id="input-ger-cep" name="ger_cep" placeholder="000000-000" maxlength="8" onblur="pesquisacep(this.value);" value="<?php echo $ger_cep; ?>">
            </div>
            <div class="form-group col-md-5 required">
                <label for="Rua" class="col-form-label">Rua</label>
                <input type="text" class="form-control novo_endereco" id="rua" name="ger_logradouro" placeholder="Ex.: Av. José Silva, Rua São Cosme..." value="<?php echo $ger_logradouro; ?>">
            </div>
            <div class="form-group col-md-2 required">
                <label for="numero" class="col-form-label">Número</label>
                <input type="text" class="form-control novo_endereco" id="numero" name="ger_numero" placeholder="00" value="<?php echo $ger_numero; ?>">
            </div>
            <div class="form-group col-md-3">
                <label for="complemento" class="col-form-label">Complemento</label>
                <input type="text" class="form-control novo_endereco" id="input-ger-complemento" name="ger_complemento" value="<?php echo $ger_complemento; ?>" placeholder="Ex.: Casa, Apartamento...">
            </div>
         </div>
         
         <div class="form-row">
            <div class="form-group col-md-4 required">
                <label for="bairro" class="col-form-label">Bairro</label>
                <input type="text" class="form-control novo_endereco" id="bairro" name="ger_bairro" placeholder="Ex.: São Gonçalo, Manguinhos..." value="<?php echo $ger_bairro; ?>">
            </div>
            <div class="form-group col-md-4 required">
                <label for="estado" class="col-form-label">Estado</label>
                <select class="form-control novo_endereco" id="estado" name="ger_uf_estado">
                    <option value="">Selecione o Estado</option>
                    <?php foreach ($estados as $n) { ?>
                        <option value="<?php echo $n->uf; ?>" <?php echo ($n->uf==$ger_uf_estado?'selected':''); ?> ><?php echo $n->nome_estado; ?></option>
                    <?php } ?>
                </select>
            </div>
    
            <div class="form-group col-md-4 required">
                <label for="cidade" class="col-form-label">Cidade</label>
                <select class="form-control novo_endereco" id="cidade" name="ger_id_cidade">
                        <option value="">Selecione a Cidade</option>
                        <?php foreach ($cidades as $n) {?>
                            <option value="<?php echo $n->id; ?>" <?php echo ($n->id==$ger_id_cidade?'selected':''); ?>  ><?php echo $n->nome_cidade;?></option>
                         <?php } ?>
                </select>
            </div>
		</div>
    
       </div> 
	  </div>
	</div>
    <br />

    <div >
		<button class="btn btn-success btn-md btn-salvar" type="submit" ><?php echo (!isset($id)?'Cadastrar':'Atualizar'); ?></button>
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
		/*seleciona classe form-horizontal adicionada na tag form do html*/
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
			
			if (json['error']) {
				$(form_ind+' .erro_envio').after('<div class="alert alert-danger" ><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
			
			if (json['error_ger_id_cidade']) {
				$(form_ind+' #cidade').parent().addClass('has-error');
				$(form_ind+' #cidade').focus();
			}
			
			if (json['error_ger_uf_estado']) {
				$(form_ind+' #estado').parent().addClass('has-error');
				$(form_ind+' #estado').focus();
			}
			
			if (json['error_ger_bairro']) {
				$(form_ind+' #bairro').parent().addClass('has-error');
				$(form_ind+' #bairro').focus();
			}
			
			if (json['error_ger_numero']) {
				$(form_ind+' #numero').parent().addClass('has-error');
				$(form_ind+' #numero').focus();
			}
			
			if (json['error_ger_logradouro']) {
				$(form_ind+' #rua').parent().addClass('has-error');
				$(form_ind+' #rua').focus();
			}
			
			if (json['error_ger_cep']) {
				$(form_ind+' #input-ger-cep').parent().addClass('has-error');
				$(form_ind+' #input-ger-cep').focus();
			}
			
			if (json['error_ger_telefone1']) {
				$(form_ind+' #input-ger-telefone1').parent().addClass('has-error');
				$(form_ind+' #input-ger-telefone1').focus();
			}
			
			if (json['error_ger_email']) {
				$(form_ind+' #input-ger-email').parent().addClass('has-error');
				$(form_ind+' #input-ger-email').focus();
			}
			
			if (json['error_responsavel']) {
				$(form_ind+' #input-responsavel').parent().addClass('has-error');
				$(form_ind+' #input-responsavel').focus();
			}
			
			if (json['error_data_inicio']) {
				$(form_ind+' #input-data-inicio').focus();
			}else
			if (json['error_data_validade']) {
				$(form_ind+' #input-data-validade').focus();
			}		
			
			if (json['error_data_inicio']) {
				$(form_ind+' #input-data-inicio').parent().parent().addClass('has-error');
			}
			if (json['error_data_validade']) {
				$(form_ind+' #input-data-validade').parent().parent().addClass('has-error');
			}

			if (json['error_uni_medida']) {
				$(form_ind+' #input-uni-medida').parent().addClass('has-error');
				$(form_ind+' #input-uni-medida').focus();
			}
			
			if (json['error_qtd']) {
				$(form_ind+' #input-qtd').parent().addClass('has-error');
				$(form_ind+' #input-qtd').focus();
			}
			
			if (json['error_acondicionado']) {
				$(form_ind+' #input-acondicionado').parent().addClass('has-error');
				$(form_ind+' #input-acondicionado').focus();
			}
				
			if (json['error_residuo']) {
				$(form_ind+' #input-residuo').parent().addClass('has-error');
				$(form_ind+' #input-residuo').focus();
			}
			
			if (json['ok']==true) {
				location.href = json['redirect'];
			}
						
			$(form_ind+' .loading_form').css("display","none");
			$(form_ind+' .btn-salvar').attr('disabled',false);
			
			return false;
		},
		error: function (exr, sender) {
			$(form_ind+' .loading_form').css("display","none");
			$(form_ind+' .btn-salvar').attr('disabled',false);
			alert('Erro ao carregar pagina');
			return false;
		}
	});
}	

/*$("#outro_endereco").click( function(){
   if( $(this).is(':checked') ){
		//alert("checked");
		$('.novo_endereco').removeAttr('readonly');
	 } else{
		//alert("rapaz q blz");
		$('.novo_endereco').attr('readonly','');
	 }
});*/

$(document).ready(function () {
	
	$(".fileinput").fileinput();
	
	/* Datepicker para mostrar calendarário */
	$("input[name=data_inicio]").datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR",
		orientation: "botton left",
		startDate: new Date(),
		allowInputToggle: true,
		autoclose: true,
	}).on('changeDate', function (selected) {
		var startDate = new Date(selected.date.valueOf());
		$('input[name=data_validade').datepicker('setStartDate', startDate);
	}).on('clearDate', function (selected) {
		$('input[name=data_validade').datepicker('setStartDate', null);
	});
	
	$("input[name=data_validade").datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR",
		orientation: "botton left",
		startDate: new Date(),
		allowInputToggle: true,
		autoclose: true,
	}).on('changeDate', function (selected) {
		var endDate = new Date(selected.date.valueOf());
		$('input[name=data_inicio]').datepicker('setEndDate', endDate);
	}).on('clearDate', function (selected) {
		$('input[name=data_inicio]').datepicker('setEndDate', null);
	});
	
	/* Select Estado pra carregar Cidades */
	$("select[name=ger_uf_estado]").change(function () {
		var estado = $(this).val();
		resetaCombo('ger_id_cidade');
		load_cidades(estado);
	});
		
});


function load_cidades(estado, cidade = false) {
	
	var url_json = '<?php echo site_url(); ?>' + 'empresa/getcidades/' + estado;
	if(cidade){
		url_json+='?cidade='+cidade;
	}
	
	$.getJSON(url_json, function (data) {

		var option = new Array();

		$.each(data, function (i, obj) {

				option[i] = document.createElement('option');
				$(option[i]).attr({value: obj.id});
				if (obj.selected != '') {
						$(option[i]).attr({selected: obj.selected});
				}
				$(option[i]).append(obj.nome_cidade);

				$("select[name=ger_id_cidade]").append(option[i]);

		});

	});

}

function resetaCombo(el) {
	$("select[name='" + el + "']").empty();
	var option = document.createElement('option');
	$(option).attr({value: ''});
	$(option).append('Selecione a Cidade');
	$("select[name='" + el + "']").append(option);
}

</script>
