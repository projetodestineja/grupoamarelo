function valida_senha() {
    var password = document.getElementById("senha1"), confirm_password = document.getElementById("senha2");
    if (password.value != confirm_password.value) {
        alert("As senhas não conferem. Por favor, digite novamente.");
        confirm_password.value = "";
        confirm_password.focus();
    }
}
;

//valida o CNPJ digitado
function valida_cnpj(ObjCnpj) {
    var cnpj = ObjCnpj.value;
    var valida = new Array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
    var dig1 = new Number;
    var dig2 = new Number;

    exp = /\.|\-|\//g
    cnpj = cnpj.toString().replace(exp, "");
    var digito = new Number(eval(cnpj.charAt(12) + cnpj.charAt(13)));

    for (i = 0; i < valida.length; i++) {
        dig1 += (i > 0 ? (cnpj.charAt(i - 1) * valida[i]) : 0);
        dig2 += cnpj.charAt(i) * valida[i];
    }
    dig1 = (((dig1 % 11) < 2) ? 0 : (11 - (dig1 % 11)));
    dig2 = (((dig2 % 11) < 2) ? 0 : (11 - (dig2 % 11)));

    if (((dig1 * 10) + dig2) != digito) {
        alert('CNPJ inválido. Por favor, digite novamente.');
        ObjCnpj.value = "";
        ObjCnpj.focus();
    }
}

//valida o CPF digitado
function valida_cpf(Objcpf) {
    var cpf = Objcpf.value;
    exp = /\.|\-/g
    cpf = cpf.toString().replace(exp, "");
    var digitoDigitado = eval(cpf.charAt(9) + cpf.charAt(10));
    var soma1 = 0, soma2 = 0;
    var vlr = 11;

    for (i = 0; i < 9; i++) {
        soma1 += eval(cpf.charAt(i) * (vlr - 1));
        soma2 += eval(cpf.charAt(i) * vlr);
        vlr--;
    }
    soma1 = (((soma1 * 10) % 11) == 10 ? 0 : ((soma1 * 10) % 11));
    soma2 = (((soma2 + (2 * soma1)) * 10) % 11);

    var digitoGerado = (soma1 * 10) + soma2;
    if (digitoGerado != digitoDigitado) {
        alert('CPF inválido. Por favor, digite novamente.');
        Objcpf.value = "";
        Objcpf.focus();
    } else if (cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999") {
        alert('CPF inválido. Por favor, digite novamente.');
        Objcpf.value = "";
        Objcpf.focus();
    }

}


/************ Mascara CPF e CNPJ mesmo input ****************
Coloque apenas isso no input:
onkeypress="mascaraMutuario(this,cpfCnpj)" maxlength="18" onblur="clearTimeout()" 
***************************************************************/
function mascaraMutuario(o, f) {
   v_obj = o
   v_fun = f
   setTimeout('execmascara()', 1)
}
function execmascara() {
   v_obj.value = v_fun(v_obj.value)
}
function cpfCnpj(v) {
  //Remove tudo o que não é dígito
  v = v.replace(/\D/g, "")
  if (v.length <= 13) { //CPF
    //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2")
    //Coloca um ponto entre o terceiro e o quarto dígitos
    //de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d)/, "$1.$2")
    //Coloca um hífen entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
  } else { //CNPJ
    //Coloca ponto entre o segundo e o terceiro dígitos
    v = v.replace(/^(\d{2})(\d)/, "$1.$2")
    //Coloca ponto entre o quinto e o sexto dígitos
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
    //Coloca uma barra entre o oitavo e o nono dígitos
    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2")
    //Coloca um hífen depois do bloco de quatro dígitos
    v = v.replace(/(\d{4})(\d)/, "$1-$2")
  }
  return v
}
/********************Fim mascara CPF e CNPJ**************/		
		
		
//MÁSCARAS JQUERY MASK

//PARA TEL-CEL
var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
 spOptions = {
    onKeyPress: function (val, e, field, options) {
    field.mask(SPMaskBehavior.apply({}, arguments), options);
}
};

$(document).ready(function () {
	
	$( "select[name=area_atuacao]").change(function() {
		(this.value == 0?$( "#outra_area_option" ).show():$( "#outra_area_option" ).hide());
	});
	
    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone').mask(SPMaskBehavior, spOptions);
    $('.mixed').mask('AAA 000-S0S');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
	
	$('a#messagesDropdown').on('click', function () {
       load_mensages();
	});
				
});


function load_mensages(){
	
	var html = '';
					
	$.getJSON('mensagens/novas_mensagens', function (data) {
		var rows = data.length;
		if(rows>0){
			$('#info_msg_top').show();
			$('.cont_msg').html(rows);
			for (var i = 0; i < rows; i++) {
				html+='<div class="dropdown-divider"></div>';
				html+='<a class="dropdown-item" href="'+data[i].href+'" >';
				html+='	<strong>'+data[i].assunto+'</strong>';
				html+='	<span class="small float-right text-muted">11:21h</span>';
				html+='	<div class="dropdown-message small">'+data[i].msg+'</div>';
				html+='</a>';
			}
		}
		$('#msg_top_load').html(html);
	});
}