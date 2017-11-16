    <div role="tabpanel" class="tab-pane" id="propostas">
    	<div id="list_propostas" >
        <?php foreach($propostas as $pr){?>
            <?php echo $pr->id; ?><br>
            <?php echo $pr->id_empresa_coletora; ?><br>
            <?php echo $pr->id_demanda; ?><br>
            <?php echo $pr->cobranca; ?><br>
            <?php echo $pr->valor; ?><br>
            <?php echo $pr->frete; ?><br>
            <?php echo $pr->total; ?><br>
            <?php echo $pr->condicoes_pagamento; ?><br>
            <?php echo $pr->prazo_coleta; ?><br>
            <?php echo $pr->validade_proposta; ?><br><br><hr>
        <?php } ?>
        </div>
    </div>
    
    
</div><!-- NÃO APAGAR ESTE FECHAMENTO DE DIV. ELA FECHA A DIV DE DEMANDA -->