<?php  if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * DataGrid CodeIgniter implementation
 *
 *
 * @category  CodeIgniter
 * @package   DataGrid CI
 * @author    Onério de Sousa Oliveira (onerio@tribo.ppg.br)
 * @version   0.3
 * Copyright (c) 2017 Onério Sousa  (http://flexigrid.eyeviewdesign.com)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
*/
if (! function_exists('datagrid_js'))
{
    
    function datagrid_js($config)
    {
        //Basic propreties
        $grid_js = '<script type="text/javascript">$(document).ready(function(){';
		 
		$grid_js.= 'var altura_navegador = $(window).height(); ';
		$grid_js.= 'var table_id;';	
		$grid_js.= 'var rows_selected = [];';
		
		//$grid_js.= ' if(altura_navegador<700){ altura_navegador = 700; }';
		//$grid_js.= 'alert(altura_navegador);';
		
		$grid_js.= 'table = $("#'.$config['grid_id'].'").DataTable({ ';
		$grid_js.= '"processing": true,';
		$grid_js.= '"serverSide": true,';
		$grid_js.= '"bStateSave":true,';
		
		/*"sPaginationType": "full_numbers",*/
		$grid_js.= '"order": [],';
		$grid_js.= '"language": {';
		$grid_js.= '  "url": "'.base_url('assets/pluguins/datatables/Portuguese-Brasil.json').'"';
		$grid_js.= '},';
		$grid_js.= '"columns": [';
		
		$total_coluna = count($config['columns']);
		$cont = 1;
		foreach($config['columns'] as $name_col){	
			if($name_col['col_width']!=NULL){
				$grid_js.='{"width": "'.$name_col['col_width'].'px"}';
			}else{
				$grid_js.='null';
			}
			if($cont<$total_coluna){
				$grid_js.= ',';
			}
			$cont++;
		}
		$grid_js.= '],';
		$grid_js.= '"lengthMenu": [[16, 25, 50, 100, 200, -1], [16, 25, 50, 100, 200, "Tudo"]],';
		//$grid_js.= '"scrollY": (altura_navegador-340)+"px",';
		$grid_js.= '	"ajax": {';
		$grid_js.= '	"url": "'.$config['load_ajax'].'",';
		$grid_js.= '	"type": "POST"';
		$grid_js.= '},';
		$grid_js.= '"rowCallback": function(row, data, dataIndex){';
		 			// Get row ID
		$grid_js.= 'var rowId = data[0];';
						
					// If row ID is in the list of selected row IDs
		$grid_js.= 'if($.inArray(rowId, rows_selected) !== -1){';
		$grid_js.= '$(row).find(\'input[type="checkbox"]\').prop(\'checked\', true);';
		$grid_js.= '	$(row).addClass(\'selected\');';
		$grid_js.= '}';
		 	
		$grid_js.= '},';
		$grid_js.= '"columnDefs": [{ ';
		$grid_js.= ' "targets": [';
		$cont = 0;
		foreach($config['columns'] as $name_col){	
			if($name_col['col_order']==false){
				$grid_js.=$cont;
				$grid_js.= ',';
			}
			
			$cont++;
		}
		$grid_js.= '], ';
		$grid_js.= ' "orderable": false,'; 
		$grid_js.= '},],';
		$grid_js.= '});';
		
		/**************************************************************** 
							FUNÇÂO REMOVER REGISTRO
		/****************************************************************/
		$grid_js.='$("#deletar_row_table").click(function(e) {';
		
		$grid_js.='	var form = "#'.$config['grid_id'].'";';
		$grid_js.='	var id_delete = "";';
		
		$grid_js.='	var confirme_delete = ""; ';
		$grid_js.='	var cont = 0;';
		
		$grid_js.='table.$("input[type=\'checkbox\']").each(function(){';
        $grid_js.='if(this.checked==true){';
        $grid_js.='   id_delete+=$(this).val()+\',\';';
        $grid_js.='   confirme_delete+=" - "+$(this).attr("rel")+" \n"; ';
        $grid_js.='   cont++;';
        $grid_js.='};';
        $grid_js.='});';
		 		  
		$grid_js.='if(confirme_delete!=""){';
		$grid_js.='	if (confirm("Confirma a Remoção de "+cont+" Registro(s):\n"+confirme_delete) == true) {';
		$grid_js.='	  $.ajax({';
		$grid_js.='		type: "POST",';
		$grid_js.='		url: "'.$config['delete_ajax'].'",';
		$grid_js.='		data: "ids_delete="+id_delete,';
		$grid_js.='		success: function(data){';
		$grid_js.='		  reload_table();';
		$grid_js.='		}';
		$grid_js.='	 });';
		$grid_js.=' }';
		$grid_js.='}else{';
		$grid_js.='	 alert("Selecione o item que deseja remover");';
		$grid_js.='	}';
		$grid_js.='return false;';
		
		$grid_js.='	});';	
			
		$grid_js.='});';
		
		//close
        $grid_js.='</script>';
		
        return $grid_js;
    }
}
?>