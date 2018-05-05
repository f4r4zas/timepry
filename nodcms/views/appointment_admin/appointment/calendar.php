<link href="<?php echo base_url(); ?>assets/metronic/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet"/>
<style>
.banner_wrapper{
	    height: 138px !important;
}
.portlet.box.blue-hoki {
    padding-top: 82px !important;
}
</style>

<div class="portlet box blue-hoki calendar">
    <div class="portlet-title">
        <div class="caption">
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
                <!-- BEGIN DRAGGABLE EVENTS PORTLET-->
                <?php /*
            <div class="col-md-3 col-sm-12">
                <div id="external-events">
                    <form class="inline-form">
                        <input type="text" value="" class="form-control" placeholder="Event Title..." id="event_title"/><br/>
                        <input type="text" value="" class="form-control" placeholder="<?php echo _l('First Name',$this); ?>..." id="fname"/><br/>
                        <input type="text" value="" class="form-control" placeholder="<?php echo _l('Last Name',$this); ?>..." id="lname"/><br/>
                        <input type="text" value="" class="form-control" placeholder="<?php echo _l('Email',$this); ?>..." id="email"/><br/>
                        <input type="text" value="" class="form-control" placeholder="<?php echo _l('Phone',$this); ?>..." id="phone"/><br/>
                        <section class="form-control" placeholder="<?php echo _l('Service',$this); ?>..." id="service"></section><br/>
                        <a href="javascript:;" id="event_add" class="btn default">
                            Add Event </a>
                    </form>
                    <hr/>
                    <div id="event_box">
                    </div>
                    <label for="drop-remove">
                        <input type="checkbox" id="drop-remove"/>remove after drop </label>
                    <hr class="visible-xs"/>
                </div>
                <!-- END DRAGGABLE EVENTS PORTLET-->
            </div>
                */ ?>
            <div class="col-md-12">
                <div id="calendar" class="has-toolbar loading-calendar-box">
                </div>
            </div>
        </div>
        <!-- END CALENDAR PORTLET-->
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
                <span>&nbsp;&nbsp;<i class="fa-li fa fa-spinner fa-spin"></i> <?php echo _l('Loading',$this); ?>... </span>
            </div>
        </div>
    </div>
</div>
<div id="popoverTheme" class="hidden">
    <div>
        <span class="name">
            Name:
        </span>:
        <span class="value bold">
            Value
        </span>
    </div>
</div>
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
</script>
<script src="<?php echo base_url(); ?>assets/nodaps/admin/reservation.js"></script>

