<div class="portlet">

    <div class="portlet-body">

        <div class="table-toolbar">

            <div class="row">

                <div class="col-md-6">

                    <div class="btn-group">

                        <a href="/timepry/Dental/addDentalOffice/4?add=treatment" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo _l("Add New",$this); ?></a>

                    </div>

                </div>

                <div class="col-md-6">



                </div>

            </div>

        </div>

        <?php 
        
        if(isset($data) && count($data)!=0){ $i=0; ?>

            <table class="table table-striped table-bordered table-advance table-hover">

                <thead>

                <tr>

                    <th></th>

                    <th><?php echo _l("Title",$this); ?></th>

                    <th><?php echo _l("Price",$this); ?></th>

                    <th><?php echo _l("service_description",$this); ?></th>

                    <th><?php echo _l("Period Min",$this); ?></th>

                    <th><?php echo _l("Created Date",$this); ?></th>

                    <th></th>

                </tr>

                </thead>

                <?php foreach($data as $item){ $i++; ?>

                    <tr>

                        <td><?php echo $i; ?></td>
                        <td><?php echo $item["title"]; ?></td>
                        <td><?php echo $this->currency->format($item["price"]); ?></td>
                        <td> <?php echo $item['service_description']; ?> </td>

                        <td><?php echo $item["period_min"]; ?></td>

                        <td><?php echo my_int_date($item["created_date"]); ?>
                        </td>

                        <td>
                            <!-- Single button -->

                            <div class="btn-group">

                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                                    <i class="fa fa-cog"></i> <?php echo _l("Options",$this); ?> <span class="caret"></span>

                                </button>

                                <ul class="dropdown-menu" role="menu">


                                    <li><a href="<?php echo APPOINTMENT_ADMIN_URL."treatmentEdit/".$item["id"]; ?>"><i class="fa fa-edit"></i> <?php echo _l("Edit",$this); ?></a></li>

                                    <li class="divider"></li>

                                    <li><a class="btn-ask" data-msg="<?php echo _l("panel_service_remove_confirmation",$this); ?>" href="<?php echo APPOINTMENT_ADMIN_URL."treatmentRemove/".$item["id"]; ?>"><i class="fa fa-trash"></i> <?php echo _l("Remove",$this); ?></a></li>

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