<?php

$CI = get_instance();

// You may need to load the model if it hasn't been pre-loaded
$CI->load->model('Appointment_model');

if(!$this->session->userdata("checkout")){
    redirect(base_url());
}
parse_str($this->session->userdata("checkout"), $outputArray);

get_instance()->load->helper('user');

$totalReservations = getNoReservations($this->session->userdata("email"));

?>


    <style>
        .steps {
            margin-top: -41px;
            display: inline-block;
            float: right;
            font-size: 16px
        }

        .step {
            float: left;
            background: white;
            padding: 7px 13px;
            border-radius: 1px;
            text-align: center;
            width: 100px;
            position: relative
        }

        .step_line {
            margin: 0;
            width: 0;
            height: 0;
            border-left: 16px solid #fff;
            border-top: 16px solid transparent;
            border-bottom: 16px solid transparent;
            z-index: 1008;
            position: absolute;
            left: 99px;
            top: 1px
        }

        .step_line.backline {
            border-left: 20px solid #f7f7f7;
            border-top: 20px solid transparent;
            border-bottom: 20px solid transparent;
            z-index: 1006;
            position: absolute;
            left: 99px;
            top: -3px
        }

        .step_complete {
            background: #357ebd
        }

        .step_complete a.check-bc, .step_complete a.check-bc:hover, .afix-1, .afix-1:hover {
            color: #eee;
        }

        .step_line.step_complete {
            background: 0;
            border-left: 16px solid #357ebd
        }

        .step_thankyou {
            float: left;
            background: white;
            padding: 7px 13px;
            border-radius: 1px;
            text-align: center;
            width: 100px;
        }

        .step.check_step {
            margin-left: 5px;
        }

        .ch_pp {
            text-decoration: underline;
        }

        .ch_pp.sip {
            margin-left: 10px;
        }

        .check-bc,
        .check-bc:hover {
            color: #222;
        }

        .SuccessField {
            border-color: #458845 !important;
            -webkit-box-shadow: 0 0 7px #9acc9a !important;
            -moz-box-shadow: 0 0 7px #9acc9a !important;
            box-shadow: 0 0 7px #9acc9a !important;
            background: #f9f9f9 url(../images/valid.png) no-repeat 98% center !important
        }

        .btn-xs {
            line-height: 28px;
        }

        /*login form*/
        .login-container {
            margin-top: 30px;
        }

        .login-container input[type=submit] {
            width: 100%;
            display: block;
            margin-bottom: 10px;
            position: relative;
        }

        .login-container input[type=text], input[type=password] {
            height: 44px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 10px;
            -webkit-appearance: none;
            background: #fff;
            border: 1px solid #d9d9d9;
            border-top: 1px solid #c0c0c0;
            /* border-radius: 2px; */
            padding: 0 8px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .login-container input[type=text]:hover, input[type=password]:hover {
            border: 1px solid #b9b9b9;
            border-top: 1px solid #a0a0a0;
            -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .login-container-submit {
            /* border: 1px solid #3079ed; */
            border: 0px;
            color: #fff;
            text-shadow: 0 1px rgba(0, 0, 0, 0.1);
            background-color: #357ebd; /*#4d90fe;*/
            padding: 17px 0px;
            font-family: roboto;
            font-size: 14px;
            /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
        }

        .login-container-submit:hover {
            /* border: 1px solid #2f5bb7; */
            border: 0px;
            text-shadow: 0 1px rgba(0, 0, 0, 0.3);
            background-color: #357ae8;
            /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
        }

        .login-help {
            font-size: 12px;
        }

        .asterix {
            background: #f9f9f9 url(../images/red_asterisk.png) no-repeat 98% center !important;
        }

        /* images*/
        ol, ul {
            list-style: none;
        }

        .hand {
            cursor: pointer;
            cursor: pointer;
        }

        .cards {
            padding-left: 0;
        }

        .cards li {
            -webkit-transition: all .2s;
            -moz-transition: all .2s;
            -ms-transition: all .2s;
            -o-transition: all .2s;
            transition: all .2s;
            background-image: url('//c2.staticflickr.com/4/3713/20116660060_f1e51a5248_m.jpg');
            background-position: 0 0;
            float: left;
            height: 32px;
            margin-right: 8px;
            text-indent: -9999px;
            width: 51px;
        }

        .cards .mastercard {
            background-position: -51px 0;
        }

        .cards li {
            -webkit-transition: all .2s;
            -moz-transition: all .2s;
            -ms-transition: all .2s;
            -o-transition: all .2s;
            transition: all .2s;
            background-image: url('//c2.staticflickr.com/4/3713/20116660060_f1e51a5248_m.jpg');
            background-position: 0 0;
            float: left;
            height: 32px;
            margin-right: 8px;
            text-indent: -9999px;
            width: 51px;
        }

        .cards .amex {
            background-position: -102px 0;
        }

        .cards li {
            -webkit-transition: all .2s;
            -moz-transition: all .2s;
            -ms-transition: all .2s;
            -o-transition: all .2s;
            transition: all .2s;
            background-image: url('//c2.staticflickr.com/4/3713/20116660060_f1e51a5248_m.jpg');
            background-position: 0 0;
            float: left;
            height: 32px;
            margin-right: 8px;
            text-indent: -9999px;
            width: 51px;
        }

        .cards li:last-child {
            margin-right: 0;
        }

        /* images end */

        /*
         * BOOTSTRAP
         */
        .container {
            border: none;
        }

        .panel-footer {
            background: #fff;
        }

        .btn {
            border-radius: 1px;
        }

        .btn-sm, .btn-group-sm > .btn {
            border-radius: 1px;
        }

        .input-sm, .form-horizontal .form-group-sm .form-control {
            border-radius: 1px;
        }

        .panel-info {
            border-color: #eee;
            border-width: 3px;
        }

        .panel-heading {
            border-top-left-radius: 1px;
            border-top-right-radius: 1px;
        }

        .panel {
            border-radius: 1px;
        }

        .panel-info > .panel-heading {
            color: #eee;
            border: none;
        }

        .panel-info > .panel-heading {
            background-image: linear-gradient(to bottom, #555 0px, #888 100%);
        }

        hr {
            border-color: #999 -moz-use-text-color -moz-use-text-color;
        }

        .panel-footer {
            border-bottom-left-radius: 1px;
            border-bottom-right-radius: 1px;
            border-top: 1px solid #999;
        }

        .btn-link {
            color: #888;
        }

        hr {
            margin-bottom: 10px;
            margin-top: 10px;
        }

        /** MEDIA QUERIES **/
        @media only screen and (max-width: 989px) {
            .span1 {
                margin-bottom: 15px;
                clear: both;
            }
        }

        @media only screen and (max-width: 764px) {
            .inverse-1 {
                float: right;
            }
        }

        @media only screen and (max-width: 586px) {
            .cart-titles {
                display: none;
            }

            .panel {
                margin-bottom: 1px;
            }
        }

        .form-control {
            border-radius: 1px;
        }

        @media only screen and (max-width: 486px) {
            .col-xss-12 {
                width: 100%;
            }

            .cart-img-show {
                display: none;
            }

            .btn-submit-fix {
                width: 100%;
            }
        }

        .radio {
            width: auto !important;
            float: left;
        }

        .radio span {
            margin-left: 22px;
        }

        .panel-heading {
            background-color: #e5e5e5a6 !important;
            background-image: none !important;
            font-size: 18px;
            padding: 20px 31px;
        }
        .panel-heading strong {
            color:black;
        }
        .panel-heading span {
            color:black;
        }
        .price {
            font-size: 17px;
        }
        .date-treatment {
            color: #4ba7ff;
        }
        .heading-treatment {
            font-size: 18px;
            font-weight: bold;
        }
        .section-heading .cus-hr {
            width: 96%;
            height: 5px;
            margin: 0 auto;
            margin-top: 18px;
            background-color: #518ed2;
        }
        .faq-page .section-heading {
            margin-bottom: 10px;
        }
        .radio-payment {
            padding-left: 0;
        }
        .register-link {
            border-top: 1px solid #c3baba;
        }
        .register-link a {
            color: #47a6ff;
            text-transform: uppercase;
            font-weight: bold;
            padding-top: 21px;
            font-size: 16px;
        }
        .reset-link a{
            color: #47a6ff;
            font-weight: bold;
            padding-top: 21px;
            font-size: 16px;
        }
    </style>

    <section class="inner-page-banner">
        <div class="banner_wrapper">
            <div class="banner_content">
                <h1>Checkout</h1>
            </div>
        </div>
    </section>

    <section class="faq-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="faq_for_dentist">
                        <div class="faq-inner">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <div class="col-md-3 you_label">
                                        <label class="control-label ">
                                            Is this for you?
                                        </label>
                                    </div>
                                    <div class="col-md-6 you_radio">
                                        <div class="radio">

                                            <label class="radio">
                                                <input name="you" <?php if($this->session->userdata('radioYou') == 1){ echo "checked"; }else{  if(empty($this->session->userdata('radioYou'))){echo "checked";}else{echo "";}  } ?> type="radio" value=1 />
                                                <span>Yes</span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label class="radio">
                                                <input name="you" <?php if($this->session->userdata('radioYou') == 2){ echo "checked"; }else{ echo ""; } ?> type="radio" value=2 />
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                <div class="col-md-12 text-left">
                                    <div class="section-heading pull-left">
                                        <h1>Payment</h1>
                                        <div class="cus-hr"></div>
                                    </div>
                                </div>
                                    <div class="col-md-12 radio-payment">
                                        <div class="radio">
                                            <label class="radio">

                                                <input name="paymentMethod" <?php if($this->session->userdata('radioPayment') == "1"){ echo "checked"; }else{ if(empty($this->session->userdata('radioPayment'))){ echo "checked"; }else{echo "";}  } ?> type="radio" value="1"/>
                                                <span>Pay at the dental office</span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label class="radio">
                                                <input name="paymentMethod" <?php if($this->session->userdata('radioPayment') == "2"){ echo "checked"; }else{echo "";} ?> type="radio" value="2"/>
                                                <span>Credit Card</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <hr/>
                                </div>

                                <?php
                                if ($this->session->userdata("logged_in_status")) {
                                    $name = explode(" ", $this->session->userdata('fullname'));
                                    if (count($name) > 1) {
                                        $fname = $name[0];
                                        $lname = $name[1];
                                    } else {
                                        $name = $name;
                                    }
                                    $email = $this->session->userdata('email');
                                    $phone = $this->session->userdata('phone');

                                }
                                ?>

                                <?php if($this->session->userdata("logged_in_status")){ ?>

                                    <form id="checkout">
                                        <div id="final_treatment">
                                            <?php
                                            //print_r($outputArray);
                                            $sizeOfarray = count($outputArray['service']) - 1;
                                            for ($i = 0; $i <= $sizeOfarray; $i++) {

                                                ?>
                                                <input type="hidden" class="final_treatment_field<?php echo $outputArray['service'][$i] ?> service" value="<?php echo $outputArray['service'][$i]; ?>" name="service[]">
                                                <input type="hidden" class="final_treatment_field<?php echo $outputArray['service'][$i] ?> practitioner" value="<?php echo $outputArray['practitioner'][$i]; ?>" name="practitioner[]">
                                                <input type="hidden" class="final_treatment_field<?php echo $outputArray['service'][$i] ?> date" value="<?php echo $outputArray['date'][$i]; ?>" name="date[]">
                                                <input type="hidden" class="final_treatment_field<?php echo $outputArray['service'][$i] ?> time" value="<?php echo $outputArray['time'][$i]; ?>" name="time[]">

                                            <?php } ?>
                                        </div>

                                        <div class="form-group">
                                            <input type="hidden" name="paymentType" value="1">
                                            <label><?php echo _l("First Name", $this) ?></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-i-cursor"></i></div>
                                                <input value="<?php if (!empty($fname)) {
                                                    echo $fname;
                                                } else if (!empty($name)) {
                                                    echo $name;
                                                } ?>" name="fname" id="fname" type="text" class="form-control"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo _l("Last Name", $this) ?></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-i-cursor"></i></div>
                                                <input value="<?php if (!empty($lname)) {
                                                    echo $lname;
                                                } else if (!empty($name)) {
                                                    echo $name;
                                                } ?>" name="lname" id="lname" type="text" class="form-control"
                                                       data-validation="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo _l("Email Address", $this) ?></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-at"></i></div>

                                                <input value="<?php if (!empty($email)) {
                                                    echo $email;
                                                } ?>" name="email" id="email" type="text" class="form-control"
                                                       data-validation="required email">

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo _l("Phone Number", $this) ?></label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                <input value="<?php if (!empty($phone)) {
                                                    echo $phone;
                                                } ?>" name="tel" id="phone" type="text" class="form-control"
                                                       data-validation="required number">
                                            </div>
                                        </div>
                                    </form>

                                <?php }else{ ?>
                                    <form class="login-form" action="<?php echo base_url(); ?>admin-sign/login" method="post">
                                        <h3 class="form-title"><?php echo _l('Login',$this); ?></h3>
                                        <?php if($this->session->flashdata('message')){ ?>
                                            <div class="alert alert-danger">
                                                <button class="close" data-close="alert"></button>
                                                <span><?php echo $this->session->flashdata('message'); ?></span>
                                            </div>
                                        <?php } ?>
                                        <div class="">
                                            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                                            <input class="form-control same-height" type="text" autocomplete="off" placeholder="Username" name="username" data-validation="required"/>
                                        </div>
                                        <div class="">
                                            <input class="form-control same-height" type="password" autocomplete="off" placeholder="Password" name="password" data-validation="required"/>
                                        </div>

                                        <div class="form-group reset-link">
                                            <a href="<?php echo base_url(); ?>change-password" class="pull-right">Reset Password</a>
                                        </div>
                                        <div class="form-actions form-group ">
                                            <input type="submit" class="greyButton loginHere" value="Login">
                                        </div>

                                        <div class="form-group register-link">
                                            <a href="#" class="pull-right">Register</a>
                                        </div>
                                    </form>
                                <?php } ?>

                                <br>
                                <div class="form-group">
                                    <hr/>
                                </div>


                                <div class="form-group text-center">
                                    <!--<h1 class="text-center">Order total</h1>
                                    <p class="total_prices text-center">
                                        <?php /*$dcAmount = $total * $discount / 100; */?>
                                    <h2 class="text-center">€<span class="rates"><?php /*echo $total - $dcAmount; */?></span></h2></p>-->



                                    <?php if (!empty($this->session->userdata("logged_in_status"))) { ?>
                                        <input type="button" class="greyButton"  id="doPayment" value="Place Order">
                                        <input type="submit" style="display: none" class="greyButton" onClick="createResrvation()"  id="place-order" value="Place Order">
                                    <?php } ?>

                                </div>

                            </div>
                            <div class="col-md-6">
                                <!--REVIEW ORDER-->
                                <form class="form-horizontal" method="post">
                                    <div class="panel panel-info">

                                        <div class="panel-body">

                                            <?php

                                            $total = 0;
                                            $discount = 0;

                                            if(!empty($this->session->userdata("email"))){
                                                $totalReservations = getNoReservations($this->session->userdata("email"));
                                                if($totalReservations >=10){
                                                    $discount = 20;
                                                }
                                            }

                                            $sizeOfarray = count($outputArray['service']) - 1;
                                            for ($i = 0; $i <= $sizeOfarray; $i++) {

                                                $treatmentData = $CI->Appointment_model->getTreatmentName($outputArray['service'][$i])[0];
                                                $total = $total + $treatmentData['price'];
                                                ?>

                                                <?php if($i>0){ ?>
                                                <div class="form-group">
                                                    <hr/>
                                                </div>
                                                <?php } ?>

                                                <div class="form-group">

                                                    <div class="col-sm-6 col-xs-6 heading-treatment">
                                                        <div class="col-xs-12"><strong><?php echo $treatmentData['title']; ?></strong></div>
                                                        <div class="col-xs-12">
                                                            <small>
                                                                <span><?php echo $treatmentData['period_min'] ?> mins</span>
                                                            </small>
                                                        </div>
                                                        <div class="col-xs-12 date-treatment">
                                                            <small><?php echo $outputArray['time'][$i]; ?>
                                                                <span>|</span>
                                                                <span><?php echo date("d M Y", strtotime($outputArray['date'][$i])); ?></span>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-right price">
                                                        <div class="col-md-12">&nbsp;</div>
                                                        <div class="col-md-12"><strong>€<span><?php echo  $treatmentData['price']; ?></span></strong></div>
                                                        <div class="col-md-12">&nbsp;</div>

                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>



                                        </div>
                                        <div class="panel-heading">
                                            <strong>Order Total</strong>
                                            <div class="pull-right">
                                                <?php $dcAmount = $total * $discount / 100; ?>
                                                <span>€</span><span><?php echo $total - $dcAmount; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!--REVIEW ORDER END-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php $this->load->view("payment_form"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/js/payment.js"></script>
<script>

    $(document).ready(function(){

        $(".redirectToLogin").click(function(){
            window.location.href="<?php echo base_url() ?>admin-sign";
        });

        $(".redirectToRegister").click(function(){
                    window.location.href="<?php echo base_url() ?>register/user-registration";
        });
    });

    function createResrvation(){

        if($("#phone").val() == ""){
            alert("Please fill the phone number");
            return false;
        }


        var totalLoop = $("[name='service[]']").length;
        var start = 0;
        $("[name='service[]']").each(function(){
            $.ajax("<?php echo base_url()."en".$this->session->userdata("provider_prefix"); ?>/set_appointment/" + $(this).val() ,{ data: $('#checkout').serialize() ,type:"POST",async:false },function(data){

            }).done(function(data){
                console.log(data);
                start++;
                if(start == totalLoop){

                    window.location.href="<?php echo base_url(); ?>checkout-complete";
                }

            });
        });


    }

    $("[name='paymentMethod']").change(function(e){

        if($(this).val() == 1){
                $("[name='paymentType']").val(1);
                $("#doPayment").hide();
                $("#place-order").show();
        }else{
            $("[name='paymentType']").val(0);
                $("#doPayment").show();
                $("#place-order").hide();
        }


    });


    $("[name='paymentMethod'],[name='you']").change(function(e){

        var paymentMod = $("[name='paymentMethod']:checked").val();
        var you = $("[name='you']:checked").val();

        saveCheckout(paymentMod,you);

    });


</script>
<script>
    function saveCheckout(payment,foryou){
        $.ajax({url:"<?php echo base_url() ?>General/saveCheckout",async:false,type:"post",data:{payment:payment,you:foryou},function(data){

            console.log(data);


        }});
    }
</script>