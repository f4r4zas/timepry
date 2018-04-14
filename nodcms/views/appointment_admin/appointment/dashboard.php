<?php if(isset($services_count) && $services_count==0){ ?>
    <div class="note note-danger">
        <p>
            <i class="icon-info"></i>
            <b><?php echo _l('Services failed!', $this); ?></b>
            <?php echo _l("You don't have any service to reach your customers.", $this); ?>
            <?php echo _l("To set one or more services,", $this); ?>
            <a href="<?php echo APPOINTMENT_ADMIN_URL; ?>services"><?php echo _l("click here!", $this); ?></a>
        </p>
    </div>
<?php } ?>
<?php if(isset($tomorrow_reservation_count) && $tomorrow_reservation_count!=0){ ?>
    <div class="note note-info">
        <h4 class="title">Reminder email!</h4>
        <p>
            Do you want send reminder email to who tomoeow appointment have?
            <b><?php echo $tomorrow_reservation_count; ?> emails is ready!</b>
        </p>
        <p>
            <a href="<?php echo APPOINTMENT_ADMIN_URL; ?>reservationGroupReminder" class="btn green-seagreen btn-sm"><i class="icon-paper-plane"></i> Yes, please send!</a>
        </p>
    </div>
<?php } ?>

<?php if(!isset($reservation_count) && $reservation_count==0){ ?>

  <div class="note note-info">
        <h4 class="title"><?php echo _l('Empty requests!', $this); ?></h4>
        <p>
            <?php echo _l("You don't have any appointment requests.", $this); ?>
            <?php echo _l("Please set all your options and wait until your customer send you requests.", $this); ?>
        </p>
    </div>

<?php } ?>


