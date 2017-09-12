function valida_senha(){
	var password = document.getElementById("senha1") , confirm_password = document.getElementById("senha2");
	if(password.value != confirm_password.value) {
		alert("As senhas não conferem. Por favor, digite novamente.");
		confirm_password.value = "";
		confirm_password.focus();
	}
};

//valida o CNPJ digitado
function valida_cnpj(ObjCnpj){
	var cnpj = ObjCnpj.value;
	var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
	var dig1= new Number;
	var dig2= new Number;

	exp = /\.|\-|\//g
	cnpj = cnpj.toString().replace( exp, "" ); 
	var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));

	for(i = 0; i<valida.length; i++){
		dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);  
		dig2 += cnpj.charAt(i)*valida[i];       
	}
	dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
	dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));

	if(((dig1*10)+dig2) != digito)  
		alert('CNPJ inválido. Por favor, digite novamente.');
		ObjCnpj.value = "";
		ObjCnpj.focus();
}

//valida o CPF digitado
function valida_cpf(Objcpf){
	var cpf = Objcpf.value;
	exp = /\.|\-/g
	cpf = cpf.toString().replace( exp, "" ); 
	var digitoDigitado = eval(cpf.charAt(9)+cpf.charAt(10));
	var soma1=0, soma2=0;
	var vlr =11;

	for(i=0;i<9;i++){
		soma1+=eval(cpf.charAt(i)*(vlr-1));
		soma2+=eval(cpf.charAt(i)*vlr);
		vlr--;
	}       
	soma1 = (((soma1*10)%11)==10 ? 0:((soma1*10)%11));
	soma2=(((soma2+(2*soma1))*10)%11);

	var digitoGerado=(soma1*10)+soma2;
	if(digitoGerado!=digitoDigitado){   
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
        cpf == "99999999999"){
		alert('CPF inválido. Por favor, digite novamente.');
		Objcpf.value = "";	
		Objcpf.focus();	
	}

}


//MÁSCARAS JQUERY MASK

//PARA TEL-CEL
var SPMaskBehavior = function (val) {
	return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
spOptions = {
	onKeyPress: function(val, e, field, options) {
		field.mask(SPMaskBehavior.apply({}, arguments), options);
	}
};

$(document).ready(function(){
	$('.date').mask('11/11/1111');
	$('.time').mask('00:00:00');
	$('.date_time').mask('00/00/0000 00:00:00');
	$('.cep').mask('00000-000');
	$('.phone').mask(SPMaskBehavior, spOptions);
	$('.mixed').mask('AAA 000-S0S');
	$('.cpf').mask('000.000.000-00', {reverse: true});
	$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
	$('.money').mask('000.000.000.000.000,00', {reverse: true});
});