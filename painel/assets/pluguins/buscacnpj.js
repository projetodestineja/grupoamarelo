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
        if (conteudo.atividades_secundarias[i].code.length>0){
            var divPai = $("#divatividadesecundaria");
            divPai.append("<div class='form-group col-md-12' >");
            divPai.append("<label for=\"area_atuacao_secundaria"+i+"\">Atividade Secundária "+(i+1)+"</label>");
            divPai.append("<select class=\"form-control\" id=\"area_atuacao_secundaria"+i+"\" name=\"area_atuacao_secundaria"+i+"\">");
            divPai.append("</select>");
            divPai.append("</div>");
            
            cod_atuacao = conteudo.atividades_secundarias[i].code;
            txt_atuacao = conteudo.atividades_secundarias[i].text;
            cod_atuacao = cod_atuacao.replace(/\D/g, '');
           
            var option = new Option(txt_atuacao, cod_atuacao);
            var select = document.getElementById("area_atuacao_secundaria"+i);
            select.add(option);
           
            document.getElementById("area_atuacao_secundaria"+i).value = (cod_atuacao);
            document.getElementById("area_atuacao_secundaria"+i).text = (txt_atuacao);
        }
        }
        //Atualiza os campos com os valores.
        document.getElementById('rsocial').value = (conteudo.nome);
        document.getElementById('nfantasia').value = (conteudo.fantasia);
        document.getElementById('area_atuacao').value = (area_atuacao);
        
        var e = document.getElementById("area_atuacao");
        var itemSelecionado = e.options[e.selectedIndex].value;
        
        if(itemSelecionado>0){
            $( "#outra_area_option" ).hide();
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

