


/* reload datatable ajax */
function reload_table(){
	
    table.ajax.reload(null,false); 
     $('thead input[name="select_all"]').prop('checked',false);
}
 

//
// Updates "Select all" control in a data table
//
function updateDataTableSelectAllCtrl(table){
    
   var $table             = table.table().node();
   var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
   var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
   var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

   // If none of the checkboxes are checked
   if($chkbox_checked.length === 0){
      chkbox_select_all.checked = false;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If all of the checkboxes are checked
   } else if ($chkbox_checked.length === $chkbox_all.length){
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If some of the checkboxes are checked
   } else {
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = true;
      }
   }
}

$(document).ready(function() {
    
    var rows_selected = [];
   
    // Handle click on checkbox
   $('#table tbody').on('click', 'input[type="checkbox"]', function(e){
       
      var $row = $(this).closest('tr');
     
      // Get row data
      var data = table.row($row).data();

      // Get row ID
      var rowId = data[0];
    
      // Determine whether row ID is in the list of selected row IDs 
      var index = $.inArray(rowId, rows_selected);

      // If checkbox is checked and row ID is not in list of selected row IDs
      if(this.checked && index === -1){
         rows_selected.push(rowId);

      // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
      } else if (!this.checked && index !== -1){
         rows_selected.splice(index, 1);
      }
     
      if(this.checked){
         $row.addClass('selected');
      } else {
         $row.removeClass('selected');
      }

      // Update state of "Select all" control
      updateDataTableSelectAllCtrl(table);

      // Prevent click event from propagating to parent
      e.stopPropagation();
   });
   
    // Handle click on table cells with checkboxes
    $('#table').on('click', 'tbody td, thead th:first-child', function(e){
      $(this).parent().find('input[type="checkbox"]').trigger('click');
    });
    
    /* Seleciona todos checkbox */
    $('#example-select-all').on('click', function(){
       var rows = table.rows({ 'search': 'applied' }).nodes();
       $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });
    
     /* Seleção individual do checkbox */
    $('#table tbody').on('change', 'input[type="checkbox"]', function(){
       if(!this.checked){
         var el = $('#example-select-all').get(0);
         if(el && el.checked && ('indeterminate' in el)){
            el.indeterminate = true;
         }
        }
    });

});	
	