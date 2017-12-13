<?php foreach($propostas as $pr){?>
    <div class="card" style="margin-bottom:30px;">
        <div class="card-header">
            <i class="fa fa-chevron-right"></i>Proposta recebida em <?php echo date('d/m/Y H:i', strtotime(str_replace("/","-",$pr->cadastrada))); ?>
            
            <span style="float:right;">
            <?php if (($pr->aceita) == 'Sim') { ?>

                <button class="btn btn-sm btn-success disabled" rel="modal_add_edit" data-target="" data-toggle="tooltip" title="Aceitar a Proposta">
                Proposta Aceita
                </button>

            <?php } ?>
            
            </span>

        </div>
        
        <div class="card-block">

            <div class="col-md-12 ">
                <div class="alert alert-info">
                <div class="form-row">
                    <div class="form-group col-12" style="font-weight: bold;">
                        <?php echo "EMPRESA COLETORA: ".$pr->razao_social; ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-4" style="font-weight: bold;">
                        <?php echo "Telefone 1: ".$pr->telefone1; ?>
                    </div>
                    <div class="form-group col-4" style="font-weight: bold;">
                        <?php echo "Telefone 2: ".$pr->telefone2; ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-6" style="font-weight: bold;">
                        <?php echo "email: ".$pr->email; ?>
                    </div>
                    <div class="form-group col-6" style="font-weight: bold;">
                        <?php echo "Contato: ".$pr->nome_responsavel; ?>
                    </div>
                </div>    
                </div>
                <div class="form-row">
                    <div class="form-group col-3">
                        <label><i class="fa fa-money"></i> O Coletor Deseja</label>
                        <br><?php echo $pr->cobranca == 0 ? "Pagar pelo resíduo" : "Cobrar pela coleta"; ?>
                    </div>

                    <div class="form-group col-3">
                        <label><i class="fa fa-th"></i> Valor Unitário Resíduo</label>
                        <br><?php echo "R$ ".number_format($pr->valor, 2, ',', '.'); ?>
                    </div>

                    <div class="form-group col-3">
                        <label><i class="fa fa-truck"></i> Valor Frete</label>
                        <br><?php echo "R$ ".number_format(($pr->frete * $pr->qtde_viagens ), 2, ',', '.'); ?>
                    </div>

                    <div class="form-group col-3">
                        <label><i class="fa fa-usd"></i> Total Aproximado</label>
                        <br><?php echo "R$ ".number_format($pr->total, 2, ',', '.'); ?>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-4">
                        <label><i class="fa fa-credit-card"></i> Forma de Pagamento</label>
                        <br><?php echo $pr->condicoes_pagamento; ?>
                    </div>
                    <div class="form-group col-4">
                        <label><i class="fa fa-calendar"></i> Prazo para Coleta</label>
                        <br><?php echo $pr->prazo_coleta." dias úteis"; ?>
                    </div>
                    <div class="form-group col-4" 
                    <?php echo strtotime($pr->validade_proposta) < strtotime($hoje) ? "style='color:#FF0000;'" : "" ; ?>>
                        <label><i class="fa fa-table"></i> Validade da Proposta</label>
                        <br><?php echo date('d/m/Y', strtotime(str_replace("/","-",$pr->validade_proposta))); ?>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-12">
                        <label><i class="fa fa-asterisk"></i> Observações</label>
                        <br><?php echo $pr->observacoes; ?>
                    </div>
                </div>
                
                <?php if (!empty($pr->removido)) { ?>
                <div class="form-row">
                    <div class="form-group col-12 alert alert-danger" style="font-weight: bold;">
                         Proposta removida em <?php echo date('d/m/Y', strtotime(str_replace("/","-",$pr->removido))); ?>. Motivo: <?php echo $pr->motivo_remocao; ?>
                    </div>
                </div>
                <?php } ?>
                
            </div>

        </div>
    </div>
<?php } ?>