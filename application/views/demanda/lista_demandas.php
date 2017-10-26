<?php ?>

<table id="lista_demandas" name="lista_demandas" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <div class="row" style="margin:20px;">
        <thead>
            <tr>
                <th ><center>Demanda</center></th>
                <th ><center>Demanda</center></th>
                <th ><center>Demanda</center></th>
            </tr>
        </thead>
    </div>
    <tbody>
        
        <?php
        $i = 0;
        
        for ($i ; $i < count($demandas) ; $i++) {   
          
        if (isset($demandas[$i])) $key = $demandas[$i]; else $key = Null;    
    
        ?>
        
        <tr>
            <td>
                <?php if ($key){ ?>
                <div style="padding:5px;">
                    <div style="text-align: center">
                        <div>
                            <img src="<?php if (isset($key->img)) echo $key->img; else echo "http://www.premiermax.com.br/wp-content/uploads/2015/12/Sem-Imagem.jpg" ; ?>" class="img-rounded" height="100" width="100">
                        </div>
                        <div style="padding:10px;">
                            <?php echo "<b>".$key->residuo."</b>"; ?>
                            <?php echo "<br>".$key->nome_cidade.", ".$key->col_uf_estado."<br>"; ?>
                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="collapse" data-target="#descricao<?php echo $i;?>">Mais Informações</button>    
                        </div>
                    </div>    
                    <div id="descricao<?php echo $i;?>" class="collapse">
                        <?php echo "Quantidade: ".$key->qtd.$key->uni_medida; ?><br>
                        <div style="text-align: justify;">
                            <?php echo $key->obs; ?>
                        </div>
                        <?php echo  "Período: ".date('d/m/Y',strtotime($key->data_inicio)). " à ".date('d/m/Y',strtotime($key->data_validade)); ?>
                        <div style="color:<?php echo $key->cor; ?>;"> 
                            <?php echo "*".$key->descricao; ?>
                        </div>
                        <center><button class="btn btn-primary btn-block" value="Ver" > Ver</button></center>
                    </div>
                </div>
                <?php $i++; if (isset($demandas[$i])) $key = $demandas[$i]; else $key = Null;   }?>
            </td>
            <td>
                <?php if ($key){ ?>
                  <div style="padding:5px;">
                    <div style="text-align: center">
                        <div>
                            <img src="<?php if (isset($key->img)) echo $key->img; else echo "http://www.premiermax.com.br/wp-content/uploads/2015/12/Sem-Imagem.jpg" ; ?>" class="img-rounded" height="100" width="100">
                        </div>
                        <div style="padding:10px;">
                            <?php echo "<b>".$key->residuo."</b>"; ?>
                            <?php echo "<br>".$key->nome_cidade.", ".$key->col_uf_estado."<br>"; ?>
                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="collapse" data-target="#descricao<?php echo $i;?>">Mais Informações</button>    
                        </div>
                    </div>    
                    <div id="descricao<?php echo $i;?>" class="collapse">
                        <?php echo "Quantidade: ".$key->qtd.$key->uni_medida; ?><br>
                        <div style="text-align: justify;">
                            <?php echo $key->obs; ?>
                        </div>
                        <?php echo  "Período: ".date('d/m/Y',strtotime($key->data_inicio)). " à ".date('d/m/Y',strtotime($key->data_validade)); ?>
                        <div style="color:<?php echo $key->cor; ?>;"> 
                            <?php echo "*".$key->descricao; ?>
                        </div>
                   <center><button class="btn btn-primary btn-block " value="Ver" > Ver</button></center>
                    </div>
                </div>
                <?php $i++; if (isset($demandas[$i])) $key = $demandas[$i]; else $key = Null;  }?>
            </td>           
            <td>
                <?php if ($key){ ?>
                <div style="padding:5px;">
                    <div style="text-align: center">
                        <div style="text-align: center">
                            <img src="<?php if (isset($key->img)) echo $key->img; else echo "http://www.premiermax.com.br/wp-content/uploads/2015/12/Sem-Imagem.jpg" ; ?>" class="img-rounded" height="100" width="100">
                        </div>
                        <div style="padding:10px;">
                            <?php echo "<b>".$key->residuo."</b>"; ?>
                            <?php echo "<br>".$key->nome_cidade.", ".$key->col_uf_estado."<br>"; ?>
                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="collapse" data-target="#descricao<?php echo $i;?>">Mais Informações</button>    
                        </div>
                    </div>    
                    <div id="descricao<?php echo $i;?>" class="collapse">
                        <?php echo "Quantidade: ".$key->qtd.$key->uni_medida?><br>
                        <div style="text-align: justify;">
                            <?php echo $key->obs; ?>
                        </div>
                        <?php echo  "Período: ".date('d/m/Y',strtotime($key->data_inicio)). " à ".date('d/m/Y',strtotime($key->data_validade)); ?>
                        <div style="color:<?php echo $key->cor; ?>;"> 
                            <?php echo "*".$key->descricao; ?>
                        </div>
                   <center><button class="btn btn-primary btn-block" value="Ver" > Ver</button></center>
                    </div>
                </div>
                 <?php   }?>
            </td>
        </tr>
         <?php
        }
        ?>
    </tbody>
</table>



<script>
    $(document).ready(function () {
        $('#lista_demandas').DataTable({                              
        "oLanguage": {
           "sProcessing": "Aguarde enquanto os dados são carregados ...",
           "sLengthMenu": "Mostrar _MENU_ linhas de registros por pagina",
           "sZeroRecords": "Nenhum registro correspondente ao criterio encontrado",
           "sInfoEmtpy": "Exibindo 0 a 0 de 0 linhas de registros",
           "sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
           "sInfoFiltered": "",
           "sSearch": "Procurar",
           "oPaginate": {
              "sFirst":    "Primeiro",
              "sPrevious": "Anterior",
              "sNext":     "Próximo",
              "sLast":     "Último"
           }
        },  
         "scrollX": true,
         "lengthMenu": [[5,10, 25], [5,10, 25]]
       });
    });
    

    
</script>    
