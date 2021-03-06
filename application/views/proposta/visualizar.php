<div class="col-md-12">
    
    <div class="form-row">
        <div class="form-group col-3">
            <label><i class="fa fa-money"></i> O Coletor Deseja</label>
            <br><?php echo $proposta->cobranca == 0 ? "Pagar pelo resíduo" : "Cobrar pela coleta"; ?>
        </div>

        <div class="form-group col-3">
            <label><i class="fa fa-th"></i> Valor Resíduo</label>
            <br><?php echo "R$ ".number_format($proposta->valor, 2, ',', '.'); ?>
        </div>

        <div class="form-group col-3">
            <label><i class="fa fa-truck"></i> Valor Frete</label>
            <br><?php echo "R$ ".number_format(($proposta->frete * $proposta->qtde_viagens), 2, ',', '.'); ?>
        </div>

        <div class="form-group col-3">
            <label><i class="fa fa-usd"></i> Total Aproximado</label>
            <br><?php echo "R$ ".number_format($proposta->total, 2, ',', '.'); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-4">
            <label><i class="fa fa-credit-card"></i> Forma de Pagamento</label>
            <br><?php echo $proposta->condicoes_pagamento; ?>
        </div>
        <div class="form-group col-4">
            <label><i class="fa fa-calendar"></i> Prazo para Coleta</label>
            <br><?php echo $proposta->prazo_coleta." dias úteis"; ?>
        </div>
        <div class="form-group col-4">
            <label><i class="fa fa-table"></i> Validade da Proposta</label>
            <br><?php echo date('d/m/Y', strtotime(str_replace("/","-",$proposta->validade_proposta))); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-12">
            <label><i class="fa fa-asterisk"></i> Observações</label>
            <br><?php echo $proposta->observacoes; ?>
        </div>
    </div>

    <a class="btn btn-sm btn-success" href="<?php echo site_url('proposta/aceitar?id='.$proposta->id);?>">
        <i class="fa fa-thumbs-up" aria-hidden="true"></i> Aceitar
    </a>
    <a class="btn btn-sm btn-danger" data-dismiss="modal">
        <i class="fa fa-thumbs-down" aria-hidden="true"></i> Agora não
    </a>
    
</div>

<script>
    $(document).ready(function () {
        $('#modal_add_edit #title_modal').html('<?php echo $title; ?>');
    });
</script>