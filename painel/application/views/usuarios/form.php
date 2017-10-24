
<form id="form_cad_gerador" action="" method="POST">

		<div class="form-row">
			<div class="form-group col-md-12  required">
				<label for="nome" class="col-form-label">Nome Completo:</label>
				<input type="text" class="form-control" id="nome" value="<?php echo $nome; ?>" name="nome" placeholder="Digite o nome completo">
			</div>
            <div class="form-group col-md-4  required">
				<label for="tel1" class="col-form-label">Telefone 1</label>
				<input type="text" class="form-control phone" id="tel1" value="<?php echo $telefone; ?>" name="telefone" placeholder="(00) 0000-0000">
			</div>
			<div class="form-group col-md-4">
				<label for="tel2" class="col-form-label">Telefone 2</label>
				<input type="text" class="form-control phone" id="tel2" value="<?php echo $celular; ?>" name="celular" placeholder="(00) 0000-0000">
			</div>
			<div class="form-group col-md-4  required">
				<label for="email" class="col-form-label">E-mail</label>
				<input type="email" class="form-control" id="email" value="<?php echo $email; ?>" name="email" placeholder="nome@dominio.com">
			</div>
		</div>

        <h3 class="">Endereço</h3>
		<div class="form-row">
			<div class="form-group col-md-2 required">
				 <label for="cep" class="col-form-label">CEP</label>
				 <input type="text" class="form-control cep" id="cep" value="<?php echo $cep; ?>" name="cep" placeholder="00000-000" maxlength="8" onblur="pesquisacep(this.value);" >
			</div>
			<div class="form-group col-md-5  required">
				 <label for="lagradouro" class="col-form-label">Lagradouro</label>
				 <input type="text" class="form-control" id="rua" value="<?php echo $logradouro; ?>" name="logradouro" placeholder="Ex.: Av. José Silva...">
			</div>
			<div class="form-group col-md-2  required">
				 <label for="numero" class="col-form-label">Número</label>
				 <input type="text" class="form-control" id="numero" value="<?php echo $numero; ?>" name="numero" placeholder="00">
			</div>
			<div class="form-group col-md-3  required">
				<label for="complemento" class="col-form-label">Complemento</label>
				<input type="text" class="form-control" id="complemento" value="<?php echo $complemento; ?>" name="complemento" placeholder="Ex.: Casa, Apartamento,...">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-4  required">
				<label for="bairro" class="col-form-label">Bairro</label>
				<input type="text" class="form-control" id="bairro" value="<?php echo $bairro; ?>" name="bairro" placeholder="Ex.: São Gonçalo, Manguinhos...">
			</div>
			<div class="form-group col-md-4">
				<label for="estado" class="col-form-label">Estado</label>
                <select class="form-control" id="estado" name="estado">
                   <option value="">Selecione o Estado</option>
                   <?php foreach ($estados as $n) {?>
                  	<option value="<?php echo $n->uf; ?>" <?php echo ($n->uf==$estado?'selected':''); ?>   ><?php echo $n->nome_estado;?></option>
                   <?php } ?>
                </select>
			</div>
            <div class="form-group col-md-4">
				<label for="cidade" class="col-form-label">Cidade</label>
                   <select class="form-control" id="cidade" name="cidade">
                     <option value="">Selecione o Estado Antes</option>
                     <?php foreach ($cidades as $n) {?>
                  		<option value="<?php echo $n->id; ?>" <?php echo ($n->id==$cidade?'selected':''); ?>  ><?php echo $n->nome_cidade;?></option>
                   	 <?php } ?>
                </select>
			</div>
		</div>

        <h3 class="">Acesso</h3>
        <div class="form-row">
        	<div class="form-group col-md-12">
            	<label for="habilitado" class="col-form-label">Usuário Habilitado?</label>
            	<input name="habilitado" type="checkbox" value="1" <?php echo (($habilitado==1 or !isset($id))?'checked':''); ?> >
            </div>
        </div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="senha1" class="col-form-label">Digite sua Senha</label>
				<input type="password" class="form-control" id="senha1" value="<?php echo ($this->input->post('senha')?$this->input->post('senha'):''); ?>" name="senha" placeholder="Digite sua Senha">
			</div>
			<div class="form-group col-md-6">
				<label for="senha2" class="col-form-label">Confirme sua Senha</label>
				<input type="password" class="form-control" id="senha2" value="<?php echo ($this->input->post('senha2')?$this->input->post('senha2'):''); ?>" name="senha2" onchange="valida_senha();" placeholder="Confirme sua Senha">
			</div>
		</div>


		<button class="btn btn-success btn-md btn-salvar" type="submit"> <?php echo (!isset($id)?'Cadastrar':'Atualizar'); ?> </button>
</form>
