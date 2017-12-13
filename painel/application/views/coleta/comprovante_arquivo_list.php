<div class="table-responsive" >
    <table class="table table-striped table-bordered" width="100%"  cellspacing="0">
      <thead>
        <tr>
          <th width="30" >-</th>
          <th>Arquivo</th>
          <th width="145">Cadastrado</th>
        </tr>
      </thead>
      <tbody>
       <?php if($result){ ?>
       <?php foreach($result as $row){?>
        <tr>
          <td>
            <a class="btn btn-info btn-sm" target="_blank" href="<?php echo site_url('demandas/arquivo_download/'.$row->id); ?>">
              <i class="fa fa-download" data-toggle="tooltip" title="Visualizar arquivo" ></i>
            </a>
          </td>	
          <td><?php echo $row->titulo; ?></td>
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
