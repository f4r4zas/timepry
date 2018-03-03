<div class="row">
    <div class="col-md-5 pull-right">
        <div class="portlet light bordered loading-box-<?php echo $data["reservation_id"]; ?>" id="action-box">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold"></span><?php echo _l("Status", $this); ?>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <button class="btn btn-default btn-circle btn-sm dropdown-toggle" type="button" id="colorPicker<?php echo $data['reservation_id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-id="<?php echo $data['reservation_id']; ?>">
                            <i class="fa fa-paint-brush"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="colorPicker<?php echo $data['reservation_id']; ?>" style="min-width:50px;">
                            <li><a class="pick-color" data-color="success" href="javascript:;" data-id="<?php echo $data['reservation_id']; ?>"><i class="fa fa-circle font-green"></i></a></li>
                            <li><a class="pick-color" data-color="danger" href="javascript:;" data-id="<?php echo $data['reservation_id']; ?>"><i class="fa fa-circle font-red"></i></a></li>
                            <li><a class="pick-color" data-color="info" href="javascript:;" data-id="<?php echo $data['reservation_id']; ?>"><i class="fa fa-circle font-blue"></i></a></li>
                            <li><a class="pick-color" data-color="warning" href="javascript:;" data-id="<?php echo $data['reservation_id']; ?>"><i class="fa fa-circle font-yellow"></i></a></li>
                            <li role="separator" class="divider"></li>
                            <li><a class="pick-color" data-color="" href="javascript:;" data-id="<?php echo $data['reservation_id']; ?>"><i class="fa fa-circle-o"></i></a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-cog"></i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a class="validate-link-<?php echo $data['reservation_id']; ?>"
                                   href="javascript: toggleValidate('<?php echo $data['reservation_id']; ?>');"
                                   data-value="<?php echo $data["checked"]; ?>">
                                    <i class="fa <?php echo $data["checked"]!=1?"fa-check font-green":"fa-times font-yellow"; ?>"></i>
                                    <span><?php echo $data["checked"]!=1?_l("Make valid", $this):_l("Make invalid", $this); ?></span>
                                </a>
                            </li>
                            <li><a id="remindedLink<?php echo $data['reservation_id']; ?>" href="javascript: $.reminder('<?php echo $data['reservation_id']; ?>');"><i class="fa fa-bell font-green-haze"></i> <span><?php echo _l("Send reminder",$this); ?></span></a></li>
                            <li>
                                <a class="closed-link-<?php echo $data['reservation_id']; ?> btn-ask"
                                   data-msg="<?php echo _l("panel_reservation_closed_confirmation",$this); ?>"
                                   href="javascript: toggleClosed('<?php echo $data["reservation_id"]; ?>');"
                                   data-value="<?php echo $data["closed"]; ?>">
                                    <i class="fa <?php echo $data["closed"]!=1?"fa-calendar-check-o font-purple-wisteria":"fa fa-undo"; ?>"></i>
                                    <span><?php echo $data["closed"]!=1?_l("Close", $this):_l("Reopen", $this); ?></span>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li><a class="btn-ask" data-msg="<?php echo _l("panel_reservation_cancel_confirmation",$this); ?>" href="<?php echo APPOINTMENT_ADMIN_URL."reservationAction/".$data["reservation_id"]."/cancel"; ?>"><i class="fa fa-ban font-red"></i> <?php echo _l("Cancel",$this); ?></a></li>
                            <li><a class="btn-ask" data-msg="<?php echo _l("panel_reservation_remove_confirmation",$this); ?>" href="<?php echo APPOINTMENT_ADMIN_URL."reservationAction/".$data["reservation_id"]."/remove"; ?>"><i class="fa fa-trash font-red"></i> <?php echo _l("Remove",$this); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row static-info">
                    <div class="col-xs-1 name"><i class="fa fa-calendar"></i></div>
                    <div class="col-xs-5 name"><?php echo _l('Created',$this); ?></div>
                    <div class="col-xs-6 value">
                        <?php echo my_int_date($data["created_date"]); ?> |
                        <?php echo my_int_justTime($data["created_date"]); ?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-xs-1 name"><i class="fa fa-bell-o"></i></div>
                    <div class="col-xs-5 name"><?php echo _l('Reminded',$this); ?></div>
                    <div class="col-xs-6 value">
                        <?php if($data['reminded']!=0){ ?>
                            <span id="reminded<?php echo $data['reservation_id']; ?>" class="badge bg-green-haze"><?php echo $data['reminded']; ?></span>
                        <?php }else{ ?>
                            <i class="fa fa-times font-yellow"></i>
                        <?php } ?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-xs-1 name"><i class="fa fa-check-square-o"></i></div>
                    <div class="col-xs-5 name"><?php echo _l('Validated',$this); ?></div>
                    <div class="col-xs-6 value">
                        <i class="validate-icon-<?php echo $data["reservation_id"]; ?> <?php echo $data['checked']!=1?'fa fa-times font-yellow':'fa fa-check font-green'; ?>"></i>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-xs-1 name"><i class="fa fa-calendar-check-o"></i></div>
                    <div class="col-xs-5 name"><?php echo _l('Closed',$this); ?></div>
                    <div class="col-xs-6 value">
                        <i class="closed-icon-<?php echo $data["reservation_id"]; ?> <?php echo $data['closed']!=1?'fa fa-times font-yellow':'fa fa-check font-green'; ?>"></i>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-xs-1 name"><i class="fa fa-paypal"></i></div>
                    <div class="col-xs-5 name"><?php echo _l('PayPal Paid',$this); ?></div>
                    <div class="col-xs-6 value">
                        <i class="<?php echo $data['paypal_paid']!=1?'fa fa-times font-yellow':'fa fa-check font-green'; ?>"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet light" id="notes">
            <div class="portlet-title">
                <span class="caption"><?php echo _l("Notes", $this); ?></span>
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
                                <p class="font-purple"><i class="icon-user"></i> <?php echo $item['username']; ?> &nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-calendar"></i> <?php echo my_int_date($item['created_date']).' - '.my_int_justTime($item['created_date']); ?></p>
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
    <div class="col-md-7">
        <div id="highlightElement" class="panel panel-<?php echo $data['color']!=''?$data['color']:'default'; ?>">
            <div class="panel-heading">
                <span class="caption">
                    <span class="caption-subject bold uppercase"><?php echo _l("Details", $this); ?></span>
                </span>
            </div>
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
        <?php if(isset($payments) && count($payments)!=0){ ?>
            <div class="portlet light">
                <div class="portlet-title">
                    <span class="caption"><?php echo _l("PayPal Payments", $this); ?></span>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered">
                        <tr>
                            <th></th>
                            <th><?php echo _l("Transaction ID", $this); ?></th>
                            <th><?php echo _l("Amount", $this); ?></th>
                            <th><?php echo _l("PayPal Fee", $this); ?></th>
                            <th><?php echo _l("Date", $this); ?></th>
                        </tr>
                        <?php $i=0; foreach($payments as $item){ $i++; ?>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $item['transaction_id']; ?></td>
                            <td><?php echo $item['amount']; ?> <?php echo $item['currency']; ?></td>
                            <td><?php echo $item['fee_amount']; ?> <?php echo $item['currency']; ?></td>
                            <td><?php echo my_int_date($item["created_date"]); ?></td>
                        <?php } ?>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/nodaps/admin/reservation.js"></script>
<script>
    $(function(){
        $('#submitComment').submit(function(e){
            var loadingElement = $("#notes");
            var thisElement = $(this);
            thisElement.find('.note').remove();
            $.ajax({
                url: thisElement.attr('action'),
                data: {"message":thisElement.find('textarea').val()},
                method: "post",
                beforeSend: function(){
                    Metronic.blockUI({
                        target: loadingElement,
                        animate: true
                    });
                },
                complete: function(){
                    Metronic.unblockUI(loadingElement);
                }
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.status == 'success'){
                    var newComment = '<div class="well">' +
                        '<p class="font-purple"> <i class="icon-user"></i> ' +
                        '<?php echo $this->session->userdata['username']; ?>' +
                        '&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-calendar"></i> <?php echo my_int_date(time()).' - '.my_int_justTime(time()); ?>' +
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
//                    thisElementParentButton.attr('class','btn btn-xs btn-circle btn-'+btnClass);
                    highlightElement.attr('class','panel panel-'+btnClass);
                    $('#row'+thisElement.attr("data-id")).attr('class',thisElement.attr('data-color'));
                }else{
                    alert(data.error);
                }
            }).error(function(){
                alert("<?php echo _l('Faild action!',$this); ?>");
            });
        });
    });

    $(function(){
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
                    if($('#reminded' + reservationID).length > 0){
                        $('#reminded' + reservationID).text(data.count);
                    }else{
                        $('<span/>', {'class':'badge bg-green-haze', 'id':'reminded'+reservationID}).text(data.count).appendTo('#row'+reservationID+' td:nth-child(9)');
                    }
                    toastr['success']("<?php echo _l('Reminder email was sent successfully!', $this); ?>", "<?php echo _l("Success",$this); ?>");
                }else{
                    toastr['error'](data.error, "<?php echo _l("Error",$this); ?>");
                }
            }).fail(function(){
                toastr['error']("<?php echo _l("There is some system errors! Please report it.", $this); ?>", "<?php echo _l("Error",$this); ?>");
            });
        };

    });

    // Close and Retern items
    var toggleClosed = function ( dataID ){
        $(function(){
            $.actionsOnAppointments( '<?php echo APPOINTMENT_ADMIN_URL; ?>reservationAction/' ,{
                commandCode: $(".closed-link-" + dataID).data('value'),
                id: dataID,
                statusIcons: [$(".closed-icon-" + dataID)],
                toggleButtons: [$(".closed-link-" + dataID)],
                toggleOptions: {
                    0: {
                        btnText: "<?php echo _l("Closed", $this); ?>",
                        btnIcon: "fa fa-calendar-check-o font-purple-wisteria",
                        btnCommand: "close"
                    },
                    1: {
                        btnText: "<?php echo _l("Reopen", $this); ?>",
                        btnIcon: "fa fa-undo",
                        btnCommand: "return"
                    }
                },
                loadingElement: $(".loading-box-" + dataID),
                successMessage: "<?php echo _l("Your command was successful", $this); ?>",
                successMessageTitle: "<?php echo _l("Success", $this); ?>",
                errorMessage: "<?php echo _l("There is some system errors! Please report it.", $this); ?>",
                errorMessageTitle: "<?php echo _l("Error", $this); ?>"
            });
        });
    };
    // Validated and Invalidated items
    var toggleValidate = function ( dataID ){
        $(function(){
            $.actionsOnAppointments( '<?php echo APPOINTMENT_ADMIN_URL; ?>reservationAction/' ,{
                commandCode: $(".validate-link-" + dataID).data('value'),
                id: dataID,
                statusIcons: [$(".validate-icon-" + dataID)],
                toggleButtons: [$(".validate-link-" + dataID)],
                toggleOptions: {
                    0: {
                        btnText: "<?php echo _l("Make valid", $this); ?>",
                        btnIcon: "fa fa-check font-green",
                        btnCommand: "valid"
                    },
                    1: {
                        btnText: "<?php echo _l("Make invalid", $this); ?>",
                        btnIcon: "fa fa-times font-yellow",
                        btnCommand: "novalid"
                    }
                },
                loadingElement: $(".loading-box-" + dataID),
                successMessage: "<?php echo _l("Your command was successful", $this); ?>",
                successMessageTitle: "<?php echo _l("Success", $this); ?>",
                errorMessage: "<?php echo _l("There is some system errors! Please report it.", $this); ?>",
                errorMessageTitle: "<?php echo _l("Error", $this); ?>"
            });
        });
    };
</script>