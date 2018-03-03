<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <section class="portlet">
            <div class="portlet-body">
                <div class=" form">
                    <?php
                    mk_hpostform();
                    ?>
                    <div class="form-group ">
                        <label class="control-label col-lg-2"><?php echo _l('Email protocol',$this); ?></label>
                        <div class="col-lg-10 col-sm-10">
                            <div class="md-radio-inline">
                                <div class="md-radio">
                                    <input value="1" type="radio" id="radio1" name="data[use_smtp]" class="md-radiobtn"  onchange="if($(this).is(':checked')){ $('.smtp_options').slideDown(500); }">
                                    <label for="radio1">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        <?php echo _l('SMTP-protocol',$this); ?> </label>
                                </div>
                                <div class="md-radio">
                                    <input value="0" type="radio" id="radio2" name="data[use_smtp]" class="md-radiobtn" onchange="if($(this).is(':checked')){ $('.smtp_options').slideUp(500); }" <?php echo (isset($settings['use_smtp']) && $settings['use_smtp']==0)?'checked':''; ?>>
                                    <label for="radio2">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        <?php echo _l('mail-protocol',$this); ?> </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="smtp_options" <?php echo (isset($settings['use_smtp']) && $settings['use_smtp']==0)?'style="display:none;"':''; ?>>
                        <?php
                        $option = "style='max-width:600px;'";
                        mk_htext("data[smtp_host]",_l('SMTP host name',$this),isset($settings['smtp_host'])?$settings['smtp_host']:'',$option);
                        mk_hnumber("data[smtp_port]",_l('SMTP port',$this),isset($settings['smtp_port'])?$settings['smtp_port']:'',$option);
                        mk_htext("data[smtp_username]",_l('SMTP username',$this),isset($settings['smtp_username'])?$settings['smtp_username']:'',$option);
                        mk_htext("data[smtp_password]",_l('SMTP password',$this),isset($settings['smtp_password'])?$settings['smtp_password']:'',$option);
                        ?>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-lg-2"><?php echo _l('Auto messages',$this); ?></label>
                        <div class="col-lg-10">
                            <ul class="nav nav-tabs nav-languages" role="tablist">
                                <?php foreach ($languages as $item) { ?>
                                    <li role="presentation">
                                        <a href="#langtab<?php echo $item["language_id"]?>" aria-controls="langtab<?php echo $item["language_id"]?>" role="tab" data-toggle="tab">
                                            <img src="<?php echo base_url().$item["image"]; ?>" style="width:32px;">
                                            <?php echo $item["language_name"]; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content nav-languages">
                                <?php foreach ($languages as $item) { ?>
                                    <div role="tabpanel" class="tab-pane" id="langtab<?php echo $item["language_id"]?>">
                                        <?php
                                        if(isset($auto_emails) && count($auto_emails)!=0){
                                            foreach($auto_emails as $key=>$val){
                                                ?>
                                                <div class="portlet light bg-inverse">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <span class="caption-subject bold uppercase"><?php echo _l($val['label'],$this)." (".'<img src="'.base_url().$item["image"].'" style="width:18px;"> '.$item["language_name"].")"; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <?php
                                                        mk_vtext("data[auto_messages][".$item["language_id"]."][$key][subject]",_l('Mail Subject',$this),isset($auto_messages_data[$item["language_id"]][$key]['subject'])?$auto_messages_data[$item["language_id"]][$key]['subject']:"");
                                                        mk_vtexteditor_shortkeys($key.$item["language_id"],"data[auto_messages][".$item["language_id"]."][$key][content]",_l('Mail Content',$this),isset($auto_messages_data[$item["language_id"]][$key]['content'])?$auto_messages_data[$item["language_id"]][$key]['content']:"",'rows="12"',$val['keys']);
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                    <?php
                    mk_hsubmit(_l('Save',$this));
                    mk_closeform();
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    $(function(){
        $('.nav.nav-tabs.nav-languages > li:first-child').addClass('active');
        $('.nav-languages .tab-pane:first-child').addClass('active');
    });
    function insertAtCaret(areaId,text) {
        var txtarea = document.getElementById(areaId);
        var scrollPos = txtarea.scrollTop;
        var strPos = 0;
        var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
            "ff" : (document.selection ? "ie" : false ) );
        if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart ('character', -txtarea.value.length);
            strPos = range.text.length;
        }
        else if (br == "ff") strPos = txtarea.selectionStart;

        var front = (txtarea.value).substring(0,strPos);
        var back = (txtarea.value).substring(strPos,txtarea.value.length);
        txtarea.value=front+text+back;
        strPos = strPos + text.length;
        if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart ('character', -txtarea.value.length);
            range.moveStart ('character', strPos);
            range.moveEnd ('character', 0);
            range.select();
        }
        else if (br == "ff") {
            txtarea.selectionStart = strPos;
            txtarea.selectionEnd = strPos;
            txtarea.focus();
        }
        txtarea.scrollTop = scrollPos;
    }
    function insertAtTexteditor(areaId,text) {
//        var txtarea = document.getElementById(areaId);
        CKEDITOR.instances[areaId].insertText(text);
    }
</script>
