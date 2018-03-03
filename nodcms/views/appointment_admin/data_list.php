<div class="portlet">
    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-sm-6">
                    <div class="btn-group">
                        <?php if(isset($addNewLink)){ ?>
                            <a href="<?php echo $addNewLink; ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo _l("Add New",$this); ?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
        <?php if(isset($data_table)){ include getcwd().'/nodcms/views/appointment_admin/'.$data_table.'.php'; } ?>
    </div>
</div>
<?php if($_SESSION['language']['rtl']!=1){ ?>
    <link href="<?php echo base_url(); ?>assets/metronic/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<?php }else{ ?>
    <link href="<?php echo base_url(); ?>assets/metronic/rtl/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap-rtl.css" rel="stylesheet" type="text/css"/>
<?php } ?>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#data_list').dataTable( {
            "aaSorting": [],
            "oLanguage": {
                "sSearch": "<?=_l("Search",$this)?>:",
                "oPaginate":{
                    "sNext": "<?=_l("Next",$this)?>",
                    "sPrevious": "<?=_l("Previous",$this)?>"
                },
                "sZeroRecords": "<?=_l("No matching records found",$this)?>",
                "sLengthMenu": "<?=_l("_MENU_ Records per page",$this)?>",
                "sInfoEmpty": "<?=_l("Showing 0 to 0 of 0 entries",$this)?>",
                "sInfo": "<?=_l("Showing _START_ to _END_ of _TOTAL_ entries",$this)?>"
            }
        } );
    } );
</script>
