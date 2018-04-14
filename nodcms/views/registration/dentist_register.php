<?php /* $this->session->unset_userdata("dataStepOne"); 
 $this->session->unset_userdata("dataStepTwo"); 
$this->session->unset_userdata("dataStepThree"); 
$this->session->unset_userdata("dataStepFour");  */

//print_r($this->session->userdata("dataStepTwo"));
 ?>
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
                        <form id="update1"  method="post" action="<?php echo base_url();?>register/dentist-registration/2" role="form">
                        <?php 
						/* Setting the user step one data */
						if($this->session->userdata('dataStepOne')){
				
							$stepOneData = $this->session->userdata('dataStepOne');
							
							$firstName = $stepOneData['firstname'];
							$lastName = $stepOneData['lastname'];
							$email =  $stepOneData['email'];
							$phone = $stepOneData['mobile'];
				
						}
					?>
            <div class="row">
                <div class="col-sm-6">
                    <input  placeholder="First Name *" value="<?php if(!empty($firstName)){ echo $firstName; } ?>" name="fname" id="fname" data-validation="required" type="text" class="form-control update1">
                    <span class="help-block"></span>
                </div>
                <div class="col-sm-6">
                    <input placeholder="Last Name *" value="<?php if(!empty($lastName)){ echo $lastName; } ?>" name="lname" id="lname"  type="text" class="form-control update1">
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <input placeholder="Email *" value="<?php if(!empty($email)){ echo $email; } ?>" name="email" id="email" type="text" data-validation="required" class="form-control update1">
                    <span class="help-block"></span>
                       
                                        
                </div>
                <div class="col-sm-6">

                    <input placeholder="Phone (e.g. 00398738927892)" value="<?php if(!empty($phone)){ echo $phone; } ?>" name="mobile" id="mobile" type="text" class="form-control update1">

                    
                        <span class="help-block"></span>
                                      
                </div>
            </div>
            <div class="row">
                
                <div class="col-sm-6">
                    <input placeholder="Password *" value="" name="password" id="password"  data-validation="required" type="password" class="form-control update1">

                    <span class="help-block"></span>
                                      
                </div>
                
                <div class="col-sm-6">
                    <input placeholder="Confirm Password *" value="" name="cpassword" id="cpassword"  data-validation="required" type="password" class="form-control update1">

                    <span class="help-block"></span>
                                     
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="submit-btn">
					<?php if($this->session->userdata('dataStepOne')){ ?>
						<button type="button" OnClick="next()" class="greyButton">Submit</button>
						<script>
						function next(){
							jQuery("[href='#step2']").click()
						}
						</script>
					<?php }else{ ?>
						<button type="submit" class="greyButton">Submit</button>
					<?php  } ?>   
                    </div>
                </div>
            </div>
        </form>
        

                    </div>

                    <div id="step2" class="tab-pane <?php echo($step == 2 ?'in active ':'');?>fade">
                     <form id="update2" method="post" action="<?php echo base_url();?>register/dentist-registration/3" role="form">
					 
					 <?php if($this->session->userdata("dataStepTwo")){ 
							
						$dataStepTwo = $this->session->userdata("dataStepTwo"); 
						
						$provider_name = $dataStepTwo['providerDetails']["provider_name"];
						$provider_username = $dataStepTwo['providerDetails']["provider_username"];
						$provider_email = $dataStepTwo['providerDetails']["provider_email"];
						$providerPhone = $dataStepTwo['providerDetails']["phone"];
						$providerDescription = $dataStepTwo['providerDetails']["description"];
						$website = $dataStepTwo['providerDetails']["website"];
						
						$doctors =  $dataStepTwo["doctors"];
						$timePeriod =  $dataStepTwo["timePeriod"];
						$providerTime =  $dataStepTwo["providerTime"];
		
					  } ?>
					 
                        <div class="row">
                            <div class="col-md-6">
                                <input placeholder="Name of the Dental Office *" value="<?php if(!empty($provider_name)){echo $provider_name; } ?>" name="dental_officename" id="dental_officename" data-validation="required" type="text" class="form-control update2">


                                <span class="help-block"></span>

                            </div>
                            <div class="col-md-6">
                            
                                <input placeholder="Website of Dental Office"  value="<?php if(!empty($website)){echo $website; } ?>" name="dental_officewebsite" id="dental_officewebsite" type="text" class="form-control update2">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input placeholder="Email of Dental Office *" data-validation="required" value="<?php if(!empty($provider_email)){echo $provider_email; } ?>" name="dental_officeemail" id="dental_officeemail" type="text" class="form-control update2">
                                <span class="help-block"></span>
                                <span style="position: absolute;top: 15px;color: #518ed2;right: 22px;font-size: 21px;" class="help glyphicon glyphicon-question-sign" data-placement="top" data-toggle="tooltip"  title="Insert the emial of the dental office. This email will be visible to your patients to give them the possibility to contact your directly. This email can be the same as the account email previously written or can be also different"></span>

                            </div>
                            <div class="col-md-6">
                                <input placeholder="Phone (e.g. 00398738927892) *" value="<?php if(!empty($providerPhone)){echo $providerPhone; } ?>" data-validation="required" name="dental_officephone" id="dental_officephone" type="text" class="form-control update2">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <textarea data-validation="required" placeholder="Description of Dental Office *" rows="6" name="dental_officedescription" id="dental_officedescription" class="form-control update2"><?php if(!empty($providerDescription)){echo $providerDescription; } ?></textarea>
                                <span class="help-block"></span>
                                
                            </div>
                        </div>

                        <hr class="mod" style="margin:20px 0;border-color:#cccaca;">

                        <div id="practioners">
                            <h1>Name of practioners who work in Dental Office (minimum 1)</h1>
                            
                            
							<?php if(!empty($doctors)){ ?>
								<?php foreach($doctors as $all_doctors){ ?>
								<?php 
									$dName = explode("  ",$all_doctors["service_name"]);
									$docTitle = $dName[0];
									$docName = $dName[1];
								?>
									<div class="row">
										<div class="col-xs-12 col-sm-6">
											<select data-validation="required" name="practitioners_title[]" id="practitioners_title" class="form-control update2">
												<option <?php if($docTitle == "Dr."){echo "selected";} ?> value="Dr.">Dr.</option>
												<option <?php if($docTitle == "Prof. Dr." || $docTitle == "Prof."){echo "selected";} ?> value="Prof. Dr.">Prof. Dr.</option>
												<option <?php if($docTitle == "Assistant"){echo "selected";} ?> value="Assistant">Assistant</option>
												<option <?php if($docTitle == "Dental Hygienist"){echo "selected";} ?> value="Dental Hygienist">Dental Hygienist</option>
											</select>
										   
										   
										</div>
										<div class="col-xs-8 col-sm-5">
											<input data-validation="required" type="text" placeholder="Name and Surname *" name="practitioner_name[]" value="<?php echo $docName; ?>" id="practitioner_name" class="form-control update2">
                                            <span class="help-block"></span>
											
										</div>
										<div class="col-xs-4 col-sm-1 add_practitioner_main">
											<div class="remove_practitioner_row"><i style="display:block; margin-top: 15px;" class="fa fa-times"></i></div>
										</div>
									</div>
										<?php } ?>
							<?php }else{ ?>
							<div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <select data-validation="required" name="practitioners_title[]" id="practitioners_title" class="form-control update2">
                                        <option value="Dr.">Dr.</option>
                                        <option value="Prof. Dr.">Prof. Dr.</option>
                                        <option value="Assistant">Assistant</option>
                                        <option value="Dental Hygienist">Dental Hygienist</option>
                                    </select>
                                   
                                   
                                </div>
                                <div class="col-xs-8 col-sm-5">
                                    <input data-validation="required" type="text" placeholder="Name and Surname *" name="practitioner_name[]" value="" id="practitioner_name" class="form-control update2">
                                    <span class="help-block"></span>
                                    
                                </div>
                                <div class="col-xs-4 col-sm-1 add_practitioner_main">
                                    <div class="add_practitioner_row">
                                        <i style="display:block; margin-top: 15px;" class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>
							<?php } ?>
							
							
                        </div>
                        <script>
                                $('.add_practitioner_row').click(function(){
                                    var main_row = $(this).parent().parent();
                                    var cloned = main_row.clone();
                                    
                                    cloned.find('.add_practitioner_row').remove();
                                    cloned.find('.add_practitioner_main').html('<div class="remove_practitioner_row"><i style="display:block; margin-top: 15px;" class="fa fa-times"></i></div>');
                                    
                                    cloned.find('input').val('');
                                    cloned.find('select').val('Dr.');
                                    
                                    $(main_row).before(cloned);
                                });
                                
                                
                                $('body').on('click','.remove_practitioner_row',function(){
                                    $(this).parent().parent().remove();
                                });
                        </script>

                        <hr class="mod" style="margin:20px 0;border-color:#cccaca;">

                        <div id="opening_days">
                            <h1>Opening hours</h1>
							<div class="col-md-12" style="padding-left:0;padding-right:0">
								<div style='display:none' id="open-close" class="alert alert-danger text-center">
									
								</div>
							</div>
                            <?php 
							
                            $days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
							$start = 0;
                            foreach($days as $k => $day): ?>
							
							<?php 
							
							if(!empty($timePeriod)){
								$timeData = $timePeriod[$start]; 
									
								if($timeData['day_no'] == $start){
									$savedStart =  $timeData['staticStartTime'];
									$savedEnd =  $timeData['staticEndtartTime'];
								}else{
									$savedStart = "";
									$savedEnd = "";
								}
							}
						
							?>
                            <div class="row daysRow">

                                <div class="col-xs-8 col-sm-4">
                                    <input class="update2" disabled="disabled" type="text" value="<?=$day;?>" name="opening_day[]" placeholder="<?=$day;?>">
                                </div>
                                <div class="col-xs-12 col-sm-3 input-append">
								
                                    <input value="<?php if(!empty($savedStart)){ echo $savedStart; } ?>"									class="time make-green update2 timePicker-from" id="timePicker-from-<?=$k?>" type="text" style="width: 80%;" placeholder="Opening hours" name="openingHours[]">
									<i id="bla" class="help-block opening"></i>
									
                                </div>
								
                                <div class="col-xs-12 col-sm-3 input-append">
                                    <input value="<?php if(!empty($savedEnd)){ echo $savedEnd; } ?>" class="time update2 timePicker-to" id="timePicker-to-<?=$k?>" type="text" style="width: 80%;" placeholder="Closing hours" data-format="hh:mm" name="closingHours[]">
                                    
                                    <a class="help-block"></a>                                   
                                </div>
                                <div class="col-xs-8 col-sm-2">
                                    <div class="closed_day">
                                        <span class="open fa fa-circle-o open"></span>
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
                            <?php $start++; ?>
                            <?php endforeach;?>
                            
                            <script type="text/javascript">
  $(function() {
    /*$('.datetimepicker3').datetimepicker({
      pickDate: false
    });*/

    $(".timePicker-from").kendoTimePicker({format:"HH:mm"});
    $(".timePicker-to").kendoTimePicker({format:"HH:mm"});
  });

