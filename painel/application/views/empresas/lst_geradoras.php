<div class="row">
  <div class="table-responsive grid-list" >
    <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
      <thead>
        <tr>
          <th>Documento</th>
          <th>Empresa</th>
          <th>Responsável</th>
          <th>Contatos</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>Documento</th>
          <th>Empresa</th>
          <th>Responsável</th>
          <th>Contatos</th>
        </tr>
      </tfoot>
      <tbody>

        <?php foreach($result as $row){?>
        <tr>
          <td><?php echo $row->cnpj; ?><?php echo $row->cpf; ?></td>
          <td><?php echo $row->razao_social; ?><br/><?php echo $row->nome_fantasia; ?></td>
          <td><?php echo $row->nome_responsavel; ?></td>
          <td><?php echo $row->telefone1; ?><br/><?php echo $row->telefone2; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

  </div>
</div>
