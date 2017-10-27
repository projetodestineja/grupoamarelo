       
<?php 
if($result){ ?>
<?php foreach($result as $n){
	$img = (isset($n->img)?$n->img:"http://www.premiermax.com.br/wp-content/uploads/2015/12/Sem-Imagem.jpg"); 
?>
<div class="row" >

     <div class="col-12 col-sm-3 col-md-2 col-lg-2 col-xl-1" >
       <img src="<?php echo $img; ?>"  width="100%;">
     </div>
     
     <div class="col-12 col-sm-9 col-md-10  col-lg-10 col-xl-11" >
         <?php echo "<b>".$n->residuo."</b>"; ?>
         <?php echo "<br> ".$n->col_uf_estado." "; //".$n->nome_cidade.", ?>
         <?php echo "Quantidade: ".$n->qtd.$n->uni_medida; ?><br>
        <p><?php echo $n->obs; ?></p>
        <?php echo  "Período: ".date('d/m/y',strtotime($n->data_inicio)). " à ".date('d/m/y',strtotime($n->data_validade)); ?>
        <?php /*<div style="color:<?php echo $n->cor; ?>;"> <?php echo "*".$n->descricao; ?></div>*/ ?>
   </div> 

</div> 

<hr>

<?php } ?>  

<?php echo $pagination; ?>

<?php } ?>

