<form id="form_cad_demandas_status" action="" method="POST">

    <div class="form-row">
        <div class="form-group col-md-12  required">
            <label for="descricao" class="col-form-label">Descrição do Status de Demandas:</label>
            <input type="text" class="form-control" id="descricao" value="<?php echo $descricao; ?>" name="descricao" maxlength="50" placeholder="Digite a descrição da área de atuação">
        </div>
        <div class="form-group col-md-2  required">
            <label for="cor" class="col-form-label">Cor</label>
            <input type="color" class="form-control" id="cor" value="<?php echo $cor; ?>" name="cor" maxlength="7" placeholder="Digite uma cor para identificação do status">
        </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="ativo" class="col-form-label">Status de Demandas ativo?</label>
        <input name="ativo" type="checkbox" value="1" <?php echo (($ativo==1 or !isset($id))?'checked':''); ?> >
      </div>
    </div>

    <button class="btn btn-success btn-md btn-salvar" type="submit"> <?php echo (!isset($id)?'Cadastrar':'Atualizar'); ?> </button>
</form>
