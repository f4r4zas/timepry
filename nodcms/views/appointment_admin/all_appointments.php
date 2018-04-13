
<script>
        $(document).ready(function(){
            $(".inner-page-banner").hide();
            $(".inner-page-banner.user").show();
        });
    </script>

    <section class="inner-page-banner user">
        <div class="banner_wrapper">
            <div class="banner_content">
                <h1>All Appointments</h1>
            </div>
        </div>
    </section>

    <section class="dashboard_area" style="padding-top:0px">
        <div class="">
            <div class="section-heading">
                <?php
                $this->db->select('*');
                $this->db->from('users');
                $this->db->where('user_id',$this->session->userdata('user_id'));
                $query = $this->db->get();
                $user_info = $query->result();?>

            </div>

            <div style="display: none" class="msgs-graph">
                <div class="row">
                    <div class="col-md-4" style="display: none;">
                        <div class="recent_msgs">
                            <div class="recent_msgs-inner">
                                <div class="heading">Recent Messages</div>
                                <div class="msgs_view">
                                    <!-- message 1 -->
                                    <div class="msg_item">
                                        <div class="user_avatar">
                                            <img src="<?php echo base_url()?>assets/reservation/img/display_image.png" alt="Username">
                                        </div>
                                        <div class="msg_meta">
                                            <p class="username">Kim Jimmy</p>
                                            <p class="message_text">Hi, How are you?</p>
                                            <p class="date_time">11/7/2017 | 11:30 PM</p>
                                        </div>
                                    </div>
                                    <!-- message 2 -->
                                    <div class="msg_item">
                                        <div class="user_avatar">
                                            <img src="<?php echo base_url()?>assets/reservation/img/display_image.png" alt="Username">
                                        </div>
                                        <div class="msg_meta">
                                            <p class="username">Kim Jimmy</p>
                                            <p class="message_text">Hi, How are you?</p>
                                            <p class="date_time">11/7/2017 | 11:30 PM</p>
                                        </div>
                                    </div>
                                    <!-- message 3 -->
                                    <div class="msg_item">
                                        <div class="user_avatar">
                                            <img src="<?php echo base_url()?>assets/reservation/img/display_image.png" alt="Username">
                                        </div>
                                        <div class="msg_meta">
                                            <p class="username">Kim Jimmy</p>
                                            <p class="message_text">Hi, How are you?</p>
                                            <p class="date_time">11/7/2017 | 11:30 PM</p>
                                        </div>
                                    </div>
                                    <!-- message 4 -->
                                    <div class="msg_item">
                                        <div class="user_avatar">
                                            <img src="<?php echo base_url()?>assets/reservation/img/display_image.png" alt="Username">
                                        </div>
                                        <div class="msg_meta">
                                            <p class="username">Kim Jimmy</p>
                                            <p class="message_text">Hi, How are you?</p>
                                            <p class="date_time">11/7/2017 | 11:30 PM</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="week_appointments">
                            <div class="heading">10 Reservation Card</div>
                            <div class="reservation-cards">
                                <?php
                                $this->db->select('*');
                                $this->db->from('r_reservation')->join('r_providers', 'r_reservation.provider_id = r_providers.provider_id');;
                                $this->db->where('email',$user_info[0]->email);

                                $query = $this->db->get();
                                $user_reservation = $query->result();
                                $total_reservation = count($user_reservation);

                                $total_price = 0;
                                foreach($user_reservation as $reservation):
                                    $total_price += $reservation->price;
                                endforeach;
                                ?>

                                <?php for($i=1;$i<=10;$i++){
                                    if($i <= $total_reservation){
                                        $tooth = "tooth-pic.png";
                                    } else {
                                        $tooth = "gtooth-pic.png";
                                    }
                                    ?>
                                    <div class="r-card">
                                        <div class="tooth-img">
                                            <img src="<?php echo base_url()?>assets/reservation/img/<?php echo $tooth;?>" alt="Reservaion Image">
                                        </div>
                                        <div class="r-no">
                                            <div class="inner">
                                                <span class="number"><?php echo $i;?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>



                                <div class="equality">
                                    <span>=</span>
                                </div>

                                <div class="r-full-card">
                                    <div class="inner">
                                        <div class="tooth" style="
    margin: 0 auto;
">
                                            <img src="<?php echo base_url()?>assets/reservation/img/tooth-pic.png" alt="Free Card">
                                        </div>
                                        <div class="text">20% OFF</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="last_appointments" style="margin-top: 0px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading">All Appointments</div>
                        <div class="appointment-header">
                            <div class="cell-c">
                                <span class="t-img"><img src="<?php echo base_url()?>assets/reservation/img/tooth-pic.png" alt="Tooth"></span>

                                <span class="text-bold">Treatments Collected</span>
                            </div>
                            <div class="cell-c">
                                <span class="text">Average value of Treatments collected </span>
                                <span class="price">$<?php echo ceil( $total_price / $total_reservation );?></span>
                            </div>
                        </div>

                        <div class="appointments-list">
                            <!-- appointment 1 -->

                            <?php

                            foreach($user_reservation as $reservation):
                                $end_date = date('Y-m-d H:i', $reservation->reservation_edate_time);

                                $start_date = date('Y-m-d H:i', $reservation->reservation_date_time);

                                $current_date = date('Y-m-d H:i');
                                $currentDate = date('d/m/Y');

                                $reservation_date = date('d/m/Y', $reservation->reservation_date);

                                if($current_date > $end_date){
                                    $status = "pending";
                                } else {
                                    $status = "done";
                                }
                                ?>
                                <div class="appointment" status="<?php echo $status;?>">
                                    <div class="date"><?php echo $reservation_date;?></div>
                                    <div class="time"><?php echo date('H:i', $reservation->reservation_date_time);?> - <?php echo date('H:i', $reservation->reservation_edate_time);?></div>
                                    <div class="patient_name"><?php echo $reservation->fname.' '.$reservation->lname;?></div>
                                    <div class="booked_services"><?php echo $reservation->service_name.' - '.$reservation->reservation_number;?></div>
                                    <div class="status">
                                        <span class="action-<?php echo $status;?>"></span>
                                    </div>

                                    <div class="dental-office-link">

                                        <a href="<?php echo base_url()."en/provider/".$reservation->provider_username; ?>">View Dental Office Office</a>
                                    </div>


                                    <?php if($currentDate > $reservation_date){ ?>

                                        <div class="review">
                                            <button data-providerId="<?php echo $reservation->provider_id; ?>" data-reviewId="<?php echo $reservation->reservation_id; ?>" id="reviewAppointment-<?php echo $reservation->reservation_id; ?>" class="btn btn-primary giveReview">Review</button>
                                        </div>

                                    <?php } ?>


                                </div>
                            <?php endforeach;?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="reviewForm" style="display:none">


    </div>


    <script>

        var reviewStart="";
        reviewStart += "<form id=\"reviewForm\" class=\"form-horizontal\">";
        reviewStart += "	<div class=\"col-md-12\">";
        reviewStart += "		<h4>1) Would you recommend this dental office to a friend?<\/h4>";
        reviewStart += "		<div class=\"rateYo\" data-id=\"1\"><\/div>";
        reviewStart += "	<\/div>";
        reviewStart += "	";
        reviewStart += "	<div class=\"col-md-12\">";
        reviewStart += "		<h4>2) How clean is the dental office?<\/h4>";
        reviewStart += "		<div class=\"rateYo\" data-id=\"2\"><\/div>";
        reviewStart += "	<\/div>";
        reviewStart += "	";
        reviewStart += "	<div class=\"col-md-12\">";
        reviewStart += "		<h4>3) How would you rate the equipment used in the dental office?<\/h4>";
        reviewStart += "		<div class=\"rateYo\" data-id=\"3\"><\/div>";
        reviewStart += "	<\/div>";
        reviewStart += "	";
        reviewStart += "	<div class=\"col-md-12\">";
        reviewStart += "		<h4>4) How would you rate the service and the attention of the dentist\/staff to you?<\/h4>";
        reviewStart += "		<div class=\"rateYo\" data-id=\"4\"><\/div>";
        reviewStart += "	<\/div>";
        reviewStart += "	";
        reviewStart += "	<div class=\"col-md-12\">";
        reviewStart += "		<h4>5) How would you rate the location (e.g. parking availability, proximity to public transportation etc…)?<\/h4>";
        reviewStart += "		<div class=\"rateYo\" data-id=\"5\"><\/div>";
        reviewStart += "	<\/div>";
        reviewStart += "	";
        reviewStart += "	<div class=\"col-md-12\">";
        reviewStart += "		<h4>Leave A Comment<\/h4>";
        reviewStart += "		<textarea class=\"form-control\"><\/textarea>";
        reviewStart += "	<\/div>";
        reviewStart += "	<p class=\"clearfix\"><\/div>";
        reviewStart += "<\/form>";


        jQuery(document).ready(function(){

            jQuery(".giveReview").click(function(){
                var reservationId = jQuery(this).attr("data-reviewid");
                var id = jQuery(this).attr("id");
                var providerId = jQuery(this).attr('data-providerId');

                bootbox.alert({
                    message: reviewStart,
                    size: 'large',
                    buttons: {
                        ok : {
                            label: 'Send Review',
                            className: "btn btn-primary appointment-review",

                        }
                    },
                    callback: function(){

                        //Getting all the ratings on sumit
                        var yo = jQuery(".rateYo").rateYo();
                        var allRatings = yo.rateYo("rating");
                        var valid = true;
                        allRatings.forEach(function (item) {
                            if(item < 1){

                                valid = false;
                            }

                        })

                        if(valid == false){
                            bootbox.alert({
                                size: "small",
                                title: "Alert",
                                message: "Kindly give rating for all questions!!"

                            });
                            return false;
                        }



                        var commentBox  = jQuery("#reviewForm textarea").val();
                        /* $.each( allRatings, function( key, value ) {
                          console.log( key + ": " + value );
                        }); */


                        $.ajax({url: "appointment/saveRating",type:"POST",data:{rating:allRatings,reservation_id:reservationId,comments:commentBox,provider_id:providerId}, success: function(data){

                                bootbox.alert({
                                    size: "small",
                                    title: "Alert",
                                    message: "Thank for the the rating!!",
                                    callback: function(){ window.location.href=""; }
                                });

                            }});

                        /* $.post("appointment/saveRating",{rating:allRatings,reservation_id:reservationId,comments:commentBox},TYPE:"POST",function(data){
                            console.log(data);
                            console.log("worked");

                        }); */


                    }
                });

                jQuery(".rateYo").rateYo({
                    rating: 0,
                    /* onSet: function (rating, rateYoInstance) {
                        alert("Rating is set to: " + rating);
                        alert("Rating is set to: " + jQuery(this).attr("data-id"));
                    } */
                });


                var yo = jQuery(".rateYo").rateYo();

                console.log(yo);

            });

        });
    </script>
</div>
