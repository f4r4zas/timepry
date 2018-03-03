<?php if(isset($data_list) && count($data_list)!=0){ $i=0; ?>
    <table class="table table-striped table-bordered table-advance table-hover">
        <thead>
        <tr>
            <th></th>
            <th><?php echo _l("Input name",$this); ?></th>
            <th><?php echo _l("Type",$this); ?></th>
            <th><?php echo _l("Minimum",$this); ?></th>
            <th><?php echo _l("Maximum",$this); ?></th>
            <th><?php echo _l("Require filed",$this); ?></th>
            <th></th>
        </tr>
        </thead>
        <?php foreach($data_list as $item){ $i++; ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $item['field_name']; ?></td>
                <td><?php echo $item["type_name"]; ?></td>
                <td><?php echo $item["min"]; ?></td>
                <td><?php echo $item["max"]; ?></td>
                <td><i class="fa <?php echo $item["require"]==1?"fa-check font-green":"fa-minus"?>"></i></td>
                <td>
                    <div class="btn-group">
                        <a class="btn btn-primary btn-xs" href="<?php echo APPOINTMENT_ADMIN_URL; ?>extraFieldsEdit/<?php echo $item['id']; ?>">
                            <i class="fa fa-edit"></i> <?php echo _l("Edit",$this); ?>
                        </a>
                        <a href="<?php echo APPOINTMENT_ADMIN_URL."extraFieldsRemove/".$item["id"]; ?>" class="btn btn-danger btn-xs btn-ask" data-msg="<?php echo _l("extra_fields_remove_confirmation",$this); ?>"><i class="icon-trash"></i> <?php echo _l("Remove",$this); ?></a>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php echo isset($pagination)?$pagination:""; ?>
<?php }else{ ?>
    <div class="note note-info">
        <h4 class="block"><i class="icon-info"></i> <?php echo _l("Not set data!",$this); ?></h4>
        <p><?php echo _l("In this page doesn't exists eny appointment request. To see more requests please change your filter or go to another page.",$this); ?></p>
    </div>
<?php } ?>