// $(".closed_day").off("click");
$(".closed_day").on("click", function(){
    var value_field = $(this).find(".closed_day_value");
    var icon_value = $(this).find("span.fa");
    if($(this).children("span.open").length > 0){
        value_field.val("1");
        $(this).parents(".daysRow").addClass("closedDay");
        for(var i=0;i<2;i++){
          $(this).parents(".daysRow").find("input.time").eq(i).data("kendoTimePicker").enable(false);
        }
        icon_value.removeClass("fa-circle-o");
        icon_value.removeClass("open");
        icon_value.addClass("fa-circle");
        icon_value.addClass("closed");
    } else {
        value_field.val("");
      	for(var i=0;i<2;i++){
          $(this).parents(".daysRow").find("input.time").eq(i).data("kendoTimePicker").enable(true);
        }
        $(this).parents(".daysRow").removeClass("closedDay");
        icon_value.removeClass("fa-circle");
        icon_value.removeClass("closed");
        icon_value.addClass("fa-circle-o");
        icon_value.addClass("open");
    }
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
					<?php if($this->session->userdata("dataStepThree")){ ?>
					
						<?php $addressData=  $this->session->userdata("dataStepThree")["address"]; ?>
					<?php } ?>
                        <div class="row">
						
                            <div class="col-md-12">
                                <input type="text" value="<?php if(!empty($addressData)){ echo $addressData['address'].", ".$addressData['street'].", ".$addressData['city'].", ".$addressData['state']; } ?>" id="pac-input" placeholder="Search Your Location *" name="location">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <input class="field update3" id="street_number" type="text" placeholder="Street No *" value="<?php if(!empty($addressData)){ echo $addressData['address']; } ?>" name="address">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-3">
                                <input class="field update3" value="<?php if(!empty($addressData)){ echo $addressData['street']; } ?>" id="route" type="text" placeholder="Street *" name="street">
                                <span class="help-block"></span>
                            </div>
                            
                            <div class="col-md-3">
                                <input class="field update3" value="<?php if(!empty($addressData)){ echo $addressData['city']; } ?>" disabled="true" id="locality" type="text" placeholder="City *" name="city">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-2">
                                <input class="field update3" disabled="true" id="administrative_area_level_1" value="<?php if(!empty($addressData)){ echo $addressData['state']; } ?>" type="text" placeholder="State *" name="state">
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
                                <input type="text" class="update_4 form-control" placeholder="Treatment title *" name="treatment_name[]" style="width: 28%; display: inline-block; vertical-align: top; margin: 0 2px;"/>

                                <select class="update_4 form-control" name="treatment_duration[]" style="width: 24%; display: inline-block; vertical-align: top; height: 40px; margin: 0 2px;">
                                <option value="">Duration in min</option>
                                    <?php
                                    for ($row=1; $row <= 8; $row++) { 
                                		   $p = 15 * $row;
                                		   echo "<option>$p</option>";
                            		}?>
                                    
                                </select>
                                <input class="update_4" type="text" placeholder="Price(€) *" name="treatment_price[]" style="width: 15%; display: inline-block; vertical-align: top; height: 40px; margin: 0 2px;"/>
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
                                <input class="update_4" type="text" placeholder="Description *" name="treatment_desc[]">
                                <span class="help-block"></span>
                            </div>
                            
                        </div>


                        <hr class="mod" style="margin:0px 0px 20px 0;border-color:#b7b7b7;">
                        
                      </div>
                    
                    
                    <form id="update4" method="post" action="<?php echo base_url();?>register/dentist-registration/5" role="form">
					<?php if(!empty($this->session->userdata("dataStepFour"))){ 
						/* echo "<pre>";
						print_r($this->session->userdata("dataStepFour"));
					
						echo "</pre>"; */
							$dataStepFour = $this->session->userdata("dataStepFour");
					 } ?>
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
                                                                    <input type="text" class="update_4 form-control" placeholder="Treatment title *" name="treatment_name[]" style="width: 28%; display: inline-block; vertical-align: top; margin: 0 2px;"/>
                                                                    <select class="update_4 form-control" name="treatment_duration[]" style="width: 24%; display: inline-block; vertical-align: top; height: 40px; margin: 0 2px;">
                                                                    <option value="">Duration in mins *</option>
                                                                        <?php
                                                                        for ($row=1; $row <= 12; $row++) { 
                                                                    		   $p = 15 * $row;
                                                                    		   echo "<option>$p</option>";
                                                                		}?>
                                                                        
                                                                    </select>
                                                                    <input class="update_4" type="text" placeholder="Price(€) *" name="treatment_price[]" style="width: 15%; display: inline-block; vertical-align: top; height: 40px; margin: 0 2px;"/>
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
                                                                    <input class="update_4" type="text" placeholder="Description *" name="treatment_desc[]">
                                                                    <span class="help-block"></span>
                                                                </div>
                                                                
                                                            </div>


                                                            <hr class="mod" style="margin:0px 0px 20px 0;border-color:#b7b7b7;">
                                                            
                                                            </div>
															<?php if(!empty($dataStepFour)){ 
																
																foreach($dataStepFour as $tPrice){
																	if($tPrice['subcategory'] == $all_subcat->subcat_id){
																		
																		?>
																<div class="cloned">
																<span class="fa fa-times remove_treatment"></span>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <input value="<?php echo $tPrice['title']; ?>" type="text" class="update_4 form-control" placeholder="Treatment title" name="treatment_name[]" style="width: 28%; display: inline-block; vertical-align: top; margin: 0 2px;"/>
                                                                    <select class="update_4 form-control" name="treatment_duration[]" style="width: 24%; display: inline-block; vertical-align: top; height: 40px; margin: 0 2px;">
                                                                    <option value="">Duration in min</option>
                                                                        <?php
                                                                        for ($row=1; $row <= 8; $row++) { 
																			$selected = "";
																		
                                                                    		   $p = 15 * $row;
																			   
																			   if($tPrice['period_min'] == $p){
																				   $selected = "selected";
																			   }
																			   
                                                                echo "<option ".$selected.">$p</option>";
                                                                		}?>
                                                                        
                                                                    </select>
                                                                    <input class="update_4" type="text" value="<?php echo $tPrice['price']; ?>" placeholder="Price(€)" name="treatment_price[]" style="width: 15%; display: inline-block; vertical-align: top; height: 40px; margin: 0 2px;"/>
                                                                    <div style="width: 29%; display: inline-block; vertical-align: top; height: 40px;">
                                                                    <?php 
                                                                    $this->db->select('*');
                                                                    $this->db->from('practitioners');
                                                                    $this->db->where('provider_id',$this->session->userdata('provider_id'));
                                                                    $query = $this->db->get();
                                                                    $practitioners = $query->result();?>
																	
																	<?php $doctorer_array = explode(",",$tPrice['dentists_id']); ?>
																	
                                                                        <select id="" class="update_4 e9" name="treatment_practitioner[]" multiple="">
                                                                            <?php foreach($practitioners as $practitioner):?>
                                                                            <option <?php if(in_array($practitioner->practitioner_id,$doctorer_array)){echo "selected"; } ?> value="<?= $practitioner->practitioner_id;?>"><?= $practitioner->practitioner_title;?> <?= $practitioner->practitioner_fullname;?></option>
                                                                            <?php endforeach;?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="row">
                                                                
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <input class="update_4" type="text" value="<?php echo $tPrice['service_description'] ?>" placeholder="Description" name="treatment_desc[]">
                                                                    <span class="help-block"></span>
                                                                </div>
                                                                
                                                            </div>


                                                            <hr class="mod" style="margin:0px 0px 20px 0;border-color:#b7b7b7;">
                                                            
                                                            </div>
																		<?php
																	}
																}
																
															}	
															?>
																	
														
															
															

                                                            <div class="add_new_treatment_inside_tab">
                                                                <!--<a href="javascript:void(0)" class="greyButton">Add treatment</a>-->
                                                                <button type="button" class="greyButton add_treat blue-button" style="margin:0px; float:right;">Save Treatment</button>
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
							
							/* if($(".e9").data("select2")){
								$(".e9").select2("destroy");
							} */
							
							$(".select2-hidden-accessible").select2("destroy");
							//$(".select2-hidden-accessible").select2();
							
							var id = "unique-"+Math.floor((Math.random() * 100) + 1);
                            $("#selected_treat").hide();
                            var add_treat = $(this);
                            var filled = true;
                            add_treat.parent().siblings().find('.notto .update_4').each(function(i,v){
                               console.log("worked");
                                if($(this).prop("tagName") != "SPAN" && $(this).prop("tagName") != "DIV" && $(this).prop("tagName") != "BUTTON")
                                  {
                                      v = $(v);
                                      if($(this).val()==""){
                                          console.log("Empty");
                                        filled = false;
                                      }else{
                                          console.log("No EMpty");
                                      }
                    
                                  }
                            });
                            
                            if(filled == true){
                                var formData = "<tr class='"+id+"' >";
                                var hiddenfields = "";
                                var validFields = true;

                                //Check validation
                                add_treat.parent().siblings().last().find('.update_4').each(function(i,v){

                                    if($(this).prop("tagName") != "SPAN" && $(this).prop("tagName") != "DIV" && $(this).prop("tagName") != "BUTTON")
                                    {
                                        v = $(v);
                                        console.log("Values");
                                        if(v.val()){

                                        }else{
                                           // alert("Please Fill all the fields");
                                            validFields =  false;
                                        }

                                    }
                                });

                                if(validFields == false){
                                    alert("Please fill all the fields");
                                    $(".e9").select2();
                                    return false;
                                }


                                add_treat.parent().siblings().last().find('.update_4').each(function(i,v){

                                  if($(this).prop("tagName") != "SPAN" && $(this).prop("tagName") != "DIV" && $(this).prop("tagName") != "BUTTON")
                                  {
                                      v = $(v);
									  console.log("Values");
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
                               							   
							    //add_treat.parent().parent().append(clone);
							   
							  first_div.before(clone);
							   
                               //jQuery(".notto").before(clone);
                                
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
									<p style="color:red">First pic uploaded will be cover photo</p>
                                </div>

                                <hr class="mod" style="margin:20px 0;border-color:#b7b7b7;">

        <form id="update5"  action="<?php echo base_url();?>Registration/imageUpload" enctype="multipart/form-data"  class="dropzone update5" id="my-awesome-dropzone">
                                    <div class="dz-message" data-dz-message><span>Click or Drop Images Here</span></div>
                                
                                <div class="fallback">
									<input type="hidden" name="step" value="update5">
									<input class="update5" name="images" type="file"  />
								</div>
                                <div class="add_new_treatment_inside_tab">
                                <button type="submit" class="greyButton" style="margin:30px auto 0;">Submit</button>
                                    
                                </div>
								<div class="uploadedImages"></div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url(); ?>assets/form-validator/jquery.form-validator.js"></script>

<script>
$(document).ready(function(){
  $(".e9").select2({
    placeholder: "Select practitioners",
});  

 $('[data-toggle="tooltip"]').tooltip(); 
 
	$("input").change(function(){
            $(this).addClass("greener");

        $(this).siblings('.help-block').html("")
        if($(this).val() == ""){
            $(this).removeClass("greener");
        }

	});
	
	
	 /*$.validate({
            onError: function($form){
				console.log($form);
                $form.submit(function (e) {
                    //e.preventDefault();
                });
            },
         errorPlacement: function(error, element) {
             element.siblings('.help-block').html(error);
             element.siblings('.help-block').html(error);
             console.log("custom error");
         },
         onElementValidate: function(rsu, element){
                element.next().next().remove();
                //element.parent().removeClass('has-info').addClass('has-error');
         },

            <?php if($lang!='en'){ ?>lang: '<?php echo $lang; ?>'<?php } ?>
        });*/
		
		
		$(".make-green").change(function(){
			$(this).addClass("greener");
		});
		
		$(".make-green").change(function(){
			$(this).addClass("greener");
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
	  console.log(v.attr('name'));
      formData.append(v.attr('name'),v.val());      
    });

	console.log(formData);
     url = "<?php echo base_url();?>register/dentist-registration/<?php echo $step;?>";
	 
	 var customMessage = "";
	 var customkey = "";
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
			   
			   if(key == "openingHours" || "closingHours"){
				   $("#open-close").show();
					console.log("Opting");
					console.log(value);
					
						$("#open-close").html(value);
				
					
				/* customkey = key;
				if(value == "You must provide this field."){
						customMessage = "You must provide openingHours/closingHours"
				}else{
					customMessage = value;
				}  */
			}else{
				$("#open-close").hide();
			}
			   
            }); 
			
            $.each( data_msg.Error_Mess, function( key, value )
            {
                $('html, body').animate({
                    scrollTop: $(".registration-tabs").offset().top
                }, -2000);

                if (key.indexOf('|') > -1 && value != "" && $("body").find("[name='"+key+"']").length > 0)
                {
                  var keyIndex = key.split("|");
                  var keyIndexEq = parseInt(keyIndex[1]);

                  /*$('html, body').animate({
                      scrollTop: $("[name='"+keyIndex[0]+"']:nth-child(1)").offset().top
                    }, -2000);
*/

                    return false;
                }else if(value != "" && $("body").find("[name='"+key+"']").length > 0) {
  /*                  $('html, body').animate({
                        scrollTop: $("[name='"+key+"']").offset().top
                    }, -2000);
                    return false;*/
                }
            });
            
            $(".se-pre-con").fadeOut("slow");
			if(canChange == true)
            {
                console.log(data_msg);
                location.href=data_msg.redirect;
                
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
