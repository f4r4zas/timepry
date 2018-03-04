<style>
#beforeCheckout_popout{
    position: absolute;
}
#map{
    height:370px;
}

#beforeCheckout_popout .schedule_calender{
    padding-top: 0px;
}

#selected_services .selservice_box {
    cursor: pointer;
}

.bottom-booknow{
    margin-top: 20px;
    position: fixed;
    width: 100%;
    bottom: 0;
    z-index: 9999;
    left: 0;
    display: none;
}
.se-pre-con{
    z-index: 9999999;
}
</style>
<section class="inner-page-banner">
    <div class="banner_wrapper">
        <div class="banner_content">
            <h1>Listing Detail</h1>
        </div>
    </div>
</section>

<div id="listing-page">
    <section class="listing-content">

        <!--<div class="images">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="banner-img">
                            <ul id="b-images">
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                            </ul>
                        </div>
                        <div class="dental-gallery">
                            <ul id="g-images">
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                                <li><img src="images/listing-banner.jpg" alt="Gallery" width="100%"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="container" style="margin-top: 20px;">

            <div class="row">
                <div class="col-md-4">
                    <div class="listing-leftside">
                        <div class="listing-map">
                            <section id="map" style="370px">

                            </section>
                            <!--<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10499.966498430253!2d2.2944813!3d48.8583701!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8ddca9ee380ef7e0!2sEiffel+Tower!5e0!3m2!1sen!2s!4v1510068304846" width="100%" height="370" frameborder="0" style="border:0" allowfullscreen></iframe>-->
                        </div>

                    </div>
                </div>

                <div class="col-md-8">
                    <div class="listing-rightside">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="dental-title"><?php echo $this->provider['provider_name']; ?></div>
                                <!--<div class="ratings">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>-->
                                <div class="dental-address"><?php echo $this->provider['address']; ?></div>

                                <div class="description">
                                    <div class="section-heading">
                                        <h1>Description</h1>
                                        <div class="cus-hr"></div>
                                    </div>

                                    <div class="desc_content">
                                        <p>
                                            <?php echo $this->provider['provider_description']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="dental_contact">
                                    <div class="dental-phone">
                                        <i class="fa fa-phone"></i>
                                        <a href="tel:<?php echo $this->provider['phone']; ?>"><?php echo $this->provider['phone']; ?></a>
                                    </div>
                                    <div class="email">
                                        <i class="fa fa-envelope"></i>
                                        <a href="mailto:<?php echo $this->provider['provider_email']; ?>"><?php echo $this->provider['provider_email']; ?></a>
                                    </div>
                                    <?php if(!empty($this->provider['website'])):?>
                                    <div class="website">
                                        <i class="fa fa-globe"></i>
                                        <a href="<?php echo $this->provider['website']; ?>" target="_blank"><?php echo $this->provider['website']; ?></a>
                                    </div>
                                    <?php endif;?>                                    
                                </div>

                                <div class="opening-timings">
                                    <div class="section-heading">
                                        <h1>Timings</h1>
                                        <div class="cus-hr"></div>
                                    </div>
                                    
                                    <?php foreach($do_time as $timming):?>

                                    <div class="timings">
                                        <span class="day"><?php echo $timming['day'];?></span>
                                        <?php if($timming['closed'] == 0):?>
                                        <span class="time"><?php echo date("H:i",mktime(0,$timming['opening']));?> - <?php echo date("H:i",mktime(0,$timming['closing']));?></span>
                                        <?php else:?>
                                        <span class="time">Closed</span>
                                        <?php endif;?>
                                    </div>
                                    <?php endforeach;?>
                                    <!--<div class="timings">
                                        <span class="day">Monday</span>
                                        <span class="time">10:00 - 06:00</span>
                                    </div>
                                    <div class="timings">
                                        <span class="day">Tuesday</span>
                                        <span class="time">10:00 - 06:00</span>
                                    </div>
                                    <div class="timings">
                                        <span class="day">Wednesday</span>
                                        <span class="time">10:00 - 06:00</span>
                                    </div>
                                    <div class="timings">
                                        <span class="day">Thursday</span>
                                        <span class="time">10:00 - 06:00</span>
                                    </div>
                                    <div class="timings">
                                        <span class="day">Friday</span>
                                        <span class="time">Closed</span>
                                    </div>
                                    <div class="timings">
                                        <span class="day">Saturday</span>
                                        <span class="time">Closed</span>                                        
                                    </div>-->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="treatments">
                        <div class="section-heading">
                            <h1>Treatments</h1>
                            <div class="cus-hr"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="treatment-tabs">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#step1">Hygiene Procedure <span class="count"></span></a>
                            </li>
                            <!--<li>
                                <a data-toggle="tab" href="#step2">Dental sealants <span class="count">(2)</span></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#step3">Sport Mouthguards <span class="count">(1)</span> </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#step4">Dental Space Maintainers <span class="count">(1)</span></a>
                            </li>-->
                        </ul>
                    </div>

                </div>

                <div class="col-md-offset-1 col-md-8">
                    <div class="tab-content">

                        <div class="tab-pane fade in active">
                            
                            <?php

            /*                echo "<pre>";
print_r($data_list);
echo "</pre>";

*/

