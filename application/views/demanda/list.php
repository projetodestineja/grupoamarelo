<?php 
if($result){ ?>
<?php foreach($result as $n){
  $capa = 'uploads/empresa/'.$n->ger_id_empresa.'/demanda/mini/'.$n->img;
  $img = (is_file( $capa)?base_url($capa):base_url('painel/assets/img/demanda_sem_img.jpg')); 
?>
<div class="row" >

     <div class="col-12 col-sm-4 col-md-2 col-lg-3 col-xl-1" >
       <img src="<?php echo $img; ?>" class="img-thumbnail"  >
     </div>
     
     <div class="col-12 col-sm-8 col-md-10  col-lg-9 col-xl-10 demanda_list" >

        <div class="row" >
          <div class="col-md-4" >
            <i class="fa fa-chevron-right" aria-hidden="true"></i> 
            <b><?php echo $n->residuo; ?></b>
          </div>
          <div class="col-md-4" >
            <i class="fa fa-cubes" aria-hidden="true"></i>
            <b>QTD:</b> <?php echo $n->qtd.' '.$n->medida; ?>
          </div>
          <div class="col-md-4" >
            <i class="fa fa-cube" aria-hidden="true"></i>
            <b>Acondicionado:</b> <?php echo $n->acondicionado; ?>
          </div> 
        </div>
        
        <div class="row" >
          <div class="col-md-4" >
          <i class="fa fa-calendar" aria-hidden="true"></i>
            <b>Período:</b> <?php echo date('d/m/y',strtotime($n->data_inicio)). " à ".date('d/m/y',strtotime($n->data_validade)); ?>
          </div>
          <div class="col-md-4" >
            <div style="color:<?php echo $n->cor; ?>;"> 
              <i class="fa fa-asterisk" aria-hidden="true"></i>
              <?php echo $n->status; ?>
            </div>
          </div> 
          <div class="col-md-4" >
            <i class="fa fa-map-marker" aria-hidden="true"></i>
            <b>Localização:</b> <?php echo $n->nome_cidade. "/".$n->ger_uf_estado; ?>
          </div>
        </div>
        
        <?php if(!empty($n->obs)){?>
          <div class="row" >  
            <div class="col-md-12" >
             <?php echo $n->obs; ?>
            </div>  
          </div>
        <?php } ?>

        <div class="row" > 
          <div class="col-md-12" > 
          	  <a class="btn btn-sm btn-warning"  href="<?php echo site_url('demanda/visualizar/'.$n->id); ?>" >
              	<i class="fa fa-search-plus" aria-hidden="true"></i> Visualizar
              </a>
            <?php if ($this->session->userdata['empresa']['funcao']==1){ ?>
              <a class="btn btn-sm btn-primary" href="<?php echo site_url('demanda/edit/'.$n->id); ?>" >
                <i class="fa fa-list" ></i> Atualizar
              </a>
              <a class="btn btn-sm btn-danger remover" title="Remover Demanda <?php echo $n->residuo; ?> ?" href="<?php echo site_url('demanda/delete/'.$n->id); ?>" >
                <i class="fa fa-close" ></i> Remover
              </a>
            <?php } ?> 
            
          </div> 
        </div>
   </div> 

</div> 

<hr>

<?php } ?>  

  <?php echo $pagination; ?>

<?php }else{ ?>
  <div class="card">
    <div class="card-block">
      <div class="col-md-12" ><br>
        <h5>Nehuma Demanda Cadastrada</h5>
        <br>
      </div>
    </div>  
  </div>
<?php } ?>

