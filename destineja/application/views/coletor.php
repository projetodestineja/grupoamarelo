<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<html lang="pt-br">
	
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/css.css') ?>">
		<title><?php echo $titulo; ?></title>

		<style type="text/css">
			#outro_ramo_option{display: none}
		</style>
	</head>

	<body>
		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<img width="200px" src="<?php echo base_url('assets/img/destinejalogo.png') ?>"/><br/>
					<h1 class="h1Forms">Cadastro - Coletor de Resíduo</h1>
					<form id="form_cad_gerador">
						<h3 class="">Dados</h3>
						<div class="form-row">
						<div class="form-group col-md-4" id="col_cnpj">
							<label for="cnpj" class="col-form-label">CNPJ</label>
							<input required type="text" class="form-control cnpj" id="cnpj" placeholder="00.000.000/0000-00" onChange="valida_cnpj(form_cad_gerador.cnpj);">
						</div>
						<div class="form-group col-md-4" id="col_rsocial">
							<label required for="rsocial" class="col-form-label">Razão Social</label>
							<input type="text" class="form-control" id="rsocial" placeholder="Razão Social">
						</div>
						<div class="form-group col-md-4" id="col_nfantasia">
							<label for="nfantasia" class="col-form-label">Nome Fantasia</label>
							<input type="text" class="form-control" id="nfantasia" placeholder="Nome Fantasia">
						</div>
						</div>
						<div class="form-row">
						<div class="form-group col-md-8">
							<label for="nresponsavel" class="col-form-label">Nome do Responsável</label>
							<input required type="text" class="form-control" id="nresponsavel" placeholder="Ex.: César Silva, Amauri Jr...">
						</div>
						</div>
						<h3 class="">Áreas de atuação</h3>
						<div class="form-row">
						<div class="col-sm-2 form-check">
							<label class="form-check-label"><input type="checkbox" value=""> Option</label>
						</div>
						<div class="col-sm-2 form-check">
							<label class="form-check-label"><input type="checkbox" value=""> Option</label>
						</div>
						<div class="col-sm-2 form-check">
							<label class="form-check-label"><input type="checkbox" value=""> Option</label>
						</div>
						<div class="col-sm-2 form-check">
							<label class="form-check-label"><input type="checkbox" value=""> Option</label>
						</div>
						<div class="col-sm-2 form-check">
							<label class="form-check-label"><input type="checkbox" value=""> Option</label>
						</div>
						<div class="col-sm-2 form-check">
							<label class="form-check-label"><input type="checkbox" value=""> Option</label>
						</div>
						</div>
						<h3 class="">Contato</h3>
						<div class="form-row">
						<div class="form-group col-md-4">
							<label for="tel1" class="col-form-label">Telefone 1</label>
							<input required type="text" class="form-control phone" id="tel1" placeholder="(21) 6564-0205, (27) 98500-6321...">
						</div>
						<div class="form-group col-md-4">
							<label for="tel2" class="col-form-label">Telefone 2</label>
							<input type="text" class="form-control phone" id="tel2" placeholder="(21) 6564-0205, (27) 98500-6321...">
						</div>
						<div class="form-group col-md-4">
							<label for="email" class="col-form-label">E-mail</label>
							<input required type="email" class="form-control" id="email" placeholder="nome@dominio.com">
						</div>
						</div>
						<h3 class="">Endereço</h3>
						<div class="form-row">
						<div class="form-group col-md-2">
							<label for="cep" class="col-form-label">CEP</label>
							<input Vtype="text" class="form-control cep" id="cep" placeholder="000000-000">
						</div>
						<div class="form-group col-md-5">
							<label for="Rua" class="col-form-label">Rua</label>
							<input required type="text" class="form-control" id="rua" placeholder="Ex.: Av. José Silva, Rua São Cosme...">
						</div>
						<div class="form-group col-md-2">
							<label for="numero" class="col-form-label">Número</label>
							<input required type="number" class="form-control" id="numero" placeholder="00">
						</div>
						<div class="form-group col-md-3">
							<label for="complemento" class="col-form-label">Complemento</label>
							<input type="text" class="form-control" id="complemento" placeholder="Ex.: Casa, Apartamento...">
						</div>
						</div>
						<div class="form-row">
						<div class="form-group col-md-4">
							<label for="bairro" class="col-form-label">Bairro</label>
							<input type="text" class="form-control" id="bairro" placeholder="Ex.: São Gonçalo, Manguinhos...">
						</div>
						<div class="form-group col-md-4">
							<label for="cidade" class="col-form-label">Cidade</label>
							<input type="text" class="form-control" id="cidade" placeholder="Ex.: Volta Redonda, Vila Velha...">
						</div>
						<div class="form-group col-md-4">
							<label for="estado" class="col-form-label">Estado</label>
							<input type="text" class="form-control" id="estado" placeholder="Ex.: Rio de Janeiro, Espírito Santo...">
						</div>
						</div>
						<h3 class="">Acesso</h3>
						<div class="form-row">
						<div class="form-group col-md-6">
							<label for="senha1" class="col-form-label">Digite sua Senha</label>
							<input required type="password" class="form-control" id="senha1" placeholder="Digite sua Senha">
						</div>
						<div class="form-group col-md-6">
							<label for="senha2" class="col-form-label">Confirme sua Senha</label>
							<input required type="password" class="form-control" id="senha2" onchange="valida_senha();" placeholder="Confirme sua Senha">
						</div>
						</div>
						<a href="<?php echo base_url('') ?>"><button class="btn btn-outline-secondary" type="button">Voltar</button></a>
						<button class="btn btn-success" type="submit">Salvar</button>
					</form>
				</div>
			</div>
		</div>
	
	</body>
	
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url('assets/js/jquery.mask.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/js.js') ?>"></script>

</html>