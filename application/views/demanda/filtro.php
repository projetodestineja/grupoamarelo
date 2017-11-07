<form action="demanda" method="get">
    <h3>Região</h3>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="estado" class="col-form-label">Estado</label>
            <select class="form-control" id="estado" name="estado">
                <option value="">Selecione o Estado</option>
                <?php foreach ($estados as $n) { ?>
                    <option value="<?php echo $n->uf; ?>" <?php echo ($n->uf==$col_uf_estado?'selected':''); ?> ><?php echo $n->nome_estado; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="cidade" class="col-form-label">Cidade</label>
            <select class="form-control" id="cidade" name="cidade">
                <option value="">Selecione a Cidade</option>
                <?php foreach ($cidades as $n) {?>
                    <option value="<?php echo $n->id; ?>" <?php echo ($n->id==$col_id_cidade?'selected':''); ?>  ><?php echo $n->nome_cidade;?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <h3>Tipo de Resíduo</h3>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="categoria" class="col-form-label">Selecione o Tipo de Resíduo</label>
            <select class="form-control" id="categoria" name="categoria">
                <option value="">Selecione o Tipo de Resíduo</option>
                <?php foreach ($categorias_residuos as $cr) {?>
                    <option value="<?php echo $cr->id; ?>"><?php echo $cr->categoria;?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <h3>Status</h3>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="status" class="col-form-label">Selecione um Status de Demanda</label>
            <select class="form-control" id="status" name="status">
                <option value="">Selecione um Status de Demanda</option>
                <?php foreach ($demandas_status as $ds) {?>
                    <option value="<?php echo $ds->id; ?>"><?php echo $ds->descricao;?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <button class="btn btn-success btn-md" type="submit" ><i class="fa fa-filter" aria-hidden="true"></i> Filtrar</button>
</form>

<script>
$(document).ready(function () {
    $('#modal_add_edit #title_modal').html('<?php echo $title; ?>');
});

$(function () {

    $("select[name=estado]").change(function () {

        var estado = $(this).val();

        resetaCombo('cidade');
        load_cidades(estado, null);

    });

});

function load_cidades(estado, cidade = NUll) {
    //alert(cidade);
    $.getJSON('<?php echo site_url(); ?>' + 'empresa/getcidades/' + estado + '?cidade=' + cidade, function (data) {

        var option = new Array();

        $.each(data, function (i, obj) {

            option[i] = document.createElement('option');
            $(option[i]).attr({value: obj.id});
            if (obj.selected != '') {
                $(option[i]).attr({selected: obj.selected});
            }
            $(option[i]).append(obj.nome_cidade);

            $("select[name='cidade']").append(option[i]);

        });

    });

}

function resetaCombo(el) {
    $("select[name='" + el + "']").empty();
    var option = document.createElement('option');
    $(option).attr({value: ''});
    $(option).append('Selecione a Cidade');
    $("select[name='" + el + "']").append(option);
}
                            
</script>