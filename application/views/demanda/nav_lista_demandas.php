<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
?>


<form action="" method="POST">
    <div class="row">
        <div class="col-md-8">
            <h1><?php echo "Demandas de ".$local; ?></h1>
        </div>    
        <div class="col-md-4" style="text-align: right;">
            <button type="submit" class="btn btn-info" value="cidade" id="btbusca" name="btcidade">da minha Cidade</button>
            <button type="submit" class="btn btn-info" value="estado" id="btbusca" name="btestado">do meu Estado</button>
        </div>
    </div>
</form>
