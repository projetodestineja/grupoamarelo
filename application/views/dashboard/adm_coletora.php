<style>
    .titulo{
        background-color: #d7d7d7;
    }
    .destaque{
        color:red;
        font-weight: bold;
    }
</style>
<br>

<?php if ($ativo==1) { ?>
<div class="alert alert-info"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Seu cadastro está liberado para realizar propostas.</div>
<?php } ?>
<div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">
                   <?php echo $demandas_meu_estado; ?> Demandas cadastradas no seu Estado
                </div>
              </div>
              <a href="<?php echo site_url('demanda'); ?>" class="card-footer text-white clearfix small z-1">
                <span class="float-left">Ver demandas</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100" style="background-color: orange;">
              <div class="card-body" style="background-color: orange;">
                <div class="card-body-icon" style="background-color: orange;">
                  <i class="fa fa-fw fa-list"></i>
                </div>
                <div class="mr-5" style="background-color: orange;">
                  <?php echo $propostas_realizadas; ?> Proposta(s) realizada(s) 
                </div>
              </div>
              <a href="<?php echo site_url('demanda?propostas=1'); ?>" class="card-footer text-white clearfix small z-1" style="background-color: orange;">
                <span class="float-left">Ver Propostas</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5">
                  <?php echo $propostas_aceitas; ?> Negócios Fechados
                </div>
              </div>
              <a href="<?php echo site_url('demanda?propostas_aceitas=1'); ?>" class="card-footer text-white clearfix small z-1">
                <span class="float-left">Ver relatórios de coleta</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fa fa-fw fa-support"></i>
                </div>
                <div class="mr-5">
                  <?php echo $certificados_ativos; ?> Certificado(s) ativo(s)
                </div>
              </div>
              <a href="<?php echo site_url('cadastro'); ?>" class="card-footer text-white clearfix small z-1">
                <span class="float-left">Ver detalhes</span>
                <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>
<br>


<div class="card mb-3">
          <div class="card-header titulo">
            <i class="fa fa-list-ol "></i>
            <b> Controle de Licenças Ativas</b>
          </div>
<table class="table table-bordered">
<?php if ($certificados_ativos==0){ ?>
    <div class="alert">Não existem licenças cadastradas.</div>  
<?php } else { ?>    
  <thead>
    <tr class="titulo">
      <th><center> #</center></th>
      <th><center>Licença</center></th>
      <th><center>Data Cadastro</center></th>
      <th><center>Data Validade</center></th>
      <th><center>Status</center></th>
    </tr>
  </thead>
  <tbody>
   <?php  foreach ($licencas as $key) {   ?>
    <tr  >
      <th scope="row"><center><?php echo $key->id;?></center></th>
      <td><?php echo $key->titulo;?></td>
      <td><center><?php echo date('d/m/Y',strtotime($key->cadastrado)); ?></center></td>
      <td class="<?php if ($key->dias_faltando<=30) echo "destaque" ?>" ><center><?php echo date('d/m/Y',strtotime($key->validade)); ?></center></td>
      <td><center><?php echo $key->status;?></center></td>
    </tr>
   <?php  }  ?>
  </tbody>
<?php }  ?>    
</table>
</div>
    <br>