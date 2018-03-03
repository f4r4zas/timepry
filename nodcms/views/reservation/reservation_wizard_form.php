<?php if(isset($data_list) && count($data_list)!=0){ ?>
    <?php include __DIR__."/form_elements.php"; ?>
    <?php if($this->session->flashdata('error_message')){ ?>
        <div class="note note-danger">
            <p>
                <?php echo $this->session->flashdata('error_message'); ?>
            </p>
        </div>
    <?php } ?>
    <div class="note note-danger" id="error" style="display: none"><i class="fa fa-warning"></i> <p style="display: inline"></p></div>
    <div class="steps" id="step1">
        <div class="note note-info">
            <p><b><?php echo _l("Step 1.", $this); ?></b> <?php echo _l("Please choose a service.", $this); ?></p>
        </div>
        <div class="">
            <?php $i=0; foreach($data_list as $item){ $i++; $right_pic=($i>2)?1:0; if($i>4){ $i=1; } ?>
                <div class="portfolio-block">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="portfolio-text">
                                <div class="portfolio-text-info">
                                    <h4><?php echo $item['service_name']?></h4>
                                    <p>
                                        <?php echo $item['service_description']?>
                                        <?php if($item['price_show']){ ?>
                                            <strong class="font-purple-seance"><?php echo $item['price']?></strong>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="portfolio-btn">
                                <a class="btn bigicn-only" href="javascript:;" onclick="$(function(){ $.chooseService(<?=$item["service_id"]?>) });">
                                    <span><?php echo _l('Choose', $this); ?> </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="steps" id="step2" style="display: none;">
        <div class="note note-info">
            <p><b><?php echo _l("Step 2.", $this); ?></b> <?php echo _l("Please choose a free date.", $this); ?></p>
        </div>
        <div class="form-group">
            <div id="date_pick"></div>
        </div>
        <button type="button" class="btn btn-default" onclick="$.backTo('step1');"><i class="fa fa-arrow-circle-left"></i> <?php echo _l('Back',$this); ?></button>
    </div>

    <div class="steps" id="step3" style="display: none;">
        <div class="note note-info">
            <p><b><?php echo _l("Step 3.", $this); ?></b> <?php echo _l("Please fill the below form.", $this); ?></p>
        </div>
        <?php echo form_open('',array('id'=>'post_form')); ?>
        <input name="date" id="date_pick_input" type="hidden">
        <div class="form-group">
            <label><?php echo _l("Date",$this)?></label>
            <p id="date_pick_label"></p>
        </div>
        <div class="form-group">
            <label><?php echo _l("Time",$this)?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                <select name="time" id="time_pick" class="form-control "></select>
            </div>
        </div>
        <div class="form-group">
            <label><?php echo _l("First Name",$this)?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-i-cursor"></i></div>
                <input name="fname" id="fname" type="text" class="form-control" data-validation="required">
            </div>
        </div>
        <div class="form-group">
            <label><?php echo _l("Last Name",$this)?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-i-cursor"></i></div>
                <input name="lname" id="lname" type="text" class="form-control" data-validation="required">
            </div>
        </div>
        <div class="form-group">
            <label><?php echo _l("Email Address",$this)?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-at"></i></div>
                <input name="email" id="email" type="text" class="form-control" data-validation="required email">
            </div>
        </div>
        <div class="form-group">
            <label><?php echo _l("Phone Number",$this)?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                <input name="phone" id="phone" type="text" class="form-control" data-validation="required number">
            </div>
        </div>
        <?php
        if(isset($extra_fields) && count($extra_fields)!=0){
            foreach($extra_fields as $item){
                $input_form =  'input_'.strtolower($item['type_name']).'_form_validation';
                $input_form('extra_field'.$item['id'],$item['title_caption'],$item['require'],$item['min'],$item['max']);
            }
        }
        ?>
        <div class="form-group">
            <button type="button" class="btn btn-default" onclick="$.backTo('step2');"><i class="fa fa-arrow-circle-left"></i> <?php echo _l('Back',$this); ?></button>
            <button type="submit" class="btn btn-success"><?php echo _l("Submit",$this); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>

    <div class="steps" id="step_success" style="display: none;">
        <div class="content"></div>
        <button type="button" class="btn btn-default" onclick="$.backTo('step1');"><i class="fa fa-refresh"></i> <?php echo _l('Set new appointment',$this); ?></button>
        <button class="btn btn-success hidden-print" type="button" onclick="window.print();"><i class="fa fa-print"></i> <?php echo _l('Print Page',$this); ?></button>
    </div>

    <script src="<?php echo base_url(); ?>assets/form-validator/jquery.form-validator.js"></script>
    <script>
        $(function(){
            var serviceID = 0;
            var allow_days = [];
            var disable_dates = [];
            $.chooseService = function( serviceId ) {
                $('#error').hide();
                if(serviceId!=''){
                    Metronic.blockUI({
                        target: '#reservation_wizard_form',
                        animate: true
                    });
                    serviceID = serviceId;
                    $('#post_form').attr("action","<?php echo base_url().$lang.$this->provider_prefix ?>/set_appointment/" + serviceID);
                    $.post("<?php echo base_url().$lang.$this->provider_prefix ?>/get_service/" + serviceId ,{},function(data){
                        data = JSON.parse(data);
                        if(data.status=="success"){
                            allow_days = data.allow_days;
                            disable_dates = data.disable_dates;
                            $('#step1').slideUp(500);
                            $('#step2').slideDown(500);
                            $( "#date_pick" ).datepicker('refresh');
                        }else{
                            $('#error').show().find('p').text(data.error);
                        }
                        Metronic.unblockUI('#reservation_wizard_form');
                    }).fail(function(e){
                        $('#error').show().find('p').text('<?php echo _l('There is some error from system! Please try later.',$this); ?>');
                        Metronic.unblockUI('#reservation_wizard_form');
                    });
                }
            };
            var setTimePick = function( selectedDate ) {
                if(selectedDate!='' && serviceID != 0){
                    Metronic.blockUI({
                        target: '#reservation_wizard_form',
                        animate: true
                    });
                    $("#date_pick_input").val(selectedDate);
                    $("#date_pick_label").text(selectedDate);
                    $('#form_elements').removeClass('pullDown');
                    $('#error').hide();
                    $.post("<?php echo base_url().$lang.$this->provider_prefix ?>/reservation/get_times/" + serviceID,{"date":selectedDate},function(data){
                        data = JSON.parse(data);
                        if(data.status=="success"){
                            $('#time_pick').html('');
                            $.each(data.times,function(key,value){
                                $('<option/>').text(value).attr("value",value).appendTo('#time_pick');
                            });
                            $('#step2').hide();
                            $('#step3').slideDown(500);
                            //                        $('#step3').addClass('pullDown');
                        }else{
                            $('#time_pick').html('');
                            //                        $('#step3').removeClass('pullDown');
                            $('#step3').hide();
                            $('#step2').show();
                            alert(data.error);
                        }
                        Metronic.unblockUI('#reservation_wizard_form');
                    }).fail(function(){
                        $('#error').show().find('p').text("Request fail!");
                        Metronic.unblockUI('#reservation_wizard_form');
                    });
                }
            };
            $( "#date_pick" ).datepicker({
                minDate: 1,
                dateFormat: "<?php echo str_replace(array("d","m","Y"),array("dd","mm","yy"), $this->_website_info["date_format"])?>",
                beforeShowDay: function(date) {
                    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    var availableDay = (allow_days.indexOf(date.getDay()) != -1) && (disable_dates.indexOf(string) == -1);
                    if(availableDay){
                        return [true,"",""];
                    }else{
                        return [false,"",""];
                    }
                },
                onSelect: setTimePick
            });
            //        $('#form_elements').hide();
            $.backTo = function(stepName){
                $('#' + stepName).show();
                $('.steps:not(#' + stepName + ')').hide();
            };
            var reservationPOST = function(){
                $('#error').hide();
                $.ajax("<?php echo base_url().$lang.$this->provider_prefix ?>/set_appointment/" + serviceID,
                    {
                        data: {
                            "date":$('#date_pick_input').val(),
                            "time":$('#time_pick').val(),
                            "fname":$('#fname').val(),
                            "lname":$('#lname').val(),
                            "email":$('#email').val(),
                            "tel":$('#phone').val(),
                            <?php
                            if(isset($extra_fields) && count($extra_fields)!=0){
                                foreach($extra_fields as $item){
                                    ?>
                            "extra_field<?php echo $item['id']; ?>": $("#extra_field<?php echo $item['id']; ?>").val(),
                            <?php
                                }
                            }
                            ?>
                        },
                        type: 'post',
                        beforeSend: function(){
                            Metronic.blockUI({
                                target: '#reservation_wizard_form',
                                animate: true
                            });
                        },
                        complete: function(){
                            Metronic.unblockUI('#reservation_wizard_form');
                        },
                        success: function(data){
                            data = JSON.parse(data);
                            if(data.status=="success"){
                                $('#step_success').show().find('.content').html(data.result);
                                $('#step3').hide();
                                $('#date_pick_input').val('');
                                $('#time_pick').val('');
                                $('#fname').val('');
                                $('#lname').val('');
                                $('#email').val('');
                                $('#phone').val('');
                                <?php
                                if(isset($extra_fields) && count($extra_fields)!=0){
                                    foreach($extra_fields as $item){
                                        if($item['field_type']!=5){
                                            echo '$("#extra_field'.$item['id'].'").val(""); ';
                                        }else{
                                            echo '$("#extra_field'.$item['id'].'").prop("checked",false); ';
                                        }
                                    }
                                }
                                ?>
                                $( "#date_pick" ).datepicker('refresh');
                            }else{
                                $('#error').show().find('p').html(data.error);
                                $('#step3').show();
                            }
                        },
                        error: function(){
                            $('#error').show().find('p').text("Request fail!");
                        }
                    });
            };
            $.validate({
                onSuccess: function(){
                    reservationPOST();
                    return false;
                },
                <?php if(in_array($lang, array('en','de','es','fr','sv'))){ ?>lang: '<?php echo $lang; ?>'<?php } ?>
            });
        });
    </script>
<?php }else{ ?>
    <div class="note note-warning">
        <p><i class="icon-info"></i> <?php echo _l('This provider has not any services for reservation! ', $this); ?></p>
    </div>
<?php } ?>
