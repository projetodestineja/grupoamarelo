<h2>Região</h2>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="estado" class="col-form-label">Estado</label>
        <select class="form-control novo_endereco" id="estado" name="col_uf_estado">
            <option value="">Selecione o Estado</option>
            <?php foreach ($estados as $n) { ?>
                <option value="<?php echo $n->uf; ?>" <?php echo ($n->uf==$col_uf_estado?'selected':''); ?> ><?php echo $n->nome_estado; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-6">
        <label for="cidade" class="col-form-label">Cidade</label>
        <select class="form-control novo_endereco" id="cidade" name="col_id_cidade">
                <option value="">Selecione a Cidade</option>
                <?php foreach ($cidades as $n) {?>
                    <option value="<?php echo $n->id; ?>" <?php echo ($n->id==$col_id_cidade?'selected':''); ?>  ><?php echo $n->nome_cidade;?></option>
                <?php } ?>
        </select>
    </div>
</div>

<h2>Tipo de Resíduo</h2>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="cidade" class="col-form-label">Selecione o Tipo de Resíduo</label>
        <select class="form-control novo_endereco" id="cidade" name="col_id_cidade">
                <option value="">Selecione o Tipo de Resíduo</option>
        </select>
    </div>
</div>

<h2>Status</h2>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="cidade" class="col-form-label">Selecione um Status de Demanda</label>
        <select class="form-control novo_endereco" id="cidade" name="col_id_cidade">
                <option value="">Selecione um Status de Demanda</option>
        </select>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#modal_add_edit #title_modal').html('<?php echo $title; ?>');
});	
</script>