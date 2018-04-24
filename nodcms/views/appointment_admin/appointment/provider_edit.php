<div class="portlet">
    <div class="portlet-body">
        <?php
        mk_hpostform(APPOINTMENT_ADMIN_URL.(isset($post_method)?$post_method:"providerManipulate/").(isset($data['provider_id'])?$data['provider_id']:""));
        ?>
        <div class="form-body">
            <?php
            mk_htext("data[provider_name]",_l('Dental Office Name',$this),isset($data['provider_name'])?$data['provider_name']:'');
            mk_htext("data[provider_username]",_l('Dental Office Unique Name',$this),isset($data['provider_username'])?$data['provider_username']:'');
            foreach ($languages as $item) {
                ?>
                <div class="form-group">
                    <label class="control-label col-lg-2">
                        <?php echo _l('Available Language',$this); ?><br>
                        <img src="<?php echo base_url().$item["image"]; ?>" style="width:16px;"> <?php echo $item["language_name"]; ?>
                    </label>
                    <div class="col-lg-10 col-sm-10">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input value="1" type="radio" id="radio<?php echo $item['language_id']; ?>1" name="extensions[<?php echo $item["language_id"]; ?>][status]" class="md-radiobtn"  onchange="if($(this).is(':checked')){ $('.lang_value<?php echo $item['language_id']; ?>').slideDown(500); }" <?php echo (isset($extensions[$item["language_id"]]['status']) && $extensions[$item["language_id"]]['status']==1)?'checked':''?>>
                                <label for="radio<?php echo $item['language_id']; ?>1">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    <?php echo _l('Yes',$this); ?> </label>
                            </div>
                            <div class="md-radio">
                                <input value="0" type="radio" id="radio<?php echo $item['language_id']; ?>2" name="extensions[<?php echo $item["language_id"]; ?>][status]" class="md-radiobtn" onchange="if($(this).is(':checked')){ $('.lang_value<?php echo $item['language_id']; ?>').slideUp(500); }" <?php echo (!isset($extensions[$item["language_id"]]['status']) || $extensions[$item["language_id"]]['status']!=1)?'checked':''?>>
                                <label for="radio<?php echo $item['language_id']; ?>2">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    <?php echo _l('No',$this); ?> </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lang_value<?php echo $item['language_id']; ?>" <?php echo (isset($extensions[$item["language_id"]]['status']) && $extensions[$item["language_id"]]['status']==1)?'':'style="display:none;"'; ?>>
                    <?php
                    mk_htext("extensions[".$item["language_id"]."][name]",_l('Admin account name',$this),isset($extensions[$item["language_id"]])?$extensions[$item["language_id"]]["name"]:"");
                    mk_htexteditor("extensions[".$item["language_id"]."][full_description]",_l('Dental Office Description',$this)." (".$item["language_name"].")",isset($extensions[$item["language_id"]])?$extensions[$item["language_id"]]["full_description"]:"");
                    ?>
                </div>
                <?php
            }
            mk_hnumber("data[phone]", _l('Phone',$this), isset($data['phone'])?$data['phone']:'');
            mk_htextarea("data[address]", _l('Address',$this), isset($data['address'])?$data['address']:'');
            mk_hselect("data[payment_type]", _l('Services Type',$this), $payment_type, "code", "name", isset($data['payment_type'])?$data['payment_type']:NULL, NULL, "style='max-width:300px;'");
            if($this->session->userdata('group')==1 || $this->session->userdata('group')==100){
                mk_hcheckbox("data[active]",_l('Active',$this),(isset($data['active']) && $data['active']==1)?1:null);
            }
            ?>
        </div>
        <div class="form-actions">
            <?php
            mk_hsubmit(_l('Submit',$this),APPOINTMENT_ADMIN_URL.'providers', _l('Cancel',$this));
            ?>
        </div>
        <?php
        mk_closeform();
        ?>
    </div>
</div>
