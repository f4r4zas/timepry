<div class="portlet">	
    <div class="portlet-body">
        <?php
        mk_hpostform(APPOINTMENT_ADMIN_URL."serviceManipulate/".(isset($data['service_id'])?$data['service_id']:""));
        ?>
        <div class="form-body">
            <?php
            //print_r($languages);

            mk_hcheckbox("data[price_show]",_l('Show price',$this),(isset($data['price_show']) && $data['price_show']==0)?0:1);
           // mk_hnumber("data[price]",_l('Practitioner Price',$this),isset($data['price'])?$data['price']:'', "style='max-width:200px; display:none;'");
            
    ?>
    <div class="form-group" style="display: none;">
        <label for="data[price]" class="control-label col-lg-2">Practitioner Price</label>
        <div class="col-lg-10">
            <input class=" form-control" id="data[price]" name="data[price]" type="text" value="1" style='max-width:200px;'/>
        </div>
    </div>
    <?php

            
            foreach ($languages as $item) {
                ?>
               <!-- <div class="form-group">
                    <label class="control-label col-lg-2">
                        <?php /*echo _l('Available Language',$this); */?><br>
                        <img src="<?php /*echo base_url().$item["image"]; */?>" style="width:16px;"> <?php /*echo $item["language_name"]; */?>
                    </label>
                    <div class="col-lg-10 col-sm-10">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input value="1" type="radio" id="radio<?php /*echo $item['language_id']; */?>1" name="extensions[<?php /*echo $item["language_id"]; */?>][status]" class="md-radiobtn"  onchange="if($(this).is(':checked')){ $('.lang_value<?php /*echo $item['language_id']; */?>').slideDown(500); }" <?php /*echo (isset($extensions[$item["language_id"]]['status']) && $extensions[$item["language_id"]]['status']==1)?'checked':''*/?>>
                                <label for="radio<?php /*echo $item['language_id']; */?>1">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    <?php /*echo _l('Yes',$this); */?> </label>
                            </div>
                            <div class="md-radio">
                                <input value="0" type="radio" id="radio<?php /*echo $item['language_id']; */?>2" name="extensions[<?php /*echo $item["language_id"]; */?>][status]" class="md-radiobtn" onchange="if($(this).is(':checked')){ $('.lang_value<?php /*echo $item['language_id']; */?>').slideUp(500); }" <?php /*echo (!isset($extensions[$item["language_id"]]['status']) || $extensions[$item["language_id"]]['status']!=1)?'checked':''*/?>>
                                <label for="radio<?php /*echo $item['language_id']; */?>2">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    <?php /*echo _l('No',$this); */?> </label>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="lang_value<?php echo $item['language_id']; ?>" <?php echo (isset($extensions[$item["language_id"]]['status']) && $extensions[$item["language_id"]]['status']==1)?'':'style="display:none;"'; ?>>


                    <?php

                    $service_name = trim(str_replace("Prof. Dr.","",$data['service_name'],$count ));
                    $match = "Prof. Dr.";
                    if($count == 0){
                        $service_name =  trim(str_replace("Dr.","",$data['service_name'],$count ));
                        $match = "Dr.";
                    }

                    if($count == 0){
                        $service_name =  trim(str_replace("Assistant","",$data['service_name'],$count ));
                        $match = "Assistant";
                    }

                    if($count == 0){
                        $service_name =  trim(str_replace("Dental Hygienist","",$data['service_name'],$count ));
                        $match = "Dental Hygienist";
                    }

                    ?>


                    <div class="form-group ">
                        <label for="data[service_name]" class="control-label col-lg-2">Practitioner Title</label>
                        <div class="col-lg-10">
                            <select data-validation="required" name="practitle" id="practitle" class="form-control update2">
                                <option <?php if($match == "Dr."){ echo "selected";} ?> value="Dr.">Dr.</option>
                                <option <?php if($match == "Prof. Dr."){ echo "selected";} ?> value="Prof. Dr.">Prof. Dr.</option>
                                <option <?php if($match == "Assistant"){ echo "selected";} ?> value="Assistant">Assistant</option>
                                <option <?php if($match == "Dental Hygienist"){ echo "selected";} ?> value="Dental Hygienist">Dental Hygienist</option>
                            </select>
                        </div>
                    </div>

                    <?php







                        mk_htext("data[service_name]",_l('Practitioner Name',$this),isset($service_name)?$service_name:'');
                            //mk_htext("extensions[".$item["language_id"]."][name]",_l('Practitioner Name',$this),$data['fname']."".$data['lname']);
                            /*mk_htextarea("extensions[".$item["language_id"]."][description]",_l('Page Description',$this)." (".$item["language_name"].")",isset($extensions[$item["language_id"]])?$extensions[$item["language_id"]]["description"]:"");*/
                    ?>
                </div>
                <?php
            }
            mk_hcheckbox("data[public]",_l('public',$this),(isset($data['public']) && $data['public']==1)?1:null);
            ?>
        </div>
        <div class="form-actions">
            <?php
            mk_hsubmit(_l('Submit',$this),APPOINTMENT_ADMIN_URL.'services',_l('Cancel',$this));
            ?>
        </div>
        <?php
        mk_closeform();
        ?>
    </div>
</div>