<?php if(1+1){ ?>

<?php if(isset($reservation_count) && $reservation_count==0){ ?>

  <div class="note note-info">
        <h4 class="title"><?php echo _l('Empty requests!', $this); ?></h4>
        <p>
            <?php echo _l("You don't have any appointment requests.", $this); ?>
            <?php echo _l("Please set all your options and wait until your customer send you requests.", $this); ?>
        </p>
    </div>

<?php } ?>

    <div class="row bcgrund">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 bgmove">
            <div class="dashboard-stat">
                 <p class="counter">
                        <?php echo isset($new_reservation_count)?$new_reservation_count:'-'; ?>
                   </p>
                        <?php echo _l('New',$this); ?>
                <span class="info-box-title"> 
                <a class="more" href="<?php echo APPOINTMENT_ADMIN_URL; ?>reservation?min_app_date=<?php echo my_int_date(time()); ?>&filters=unclosed">
                    <?php echo _l('View more',$this); ?> <i class="m-icon-swapright m-icon-white"></i>
                </a>
				</span>
            </div>
			<div class="info-box-progress">
			 <div class="progress progress-xs progress-squared bs-n">
			 <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
			  </div>
			  </div>
			  </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 bgmove">
            <div class="dashboard-stat ">
                 <p class="counter">
                        <?php echo isset($today_reservation_count)?$today_reservation_count:'-'; ?>
                    </p>
                    <div class="desc">
                        <?=_l("Today",$this)?>
                    </div>
					<span class="info-box-title"> 
               
                <a class="more" href="<?php echo APPOINTMENT_ADMIN_URL; ?>reservation?min_app_date=<?php echo my_int_date(time()); ?>&max_app_date=<?php echo my_int_date(strtotime("tomorrow")); ?>&filters=unclosed">
                    <?php echo _l('View more',$this); ?> <i class="m-icon-swapright m-icon-white"></i>
                </a>
				</span>
            </div>
			<div class="info-box-progress">
			 <div class="progress progress-xs progress-squared bs-n">
			 <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"> 
			  </div>
			  </div>
			  </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 bgmove">
            <div class="dashboard-stat">
                <p class="counter">
                        <?php echo isset($closed_reservation_count)?$closed_reservation_count:'-'; ?>
                  </p>
                    <div class="desc">
                        <?php echo _l('Closed',$this); ?>
                    </div>
                <span class="info-box-title"> 
                <a class="more" href="<?php echo APPOINTMENT_ADMIN_URL; ?>reservation?filters=closed">
                    <?php echo _l('View more',$this); ?> <i class="m-icon-swapright m-icon-white"></i>
                </a>
				</span>
            </div>
			<div class="info-box-progress">
			 <div class="progress progress-xs progress-squared bs-n">
			 <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
			  </div> 
			  </div>
			  </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 bgmove">
            <div class="dashboard-stat ">
               <p class="counter">
                        <?php echo isset($reservation_count)?$reservation_count:'-'; ?>
                    </p>
                    <div class="desc">
                        <?=_l("All Requests",$this)?>
                    </div>
                <span class="info-box-title"> 
                <a class="more" href="<?php echo APPOINTMENT_ADMIN_URL; ?>reservation">
                    <?php echo _l('View more',$this); ?> <i class="m-icon-swapright m-icon-white"></i>
                </a>
				</span>
            </div>
			<div class="info-box-progress">
			 <div class="progress progress-xs progress-squared bs-n">
			 <div class="progress-bar  progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
			  </div> 
			  </div>
			  </div>
        </div>
   
    <!-- END DASHBOARD STATS -->
    <div class="clearfix"></div>
    <div class="row bgpading">
        <div class="col-md-6">
            <div class="portlet light bg-inverse">
                <div class="portlet-title"><?php echo _l('Online Requests',$this); ?></div>
                <div id="reservation-area" class="graph" style="height: 260px;"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="portlet light bg-inverse">
                <div class="portlet"><?php echo _l('Meeting Points',$this); ?></div>
                <div id="meeting-point-area" class="graph" style="height: 260px;"></div>
            </div>
        </div>
    </div>

    <script src="<?=base_url()?>assets/metronic/global/plugins/flot/jquery.flot.js"></script>
    <script src="<?=base_url()?>assets/metronic/global/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?=base_url()?>assets/metronic/global/plugins/flot/jquery.flot.pie.js"></script>
    <script src="<?=base_url()?>assets/metronic/global/plugins/flot/jquery.flot.stack.js"></script>
    <script src="<?=base_url()?>assets/metronic/global/plugins/flot/jquery.flot.crosshair.js"></script>

    <script src="<?=base_url()?>assets/metronic/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/metronic/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
    <link href="<?=base_url()?>assets/metronic/global/plugins/morris/morris.css" rel="stylesheet" />

    <script>
        var Script = function () {
            $(function(){
                var labelFormatter = function(label, series){
                    return '<div style="font-size:10pt;text-align:center;padding:2px;color:white;">'+Math.round(series.percent)+'%<br>'+label+'</div>';
                };
                <?php if(isset($meeting_point) && count($meeting_point)!=0){ ?>
                Morris.Line({
                    element: 'meeting-point-area',
                    data: [
                        <?php foreach($meeting_point as $key=>$value){ ?>
                        <?php if(count($value)!=0){ ?>
                        {"period": '<?php echo date('Y-m',$key); ?>',
                            <?php foreach($value as $key2=>$value2){ ?>
                            '<?php echo $key2; ?>':<?php echo $value2; ?>,
                            <?php } ?>
                        },
                        <?php } ?>
                        <?php } ?>
                    ],

                    xkey: 'period',
                    ykeys: <?php echo isset($keys)?$keys:'[]'; ?>,
                    labels: <?php echo isset($labels)?$labels:'[]'; ?>,
                    hideHover: 'auto',
                    lineWidth: 1,
                    pointSize: 5,
                    lineColors: ['#333333','#4a8bc2', '#009933','#ff6c60'],
                    fillOpacity: 0.5,
                    smooth: true
                });
                <?php } ?>
                <?php if(isset($reservations) && count($reservations)!=0){ ?>
                Morris.Line({
                    element: 'reservation-area',
                    data: [
                        <?php foreach($reservations as $item){ ?>
                        {"period": '<?php echo date('Y-m',$item['min_date']); ?>',
                            'lbl1':<?php echo $item["all_count"]; ?>,
                        },
                        <?php } ?>
                    ],

                    xkey: 'period',
                    ykeys: ['lbl1','lbl2','lbl3','lbl4'],
                    labels: ['ALL','Accepted', 'Closed','In Trash'],
                    hideHover: 'auto',
                    lineWidth: 1,
                    pointSize: 5,
                    lineColors: ['#333333','#4a8bc2', '#009933','#ff6c60'],
                    fillOpacity: 0.5,
                    smooth: true
                });
                <?php }else{ ?>
				
				Morris.Line({
                    element: 'reservation-area',
                    data: [

                        {"period": '<?php echo date(); ?>',
                            'lbl1':0,
                        },
                        
                    ],

                    xkey: 'period',
                    ykeys: ['lbl1','lbl2','lbl3','lbl4'],
                    labels: ['ALL','Accepted', 'Closed','In Trash'],
                    hideHover: 'auto',
                    lineWidth: 1,
                    pointSize: 5,
                    lineColors: ['#333333','#4a8bc2', '#009933','#ff6c60'],
                    fillOpacity: 0.5,
                    smooth: true
                });
				
				<?php } ?>
            });
        }();
    </script>
<?php }else{ ?>
    <div class="note note-info">
        <h4 class="title"><?php echo _l('Empty requests!', $this); ?></h4>
        <p>
            <?php echo _l("You don't have any appointment requests.", $this); ?>
            <?php echo _l("Please set all your options and wait until your customer send you requests.", $this); ?>
        </p>
    </div>
<?php } ?>
