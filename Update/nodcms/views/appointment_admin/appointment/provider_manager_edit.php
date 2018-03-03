    <div class="portlet">
        <div class="portlet-body">
            <?php
                mk_hpostform(APPOINTMENT_ADMIN_URL."providerManagerManipulate/".(isset($data['provider_id'])?$data['provider_id']:""));
            ?>
            <div class="form-body">
            <?php
                mk_htext("data[group_id]",_l('Property Name',$this),isset($data['provider_name'])?$data['provider_name']:'');
                mk_htext("data[user_id]",_l('Property Username',$this),isset($data['provider_username'])?$data['provider_username']:'');
                mk_hcheckbox("data[active]",_l('Active',$this),(isset($data['active']) && $data['active']==1)?1:null);
            ?>
            </div>
            <div class="form-actions">
            <?php
                mk_hsubmit(_l('Submit',$this),APPOINTMENT_ADMIN_URL, _l('Cancel',$this));
            ?>
            </div>
            <?php
                mk_closeform();
            ?>
        </div>
    </div>
