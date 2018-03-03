<div class="portlet">
    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insertForm" data-whatever="<?php echo _l("Add New",$this); ?>"><i class="fa fa-plus"></i> <?php echo _l("Add New",$this); ?></button>
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
                    <th class="hidden-sm hidden-xs"></th>
                    <th><?php echo _l("Title",$this); ?></th>
                    <th class="hidden-sm hidden-xs"><?php echo _l("Date",$this); ?></th>
                    <th></th>
                </tr>
                </thead>
                <?php foreach($data as $item){ $i++; ?>
                    <tr>
                        <td class="hidden-sm hidden-xs"><?php echo $i; ?>.</td>
                        <td><?php echo $item["date_title"]; ?></td>
                        <td class="hidden-sm hidden-xs"><?php echo my_int_date($item["free_date"]); ?></td>
                        <td>
                            <!-- Single button -->
                            <button class="btn btn-primary btn-sm" type="button" onClick="$(function(){ $.editForm(<?php echo $item["date_id"]; ?>); });"><i class="fa fa-edit"></i> <?php echo _l("Edit",$this); ?></button>
                            <a href="<?php echo APPOINTMENT_ADMIN_URL."holidaysRemove/".$item["date_id"]; ?>" class="btn btn-danger btn-sm btn-ask" data-msg="<?php echo _l("holidays_remove_confirmation",$this); ?>"><i class="icon-trash"></i> <?php echo _l("Remove",$this); ?></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php }else{ ?>
            <div class="alert alert-info"><i class="fa fa-exclamation"></i> <?php echo _l("Empty",$this); ?></div>
        <?php } ?>
        <?php echo isset($pagination)?$pagination:""; ?>
    </div>
</div>

<div class="modal fade" id="insertForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="<?php echo APPOINTMENT_ADMIN_URL; ?>holidaysManipulate" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label"><?php echo _l("Name",$this); ?>:</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo _l("Date",$this); ?>:</label>
                    <input type="text" class="form-control" id="date" name="date">
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
<script>
    $(function(){
        $("#date").datepicker({
            changeYear: true,
            changeMonth:true,
            autoclose: true
        });
        var mainAction = $("#insertForm form").attr("action");
        var closeModal = function(e){
            $("#insertForm .modal-title").html("");
            $(this).find("form").attr("action",mainAction);
            $("#name").val("");
            $("#date").val("");
        }
        $.editForm = function (editID){
            $("#insertForm").modal("show").on("hide.bs.modal",closeModal).find("form").attr("action",mainAction+"/"+editID);
            $("#insertForm .modal-title").html("Edit");
            $.ajax({
                url: "<?php echo APPOINTMENT_ADMIN_URL; ?>holidaysEdit/" + editID,
                beforeSend: function( xhr ) {
                    $("#insertForm .modal-body").prepend("<div class='loading'>Please Wait...</div>");
//                    xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                },
                success: function(data){
                    data = $.parseJSON(data);
                    if(data.status=="success"){
                        $("#name").val(data.data["name"]);
                        $("#date").val(data.data["date"]);
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