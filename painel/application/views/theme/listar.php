<div class="row">  
<div class="table-responsive" style="width:100%">
    <table id="table" class="display table select table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
               <?php foreach($table_th as $name_col){?>
               <th class="<?php echo ($name_col['col_order']==true?'':'no-sort'); ?>" ><?php echo $name_col['col_name']; ?></th>
			   <?php }?>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>    
</div>
