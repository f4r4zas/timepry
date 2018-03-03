<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <section class="panel">
            <header class="panel-heading">
                <?=_l('Account settings',$this)?>
            </header>
            <div class="panel-body">
                <?php if($this->session->flashdata('form_error')){ ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('form_error'); ?>
                </div>
                <?php } ?>
                <div class=" form">
                    <?php
                    mk_hpostform();
                    mk_htext("data[username]",_l('Username',$this),isset($data['username'])?$data['username']:'');
                    mk_hemail("data[email]",_l('Email',$this),isset($data['email'])?$data['email']:'');
                    mk_htext("data[fullname]",_l('Full Name',$this),isset($data['fullname'])?$data['fullname']:'');
                    mk_hpassword("data[password]",_l('Password',$this));
                   // mk_hselect("data[language_id]",_l('language',$this),$languages,"language_id","language_name",isset($data['language_id'])?$data['language_id']:null,null,'style="width:200px"');
                    mk_hsubmit(_l('Submit',$this),APPOINTMENT_ADMIN_URL,_l('Cancel',$this));
                    mk_closeform();
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>
