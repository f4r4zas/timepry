<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <section class="portlet">
            <div class="portlet-body">
                <div class=" form">
                    <?php
                    mk_hpostform();
//                    mk_hcheckbox('data[contact_form]',_l('Available Contact Form',$this),(isset($settings["contact_form"]) && $settings["contact_form"]==1)?1:null);
                    mk_hemail("data[email]",_l('Email Address',$this),isset($settings['email'])?$settings['email']:'');
                    mk_hnumber("data[phone]",_l('Phone Number',$this),isset($settings['phone'])?$settings['phone']:'');
                    mk_hnumber("data[zip_code]",_l('Zip Code',$this),isset($settings['zip_code'])?$settings['zip_code']:'');
//                    mk_hgoogle_location("data[location]",_l('Google Location',$this),isset($settings['location'])?$settings['location']:'');
                    mk_htextarea("data[address]",_l('Address',$this),isset($settings['address'])?$settings['address']:'');
                    mk_hsubmit(_l('Save',$this));
                    mk_closeform();
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>
