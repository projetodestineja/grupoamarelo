function pesquisacnpj(valor) {
    
    var valor = valor.replace(/\D/g, '');

    if (valor.length > 0)
    {
        $( "#div_pesquisa_cnpj" ).text('Pesquisando CNPJ...');
        $( "#div_pesquisa_cnpj" ).show();
        //Preenche os campos com "..." enquanto consulta webservice.
        document.getElementById('rsocial').value = "...";
        document.getElementById('nfantasia').value = "...";
        document.getElementById('cidade').value = "...";
        document.getElementById('estado').value = "...";
        document.getElementById('bairro').value = "...";
        document.getElementById('email').value = "...";
        document.getElementById('tel1').value = "...";
        document.getElementById('cep').value = "...";
        document.getElementById('rua').value = "...";
        document.getElementById('numero').value = "...";
        document.getElementById('complemento').value = "...";
        //Cria um elemento javascript.
        var script = document.createElement('script');

        script.src = 'https://www.receitaws.com.br/v1/cnpj/' + valor + '/?callback=preenche_dados_cnpj';
        document.body.appendChild(script);
 
    }
}


function preenche_dados_cnpj(conteudo) {

    if ((conteudo.status) == 'OK') {

        document.getElementById('rsocial').value = (conteudo.nome);
        document.getElementById('nfantasia').value = (conteudo.fantasia);
        document.getElementById('cidade').value = (conteudo.municipio);
        document.getElementById('estado').value = (conteudo.uf);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('email').value = (conteudo.email);
        document.getElementById('tel1').value = (conteudo.telefone);
        document.getElementById('cep').value = (conteudo.cep);
        document.getElementById('rua').value = (conteudo.logradouro);
        document.getElementById('numero').value = (conteudo.numero);
        document.getElementById('complemento').value = (conteudo.complemento);
        $("#nresponsavel").focus();
        $( "#div_pesquisa_cnpj" ).hide();
    }
    else{
        document.getElementById('rsocial').value = "";
        document.getElementById('nfantasia').value = "";
        document.getElementById('cidade').value = "";
        document.getElementById('estado').value = "";
        document.getElementById('bairro').value = "";
        document.getElementById('email').value = "";
        document.getElementById('tel1').value = "";
        document.getElementById('cep').value = "";
        document.getElementById('rua').value = "";
        document.getElementById('numero').value = "";
        document.getElementById('complemento').value = "";
        $( "#div_pesquisa_cnpj" ).text('CNPJ não encontrado, digite os dados da empresa');
    }

   

}