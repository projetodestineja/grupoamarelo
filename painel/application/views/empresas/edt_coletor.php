<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
?>

	<div class="row">
		<div class="col-md-3">
			<a href="<?php echo site_url('empresa/desbloquear/'); echo $acao_ativo; echo '/'.$result->id; ?>" class="btn btn-<?php echo $bt_ativo; ?> btn-sm"><i class="fa fa-<?php echo $icon_ativo; ?>"></i> <?php echo $texto_ativo; ?></a>
		</div>
	</div>
	<br><br>

	<div class="row">
		<div class="col-md-12">
			<form id="form_cad_coletor" action="<?php echo site_url('empresa/atualizar'); ?>" method="POST">
				<h3 class="">Dados</h3>
				<div class="form-row">
				<div class="form-group col-md-4" id="col_cnpj">
					<label for="cnpj" class="col-form-label">CNPJ</label>
					<input required type="text" class="form-control cnpj" id="cnpj" name="cnpj" value="<?php echo $result->cnpj; ?>" placeholder="00.000.000/0000-00" value="<?php echo (isset($cnpj) ? $cnpj : ''); ?>" onChange="valida_cnpj(form_cad_coletor.cnpj);" onblur="pesquisacnpj(this.value);">
				</div>
				<div class="form-group col-md-4" id="col_rsocial">
					<label required for="rsocial" class="col-form-label">Razão Social</label>
					<input type="text" class="form-control" id="rsocial" name="rsocial" value="<?php echo $result->razao_social; ?>" placeholder="Razão Social">
				</div>
				<div class="form-group col-md-4" id="col_nfantasia">
					<label for="nfantasia" class="col-form-label">Nome Fantasia</label>
					<input type="text" class="form-control" id="nfantasia" name="nfantasia" value="<?php echo $result->nome_fantasia; ?>" placeholder="Nome Fantasia">
				</div>
				</div>
				<div class="form-row">
				<div class="form-group col-md-5">
					<label for="nresponsavel" class="col-form-label">Nome do Responsável</label>
					<input required type="text" class="form-control" id="nresponsavel" name="nresponsavel" value="<?php echo $result->nome_responsavel; ?>" placeholder="Ex.: César Silva, Amauri Jr...">
				</div>
				<div class="form-group col-md-4">
						<label for="area_atuacao">Área de Atuação</label>
						<select class="form-control" id="area_atuacao" name="area_atuacao">
								<option value="0">Outra</option>
								<?php foreach ($areas as $n3) { ?>
										<option <?php if ($result->codigo_area_atuacao == $n3->codigo) { echo "selected"; } ?> value="<?php echo $n3->codigo; ?>"  ><?php echo $n3->area_atuacao; ?></option>
								<?php } ?>
						</select>
				</div>
				<div class="form-group col-md-3" id="outra_area_option">
						<label for="digite_ramo" class="col-form-label">Digite Outra Área de Atuação</label>
						<input type="text" class="form-control" id="digite_area" name="digite_area" value="<?php echo $result->outra_area_atuacao; ?>" placeholder="Especifique a área de atuação">
				</div>
				</div>
				<h3 class="">Contato</h3>
				<div class="form-row">
				<div class="form-group col-md-4">
					<label for="tel1" class="col-form-label">Telefone 1</label>
					<input required type="text" class="form-control phone" id="tel1" name="tel1" value="<?php echo $result->telefone1; ?>" placeholder="(21) 6564-0205, (27) 98500-6321...">
				</div>
				<div class="form-group col-md-4">
					<label for="tel2" class="col-form-label">Telefone 2</label>
					<input type="text" class="form-control phone" id="tel2" name="tel2" value="<?php echo $result->telefone2; ?>" placeholder="(21) 6564-0205, (27) 98500-6321...">
				</div>
				<div class="form-group col-md-4">
					<label for="email" class="col-form-label">E-mail</label>
					<input required type="email" class="form-control" id="email" name="email" value="<?php echo $result->email; ?>" placeholder="nome@dominio.com">
				</div>
				</div>
				<h3 class="">Endereço</h3>
				<div class="form-row">
				<div class="form-group col-md-2">
					<label for="cep" class="col-form-label">CEP</label>
					<input type="text" class="form-control cep" id="cep" name="cep" value="<?php echo $result->cep; ?>" placeholder="000000-000" maxlength="8" onblur="pesquisacep(this.value);">
				</div>
				<div class="form-group col-md-5">
					<label for="Rua" class="col-form-label">Rua</label>
					<input required type="text" class="form-control" id="rua" name="rua" value="<?php echo $result->logradouro; ?>" placeholder="Ex.: Av. José Silva, Rua São Cosme...">
				</div>
				<div class="form-group col-md-2">
					<label for="numero" class="col-form-label">Número</label>
					<input required type="number" class="form-control" id="numero" name="numero" value="<?php echo $result->numero; ?>" placeholder="00">
				</div>
				<div class="form-group col-md-3">
					<label for="complemento" class="col-form-label">Complemento</label>
					<input type="text" class="form-control" id="complemento" name="complemento" value="<?php echo $result->complemento; ?>" placeholder="Ex.: Casa, Apartamento...">
				</div>
				</div>
				<div class="form-row">
				<div class="form-group col-md-4">
					<label for="bairro" class="col-form-label">Bairro</label>
					<input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $result->bairro; ?>" placeholder="Ex.: São Gonçalo, Manguinhos...">
				</div>
				<div class="form-group col-md-4">
						<label for="estado" class="col-form-label">Estado</label>
						<select class="form-control" id="estado" name="estado">
								<option value="">Selecione o Estado</option>
								<?php foreach ($estados as $n) { ?>
										<option value="<?php echo $n->uf; ?>"  ><?php echo $n->nome_estado; ?></option>
								<?php } ?>
						</select>
				</div>

				<div class="form-group col-md-4">
						<label for="cidade" class="col-form-label">Cidade</label>
						<select class="form-control" id="cidade" name="cidade">
								<option value="">Selecione a Cidade</option>
						</select>
				</div>
				</div>
				<h3 class="">Acesso</h3>
				<div class="form-row">
				<div class="form-group col-md-6">
					<label for="senha1" class="col-form-label">Digite sua Senha</label>
					<input required type="password" class="form-control" id="senha1" name="senha1" placeholder="Digite sua Senha">
				</div>
				<div class="form-group col-md-6">
					<label for="senha2" class="col-form-label">Confirme sua Senha</label>
					<input required type="password" class="form-control" id="senha2" name="senha2" onchange="valida_senha();" placeholder="Confirme sua Senha">
				</div>
				</div>
				<!--input type="hidden" name="tipo_cadastro" value="J"-->
				<!--input type="hidden" name="funcao" value="2"-->
				<!--input type="number" maxlength="1" id="ativo" name="ativo" value="0" hidden-->
				<a href="<?php echo base_url('') ?>"><button class="btn btn-outline-secondary" type="button">Voltar</button></a>
				<button class="btn btn-success" type="submit">Salvar</button>
			</form>
		</div>
	</div>

	<script type="text/javascript">

	$( "#area_atuacao" ).change(function() {
		if (this.value == 0){
			$( "#outra_area_option" ).show();
			//alert('teste');
		} else{
			$( "#outra_area_option" ).hide();
		}
	});

  $(function(){

      $("select[name=estado]").change(function(){

          var estado = $(this).val();

          resetaCombo('cidade');
          load_cidades(estado,null);

      });

  });

  function load_cidades(estado,cidade=NUll){
  //alert(cidade);
    $.getJSON( '<?php echo "../../../application/empresa/getcidades/"; ?>' + 'empresa/getcidades/' + estado+'?cidade='+cidade, function (data){

        var option = new Array();

        $.each(data, function(i, obj){

            option[i] = document.createElement('option');
            $( option[i] ).attr( {value : obj.id} );
            if(obj.selected!=''){
                $( option[i] ).attr( {selected : obj.selected} );
            }
            $( option[i] ).append( obj.nome_cidade );

            $("select[name='cidade']").append( option[i] );

        });

    });

  }

  function resetaCombo( el ) {
     $("select[name='"+el+"']").empty();
     var option = document.createElement('option');
     $( option ).attr( {value : ''} );
     $( option ).append( 'Selecione a Cidade' );
     $("select[name='"+el+"']").append( option );
  }

	</script>
