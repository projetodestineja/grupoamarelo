<?php


$this->fpdf->AddPage();
$this->fpdf->SetFont('Arial','B',14);

$titulo = 'Relatório de Propostas Recebidas Para Coleta de Resíduo';

$this->fpdf->Image(site_url('painel/assets/img/destinejalogo.png') , 160 ,10, 35 , 10,'PNG');
$this->fpdf->Cell(186,10,$titulo,0,0,'l');

$this->fpdf->Ln(15);
$this->fpdf->SetFont('Arial','b',12);
$this->fpdf->Cell(30,8,'Demanda',0,0,'L');
$this->fpdf->Ln(8);

$this->fpdf->SetFont('Arial','',10);
$this->fpdf->Cell(20,8,'Resíduo:',0,0,'L');
$this->fpdf->Cell(110,8,'aaa',0,0,'L');
$this->fpdf->Cell(23,8,'Quantidade:',0,0,'L');
$this->fpdf->Cell(30,8,'a',0,0,'L');
$this->fpdf->Ln(8);

$this->fpdf->Cell(22,8,'Data Início: ',0,0,'L');
$this->fpdf->Cell(30,8,'a',0,0,'L');
$this->fpdf->Cell(28,8,'Data Expiração: ',0,0,'L');
$this->fpdf->Cell(30,8,'a',0,0,'L');
$this->fpdf->Ln(8);
$this->fpdf->Cell(30,8,'Observação: ',0,0,'L');
$this->fpdf->MultiCell(156,5,'  ',0,'L');


$this->fpdf->Ln(10);
$this->fpdf->SetFont('Arial','b',12);
$this->fpdf->Cell(30,8,'Propostas',0,0,'L');
$this->fpdf->Ln(8);




$this->fpdf->Output();
            
?>