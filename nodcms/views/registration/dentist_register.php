<style>
.registration-tabs input.update4[type=text], .registration-tabs input.update4[type=password], .registration-tabs textarea.update4, .select2-container{
    background: #ddd;
}

.select2-container{
    /*padding-top: 15px;*/
    border: 0px !important;
    width: 100% !important;
}

.select2-container--default .select2-search--inline .select2-search__field{
        background-color: transparent !important;
        font-size: 15px;
        width: 100% !important;
}

.select2-container--default .select2-selection--multiple {
    background-color: transparent;
    border: 0px solid #ddd;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 0px solid #ddd;
}
</style>

<section class="inner-page-banner">
    <div class="banner_wrapper">
        <div class="banner_content">
            <h1>Register</h1>
        </div>
    </div>
</section>

<section class="register-dentist dentist_registration">
    <div class="container">
        <div class="row">
            <div class="section-heading">
                <h1>Register As A Dentist</h1>
                <div class="cus-hr"></div>
            </div>
            <div class="registration-tabs">
                <ul class="nav nav-tabs">
                
                    <li <?php echo($step == 1 ?'class="active"':'');?>><a data-toggle="tab" href="#step1"><span class="big">1</span> Personal Data</a></li>
                    <li <?php echo($step == 2 ?'class="active"':'');?><?php echo($step > 1 ?'':'class="disabled"');?>><a <?php echo($step > 1 ?'data-toggle="tab"':'');?> href="#step2"><span class="big">2</span> Dental Office Information</a></li>
                    <li <?php echo($step == 3 ?'class="active"':'');?><?php echo($step > 2 ?'':'class="disabled"');?>><a <?php echo($step > 2 ?'data-toggle="tab"':'');?> href="#step3" id="loadMap"><span class="big">3</span> Dental Office Address</a></li>
                    <li <?php echo($step == 4 ?'class="active"':'');?><?php echo($step > 3 ?'':'class="disabled"');?>><a <?php echo($step > 3 ?'data-toggle="tab"':'');?> href="#step4"><span class="big">4</span> Price List</a></li>
                    <li <?php echo($step == 5 ?'class="active"':'');?><?php echo($step > 4 ?'':'class="disabled"');?>><a <?php echo($step > 4 ?'data-toggle="tab"':'');?> href="#step5"><span class="big">5</span> Pictures</a></li>
                </ul>

                <div class="tab-content">
                    <div id="step1" class="tab-pane <?php echo($step == 1 ?'in active ':'');?>fade ">
                        <form id="update1" method="post" action="<?php echo base_url();?>register/dentist-registration/2" role="form">
                        
            <div class="row">
                <div class="col-sm-6">
                    <input placeholder="First Name" value="" name="fname" id="fname" type="text" class="form-control update1">
                    
                        <span class="help-block"><?php echo _l('Please enter your first name just with alphabet and space.', $this); ?></span>
                    
                </div>
                <div class="col-sm-6">
                    <input placeholder="Last Name" value="" name="lname" id="lname" type="text" class="form-control update1">
                    
                        <span class="help-block"><?php echo _l('Please enter your last name just with alphabet and space.', $this); ?></span>
                                     
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <input placeholder="Email" value="" name="email" id="email" type="text" class="form-control update1">
                    
                        <span class="help-block"><?php echo _l('Please enter your email address. It should be unique in this system.', $this); ?></span>
                                        
                </div>
                <div class="col-sm-6">
                    <input placeholder="Phone" value="" name="mobile" id="mobile" type="text" class="form-control update1">
                    
                        <span class="help-block"><?php echo _l('Please enter your mobile number.', $this); ?></span>
                                      
                </div>
            </div>
            <div class="row">
                
                <div class="col-sm-6">
                    <input placeholder="Password" value="" name="password" id="password" type="password" class="form-control update1">
                    
                        <span class="help-block"><?php echo _l('Please enter a password between 6 and 16 character for your account.', $this); ?></span>
                                      
                </div>
                
                <div class="col-sm-6">
                    <input placeholder="Confirm Password" value="" name="cpassword" id="cpassword" type="password" class="form-control update1">
                    
                        <span class="help-block"><?php echo _l('Please re-enter password.', $this); ?></span>
                                     
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="submit-btn">
                    <button type="submit" class="greyButton">Submit</button>
                    </div>
                </div>
            </div>
        </form>
        

                    </div>

                    <div id="step2" class="tab-pane <?php echo($step == 2 ?'in active ':'');?>fade">
                     <form id="update2" method="post" action="<?php echo base_url();?>register/dentist-registration/3" role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <input placeholder="Name of the Dental Office *" value="" name="dental_officename" id="dental_officename" type="text" class="form-control update2">
                                
                                    <span class="help-block"><?php echo _l('Please enter dental office name just with alphabet and space.', $this); ?></span>
                                

                            </div>
                            <div class="col-md-6">
                            
                                <input placeholder="Website of Dental Office" value="" name="dental_officewebsite" id="dental_officewebsite" type="text" class="form-control update2">
                                
                                    <span class="help-block"><?php echo _l('Please enter dental office website if any with http:// or https://', $this); ?></span>
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input placeholder="Email of Dental Office" value="" name="dental_officeemail" id="dental_officeemail" type="text" class="form-control update2">
                                
                                    <span class="help-block"><?php echo _l('Please enter dental office email address.', $this); ?></span>
                                
                            </div>
                            <div class="col-md-6">
                                <input placeholder="Phone of Dental Office *" value="" name="dental_officephone" id="dental_officephone" type="text" class="form-control update2">
                                
                                    <span class="help-block"><?php echo _l('Please enter dental office username for page url.', $this); ?></span>
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <textarea placeholder="Description of Dental Office *" rows="6" name="dental_officedescription" id="dental_officedescription" class="form-control update2"></textarea>
                                
                                    <span class="help-block"><?php echo _l('Please enter description of dental office.', $this); ?></span>
                                
                                
                            </div>
                        </div>

                        <hr class="mod" style="margin:20px 0;border-color:#cccaca;">

                        <div id="practioners">
                            <h1>Name of practioners who work in Dental Office (minimum 1)</h1>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <select name="practitioners_title[]" id="practitioners_title" class="form-control update2">
                                        <option value="Dr.">Dr.</option>
                                        <option value="Prof. Dr.">Prof. Dr.</option>
                                        <option value="Assistant">Assistant</option>
                                        <option value="Dental Hygienist">Dental Hygienist</option>
                                    </select>
                                    <!--<input type="text" placeholder="Title *" name="practitioners_title[]" value="" id="practitioners_title" class="form-control update2">-->
                                    
                                        <span class="help-block"></span>
                                   
                                </div>
                                <div class="col-xs-8 col-sm-5">
                                    <input type="text" placeholder="Name and Surname *" name="practitioner_name[]" value="" id="practitioner_name" class="form-control update2">
                                    
                                        <span class="help-block"></span>
                                    
                                </div>
                                <div class="col-xs-4 col-sm-1 add_practitioner_main">
                                    <div class="add_practitioner_row">
                                        <i style="display:block; margin-top: 15px;" class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                                $('.add_practitioner_row').click(function(){
                                    var main_row = $(this).parent().parent();
                                    var cloned = main_row.clone();
                                    
                                    cloned.find('.add_practitioner_row').remove();
                                    cloned.find('.add_practitioner_main').html('<div class="remove_practitioner_row"><i style="display:block; margin-top: 15px;" class="fa fa-times"></i></div>');
                                    
                                    cloned.find('input').val('');
                                    cloned.find('select').val('Dr.');
                                    
                                    $(main_row).after(cloned);
                                });
                                
                                
                                $('body').on('click','.remove_practitioner_row',function(){
                                    $(this).parent().parent().remove();
                                });
                        </script>

                        <hr class="mod" style="margin:20px 0;border-color:#cccaca;">

                        <div id="opening_days">
                            <h1>Opening hours</h1>
                            
                            
                            <?php 
                            $days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
                            foreach($days as $k => $day):?>

                            <div class="row">
                                <div class="col-xs-8 col-sm-4">
                                    <input class="update2" disabled="disabled" type="text" value="<?=$day;?>" name="opening_day[]" placeholder="<?=$day;?>">
                                </div>
                                <div class="col-xs-12 col-sm-3 input-append">
                                    <input class="time update2 timePicker-from" id="timePicker-from-<?=$k?>" type="text" style="width: 80%;" placeholder="Opening hours * 08:00" name="openingHours[]">
                                    
                                    <!--<span class="add-on">
                                      <i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-time">
                                      </i>-->
                                    </span>
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-xs-12 col-sm-3 input-append">
                                    <input class="time update2 timePicker-to" id="timePicker-to-<?=$k?>" type="text" style="width: 80%;" placeholder="Closing hours * 14:00" data-format="hh:mm" name="closingHours[]">
                                    
                                    <!--<span class="add-on">
                                      <i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-time">
                                      </i>-->
                                    </span> 
                                    <span class="help-block"></span>                                   
                                </div>
                                <div class="col-xs-8 col-sm-2">
                                    <div class="closed_day">
                                        <span class="open fa fa-circle-o"></span>
                                        <span class="closed_label">Closed</span>
                                        <input class="closed_day_value update2" type="hidden" name="dayClosed[]"/>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-1">
                                    <!--<div class="add_day">
                                        <i class="fa fa-plus"></i>
                                    </div>-->
                                </div>
                            </div>
                            
                            <?php endforeach;?>
                            
                            <script type="text/javascript">
  $(function() {
    /*$('.datetimepicker3').datetimepicker({
      pickDate: false
    });*/
    
    $(".closed_day").click(function(){
        var value_field = $(this).find(".closed_day_value");
        var icon_value = $(this).find("span.fa");
        if($(this).children("span.open").length > 0){
            value_field.val("1");
            icon_value.removeClass("fa-circle-o");
            icon_value.removeClass("open");
            icon_value.addClass("fa-circle");
            icon_value.addClass("closed");
        } else {
           value_field.val("");
            icon_value.removeClass("fa-circle");
            icon_value.removeClass("closed");
            icon_value.addClass("fa-circle-o");
            icon_value.addClass("open"); 
        }
    });

    $(".timePicker-from").kendoTimePicker({format:"HH:mm"});
    $(".timePicker-to").kendoTimePicker({format:"HH:mm"});
  });
