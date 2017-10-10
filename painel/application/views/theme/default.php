<!DOCTYPE html>
<html lang="pt-br">

  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $title; ?></title>


        <?php
        /** -- Copy from here -- */
        if (!empty($meta))
            foreach ($meta as $name => $content) {
                ?>
                <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" /><?php
            }
        if (!empty($canonical)) {
            ?>
            <link rel="canonical" href="<?php echo $canonical ?>" />
        <?php } ?>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url('assets/pluguins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <!-- Custom fonts for this template -->
        <link href="<?php echo base_url('assets/pluguins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
        <!-- Plugin CSS -->
        <link href="<?php echo base_url('assets/pluguins/datatables/dataTables.bootstrap4.css'); ?>" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?php echo base_url('assets/css/sb-admin.css'); ?>" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    </head>

    <body class="fixed-nav sticky-footer bg-dark <?php echo ((isset($_COOKIE['menu-vertital-painel']) and $_COOKIE['menu-vertital-painel'] == 'sim') ? 'sidenav-toggled' : ''); ?>" id="page-top">

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <a class="navbar-brand" href="<?php echo site_url('painel'); ?>" >
                <img style="height:25px;" src="<?php echo base_url('assets/img/destinejalogo.png'); ?>"/>
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">         
                <?php $this->load->view('theme/menu'); ?>
      		</div>
    </nav>





    <div class="content-wrapper">

      <div class="container-fluid">
		<?php if(isset($menu_mapa)){ ?>
        <!-- Breadcrumbs -->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?php echo site_url(); ?>">Painel</a>
          </li>
          <?php

            foreach($menu_mapa as $key => $item) {
              if(empty($item)){
                echo '<li class="breadcrumb-item active" >'.$key.'</li>';
              }else{
                echo '<li class="breadcrumb-item" ><a href="'.site_url($item).'" >'.$key.'</a></li>';
              }
            }

          ?>
        </ol>
        <?php } ?>
        <div class="row" >
            <div class="col-md-4">
                <h1 style="font-size:27px;"><?php echo $title; ?></h1>

            </div>
            <div class="col-md-8 text-right">
                <span id="colvis"></span>
                <?php
		if(isset($menu_opcao_direita)){
                    foreach($menu_opcao_direita as $menu_r){
                        echo ' '.$menu_r;
                    }
		}
		?>
            </div>
        </div>

        <?php
	if($this->session->flashdata('resposta_erro') or isset($resposta_erro)){ ?>
            <div class="alert alert-danger" >
             <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>

            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<?php echo ($this->session->flashdata('resposta_erro')?$this->session->flashdata('resposta_erro'):''); ?>
            <?php echo ($resposta_erro?$resposta_erro:''); ?>
        </div>
	<?php }
        if($this->session->flashdata('resposta_ok')){ ?>
            <div class="alert alert-success " >
           <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php echo $this->session->flashdata('resposta_ok'); ?>

            </div>
        <?php } ?>

        <div class="conteudo">
            <?php echo $output;?>
        </div>

     </div>
    </div>


         


    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>&copy; <?php echo $this->config->item('title').' '.date('Y'); ?> - Load {elapsed_time} Seg. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter V <strong>' . CI_VERSION . '</strong>' : '' ?></small>
        </div>
      </div>
    </footer>

    <!-- Ir para o Topo -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

        <!-- Modal sair do painel-->
        <?php $this->load->view('modal/sair'); ?>

        <div id="modal_add_edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="plan-info" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="title_modal">#</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><!-- /# content goes here --></div>
                </div>
            </div>
        </div>



       <!-- Bootstrap core JavaScript -->
        <script src="<?php echo base_url('assets/pluguins/popper/popper.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/pluguins/bootstrap/js/bootstrap.min.js'); ?>"></script>


        <!-- Plugin JavaScript -->
        <script src="<?php echo base_url('assets/pluguins/jquery-easing/jquery.easing.min.js'); ?>" ></script>

        <!-- Calendário -->
        <link rel="stylesheet" href="<?php echo base_url('assets/pluguins/datepicker/css/bootstrap-datepicker.min.css'); ?>" type="text/css" />

        <script src="<?php echo base_url('assets/pluguins/datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/pluguins/datepicker/locales/bootstrap-datepicker.pt-BR.min.js'); ?>"></script>

        <?php
        // Load CSS Controller
        foreach ($css as $file) {
            ?>
            <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" />
        <?php
        }
        // Load JS Controller
        foreach ($js as $file) {
            ?>
            <script src="<?php echo $file; ?>"></script>
        <?php } ?>

        <script src="<?php echo site_url('assets/pluguins/buscacep.js') ?>" ></script>           
        <script src="<?php echo site_url('assets/pluguins/jquery.mask.js') ?>" ></script>
        <script src="<?php echo site_url('assets/js/js.js') ?>"></script>

        <!-- Custom scripts for this template -->
        <script src="<?php echo base_url('assets/js/sb-admin.js'); ?>"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('a[rel=modal_add_edit]').on('click', function (evt) {
                    evt.preventDefault();
                    var modal = $('#modal_add_edit').modal({backdrop: 'static', keyboard: false});

                    modal.find('#modal_add_edit .modal-body').load($(this).attr('href'), function (responseText, textStatus) {
                        if (textStatus === 'success' || textStatus === 'notmodified') {
                            modal.show();
                        }
                    });
                    return false;
                });



            });

        </script>
        <script>

            $(document).ready(function () {
                $('.btn-add-edit-modal').on("click", function () {
                    pop_up_form(this);
                });
            });

            <?php if (isset($id)) { ?>
                certificados_list(<?php echo $id; ?>);
            <?php } ?>

            function certificados_list(id) {

                $("#result_certificados").load("<?php echo site_url('empresa/certificados_list/') ?>" + id, function () {
                    /*alert( "carregouuuuu...." );*/
                });
            }

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

            function load_cidades(estado, cidade = NUll) {

                $.getJSON('<?php echo site_url(); ?>' + 'endereco/getcidades/' + estado + '?cidade=' + cidade, function (data) {
                    var option = new Array();
                    $.each(data, function (i, obj) {
                        option[i] = document.createElement('option');
                        $(option[i]).attr({value: obj.id});
                        if (obj.selected != '') {
                            $(option[i]).attr({selected: obj.selected});
                        }
                        $(option[i]).append(obj.nome_cidade);
                        $("select[name=cidade]").append(option[i]);
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

            $(document).ready(function () {

                if ($('input[name=tipo_cadastro]:checked').val()) {
                    form_empresa($('input[name=tipo_cadastro]:checked').val());
                }

                $("input[name=tipo_cadastro]").click(function () {
                    form_empresa($(this).val());
                });


                $("#rnegocio").change(function () {
                    if (this.value == "outro") {
                        $("#outro_ramo_option").show();
                        //alert('teste');
                    } else {
                        $("#outro_ramo_option").hide();
                    }
                });


                $('[data-toggle="tooltip"]').tooltip();
                $('.menu-vertical-principal .menu-v-<?php echo $this->uri->segment(1); ?>').addClass("active");

                $("select[name=estado]").change(function () {
                    var estado = $(this).val();
                    resetaCombo('cidade');
                    load_cidades(estado, '');
                });


            });





            /****************************************************
             * 
             *      @type Buscar CNPJ e Cadastrar Atuacao
             * 
             *****************************************************/
            if (atuacao != 0) {
                var i = atuacao;
            } else {
                var i = <?php echo (isset($atuacao) ? $atuacao : 0); ?>;
            }
            function limpa_formulario_cnpj() {
                //Limpa valores do formulario de cnpj.
                document.getElementById('rsocial').value = "";
                document.getElementById('nfantasia').value = "";
                document.getElementById('area_atuacao').value = "";
                document.getElementById('tel1').value = "";
                document.getElementById('email').value = "";
                document.getElementById('cep').value = "";
                document.getElementById('rua').value = "";
                document.getElementById('numero').value = "";
                document.getElementById('complemento').value = "";
                document.getElementById('estado').value = "";
                document.getElementById('bairro').value = "";
                resetaCombo('cidade');
            }

            function preenche_cnpj(conteudo) {
                if (conteudo.status == 'OK') {
                    //trata variaveis

                    area_atuacao = conteudo.atividade_principal[0].code;
                    area_atuacao = area_atuacao.replace(/\D/g, '');

                    for (i = 0; i < conteudo.atividades_secundarias.length; i++) {
                        if (conteudo.atividades_secundarias[i].code.length > 0) {
                            var divPai = $("#divatividadesecundaria");

                            divPai.append("<div class=\"form-row\" >");
                            divPai.append("<label for=\"area_atuacao_secundaria" + i + "\" >Atividade Secundária </label>");
                            divPai.append("</div>");
                            divPai.append("<div class=\"form-row\"><div class=\"form-group col-md-10\" id=\"divsel" + i + "\"  ><select class=\"form-control col-md-10\" id=\"area_atuacao_secundaria" + i + "\" name=\"atuacao_secundaria[]\" ></select></div><div class=\"form-group col-md-2\" id=\"divbt" + i + "\" name=\"divbt" + i + "\"><button class=\"btn btn-danger\" type=\"button\" onclick=\"remove_atividade(document.getElementById('area_atuacao_secundaria" + i + "').value," + i + ") ;\">Excluir</button></div></div>");
                            //o html da div do select foi colocado na msm linha pois ele não conseguia dividir as colunas se fossem appends separados

                            cod_atuacao = conteudo.atividades_secundarias[i].code;
                            txt_atuacao = conteudo.atividades_secundarias[i].text;
                            cod_atuacao = cod_atuacao.replace(/\D/g, '');

                            var option = new Option(txt_atuacao, cod_atuacao);
                            var select = document.getElementById("area_atuacao_secundaria" + i);
                            select.add(option);

                            document.getElementById("area_atuacao_secundaria" + i).value = (cod_atuacao);
                            document.getElementById("area_atuacao_secundaria" + i).text = (txt_atuacao);
                        }
                    }
                    //Atualiza os campos com os valores.
                    document.getElementById('rsocial').value = (conteudo.nome);
                    document.getElementById('nfantasia').value = (conteudo.fantasia);
                    document.getElementById('area_atuacao').value = (area_atuacao);

                    var e = document.getElementById("area_atuacao");
                    var itemSelecionado = e.options[e.selectedIndex].value;

                    if (itemSelecionado > 0) {
                        $("#outra_area_option").hide();
                        $("#divatividadeprincipal").removeClass("form-group col-md-4");
                        $("#divatividadeprincipal").addClass("form-group col-md-8");
                    }

                    document.getElementById('tel1').value = (conteudo.telefone);
                    document.getElementById('email').value = (conteudo.email);
                    document.getElementById('cep').value = (conteudo.cep);
                    document.getElementById('rua').value = (conteudo.logradouro);
                    document.getElementById('numero').value = (conteudo.numero);
                    document.getElementById('complemento').value = (conteudo.complemento);
                    document.getElementById('estado').value = (conteudo.uf);
                    document.getElementById('bairro').value = (conteudo.bairro);

                    load_cidades(conteudo.uf, conteudo.municipio);

                    //leva o cursor para o campo responsavel
                    $("#nresponsavel").focus();

                } //end if.
                else {
                    //CNPJ não Encontrado.
                    limpa_formulario_cnpj();
                    alert("CNPJ não encontrado.");
                }
            }

            function pesquisacnpj(valor) {

                //Nova variavel "cnpj" somente com dígitos.
                var cnpj = valor.replace(/\D/g, '');

                //Verifica se campo cnpj possui valor informado.
                if (cnpj != "") {

                    //Expressão regular para retirar digitos nao numericos CNPJ.
                    cnpj = cnpj.replace(/[^0-9]/g, '');

                    //Valida o formato do CNPJ.
                    if (cnpj.length == 14) {

                        //Cria um elemento javascript.
                        var script = document.createElement('script');

                        //Sincroniza com o callback.
                        script.src = 'https://www.receitaws.com.br/v1/cnpj/' + cnpj + '/?callback=preenche_cnpj';

                        //Insere script no documento e carrega o conteúdo.
                        document.body.appendChild(script);

                    } //end if.
                    else {
                        //cnpj é invalido.
                        limpa_formulario_cnpj();
                        alert("Formato de CNPJ invalido.");
                    }
                } //end if.
                else {
                    //cnpj sem valor, limpa formulario.
                    limpa_formulario_cnpj();
                }
            }


            function remove_atividade(value, i) {
                document.getElementById('area_atuacao_secundaria' + i).value = "0";
                $("label[for=\"area_atuacao_secundaria" + i + "\"]").css('display', 'none');
                $("#divsel" + i).hide();
                $("#divbt" + i).hide();

            }

            function add_atividade_secundaria() {
                var divPai = $("#divatividadesecundaria");
                divPai.append("<div class=\"form-row\" >");
                divPai.append("<label for=\"area_atuacao_secundaria" + i + "\" >Atividade Secundária </label>");
                divPai.append("</div>");
                divPai.append("<div class=\"form-row\"><div class=\"form-group col-md-10\" id=\"divsel" + i + "\"  ><select class=\"form-control col-md-10\" id=\"area_atuacao_secundaria" + i + "\" name=\"atuacao_secundaria[]\" \">    </select></div><div class=\"form-group col-md-2\" id=\"divbt" + i + "\" name=\"divbt" + i + "\"><button class=\"btn btn-danger\" type=\"button\" onclick=\"remove_atividade(document.getElementById('area_atuacao_secundaria" + i + "').value," + i + ") ;\">Excluir</button></div></div>");

                combopai = document.getElementById("area_atuacao").options;
                for (j = 0; j < (combopai.length); j++) {

                    if (combopai[j].value > 0) {
                        var option = new Option(combopai[j].text, combopai[j].value);
                        var select = document.getElementById("area_atuacao_secundaria" + i);
                        select.add(option);
                    }
                }
                i++;
            }

        </script>

        <?php
        //Carregamento javascript datatables JS
        if (isset($datagrid_js)) {
            echo $datagrid_js;
        }
        ?>
   </body>

</html>