
<div id="list_demandas" >
<!-- Arqui vai ser carregado o Ajax com a listagens dos itens-->
	
</div>

<script>
  list_demandas();
  
  var loading = '<img src="<?php echo base_url('assets/img/ajax-loader.gif') ?>" >';
  
  $("#list_demandas").html(loading);
  
  function list_demandas() {
	 
     $("#list_demandas").load("<?php echo site_url('demandas/get_list') ?>");
  }
  
  $('#list_demandas').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();
	$("#list_demandas").html(loading);
	$('#list_demandas').load(this.href);
  });	

</script>	 