</script>
                            
                            
                        </div>

                        <div class="next_step">
                            <div class="this_step_btn">
                                <button type="submit" class="greyButton">Submit</button>
                            </div>
                        </div>
                        
                        
                        </form>

                    </div> 
                    
                    <div id="step3" class="tab-pane <?php echo($step == 3 ?'in active ':'');?>fade">
                    <form id="update3" method="post" action="<?php echo base_url();?>register/dentist-registration/4" role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" id="pac-input" placeholder="Search Your Location *" name="location">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <input class="field update3" id="street_number" type="text" placeholder="Address *" name="address">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-3">
                                <input class="field update3" id="route" type="text" placeholder="Street *" name="street">
                                <span class="help-block"></span>
                            </div>
                            
                            <div class="col-md-3">
                                <input class="field update3" disabled="true" id="locality" type="text" placeholder="City *" name="city">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-2">
                                <input class="field update3" disabled="true" id="administrative_area_level_1"  type="text" placeholder="State *" name="state">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-2">
                                <input class="field update3" disabled="true" id="postal_code"  type="text" placeholder="Zip" name="zip">
                            </div>
                        </div>

                        <hr class="mod" style="margin:20px 0;border-color:#cccaca;">

                        <!-- Map -->
                        <div class="registration-map">
                            <div id="dentist_reg_map" style="height:400px;">
                            
                            </div>
                        </div>

                        <div class="add_new_treatment_inside_tab">
                        <button type="submit" class="greyButton" style="margin:30px auto 0;">Submit</button>
                            
                        </div>
                        </form>
                    </div>

                    <div id="step4" class="tab-pane <?php echo($step == 4 ?'in active ':'');?>fade">
                    <div id="toclone" class="cloned" style="display: none;">
                        <span class="fa fa-times remove_treatment"></span>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" class="update_4 form-control" placeholder="Treatment title" name="treatment_name[]" style="width: 28%; display: inline-block; vertical-align: top; margin: 0 2px;"/>
                                <select class="update_4 form-control" name="treatment_duration[]" style="width: 24%; display: inline-block; vertical-align: top; height: 40px; margin: 0 2px;">
                                <option value="">Duration in min</option>
                                    <?php
                                    for ($row=1; $row <= 8; $row++) { 
                                		   $p = 15 * $row;
                                		   echo "<option>$p</option>";
                            		}?>
                                    
                                </select>
                                <input class="update_4" type="text" placeholder="Price($)" name="treatment_price[]" style="width: 15%; display: inline-block; vertical-align: top; height: 40px; margin: 0 2px;"/>
                                <div style="width: 29%; display: inline-block; vertical-align: top; height: 40px;">
                                <?php 
                                $this->db->select('*');
                                $this->db->from('practitioners');
                                $this->db->where('provider_id',$this->session->userdata('provider_id'));
                                $query = $this->db->get();
                                $practitioners = $query->result();?>
                                    <select id="" class="update_4 e9" name="treatment_practitioner[]" multiple="">
                                        <?php foreach($practitioners as $practitioner):?>
                                        <option value="<?= $practitioner->practitioner_id;?>"><?= $practitioner->practitioner_fullname;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <input class="update_4" type="text" placeholder="Description" name="treatment_desc[]">
                                <span class="help-block"></span>
                            </div>
                            
                        </div>


                        <hr class="mod" style="margin:0px 0px 20px 0;border-color:#b7b7b7;">
                        
                      </div>
                    
                    
                    <form id="update4" method="post" action="<?php echo base_url();?>register/dentist-registration/5" role="form">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="treatment-tabs">
                                    <ul class="nav nav-tabs">
                                        <?php 
                                        $cats = 1;
                                        foreach($all_cats as $all_cat):?>
                                        <li class="cat <?php echo ($cats==1)?'active':'';?>">
                                            <a data-toggle="tab" data-catid="<?php echo $all_cat->cat_id;?>" href="#treatment<?php echo $cats;?>"><?php echo $all_cat->cat_name;?></a>
                                        </li>
                                        <?php 
                                        $cats++;
                                        endforeach;?>

                                    </ul>
                                </div>

                            </div>

                            <div class="col-md-10">
                                <div class="tab-content" style="padding-top:0;">
                                
                                <?php 
                                    $cats = 1;
                                    $subcats = 1;
                                    $subcats_content = 1;
                                    foreach($all_cats as $all_cat):?>

                                    <div id="treatment<?php echo $cats;?>" class="<?php echo ($cats==1)?'tab-pane fade in active':'tab-pane fade';?>">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="treatment-tabs">
                                                    <ul class="nav nav-tabs">
                                                        <?php 
                                                        
                                                        foreach($all_subcats as $all_subcat):
                                                            if($all_subcat->cat_id == $all_cat->cat_id):
                                                        ?>
                                                        <li class="subcat <?php echo ($subcats==1)?'active':'';?>">
                                                            <a data-toggle="tab" data-subcatid="<?php echo $all_subcat->subcat_id;?>" href="#treatment-service<?php echo $subcats;?>"><?php echo $all_subcat->subcat_name;?></a>
                                                        </li>
                                                        <?php 
                                                        $subcats++;
                                                            endif;
                                                        endforeach;?>
                                    

                                                    </ul>
                                                </div>

                                            </div>

                                            <div class="col-md-9">
                                                <div class="tab-content" style="padding:22px 20px;">
                                                
                                                    <?php 
                                                    
                                                    foreach($all_subcats as $all_subcat):
                                                        if($all_subcat->cat_id == $all_cat->cat_id):
                                                    ?>

                                                    <div id="treatment-service<?php echo $subcats_content;?>" class="<?php echo ($subcats_content==1)?'tab-pane fade in active':'tab-pane fade';?>">
                                                            
                                                            <div class="notto">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <input type="text" class="update_4 form-control" placeholder="Treatment title" name="treatment_name[]" style="width: 28%; display: inline-block; vertical-align: top; margin: 0 2px;"/>
                                                                    <select class="update_4 form-control" name="treatment_duration[]" style="width: 24%; display: inline-block; vertical-align: top; height: 40px; margin: 0 2px;">
                                                                    <option value="">Duration in min</option>
                                                                        <?php
                                                                        for ($row=1; $row <= 8; $row++) { 
                                                                    		   $p = 15 * $row;
                                                                    		   echo "<option>$p</option>";
                                                                		}?>
                                                                        
                                                                    </select>
                                                                    <input class="update_4" type="text" placeholder="Price($)" name="treatment_price[]" style="width: 15%; display: inline-block; vertical-align: top; height: 40px; margin: 0 2px;"/>
                                                                    <div style="width: 29%; display: inline-block; vertical-align: top; height: 40px;">
                                                                    <?php 
                                                                    $this->db->select('*');
                                                                    $this->db->from('practitioners');
                                                                    $this->db->where('provider_id',$this->session->userdata('provider_id'));
                                                                    $query = $this->db->get();
                                                                    $practitioners = $query->result();?>
                                                                        <select id="" class="update_4 e9" name="treatment_practitioner[]" multiple="">
                                                                            <?php foreach($practitioners as $practitioner):?>
                                                                            <option value="<?= $practitioner->practitioner_id;?>"><?= $practitioner->practitioner_title;?> <?= $practitioner->practitioner_fullname;?></option>
                                                                            <?php endforeach;?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="row">
                                                                
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <input class="update_4" type="text" placeholder="Description" name="treatment_desc[]">
                                                                    <span class="help-block"></span>
                                                                </div>
                                                                
                                                            </div>


                                                            <hr class="mod" style="margin:0px 0px 20px 0;border-color:#b7b7b7;">
                                                            
                                                            </div>

                                                            <div class="add_new_treatment_inside_tab">
                                                                <!--<a href="javascript:void(0)" class="greyButton">Add treatment</a>-->
                                                                <button type="button" class="greyButton add_treat" style="margin:0px; float:right;">Add Treatment</button>
                                                            </div>

                                                    </div>
                                                    
                                                    <?php 
                                                    $subcats_content++;
                                                    //break;
                                                        endif;
                                                        
                                                    endforeach;?>

                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- tabcontent1 -->
                                    
                                    <?php 
                                    $cats++;
                                    endforeach;?>

                                </div>
                            </div>
                        </div>
                        
                        <table id="selected_treat" style="display: none; width: 100%;">
                            <tr>
                                <th style="text-align: center; padding: 10px; border: 1px solid #ccc;">Title</th>
                                <th style="text-align: center; padding: 10px; border: 1px solid #ccc;">Duration in minutes</th>
                                <th style="text-align: center; padding: 10px; border: 1px solid #ccc;">Price</th>
                                <th style="text-align: center; padding: 10px; border: 1px solid #ccc;">Practitioner(s)</th>
                                <th style="text-align: center; padding: 10px; border: 1px solid #ccc;">Description</th>
                                <th style="text-align: center; padding: 10px; border: 1px solid #ccc;">Category</th>
                                <th style="text-align: center; padding: 10px; border: 1px solid #ccc;">Sub-category</th>
                            </tr>
                        </table>
                        
                        <div class="hiddenfields" style="display: none;">
                        
                        </div>
                        
                        <script>
                        $(".add_treat").click(function(e){
                            e.preventDefault();
							var id = "unique-"+Math.floor((Math.random() * 100) + 1);
                            $("#selected_treat").hide();
                            var add_treat = $(this);
                            var filled = true;
                            add_treat.parent().siblings().find('.notto .update_4').each(function(i,v){
                                if($(this).prop("tagName") != "SPAN" && $(this).prop("tagName") != "DIV" && $(this).prop("tagName") != "BUTTON")
                                  {
                                      v = $(v);
                                      if($(this).val()==""){
                                        filled = false;
                                        //return false;
                                      }
                    
                                  }
                            });
                            
                            if(filled == true){
                                var formData = "<tr class='"+id+"' >";
                                var hiddenfields = "";
				                
                                add_treat.parent().siblings().last().find('.update_4').each(function(i,v){
                                  if($(this).prop("tagName") != "SPAN" && $(this).prop("tagName") != "DIV" && $(this).prop("tagName") != "BUTTON")
                                  {
                                      v = $(v);
									   console.log("Go");
									   console.log(v.val());
                                      var temp = v.attr('name');
                                      hiddenfields +='<input type="hidden" name="'+temp+'" class="update4 '+id+'" value="'+v.val()+'"/>';
                                        formData +="<td style='text-align: center; padding: 10px; border: 1px solid #ccc;'>"+v.val()+"</td>";      
                                  }
                			  }); 
                              hiddenfields +='<input type="hidden" name="cat[]" class="update4 '+id+'" value="'+$(".cat.active a").attr("data-catid")+'"/>';
                              hiddenfields +='<input type="hidden" name="subcat[]" class="update4 '+id+'" value="'+$(".subcat.active a").attr("data-subcatid")+'"/>';
                              formData += "<td style='text-align: center; padding: 10px; border: 1px solid #ccc;'>"+$('.cat.active a').text()+"</td>";
                               formData += "<td style='text-align: center; padding: 10px; border: 1px solid #ccc;'>"+$('.subcat.active a').text()+"</td>";
                              
                              formData += "</tr>";
                              
                              $("#selected_treat").prepend(formData);
                              $('.hiddenfields').prepend(hiddenfields);
                                //$(".e9").select2("destroy");
            
                               var clone = $("#toclone").clone();
                               var first_div = add_treat.parent();
                               clone.find('.error').html("");
                               clone.removeAttr("id");
                               clone.removeAttr("style");
                               clone.attr("custom-class",id);
                               first_div.before(clone);
                                
                                setTimeout(function(){
                                var total_treatments = add_treat.parent().siblings('.cloned').length;//$(".customform.skillform:visible").length;
                                if(total_treatments > 0){
                                    add_treat.parent().siblings('.cloned').children('.remove_treatment').show();//$(".delete-treatment").show();
                                    
                                } else {
                                    
                                    //$(this).parent().siblings('.cloned').children('.delete-treatment').show();//$(".delete-treatment").hide();
                                }
                                $(".e9").select2({
                                        placeholder: "Select practitioners",
                                    });
                                
                               },400);
                               
                               //$("#selected_treat").show();
                           
                           } else {
                                alert("please fill all above fields");
                            }
                        });
                        
                        
                        jQuery(document).on("click",".remove_treatment",function(){
							
							var idRemove = jQuery(this).parent(".cloned").attr("custom-class");
							
							jQuery("."+idRemove).remove();
							jQuery(this).parent(".cloned").remove();
							/* jQuery(this).parent(".cloned").remove();
							console.log("ID");
							console.log(id);
							jQuery("."+id).remove(); */
						});
                        
                         /*$(".add_treat").click(function(){
                            $("#selected_treat").hide();
                            var filled = true;
                            $('.update_4').each(function(i,v){
                                if($(this).prop("tagName") != "SPAN" && $(this).prop("tagName") != "DIV" && $(this).prop("tagName") != "BUTTON")
                                  {
                                      v = $(v);
                                      if(v.val() == ""){
                                        filled = false;
                                      }
                    
                                  }
                            });
                            
                            
                            if(filled == true){
                                var formData = "<tr>";
                                var hiddenfields = "";
				                
                                $('.update_4').each(function(i,v){
                                  if($(this).prop("tagName") != "SPAN" && $(this).prop("tagName") != "DIV" && $(this).prop("tagName") != "BUTTON")
                                  {
                                      v = $(v);
                                      var temp = v.attr('name');
                                      hiddenfields +='<input type="hidden" name="'+temp+'" class="update4" value="'+v.val()+'"/>';
                                        formData +="<td style='text-align: center; padding: 10px; border: 1px solid #ccc;'>"+v.val()+"</td>"; 
                    
                                  }
                                  
                			  }); 
                              formData += "<td style='text-align: center; padding: 10px; border: 1px solid #ccc;'>Preventive</td>";
                              formData += "<td style='text-align: center; padding: 10px; border: 1px solid #ccc;'>Hygiene Procedure</td>";
                              formData += "</tr>";
                              
                              $("#selected_treat").append(formData);
                              $('.hiddenfields').append(hiddenfields);
                              
                              $('.update_4').each(function(i,v){
                                  if($(this).prop("tagName") != "SPAN" && $(this).prop("tagName") != "DIV" && $(this).prop("tagName") != "BUTTON")
                                  {
                                      v = $(v);
                                      v.val(""); 
                                      $(".e9").val([]);
                    
                                  }
                                  
                			  }); 
                              
                              
                              $("#selected_treat").show();
                            } else {
                                alert("please fill all above fields");
                            }
                         });*/
                        
                        </script>

                        <div class="add_new_treatment_inside_tab">
                        <button type="submit" class="greyButton" style="margin:30px auto 0;">Submit</button>
                            
                        </div>
                        </form>
                    </div>

                    <div id="step5" class="tab-pane <?php echo($step == 5 ?'in active ':'');?>fade">
                   
                        <div class="row">
                            <div class="col-md-12">
                                <div class="heading">
                                    <h3>Submit your place</h3>
                                    <small>Add images</small>
                                </div>

                                <hr class="mod" style="margin:20px 0;border-color:#b7b7b7;">

                                <form id="update5" enctype="multipart/form-data" action="<?php echo base_url();?>" role="form" class="dropzone" id="my-awesome-dropzone">
                                    <div class="dz-message" data-dz-message><span>Click or Drop Images Here</span></div>
                                
                                <div class="fallback">
                                <input class="update5" name="images" type="file" multiple />
                              </div>
                                <div class="add_new_treatment_inside_tab">
                                <button type="submit" class="greyButton" style="margin:30px auto 0;">Submit</button>
                                    
                                </div>
                                </form>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){
  $(".e9").select2({
    placeholder: "Select practitioners",
});  
});



            $('form').on('submit',function(e){
                
                var formid = $(this).attr("id");
    e.preventDefault();
    $('.help-block').html('');
    var formData = new FormData();
    
    /*$(this).serializeArray().forEach(function(field) {
      formData.append(field.name, field.value);
    });?*/
    
      formData.append('step',formid);
      if(formid == 'update4' && $('.'+formid).length == 0){
        alert("must add atleast one treatment");
      } else{
      
        
    $('.'+formid).each(function(i,v){
      v=$(v);
      formData.append(v.attr('name'),v.val());      
    });

     url = "<?php echo base_url();?>register/dentist-registration/<?php echo $step;?>";
     $.ajax({
          url: url,
          type: "POST",
          data: formData,
          beforeSend:function()
          {
            $(".se-pre-con").fadeIn("slow");
          },
          processData: false,
          contentType: false,
          success: function (data) {
              $(".se-pre-con").fadeOut("slow");
               var data_msg=$.parseJSON(data);
                var canChange = true;
            $.each( data_msg.Error_Mess, function( key, value )
            {
                if (key.indexOf('|') > -1)
                {
                  var keyIndex = key.split("|");
                  var keyIndexEq = parseInt(keyIndex[1]);
                    $("[name='"+keyIndex[0]+"']").eq(keyIndexEq).siblings('.help-block').html(value);
                }else{
                    $("[name='"+key+"']").siblings('.help-block').html(value);
                    $("[name='"+key+"[]']").siblings('.help-block').html(value);      
                }
                
               canChange=false;
            }); 
            
            $.each( data_msg.Error_Mess, function( key, value )
            {
                if (key.indexOf('|') > -1 && value != "" && $("body").find("[name='"+key+"']").length > 0)
                {
                  var keyIndex = key.split("|");
                  var keyIndexEq = parseInt(keyIndex[1]);
                  
                  $('html, body').animate({
                        scrollTop: $("[name='"+keyIndex[0]+"']").offset().top
                    }, 1000);
                
                    return false;
                }else if(value != "" && $("body").find("[name='"+key+"']").length > 0) {
                    $('html, body').animate({
                        scrollTop: $("[name='"+key+"']").offset().top
                    }, 1000);
                    return false;
                }
            });
            
            $(".se-pre-con").fadeOut("slow");
			if(canChange == true)
            {
                console.log(data_msg);
                location.href=data_msg.redirect;
                /*$('html,body').animate({
                scrollTop: 0
                }, 700);*/
				//profileTabOnSave();
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            $(".se-pre-con").fadeOut("slow");
            alert('Error adding / update data');
          }
        });
        
        }
  });
        
        </script>

<!--<script src="<?php echo base_url(); ?>assets/form-validator/jquery.form-validator.js"></script>
<script>
    $(function(){
        $.validate({
            onError: function($form){
                $form.submit(function (e) {
                    e.preventDefault();
                });
            },
            onElementValidate: function(rsu, element){
                element.next().next().remove();
//                element.parent().removeClass('has-info').addClass('has-error');
            },
            <?php if($lang!='en'){ ?>lang: '<?php echo $lang; ?>'<?php } ?>
        });
    });
</script>-->