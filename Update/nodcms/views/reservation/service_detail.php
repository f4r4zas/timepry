<div class="page-title">
    <div class="container">
        <h1><?php echo $title; ?></h1>
    </div>
</div>
<div class="page-sub-title">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="<?=base_url().$lang?>"><i class="fa fa-home"></i> <?=_l("Home",$this)?></a></li>
            <li><a href="<?=base_url().$lang?>/reservation/services"><?=_l('Services',$this)?></a></li>
            <li class="active"><?php echo $title; ?></li>
        </ul>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-xs-12">
            <p><img src="<?=base_url()?><?=(isset($data['image']) && $data['image']!="")?$data['image']:$settings['default_image']?>" alt="<?=$title?>" title="<?=$title?>" style="width:100%;"/></p>
            <?php if(isset($extension_data['full_description']) && $extension_data['full_description']!=''){ ?>
                <div><?=$extension_data['full_description']?></div>
            <?php }elseif(isset($enable_languages) && count($enable_languages)!=0){ ?>
                <h4><?php echo _l('Description for this service is just in these languages available!',$this); ?></h4>
                <?php foreach($enable_languages as $item){?>
                    <a href="<?php echo base_url().$item['code']; ?>/reservation/service/<?php echo $data['service_id']; ?>"><img style="width:36px;" src="<?php echo base_url().$item['image']?>" title="<?php echo $item['language_name']; ?>" alt="<?php echo $item['language_name']; ?>"> <?php echo $item['language_name']; ?></a>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="col-sm-4 col-xs-12">
            <div class="panel">
                <h3 class="panel-heading"><?php echo _l("Reservation Form",$this); ?></h3>
                <div class="panel-body">
                    <?php if($this->session->flashdata('error_message')){ ?>
                        <div class="alert alert-danger">
                            <i class="fa fa-times-circle"></i>
                            <?php echo $this->session->flashdata('error_message'); ?>
                        </div>
                    <?php } ?>
                    <?php if($this->session->flashdata('success_message')){ ?>
                        <div class="alert alert-success">
                            <i class="fa fa-check"></i>
                            <?php echo $this->session->flashdata('success_message'); ?>
                        </div>
                    <?php } ?>
                    <?php echo form_open('',array('id'=>'post_form')); ?>
                    <div class="form-group">
<!--                        <div id="date_pick"></div>-->
                        <label><?php echo _l("Date",$this)?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input id="date_pick" class="form-control" readonly>
                            <label for="date_pick" class="input-group-addon btn"><i class="fa fa-hand-pointer-o"></i> <?php echo _l('Choose a Date...',$this); ?></label>
                        </div>
                        <input id="date_pick_input" name="data[date]" type="hidden">
                    </div>
                    <div id="form_elements">
                        <div class="form-group">
                            <label><?php echo _l("Time",$this)?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                <select id="time_pick" name="data[time]" class="form-control "></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l("First Name",$this)?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-i-cursor"></i></div>
                                <input name="data[fname]" type="text" class="form-control" data-validation="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l("Last Name",$this)?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-i-cursor"></i></div>
                                <input name="data[lname]" type="text" class="form-control" data-validation="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l("Email Address",$this)?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-at"></i></div>
                                <input id="email" name="data[email]" type="text" class="form-control" data-validation="required email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo _l("Phone Number",$this)?></label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                <input name="data[tel]" type="text" class="form-control" data-validation="required number">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><?php echo _l("Submit",$this); ?></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        var setTimePick = function( selectedDate ) {
            if(selectedDate!=''){
                $("#date_pick_input").val(selectedDate);
                $('#form_elements').removeClass('pullDown');
                $.post("<?php echo base_url().$lang ?>/reservation/get_times/<?php echo $data["service_id"]; ?>",{"date":selectedDate},function(data){
                    data = JSON.parse(data);
                    if(data.status=="success"){
                        $('#time_pick').html('');
                        $.each(data.times,function(key,value){
                            $('<option/>').text(value).attr("value",value).appendTo('#time_pick');
                        });
//                        $('#form_elements').slideDown(500);
                        $('#form_elements').addClass('pullDown');
                    }else{
                        $('#time_pick').html('');
                        $('#form_elements').removeClass('pullDown');
//                        $('#form_elements').hide();
                        alert(data.error);
                    }
                })
            }
        };
        var allow_days = <?php echo isset($allow_days)?$allow_days:"[]"; ?>;
        var disable_dates = <?php echo isset($disable_dates)?$disable_dates:'[]'; ?>;
        $( "#date_pick" ).datepicker({
            minDate: 1,
            dateFormat: 'dd.mm.yy',
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
    });
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.8/jquery.form-validator.min.js"></script>
<script>
    $.validate({
        <?php if($lang!='en'){ ?>lang: '<?php echo $lang; ?>'<?php } ?>
    });
</script>