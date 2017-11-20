<div class="card">
      <h5 class="card-header"><i class="fa fa-commenting" ></i> Mensagem</h5>
      <div class="card-block">
       
        <div class="col-md-12">
          <label>Assunto</label><br>
          <?php echo $assunto; ?>
        </div>
        
        <br />

        <div class="col-md-12">
          <label>Mensagem</label><br>
          <?php echo $msg; ?>
      	</div>
        
       
            <div class="col-md-12">
            <hr>
            <div class="row" >
                
                <div class="col-md-3">
                  <label><i class="fa fa-paper-plane" aria-hidden="true"></i> Alerta por E-mail</label><br>
                  <?php echo $alert_email; ?>
                </div>
                
                <div class="col-md-3">
                  <label><i class="fa fa-calendar" aria-hidden="true"></i> Cadastrada</label><br>
                  <?php echo $cadastrada; ?>
                </div>
                
                <div class="col-md-3">
                  <label><i class="fa fa-calendar" aria-hidden="true"></i>  Atualizada</label><br>
                  <?php echo $atualizada; ?>
                </div>
                
              </div>  
            </div>
    
        
        
     </div>
</div>     