    <div role="tabpanel" class="tab-pane" id="propostas">
    	<div id="list_propostas" >

        <?php foreach($propostas as $pr){?>
        <div class="card" style="margin-bottom:30px;">
            <h5 class="card-header"><i class="fa fa-chevron-right"></i>Proposta #<?php echo $pr->id; ?></h5>
            <div class="card-block">

                <div class="col-md-12">
                    
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label><i class="fa fa-credit-card"></i> Pagamento</label>
                            <br><?php echo $pr->cobranca; ?>
                        </div>

                        <div class="form-group col-3">
                            <label><i class="fa fa-th"></i> Valor Resíduo</label>
                            <br><?php echo $pr->valor; ?>
                        </div>

                        <div class="form-group col-3">
                            <label><i class="fa fa-truck"></i> Valor Frete</label>
                            <br><?php echo $pr->frete; ?>
                        </div>

                        <div class="form-group col-3">
                            <label><i class="fa fa-usd"></i> Total</label>
                            <br><?php echo $pr->total; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-4">
                            <label><i class="fa fa-credit-card"></i> Forma de Pagamento</label>
                            <br><?php echo $pr->condicoes_pagamento; ?>
                        </div>
                        <div class="form-group col-4">
                            <label><i class="fa fa-calendar"></i> Prazo para Coleta</label>
                            <br><?php echo $pr->prazo_coleta; ?>
                        </div>
                        <div class="form-group col-4">
                            <label><i class="fa fa-table"></i> Validade da Proposta</label>
                            <br><?php echo $pr->validade_proposta; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-10">
                            <label><i class="fa fa-comments-o"></i> Observações</label>
                            <br><?php echo $pr->observacoes; ?>
                        </div>
                        <div class="form-group col-2">
                            <a class="btn btn-lg btn-success" data-toggle="tooltip" title="Aceitar a Proposta" href="#" >
                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-lg btn-danger" data-toggle="tooltip" title="Recusar a Proposta" href="#" >
                                <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
        <?php } ?>
        </div>
    </div>
    
    
</div><!-- NÃO APAGAR ESTE FECHAMENTO DE DIV. ELA FECHA A DIV DE DEMANDA -->