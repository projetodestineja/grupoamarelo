<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" href="#perfil" role="tab" data-toggle="tab">Perfil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#atuacao_secundaria" role="tab" data-toggle="tab">Atuação Secundária</a>
    </li>
</ul>


<div class="tab-content">
    <div role="tabpanel" class="tab-pane  active" id="perfil">

        <div class="row">
            <div class="col-md-12">

                <form id="form_cad_coletor" action="" method="POST">
                    
					
                    <?php if ($id_funcao) { ?>
                    <div class="form-row  required">
                        <div class="form-group col-md-4 " >
                            <label for="id_funcao">Função</label>
                            <select class="form-control" id="id_funcao" name="id_funcao">
                                <option value="1" <?php if ($id_funcao==1) echo "selected"; ?>>Gerador de Resíduos </option>
                                <option value="2" <?php if ($id_funcao==2) echo "selected"; ?>>Coletor de Resíduos </option>
                            </select>
                        </div>
                    </div>    
                    <?php } ?>  
                    
                    <input name="tipo_cadastro" type="hidden" value="<?php echo (strlen($cnpj)<=14?'F':'J'); ?>" >
                    

                    <div class="form-row  required">
                        
                        <div class="form-group col-md-4 col-pjuridica " >
                            <label for="cnpj" class="col-form-label">CNPJ</label>
                            <input type="text" class="form-control cnpj" id="cnpj" readonly name="cnpj" value="<?php echo $cnpj; ?>"  >
                        </div>
                        
                        <div class="form-group col-md-4  col-pfisica" >
                            <label for="cpf" class="col-form-label">CPF</label>
                            <input type="text" class="form-control cpf" id="cpf" readonly name="cpf" value="<?php echo $cnpj; ?>" placeholder="000.000.000-00" onChange="valida_cpf(form_cad_gerador.cpf);">
                        </div>
                        
                        <div class="form-group col-md-4 col-pjuridica" >
                            <label required for="rsocial" class="col-form-label">Razão Social</label>
                            <input type="text" class="form-control" id="rsocial" name="rsocial" value="<?php echo $razao_social; ?>" placeholder="Razão Social">
                        </div>
                        
                        <div class="form-group col-md-4  col-pjuridica" >
                            <label for="nfantasia" class="col-form-label">Nome Fantasia</label>
                            <input type="text" class="form-control" id="nfantasia" name="nfantasia" value="<?php echo $nome_fantasia; ?>" placeholder="Nome Fantasia">
                        </div>
                        
                    </div>


                    <div class="form-row  required">
                        <div class="form-group col-md-5">
                            <label for="nresponsavel" class="col-form-label">Nome do Responsável</label>
                            <input required type="text" class="form-control" id="nresponsavel" name="nresponsavel" value="<?php echo $nome_responsavel; ?>" placeholder="Ex.: César Silva">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="area_atuacao">Área de Atuação Principal</label>
                            <select class="form-control" id="area_atuacao" name="area_atuacao">
                                <option value="0">Outra</option>
                                <?php
                                if ($areas_atuacoes) {
                                    foreach ($areas_atuacoes as $n) {
                                        ?>
                                        <option <?php echo ((isset($row_atuacao_principal->codigo_area_atuacao) and $row_atuacao_principal->codigo_area_atuacao == $n->codigo) ? "selected" : ''); ?> value="<?php echo $n->codigo; ?>"  ><?php echo $n->area_atuacao; ?></option>
    <?php }
} ?>
                            </select>
                        </div>
                        <div style="display:none;" class="form-group col-md-3" id="outra_area_option">
                            <label for="digite_ramo" class="col-form-label">Digite Outra Área de Atuação </label>
                            <input type="text" class="form-control" id="digite_area" name="digite_area" value="" placeholder="Especifique a área de atuação">
                        </div>
                    </div>



                    <h3 class="">Contato</h3>
                    <div class="form-row">
                        <div class="form-group col-md-4  required">
                            <label for="tel1" class="col-form-label">Telefone 1</label>
                            <input required type="tel" class="form-control phone" id="telefone1" name="telefone1" value="<?php echo $telefone1; ?>" placeholder="(21) 6564-0205">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tel2" class="col-form-label">Telefone 2</label>
                            <input type="tel" class="form-control phone" id="telefone2" name="telefone2" value="<?php echo $telefone2; ?>" placeholder="(21) 6564-0205">
                        </div>
                        <div class="form-group col-md-4  required">
                            <label for="email" class="col-form-label">E-mail</label>
                            <input required type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" placeholder="nome@dominio.com">
                        </div>
                    </div>


                    <h3 class="">Endereço</h3>
                    <div class="form-row">
                        <div class="form-group col-md-2  required">
                            <label for="cep" class="col-form-label">CEP</label>
                            <input type="text" class="form-control cep"  required id="cep" name="cep" value="<?php echo $cep; ?>" placeholder="000000-000" maxlength="8" onblur="pesquisacep(this.value);">
                        </div>
                        <div class="form-group col-md-5  required">
                            <label for="Rua" class="col-form-label">Rua</label>
                            <input required type="text" class="form-control" id="rua" name="logradouro" value="<?php echo $logradouro; ?>" placeholder="Ex.: Av. José Silva">
                        </div>
                        <div class="form-group col-md-2  required">
                            <label for="numero" class="col-form-label">Número</label>
                            <input required type="number" class="form-control" id="numero" name="numero" value="<?php echo $numero; ?>" placeholder="00">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="complemento" class="col-form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" value="<?php echo $complemento; ?>" placeholder="Ex.: Casa, Apartamento...">
                        </div>
                    </div>
                    <div class="form-row  required">
                        <div class="form-group col-md-4">
                            <label for="bairro" class="col-form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $bairro; ?>" placeholder="Ex.: São Gonçalo">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="estado" class="col-form-label">Estado</label>
                            <select class="form-control" id="estado" name="estado">
                                <option value="">Selecione o Estado</option>
                                <?php foreach ($estados as $n) { ?>
                                    <option value="<?php echo $n->uf; ?>" <?php echo ($n->uf == $uf_estado ? 'selected' : ''); ?>   ><?php echo $n->nome_estado; ?></option>
<?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cidade" class="col-form-label">Cidade</label>
                            <select class="form-control" id="cidade" name="cidade">
                                <option value="">Selecione o Estado Antes</option>
                                <?php foreach ($cidades as $n) { ?>
                                    <option value="<?php echo $n->id; ?>" <?php echo ($n->id == $id_cidade ? 'selected' : ''); ?>  ><?php echo $n->nome_cidade; ?></option>
<?php } ?>
                            </select>
                        </div>    
                    </div>



                    <h3 class="">Acesso</h3>
                    <div class="form-row <?php echo (!isset($id) ? 'required' : ''); ?>" >
                        <div class="form-group col-md-6">
                            <label for="senha1" class="col-form-label">Digite a Senha</label>
                            <input type="password" class="form-control" id="senha1" name="senha" value="<?php echo ($this->input->post('senha') ? $this->input->post('senha') : ''); ?>" placeholder="Digite a Senha">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="senha2" class="col-form-label">Confirme a Senha</label>
                            <input type="password" class="form-control" id="senha2" name="senha2" value="<?php echo ($this->input->post('senha2') ? $this->input->post('senha2') : ''); ?>" onchange="valida_senha();" placeholder="Confirme a Senha">
                        </div>
                    </div>

                    <button class="btn btn-success btn-md btn-salvar" type="submit">Salvar</button>
                </form>
            </div>
        </div>

    </div>
    <div role="tabpanel" class="tab-pane fade" id="atuacao_secundaria">
        <?php  if ($result_atuacoes) {
            foreach ($result_atuacoes as $n) {
                ?>
                <div class="form-row" id="divatividadesecundaria">
                    <div class="form-group col-md-12">
                        <label for="atuacao_secundaria" class="col-form-label">Área de Atuação Secundária </label>
                        <input type="text" readonly class="form-control" id="atuacao_secundaria" name="<?php echo $n->codigo; ?>" value="<?php echo $n->area_atuacao; ?>"></input>
                    </div>
                </div>
            <?php }
        } else {
        ?>
            <h3>Nenhuma atuação secundaria cadastrada.</h3>
        <?php } ?>

    </div>
</div>

<script>
	<?php if(strlen($cnpj)<=14){?>
		form_empresa('F');
	<?php }else{ ?>
		form_empresa('J');
	<?php } ?>	
	
	function form_empresa(value) {

       if (value == 'F') {
           $('.col-pjuridica').hide();
           $('.col-pfisica').show();
           document.getElementById("cnpj").required = false;
           document.getElementById("cpf").required = true;
       } else {
           $('.col-pfisica').hide();
           $('.col-pjuridica').show();
           document.getElementById("cpf").required = false;
           document.getElementById("cnpj").required = true;
       }
    }
</script>
