       
<?php 
if($result){ ?>
<?php foreach($result as $n){
 $capa = '../uploads/empresa/'.$n->ger_id_empresa.'/demanda/mini/'.$n->img;
 $img = (is_file( $capa)?$capa:base_url('assets/img/demanda_sem_img.jpg')); 
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

