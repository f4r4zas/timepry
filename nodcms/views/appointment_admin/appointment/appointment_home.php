<div class="portlet">
    <div class="portlet-body">
        <div class="table-toolbar" style="display: none;">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <a href="<?php echo APPOINTMENT_ADMIN_URL; ?>providerEdit" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo _l("Add New",$this); ?></a>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>
        <?php if(isset($data) && count($data)!=0){ $i=0; ?>
            <table class="table">
                <thead>
                <tr>
                    <th><?php echo _l("Name",$this); ?></th>
                    <th><?php echo _l("Created Date",$this); ?></th>
                    <th><?php echo _l("Yours Permission",$this); ?></th>
                    <th><?php echo _l("Active",$this); ?></th>
                    <th></th>
                </tr>
                </thead>
                <?php foreach($data as $item){ $i++; ?>
                    <tr>
                        <td style="min-width:50%;">
                            <a href="<?php echo APPOINTMENT_ADMIN_URL."index/".$item["provider_id"]; ?>"><?php echo $item["provider_name"]; ?></a>
                        </td>
                        <td><?php echo my_int_date($item["created_date"]); ?></td>
                        <td><?php echo $item["group_name"]; ?></td>
                        <td>
                            <i class="<?php echo (isset($item["active"]) && $item["active"]==1)?'fa fa-check font-green':'fa fa-times font-red'; ?>"></i>
                        </td>
                        <td>
                            <!-- Single button -->
                            <div class="btn-group">
                                <a class="btn btn-info btn-xs" target="_blank" href="<?php echo base_url().$item["provider_username"]; ?>"><i class="fa fa-eye"></i> <?php echo _l("View",$this); ?></a>
                                <a class="btn btn-primary btn-xs" href="<?php echo APPOINTMENT_ADMIN_URL."index/".$item["provider_id"]; ?>"><i class="fa fa-cog"></i> <?php echo _l('Open', $this); ?></a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php }else{ ?>
            <div class="alert alert-info"><i class="fa fa-exclamation"></i> <?php echo _l("Empty",$this); ?></div>
        <?php } ?>
    </div>
</div>