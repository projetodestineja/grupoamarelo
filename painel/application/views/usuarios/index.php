      <div class="row">
            <div class="col-md-3">
                <?php echo $user_row->id; ?>
            </div> 
            <div class="col-md-3">
                <?php echo $user_row->nome; ?>
            </div> 
            <div class="col-md-3">
                <?php echo $user_row->email; ?>
            </div> 
            <div class="col-md-3">
                <?php echo $user_row->telefone; ?>
            </div> 
      </div> 

<hr>
      <div class="row">    
            <div class="table-responsive grid-list" >
              <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                  </tr>
                </tfoot>
                <tbody>
                   
                  <?php foreach($result as $row){?> 
                  <tr>
                    <td><?php echo $row->id; ?></td>  
                    <td><?php echo $row->nome; ?></td>
                    <td><?php echo $row->telefone; ?></td>
                    <td><?php echo $row->celular; ?></td>
                    <td><?php echo $row->email; ?></td>
                    <td><?php echo $row->cep; ?></td>
                    
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            </div>
  