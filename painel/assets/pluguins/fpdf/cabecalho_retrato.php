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
        $this-> Cell(198,5,iconv('utf-8','iso-8859-1',$c_titulo_1),0,0,C);
		$this-> Ln(6);
		$this-> Cell(198,5,iconv('utf-8','iso-8859-1',$c_titulo_2),0,0,C);
		$this-> Ln(6);
		$this-> Cell(198,5,iconv('utf-8','iso-8859-1',$c_titulo_3),0,0,C);
		$this-> Ln(6);
		$this-> Cell(198,5,iconv('utf-8','iso-8859-1',$c_titulo_4),0,0,C);
		$this-> Ln(8);
		//endereco da imagem,posicao X(horizontal),posicao Y(vertical), tamanho altura, tamanho largura
	    $this->Image('../imagens/logo_pmv.jpg',10,6,22);
		
		$this-> Cell(198,3,"",0,0,C);
		$this-> Ln(3);
	    $this->Image('../imagens/logo_semas.jpg',180,6,20);   

     }

     function Footer()
     {
          // Definimos a fonte
		
          $this->SetFont('Arial','',10);
		
          // Posicionamos o texto a 9.5 cm da margem 
          // esquerda e a 4 cm da base
		
          $this->SetXY(100,-20);
			
          // Escrevemos afinal com link
		
         $this->Cell(4,1.5,'PMV - Prefeitura Municipal de Vitória - Av. Marechal de Moraes, 1927 - Bento Ferreira, Vitória / ES - Telefone: (27)3382-6000',0,0,'C','','');
		  

     }


  function MultiCellBullet($w, $h, $txt, $border=0, $align='J', $fill=0, $indent=0)
{
    //Output text with automatic or explicit line breaks
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;

    $wFirst = $w;
    $wOther = $w;
	$txt = '
				   '.chr(149).'  '.$txt;
    $wmaxFirst=($wFirst-2*$this->cMargin)*1000/$this->FontSize;
    $wmaxOther=($wOther-2*$this->cMargin)*1000/$this->FontSize;

    $s=str_replace("&&", '
				   '.chr(149).'  ', $txt);
	$s=str_replace("$$", '
				             '.chr(149).'  ', $s);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $b=0;
    if($border)
    {
        if($border==1)
        {
            $border='LTRB';
            $b='LRT';
            $b2='LR';
        }
        else
        {
            $b2='';
            if(is_int(strpos($border, 'L')))
                $b2.='L';
            if(is_int(strpos($border, 'R')))
                $b2.='R';
            $b=is_int(strpos($border, 'T')) ? $b2.'T' : $b2;
        }
    }
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $ns=0;
    $nl=1;
        $first=true;
    while($i<$nb)
    {
        //Get next character
        $c=$s[$i];
        if($c=="\n")
        {
            //Explicit line break
            if($this->ws>0)
            {
                $this->ws=0;
                $this->_out('0 Tw');
            }
            $this->Cell($w, $h, substr($s, $j, $i-$j), $b, 2, $align, $fill);
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $ns=0;
            $nl++;
            if($border and $nl==2)
                $b=$b2;
            continue;
        }
        if($c==' ')
        {
            $sep=$i;
            $ls=$l;
            $ns++;
        }
        $l+=$cw[$c];

        if ($first)
        {
            $wmax = $wmaxFirst;
            $w = $wFirst;
        }
        else
        {
            $wmax = $wmaxOther;
            $w = $wOther;
        }

        if($l>$wmax)
        {
            //Automatic line break
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
                if($this->ws>0)
                {
                    $this->ws=0;
                    $this->_out('0 Tw');
                }
                $SaveX = $this->x; 
                if ($first and $indent >0)
                {
                    $this->SetX($this->x);
                    $first=false;
                }
                $this->Cell($w, $h, substr($s, $j, $i-$j), $b, 2, $align, $fill);
                    $this->SetX($SaveX);
            }
            else
            {
                if($align=='J')
                {
                    $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                    $this->_out(sprintf('%.3f Tw', $this->ws*$this->k));
                }
                $SaveX = $this->x; 
                if ($first and $indent >0)
                {
                    $this->SetX($this->x );
                    $first=false;
                }
                $this->Cell($w, $h, substr($s, $j, $sep-$j), $b, 2, $align, $fill);
                    $this->SetX($SaveX);
                $i=$sep+1;
            }
            $sep=-1;
            $j=$i;
            $l=0;
            $ns=0;
            $nl++;
            if($border and $nl==2)
                $b=$b2;
        }
        else
            $i++;
    }
    //Last chunk
    if($this->ws>0)
    {
        $this->ws=0;
        $this->_out('0 Tw');
    }
    if($border and is_int(strpos($border, 'B')))
        $b.='B';
    $this->Cell($w, $h, substr($s, $j, $i), $b, 2, $align, $fill);
    $this->x=$this->lMargin;
    }




}

 
?>