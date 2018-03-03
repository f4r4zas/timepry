<div class="row">
    <div class="col-sm-6">
        <div class="note note-info">
            <h4 class="block"><i class="icon-info"></i> <?php echo _l('Information!',$this); ?></h4>
            <p><?php echo _l('With this form you can generate your custom button code!',$this); ?></p>
            <p><?php echo _l('The basic code is just a script tag with id="portable_code" and below URL for src',$this); ?>:</p>
            <p><b><?php echo base_url() ?>en/external</b></p>
        </div>
        <?php
        mk_hpostform('','btn-generator');
        mk_hselect('lang',_l('Default Language',$this),$languages,'code','language_name');
        mk_htext('btnText',_l('Button Text',$this));
        mk_htext('btnClass',_l('Button Class',$this));
        ?>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button id="doGenerate" type="button" class="btn green">
                    <i class="icon-magic-wand"></i> <?php echo _l('Get portable button!',$this); ?>
                </button>
            </div>
        </div>
        <?php
        mk_closeform();
        ?>
    </div>
    <div class="col-sm-6">
        <div class="note note-warning empty-msg">
            <h4 class="block"><?php echo _l('Empty!',$this); ?></h4>
            <p><?php echo _l('Please fill the form to get your portable code.',$this); ?></p>
        </div>
        <div class="hidden code-panel">
            <div class="note note-success">
                <h4 class="block"><?php echo _l('Portable code usage!',$this); ?></h4>
                <p><?php echo _l('Copy below code and past it to where you want to show the button!',$this); ?></p>
            </div>
            <textarea id="portable_code" onclick="$(this).select();" class="form-control" readonly></textarea>
        </div>
    </div>
</div>
<script>
    $(function(){
       $('#doGenerate').click(function(){
           var myCode = '<script id="btnNodAPS" src="<?php echo base_url(); ?>' + $('#lang').val() + '/provider/<?php echo $provider_data['provider_username']; ?>/external';
           var options = '';
           if($('#btnText').val()!=''){
               options = 'btnText=' + $('#btnText').val();
           }
           if($('#btnClass').val()!=''){
               if(options != '') options += '&';
               options += 'btnClass=' + $('#btnClass').val();
           }
           if(options != '') myCode += '?' + options;
           myCode += '"></' + 'script>';
           $('#portable_code').val(myCode);
           $('.code-panel').removeClass('hidden');
           $('.empty-msg').remove();
       });
    });
</script>