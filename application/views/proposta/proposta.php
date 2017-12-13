<div role="tabpanel" class="tab-pane <?php if ($tab_ativa=='proposta') echo "active"; ?>" id="propostas" name="propostas">
<?php if ($this->session->userdata['empresa']['ativo']==1) {?>    
    <div class="card">
    <h5 class="card-header"><i class="fa fa-list" ></i> Cadastro de Proposta <?php if (isset($id)) echo "#".$id; ?></h5>
    <div class="card-block">
        <div style="padding:15px;">
        
        <form id="form_proposta" name="form_proposta" method="POST" action="">
            <input type="text" id="id_proposta" name="id_proposta" value="<?php if (isset($id)) echo $id; ?>" hidden>   
            <div>
                <div class="form-check form-check-inline col-md-4">    
                    <div <?php if ((isset($cobranca)) && $cobranca == 0 )echo "hidden"; ?> >    <input required class="form-check-input" type="radio" name="cobranca" id="cobrancasim"  value="1"  onchange="atualiza_total();" <?php if ((isset($cobranca)) && $cobranca == 1 )echo "checked"; ?>><b> Cobrar para coletar o resíduo</b></input></div>
                    <div <?php if ((isset($cobranca)) && $cobranca == 1 )echo "hidden"; ?>><input required class="form-check-input" type="radio" name="cobranca" id="cobrancanao"  value="0"  onchange="atualiza_total();" <?php if (isset($cobranca) && $cobranca == 0) echo "checked"; ?>><b> Pagar para coletar o resíduo</b></input></div>
                </div>  
            </div>  
            <br>
            <div class="row">
                <div class="form-group col-md-6 required" id="col_coleta">
                    <label for="valor_coleta" class="col-form-label">Valor por unidade de medida <?php if (isset($uni_medida)) echo "(R$ / $uni_medida)";?></label>
                    <input required type="text"  class="form-control money" id="valor_coleta" name="valor_coleta" placeholder="00,00" onblur="atualiza_total();" value="<?php if (isset($valor)) echo number_format($valor, 2, ',', '.');?>" <?php if (isset($validade_proposta)) echo "readonly";?>>
                </div>
                <div class="form-group col-md-3 " id="col_qtde" >
                    <label for="qtde_demanda" class="col-form-label">Quantidade informada</label>
                    <input required type="number"  class="form-control " id="qtde_demanda" name="qtde_demanda" readonly onblur="atualiza_total();" value="<?php if (isset($qtd)) echo $qtd;?>" >
                </div>
            </div>    
            <div class="row">    
                <div class="form-group col-md-4 required" id="col_frete">
                    <label for="valor_frete" class="col-form-label">Valor por Viagem de Frete (R$)</label>
                    <input required type="text" class="form-control money" id="valor_frete" name="valor_frete" placeholder="00,00" onblur="atualiza_total();" value="<?php if (isset($frete)) echo number_format($frete, 2, ',', '.'); ?>" <?php if (isset($validade_proposta)) echo "readonly";?>>
                </div>
                 <div class="form-group col-md-3 required" id="col_frete2">
                    <label for="qtde_viagens" class="col-form-label">Quantidade de Viagens</label>
                    <input required type="number" class="form-control " id="qtde_viagens" name="qtde_viagens" onblur="atualiza_total();" value="<?php if (isset($qtd_viagens)) echo $qtd_viagens; else echo "1"; ?>" <?php if (isset($validade_proposta)) echo "readonly";?>>
                </div>

            </div>   
            <div class="row">
                <div class="form-group col-md-3" id="col_total">
                    <label for="valor_total" class="col-form-label">Total Aproximado (R$)</label>
                    <input type="text" class="form-control money" id="valor_total" name="valor_total" placeholder="00,00" readonly value="<?php if (isset($total)) echo number_format($total, 2, ',', '.');?>">
                </div>
                <div class="form-group col-md-12" style="font-weight: bold;font-size: 14px;color:#0080FF;text-align: justify;">
                * O total aproximado é o valor por unidade de medida multiplicado pela quantidade informada na demanda somada com o valor do frete.
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 required" id="col_condicoes">
                    <label for="condicoes" class="col-form-label">Condições de Pagamento</label>
                    <input required type="text" class="form-control" id="condicoes" name="condicoes"  value="<?php if (isset($condicoes_pagamento)) echo $condicoes_pagamento;?>" <?php if (isset($validade_proposta)) echo "readonly";?>>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3 required" id="col_prazo">
                    <label for="prazo" class="col-form-label">Prazo para Coleta (dias)</label>
                    <input required type="number" class="form-control" id="prazo" name="prazo"  min="0" max="180"  value="<?php if (isset($prazo_coleta)) echo $prazo_coleta;?>" <?php if (isset($validade_proposta)) echo "readonly";?>>
                </div>  
                <div class="form-group col-md-4 required" id="col_validade">
                    <label for="validade" class="col-form-label">Validade da Proposta </label>
                    <input required type="text" class="form-control date" id="validade" name="validade" value="<?php if (isset($validade_proposta)) echo date('d/m/Y', strtotime($validade_proposta));?>" <?php if (isset($validade_proposta)) echo "readonly";?>>
                </div>
            </div>
            <div class="form-group col-md-12" style="font-weight: bold;font-size: 14px;color:#0080FF;text-align: justify;">
                * O prazo para coleta começa a contar a partir do momento que a proposta for aceita pelo cliente.<br>
            </div>  
            <div class="row">
                <div class="form-group col-md-12 " id="col_condicoes">
                    <label for="obs" class="col-form-label">Observações</label>
                    <input type="text" class="form-control" id="obs" name="obs" value="<?php if (isset($observacoes)) echo $observacoes;?>" <?php if (isset($validade_proposta)) echo "readonly";?>>
                </div>
            </div>
            <div class="row ">
            <div class="form-group col-md-3">
                <button class="btn btn-success" <?php if (isset($validade_proposta)) echo "disabled"; ?> type="submit">Salvar</button> 
                <button class="btn btn-danger" <?php if ((isset($aceita) && ($aceita=='Sim')) || (!isset($validade_proposta)) ) echo "disabled"; ?> type="button"  id="btmostramotivo" name="btmostramotivo" onclick="mostra_motivo();">Cancelar Proposta</button>
            </div>
            </div>
            <div class="row ">    
            <div class="form-group col-md-3 " id="div1motivo" name="div1motivo" style="color:red;" >
               <label for="motivo_cancelamento" class="col-form-label">Motivo do cancelamento:</label>
            </div>
            <div class="form-group col-md-7  " id="div2motivo" >
                <input type="text" class="form-control" id="motivo_cancelamento" name="motivo_cancelamento" maxlength="250" >
            </div>
            <div class="form-group col-md-2" id="div3motivo" >
                <button class="btn btn-danger" <?php if ((isset($aceita) && ($aceita=='Sim')) || (!isset($validade_proposta)) ) echo "disabled"; ?> type="submit" value="cancelar_proposta" id="btcancelar" name="btcancelar">Confirmar</button>
            </div>
            </div>
        </form>
    </div>
    </div>
</div>
<?php } else { ?>  
    <div class="alert alert-danger"> Seu cadastro ainda não está desbloqueado para realizar propostas. Entre em contato com a Destine Já.</div>
<?php } ?>  

