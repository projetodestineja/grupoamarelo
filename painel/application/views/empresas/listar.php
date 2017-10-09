<div class="row">
<div class="table-responsive" style="width:100%;">
    <table class="display table select table-striped table-bordered" width="100%" id="dataTable" cellspacing="0">
      <thead>
        <tr>
         
          <th>CNPJ / CPF</th>
          <th>Razão Social / Nome Fantasia / Responsável</th>
          <th>Contatos</th>
           <th>..</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
         
          <th>CNPJ / CPF</th>
          <th>Razão Social / Nome Fantasia / Responsável</th>
          <th>Contatos</th>
           <th>..</th>
        </tr>
      </tfoot>
      <tbody>

        <?php foreach($result as $row){?>
        <tr>
         
          <td>
            <?php echo $row->cnpj; ?><?php echo $row->cpf; ?>
          </td>
          <td>
		  <?php echo (!empty($row->razao_social)?$row->razao_social.'<br>':''); ?>
          <?php echo (!empty($row->nome_fantasia)?$row->nome_fantasia.'<br>':''); ?>
          <?php echo (!empty($row->nome_responsavel)?$row->nome_responsavel.'<br>':''); ?>
          </td>
          <td><?php echo $row->telefone1; ?><br/><?php echo $row->telefone2; ?></td>
           <td>
            <a class="btn btn-warning btn-sm" href="<?php echo site_url('empresa/edit/'.$row->id);?>">
              <i class="fa fa-pencil" data-toggle="tooltip" title="Clique aqui para editar o cadastro"></i>
            </a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    </div>
</div>