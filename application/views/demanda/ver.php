
<?php  if ($this->session->flashdata('msg_proposta')) echo "<div class=\"alert alert-success\">".$this->session->flashdata('msg_proposta')."</div>"; ?>
    
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link <?php if ($tab_ativa=='demanda') echo "active"; ?>" href="#demanda" role="tab" data-toggle="tab">Demanda</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if ($tab_ativa=='proposta') echo "active"; ?>" href="#propostas" role="tab" data-toggle="tab"><?php echo $tab_proposta; ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if ($tab_ativa=='inf_coleta') echo "active"; ?>" href="#inf_coleta" role="tab" data-toggle="tab">Comprovante de Destinação</a>
    </li>
    <?php if($tab_cert_entrega){ ?>
    <li class="nav-item">
        <a class="nav-link" href="#cert_coleta" role="tab" data-toggle="tab">Certificado de Entrega</a>
    </li>
    <?php } ?>
   <?php if($this->session->userdata['empresa']['funcao']==1){ // Geradora?>
    <li class="nav-item">
        <a class="nav-link" href="#mensagens" role="tab" data-toggle="tab">Mensagens</a>
    </li>
     <li class="nav-item">
        <a class="nav-link" href="#historico" role="tab" data-toggle="tab">Histórico</a>
    </li>
    <?php } ?>
</ul>

<div class="tab-content">

  <?php if($this->session->userdata['empresa']['funcao']==1){ // Geradora?>
  <div role="tabpanel" class="tab-pane" id="mensagens">	
	<div id="list_hitorico_mensagens"></div>
  </div>
  
  <div role="tabpanel" class="tab-pane" id="historico">	
	<div id="list_hitorico_status"></div>
  </div>
  <?php } ?>
  
  <div role="tabpanel" class="tab-pane" id="cert_coleta" >	
  <?php
  if($tab_cert_entrega){
  	$this->load->view('coleta/form_upload_comprovante');
  } 	 
  ?>
  </div>
  
  <div role="tabpanel" class="tab-pane  <?php if ($tab_ativa=='demanda') echo "active"; ?>" id="demanda">

	<div class="card">
      <h5 class="card-header"><i class="fa fa-list" ></i> Informações</h5>
      <div class="card-block">
      
      
      	<div class="col-md-12" >
      
		<div class="form-row">
            <div class="col-md-2 text-center">
            	<?php if(!empty($row['img_media'])){ ?>
            	<a href="<?php echo $row['img_media']; ?>" class="zoom-foto" title="<?php echo $row['residuo']; ?>" >
                	<img src="<?php echo $row['img']; ?>" alt="..." class="img-fluid" >
                </a>
                <?php }else{ ?>
                	<img src="<?php echo $row['img']; ?>" alt="..." class="img-fluid" >
                <?php } ?>
            </div>
        	<div class="col-md-10">
         <div class="resposta_json" ></div>
        	<div class="form-row">
                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3" >
                    <label><span class="fa fa-chevron-right"></span> Resíduo</label><br>
                    <?php echo $row['residuo']; ?>
                </div>
                <div class="form-group col-12 col-sm-6  col-md-6 col-lg-6 col-xl-3">
                    <label><i class="fa fa-cubes" aria-hidden="true"></i> QTD:</label><br>
                    <?php echo $row['qtd']; ?> <?php echo $row['uni_medida_nome']; ?>
                </div>
                <div class="form-group col-12 col-sm-6  col-md-6 col-lg-6 col-xl-3">
                    <label><i class="fa fa-cube" aria-hidden="true"></i> Acondicionamento</label><br>
                    <?php echo $row['acondicionado']; ?>
                </div>
                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3" >
                    <label><span class="fa fa-calendar"></span> Data Início / Expiração</label><br>
                    <?php echo $row['data_inicio'];?> / <?php echo $row['data_validade'];?>
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
                    <label><i class="fa fa-asterisk" aria-hidden="true"></i> Status:</label><br>
            		<?php echo $row['status_nome']; ?>
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

    
    <?php if($row['info_completa']){ ?>
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
    <?php } ?>

    
    <div class="card">
      <h5 class="card-header"><i class="fa fa-truck" ></i> Local da Coleta</h5>
      <div class="card-block">
      <div class="col-md-12" >
      	
        <?php if($row['info_completa']){ ?>  
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
        <?php } ?>

         <div class="form-row">
            <div class="form-group col-md-4">
                <label>Bairro</label><br>
                <?php echo $row['ger_bairro']; ?>
            </div>
            <div class="form-group col-md-4">
                <label>Cidade / UF</label><br>
                <?php echo $row['ger_nome_cidade']; ?> / <?php echo $row['ger_uf_estado']; ?>
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
                <label>Cidade / UF</label><br>
                <?php echo $row['col_nome_cidade']; ?> / <?php echo $row['col_uf_estado']; ?>
            </div>
    
		</div>
    
       </div> 
	  </div>
	</div>
    <br />
    <?php } ?>
  </div>
    
<script>
$(document).ready(function () {
  <?php if($this->session->userdata['empresa']['funcao']==1){ // Geradora?>
  $("#list_hitorico_status").load("<?php echo site_url('demanda/status_demanda_historico/'.$row['id']); ?>");
  $("#list_hitorico_mensagens").load("<?php echo site_url('mensagens/mensagens_demanda/'.$row['id']); ?>");
  <?php } ?>
  
  $(".remover" ).click(function() {
	if (confirm($(this).attr('title')) == true) {
       location.href= $(this).attr('rel');
    }
  });
});  
</script>      


