<form action="<?php echo site_url('demanda/delete_motivo');?>" method="post">
    <div class="form-row">
        <div class="form-group col-md-12 required" >
            <label for="motivo_cancela" class="col-form-label">Digite o motivo</label>
            <input required type="text" class="form-control" id="motivo_cancela" name="motivo_cancela">
        </div>
    </div>
    <input type="hidden" value="<?php echo $id;?>" id="id" name="id">

    <button type="" class="btn btn-sm btn-danger">
        <i class="fa fa-times" aria-hidden="true"></i> Remover
    </button>
</form>

<script>
    $(document).ready(function () {
        $('#modal_add_edit #title_modal').html('<?php echo $title; ?>');
    });
</script>