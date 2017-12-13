<?php


$this->fpdf->AddPage();
$this->fpdf->SetFont('Arial','B',14);

$titulo = 'Relatório de Propostas Recebidas Para Coleta de Resíduo';

$this->fpdf->Image(site_url('painel/assets/img/destinejalogo.png') , 12 ,10, 35 , 10,'PNG');
$this->fpdf->Cell(186,10,$titulo,0,0,'R');

$this->fpdf->Ln(15);
$this->fpdf->SetFont('Arial','b',12);
$this->fpdf->Cell(30,8,'Demanda',0,0,'L');
$this->fpdf->Ln(8);

$this->fpdf->SetFont('Arial','',10);
$this->fpdf->Cell(17,8,'Resíduo:',0,0,'L');
$this->fpdf->Cell(108,8,$row['residuo'],0,0,'L');
$this->fpdf->Cell(21,8,'Quantidade:',0,0,'L');
$this->fpdf->Cell(35,8,$row['qtd'].' '.$row['uni_medida_nome'],0,0,'L');
$this->fpdf->Ln(8);

$this->fpdf->Cell(20,8,'Data Início: ',0,0,'L');
$this->fpdf->Cell(30,8,$row['data_inicio'],0,0,'L');
$this->fpdf->Cell(27,8,'Data Expiração: ',0,0,'L');
$this->fpdf->Cell(30,8,$row['data_validade'],0,0,'L');
$this->fpdf->Cell(30,8,'Acondicionamento: ',0,0,'L');
$this->fpdf->Cell(40,8,$row['acondicionado'],0,0,'L');
$this->fpdf->Ln(8);
$this->fpdf->Cell(30,8,'Observação: ',0,0,'L');
$this->fpdf->MultiCell(156,8,$row['obs'],0,'L');


$this->fpdf->Ln(10);
$this->fpdf->SetFont('Arial','b',12);
$this->fpdf->Cell(30,8,'Propostas',0,0,'L');
$this->fpdf->Ln(12);



if (!empty($propostas)) {   
            
    foreach($propostas as $pr){
        if ($pr->cobranca == 0) $cobranca =  "pagar pelo resíduo" ; else $cobranca = "cobrar pelo resíduo";
        $this->fpdf->SetFont('Arial','b',10);
        $this->fpdf->Cell(70,6,'Proposta Código #'.$pr->id,0,0,'L');
        $this->fpdf->Cell(115,6,'Proposta aceita: '.$pr->aceita,0,0,'R');
        $this->fpdf->Ln(6);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(105,6,'O coletor deseja '.$cobranca,0,0,'L');
        $this->fpdf->Cell(80,6,'Validade da proposta: '.date('d/m/Y', strtotime(str_replace("/","-",$pr->validade_proposta))),0,0,'R');
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(87,6,'Valor por unidade de medida do resíduo: R$ '.number_format($pr->valor, 2, ',', '.'),0,0,'L');
        $this->fpdf->Cell(58,6,'Frete Por Viagem: R$ '.number_format($pr->frete, 2, ',', '.'),0,0,'L');
        $this->fpdf->Cell(40,6,'Quantidade de Viagens: '.$pr->qtde_viagens,0,0,'R');
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(145,6,'Prazo para coleta: '.$pr->prazo_coleta.' dias úteis após a aceitação da proposta.',0,0,'L');
        $this->fpdf->SetFont('Arial','b',10);
        $this->fpdf->Cell(40,6,'Valor total aproximado: R$ '.number_format($pr->total, 2, ',', '.'),0,0,'R');
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(45,6,'Condições de pagamento: ',0,0,'L');
        $this->fpdf->MultiCell(140,6,$pr->condicoes_pagamento,0,'L');
        
        $this->fpdf->Cell(25,6,'Observação: ',0,0,'L');
        $this->fpdf->MultiCell(160,6,$pr->observacoes,0,'L');
        $this->fpdf->Ln(12);
    }   
            
} else $this->fpdf->Cell(30,8,'Não existem propostas cadastradas. ',0,0,'L');


$this->fpdf->Output();
            
?>