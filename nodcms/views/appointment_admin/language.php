<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo base_url();?>admin"><?php echo _l('Admin',$this); ?></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="<?php echo base_url();?>language"><?php echo _l('Languages',$this); ?></a>
        </li>
    </ul>
</div>
<section class="portlet">
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
            <table  class="display table table-bordered table-striped" id="data_list">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?=_l("Language Name",$this)?></th>
                    <th><?=_l("Language Code",$this)?></th>
                    <th><?=_l("Public",$this)?></th>
                    <th><?=_l("Order",$this)?></th>
                    <th><?=_l('Action',$this)?></th>
                </tr>
                </thead>
                <tbody>
                <?php $i=0; foreach($data_list as $data){ $i++; ?>
                    <tr class="gradeX">
                        <td><?php echo $i; ?>.</td>
                        <td>
                            <?php if($data["image"]!=''){ ?>
                                <img style="width: 24px;" src="<?php echo base_url().$data["image"]; ?>">
                            <?php } ?>
                            <?=$data["language_name"]?> <?=$data["default"]==1?"("._l('Default',$this).")":""?>
                        </td>
                        <td><?=$data["code"]?></td>
                        <td><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"</td>
                        <td><?=$data["sort_order"]?></td>
                        <td>
                            <div class="dropdown btn-group">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-cog"></i>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="action">
                                    <li><a href="<?=$base_url?>edit<?=$page?>/<?=$data["language_id"]?>"><i class="fa fa-pencil"></i> <?=_l('Edit',$this)?></a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?=$base_url?>edit_lang_file/<?=$data["language_id"]?>/<?=$data["code"]?>"><i class="fa fa-language"></i> <?=_l('Edit Language',$this)?> (<?php echo _l('Frontend',$this); ?>)</a></li>
                                    <li><a href="<?=$base_url?>edit_lang_file/<?=$data["language_id"]?>/backend"><i class="fa fa-language"></i> <?=_l('Edit Language',$this)?> (<?php echo _l('Admin Side',$this); ?>)</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?=$base_url?>delete<?=$page?>/<?=$data["language_id"]?>"><i class="fa fa-trash-o"></i> <?=_l('Delete',$this)?></a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</section>
