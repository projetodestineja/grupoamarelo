<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" href="#demanda" role="tab" data-toggle="tab">Demanda</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#propostas_recebidas" role="tab" data-toggle="tab">Propostas Recebidas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#historico_status" role="tab" data-toggle="tab">Histórico Status</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#mensagens" role="tab" data-toggle="tab">Mensagens</a>
    </li>
</ul>

<div class="tab-content">
  <div role="tabpanel" class="tab-pane  active" id="demanda">

	<div class="card">
      <h5 class="card-header"><i class="fa fa-list" ></i> Informações da Demanda</h5>
      <div class="card-block">
      
      
      	<div class="col-md-12" >
      
		<div class="form-row">
            <div class="col-md-2">
                <img src="<?php echo $row['img']; ?>" alt="..." class="img-fluid"  >
            </div>
        	<div class="col-md-10">
         <div class="resposta_json" ></div>
        	<div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <label><span class="fa fa-chevron-right"></span> Resíduo</label><br>
                    <?php echo $row['residuo']; ?>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <label><i class="fa fa-cubes" aria-hidden="true"></i> QTD:</label><br>
                    <?php echo $row['qtd']; ?> <?php echo $row['uni_medida_nome']; ?>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <label><i class="fa fa-cube" aria-hidden="true"></i> Acondicionamento</label><br>
                    <?php echo $row['acondicionado']; ?>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3" >
                    <label><span class="fa fa-calendar"></span> Data Início / Expiração</label><br>
                    <?php echo $row['data_inicio'];?> - <?php echo $row['data_validade'];?>
            	</div>
               </div>
    
        
        	<div class="row">
            
            	<?php if(!empty($row['obs'])){ ?>
            	<div class="form-group col-md-12">
            		<label>Observações:</label><br>
            		<?php echo $row['obs']; ?>
              	</div>
                <?php } ?>
           		
                <div class="form-group col-md-12"><hr></div>
                
            	<div class="form-group col-md-6" >
                    <form id="form_update_status" class="form_ajax"  onSubmit="send_form(); return false" action="<?php echo site_url('demandas/post_update_status'); ?>" method="POST"  >
                        <div class="row" >
                        <div class="form-group col-md-6" >
                            <select name="status" class="form-control" >
                                <?php foreach($result_status as $n){?>
                                <Option value="<?php echo $n->id; ?>" <?php echo ($row['status']==$n->id?'selected':''); ?> ><?php echo $n->descricao; ?></Option>
                                <?php } ?>
                            </select>
                            <input name="id_demanda" type="hidden" value="<?php echo $row['id']; ?>" />
                        </div>
                        <div class="form-group col-md-6" >  
                            <button class="btn btn-primary btn-md btn-block btn-salvar-post"  ><i class="fa fa-hand-pointer-o" aria-hidden="true"></i> Atualizar</button>
                        </div>
                        </div>     
                   </form>    
               </div>
               
               <div class="form-group col-6 col-md-3" >
                 <span class="fa fa-calendar"></span>
                 <label>Cadastrado</label><br>
                 <?php echo $row['cadastrada'];?>h
               </div>
                
               <div class="form-group col-6 col-md-3" >
                 <span class="fa fa-calendar"></span>
                 <label>Atualizado</label> <br>
                 <span class="date_update_demanda" ><?php echo $row['atualizada'];?></span>h
               </div>
            </div> 
                
        </div>
   	   </div>
   	  </div>
    </div>
    </div>

	<br />



	<div class="card">
      <h5 class="card-header"><i class="fa fa-comment" ></i> Contato para Demanda</h5>
      <div class="card-block">
      <div class="col-md-12" >
      	<div class="form-row">
            <div class="form-group col-md-12">
                <label>Responsável:</label><br>
                <?php echo $row['responsavel']; ?>
            </div>
            <div class="form-group col-md-6">
                <label >E-mail:</label><br>
                <?php echo $row['ger_email']; ?>
            </div>
            <div class="form-group col-md-3">
                <label>Telefone 1:</label><br>
				<?php echo $row['ger_telefone1']; ?>
            </div>
            <div class="form-group col-md-3">
                <label >Telefone 2:</label><br>
                <?php echo $row['ger_telefone2']; ?>
            </div>
        </div>
       </div> 
	  </div>
	</div>
    
    <br />

    
    <div class="card">
      <h5 class="card-header"><i class="fa fa-truck" ></i> Local de Coleta</h5>
      <div class="card-block">
      <div class="col-md-12" >
      	
        <div class="form-row">
    	    <div class="form-group col-md-2">
                <label>CEP</label><br>
                <?php echo $row['ger_cep']; ?>
            </div>
            <div class="form-group col-md-5">
                <label>Rua</label><br>
                <?php echo $row['ger_logradouro']; ?>
            </div>
            <div class="form-group col-md-2">
                <label>Número</label><br>
                <?php echo $row['ger_numero']; ?>
            </div>
            <div class="form-group col-md-3">
                <label>Complemento</label><br>
                <?php echo $row['ger_complemento']; ?>
            </div>
         </div>
         
         <div class="form-row">
            <div class="form-group col-md-4">
                <label>Bairro</label><br>
                <?php echo $row['ger_bairro']; ?>
            </div>
            <div class="form-group col-md-4">
                <label>Estado</label><br>
                <?php echo $row['ger_uf_estado']; ?>
            </div>
    
            <div class="form-group col-md-4">
            	<label>Cidade</label><br>
                <?php echo $row['ger_nome_cidade']; ?>
            </div>
		</div>
    
       </div> 
	  </div>
	</div>
    <br />
    
    
    <?php if($row['col_id_empresa']){ ?>
    <div class="card">
      <h5 class="card-header"><i class="fa fa-truck" ></i> Empresa Coletora</h5>
      <div class="card-block">
      <div class="col-md-12" >
      	
        <div class="form-row">
    	    <div class="form-group col-md-2">
                <label>CEP</label><br>
                <?php echo $row['col_cep']; ?>
            </div>
            <div class="form-group col-md-5">
                <label>Rua</label><br>
                <?php echo $row['col_logradouro']; ?>
            </div>
            <div class="form-group col-md-2">
                <label>Número</label><br>
                <?php echo $row['col_numero']; ?>
            </div>
            <div class="form-group col-md-3">
                <label>Complemento</label><br>
                <?php echo $row['col_complemento']; ?>
            </div>
         </div>
         
         <div class="form-row">
            <div class="form-group col-md-4">
                <label>Bairro</label><br>
                <?php echo $row['col_bairro']; ?>
            </div>
            <div class="form-group col-md-4">
                <label>Estado</label><br>
                <?php echo $row['col_uf_estado']; ?>
            </div>
    
            <div class="form-group col-md-4">
            	<label>Cidade</label><br>
                <?php echo $row['col_nome_cidade']; ?>
            </div>
		</div>
    
       </div> 
	  </div>
	</div>
    <br />
    <?php } ?>
    	<div class="loading_form" ></div>
	</div>
    
    <div role="tabpanel" class="tab-pane" id="propostas_recebidas">
    	<div id="list_propostas_recebidas" ><img src="<?php echo base_url('assets/img/ajax-loader.gif') ?>" ></div>
    </div>
    
    <div role="tabpanel" class="tab-pane" id="historico_status">
    	<div id="list_hitorico_status" ><img src="<?php echo base_url('assets/img/ajax-loader.gif') ?>" ></div>
    </div>
    
    <div role="tabpanel" class="tab-pane" id="mensagens">
        <div id="list_hitorico_mensagens" ><img src="<?php echo base_url('assets/img/ajax-loader.gif') ?>" ></div>
    </div>
    
