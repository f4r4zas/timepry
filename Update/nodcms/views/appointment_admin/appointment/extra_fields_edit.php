    <div class="portlet">
        <div class="portlet-body">
            <?php
                mk_hpostform(APPOINTMENT_ADMIN_URL."extraFieldsManipulate/".(isset($data['id'])?$data['id']:""));
            ?>
            <div class="form-body">
            <?php
                mk_htext("data[field_name]",_l('Input Name',$this),isset($data['field_name'])?$data['field_name']:'');
                foreach ($languages as $item) {
                    mk_htext("data[titles][".$item["language_id"]."]",'<img src="'.base_url().$item["image"].'" style="width:24px;" alt="'.$item["language_name"].'" title="'.$item["language_name"].'"> '._l('Input name',$this),isset($titles[$item["language_id"]])?$titles[$item["language_id"]]["title_caption"]:"");
                }
                mk_hselect("data[field_type]",_l('Fields Type',$this),$fields_type,'type_id','type_name',isset($data['field_type'])?$data['field_type']:'',null,'style="width:250px;"');
                mk_hnumber("data[min]",_l('Minimum',$this),isset($data['min'])?$data['min']:"",'style="width:150px;"');
                mk_hnumber("data[max]",_l('Maximum',$this),isset($data['max'])?$data['max']:"",'style="width:150px;"');
                mk_hcheckbox("data[require]",_l('Require field',$this),(isset($data['require']) && $data['require']==1)?1:null);
            ?>
            </div>
            <div class="form-actions">
            <?php
                mk_hsubmit(_l('Submit',$this),APPOINTMENT_ADMIN_URL.'extra_fields',_l('Cancel',$this));
            ?>
            </div>
            <?php
                mk_closeform();
            ?>
        </div>
    </div>
