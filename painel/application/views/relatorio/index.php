<div class="card">
	<div class="card-block">
    	<div class="col-md-12" >
        <form  action="<?php echo site_url('relatorio/empresas')?>" method="POST">
            <h4>Empresas Cadastradas</h4>
            <div class="form-row">
                <div class="form-group col-md-4">
                	<label for="data_inicio" class="col-form-label">Data Início</label>
                	<div class="input-group" >
                    <input type="text" class="form-control date" id="data_inicio" value="" name="data_inicio" placeholder="dd/mm/aaaa" >
                    <label class="input-group-addon btn" for="testdate">
               			<span class="fa fa-calendar"></span>
            		</label>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="data_inicio" class="col-form-label">Data Final</label>
                    <div class="input-group" >
                    <input type="text" class="form-control date" id="data_final" value="" name="data_final" placeholder="dd/mm/aaaa" >
                    <label class="input-group-addon btn" for="testdate">
               			<span class="fa fa-calendar"></span>
            		</label>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-md btn-salvar" type="submit">Exportar </button>
        </form>
        </div>
	</div>
</div>

<script>
$(document).ready(function () {
	
	/* Datepicker para mostrar calendarário */
	$("input[name=data_inicio]").datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR",
		orientation: "botton left",
		allowInputToggle: true,
		autoclose: true,
	}).on('changeDate', function (selected) {
		var startDate = new Date(selected.date.valueOf());
		$('input[name=data_final').datepicker('setStartDate', startDate);
	}).on('clearDate', function (selected) {
		$('input[name=data_final').datepicker('setStartDate', null);
	});
	
	$("input[name=data_final").datepicker({
		format: "dd/mm/yyyy",
		language: "pt-BR",
		orientation: "botton left",
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