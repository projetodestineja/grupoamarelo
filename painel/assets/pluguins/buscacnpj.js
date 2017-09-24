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
        $area_atuacao = conteudo.atividade_principal[0].code;
        $area_atuacao = $area_atuacao.replace(/\D/g, '');
        //Atualiza os campos com os valores.
        document.getElementById('rsocial').value = (conteudo.nome);
        document.getElementById('nfantasia').value = (conteudo.fantasia);
        document.getElementById('area_atuacao').value = ($area_atuacao);
        document.getElementById('tel1').value = (conteudo.telefone);
        document.getElementById('email').value = (conteudo.email);
        document.getElementById('cep').value = (conteudo.cep);
        document.getElementById('rua').value = (conteudo.logradouro);
        document.getElementById('numero').value = (conteudo.numero);
        document.getElementById('complemento').value = (conteudo.complemento);
        document.getElementById('estado').value = (conteudo.uf);
        document.getElementById('bairro').value = (conteudo.bairro);
        
        load_cidades(conteudo.uf, conteudo.municipio);
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

            //leva o cursor para o campo responsavel
            $("#nresponsavel").focus();

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