</div>
<script>

$("#list_propostas_recebidas").load("<?php echo site_url('proposta/listar_propostas/'.$row['id']); ?>");
$("#list_hitorico_status").load("<?php echo site_url('demandas/status_demanda_historico/'.$row['id']); ?>");
$("#list_hitorico_mensagens").load("<?php echo site_url('mensagens/mensagens_demanda/'.$row['id']); ?>");

function send_form(){
	
	var form_ind = '.form_ajax';
	$(form_ind+' .btn-salvar-post').attr('disabled',true);
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
				$('.resposta_json').html('<div class="alert alert-danger" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
			
			if (json['ok']) {
				$('.resposta_json').html('<div class="alert alert-success" ><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle"></i> ' + json['ok'] + '</div>');
				$('span.date_update_demanda').html(json['data_update']);
				
				$("#list_hitorico_status").load(json['load']);
				
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
			
			if (json['error_status']) {
				$(form_ind+' #input-status').parent().addClass('has-error');
				$(form_ind+' #input-status').focus();
			}
						
			$(form_ind+' .loading_form').css("display","none");
			$(form_ind+' .btn-salvar-post').attr('disabled',false);
			
			return false;
		},
		error: function (exr, sender) {
			$(form_ind+' .loading_form').css("display","none");
			$(form_ind+' .btn-salvar-post').attr('disabled',false);
			alert('Erro ao carregar pagina');
			return false;
		}
	});
}	
</script>
