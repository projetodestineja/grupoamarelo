<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>

<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="<?php echo base_url('painel/assets/css/css.css') ?>">
        <title><?php echo $titulo; ?></title>

        <style type="text/css">
            #col_cpf, #outro_ramo_option{display: none}
        </style>
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="<?php echo site_url(); ?>" >
                        <img width="200px" src="<?php echo base_url('painel/assets/img/destinejalogo.png') ?>"/>
                    </a>
                    <br/>
                    <h1 class="h1Forms">Cadastro - Gerador de Resíduo</h1>

                    <?php if (!empty($erro)) { ?>
                        <div class="alert alert-danger"><?php echo $erro; ?></div>
                    <?php } ?>

                    <form id="form_cad_gerador" action="<?php echo site_url('empresa/cadastrar'); ?>" method="POST">    
                        <input type="number" maxlength="1" id="ativo" name="ativo" value="1" hidden>

                        <div class="form-group col-md-4">
                            <label for="funcao" class="col-form-label" hidden>Função da Empresa</label>
                            <select class="form-control" id="funcao" name="funcao" hidden>
                                <?php foreach ($funcoes as $n4) { ?>
                                <option value="<?php echo $n4->id; ?>"  selected="selected"><?php echo $n4->funcao; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <h3 class="">Tipo de cadastro</h3>
                        <div class="form-row">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input checked class="form-check-input" type="radio" name="tipo_cadastro" id="pjuridica" name="pjuridica" value="J"> Pessoa Jurídica</input>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="tipo_cadastro" id="pfisica" name="pfisica" value="F"> Pessoa Física</input>
                                </label>
                            </div>

                        </div>
                        <h3 class="">Dados</h3>
                        <div class="form-row">
                            <div class="form-group col-md-4 required" id="col_cnpj">
                                <label for="cnpj" class="col-form-label">CNPJ</label>
                                <input required type="text" class="form-control cnpj" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00" value="<?php echo (isset($cnpj) ? $cnpj : ''); ?>" onChange="valida_cnpj(form_cad_gerador.cnpj);" onblur="pesquisacnpj(this.value);">
                            </div>
                            <div class="form-group col-md-4" id="col_cpf">
                                <label for="cpf" class="col-form-label">CPF</label>
                                <input type="text" class="form-control cpf" id="cpf" name="cpf" placeholder="000.000.000-00" onChange="valida_cpf(form_cad_gerador.cpf);">
                            </div>
                            <div class="form-group col-md-4" id="col_rsocial">
                                <label for="rsocial" class="col-form-label">Razão Social</label>
                                <input type="text" class="form-control" id="rsocial" name="rsocial" placeholder="Razão Social">
                            </div>
                            <div class="form-group col-md-4" id="col_nfantasia">
                                <label for="nfantasia" class="col-form-label">Nome Fantasia</label>
                                <input type="text" class="form-control" id="nfantasia" name="nfantasia" placeholder="Nome Fantasia">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="nresponsavel" class="col-form-label required">Nome do Responsável</label>
                                <input required type="text" class="form-control" id="nresponsavel" name="nresponsavel" placeholder="Ex.: César Silva, Amauri Jr...">
                            </div>
                            <div id="divatividadeprincipal" name="divatividadeprincipal" class="form-group col-md-4">
                                <label for="area_atuacao">Atividade Principal</label>
                                <select class="form-control" id="area_atuacao" name="area_atuacao">
                                    <option value="0">Outra</option>
                                    <?php foreach ($areas as $n3) { ?>
                                        <option value="<?php echo $n3->codigo; ?>" title="<?php echo "Código da Atividade: $n3->codigo";  ?>" ><?php echo $n3->area_atuacao; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="outra_area_option">
                                <label for="digite_ramo" class="col-form-label">Digite Outra Área de Atuação</label>
                                <input type="text" class="form-control" id="digite_area" name="digite_area" placeholder="Especifique a área de atuação">
                            </div>
                        </div>
                        
                        <div id="corpo_form" name="corpo_form" >
                        <div  id="divatividadesecundaria" >    
                            
                        </div>
                        
                        <input type="button" class="btn btn-secondary" value="Adicionar Atividade Secundária" onclick="add_atividade_secundaria();">
                        <br><br>
                        <h3 class="">Contato</h3>
                        <div class="form-row">
                            <div class="form-group col-md-4 required">
                                <label for="tel1" class="col-form-label ">Telefone 1</label>
                                <input required type="text" class="form-control phone" id="tel1" name="tel1" placeholder="(21) 6564-0205, (27) 98500-6321...">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tel2" class="col-form-label">Telefone 2</label>
                                <input type="text" class="form-control phone" id="tel2" name="tel2" placeholder="(21) 6564-0205, (27) 98500-6321...">
                            </div>
                            <div class="form-group col-md-4 required">
                                <label for="email" class="col-form-label ">E-mail</label>
                                <input required type="email" class="form-control" id="email" name="email" placeholder="nome@dominio.com">
                            </div>
                        </div>
                        <h3 class="">Endereço</h3>
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
                                <input type="number" class="form-control" id="numero" name="numero" placeholder="00">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="complemento" class="col-form-label">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Ex.: Casa, Apartamento,...">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 required">
                                <label for="bairro" class="col-form-label ">Bairro</label>
                                <input required type="text" class="form-control" id="bairro" name="bairro" placeholder="Ex.: São Gonçalo, Manguinhos...">
                            </div>

                            <div class="form-group col-md-4 required">
                                <label for="estado" class="col-form-label ">Estado</label>
                                <select required class="form-control" id="estado" name="estado">
                                    <option value="">Selecione o Estado</option>
                                    <?php foreach ($estados as $n) { ?>
                                        <option value="<?php echo $n->uf; ?>"  ><?php echo $n->nome_estado; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4 required">
                                <label for="cidade" class="col-form-label ">Cidade</label>
                                <select required class="form-control" id="cidade" name="cidade">
                                    <option value="">Selecione a Cidade</option>
                                </select>
                            </div>

                        </div>
                        <h3 class="">Acesso</h3>
                        <div class="form-row">
                            <div class="form-group col-md-6 required">
                                <label for="senha1" class="col-form-label ">Digite sua Senha</label>
                                <input required type="password" class="form-control" id="senha1" name="senha1" placeholder="Digite sua Senha">
                            </div>
                            <div class="form-group col-md-6 required">
                                <label for="senha2" class="col-form-label ">Confirme sua Senha</label>
                                <input required type="password" class="form-control" id="senha2" name="senha2" onchange="valida_senha();" placeholder="Confirme sua Senha">
                            </div>
                        </div>
                        <br>
                        </div>    
                        <button class="btn btn-success" type="submit">Salvar</button>
                        <button class="btn btn-warning" type="button" onclick="location.reload();">Limpar Formulário</button>
                        <a href="<?php echo base_url('') ?>"><button class="btn btn-outline-secondary" type="button">Voltar</button></a>
                    </form>
                </div>
            </div>
        </div>

    </body>

	<script src="<?php echo base_url('painel/assets/pluguins/jquery/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('painel/assets/pluguins/popper/popper.min.js'); ?>"></script>
        <script src="<?php echo base_url('painel/assets/pluguins/bootstrap/js/bootstrap.min.js'); ?>"></script>

	<script src="<?php echo site_url('painel/assets/pluguins/jquery.mask.js') ?>"></script>
	<script src="<?php echo site_url('painel/assets/js/js.js') ?>"></script>
	<script src="<?php echo site_url('painel/assets/pluguins/buscacep.js') ?>"></script>
        <script src="<?php echo site_url('painel/assets/pluguins/buscacnpj.js') ?>"></script>
	<script type="text/javascript">
	$( "#pjuridica" ).click(function() {
		$( "#col_cnpj" ).show();
		$( "#col_rsocial" ).show();
		$( "#col_nfantasia" ).show();
		$( "#col_cpf" ).hide();
		document.getElementById("cpf").required = false;
		document.getElementById("cnpj").required = true;
		//alert("1");
	});


	$( "#pfisica" ).click(function() {
		$( "#col_cnpj" ).hide();
		$( "#col_rsocial" ).hide();
		$( "#col_nfantasia" ).hide();
		$( "#col_cpf" ).show();
		document.getElementById("cnpj").required = false;
		document.getElementById("cpf").required = true;
		//alert("2");
	});

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

            $("select[name=area_atuacao]").change(function(){

               var e = document.getElementById("area_atuacao");
                var itemSelecionado = e.options[e.selectedIndex].value;

                if(itemSelecionado!=0){
                    $( "#outra_area_option" ).hide();
                    $("#divatividadeprincipal").removeClass("form-group col-md-4");
                    $("#divatividadeprincipal").addClass("form-group col-md-8");
                }
                else{
                    $("#divatividadeprincipal").removeClass("form-group col-md-8");
                    $("#divatividadeprincipal").addClass("form-group col-md-4");
                }

            });
            
            $("input[name=cpf]").change(function(){
                var cpf = $(this).val();
                if (cpf.length==14){
                $("#corpo_form").show();
            }
            }); 
            
            $("input[name=cnpj]").change(function(){
                var cnpj = $(this).val();
                if (cnpj.length==18){
                $("#corpo_form").show();
                }
            });
            
        });

        function load_cidades(estado,cidade=NUll){
        //alert(cidade);
                $.getJSON( '<?php echo site_url(); ?>' + 'empresa/getcidades/' + estado+'?cidade='+cidade, function (data){

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

        $('#area_atuacao option').each(function() {
			var minhaString = $(this).text();
			if(minhaString.length > 90){
				$(this).text(minhaString.substring(0,90) + ' ...');
			}
        });
        
        $("#corpo_form").hide();
        
	</script>

</html>