?>
                            
                        
                        <?php $fetched = array(); $i=0; foreach($data_list as $item){ $i++; $right_pic=($i>2)?1:0; if($i>4){ $i=1; } 
                        if(!in_array($item["title"],$fetched)){
                        ?>
                            <div class="treatment-box">
                                <div class="row">
                                
                                <span style="display: none;" class="serviceID"><?php echo $item["id"];?></span>

                                    <div class="col-md-8">
                                        <div class="treatment_content">
                                            <div class="treatment-title"><?php echo $item['title']?></div>
                                            <div class="duration"><?php echo $item['period_min']?> mins</div>
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <span class="rate">From <span class="prices"><?php echo $item['price']?></span></span>
                                        <span class="details_arrow">
                                            <i class="fa fa-chevron-up"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="treatment-details">
                                    <div class="row">
                                        <div class="detailsDiv active">
                                            <div class="col-sm-10 col-md-10">
                                                <div class="detail">
                                                    <p>
                                                        <?php echo $item['service_description']?> 
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-md-2">
                                                <div class="add_service">
                                                    <i class="fa fa-plus-square-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        <?php 
                        $fetched[] = $item["title"];
                            }
                        }
                         ?>

                            

                            <!--<div class="treatment-box">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="treatment_content">
                                            <div class="treatment-title">Cleaning Treatment</div>
                                            <div class="duration">40 mins <span>-</span> 50 mins</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="rate">From <span class="prices">$50</span></span>
                                        <span class="details_arrow">
                                            <i class="fa fa-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="treatment-details">
                                    <div class="row">
                                        <div class="detailsDiv">
                                            <div class="col-sm-10 col-md-10">
                                                <div class="detail active">
                                                    <p>
                                                        This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. 
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-md-2">
                                                <div class="add_service">
                                                    <i class="fa fa-plus-square-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="treatment-box">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="treatment_content">
                                            <div class="treatment-title">Cleaning Treatment</div>
                                            <div class="duration">40 mins <span>-</span> 50 mins</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="rate">From <span class="prices">$50</span></span>
                                        <span class="details_arrow">
                                            <i class="fa fa-chevron-down"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="treatment-details">
                                    <div class="row">
                                        <div class="detailsDiv">
                                            <div class="col-sm-10 col-md-10">
                                                <div class="detail active">
                                                    <p>
                                                        This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. 
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-md-2">
                                                <div class="add_service">
                                                    <i class="fa fa-plus-square-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->

                        </div>

                        <!--<div id="step2" class="tab-pane fade"></div>
                        <div id="step3" class="tab-pane fade"></div>
                        <div id="step4" class="tab-pane fade"></div>-->
                    </div>
                </div>
            </div>

            <!--<div class="listing-feedback">
                <div class="section-heading">
                    <h1>Feedbacks for Users</h1>
                    <div class="cus-hr"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="feedback-box">
                            <div class="feedback-header">
                                <span class="title">John Deo</span>
                                <span class="sep">-</span>
                                <span class="date">November 15 2017</span>
                            </div>
                            <div class="feedback-content">
                                <p>
                                    This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feedback-box">
                            <div class="feedback-header">
                                <span class="title">John Deo</span>
                                <span class="sep">-</span>
                                <span class="date">November 15 2017</span>
                            </div>
                            <div class="feedback-content">
                                <p>
                                    This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feedback-box">
                            <div class="feedback-header">
                                <span class="title">John Deo</span>
                                <span class="sep">-</span>
                                <span class="date">November 15 2017</span>
                            </div>
                            <div class="feedback-content">
                                <p>
                                    This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feedback-box">
                            <div class="feedback-header">
                                <span class="title">John Deo</span>
                                <span class="sep">-</span>
                                <span class="date">November 15 2017</span>
                            </div>
                            <div class="feedback-content">
                                <p>
                                    This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->

            <div class="bottom-booknow" style="margin-top: 20px;">
                <div class="row">
                    <div class="col-md-offset-2 col-md-8">
                        <div class="blue_back">
                            <div class="pane-inner">
                                <div class="booknow_prices">
                                    <span class="service_count" id="service_count">0</span>
                                    <span class="service_title">service</span>
                                    <span class="service_price">$<span id="service_price">0</span></span>
                                </div>
                                <div class="book_now_btn">
                                    <a href="javascript:void(0)" class="greyButton" id="services_booknow">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<div class="modal-box" id="beforeCheckout_popout">
    <div class="modal-inner">
        <div class="row">
        <h1 style="text-align: center; font-family: 'Lato', sans-serif; font-size: 17px; padding-left: 2px; font-weight: 400; color: #fff; padding-bottom: 20px;">Click on treatment on right then select dentist from dropdown and select start time for your appointment</h1>
            <div class="col-md-6">
            
             <div class="schedule_calender">
                <div class="steps dentist-select" id="step1" style="display: none;">
                
                    <select name="dentist_name" id="dentist_name">
                    <option value="">Select the dentist</option>
                    <?php /*foreach($practitioners as $practitioner):?>
                        
                        <!--<option value="dentist name">John Doe</option>
                        <option value="dentist name">Jeny Richel</option>
                        <option value="dentist name">Philips Muller</option>--->
                        <option value="<?php echo $practitioner['service_id'];?>"><?php echo $practitioner['service_name'];?></option>
                    <?php endforeach;*/?>
                    </select>
                </div>

                <div id="error">
            <p style="color: red; text-align: center;"></p>
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
            <!--<button type="submit" class="btn btn-success"><?php echo _l("Submit",$this); ?></button>-->
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
            var selectedtreatment_id = 0;            
            $('#dentist_name').change(function(){
                                
                if($(this).val() != ""){
                    
                    $.setPractitioner(selectedtreatment_id);                    
                    $.chooseService($(this).val());
                                        
                } else {
                    $.backTo('step1');
                }
            });
            
            $.setPractitioner = function(treatment_id) {
                
                $('.final_treatment_field'+treatment_id+'.practitionername').text($("#dentist_name option:selected").text());
             ;               
            }                         
            
            
            $.selectprac = function(treatment_id) {
                $("option.dentist_name").remove();
                $('#step1').slideUp(500);
                $.backTo('step1');
                
                $.post("<?php echo base_url().$lang.$this->provider_prefix ?>/get_practitioner/" + treatment_id ,{},function(data){
                        data = JSON.parse(data);
                        selectedtreatment_id = data.treatment_id;                        
                        if(data.status=="success"){
                            $.each(data.practitioners,function(key,value){
                                $('<option/>').text(value).attr("class","dentist_name").attr("value",key).appendTo('#dentist_name');
                            });
                            $("#step1").slideDown(500);
                        }else{
                            $('#error').show().find('p').text("practitioner not found");
                        }
                    }).fail(function(e){
                        $('#error').show().find('p').text('<?php echo _l('There is some error from system! Please try later.',$this); ?>');
                    });
                
                
                
            };
            
            $.chooseService = function( serviceId ) {
                $('#error').hide();
                if(serviceId!=''){
                    Metronic.blockUI({
                        target: '#reservation_wizard_form',
                        animate: true
                    });
                    serviceID = serviceId;
                    $('.final_treatment_field'+selectedtreatment_id+'.practitionername').text($("#dentist_name option:selected").text());                    
                    $('#post_form').attr("action","<?php echo base_url().$lang.$this->provider_prefix ?>/set_appointment/" + serviceID);
                    $.post("<?php echo base_url().$lang.$this->provider_prefix ?>/get_service/" + serviceId ,{},function(data){
                        data = JSON.parse(data);
                        if(data.status=="success"){
                            allow_days = data.allow_days;
                            disable_dates = data.disable_dates;
                            selectedtreatment_id = data.treatment_id;                            
                            $(".final_treatment_field"+data.treatment_id+".practitioner").val(serviceID);
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
                //console.log(serviceID);
                //console.log(selectedDate);
                if(selectedDate!='' && serviceID != 0){
                    //alert('setTimePick');
                    Metronic.blockUI({
                        target: '#reservation_wizard_form',
                        animate: true
                    });
                    $("#date_pick_input").val(selectedDate);
                    $("#date_pick_label").text(selectedDate);
                    $("span.final_treatment_field"+selectedtreatment_id+".date").text(selectedDate);                    
                    $(".final_treatment_field"+selectedtreatment_id+".date").val(selectedDate);
                    $('#form_elements').removeClass('pullDown');
                    $('#error').hide();
                    var selected_duration = [];
                    //alert(parseInt(selected_duration[0]))
                    var selected_times = [];
                    $('#checkout input.date').each(function(){
                        if($(this).val() == selectedDate){
                            var current_date_class = $(this).attr('class');
                            current_date_class = current_date_class.split(" ");
                            current_date_class = current_date_class[0];
                            
                            var duration = $('.'+current_date_class+'.duration').text().split(" ");
                            
                            if(!isNaN(parseInt(duration[0]))) {
                                selected_duration.push(parseInt(duration[0]));
                            } else {
                                selected_duration.push("");
                            }
                            if($('#checkout .'+current_date_class+'.time').val()){
                                selected_times.push($('#checkout .'+current_date_class+'.time').val());
                            }
                        }
                    });
                    
                    //console.log(selected_times);
                    //console.log(selected_duration);
                    
                    $.post("<?php echo base_url().$lang.$this->provider_prefix ?>/reservation/get_times/" + serviceID,{"date":selectedDate,'selected_times':selected_times,'selected_duration':selected_duration},function(data){
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
                        data: $('#checkout').serialize() 
                            //$("#myForm input").serialize(),
                            /*"date":$('#date_pick_input').val(),
                            "time":$('#time_pick').val(),
                            "fname":$('#fname').val(),
                            "lname":$('#lname').val(),
                            "email":$('#email').val(),
                            "tel":$('#phone').val(),*/
                            <?php
                            if(isset($extra_fields) && count($extra_fields)!=0){
                                ?>
                                +
                             <?php foreach($extra_fields as $item){
                                    ?>
                            "&extra_field<?php echo $item['id']; ?>=" $("#extra_field<?php echo $item['id']; ?>").val(),
                            <?php
                                }
                            }
                            ?>
                        ,
                        type: 'post',
                        beforeSend: function(){
                            $(".se-pre-con").fadeIn("slow");
                            Metronic.blockUI({
                                target: '#reservation_wizard_form',
                                animate: true
                            });
                        },
                        complete: function(){
                            Metronic.unblockUI('#reservation_wizard_form');
                        },
                        success: function(data){
                            $(".se-pre-con").fadeOut("slow");
                            data = JSON.parse(data);
                            if(data.status=="success"){
                                $('#step_success').show().find('.content').html(data.result);
                                $('#step3').hide();
                                $('#checkout .input-group input').val('');
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
                            $(".se-pre-con").fadeOut("slow");
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
            
            
            $('#time_pick').change(function(){
                //selectedtreatment_id
                $("span.final_treatment_field"+selectedtreatment_id+".time").text($(this).val());            
                $(".final_treatment_field"+selectedtreatment_id+".time").val($(this).val());
                
                var show_checkout = true;
                $('#checkout input.time').each(function(){
                    //$(this).val();
                    if($(this).val()==""){
                        show_checkout = false;
                        return false;
                    }
                });
                
                if(show_checkout == true){
                    $('#checkout').show();
                } else {
                    $('#checkout').hide();
                }
                
                            
            });                                    
        });
    </script>
                </div>
            </div>
            <div class="col-md-6">
                <div id="selected_services">
                <!--<div class="steps" id="step1">-->
                <?php $i=0; foreach($data_list as $item){ $i++; $right_pic=($i>2)?1:0; if($i>4){ $i=1; } ?>
                
                    
                
                <?php } ?>
                <!--</div>-->
                </div>
                <div class="addmore_services">
                    <i class="fa fa-plus-square-o"></i>Add another service
                </div>
                <div class="order_total">
                    <p>Order Total</p>                   
                    <p class="total_prices">$ <span class="rates">0</span></p>
                    <?php 
                    $this->db->select('*');
                    $this->db->from('users');
                    $this->db->where('user_id',$this->session->userdata('user_id'));
                    $query = $this->db->get();
                    $user_info = $query->result();?>
                    
                    
                    <form id="checkout" style="display: none;">
                        <div id="final_treatment"></div>                    
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
                        <div class="form-group" style="display: none;">
                            <label><?php echo _l("Email Address",$this)?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-at"></i></div>
                                <input name="email" id="email" type="text" class="form-control" data-validation="required email" value="<?php echo (!empty($user_info))?$user_info[0]->email:'';?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l("Phone Number",$this)?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                <input name="tel" id="phone" type="text" class="form-control" data-validation="required number">
                            </div>
                        </div>
                        <input type="submit" class="greyButton" value="Checkout"/>
                    
                    </form> 
                    <a style="display: none;" href="checkout.php" class="greyButton">Go to Checkout</a>
                </div>
            </div>
            <div id="step1"></div>
        </div>
    </div>
</div>


<!--<div class="container">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject bold"><?php echo $this->provider['provider_name']; ?></span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->provider['provider_description']; ?>
                    <ul class="list-inline blog-tags">
                        <?php if($this->provider['phone']!=''){ ?>
                            <li><i class="fa fa-phone font-blue-steel"></i> <span class="font-blue-hoki"><?php echo $this->provider['phone']; ?></span></li>
                        <?php } ?>
                        <?php if($this->provider['address']!=''){ ?>
                            <li><i class="fa fa-map-marker font-blue-steel"></i> <span class="font-blue-hoki"><?php echo $this->provider['address']; ?></span></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption ">
                                <span class="caption-subject bold uppercase"><?php echo _l('Reservation Form',$this); ?></span>
                            </div>
                        </div>
                        <div class="portlet-body" id="reservation_wizard_form">
                            <?php include __DIR__."/reservation_wizard_form.php"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZ6v5rVNIY_XwJfCdIntpT1jNj0wLVReY&sensor=false&extension=.js"></script> 
<script type="text/javascript"> 

   var address = '<?php echo $this->provider['address']; ?>';

   var map = new google.maps.Map(document.getElementById('map'), { 
       mapTypeId: google.maps.MapTypeId.TERRAIN,
       zoom: 14
   });

   var geocoder = new google.maps.Geocoder();

   geocoder.geocode({
      'address': address
   }, 
   function(results, status) {
      if(status == google.maps.GeocoderStatus.OK) {
         new google.maps.Marker({
            position: results[0].geometry.location,
            map: map,
            icon: '<?php echo base_url();?>assets/front/images/teeth_marker.png'
         });
         map.setCenter(results[0].geometry.location);
      }
   });

   </script>
