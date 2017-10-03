<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class CI_Util {


	 function validaCpf($cpf=null) {
 
		// Verifica se um n�mero foi informado
		if(empty($cpf)) {
			return false;
		}
	 
		// Elimina possivel mascara
		$cpf = preg_replace("/[^0-9]/", "",$cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		 
		// Verifica se o numero de digitos informados � igual a 11 
		if (strlen($cpf) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequ�ncias invalidas abaixo 
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' || 
			$cpf == '11111111111' || 
			$cpf == '22222222222' || 
			$cpf == '33333333333' || 
			$cpf == '44444444444' || 
			$cpf == '55555555555' || 
			$cpf == '66666666666' || 
			$cpf == '77777777777' || 
			$cpf == '88888888888' || 
			$cpf == '99999999999') {
			return false;
		 // Calcula os digitos verificadores para verificar se o
		 // CPF � v�lido
		 } else {   
			 
			for ($t = 9; $t < 11; $t++) {
				 
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}
	 
			return true;
		}
	}


	function ValidaData($dat){
		$data = explode("/",$dat); // fatia a string $dat em pedados, usando / como refer�ncia
		$d = $data[0];
		$m = $data[1];
		$y = $data[2];
		// verifica se a data � v�lida!
		// 1 = true (v�lida)
		// 0 = false (inv�lida)
		return checkdate($m,$d,$y);
	}
	
	
	function ValidarCnpj($cnpj_user){
		$cnpj = preg_replace('/[^0-9]/', '', (string)$cnpj_user);
		// Valida tamanho
		if (strlen($cnpj) != 14){
			return false;
                }       
		// Valida primeiro d�gito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
		{
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = ($soma % 11);
		if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
			return false;
		// Valida segundo d�gito verificador
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
		{
			$soma += $cnpj{$i} * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
	}

        function SenhaEncode($string) {
                $key_chave = "44s5f4s54fsf6666644df4sf4s4fd5s4f"; // Se apagar MORRE, chave de codificar e decodificar senha
                $key = sha1($key_chave);
                $strLen = strlen($string);
                $keyLen = strlen($key);
                $j = 0;
                $hash = '';
                for ($i = 0; $i < $strLen; $i++) {
                    $ordStr = ord(substr($string,$i,1));
                    if ($j == $keyLen) { $j = 0; }
                    $ordKey = ord(substr($key,$j,1));
                    $j++;
                    $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
                }
                return $hash;
        }

        function SenhaDecode($string) {
                $key_chave="44s5f4s54fsf6666644df4sf4s4fd5s4f"; // Se apagar MORRE, chave de codificar e decodificar senha
                $key = sha1($key_chave);
                $strLen = strlen($string);
                $keyLen = strlen($key);
                $j = 0;
                $hash = '';
                for ($i = 0; $i < $strLen; $i+=2) {
                    $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
                    if ($j == $keyLen) { $j = 0; }
                    $ordKey = ord(substr($key,$j,1));
                    $j++;
                    $hash .= chr($ordStr - $ordKey);
                }
                return $hash;
        }










	
}
	
?>