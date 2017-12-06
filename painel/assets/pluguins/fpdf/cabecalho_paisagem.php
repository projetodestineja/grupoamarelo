<?php

require('fpdf.php');

class PDF extends FPDF
{
     function Header()
     {
		global $c_titulo_1;
		global $c_titulo_2;
		global $c_titulo_3;
		global $c_titulo_4;
		$this-> SetFont('arial','','10');
        $this-> Cell(286,5,iconv('utf-8','iso-8859-1',$c_titulo_1),0,0,C);
		$this-> Ln(6);
		$this-> Cell(286,5,iconv('utf-8','iso-8859-1',$c_titulo_2),0,0,C);
		$this-> Ln(6);
		$this-> Cell(286,5,iconv('utf-8','iso-8859-1',$c_titulo_3),0,0,C);
		$this-> Ln(6);
		$this-> Cell(286,5,iconv('utf-8','iso-8859-1',$c_titulo_4),0,0,C);
		$this-> Ln(6);
		//endereco da imagem,posicao X(horizontal),posicao Y(vertical), tamanho altura, tamanho largura
	    $this->Image('../imagens/logo_pmv.jpg',10,6,22);
	
	    $this->Image('../imagens/logo_semas.jpg',265,6,20);   
		

     }

     function Footer()
     {
          // Definimos a fonte
		
          $this->SetFont('Arial','',9);
		
          // Posicionamos o texto a 9.5 cm da margem 
          // esquerda e a 4 cm da base
		
          $this->SetXY(147,-10);
			
          // Escrevemos afinal com link
		
          $this->Cell(4,1.5,"PMV - Prefeitura Municipal de Vitуria - Av. Marechal de Moraes, 1927 - Bento Ferreira, Vitуria / ES - Telefone: (27)3382-6000. Data da geraзгo:".date('d/m/Y'),0,0,'C','','');
		
		
  
     }
}



?>