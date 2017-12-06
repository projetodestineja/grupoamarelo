<?php if($result){ ?>
<div class="list-group">
<?php foreach($result as $n){?>
  <div id="item-<?php echo $n->id; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1"><?php echo $n->assunto; ?></h5>
      <small><i class="fa fa-paper-plane" aria-hidden="true"></i>  <?php echo date('d/m/y H:i',strtotime($n->cadastrada)); ?>h</small>
    </div>
    <p class="mb-1"><?php echo $n->msg; ?></p>
    
    <div class="row">
    
    <div class="col-md-12 text-right" >
     Informado por e-mail: <?php echo ($n->alert_email==true?'SIM':'NÂO'); ?>
    </div>
    
    </div>
  </div>
<?php } ?> 
</div>
<?php  }else{  ?>
  <h5><i class="fa fa-comments" aria-hidden="true"></i> Nenhuma mensagem recebida</h5>
<?php } ?>
