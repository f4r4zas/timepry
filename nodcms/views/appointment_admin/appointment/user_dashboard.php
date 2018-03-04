<?php //include('header.php'); ?>

<?php //include('login_menu.php'); ?>
<script>
$(document).ready(function(){
    $(".inner-page-banner").hide();
    $(".inner-page-banner.user").show();
});
</script>

<section class="inner-page-banner user">
    <div class="banner_wrapper">
        <div class="banner_content">
            <h1>Dashboard</h1>
        </div>
    </div>
</section>

<section class="dashboard_area">
    <div class="container">
        <div class="section-heading">
        <?php 
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id',$this->session->userdata('user_id'));
        $query = $this->db->get();
        $user_info = $query->result();?>
            <h1>Welcome, <?php echo $user_info[0]->fullname;?></h1>
            <div class="cus-hr" style="margin-top:10px;"></div>
        </div>

        <div class="msgs-graph">
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
                        $this->db->from('r_reservation');
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
                                    <div class="tooth">
                                        <img src="<?php echo base_url()?>assets/reservation/img/tooth-pic.png" alt="Free Card">
                                    </div>
                                    <div class="text">Free</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="last_appointments">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">Last Appointments</div>
                    <div class="appointment-header">
                        <div class="cell-c">
                            <span class="t-img"><img src="<?php echo base_url()?>assets/reservation/img/tooth-pic.png" alt="Tooth"></span>
                            <span class="counter"><?php echo $total_reservation;?></span>
                            <span class="text-bold">Treatments Collected</span>
                        </div>
                        <div class="cell-c">
                            <span class="text">Average value of Treatments collected </span>
                            <span class="price">$<?php echo ceil( $total_price / $total_reservation );?></span>
                        </div>
                    </div>

                    <div class="appointments-list">
                        <!-- appointment 1 -->
                        <?php foreach($user_reservation as $reservation):
                        $end_date = date('Y-m-d H:i', $reservation->reservation_edate_time);
                        
                        $start_date = date('Y-m-d H:i', $reservation->reservation_date_time);
                        
                        $current_date = date('Y-m-d H:i');
                        
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
                        </div>
                        <?php endforeach;?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php //include('footer.php'); ?>