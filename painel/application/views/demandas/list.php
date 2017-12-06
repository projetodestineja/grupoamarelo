<?php 
if($result){ ?>
<?php foreach($result as $n){
  $capa = '../uploads/empresa/'.$n->ger_id_empresa.'/demanda/mini/'.$n->img;
  $img = (is_file( $capa)?base_url($capa):base_url('assets/img/demanda_sem_img.jpg')); 
?>
<div class="row" style="border-left:5px solid <?php echo $n->cor; ?>;">

     <div class="col-12 col-sm-4 col-md-2 col-lg-3 col-xl-1 text-center" >
       <img src="<?php echo $img; ?>" class="img-thumbnail"  >
       <div class="text-center" >
        Nº <?php echo $n->id; ?>
       </div>
     </div>
     
     <div class="col-12 col-sm-8 col-md-10  col-lg-9 col-xl-10 demanda_list" >

        <div class="row" >
          <div class="col-md-4" >
            <i class="fa fa-chevron-right" aria-hidden="true"></i> 
            <b><?php echo $n->residuo; ?></b>
          </div>
          <div class="col-md-4" >
            <i class="fa fa-cubes" aria-hidden="true"></i>
            <b>QTD:</b> <?php echo $n->qtd.' '.(!empty($n->medida)?$n->medida:$n->uni_medida_outro); ?>
          </div>
          <div class="col-md-4" >
            <i class="fa fa-cube" aria-hidden="true"></i>
            <b>Acondicionado:</b> <?php echo (!empty($n->acondicionado)?$n->acondicionado:$n->acondicionado_outro); ?>
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
            <a class="btn btn-sm btn-warning"  href="<?php echo site_url('demandas/visualizar/'.$n->id); ?>" >
              <i class="fa fa-search-plus" aria-hidden="true"></i> Visualizar
            </a> 
            
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
        <h5>Nenhuma Demanda Cadastrada</h5>
        <br>
      </div>
    </div>  
  </div>
<?php } ?>

