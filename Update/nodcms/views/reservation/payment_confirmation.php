<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="note note-success">
                        <p>
                            <?php echo _l("Your payment was successful, and you booked your appointment.", $this); ?>
                        </p>
                    </div>
                    <?php if(isset($data)){ ?>
                        <div class="row static-info">
                            <div class="col-xs-1 name"><i class="fa fa-barcode"></i></div>
                            <div class="col-xs-5 name"><?php echo _l('Reservation Key',$this); ?></div>
                            <div class="col-xs-6 value"><mark><?php echo $data["reservation_id"]; ?></mark></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-xs-1 name"><i class="fa fa-calendar"></i></div>
                            <div class="col-xs-5 name"><?php echo _l('Appointment Date',$this); ?></div>
                            <div class="col-xs-6 value"><mark><?php echo my_int_justDate($data["reservation_date_time"]); ?></mark></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-xs-1 name"><i class="fa fa-clock-o"></i></div>
                            <div class="col-xs-5 name"><?php echo _l('Appointment Time',$this); ?></div>
                            <div class="col-xs-6 value">
                                <mark>
                                    <?php echo my_int_justTime($data["reservation_date_time"]); ?> -
                                    <?php echo my_int_justTime($data["reservation_edate_time"]); ?>
                                </mark>
                            </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-xs-1 name"><i class="fa fa-certificate"></i></div>
                            <div class="col-xs-5 name"><?php echo _l('Service Name',$this); ?></div>
                            <div class="col-xs-6 value"><?php echo $data["service_name"]; ?></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-xs-1 name"><i class="fa fa-ticket"></i></div>
                            <div class="col-xs-5 name"><?php echo _l('Price',$this); ?></div>
                            <div class="col-xs-6 value"><?php echo $this->currency->format($data["price"]); ?></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-xs-1 name"><i class="fa fa-user"></i></div>
                            <div class="col-xs-5 name"><?php echo _l('Name',$this); ?></div>
                            <div class="col-xs-6 value"><?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?></div>
                        </div>
                    <?php } ?>
                    <p class="text-center">
                        <a class="btn btn-default hidden-print" href="<?php echo base_url().$lang; ?>/provider/<?php echo $this->provider["provider_username"]?>">
                            <?php echo _l("Done", $this); ?>
                        </a>
                        <button class="btn btn-success hidden-print" type="button" onclick="window.print();"><i class="fa fa-print"></i> <?php echo _l('Print Page',$this); ?></button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>