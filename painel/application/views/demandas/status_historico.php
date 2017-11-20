<div class="table-responsive">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped" >
  <tr>
    <th><span class="fa fa-list"></span> Status</th>
    <th><span class="fa fa-calendar"></span> Data/Hora</th>
  </tr>
  <?php if($result){ ?>
  <?php foreach($result as $n){?>
  <tr>
    <td><?php echo $n->descricao; ?></td>
    <td><?php echo date('d/m/y H:i',strtotime($n->datahora)); ?>h</td>
  </tr>
  <?php } 
  }else{
  ?>
  <tr>
    <td colspan="2">Nenhum registro encontrado</td>
  </tr>
  <?php } ?>
</table>
</div>