</div>




<script src="<?php echo site_url('painel/assets/pluguins/jquery.mask.js') ?>"></script>
<script>
    
    function atualiza_total(){
        
        var valor_coleta = 0;
        var qtde_unidade = parseInt(document.getElementById("qtde_demanda").value);
        var valor_frete = 0;
        var qtde_viagens = parseInt(document.getElementById("qtde_viagens").value);
        var total = 0;
        
        
        if (parseFloat(document.getElementById("valor_coleta").value.replace(",","."))>0){
            valor_coleta = parseFloat(document.getElementById("valor_coleta").value.replace(".","").replace(",","."));
            if (document.getElementById("valor_coleta").value.length<3)
                document.getElementById("valor_coleta").value = valor_coleta.toFixed(2).replace('.',',');
        }
        
        if (parseFloat(document.getElementById("valor_frete").value.replace(",","."))>0){
            valor_frete = parseFloat(document.getElementById("valor_frete").value.replace(".","").replace(",","."));
            if (document.getElementById("valor_frete").value.length<3)
                document.getElementById("valor_frete").value = valor_frete.toFixed(2).replace('.',',');
        } 

        if (document.getElementById("cobrancasim").checked){
            total = (parseFloat(valor_coleta) * qtde_unidade) + (parseFloat(valor_frete) * qtde_viagens );
        }
        if (document.getElementById("cobrancanao").checked){
           total =(parseFloat(valor_coleta) * qtde_unidade) - (parseFloat(valor_frete) * qtde_viagens );;
        }
        document.getElementById("valor_total").value = parseFloat(total).toFixed(2).replace('.',',');
    }
    
    function mostra_motivo(){
        $("#div1motivo").show();
        $("#div2motivo").show();
        $("#div3motivo").show();
    }

    $(document).ready(function () {
            $("#div1motivo").hide();
            $("#div2motivo").hide();
            $("#div3motivo").hide();
        
            $('.money').mask('000.000.000.000.000,00', {reverse: true});

            $(".fileinput").fileinput();

            $("input[name=validade").datepicker({
                    format: "dd/mm/yyyy",
                    language: "pt-BR",
                    orientation: "botton left",
                    startDate: new Date(),
                    allowInputToggle: true,
                    autoclose: true,
            }).on('changeDate', function (selected) {
                    var endDate = new Date(selected.date.valueOf());
                    $('input[name=data_inicio]').datepicker('setEndDate', endDate);
            }).on('clearDate', function (selected) {
                    $('input[name=data_inicio]').datepicker('setEndDate', null);
            });

    });
    

   
</script>    