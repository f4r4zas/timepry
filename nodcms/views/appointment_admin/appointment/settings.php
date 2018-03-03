<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <section class="panel">
            <div class="panel-body">
                <div class=" form">
                    <?php
                    mk_hpostform();
                    $option = "style='max-width:600px;'";
                    mk_hselect("data[currency_format]", _l('Display Price Format',$this), $currency_format, "code", "code", isset($settings['currency_format'])?$settings['currency_format']:NULL, NULL, "style='max-width:200px;'");
                    mk_htext("data[currency_sign]", _l('Currency Sign',$this), isset($settings['currency_sign'])?$settings['currency_sign']:'', "style='max-width:200px;'");
                    ?>
                    <div class="form-group ">
                        <label class="control-label col-lg-2" for="data[currency_sign_before]"><?php echo _l("Currency Sign Position", $this);?></label>
                        <div class="col-lg-10 col-sm-10">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input type="radio" <?php echo (isset($settings['currency_sign_before']) && $settings['currency_sign_before']==1)?'checked=""':''; ?> class="md-radiobtn" name="data[currency_sign_before]" id="yesdata[currency_sign_before]" value="1">
                                    <label for="yesdata[currency_sign_before]">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        <?php echo _l("Before Price", $this); ?> </label>
                                </div>
                                <div class="md-radio">
                                    <input type="radio" <?php echo (!isset($settings['currency_sign_before']) || $settings['currency_sign_before']==0)?'checked=""':''; ?> class="md-radiobtn" name="data[currency_sign_before]" id="nodata[currency_sign_before]" value="0">
                                    <label for="nodata[currency_sign_before]">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        <?php echo _l("After Price", $this); ?> </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    mk_hcheckbox('data[appointment_non_repeating]',_l('Not Duplicate',$this),(isset($settings["appointment_non_repeating"]) && $settings["appointment_non_repeating"]==1)?1:null);
                    mk_hcheckbox('data[appointment_multiowner]',_l('Use Multi-Owner system',$this),(isset($settings["appointment_multiowner"]) && $settings["appointment_multiowner"]==1)?1:null);
                    mk_hcheckbox('data[registration]',_l('Active Registration',$this),(isset($settings["registration"]) && $settings["registration"]==1)?1:null);
//                    mk_hcheckbox('data[appointment_cancel]',_l('Cancelling',$this),(isset($settings["appointment_cancel"]) && $settings["appointment_cancel"]==1)?1:null);
//                    mk_htext("data[appointment_non_repeating_field]",_l('Non-Repeating Field',$this),isset($item["appointment_non_repeating_field"])?$item["appointment_non_repeating_field"]:'',$option);
                    mk_hsubmit(_l('Save',$this));
                    mk_closeform();
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>
