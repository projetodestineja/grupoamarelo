<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<form id="form_cad_demanda" action="" method="POST" enctype="multipart/form-data">

		<div class="form-row">
			<div class="form-group col-md-3 required">
				<label for="data_inicio" class="col-form-label">Data Início</label>
				<input name="data_inicio" class="form-control date" value="<?php echo $data_inicio;?>" id="data_inicio" style="position:relative" >
			</div>
      <div class="form-group col-md-3 required">
				<label for="data_validade" class="col-form-label">Data de Expiração</label>
				<input name="data_validade" class="form-control date" value="<?php echo $data_validade;?>" id="data_validade" style="position:relative" >
			</div>
		</div>
    
		<div class="form-row">
      <div class="form-group col-md-6 required">
        <label for="residuo" class="col-form-label">Especifique o resíduo:</label>
				<input type="text" class="form-control" id="residuo" value="<?php echo $residuo; ?>" name="residuo" placeholder="Ex.: Oléo de cozinha usado">
      </div>
			<div class="form-group col-md-6 required">
        <label for="condicionado" class="col-form-label">Como o resíduo está acondicionado?</label>
				<input type="text" class="form-control" id="condicionado" value="<?php echo $condicionado; ?>" name="condicionado" placeholder="Ex.: Garrafas pet 2 litros">
      </div>
    </div>

		<div class="form-row">
      <div class="form-group col-md-3 required">
        <label for="qtd" class="col-form-label">Quantidade:</label>
				<input type="number" class="form-control" id="qtd" value="<?php echo $qtd; ?>" name="qtd" placeholder="Ex.: 11,5">
      </div>
			<div class="form-group col-md-3 required">
        <label for="uni_medida" class="col-form-label">Unidade de Medida:</label>
				<input type="text" class="form-control" id="uni_medida" value="<?php echo $uni_medida; ?>" name="uni_medida" placeholder="Ex.: Garrafas pet 2 litros">
      </div>
    </div>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="img1" class="col-form-label">Imagem 1 - Tamanho Máx.: 5MB</label>
				<input type="file" class="form-control" id="img1" name="img1">
			</div>
		</div>

		<div class="form-row">
      <div class="form-group col-md-12 required">
        <label for="obs" class="col-form-label">Observações:</label>
				<textarea class="form-control" id="obs" value="<?php echo $obs; ?>" name="obs" rows="5" placeholder="Utilize este campo para observações tais como: dificuldade para entrada de veículos grandes, disponibilidade de horário, etc."></textarea>
      </div>
    </div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<input name="outro_endereco" id="outro_endereco" type="checkbox" value="1" <?php /*echo (($outro_endereco==1)?'checked':'');*/ ?> >
				<label for="outro_endereco" class="col-form-label">A coleta será em outro endereço?</label>
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-2">
					<label for="cep" class="col-form-label">CEP</label>
					<input type="text" class="form-control cep" id="cep" name="cep" placeholder="000000-000" maxlength="8" onblur="pesquisacep(this.value);">
			</div>
			<div class="form-group col-md-5">
					<label for="Rua" class="col-form-label">Rua</label>
					<input required type="text" class="form-control" id="rua" name="rua" placeholder="Ex.: Av. José Silva, Rua São Cosme...">
			</div>
			<div class="form-group col-md-2">
					<label for="numero" class="col-form-label">Número</label>
					<input  type="number" class="form-control" id="numero" name="numero" placeholder="00">
			</div>
			<div class="form-group col-md-3">
					<label for="complemento" class="col-form-label">Complemento</label>
					<input type="text" class="form-control" id="complemento" name="complemento" placeholder="Ex.: Casa, Apartamento...">
			</div>
		</div>
		<div class="form-row">
				<div class="form-group col-md-4">
						<label for="bairro" class="col-form-label">Bairro</label>
						<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Ex.: São Gonçalo, Manguinhos...">
				</div>
				<div class="form-group col-md-4">
						<label for="estado" class="col-form-label">Estado</label>
						<select required class="form-control" id="estado" name="estado">
								<option value="">Selecione o Estado</option>
								<?php foreach ($estados as $n) { ?>
										<option value="<?php echo $n->uf; ?>"  ><?php echo $n->nome_estado; ?></option>
								<?php } ?>
						</select>
				</div>

			<div class="form-group col-md-4">
					<label for="cidade" class="col-form-label">Cidade</label>
					<select required class="form-control" id="cidade" name="cidade">
							<option value="">Selecione a Cidade</option>
					</select>
			</div>
	</div>

		<button class="btn btn-success btn-md btn-salvar" type="submit"> <?php echo (!isset($id)?'Cadastrar':'Atualizar'); ?> </button>
</form>

<script>
$(document).ready(function () {
		$('input[name=data_inicio]').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			startView: 2,
			maxViewMode: 2,
			language: "pt-BR",
			orientation: "botton left"
		});
		$('input[name=data_validade]').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			startView: 2,
			maxViewMode: 2,
			language: "pt-BR",
			orientation: "botton left"
		});
});

$("#outro_endereco").click( function(){
   if( $(this).is(':checked') ){
		//alert("checked");
		//$('.novo_endereco').removeAttr('readonly');
	 } else{
		//alert("rapaz q blz");
	 }
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