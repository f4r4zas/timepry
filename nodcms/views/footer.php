    </div>

    <footer id="footer">
        <div class="footer_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 box">
                        <div class="footer_logo">
                            <img src="http://techopialabs.com/timepry/assets/front/images/timepry_footer_logo.png" alt="Timepry">
                        </div>
                        <div class="details">
                            <p>
                                This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio.  Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate curs
                            </p>
                        </div>
                    </div>

                    <div class="col-md-2 box">
                        <div class="title">Follow Us On</div>
                        <div class="social_icons">
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-facebook-square"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-twitter-square"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-google-plus-square"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="details">
                            <p>
                                Lorem ipsum dolor sit amet, consectt dipiscing elit esent vestibulum molestie lacus. Aenean nonmy hendrerit mauris. Phasellus porta. Fusce suit varius mi.
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-2 box">
                        <div class="title">Company</div>
                        <div class="links">
                            <ul>
                                <li><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-2 box">
                        <div class="title">Links</div>
                        <div class="links">
                            <ul class="menu">
                                <li>
                                    <a href="index.php">Home</a>
                                </li>
                                <li>
                                    <a href="about">About</a>
                                </li>
                                <li>
                                    <a href="faq">FAQ</a>
                                </li>
                                <li>
                                    <a href="contact">Contact</a>
                                </li>
                                <li>
                                    <a href="register">Signup</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="showLogin">Login</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="copyright">
            <div class="container">
                <p>
                    Copyright &copy; 2017 Timepry. All Rights Reserved
                </p>
            </div>
        </div>
    </footer>

    <div class="black_overlay"></div>
    <div id="loginBox">
        <div class="box_wrapper">
            <div class="section-heading">
                <h1>Login</h1>
                <div class="cus-hr"></div>
            </div>
            <div class="fields">
                <form class="login-form" action="<?php echo base_url(); ?>admin-sign/login" method="post">
                    <?php if($this->session->flashdata('message')){ ?>
                   <?php if(!is_array($this->session->flashdata('message'))){ ?>
						
						<div class="alert alert-danger">
							<button class="close" data-close="alert"></button>
							
								<span><?php echo $this->session->flashdata('message'); ?></span>
							
						</div>
						
						<?php } ?>
                    <?php } ?>
                    <div class="form-group input-field">
                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                        <!--<label class="control-label visible-ie8 visible-ie9"><?php echo _l('Username',$this); ?></label>-->
                        <input class="form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" data-validation="required"/>
                    </div>
                    <div class="form-group input-field">
                        <!--<label class="control-label visible-ie8 visible-ie9"><?php echo _l('Password',$this); ?></label>-->
                        <input class="form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" data-validation="required"/>
                    </div>
                    <div class="form-group forget_pass">
                        <a href="javascript:void(0)" id="forgot_password-trigger">Forget Password?</a>
                    </div>
                    <div class="form-actions submit-btn">
                        <input type="submit" value="<?php echo _l('Login',$this); ?>" class="greyButton">
                    </div>
                </form>
            
            
                <!--<div class="input-field">
                    <input type="text" name="email" placeholder="Email">
                </div>
                <div class="input-field">
                    <input type="password" name="password" placeholder="Password">
                </div>
                
                <div class="submit-btn">
                    <input type="button" value="Login" class="greyButton">
                </div>
                <div id="errorMsg"></div>-->
            </div>
        </div>
    </div>

    <div id="forget_pass">
        <div class="box_wrapper">
            <div class="section-heading">
                <h1>Forgot Password</h1>
                <div class="cus-hr"></div>
            </div>
            <div class="fields">
                <div class="input-field">
                    <input type="text" name="email" placeholder="Enter Your Email">
                </div>
                <div class="submit-btn">
                    <input type="button" value="Submit" class="greyButton">
                </div>
                <div id="errorMsg"></div>
            </div>
        </div>
    </div>

    <div id="   ">
        <div class="closepopup">
            <i class="fa fa-times"></i>
        </div>
        <div class="doc-img">
            <div class="popup_wrapper">
                <div class="text">
                    <p>FREE ONLINE BOOKING WITH</p>
                    <p class="heavy-font">OVER 3,500 NHS AND PRIVATE DENTISTS</p>
                </div>
                <div class="learnmore_btn_wrraper">
                    <a href="#" class="greyButton">Learn More</a>
                </div>
            </div>
        </div>
    </div>

