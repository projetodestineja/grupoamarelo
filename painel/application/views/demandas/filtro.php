<form action="demandas" method="get">
    <!--h3><i class="fa fa-map-marker" aria-hidden="true"></i> Região</h3-->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="estado" class="col-form-label">Estado</label>
            <select class="form-control" id="estado" name="estado">
                <option value="">Todos</option>
                <?php foreach ($estados as $n) { ?>
                    <option value="<?php echo $n->uf; ?>"><?php echo $n->nome_estado; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="cidade" class="col-form-label">Cidade</label>
            <select class="form-control" id="cidade" name="cidade">
                <option value="">Todas</option>
                <?php foreach ($cidades as $n) {?>
                    <option value="<?php echo $n->id; ?>"><?php echo $n->nome_cidade;?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!--h3><i class="fa fa-cubes" aria-hidden="true"></i> Tipo de Resíduo</h3-->
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="categoria" class="col-form-label">Tipo de Resíduo</label>
            <select class="form-control" id="categoria" name="categoria">
                <option value="">Todos</option>
                <?php foreach ($categorias_residuos as $cr) {?>
                    <option value="<?php echo $cr->id; ?>"><?php echo $cr->categoria;?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!--h3><i class="fa fa-tags" aria-hidden="true"></i> Status</h3-->
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="status" class="col-form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="">Todos</option>
                <?php foreach ($demandas_status as $ds) {?>
                    <option value="<?php echo $ds->id; ?>"><?php echo $ds->descricao;?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <button class="btn btn-success btn-md" type="submit" ><i class="fa fa-filter" aria-hidden="true"></i> Buscar</button>
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
    $(option).append('Todas');
    $("select[name='" + el + "']").append(option);
}

$('#categoria option').each(function () {
    var minhaString = $(this).text();
    if (minhaString.length > 85) {
        $(this).text(minhaString.substring(0, 85) + '...');
    }
});
</script>