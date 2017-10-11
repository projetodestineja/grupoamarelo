<div class="table-responsive" >
    <table class="table table-striped table-bordered" width="100%"  cellspacing="0">
      <thead>
        <tr>
          <th width="30" >-</th>
          <th width="120" >Status</th>
          <th width="100" >Validade</th>
          <th>Titulo</th>
          <th width="145">Cadastrado</th>
        </tr>
      </thead>
      <tbody>
       <?php if($result){ ?>
       <?php foreach($result as $row){?>
        <tr>
          <td>
            <a class="btn btn-info btn-sm" target="_blank" href="<?php echo site_url('cadastro/licenca_download/'.$row->id); ?>">
              <i class="fa fa-download" data-toggle="tooltip" title="Visualizar arquivo" ></i>
            </a>
          </td>	
          <td><?php echo $row->status; ?></td>
          <td><?php echo date('d/m/y', strtotime($row->validade)); ?></td>
          <td><a href="<?php echo site_url('cadastro/licenca_form/'.$row->id); ?>" rel="modal_add_edit" ><?php echo $row->titulo; ?></a></td>
          <td><?php echo date('d/m/y H:i', strtotime($row->cadastrado)); ?>h</td>
        </tr>
        <?php } ?>
         <?php }else{ ?>
         <tr>
          <td colspan="5">Nenhum registro encontrado.</td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>

<script type="text/javascript">
  $(document).ready(function(){
	 $('[data-toggle="tooltip"]').tooltip(); 
     $('a[rel=modal_add_edit]').on('click', function(evt) {
        evt.preventDefault();
         var modal = $('#modal_add_edit').modal();
         modal
         .find('.modal-body')
         .load($(this).attr('href'), function (responseText, textStatus) {
            if ( textStatus === 'success' || textStatus === 'notmodified') {
              modal.show();
          }
       });
    });
 });
</script>