<div class="se-pre-con"></div>
    <script src="<?php echo base_url();?>assets/front/js/dropzone.js"></script>
    <script async defer src="<?php echo base_url();?>assets/front/js/bootstrap.min.js"></script>
    <script async defer src="<?php echo base_url();?>assets/front/js/slick.js"></script>
    <script async defer src="<?php echo base_url();?>assets/front/js/scripts.js"></script>
    <script async defer src="<?php echo base_url();?>assets/front/js/google-map.js"></script>

    <script src='<?php echo base_url();?>assets/front/js/lib/moment.min.js'></script>
    <script src='<?php echo base_url();?>assets/front/js/lib/fullcalendar.js'></script>


    <script>
        var enableHomePopup = false;
        $(document).ready(function() {
            $(".se-pre-con").css("display", "none");
            if ( $('.home-banner').length > 0 ) {
                if (enableHomePopup) {
                    setTimeout(function() {
                        $('#site_auto_popup').show();
                        $('.black_overlay').show();
                    }, 2000);
                }
            }
        });
        $('#mobilemenuBtn').on('click', function() {
            $('nav.menu_nav').toggleClass('show');
        });

        $('.showLogin').on('click', function() {
            $('#loginBox').show();
            $('.black_overlay').show();            
        });

        $('.black_overlay').on('click', function() {
            $('#loginBox').hide();
            $('#forget_pass').hide();
            $('#beforeCheckout_popout').hide();
            if ( $('#site_auto_popup').is(':hidden') ){
                $('.black_overlay').hide();
            }
        });
        $('#site_auto_popup .closepopup').on('click', function() {
            $('.black_overlay').hide();
            $('#site_auto_popup').hide();
        });

        $('.treatment-box .details_arrow').click(function() {
            $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
            $(this).parents('.treatment-box').find('.treatment-details .detailsDiv').toggleClass('active');
        });

        var orderTotal = '0';
        $('.treatment-box .add_service').click(function() {

            orderTotal = '';
            var getPrice = $(this).parents('.treatment-box').find('.prices').text().replace('$', '');
            var price = $('#service_price').text();
            var servicesCount = $('#service_count').text();
            $(this).find('i').toggleClass('fa-plus-square-o fa-check-square-o');

            if ( $(this).find('i').hasClass('fa-check-square-o') ) {
                $(this).css('font-size', '25px');
                orderTotal =  Number(price) + Number(getPrice);
                $('#service_price').text( orderTotal );
                $('#service_count').text( Number(servicesCount) + 1 );
            }else{
                $(this).css('font-size', '30px');
                orderTotal =  Number(price) - Number(getPrice);
                $('#service_price').text( orderTotal );
                $('#service_count').text( Number(servicesCount) - 1 );                
            }
        });

        $('#services_booknow').click(function() {
            $('.black_overlay').show();

            var selectedServices = $('.tab-content').find('.fa-check-square-o');
            var bodyToAppend = '';

            console.log(orderTotal);
            if ( orderTotal == '0' || orderTotal == '' ) {
                $('#beforeCheckout_popout').find('.order_total').find('.greyButton').addClass('disabledAction');
            }else{
                $('#beforeCheckout_popout').find('.order_total').find('.greyButton').removeClass('disabledAction');
            }

            for (var i = 0; i < selectedServices.length; i++) {

                var serviceName = selectedServices.eq(i).parents('.treatment-box').find('.treatment-title').text();
                var serviceDuration = selectedServices.eq(i).parents('.treatment-box').find('.duration').html();
                var serviceRates = selectedServices.eq(i).parents('.treatment-box').find('.prices').text().replace('$', '');

                bodyToAppend += '<div class="selservice_box">'
                        + '<div class="row">'
                        + '<div class="col-md-8">'
                        + '<div class="service_title">'+ serviceName +'</div>'
                        + '<div class="service_duration">'+ serviceDuration +'</div>'
                        + '</div>'

                        + '<div class="col-md-4">'
                        + '<div class="service_rates">From $<span class="price">'+ serviceRates +'</span></div>'
                        + '</div>'
                        + '</div>'
                        + '</div>';

            }
            $('#selected_services').html(bodyToAppend);
            $('#beforeCheckout_popout').find('.order_total').find('.total_prices .rates').text( orderTotal );
            $('#beforeCheckout_popout').show();
        });

        $('.addmore_services').click(function() {
            $('.black_overlay').hide();
            $('#beforeCheckout_popout').hide();
        });

        $("#forgot_password-trigger").click(function() {
            $('#loginBox').hide();
            $('#forget_pass').show();
        });

        $("#loadMap").click(function() {
            setTimeout(function () {
                registerMap();
            }, 1300);
        });

        function s_tab(e) {
            var tab = $(e.target);
            $('.s_tab').removeClass('active');
            tab.addClass('active');
            $(".tab_content").removeClass("active");
            $("#tabcontent-" + tab.attr('data-tab')).addClass("active");
        }
    </script>

<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			defaultDate: '2017-10-12',
			navLinks: true,
			editable: false,
            eventLimit: true, // allow "more" link when too many events
            displayEventTime: true,
            displayEventEnd: true,
            evenTimeFormat: 'small',
			events: [
				{
					title: 'Conference',
					start: '2017-10-11',
					end: '2017-10-11'
				},
				{
					title: 'Meeting',
					start: '2017-10-23T10:30:00',
					end: '2017-10-23T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2017-10-23T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2017-10-23T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2017-10-23T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2017-10-23T20:00:00'
				},
				{
					title: 'Test',
					start: '2017-10-23T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2017-10-13T07:00:00'
				}
			]
        });
		
    });

</script>
</body>
</html>