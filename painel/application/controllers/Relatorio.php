<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller {
	
    function __construct() {
        parent::__construct();

        $this->login_model->restrito();

        $this->load->model(array('empresa_model', 'endereco_model'));
        $this->load->library(array('form_validation', 'util'));
        $this->_init();
    }

    private function _init() {
		
		/****** Pluguin Calendário Input **************/
        $this->load->css('assets/pluguins/datepicker/css/bootstrap-datepicker.min.css');
        $this->load->js('assets/pluguins/datepicker/js/bootstrap-datepicker.min.js');
        $this->load->js('assets/pluguins/datepicker/locales/bootstrap-datepicker.pt-BR.min.js');
		
        $this->output->set_template('default');
				
    }
	
	/**
	*	Index Relatorio
	*/
    public function index() {
		
		$title = 'Relatório ';
        $this->output->set_common_meta($title, '', ''); //Title / Description / Tags
        $data['menu_mapa'] = array(
            $title => ''
        );
		
        $this->load->view('relatorio/index', $data);
    }
	
	
	/**
	*	Exportar empresas
	*/
	public function empresas(){
		
		$this->output->unset_template();
	   
	  	require_once '../system/third_party/Phpexcel/Bootstrap.php';
		
		// Create new Spreadsheet object
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		
		// Set document properties
		$spreadsheet->getProperties()->setCreator($this->config->item('title'))
			->setLastModifiedBy($this->config->item('title'))
			->setTitle('Empresas '.$this->config->item('title'))
			->setSubject('Empresas '.$this->config->item('title'))
			->setDescription('Empresas')
			->setKeywords('Empresas')
			->setCategory('Empresas');
		
		$spreadsheet->getDefaultStyle()->getFont()->setName('Verdana')->setSize(10);
		
		/*TOPO*/
		$spreadsheet->getActiveSheet()->getStyle("A1:R1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('007744');
		$spreadsheet->getActiveSheet()->getStyle("A1:R1")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(28);
		
		//TAB
		$spreadsheet->setActiveSheetIndex(0)->setTitle("EMPRESAS");
		
		$spreadsheet->getActiveSheet()
			->setCellValue("A1", 'DATA DE CADASTRO')
			->setCellValue('B1', 'HABILITADO')
			->setCellValue('C1', 'PERFIL')
			->setCellValue('D1', 'TIPO DE CADASTRO')
			//EMPRESA
			->setCellValue('E1', 'CNPJ / CPF')
			->setCellValue('F1', 'RAZÃO SOCIAL')
			->setCellValue('G1', 'NOME FANTASIA')
			->setCellValue('H1', 'NOME RESPONSÁVEL')
			//CONTATO
			->setCellValue('I1', 'TELEFONE 1')
			->setCellValue('J1', 'TELEFONE 2')
			->setCellValue('K1', 'E-MAIL')
			//ENDEREÇO
			->setCellValue('L1', 'CEP')
			->setCellValue('M1', 'LOGRADOURO')
			->setCellValue('N1', 'NUMERO')			
			->setCellValue('O1', 'COMPLEMENTO')
			->setCellValue('P1', 'BAIRRO')
			->setCellValue('Q1', 'CIDADE')
			->setCellValue('R1', 'UF');
		
		$filter = array();
		$post = $this->input->post();
        $dataArray = $this->empresa_model->get_relatorio_empresas($post);
		
		//$spreadsheet->getActiveSheet()->fromArray($dataArray, null, 'A2');
		$x = 2;
		foreach($dataArray as $n){
			 $spreadsheet->setActiveSheetIndex(0)
			 	->setCellValue("A$x", date('d/m/Y',strtotime($n['data_cadastro'])))
			    ->setCellValue("B$x", ($n['ativo']==0?'NÂO':'SIM'))
				->setCellValue("C$x", $n['perfil'])
				->setCellValue("D$x", ($n['tipo_cadastro']=='J'?'Pessoa Jurídica':'Pessoa Física'))
				//EMPRESA
			    ->setCellValue("E$x", (!empty($n['cnpj'])?$n['cnpj']:$n['cpf']))
				->setCellValue("F$x", $n['razao_social'])
				->setCellValue("G$x", $n['nome_fantasia'])
				->setCellValue("H$x", $n['nome_responsavel'])
				//CONTATO
				->setCellValue("I$x", $n['telefone1'])
				->setCellValue("J$x", $n['telefone2'])
				->setCellValue("K$x", $n['email'])
				//ENDEREÇO
				->setCellValue("L$x", $n['cep'])
				->setCellValue("M$x", $n['logradouro'])
				->setCellValue("N$x", $n['numero'])
				->setCellValue("O$x", $n['complemento'])
				->setCellValue("P$x", $n['bairro'])
				->setCellValue("Q$x", $n['cidade'])
				->setCellValue("R$x", $n['uf_estado']);
			
			   // cor ROW
			   if($n['id_funcao']==1){
			   		$spreadsheet->getActiveSheet()->getStyle("A$x:R$x")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FCD8BC');
			   }else{ 
			   		$spreadsheet->getActiveSheet()->getStyle("A$x:R$x")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('E1FFF2');
			   }
			  
			   //Altura linha
			   $spreadsheet->getActiveSheet()->getRowDimension($x)->setRowHeight(19);
			  
		   $x++;
		}
		
		//Centraliza texto
		$spreadsheet->getActiveSheet()->getStyle('A2:C'.$x)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		
		//centraliza texto para vertical
		$spreadsheet->getActiveSheet()->getStyle('A1:R'.$x)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		
		// Ajuste coluna
		foreach(range('A','R') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		
		//bold 1º LINHA
		$spreadsheet->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
		
		// Borda Celula
		$spreadsheet->getActiveSheet()->getStyle('A1:R'.($x-1))->applyFromArray(
			array(
			 'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHDOT,
			 'color' => array(
				'rgb' => '808080'
			 ),
			 'borders' => array(
				'allborders' => array(
					'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => array('rgb' => '000000')
			  )))
      	);
		
		// Coloca Filtro
		$spreadsheet->getActiveSheet()->setAutoFilter($spreadsheet->getActiveSheet()->calculateWorksheetDimension());
		
		if(!empty($post['data_inicio']) || !empty($post['data_final'])){
			$periodo = ' - '.str_replace('/','-',$post['data_inicio']).' - '.str_replace('/','-',$post['data_final']);
		}else{
			$periodo = '';	
		}
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Empresas - '.$this->config->item('title').' - Total '.count($dataArray).' - '.date('d-m-Y').''.$periodo.'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Excel2007');
		$writer->save('php://output');
		exit;
	
	}
	

}
