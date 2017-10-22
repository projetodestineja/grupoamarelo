<form id="form_cad_demanda" action="" method="POST">

		<div class="form-row">
			<div class="form-group col-md-3 required">
				<label for="data_inicio" class="col-form-label">Início do Anúncio:</label>
				<input type="date" class="form-control date" id="data_inicio" value="<?php echo $data_inicio; ?>" name="data_inicio" placeholder="Escolha uma data para o anúncio ser disponibilizado">
			</div>
      <div class="form-group col-md-3 required">
				<label for="data_validade" class="col-form-label">Expiração do Anúncio:</label>
				<input type="date" class="form-control date" id="data_validade" value="<?php echo $data_validade; ?>" name="data_validade" placeholder="Escolha uma data para o anúncio expirar">
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
				<label for="licenca" class="col-form-label">Imagem 1 - Tamanho Máx.: 5MB</label>
				<input type="file" accept="image/x-png,image/gif,image/jpeg" class="form-control" id="input-licenca" name="licenca" >
			</div>
		</div>

		<div class="form-row">
      <div class="form-group col-md-12 required">
        <label for="obs" class="col-form-label">Observações:</label>
				<textarea class="form-control" id="obs" value="<?php echo $obs; ?>" name="obs" rows="5" placeholder="Utilize este campo para observações tais como: dificuldade para entrada de veículos grandes, disponibilidade de horário, etc."></textarea>
      </div>
    </div>

		<button class="btn btn-success btn-md btn-salvar" type="submit"> <?php echo (!isset($id)?'Cadastrar':'Atualizar'); ?> </button>
</form>