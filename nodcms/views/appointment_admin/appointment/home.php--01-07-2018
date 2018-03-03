<?php if($this->_website_info["date_format"]==""){ ?>
    <div class="note note-danger">
        <h4 class="title"><i class="icon-ban"></i>  <?php echo _l("Failed in settings", $this); ?></h4>
        <p>
            <?php echo _l("Date format for your system is not set.", $this); ?>
            <?php echo _l("To set it,", $this); ?>
            <b><a href="<?php echo ADMIN_URL; ?>settings/date-and-time"><?php echo _l("click here!", $this)?></a></b>
        </p>
    </div>
<?php } ?>
<?php if($this->_website_info["time_format"]==""){ ?>
    <div class="note note-danger">
        <h4 class="title"><i class="icon-ban"></i>  <?php echo _l("Failed in settings", $this); ?></h4>
        <p>
            <?php echo _l("Time format for your system is not set.", $this); ?>
            <?php echo _l("To set it,", $this); ?>
            <b><a href="<?php echo ADMIN_URL; ?>settings/date-and-time"><?php echo _l("click here!", $this)?></a></b>
        </p>
    </div>
<?php } ?>
<?php if(isset($fail_auto_messages) && count($fail_auto_messages)!=0){ ?>
    <div class="note note-danger">
        <h4 class="title"><i class="icon-ban"></i>  <?php echo _l("Failed in settings", $this); ?></h4>
        <p>
            <?php echo _l("The bellow ''auto email messages'' don't set.", $this)?>
            <?php echo _l("To set them,", $this)?>
            <b><a href="<?php echo ADMIN_URL; ?>settings/mail"><?php echo _l("click here!", $this)?></a></b>
        </p>
        <ul class="list-unstyled" style="margin: 0 20px;">
            <?php foreach($fail_auto_messages as $item){ ?>
                <li>
                    <img style="width:18px;" src="<?php echo base_url().$item['language']['image']; ?>">
                    <?php echo $item['message']['label']; ?>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<div class="note note-warning">
    <p>
        <i class="icon-info"></i>
        <?php if($this->_website_info['appointment_multiowner']){ ?>
            <?php echo _l("Your system work as a ''multi-owner appointment system'' now.", $this); ?>
        <?php }else{ ?>
            <?php echo _l("Your system work as a ''single-owner appointment system'' now.", $this); ?>
        <?php } ?>
        <?php echo _l("If you want change it,", $this); ?>
        <a href="<?php echo APPOINTMENT_ADMIN_URL; ?>settings"><?php echo _l("click here!", $this); ?></a>
    </p>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-users"></i>
                    <span class="caption-subject bold"><?php echo _l('Last Registered Users', $this); ?></span>
                </div>
                <div class="actions">
                    <a href="<?php echo ADMIN_URL; ?>edituser" class="btn btn-circle btn-default">
                        <i class="fa fa-plus"></i>
                        <?php echo _l("Add New",$this); ?>
                    </a>
                    <a href="<?php echo ADMIN_URL; ?>user" class="btn btn-circle btn-icon-only btn-default"  data-toggle="tooltip" data-placement="bottom" title="<?php echo _l('Full List', $this); ?>">
                        <i class="icon-list"></i>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <?php if(isset($users) && count($users)!=0){ $i=0; ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th><?php echo _l("Username",$this); ?></th>
                            <th><?php echo _l("Date",$this); ?></th>
                            <th><?php echo _l("Active",$this); ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <?php foreach($users as $item){ $i++; ?>
                            <tr>
                                <td>
                                    <?php echo $item["username"]; ?>
                                </td>
                                <td><?php echo my_int_date($item["created_date"]); ?></td>
                                <td>
                                    <i class="<?php echo (isset($item["active"]) && $item["active"]==1)?'fa fa-check font-green':'fa fa-times font-red'; ?>"></i>
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-xs dropdown-toggle" href="<?php echo ADMIN_URL."edituser/".$item["user_id"]; ?>"><i class="fa fa-edit"></i> <?php echo _l("Edit",$this); ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php }else{ ?>
                    <div class="note note-info"><i class="fa fa-exclamation"></i> <?php echo _l("Empty",$this); ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-docs"></i>
                    <span class="caption-subject bold"><?php echo _l('Dental Offices', $this); ?></span>
                </div>
                <div class="actions">
                    <a href="<?php echo APPOINTMENT_ADMIN_URL; ?>providerEdit" class="btn btn-circle btn-default">
                        <i class="fa fa-plus"></i>
                        <?php echo _l("Add New",$this); ?>
                    </a>
                    <a href="<?php echo APPOINTMENT_ADMIN_URL; ?>providers" class="btn btn-circle btn-icon-only btn-default"  data-toggle="tooltip" data-placement="bottom" title="<?php echo _l('Full List', $this); ?>">
                        <i class="icon-list"></i>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <?php if(isset($providers) && count($providers)!=0){ $i=0; ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th><?php echo _l("Unique Name",$this); ?></th>
                            <th><?php echo _l("Date",$this); ?></th>
                            <th><?php echo _l("Active",$this); ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <?php foreach($providers as $item){ $i++; ?>
                            <tr>
                                <td>
                                    <?php if(isset($item["default"]) && $item["default"]==1){ ?>
                                        <i class="fa fa-star font-yellow"  data-toggle="tooltip" data-placement="bottom" title="<?php echo _l('Default provider', $this); ?>"></i>
                                    <?php }elseif(!$this->_website_info['appointment_multiowner']){ ?>
                                        <i class="fa fa-times font-red"  data-toggle="tooltip" data-placement="bottom" title="<?php echo _l('Inaccessible', $this); ?>"></i>
                                    <?php } ?>
                                    <a href="<?php echo APPOINTMENT_ADMIN_URL."index/".$item["provider_id"]; ?>">
                                        <?php echo $item["provider_username"]; ?>
                                    </a>
                                </td>
                                <td><?php echo my_int_date($item["created_date"]); ?></td>
                                <td>
                                    <?php if(!$this->_website_info['appointment_multiowner'] && !$item["default"]){ ?>
                                        <i class="<?php echo (isset($item["active"]) && $item["active"]==1)?'fa fa-check font-grey':'fa fa-times font-grey'; ?>"></i>
                                    <?php }else{ ?>
                                        <i class="<?php echo (isset($item["active"]) && $item["active"]==1)?'fa fa-check font-green':'fa fa-times font-red'; ?>"></i>
                                    <?php } ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-cog"></i> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a target="_blank" href="<?php echo base_url().$_SESSION['language']['code'].'/provider'.$item["provider_username"]; ?>"><i class="fa fa-eye"></i> <?php echo _l("View",$this); ?></a></li>
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
                    <div class="note note-danger">
                        <h4 class="title"><i class="fa fa-exclamation"></i> <?php echo _l("Empty",$this); ?></h4>
                        <p><?php echo _l('Without providers your system will not work.', $this); ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
