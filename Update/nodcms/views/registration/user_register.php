<div class="container">
    <div class="portlet light">
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-7">
                    <?php include __DIR__.'/details/'.$lang.'/user_register.html'; ?>
                </div>
                <div class="col-md-5">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-pin font-blue"></i>
                                <span class="caption-subject bold uppercase"> <?php echo _l('Registration Form', $this); ?></span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php if($this->session->flashdata('error_message')){ ?>
                                <div class="note note-danger">
                                    <p>
                                        <?php echo $this->session->flashdata('error_message'); ?>
                                    </p>
                                </div>
                            <?php } ?>
                            <form method="post" action="" role="form">
                                <div class="form-body">
                                    <div class="form-group form-md-line-input form-md-floating-label <?php echo $form_error['fname']!=''?'has-error':'has-info'; ?>">
                                        <input value="<?php echo $set_value['fname']; ?>" name="fname" id="fname" type="text" class="form-control <?php echo $set_value['fname']!=''?'edited':''; ?>" data-validation="required">
                                        <label for="fname"><i class="fa fa-i-cursor"></i> <?php echo _l("First Name",$this)?></label>
                                        <?php if($form_error['fname']!=''){ ?>
                                            <span class="help-block"><?php echo $form_error['fname']; ?></span>
                                        <?php }else{ ?>
                                            <span class="help-block"><?php echo _l('Please enter your first name just with alphabet and space.', $this); ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group form-md-line-input form-md-floating-label <?php echo $form_error['lname']!=''?'has-error':'has-info'; ?>">
                                        <input value="<?php echo $set_value['lname']; ?>" name="lname" id="lname" type="text" class="form-control <?php echo $set_value['lname']!=''?'edited':''; ?>" data-validation="required">
                                        <label for="lname"><i class="fa fa-i-cursor"></i> <?php echo _l("Last Name",$this)?></label>
                                        <?php if($form_error['lname']!=''){ ?>
                                            <span class="help-block"><?php echo $form_error['lname']; ?></span>
                                        <?php }else{ ?>
                                            <span class="help-block"><?php echo _l('Please enter your last name just with alphabet and space.', $this); ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group form-md-line-input form-md-floating-label <?php echo $form_error['mobile']!=''?'has-error':'has-info'; ?>">
                                        <input value="<?php echo $set_value['mobile']; ?>" name="mobile" id="mobile" type="text" class="form-control <?php echo $set_value['mobile']!=''?'edited':''; ?>" data-validation="required">
                                        <label for="mobile"><i class="fa fa-phone"></i> <?php echo _l("Phone Number",$this)?></label>
                                        <?php if($form_error['mobile']!=''){ ?>
                                            <span class="help-block"><?php echo $form_error['mobile']; ?></span>
                                        <?php }else{ ?>
                                            <span class="help-block"><?php echo _l('Please enter your mobile number.', $this); ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group form-md-line-input form-md-floating-label <?php echo $form_error['email']!=''?'has-error':'has-info'; ?>">
                                        <input value="<?php echo $set_value['email']; ?>" name="email" id="email" type="text" class="form-control <?php echo $set_value['email']!=''?'edited':''; ?>" data-validation="required email">
                                        <label for="email"><i class="fa fa-at"></i> <?php echo _l("Email Address",$this)?></label>
                                        <?php if($form_error['email']!=''){ ?>
                                            <span class="help-block"><?php echo $form_error['email']; ?></span>
                                        <?php }else{ ?>
                                            <span class="help-block"><?php echo _l('Please enter your email address. It should be unique in this system.', $this); ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group form-md-line-input form-md-floating-label <?php echo $form_error['username']!=''?'has-error':'has-info'; ?>">
                                        <input value="<?php echo $set_value['username']; ?>" name="username" id="username" type="text" class="form-control <?php echo $set_value['username']!=''?'edited':''; ?>" data-validation="required">
                                        <label for="username"><i class="fa fa-user"></i> <?php echo _l("Username",$this)?></label>
                                        <?php if($form_error['username']!=''){ ?>
                                            <span class="help-block"><?php echo $form_error['username']; ?></span>
                                        <?php }else{ ?>
                                            <span class="help-block"><?php echo _l('Please enter an unique username.', $this); ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group form-md-line-input form-md-floating-label <?php echo $form_error['password']!=''?'has-error':'has-info'; ?>">
                                        <input value="<?php echo $set_value['password']; ?>" name="password" id="password" type="password" class="form-control <?php echo $set_value['password']!=''?'edited':''; ?>" data-validation="required">
                                        <label for="password"><i class="fa fa-user"></i> <?php echo _l("Password",$this)?></label>
                                        <?php if($form_error['password']!=''){ ?>
                                            <span class="help-block"><?php echo $form_error['password']; ?></span>
                                        <?php }else{ ?>
                                            <span class="help-block"><?php echo _l('Please enter a password between 6 and 16 character for your account.', $this); ?></span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success"><?php echo _l("Submit",$this); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/form-validator/jquery.form-validator.js"></script>
<script>
    $(function(){
        $.validate({
            onError: function($form){
                $form.submit(function (e) {
                    e.preventDefault();
                });
            },
            onElementValidate: function(rsu, element){
                element.next().next().remove();
//                element.parent().removeClass('has-info').addClass('has-error');
            },
            <?php if($lang!='en'){ ?>lang: '<?php echo $lang; ?>'<?php } ?>
        });
    });
</script>