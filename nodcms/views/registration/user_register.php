<section class="inner-page-banner">

    <div class="banner_wrapper">

        <div class="banner_content">

            <h1>Register</h1>

        </div>

    </div>

</section>



<section class="register-user">
    <div class="container">
        <div class="section-heading">
            <h1>Register As A User</h1>
            <div class="cus-hr"></div>
        </div>

        <form method="post" action="" role="form" class="has-validation-callback">
            <div class="row">
                <div class="col-sm-6">
                    <input placeholder="First Name *" value="<?php echo $set_value['fname']; ?>" name="fname" id="fname" type="text" class="form-control <?php echo $set_value['fname']!=''?'edited':''; ?>" data-validation="required">

                    <?php if($form_error['fname']!=''){ ?>
                        <span class="help-block"><?php echo $form_error['fname']; ?></span>
                    <?php }else{ ?>
                        <span class="help-block"></span>
                    <?php } ?>
                </div>

                <div class="col-sm-6">

                    <input placeholder="Last Name *" value="<?php echo $set_value['lname']; ?>" name="lname" id="lname" type="text" class="form-control <?php echo $set_value['lname']!=''?'edited':''; ?>" data-validation="required">

                    <?php if($form_error['lname']!=''){ ?>

                        <span class="help-block"><?php echo $form_error['lname']; ?></span>

                    <?php }else{ ?>

                        <span class="help-block"></span>

                    <?php } ?>                  

                </div>

            </div>

            <div class="row">

                <div class="col-sm-6">

                    <input placeholder="Email *" value="<?php echo $set_value['email']; ?>" name="email" id="email" type="text" class="form-control <?php echo $set_value['email']!=''?'edited':''; ?>" data-validation="required email">

                    <?php if($form_error['email']!=''){ ?>

                        <span class="help-block"><?php echo $form_error['email']; ?></span>

                    <?php }else{ ?>

                        <span class="help-block"></span>

                    <?php } ?>                      

                </div>

                <div class="col-sm-6">

                    <input placeholder="Phone (e.g.00398738927892)" value="<?php echo $set_value['mobile']; ?>" name="mobile" id="mobile" type="text" class="form-control <?php echo $set_value['mobile']!=''?'edited':''; ?>" >

					<span style="position: absolute;top: 15px;color: #518ed2;right: 22px;font-size: 21px;" class="help glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" data-original-title="Your number might be useful for the dentist to contact you directly"></span>
                    <?php if($form_error['mobile']!=''){ ?>

                        <span class="help-block"><?php echo $form_error['mobile']; ?></span>

                    <?php }else{ ?>

                        <span class="help-block"></span>

                    <?php } ?>                   

                </div>
				
				
			<?php /*	<div class="col-sm-12">

                    <input placeholder="Your address" value="<?php echo $set_value['address']; ?>" name="address" id="address" type="text" class="form-control <?php echo $set_value['address']!=''?'edited':''; ?>" data-validation="required">

                    <?php if($form_error['address']!=''){ ?>

                        <span class="help-block"><?php echo $form_error['address']; ?></span>

                    <?php }else{ ?>

                        <span class="help-block"></span>

                    <?php } ?>                   

                </div> */ ?>
				
				
			<?php /*	<div class="col-sm-12">
				
				<textarea placeholder="About yourself" class="form-control <?php echo $set_value['about']!=''?'edited':''; ?>" data-validation="required" name="about" ><?php echo $set_value['address']; ?></textarea>

                    <?php if($form_error['address']!=''){ ?>

                        <span class="help-block"><?php echo $form_error['address']; ?></span>

                    <?php }else{ ?>

                        <span class="help-block"></span>

                    <?php } ?>                   

                </div> */ ?>

            </div>

            <div class="row">

                <?php /*<div class="col-sm-6">

                    <input placeholder="Username" value="<?php echo $set_value['username']; ?>" name="username" id="username" type="text" class="form-control <?php echo $set_value['username']!=''?'edited':''; ?>" data-validation="required">

                    <?php if($form_error['username']!=''){ ?>

                        <span class="help-block"><?php echo $form_error['username']; ?></span>

                    <?php }else{ ?>

                        <span class="help-block"><?php echo _l('Please enter an unique username.', $this); ?></span>

                    <?php } ?>                 

                </div> */?>

                <div class="col-sm-6">

                    <input placeholder="Password *" value="<?php echo $set_value['password']; ?>" name="password" id="password" type="password" class="form-control <?php echo $set_value['password']!=''?'edited':''; ?>" data-validation="required">

                    <?php if($form_error['password']!=''){ ?>

                        <span class="help-block"><?php echo $form_error['password']; ?></span>

                    <?php }else{ ?>

                        <span class="help-block"></span>

                    <?php } ?>                    

                </div>

                

                <div class="col-sm-6">

                    <input placeholder="Confirm Password *" value="<?php echo $set_value['cpassword']; ?>" name="cpassword" id="cpassword" type="password" class="form-control <?php echo $set_value['cpassword']!=''?'edited':''; ?>" data-validation="required">

                    <?php if($form_error['cpassword']!=''){ ?>

                        <span class="help-block"><?php echo $form_error['cpassword']; ?></span>

                    <?php }else{ ?>

                        <span class="help-block"></span>

                    <?php } ?>                    

                </div>

            </div>

            <div class="row">

                <div class="col-sm-12">

                    <button type="submit" class="greyButton">REGISTER</button>

                </div>

            </div>

        </form>

    </div>

</section>



<?php /*

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



*/?>



<script src="<?php echo base_url(); ?>assets/form-validator/jquery.form-validator.js"></script>

<script>

    $(function(){
$('[data-toggle="tooltip"]').tooltip(); 
        $.validate({

            onError: function($form){
				console.log($form);
                $form.submit(function (e) {

                    //e.preventDefault();

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