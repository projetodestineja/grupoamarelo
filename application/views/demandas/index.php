<div class="row">
    <div class="col-md-3">
        <?php echo $user_row->id; ?>
    </div>
    <div class="col-md-3">
        <?php echo $user_row->residuo; ?>
    </div>
    <div class="col-md-3">
        <?php echo $user_row->status; ?>
    </div>
    <div class="col-md-3">
        <?php echo $user_row->data_validade; ?>
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
            <td><?php echo $row->residuo; ?></td>
            <td><?php echo $row->status; ?></td>
            <td><?php echo $row->data_validade; ?></td>
          </tr>
          <?php } ?>
        </tbody>
        
      </table>
    </div>
</div>
