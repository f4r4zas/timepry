<?php get_instance()->load->helper('user'); ?>
<div class="user-profile-details" style="display: none">
</div>
<div class="portlet">
    <div class="portlet-body">
        <p>
            <?php echo _l("Total results:", $this); ?>
            <strong><?php echo isset($count)?$count:0; ?></strong>
        </p>
        <p>
            <?php echo _l("Total price:", $this); ?>
            <strong><?php echo isset($sum_price)?$this->currency->format($sum_price):0; ?></strong>
        </p>
        <div class="">
            <table class="table table-striped table-bordered table-advance table-hover">
                <thead>
                <tr class="gray-gallery">
                    <th><?php echo _l("ID",$this); ?></th>
                    <th><?php echo _l("Date and Time",$this); ?></th>
                    <th><?php echo _l("Name",$this); ?></th>
                    <th><?php echo _l("Practitioner",$this); ?></th>
                    <th><?php echo _l("Treatment",$this); ?></th>
                    <th><?php echo _l("Price",$this); ?></th>
                    <th><?php echo _l("Online Paid",$this); ?></th>
                    <th><?php echo _l("To pay at dental office",$this); ?></th>
                   <!-- <th><i class="fa fa-check-square-o" title="<?php /*echo _l("Validated",$this); */?>"></i></th>
                    <th><i class="fa fa-flag-o" title="<?php /*echo _l("Closed", $this); */?>"></i></th>
                    <th><i class="fa fa-bell-o" title="<?php /*echo _l("Reminded", $this); */?>"></i></th>-->
                    <th></th>
                </tr>
                <tr>
                    <td>
                        <input class="form-control input-sm" id="reservation-id" value="<?php echo isset($reservation_id)?$reservation_id:''; ?>">
                    </td>
                    <td style="width:120px;">
                        <input placeholder="<?php echo _l("From", $this); ?>" class="my-datepicker form-control input-sm margin-bottom-5" id="min-app-date" readonly value="<?php echo isset($min_app_date)?$min_app_date:''; ?>">
                        <input placeholder="<?php echo _l("To", $this); ?>" class="my-datepicker form-control input-sm" id="max-app-date" readonly value="<?php echo isset($max_app_date)?$max_app_date:''; ?>">
                    </td>
                    <td>
                        <input placeholder="<?php echo _l("Search name", $this); ?>" class="form-control input-sm" id="search-name" value="<?php echo isset($search_text)?$search_text:''; ?>">
                    </td>
                    <td>
                        <select class="form-control input-sm" id="service">
                            <option value="0"><?php echo _l("All Services", $this); ?></option>
                            <?php foreach($services as $item){ ?>
                                <option value="<?php echo $item["service_id"]; ?>" <?php echo (isset($service_id) && $service_id == $item["service_id"])?'selected':''; ?>>
                                    <?php echo $item["service_name"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td>
                        <button id="submit-search" class="btn btn-success btn-sm margin-bottom-5"><i class="fa fa-search"></i> <?php echo _l("Search", $this)?></button>
                        <button id="submit-print" class="btn btn-primary btn-sm margin-bottom-5"><i class="fa fa-print"></i> <?php echo _l("Print", $this)?></button>
                        <a href="<?php echo APPOINTMENT_ADMIN_URL; ?>reservation" class="btn btn-danger btn-sm btn-ask">
                            <i class="fa fa-times"></i>
                            <?php echo _l("Reset", $this); ?></a>
                    </td></tr>

                </thead>
                <?php if(isset($data) && count($data)!=0){ $i=0; ?>
                    <?php foreach($data as $item){ $i++; ?>
                        <tr class="<?php echo $item['color']; ?> loading-box-<?php echo $item['reservation_id']; ?>" id="row<?php echo $item['reservation_id']; ?>">
                            <td style="width: 80px;"><?php echo $item['reservation_id']; ?></td>
                            <td>
							
                                <?php if($item["reservation_date"] < mktime(0,0,0,date("m"),date("d"),date("Y"))){ ?>
								
                                <span class="font-red" title="<?php echo _l("Expired", $this); ?>">
                            <?php }elseif($item["reservation_date"] == mktime(0,0,0,date("m"),date("d"),date("Y"))){ ?>
							
                                    <span class="font-yellow" title="<?php echo _l("Today", $this); ?>">
                            <?php }else{ ?>
                                        <span class="font-green">
                            <?php } ?>
                            <?php echo my_int_date($item["reservation_date_time"]).' '.my_int_justTime($item["reservation_date_time"]); ?>
                            </span>
                            </td>
                            <td><a class="userDetails" href="#"><?php echo $item["fname"]; ?> <?php echo $item["lname"]; ?></a></td>
                            <td><?php echo $item["service_name"]; ?></td>
                            <td><?php echo $item["title_treatment"]; ?></td>
                            <td><?php echo $this->currency->format($item["price"]); ?></td>
                            <td>
                                <i class="<?php echo $item['paypal_paid']=0?'fa fa-times font-yellow':'fa fa-check font-green'; ?>"></i>
                            </td>
                            <td>
                                <i class="<?php echo $item['paypal_paid']=1?'fa fa-times font-yellow':'fa fa-check font-green'; ?>"></i>
                            </td>
                            <td>
                                <a class="btn default btn-xs" href="javascript:;" onclick="$.showComments(<?php echo $item['reservation_id']; ?>)"><i class="fa fa-search"></i> <?php echo _l("View",$this); ?></a>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <!--<li>
                                            <a href="<?php /*echo APPOINTMENT_ADMIN_URL."reservationDetails/".$item["reservation_id"]*/?>" target="_blank">
                                                <i class="fa fa-external-link font-blue"></i> <?php /*echo _l("Open in new tab",$this); */?>
                                            </a>
                                        </li>-->
                                       <!-- <li>
                                            <a id="validateLink<?php /*echo $item['reservation_id']; */?>"
                                               class="validate-link-<?php /*echo $item['reservation_id']; */?>"
                                               href="javascript: toggleValidate('<?php /*echo $item['reservation_id']; */?>');"
                                               data-value="<?php /*echo $item["checked"]; */?>">
                                                <i class="fa <?php /*echo $item["checked"]!=1?"fa-check font-green":"fa-times font-yellow"; */?>"></i>
                                                <span><?php /*echo $item["checked"]!=1?_l("Make valid", $this):_l("Make invalid", $this); */?></span>
                                            </a>
                                        </li>-->

                                        <!--<li><a id="remindedLink<?php /*echo $item['reservation_id']; */?>" href="javascript: $.reminderRow('<?php /*echo $item['reservation_id']; */?>');"><i class="fa fa-bell font-green-haze"></i> <span><?php /*echo _l("Send reminder",$this); */?></span></a></li>-->

                                        <!--<li>
                                            <a class="closed-link-<?php /*echo $item['reservation_id']; */?> btn-ask"
                                               data-msg="<?php /*echo _l("panel_reservation_closed_confirmation",$this); */?>"
                                               href="javascript: toggleClosed('<?php /*echo $item["reservation_id"]; */?>');"
                                               data-value="<?php /*echo $item["closed"]; */?>">
                                                <i class="fa <?php /*echo $item["closed"]!=1?"fa-calendar-check-o font-purple-wisteria":"fa fa-undo"; */?>"></i>
                                                <span><?php /*echo $item["closed"]!=1?_l("Close", $this):_l("Reopen", $this); */?></span>
                                            </a>
                                        </li>-->
                                        <li><a><i class="fa fa-user"></i><?php echo _l("See Patient details",$this); ?></a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo base_url() ?>contact"><i class="fa fa-exclamation-triangle"></i><?php echo _l("Report a problem",$this); ?></a></li>
                                     <!--   <li><a class="btn-ask" data-msg="<?php /*echo _l("panel_reservation_cancel_confirmation",$this); */?>" href="<?php /*echo APPOINTMENT_ADMIN_URL."reservationAction/".$item["reservation_id"]."/cancel"; */?>"><i class="fa fa-ban font-red"></i> <?php /*echo _l("Cancel",$this); */?></a></li>-->

                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        </div>
        <?php if(!isset($data) || count($data) == 0){ ?>
            <div class="note note-info">
                <h4 class="block"><i class="icon-info"></i> <?php echo _l("Not found!",$this); ?></h4>
                <p><?php echo _l("There were no results from that report. You need to adjust your report parameters.",$this); ?></p>
            </div>
        <?php } ?>
        <?php echo isset($pagination)?$pagination:""; ?>
    </div>
</div>

<div class="modal fade" id="comments" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo _l('Information',$this); ?></h4>
            </div>
            <div class="modal-body">
                <p class="info"></p>
                <div class="comments"></div>
            </div>
        </div>
        <div class="modal-content loading">
            <div class="modal-body">
                <img src="<?php echo base_url(); ?>assets/nodcms/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span>&nbsp;&nbsp;<?php echo _l('Loading',$this); ?>... </span>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/nodaps/admin/reservation.js"></script>
<script>
    $(function(){
        // Show Reservation Info
        $('#comments').on('shown.bs.modal',function(){
            var reservationID = $(this).attr('data-id');
            var resultElement = $(this).find('.modal-content.content');
            var loadingElement = $(this).find('.modal-content.loading');
            loadingElement.show();
            resultElement.html('').hide();
            $.ajax({
                url: '<?php echo APPOINTMENT_ADMIN_URL; ?>reservationDetails/'+reservationID
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.status == 'success'){
                    loadingElement.hide();
                    resultElement.html(data.result).show();
                }else{
                    loadingElement.hide();
                    resultElement.show();
                    resultElement.html(data.error);
                }
            });
        }).on('hidden.bs.modal',function(){
            $(this).find('.modal-content.loading').show();
            $(this).find('.modal-content.content').html('');
        });
        $.showComments = function(reservationID){
            var type = $('#row' + reservationID).addClass('active');
            $('#comments').attr('data-id', reservationID).modal('show');
        };
    });

    $(function(){
        $.reminderRow = function(reservationID){
            $.ajax({
                url: '<?php echo APPOINTMENT_ADMIN_URL; ?>reservationAction/' + reservationID + '/remind',
                beforeSend: function(){
                    Metronic.blockUI({
                        target: '#row' + reservationID,
                        animate: true
                    });
                },
                complete: function(){
                    Metronic.unblockUI('#row' + reservationID);
                }
            }).done(function(data){
                data = JSON.parse(data);
                if(data.status == 'success'){
                    if($('#reminded' + reservationID).length > 0){
                        $('#reminded' + reservationID).text(data.count);
                    }else{
                        $('<span/>', {'class':'badge bg-green-haze', 'id':'reminded'+reservationID}).text(data.count).appendTo('#row'+reservationID+' td:nth-child(11)');
                    }
                    toastr['success']("<?php echo _l('Reminder email was sent successfully!', $this); ?>", "<?php echo _l("Success",$this); ?>");
                }else{
                    toastr['error'](data.error, "<?php echo _l("Error",$this); ?>");
                }
            }).fail(function(){
                toastr['error']("<?php echo _l("There is some system errors! Please report it.", $this); ?>", "<?php echo _l("Error",$this); ?>");
            });
        };


        $('.table tr').mouseover(function(){
            $('.table tr').removeClass('active');
        });

        // Search row
        SearchReservationRow("<?php echo APPOINTMENT_ADMIN_URL; ?>reservation", "<?php echo str_replace(array("d","m","Y"),array("dd","mm","yyyy"), $this->_website_info["date_format"])?>");
    });

    // Toggle action function
    var makeToggleAction = function ( URL, elementID ) {
        $(function(){
            $(elementID).actionsOnAppointments( '<?php echo APPOINTMENT_ADMIN_URL; ?>reservationAction/' ,{
                successFunction : function(thisElement){
                    if($(elementID + '-icon').hasClass('fa-check')) {
                        $(elementID + '-icon').attr('class', 'fa fa-times font-yellow')
                    }else if($(elementID + '-icon').hasClass('fa-times')){
                        $(elementID + '-icon').attr('class', 'fa fa-check font-green')
                    }
                    if($('#closeIcon' + thisElement.data('id')).hasClass('fa-check')) {
                        $('#closeIcon' + thisElement.data('id')).attr('class', 'fa fa-times font-yellow')
                    }else if($('#closeIcon' + thisElement.data('id')).hasClass('fa-times')){
                        $('#closeIcon' + thisElement.data('id')).attr('class', 'fa fa-check font-green')
                    }
                    if($("#calendar").length > 0){
                        $("#calendar").fullCalendar( 'refetchEvents' );
                    }
                }
            });
        });
    };
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