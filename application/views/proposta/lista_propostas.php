<div role="tabpanel" class="tab-pane" id="propostas">
    	<div id="list_propostas" >

        <?PHP if (!empty($propostas)) { ?>    
            
        <?php foreach($propostas as $pr){?>
        <div class="card" style="margin-bottom:30px;">
            <div class="card-header">
                <i class="fa fa-chevron-right"></i>Proposta recebida em <?php echo date('d/m/Y H:i', strtotime(str_replace("/","-",$pr->cadastrada))); ?>
                
                <span style="float:right;">
                <a class="btn btn-sm btn-success <?php echo strtotime($pr->validade_proposta) < strtotime($hoje) || $pr->aceita == 'Sim' ? 'disabled' : '' ; ?>" rel="modal_add_edit" data-target="" data-toggle="tooltip" title="Aceitar a Proposta" href="<?php echo site_url('proposta/visualizar?id='.$pr->id); ?>">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <?php echo $pr->aceita == 'Sim' ? 'Proposta Aceita' : 'Aceitar' ; ?>
                </a>
                <!--a class="btn btn-sm btn-danger" data-toggle="tooltip" title="Recusar a Proposta" href="#" >
                    <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                </a-->
                
                </span>

            </div>
            
            <div class="card-block">

                <div class="col-md-12">
                    
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label><i class="fa fa-money"></i> O Coletor Deseja</label>
                            <br><?php echo $pr->cobranca == 0 ? "pagar pelo resíduo" : "cobrar pelo resíduo"; ?>
                        </div>

                        <div class="form-group col-3">
                            <label><i class="fa fa-th"></i> Valor unitário resíduo</label>
                            <br><?php echo "R$ ".number_format($pr->valor, 2, ',', '.'); ?>
                        </div>

                        <div class="form-group col-3">
                            <label><i class="fa fa-truck"></i> Valor Frete</label>
                            <br><?php echo "R$ ".number_format($pr->frete * $pr->qtde_viagens, 2, ',', '.'); ?>
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
                            <br><?php echo $pr->prazo_coleta; ?> dias úteis 
                        </div>
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
                    
                </div>

            </div>
        </div>
        <?php } ?>
        <?PHP } else echo "Não existem propostas cadastradas pelos coletores de resíduos." ?>      
        </div>
        <?php if (isset($pr->id_demanda)) { ?>
            <a href="<?php  echo site_url('relatorio/lista_propostas/'.$pr->id_demanda); ?>" target="_blank" ><button class="btn btn-info"  type="button"  >Imprimir Propostas Recebidas</button></a>
        <?php } ?>
    </div>