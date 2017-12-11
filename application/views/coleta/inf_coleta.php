<div role="tabpanel" class="tab-pane <?php if ($tab_ativa == 'inf_coleta') echo "active"; ?>" id="inf_coleta" name="inf_coleta">
    
     <?PHP if ((isset($obs)) || (($this->session->userdata['empresa']['funcao'] == 2) && ((isset($id_empresa_coletora)) && ($id_empresa_coletora == $this->session->userdata['empresa']['id'])) )) { ?>   
    
    <div class="card">
        <h5 class="card-header"><i class="fa fa-list" ></i> Destinação Final do Resíduo</h5>
        
        
        
        <div class="card-block">
        
        	 <div style="padding:15px;">
            <form action="" method="POST">    
                <input hidden type="text" class="form-control" id="id_demanda" name="id_demanda" value="<?php if (isset($id_demanda)) echo $id_demanda;?>" >
                <input hidden type="text" class="form-control" id="id_empresa_coletora" name="id_empresa_coletora" value="<?php if (isset($id_empresa_coletora)) echo $id_empresa_coletora;?>" >
               <div class="form-row">
                <div class="form-group col-md-12">
                        <label for="nome_local" class="col-form-label">Nome do local de destinação final</label>
                        <input type="text" class="form-control" id="nome_local" name="nome_local" value="<?php if (isset($nome_local)) echo $nome_local;?>" <?php if (isset($obs) || ($this->session->userdata['empresa']['funcao'] == 1)) echo "disabled";?> >
                </div>
               </div>
                <div class="form-row">
                    <div class="form-group col-md-2 required">
                        <label for="cep" class="col-form-label">CEP</label>
                        <input required type="text" class="form-control cep" id="cep" name="cep" placeholder="000000-000" maxlength="8" value="<?php if (isset($cep)) echo $cep;?>" onblur="pesquisacep(this.value);"  <?php if (isset($obs) || ($this->session->userdata['empresa']['funcao'] == 1)) echo "disabled";?>>
                    </div>
                    <div class="form-group col-md-5 required">
                        <label for="Rua" class="col-form-label">Rua</label>
                        <input required type="text" class="form-control" id="rua" name="rua" value="<?php if (isset($rua)) echo $rua;?>" <?php if (isset($obs) || ($this->session->userdata['empresa']['funcao'] == 1)) echo "disabled";?>>
                    </div>
                    <div class="form-group col-md-2 ">
                        <label for="numero" class="col-form-label">Número</label>
                        <input type="number" class="form-control" id="numero" name="numero" value="<?php if (isset($numero)) echo $numero;?>" <?php if (isset($obs) || ($this->session->userdata['empresa']['funcao'] == 1)) echo "disabled";?> >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="complemento" class="col-form-label">Complemento</label>
                        <input type="text" class="form-control" id="complemento" name="complemento" value="<?php if (isset($complemento)) echo $complemento;?>" <?php if (isset($obs) || ($this->session->userdata['empresa']['funcao'] == 1)) echo "disabled";?> >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4 required">
                        <label for="bairro" class="col-form-label">Bairro</label>
                        <input required type="text" class="form-control" id="bairro" name="bairro" value="<?php if (isset($bairro)) echo $bairro;?>" <?php if (isset($obs) || ($this->session->userdata['empresa']['funcao'] == 1)) echo "disabled";?>>
                    </div>
                    <div class="form-group col-md-4 required">
                        <label for="estado" class="col-form-label">Estado</label>
                        <select required class="form-control" id="estado" name="estado" <?php if (isset($obs) || ($this->session->userdata['empresa']['funcao'] == 1)) echo "disabled";?>>
                            <option value="">Selecione o Estado</option>
                            <?php foreach ($estados as $n) { ?>
                                <option value="<?php echo $n->uf; ?>" <?php if ((isset($uf_estado))&&($n->uf==$uf_estado)) echo "selected"; ?>  ><?php echo $n->nome_estado; ?> </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-4 required">
                        <label for="cidade" class="col-form-label">Cidade</label>
                        <select required class="form-control" id="cidade" name="cidade" <?php if (isset($obs) || ($this->session->userdata['empresa']['funcao'] == 1)) echo "disabled";?>>
                            <option value="" ><?php if (isset($nome_cidade)) echo $nome_cidade; else echo "Selecione a Cidade" ;?></option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12 ">
                        <label for="obs" class="col-form-label">Observação</label>
                        <input type="text" class="form-control" id="obs" name="obs" <?php if (isset($obs) || ($this->session->userdata['empresa']['funcao'] == 1)) echo "disabled";?> value="<?php if (isset($obs)) echo $obs;?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <button class="btn btn-success" id="btsalvarlocal" name="btsalvarlocal" value="btsalvarlocal" type="submit" <?php if (isset($obs)) echo "disabled";?>>Salvar</button>                         
                    </div>
                </div>
            </form>
            </div>
        </div>
        
       
        
    </div>
    
    
    
    <?php } else echo "Não existe destinação final cadastrada pela empresa responsável pela coleta do resíduo." ?>    
</div>

<script>

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
