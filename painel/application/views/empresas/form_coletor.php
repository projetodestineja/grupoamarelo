<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" href="#perfil" role="tab" data-toggle="tab">Perfil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#atuacao_secundaria" role="tab" data-toggle="tab">Atuação Secundária</a>
    </li>
    <?php if(isset($id)){ ?>
     <li class="nav-item">
        <a class="nav-link" href="#licenca" role="tab" data-toggle="tab">Licença</a>
    </li>
    <?php } ?>
</ul>



<form id="form_cad_coletor"  action="" method="POST" enctype="multipart/form-data" >
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane  active" id="perfil">

            <div class="row">
                <div class="col-md-12">

                    <?php if ($id_funcao) { ?>
                        <input name="id_funcao" type="hidden" value="<?php echo $id_funcao; ?>" >
                    <?php } ?>  
                            
                    <div class="form-row  required">
                        <div class="form-group col-md-4 " >
                            <label for="cnpj" class="col-form-label">CNPJ</label>
                            <input type="text" class="form-control cnpj" id="cnpj" name="cnpj" value="<?php echo $cnpj; ?>" onblur="pesquisacnpj(this.value);"  >
                        </div>
                        <div class="form-group col-md-4" >
                            <label required for="rsocial" class="col-form-label">Razão Social</label>
                            <input type="text" class="form-control" id="rsocial" name="rsocial" value="<?php echo $razao_social; ?>" placeholder="Razão Social">
                        </div>
                        <div class="form-group col-md-4" >
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
                                <?php if ($areas_atuacoes) {
                                    foreach ($areas_atuacoes as $n) {
										$selected = ((isset($row_atuacao_principal->codigo_area_atuacao) and $row_atuacao_principal->codigo_area_atuacao == $n->codigo) ? "selected" : '');
                                ?>
                                <option <?php echo $selected; ?> value="<?php echo $n->codigo; ?>"  ><?php echo $n->area_atuacao; ?></option>
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
                            <input required type="tel" class="form-control phone" id="tel1" name="telefone1" value="<?php echo $telefone1; ?>" placeholder="(21) 6564-0205">
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
                    <div class="form-row  required">
                        <div class="form-group col-md-2">
                            <label for="cep" class="col-form-label">CEP</label>
                            <input required type="text" class="form-control cep" id="cep" name="cep" value="<?php echo $cep; ?>" placeholder="000000-000" maxlength="8" onblur="pesquisacep(this.value);">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="Rua" class="col-form-label">Rua</label>
                            <input required type="text" class="form-control" id="rua" name="logradouro" value="<?php echo $logradouro; ?>" placeholder="Ex.: Av. José Silva">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="numero" class="col-form-label">Número</label>
                            <input required type="number" class="form-control" id="numero" name="numero" value="<?php echo $numero; ?>" placeholder="00">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="complemento" class="col-form-label">Complemento</label>
                            <input required type="text" class="form-control" id="complemento" name="complemento" value="<?php echo $complemento; ?>" placeholder="Ex.: Casa, Apartamento...">
                        </div>
                    </div>
                    <div class="form-row  required">
                        <div class="form-group col-md-4">
                            <label for="bairro" class="col-form-label">Bairro</label>
                            <input required type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $bairro; ?>" placeholder="Ex.: São Gonçalo">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="estado" class="col-form-label">Estado</label>
                            <select required class="form-control" id="estado" name="estado">
                                <option value="">Selecione o Estado</option>
                                <?php foreach ($estados as $n) { ?>
                                    <option value="<?php echo $n->uf; ?>" <?php echo ($n->uf == $uf_estado ? 'selected' : ''); ?>   ><?php echo $n->nome_estado; ?></option>
								<?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cidade" class="col-form-label">Cidade</label>
                            <select required class="form-control" id="cidade" name="cidade">
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
                            <input type="password" class="form-control" id="senha2" name="senha2" value="<?php echo ($this->input->post('senha2') ? $this->input->post('senha2') : ''); ?>"  placeholder="Confirme a Senha">
                        </div>
                    </div>

                    <button class="btn btn-success btn-md btn-salvar" type="submit">Salvar</button>

                </div>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane fade" id="atuacao_secundaria">

            <?php
            if ($result_atuacoes) {
                $atuacao = 0;
                foreach ($result_atuacoes as $n) {
                    ?>
                    <div class="form-row">
                        <div class="form-group col-md-10" id="divsel<?php echo $atuacao; ?>"  >
                            <select class="form-control col-md-10" id="area_atuacao_secundaria<?php echo $atuacao; ?>" name="atuacao_secundaria[]" >
                                <?php if ($areas_atuacoes) {
                                    foreach ($areas_atuacoes as $at) {
                                ?>
                                <option <?php echo ($n->codigo_area_atuacao == $at->codigo ? "selected" : ''); ?> value="<?php echo $at->codigo; ?>"  ><?php echo $at->area_atuacao; ?></option>
            <?php }
        } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2" id="divbt<?php echo $atuacao; ?>" name="divbt<?php echo $atuacao; ?>" >
                            <button class="btn btn-danger" type="button" onclick="remove_atividade(document.getElementById('area_atuacao_secundaria<?php echo $atuacao; ?>').value,<?php echo $atuacao; ?>);" >
                                Excluir
                            </button>
                        </div>
                    </div>
                    <?php
                    $atuacao++;
                }
            } else {
                ?>
                <h3>Nenhuma atuação secundaria cadastrada.</h3>
            <?php } ?>

            <div  id="divatividadesecundaria" ></div>


            <input type="button" class="btn btn-secondary" value="Adicionar Atividade Secundária" onclick="add_atividade_secundaria();">
            <br><br>
            <button class="btn btn-success btn-md btn-salvar" type="submit">Salvar</button>
        </div>
        
        <?php if(isset($id)){ ?>
        <div role="tabpanel" class="tab-pane fade" id="licenca">
            <div align="right" >
            <a class="btn btn-primary"  href="<?php echo site_url('empresa/licenca_form/'.$id); ?>" rel="modal_add_edit"   >
              <i class="fa fa-fw fa-plus"></i>  Cadastrar Arquivo
            </a>
            </div>
            <div id="result_licenca" style="margin-top:15px;" ></div>
        </div> 
        <?php } ?>
    </div>
</form>

<style>
    .has-error .form-control{ border:red solid 1px;}
	.has-error{color:#F00}
    
    .loading_form{ display:none; background:  url('<?php echo base_url('assets/img/ajax-loader.gif');?>') no-repeat center center rgba(255,255,255,0.8);  position: absolute; top: 0px; bottom: 0px; left: 0px; right: 0px; z-index: 9999;  }
</style>   

<script>
	<?php if (isset($atuacao)) { ?>
        var atuacao = <?php echo (int) $atuacao; ?>;
	<?php } else { ?>
        var atuacao = 0;
	<?php } ?>
</script>
