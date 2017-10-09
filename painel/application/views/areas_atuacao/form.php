<form id="form_cad_area_atuacao" action="" method="POST">

		<div class="form-row">
			<div class="form-group col-md-12  required">
				<label for="area_atuacao" class="col-form-label">Descrição da Área de Atuação:</label>
				<input type="text" class="form-control" id="area_atuacao" value="<?php echo $area_atuacao; ?>" name="area_atuacao" placeholder="Digite a descrição da área de atuação">
			</div>
      <div class="form-group col-md-4  required">
				<label for="codigo" class="col-form-label">Código</label>
				<input type="text" class="form-control" id="codigo" value="<?php echo $codigo; ?>" name="codigo" placeholder="Digite o código da área de atuação">
			</div>
		</div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="ativo" class="col-form-label">Área de Atuação ativa?</label>
        <input name="ativo" type="checkbox" value="1" <?php echo (($ativo==1 or !isset($id))?'checked':''); ?> >
      </div>
    </div>

		<button class="btn btn-success btn-md btn-salvar" type="submit"> <?php echo (!isset($id)?'Cadastrar':'Atualizar'); ?> </button>
</form>
