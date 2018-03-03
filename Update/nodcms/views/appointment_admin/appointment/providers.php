<div class="portlet">
    <div class="portlet-body">
        <div class="table-toolbar">
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
            <table class="table table-striped table-bordered table-advance table-hover">
                <thead>
                <tr>
                    <th><?php echo _l("Name",$this); ?></th>
                    <th><?php echo _l("Owner",$this); ?></th>
                    <th><?php echo _l("Created Date",$this); ?></th>
                    <th><?php echo _l("Your Permission",$this); ?></th>
                    <th><?php echo _l("Active",$this); ?></th>
                    <th><?php echo _l("Default",$this); ?></th>
                    <th></th>
                </tr>
                </thead>
                <?php foreach($data as $item){ $i++; ?>
                    <tr>
                        <td>
                            <a href="<?php echo APPOINTMENT_ADMIN_URL."index/".$item["provider_id"]; ?>">
                                <?php echo $item["provider_name"]; ?>
                            </a>
                        </td>
                        <td><?php echo $item["username"]; ?></td>
                        <td><?php echo my_int_date($item["created_date"]); ?></td>
                        <td><?php echo $item["group_name"]; ?></td>
                        <td>
                            <i class="<?php echo (isset($item["active"]) && $item["active"]==1)?'fa fa-check font-green':'fa fa-times font-red'; ?>"></i>
                        </td>
                        <td>
                            <?php if(isset($item["default"]) && $item["default"]==1){ ?>
                                <i class="fa fa-check font-green"></i>
                            <?php } ?>
                        </td>
                        <td>
                            <!-- Single button -->
                            <div class="btn-group">
                                <a class="btn btn-info btn-xs" target="_blank" href="<?php echo base_url().$_SESSION['language']['code'].'/provider/'.$item["provider_username"]; ?>"><i class="fa fa-eye"></i> <?php echo _l("View",$this); ?></a>
                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-cog"></i> <?php echo _l("Options",$this); ?> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo APPOINTMENT_ADMIN_URL."providerEdit/".$item["provider_id"]; ?>"><i class="fa fa-edit"></i> <?php echo _l("Edit",$this); ?></a></li>
                                    <li><a href="<?php echo APPOINTMENT_ADMIN_URL."providerManager/".$item["provider_id"]; ?>"><i class="fa fa-users"></i> <?php echo _l("Manager",$this); ?></a></li>
                                    <li><a href="<?php echo APPOINTMENT_ADMIN_URL."makeProviderDefault/".$item["provider_id"]; ?>"><i class="fa fa-asterisk"></i> <?php echo _l("Make default",$this); ?></a></li>
                                    <li class="divider"></li>
                                    <li><a class="btn-ask" data-msg="<?php echo _l("panel_provider_remove_confirmation",$this); ?>" href="<?php echo APPOINTMENT_ADMIN_URL."providerRemove/".$item["provider_id"]; ?>"><i class="fa fa-trash"></i> <?php echo _l("Remove",$this); ?></a></li>
                                </ul>
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