<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/fullcalendar/fullcalendar.js"></script>
<script src="<?php echo base_url(); ?>assets/metronic/global/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<script>

    var Calendar = function() {
        return {
            //main function to initiate the module
            init: function() {
                Calendar.initCalendar();
            },

            initCalendar: function() {

                if (!jQuery().fullCalendar) {
                    return;
                }
            }

        };

    }();
    $(function() {
        var changeDate = function(reservationID,startDate,endDate,stopFunction){
            $.ajax({
                url: '<?php echo APPOINTMENT_ADMIN_URL; ?>reservationAction/'+reservationID+'/change',
                data:{
                    'start':startDate,
                    'end':endDate
                },
                method:'post'
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.status != 'success'){
                    alert(data.error);
                    stopFunction();
                }
            });
        };

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var h = {};
        if (Metronic.isRTL()) {
            if ($('#calendar').parents(".portlet").width() <= 720) {
                $('#calendar').addClass("mobile");
                h = {
                    right: 'title, prev, next',
                    center: '',
                    left: 'agendaDay, agendaWeek, month, today'
                };
            } else {
                $('#calendar').removeClass("mobile");
                h = {
                    right: 'title',
                    center: '',
                    left: 'agendaDay, agendaWeek, month, today, prev,next'
                };
            }
        } else {
            if ($('#calendar').parents(".portlet").width() <= 720) {
                $('#calendar').addClass("mobile");
                h = {
                    left: 'title, prev, next',
                    center: '',
                    right: 'today,month,agendaWeek,agendaDay'
                };
            } else {
                $('#calendar').removeClass("mobile");
                h = {
                    left: 'title',
                    center: '',
                    right: 'prev,next,today,month,agendaWeek,agendaDay'
                };
            }
        }

        var initDrag = function(el) {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim(el.text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            el.data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            el.draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0 //  original position after the drag
            });
        };

        var addEvent = function(title) {
            title = title.length === 0 ? "Untitled Event" : title;
            var html = $('<div class="external-event label label-default">' + title + '</div>');
            jQuery('#event_box').append(html);
            initDrag(html);
        };

        $('#external-events div.external-event').each(function() {
            initDrag($(this));
        });

        $('#event_add').unbind('click').click(function() {
            var title = $('#event_title').val();
            addEvent(title);
        });


        var makePopoverContent = function(data){

            console.log("name");
            console.log(data);

            var result = "";
            var contentTheme = $("#popoverTheme");
            contentTheme.find(".name").text("Name");
            contentTheme.find(".value").text(data.fname+' '+data.lname);
            result += contentTheme.html();
            contentTheme.find(".name").text("Service");
            contentTheme.find(".value").text(data.service_name);
            result += contentTheme.html();
            contentTheme.find(".name").text("Price");
            contentTheme.find(".value").text(data.price);
            result += contentTheme.html();
            contentTheme.find(".name").text("Email");
            contentTheme.find(".value").text(data.email);
            result += contentTheme.html();
            contentTheme.find(".name").text("Phone");
            contentTheme.find(".value").text(data.tel);
            result += contentTheme.html();
            contentTheme.find(".name").text("Validated");
            if(data.checked != 1){
                contentTheme.find(".value").html('<i class="validate fa fa-times font-yellow"></i>');
            }else{
                contentTheme.find(".value").html('<i class="fa fa-check font-green"></i>');
            }
            result += contentTheme.html();
            contentTheme.find(".name").text("PayPal Paid");
            if(data.paypal_paid != 1){
                contentTheme.find(".value").html('<i class="fa fa-times font-yellow"></i>');
            }else{
                contentTheme.find(".value").html('<i class="fa fa-check font-green"></i>');
            }
            result += contentTheme.html();
            result += '<small class="font-green"><?php echo _l("To see more info, double-click on the events", $this); ?></small>';
            return result;

        };
        //predefined events
        $('#event_box').html("");
        $('#calendar').fullCalendar('destroy'); // destroy the calendar
        $('#calendar').fullCalendar({ //re-initialize the calendar
            header: h,
            defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/
//            slotMinutes: 5,
            slotDuration: '<?php echo isset($slotDuration)?$slotDuration:"00:30:00"; ?>',
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function(date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                copiedEventObject.className = $(this).attr("data-class");

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: '<?php echo APPOINTMENT_ADMIN_URL; ?>calendar',
                    method: "POST",
                    data: {
                        // our hypothetical feed requires UNIX timestamps
                        start: start.unix(),
                        end: end.unix()
                    },
                    success: function(data) {
                        var events = [];
                        data = JSON.parse(data);
                        if(data.status=="success"){
                            $.each(data.data, function(index, value){
                                events.push({
                                    id: value.reservation_id,
                                    fn_dblclick: function(){
                                        $.showComments( value.reservation_id );
                                    },
                                    title: value.fname + ' ' + value.lname,
                                    start: new Date(value.reservation_date_time), // will be parsed
                                    end: new Date(value.reservation_edate_time), // will be parsed
                                    backgroundColor: Metronic.getBrandColor(value.bgcolor),
                                    description: value.service_name,
                                    popover: {
                                        html: true,
                                        content: makePopoverContent(value),
                                        placement: 'top'
                                    }
                                });
                            });
                            callback(events);
                        }
                    },
                    beforeSend: function(){
                        Metronic.blockUI({
                            target: $(".loading-calendar-box"),
                            animate: true
                        });
                    },
                    complete: function(){
                        Metronic.unblockUI($(".loading-calendar-box"));
                    }
                });
            },
            eventRender: function(event, element) {
//                element.myContextMenu(event.context);
                element.dblclick(event.fn_dblclick);
                element.popover(event.popover)
                    .mouseover(function(){
                        $(this).popover("show");
                    }).mouseleave(function(){
                        $(this).popover("hide");
                    });
            },
            eventDrop: function(event, delta, revertFunc) {
                changeDate(event.id,event.start.format(),event.end.format(),revertFunc);
            },
            eventResize: function(event, delta, revertFunc) {
                changeDate(event.id,event.start.format(),event.end.format(),revertFunc);
            }
        });
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
