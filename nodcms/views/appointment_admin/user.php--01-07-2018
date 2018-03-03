<link href="<?php echo base_url(); ?>assets/nodcms/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
<section class="portlet">
    <div class="portlet-body">
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <a href="<?=$base_url?>edit<?=$page?>" class="btn btn-primary"><?=_l("Add New",$this)?> <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
        <?php if(isset($data_list) && count($data_list)!=0){ ?>
            <table  class="table table-striped table-bordered table-hover" id="data_list">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?=_l("Username",$this)?></th>
                    <th><?=_l("Email",$this)?></th>
                    <th><?=_l("Full Name",$this)?></th>
                    <th><?=_l("signup date",$this)?></th>
                    <th><?=_l("Group",$this)?></th>
                    <th><?=_l("Active",$this)?></th>
                    <th><?=_l('Action',$this)?></th>
                </tr>
                </thead>
                <tbody>
                <?php $i=0; foreach($data_list as $data){ $i++; ?>
                    <tr class="gradeX">
                        <td><?php echo $i; ?>.</td>
                        <td><?=$data["username"]?></td>
                        <td><?=$data["email"]?></td>
                        <td><?=$data["fullname"]?></td>
                        <td><?=my_int_date($data["created_date"])?></td>
                        <td>
                            <?php if($data["group_id"]==1){ ?>
                                <span class="label label-success"><?php echo $data['group_name']; ?></span>
                            <?php }elseif(in_array($data["group_id"],array(2,20))){ ?>
                                <span class="label label-primary"><?php echo $data['group_name']; ?></span>
                            <?php }elseif($data["group_id"]==100){ ?>
                                <span class="label label-warning"><?php echo $data['group_name']; ?></span>
                            <?php }else{ ?>
                                <span class="label label-danger"><?php echo $data['group_name']; ?></span>
                            <?php } ?>
                        </td>
                        <td><i class="fa <?=$data["active"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                        <td>
                            <a href="<?=$base_url?>edit<?=$page?>/<?=$data["user_id"]?>" class="btn btn-primary btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                            <a href="<?=$base_url?>delete<?=$page?>/<?=$data["user_id"]?>" class="btn btn-danger btn-sm" title="<?=_l('Delete',$this)?>"><i title="<?=_l('Deactive',$this)?>" class="fa fa-times"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</section>
<?php /*
<script src="<?php echo base_url(); ?>assets/nodcms/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/nodcms/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript"></script>

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
 */?>