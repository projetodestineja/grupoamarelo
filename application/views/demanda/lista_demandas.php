<?php ?>

<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <div class="row" style="margin:20px;">
        <thead>
            <tr>
                <th width="110"><center>Imagem</center></th>
                <th><center>Descrição</center></th>
                <th><center>Período</center></th>
                <th width="70"><center>Status</center></th>
            </tr>
        </thead>
    </div>
    <tbody>
        
        <?php
        foreach ($demandas as $key){
        ?>
        <tr>
            <td>
                <div style="padding:5px;">
                    <img src="<?php echo $key->img; ?>" class="img-rounded" height="100" width="100">
                </div>
            </td>
            <td>
                <div>
                    <b><?php echo $key->residuo; ?></b>
                </div>
                <div>
                    <?php echo "Quantidade: ".$key->qtd.$key->uni_medida."<br>".$key->obs; ?><br>
                    <?php echo $key->nome_cidade.", ".$key->col_uf_estado; ?>
                </div>
            </td>
            <td>
                <center><?php echo  date('d/m/Y',strtotime($key->data_inicio)). " à <br>".date('d/m/Y',strtotime($key->data_validade)); ?></center>
            </td>
            <td>
                <div style="text-align: center;color:<?php echo $key->cor; ?>;"> <?php echo $key->descricao; ?></div><br>
            <center><button class="btn btn-info" value="Ver" > Ver</button></center>
            </td>
        </tr>
         <?php
        }
        ?>
    </tbody>
</table>



<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>    
