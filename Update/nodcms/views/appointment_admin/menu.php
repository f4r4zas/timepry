<div class="portlet">
    <div class="portlet-body">
        <div class="table-toolbar">
            <a href="<?php echo ADMIN_URL; ?>editmenu" class="btn btn-primary">
                <i class="fa fa-plus"></i> <?php echo _l("Add New",$this); ?>
            </a>
        </div>
        <?php if(isset($data_list) && count($data_list)!=0){ ?>
            <table  class="table table-striped" id="data_list">
                <thead>
                <tr>
                    <th></th>
                    <th><?=_l("Name",$this)?></th>
                    <th><?=_l("Order",$this)?></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $i=0; foreach($data_list as $item){ $i++; ?>
                    <tr>
                        <td style="width: 20px;"><?=$i?>.</td>
                        <td><?=$item["menu_name"]?></td>
                        <td style="width: 100px;"><?=$item["menu_order"]?></td>
                        <td style="width: 100px;">
                            <?php if(isset($item["public"]) && $item["public"]==1){ ?>
                            <i class="fa fa-eye font-green" title="<?php echo _l("Visible", $this)?>"></i>
                            <?php }else{ ?>
                            <i class="fa fa-eye-slash font-gray" title="<?php echo _l("Hidden", $this)?>"></i>
                            <?php } ?>
                        </td>
                        <td style="width: 100px">
                            <a href="<?=$base_url?>editmenu/<?=$item["menu_id"]?>" class="btn btn-primary btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                            <a href="<?=$base_url?>deletemenu/<?=$item["menu_id"]?>" class="btn btn-danger btn-sm" title="<?=_l('Delete',$this)?>"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php }else{ ?>
            <div class="note note-info"><i class="fa fa-exclamation"></i> <?php echo _l("Empty",$this); ?></div>
        <?php } ?>
    </div>
</div>