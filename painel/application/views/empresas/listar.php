<div class="row">
  <div class="col-lg-3">
    <a href="<?php echo base_url('../');?>" target="_blank" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Clique aqui para realizar um novo cadastro"><i class="fa fa-plus-circle"></i> Novo Cadastro</a>
  </div><br><br>
  <div class="table-responsive grid-list" >
    <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
      <thead>
        <tr>
          <th>..</th>
          <th>Documento</th>
          <th>Empresa</th>
          <th>Responsável</th>
          <th>Contatos</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>..</th>
          <th>Documento</th>
          <th>Empresa</th>
          <th>Responsável</th>
          <th>Contatos</th>
        </tr>
      </tfoot>
      <tbody>

        <?php foreach($result as $row){?>
        <tr>
          <td>
            <a class="btn btn-warning btn-sm" href="<?php echo site_url('empresa/');?><?php echo $form_edicao.'/'.$row->id; ?>">
              <i class="fa fa-pencil" data-toggle="tooltip" title="Clique aqui para editar o cadastro"></i>
            </a>&nbsp;
          </td>
          <td>
            <?php echo $row->cnpj; ?><?php echo $row->cpf; ?>
          </td>
          <td><?php echo $row->razao_social; ?><br/><?php echo $row->nome_fantasia; ?></td>
          <td><?php echo $row->nome_responsavel; ?></td>
          <td><?php echo $row->telefone1; ?><br/><?php echo $row->telefone2; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

  </div>
</div>
