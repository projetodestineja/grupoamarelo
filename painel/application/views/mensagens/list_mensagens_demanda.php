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
    <div class="col-md-6" >
     <?php echo character_limiter($n->razao_social,30); ?><br><?php echo $n->nome_responsavel; ?> 
    </div>
    <div class="col-md-6 text-right" >
    <a href="<?php echo site_url('mensagens/mensagem_demanda/'.$n->id_demanda.'/'.$n->id_empresa.'/'.$n->id); ?>" rel="modal_add_edit" class="btn btn-sm btn-warning" >
      <i class="fa fa-pencil-square-o" ></i>
    </a>
    <a href="javascript:void(0)" rel="<?php echo $n->id; ?>" title="<?php echo $n->assunto; ?>" class="btn btn-sm btn-danger btn-remover" >
      <i class="fa fa-trash" ></i>
    </a><br>
     Informado por e-mail: <?php echo ($n->alert_email==true?'SIM':'NÂO'); ?>
    </div>
    
    </div>
  </div>
<?php } ?> 
</div>
<?php  }else{  ?>
  <h5><i class="fa fa-comments" aria-hidden="true"></i> Nenhuma mensagem enviada</h5>
<?php } ?>

<script>
 $(document).ready(function () {
  $('a[rel=modal_add_edit]').on('click', function (evt) {
    evt.preventDefault();
    $('#modal_add_edit').modal({backdrop: 'static', keyboard: false}).modal('show').find('.modal-body').load($(this).attr('href'));
    return false;
  }); 

  $('a.btn-remover').on('click', function (evt) {

    if(confirm("Remover Mensagem: "+$(this).attr('title'))){
      var id_delete = $(this).attr('rel');
      $.getJSON('<?php echo site_url('mensagens/remover'); ?>', { id_delete: id_delete } , function( json ) {
          if(json.ok==true){
            $("#item-"+id_delete).hide();
          }
          alert(json.resposta);
      });
    }
    return false;
  }); 

});     
</script>
