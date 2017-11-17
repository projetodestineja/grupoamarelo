<div id="list_demandas" >
	<!-- Arqui vai ser carregado o Ajax com a listagens dos itens-->
</div>
<script>

  list_demandas();
  
  var loading = '<img src="<?php echo base_url('painel/assets/img/ajax-loader.gif') ?>" >';
  
  $("#list_demandas").html(loading);
  
  function list_demandas() {
     $("#list_demandas").load("<?php echo $url_ajax; ?>");
  }

  $('#list_demandas').delegate('.remover', 'click', function(e) {
    e.preventDefault();
    if (confirm($(this).attr('title')) == true) {
       location.href= $(this).attr('href');
    }
  });	
   
  $('#list_demandas').delegate('.pagination a', 'click', function(e) {
      e.preventDefault();
      $("#list_demandas").html(loading);
      $('#list_demandas').load(this.href);
  });	

</script>	 