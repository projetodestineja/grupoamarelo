<div class="row" >

     <div class="col-12 col-sm-4 col-md-2 col-lg-3 col-xl-1" >
       <img src="<?php echo $row['img']; ?>" class="img-thumbnail"  >
     </div>
     
     <div class="col-12 col-sm-8 col-md-10  col-lg-9 col-xl-10 demanda_list" >

        <div class="row" >
          
          <div class="col-md-4" >
            <i class="fa fa-chevron-right" aria-hidden="true"></i> 
            <b><?php echo $row['residuo']; ?></b>
          </div>

          <div class="col-md-4" >
            <i class="fa fa-cubes" aria-hidden="true"></i>
            <b>QTD:</b> <?php echo "QTD: ".$row['qtd']." ".$row['medida']; ?>
          </div>

          <div class="col-md-4" >
            <i class="fa fa-cube" aria-hidden="true"></i>
            <b>Acondicionado:</b> <?php echo $row['acondicionado']; ?>
          </div> 

        </div>
        
        <div class="row" >
          <div class="col-md-4" >
          <i class="fa fa-calendar" aria-hidden="true"></i>
            <b>Período:</b> 
          </div>
          <div class="col-md-4" >
            <div style="color:<?php echo $row['cor']; ?>;"> 
              <i class="fa fa-asterisk" aria-hidden="true"></i>
              <?php echo $row['status']; ?>
            </div>
          </div> 
          <div class="col-md-4" >
            <i class="fa fa-map-marker" aria-hidden="true"></i>
            <b>Localização:</b> <?php echo $row['nome_cidade']."/".$row['ger_uf_estado']; ?>
          </div>
        </div>
        
        <?php if(!empty($row['obs'])){?>
          <div class="row" >  
            <div class="col-md-12" >
             <?php echo $row['obs']; ?>
            </div>  
          </div>
        <?php } ?>

        <select name="status" id="status">
            <?php foreach($status_result as $n){?>
                <option value="<?php echo $n->id; ?>" ><?php echo $n->descricao; ?></option>
            <?php } ?>
        </select>

   </div> 

</div> 


