<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/flatlab/assets/bootstrap-timepicker/compiled/timepicker.css" />
<div class="portlet">
    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insertForm" data-whatever="<?php echo _l("Set a time",$this); ?>"><i class="fa fa-plus"></i> <?php echo _l("Set a time",$this); ?></button>
                    <a class="btn default blue-stripe"  href="<?php echo APPOINTMENT_ADMIN_URL; ?>services"><?php echo _l('Back to Services',$this); ?></a>
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>
        <?php if(isset($data) && count($data)!=0){ ?>
            <table class="table table-striped table-bordered table-advance table-hover">
                <thead>
                <tr>
                    <th></th>
                    <th><?php echo _l('Start Time',$this); ?></th>
                    <th><?php echo _l('End Time',$this); ?></th>
                    <th><?php echo _l('Description',$this); ?></th>
                    <th></th>
                </tr>
                </thead>
                <?php for($i=0;$i<count($data);$i++){ ?>
                    <?php if(isset($data[$i]) && count($data[$i])!=0){ $j=0; ?>
                        <?php foreach($data[$i] as $item){ $j++; ?>
                            <tr>
                                <?php if($j==1){ ?>
                                    <th rowspan="<?php echo count($data[$i])?>" style="width: 60px;"><?php echo $days[$i]; ?></th>
                                <?php } ?>
                                <td>
                                    <i class="fa fa-hourglass-start"></i>
                                    <?php echo reservation_min_to_hours($item["period_start_time"]); ?>
                                </td>
                                <td>
                                    <i class="fa fa-hourglass-end"></i>
                                    <?php echo reservation_min_to_hours($item["period_end_time"]); ?>
                                </td>
                                <td>
                                    <?php echo _l("Each",$this); ?> <?php echo $item["period_min"]; ?> <?php echo _l("Minute",$this); ?>
                                    <?php echo $item["max_count"]!=0?$item["max_count"]:_l("Unlimited",$this); ?> <?php echo _l("appointment",$this); ?>
                                </td>
                                <td>
                                    <!-- Single button -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-cog"></i> <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="javascript:" onClick="$(function(){ $.editForm(<?php echo $item["period_id"]; ?>); });"><i class="fa fa-edit"></i> <?php echo _l("Edit",$this); ?></a></li>
                                            <li class="divider"></li>
                                            <li><a class="btn-ask" data-msg="<?php echo _l("panel_period_remove_confirmation",$this); ?>" href="<?php echo APPOINTMENT_ADMIN_URL; ?>servicePeriodRemove/<?php echo isset($service_data)?$service_data["service_id"]."/":""; ?>/<?php echo $item["period_id"]; ?>"><i class="fa fa-trash"></i> <?php echo _l("Remove",$this); ?></a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr>
                            <th style="width: 60px;"><?php echo $days[$i]; ?></th>
                            <td colspan="4">
                                <div class="note note-warning"><p><i class="icon-info"></i> <?php echo _l('Not set any time!',$this); ?></p></div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        <?php }else{ ?>
            <div class="text-info"><i class="fa fa-exclamation"></i> <?php echo _l("Empty",$this); ?></div>
        <?php } ?>
    </div>
</div>

<div class="modal fade" id="insertForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo APPOINTMENT_ADMIN_URL; ?>servicePeriodsManipulate/<?php echo isset($service_data)?$service_data["service_id"]."/":""; ?>" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="control-label"><?php echo _l("Day",$this); ?>:</label>
                            <select class="form-control" id="day" name="day">
                                <?php for($i=0;$i<7;$i++){ ?>
                                    <option value="<?php echo $i; ?>"><?php echo $days[$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group bootstrap-timepicker">
                                    <label class="control-label"><?php echo _l("Start time",$this); ?>:</label>
                                    <input type="text" class="form-control" data-mask="99:99" id="start_time" name="start_time">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group bootstrap-timepicker">
                                    <label class="control-label"><?php echo _l("End time",$this); ?>:</label>
                                    <input type="text" class="form-control" data-mask="99:99" id="end_time" name="end_time">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" style="display: inline-block"><?php echo _l("How many customers at any time come?",$this); ?></label>
                    <input type="text" class="form-control input-sm number-input" id="customer" name="customer" style="display: inline-block;width: 100px">
                </div>
                <div class="form-group">
                    <label class="control-label" style="display: inline-block;"><?php echo _l("How many minutes per customer need?",$this); ?></label>
                    <input type="text" class="form-control input-sm number-input" id="period" name="period" style="display: inline-block;width: 100px;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("Cancel",$this)?></button>
                <button type="submit" class="btn btn-danger" onclick="$(this).toggleClass('disabled')"><?php echo _l("Submit",$this)?></button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="periodOptions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("Cancel",$this)?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/metronic/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script>
    $(function(){
        $('.timepicker-default').timepicker({
            autoclose: true,
            minuteStep: 1,
            showMeridian: false
        });

        var mainAction = $("#insertForm form").attr("action");
        var closeModal = function(e){
            $("#insertForm .modal-title").html("");
            $("#insertForm .modal-body .alert").remove();
            $(this).find("form").attr("action",mainAction);
            $("#insertForm .modal-body input").val("");
        };
        $.editForm = function (editID){
            $("#insertForm").modal("show").on("hide.bs.modal",closeModal).find("form").attr("action",mainAction+editID);
            $("#insertForm .modal-title").html("Edit");
            $.ajax({
                url: "<?php echo APPOINTMENT_ADMIN_URL; ?>servicePeriodEditGet/<?php echo isset($service_data)?$service_data["service_id"]."/":""; ?>" + editID,
                beforeSend: function( xhr ) {
                    $("#insertForm .modal-body").prepend("<div class='loading'>Please Wait...</div>");
                },
                success: function(data){
                    data = $.parseJSON(data);
                    if(data.status=="success"){
                        $("#customer").val(data.data["customer"]);
                        $("#start_time").val(data.data["start_time"]);
                        $("#end_time").val(data.data["end_time"]);
                        $("#period").val(data.data["period"]);
                        $("#day").val(data.data["day"]);
//                        $("#day option:nth-child(" + data.data["day"] + ")").attr("selected","selected");
                    }else{
                        $("#insertForm .modal-body").prepend("<div class='alert alert-danger'>Error: "+ data.error +"</div>");
                    }
                },
                complete: function(xhr,status){
                    $("#insertForm").find(".loading").remove();
                },
                error:function(xhr,status,error){
                    $("#insertForm .modal-body").prepend("<div class='alert alert-danger'>Error: "+ error +"</div>");
                }
            });
        }
        $.submitPeriodForm = function(){
            alert($(this).attr("action"));
            return false;
        }
    });
</script>