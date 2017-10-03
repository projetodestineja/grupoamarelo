<div class="row">   
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
