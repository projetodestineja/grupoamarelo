<div role="tabpanel" class="tab-pane" id="propostas">

    <div class="card">
    <h5 class="card-header"><i class="fa fa-list" ></i> Cadastro de Proposta</h5>
    <div class="card-block">
        <div style="padding:15px;">
        <form id="form_proposta" name="form_proposta" action="" method="POST">
            <div>
                <div class="form-check form-check-inline col-md-4">    
                    <input checked class="form-check-input" type="radio" name="cobranca" id="cobrancasim" name="cobrancasim" value="1"  onchange="atualiza_total();"><b> Cobrar para coletar o resíduo</b></input>
                    <br>
                    <input class="form-check-input" type="radio" name="cobranca" id="cobrancanao" name="cobrancanao" value="0"  onchange="atualiza_total();"><b> Pagar para coletar o Resíduo</b></input>
                </div>  
            </div>  
            <br>
            <div class="row">
                <div class="form-group col-md-3 required" id="col_coleta">
                    <label for="valor_coleta" class="col-form-label">Valor para Coleta (R$)</label>
                    <input required type="text"  class="form-control money" id="valor_coleta" name="valor_coleta" placeholder="00,00" onblur="atualiza_total();">
                </div>
                <div class="form-group col-md-3 required" id="col_frete">
                    <label for="valor_frete" class="col-form-label">Valor Frete (R$)</label>
                    <input required type="text" class="form-control money" id="valor_frete" name="valor_frete" placeholder="00,00" onblur="atualiza_total();">
                </div>
                <div class="form-group col-md-3" id="col_total">
                    <label for="valor_total" class="col-form-label">Total (R$)</label>
                    <input type="text" class="form-control money" id="valor_total" name="valor_total" placeholder="00,00" readonly >
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 required" id="col_condicoes">
                    <label for="condicoes" class="col-form-label">Condições de Pagamento</label>
                    <input required type="text" class="form-control" id="condicoes" name="condicoes"  >
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3 required" id="col_prazo">
                    <label for="prazo" class="col-form-label">Prazo para Coleta (dias)</label>
                    <input required type="number" class="form-control" id="condicoes" name="condicoes"  min="0" max="180"  >
                </div>
                <div class="form-group col-md-4 required" id="col_validade">
                    <label for="validade" class="col-form-label">Validade da Proposta (dias)</label>
                    <input required type="number" class="form-control" id="validade" name="validade" min="0" max="180" >
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12 " id="col_condicoes">
                    <label for="obs" class="col-form-label">Observações</label>
                    <input required type="text" class="form-control" id="obs" name="obs"  >
                </div>
            </div>
            
            <div >
                <button class="btn btn-success" type="submit">Salvar</button> 
                <button class="btn btn-danger" type="button">Cancelar</button>
            </div>
            
        </form>
    </div>
    </div>
</div>


</div><!-- NÃO APAGAR ESTE FECHAMENTO DE DIV. ELA FECHA A DIV DE DEMANDA -->
<script src="<?php echo site_url('painel/assets/pluguins/jquery.mask.js') ?>"></script>
<script>
    
    
    
    function atualiza_total(){
        
        var valor_coleta = 0;
        var valor_frete = 0;
        var total = 0;
        
        if (parseFloat(document.getElementById("valor_coleta").value.replace(",","."))>0){
            valor_coleta = parseFloat(document.getElementById("valor_coleta").value.replace(",","."));
            document.getElementById("valor_coleta").value = valor_coleta.toFixed(2).replace('.',',');
        }
        if (parseFloat(document.getElementById("valor_frete").value.replace(",","."))>0){
            valor_frete = parseFloat(document.getElementById("valor_frete").value.replace(",","."));
            document.getElementById("valor_frete").value = valor_frete.toFixed(2).replace('.',',');
        } 

        if (document.getElementById("cobrancasim").checked){
            total = parseFloat(valor_coleta) + parseFloat(valor_frete);
        }
        if (document.getElementById("cobrancanao").checked){
           total = parseFloat(valor_coleta) - parseFloat(valor_frete);
        }
        document.getElementById("valor_total").value = parseFloat(total).toFixed(2).replace('.',',');
    }
    
    
    

      
    
</script>    