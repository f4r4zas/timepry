<?php get_instance()->load->helper('user'); ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><?php echo _l('Information',$this); ?>: <?php echo $data['reservation_id']; ?></h4>
</div>
<div class="modal-body">

    <div class="row">
        <div class="col-md-6">
            <div id="highlightElement" class="panel panel-<?php echo $data['color']!=''?$data['color']:'default'; ?>">
                <div class="panel-heading"><?php echo _l("Appointment Details", $this); ?></div>
                <div class="panel-body">
                    <div class="row static-info">
                        <div class="col-xs-1 name"><i class="fa fa-barcode"></i></div>
                        <div class="col-xs-5 name"><?php echo _l('Booking Key',$this); ?></div>
                        <div class="col-xs-6 value"><mark><?php echo $data["reservation_id"]; ?></mark></div>
                    </div>
                    <div class="row static-info">
                        <div class="col-xs-1 name"><i class="fa fa-calendar"></i></div>
                        <div class="col-xs-5 name"><?php echo _l('Appointment Date',$this); ?></div>
                        <div class="col-xs-6 value"><mark><?php echo my_int_justDate($data["reservation_date_time"]); ?></mark></div>
                    </div>
                    <div class="row static-info">
                        <div class="col-xs-1 name"><i class="fa fa-clock-o"></i></div>
                        <div class="col-xs-5 name"><?php echo _l('Appointment Time',$this); ?></div>
                        <div class="col-xs-6 value">
                            <mark>
                                <?php echo my_int_justTime($data["reservation_date_time"]); ?> -
                                <?php echo my_int_justTime($data["reservation_edate_time"]); ?>
                            </mark>
                        </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-xs-1 name"><i class="fa fa-certificate"></i></div>
                        <div class="col-xs-5 name"><?php echo _l('Service Name',$this); ?></div>
                        <div class="col-xs-6 value"><?php echo $data["service_name"]; ?></div>
                    </div>
                    <div class="row static-info">
                        <div class="col-xs-1 name"><i class="fa fa-ticket"></i></div>
                        <div class="col-xs-5 name"><?php echo _l('Price',$this); ?></div>
                        <div class="col-xs-6 value"><?php echo $this->currency->format($data["price"]); ?></div>
                    </div>
                    <div class="row static-info">
                        <div class="col-xs-1 name"><i class="fa fa-user"></i></div>
                        <div class="col-xs-5 name"><?php echo _l('Name',$this); ?></div>
                        <div class="col-xs-6 value"><?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?></div>
                    </div>
                    <div class="row static-info">
                        <div class="col-xs-1 name"><i class="fa fa-envelope"></i></div>
                        <div class="col-xs-5 name"><?php echo _l('Email',$this); ?></div>
                        <div class="col-xs-6 value"><?php echo $data["email"]; ?></div>
                    </div>
                    <div class="row static-info">
                        <div class="col-xs-1 name"><i class="fa fa-phone"></i></div>
                        <div class="col-xs-5 name"><?php echo _l('Telephone',$this); ?></div>
                        <div class="col-xs-6 value"><?php echo $data["tel"]; ?></div>
                    </div>

                    <div class="row static-info">
                        <div class="col-xs-1"><input type="button" id="userDetails" class="btn btn-primary userDetails" value="User Public Profile"></div>

                    </div>




                    <?php if(isset($extra_fields) && count($extra_fields)!=0){ ?>
                        <?php foreach($extra_fields as $item){ ?>
                            <div class="row static-info">
                                <div class="col-xs-1 name"><i class="fa fa-plus"></i></div>
                                <div class="col-xs-5 name"><?php echo $item["field_name"]; ?></div>
                                <div class="col-xs-6 value"><?php echo $item["value"]; ?></div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="btn-group loading-box-<?php echo $data["reservation_id"]; ?>" id="action-box">
                <a class="btn btn-default validate-link-<?php echo $data['reservation_id']; ?>"
                   href="javascript: toggleValidate('<?php echo $data['reservation_id']; ?>');"
                   data-value="<?php echo $data["checked"]; ?>">
                    <i class="fa <?php echo $data["checked"]!=1?"fa-check font-green":"fa-times font-yellow"; ?>"></i>
                    <span><?php echo $data["checked"]!=1?_l("Make valid", $this):_l("Make invalid", $this); ?></span>
                </a>
                <a class="btn btn-default" id="remindedBtnLink<?php echo $data['reservation_id']; ?>" href="javascript: $.reminder('<?php echo $data['reservation_id']; ?>');">
                    <i class="fa fa-bell font-green-haze"></i>
                    <span><?php echo _l("Send reminder",$this); ?></span>
                    <?php if($data['reminded']!=0){ ?>
                        <span id="reminded_btn<?php echo $data['reservation_id']; ?>" class="badge bg-green-haze"><?php echo $data['reminded']; ?></span>
                    <?php } ?>
                </a>
                <a class="btn btn-default closed-link-<?php echo $data['reservation_id']; ?> btn-ask"
                   data-msg="<?php echo _l("panel_reservation_closed_confirmation",$this); ?>"
                   href="javascript: toggleClosed('<?php echo $data["reservation_id"]; ?>');"
                   data-value="<?php echo $data["closed"]; ?>">
                    <i class="fa <?php echo $data["closed"]!=1?"fa-calendar-check-o font-purple-wisteria":"fa fa-undo"; ?>"></i>
                    <span><?php echo $data["closed"]!=1?_l("Close", $this):_l("Reopen", $this); ?></span>
                </a>
            </div>
            <div id="notes" class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold"><?php echo _l("Notes", $this); ?></span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form" method="post" action="<?php echo APPOINTMENT_ADMIN_URL; ?>reservationAction/<?php echo $data['reservation_id']; ?>/comment" id="submitComment">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-sm-9">
                                    <textarea name="message" class="form-control" placeholder="<?php echo _l('Write your text here...',$this) ?>"></textarea>
                                </div>
                                <div class="col-sm-3">
                                    <button class="btn btn-primary btn-block" type="submit"><?php echo _l('Save',$this); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="comment_list">
                        <?php if(isset($comments) && count($comments)!=0){ ?>
                            <?php foreach($comments as $item){ ?>
                                <div class="well">
                                    <p class="font-purple"><i class="icon-user"></i> <?php echo $item['username']; ?> &nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-calendar"></i> <?php echo my_int_date($item['created_date']); ?></p>
                                    <p><?php echo $item['comment_message']; ?></p>
                                </div>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="note note-info"><?php echo _l('Empty!',$this); ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer hidden-print">
    <div class="btn-group">
        <div class="dropup">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-times font-red"></i> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a class="btn-ask" data-msg="<?php echo _l("panel_reservation_cancel_confirmation",$this); ?>" href="<?php echo APPOINTMENT_ADMIN_URL."reservationAction/".$data["reservation_id"]."/cancel"; ?>"><i class="fa fa-ban font-red"></i> <?php echo _l("Cancel",$this); ?></a></li>
                <li><a class="btn-ask" data-msg="<?php echo _l("panel_reservation_remove_confirmation",$this); ?>" href="<?php echo APPOINTMENT_ADMIN_URL."reservationAction/".$data["reservation_id"]."/remove"; ?>"><i class="fa fa-trash font-red"></i> <?php echo _l("Remove",$this); ?></a></li>
            </ul>
        </div>
    </div>
    <div class="btn-group">
        <div class="dropup">
            <button class="btn btn-<?php echo $data['color']!=''?$data['color']:'default'; ?> dropdown-toggle" type="button" id="colorPicker<?php echo $data['reservation_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-id="<?php echo $data['reservation_id']; ?>">
                <i class="fa fa-paint-brush"></i>
                <i class="fa fa-caret-up"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="colorPicker<?php echo $data['reservation_id']; ?>" style="min-width:50px;">
                <li><a class="pick-color" data-color="success" href="#" data-id="<?php echo $data['reservation_id']; ?>"><i class="fa fa-circle font-green"></i></a></li>
                <li><a class="pick-color" data-color="danger" href="#" data-id="<?php echo $data['reservation_id']; ?>"><i class="fa fa-circle font-red"></i></a></li>
                <li><a class="pick-color" data-color="info" href="#" data-id="<?php echo $data['reservation_id']; ?>"><i class="fa fa-circle font-blue"></i></a></li>
                <li><a class="pick-color" data-color="warning" href="#" data-id="<?php echo $data['reservation_id']; ?>"><i class="fa fa-circle font-yellow"></i></a></li>
                <li role="separator" class="divider"></li>
                <li><a class="pick-color" data-color="" href="#" data-id="<?php echo $data['reservation_id']; ?>"><i class="fa fa-circle-o"></i></a></li>
            </ul>
        </div>
    </div>
    <a class="btn btn-primary" href="<?php echo APPOINTMENT_ADMIN_URL; ?>reservationDetails/<?php echo $data["reservation_id"]; ?>"`>
        <?php echo _l("More Details", $this); ?>
    </a>
    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("Close",$this)?></button>
</div>

<div class="user-profile-details" style="display: none">

    <?php

    $userdata = getReservationUserId($data["email"]);

                if(getUserProfile($userdata[0]['user_id'])){
                    generateUserProfile($userdata[0]['user_id']);
                }
    ?>

</div>

<script>
    $(function(){

            $(".userDetails").click(function(){

                var html = $(".user-profile-details").html();

                if(html.trim()){
                    console.log(html);
                    bootbox.alert(html);
                }else{
                    bootbox.alert("User has not finished his profile");
                }

            })
        //


        $('#submitComment').submit(function(e){
            var thisElement = $(this);
            thisElement.find('.note').remove();
            $.ajax({
                url: thisElement.attr('action'),
                data: {"message":thisElement.find('textarea').val()},
                method: "post",
                beforeSend: function(){
                    Metronic.blockUI({
                        target: $("#notes"),
                        animate: true
                    });
                },
                complete: function(){
                    Metronic.unblockUI($("#notes"));
                }
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.status == 'success'){
                    var newComment = '<div class="well">' +
                        '<p class="font-purple"> <i class="icon-user"></i> ' +
                        '<?php echo $this->session->userdata['username']; ?>' +
                        '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-calendar"></i> <?php echo my_int_date(time())?>' +
                        '</p>' +
                        '<p>'+thisElement.find('textarea').val()+'</p>' +
                        '</div>';

                    $('#comment_list').prepend(newComment);
                    $('#comment_list').find('.note').remove();
                    thisElement.find('textarea').val('');
                }else{
                    thisElement.prepend('<div class="note note-danger">'+data.error+'</div>');
                }
            });
            e.preventDefault();
        });
        $('.pick-color').click(function(e){
            var thisElement = $(this);
            var thisElementParentButton = $('#colorPicker<?php echo $data['reservation_id']; ?>');
            var highlightElement = $('#highlightElement');
            $.ajax({
                url: "<?php echo APPOINTMENT_ADMIN_URL; ?>reservationAction/"+thisElement.attr("data-id")+"/color",
                data: {"color":thisElement.attr('data-color')},
                method: "post",
                beforeSend: function(){
                    Metronic.blockUI({
                        target: highlightElement,
                        animate: true
                    });
                },
                complete: function(){
                    Metronic.unblockUI(highlightElement);
                }
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.status == 'success'){
                    if(thisElement.attr('data-color')!=''){
                        var btnClass = thisElement.attr('data-color');
                    }else{
                        var btnClass = 'default';
                    }
                    thisElementParentButton.attr('class','btn btn-' + btnClass);
                    highlightElement.attr('class','panel panel-' + btnClass);
                    $('#row'+thisElement.attr("data-id")).attr('class',thisElement.attr('data-color'));
                    if($('#event'+thisElement.attr("data-id")).length > 0){
                        var eventColor = '';
                        if(thisElement.attr("data-color")=='danger')
                            eventColor = 'red';
                        else if(thisElement.attr("data-color")=='success')
                            eventColor = 'green';
                        else if(thisElement.attr("data-color")=='info')
                            eventColor = 'blue';
                        else if(thisElement.attr("data-color")=='warning')
                            eventColor = 'yellow';
                    }
                    if($("#calendar").length > 0){
                        $("#calendar").fullCalendar( 'refetchEvents' );
                    }
                }else{
                    alert(data.error);
//                alert('<div class="note note-danger">'+data.error+'</div>');
                }
            }).error(function(){
                alert("<?php echo _l('Faild action!',$this); ?>");
            });
        });


        // Reminer click action
        $.reminder = function(reservationID){
            $.ajax({
                url: '<?php echo APPOINTMENT_ADMIN_URL; ?>reservationAction/' + reservationID + '/remind',
                beforeSend: function(){
                    Metronic.blockUI({
//                        target: '#row' + reservationID,
                        target: '#action-box',
                        animate: true
                    });
                },
                complete: function(){
//                    Metronic.unblockUI('#row' + reservationID);
                    Metronic.unblockUI('#action-box');
                }
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.status == 'success'){
                    // Add to row in table
                    if($('#reminded' + reservationID).length > 0){
                        $('#reminded' + reservationID).text(data.count);
                    }else{
                        $('<span/>', {'class':'badge bg-green-haze', 'id':'reminded'+reservationID}).text(data.count).appendTo('#row'+reservationID+' td:nth-child(11)');
                    }
                    // Add to button
                    if($('#reminded_btn' + reservationID).length > 0){
                        $('#reminded_btn' + reservationID).text(data.count);
                    }else{
                        $('<span/>', {'class':'badge bg-green-haze', 'id':'reminded_btn'+reservationID}).text(data.count).appendTo('#remindedBtnLink'+reservationID);
                    }
                    toastr['success']("<?php echo _l('Reminder email was sent successfully!', $this); ?>", "<?php echo _l("Success",$this); ?>");
                }else{
                    toastr['error'](data.error, "<?php echo _l("Error",$this); ?>");
                }
            }).fail(function(){
                toastr['error']("<?php echo _l("There is some system errors! Please report it.", $this); ?>", "<?php echo _l("Error",$this); ?>");
            });
        };

        // Validate click action
        $.changeValidate = function(reservationID){
            var type = $('#validateLink' + reservationID).attr('data-type');
            var ajaxPost = function(){
                $.ajax({
                    url: '<?php echo APPOINTMENT_ADMIN_URL; ?>reservationAction/' + reservationID + '/' + type,
                    beforeSend: function(){
                        Metronic.blockUI({
//                            target: '#row' + reservationID,
                            target: '#action-box',
                            animate: true
                        });
                    },
                    complete: function(){
//                        Metronic.unblockUI('#row' + reservationID);
                        Metronic.unblockUI('#action-box');
                    }
                }).done(function(data) {
                    data = JSON.parse(data);
                    if(data.status == 'success'){
                        successFunction();
                        if($("#calendar").length > 0){
                            $("#calendar").fullCalendar( 'refetchEvents' );
                        }
                    }else{
                        toastr['error'](data.error, "<?php echo _l("Error",$this); ?>");
                    }
                });
            };
            if(type=='valid'){
                var successFunction = function(){
                    $('#validateIcon' + reservationID).removeClass('fa-times font-yellow').addClass('fa-check font-green');
                    $('#validateLink' + reservationID).attr("data-type", "novalid");
                    $('#validateLink' + reservationID + ' i').removeClass('fa-check font-green').addClass('fa-times font-yellow');
                    $('#validateLink' + reservationID + ' span').text("<?php echo _l("Make invalid",$this); ?>");
                };
                ajaxPost();
            }else if(type=='novalid'){
                var successFunction = function(){
                    $('#validateIcon' + reservationID).removeClass('fa-check font-green').addClass('fa-times font-yellow');
                    $('#validateLink' + reservationID).attr("data-type", "valid");
                    $('#validateLink' + reservationID + ' i').removeClass('fa-times font-yellow').addClass('fa-check font-green');
                    $('#validateLink' + reservationID + ' span').text("<?php echo _l("Make valid",$this); ?>");
                };
                ajaxPost();
            }
        };


        $('.btn-ask').confirmation({
            container: 'body',
            btnOkClass: 'btn-xs btn-success',
            btnCancelClass: 'btn-xs btn-danger',
            singleton: true,
            popout: true,
            btnOkIcon: 'fa fa-check',
            btnCancelIcon: 'fa fa-times',
            placement: 'left',
            title:$(this).attr('data-msg'),
            btnOkLabel: '<?php echo _l("Yes please!",$this); ?>',
            btnCancelLabel: '<?php echo _l("No Stop!",$this); ?>'
        });
    });

</script>