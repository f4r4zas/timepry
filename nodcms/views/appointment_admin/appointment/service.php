
<div class="portlet">

    <div class="portlet-body">

        <div class="table-toolbar">

            <div class="row">

                <div class="col-md-6">

                    <div class="btn-group">

                        <a href="<?php echo APPOINTMENT_ADMIN_URL; ?>serviceEdit" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo _l("Add New",$this); ?></a>

                    </div>

                </div>

                <div class="col-md-6">



                </div>

            </div>

        </div>

        <?php 
        //print_r($this->session->userdata());
        
        if(isset($data) && count($data)!=0){ $i=0; ?>

            <table class="table table-striped table-bordered table-advance table-hover">

                <thead>

                <tr>

                    <th></th>

                    <th><?php echo _l("Name",$this); ?></th>

                    <!--<th><?php echo _l("Price",$this); ?></th>-->

                    <th><?php echo _l("Content Languages",$this); ?></th>

                    <th><?php echo _l("Created Date",$this); ?></th>

                    <th><?php echo _l("Work Days",$this); ?></th>

                    <th></th>

                </tr>

                </thead>

                <?php foreach($data as $item){ $i++; ?>

                    <tr>

                        <td><?php echo $i; ?></td>

                        <td><?php echo $item["service_name"]; ?></td>

                        <!--<td><?php echo $this->currency->format($item["price"]); ?></td>-->

                        <td>

                            <?php if(isset($item['languages']) && count($item['languages'])!=0){ ?>

                                <?php foreach($item['languages'] as $item2){ ?>

                                    <img style="width: 16px;" src="<?php echo base_url().$item2['image']; ?>" alt="<?php echo $item2['language_name']; ?>" title="<?php echo $item2['language_name']; ?>">

                                <?php } ?>

                            <?php }else{ ?>

                                <?php echo _l('Not set!',$this)?>

                            <?php } ?>

                        </td>

                        <td><?php echo my_int_date($item["created_date"]); ?></td>

                        <td>

                            <?php if(count($item['work_times'])!=0){ ?>

                                <?php echo implode(' - ', $item['work_times']); ?>

                            <?php }else{ ?>

                                <i class="fa fa-exclamation-triangle font-red"></i>

                                <span class="font-red"><?php echo _l('Work time is not set.', $this); ?></span>

                            <?php } ?>

                        </td>

                        <td>

                            <!-- Single button -->

                            <div class="btn-group">

                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                                    <i class="fa fa-cog"></i> <?php echo _l("Options",$this); ?> <span class="caret"></span>

                                </button>

                                <ul class="dropdown-menu" role="menu">

                                    <li><a href="<?php echo APPOINTMENT_ADMIN_URL."servicePeriodsEdit/".$item["service_id"]; ?>"><i class="fa fa-clock-o"></i> <?php echo _l("Set Program",$this); ?></a></li>

                                    <li><a class="assign_treatment" href="#" onclick="return false;" data-id="<?php echo $item["service_id"]; ?>"><i class="fa fa-edit"></i> <?php echo _l("See assigned treatments",$this); ?></a></li>

                                    <li><a href="<?php echo APPOINTMENT_ADMIN_URL."serviceEdit/".$item["service_id"]; ?>"><i class="fa fa-edit"></i> <?php echo _l("Edit",$this); ?></a></li>

                                    <li class="divider"></li>

                                    <li><a class="btn-ask" data-msg="<?php echo _l("panel_service_remove_confirmation",$this); ?>" href="<?php echo APPOINTMENT_ADMIN_URL."serviceRemove/".$item["service_id"]; ?>"><i class="fa fa-trash"></i> <?php echo _l("Remove",$this); ?></a></li>

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

<script>
    $(document).ready(function(){
        $(".assign_treatment").click(function(){

            $.ajax({url:'<?php echo base_url() ?>admin-appointment/getAllTreatment',type:"POST",data:{dentist_id:$(this).attr('data-id')} ,function(data){
                console.log(data);
            }}).done(function(data){

                bootbox.alert({
                    title: "Doctors treatments",
                    size: 'small',
                    message: data,
                    callback: function () {
                        console.log('This was logged in the callback!');
                    }
                })
            });

        });
    });
</script>