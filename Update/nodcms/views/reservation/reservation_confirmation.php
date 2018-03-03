<?php if($this->provider["payment_type"]!=1 || $data["price"] == 0){ ?>
    <p class="text-center alert alert-success"><?php echo _l("Reservation Confirmation!",$this); ?></p>
<?php } ?>

<div class="row">
    <div class="col-sm-8 col-xs-12">
        <h3><?php echo $data["service_name"]; ?></h3>
        <p><?php echo $data["service_description"]; ?></p>
    </div>
    <div class="col-sm-4 col-xs-12">
        <p><?php echo _l('Date',$this); ?>: <b><?php echo my_int_date($data["created_date"]); ?></b></p>
    </div>
</div>
<?php if(isset($data)){ ?>
    <?php if($this->provider["payment_type"]!=1 || $data["price"] == 0){ ?>
        <div class="row static-info">
            <div class="col-xs-1 name"><i class="fa fa-barcode"></i></div>
            <div class="col-xs-5 name"><?php echo _l('Reservation Key',$this); ?></div>
            <div class="col-xs-6 value"><mark><?php echo $data["reservation_id"]; ?></mark></div>
        </div>
    <?php } ?>
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
    <?php if($data['price_show']==1){ ?>
        <div class="row static-info">
            <div class="col-xs-1 name"><i class="fa fa-ticket"></i></div>
            <div class="col-xs-5 name"><?php echo _l('Price',$this); ?></div>
            <div class="col-xs-6 value"><?php echo $this->currency->format($data["price"]); ?></div>
        </div>
    <?php } ?>
    <div class="row static-info">
        <div class="col-xs-1 name"><i class="fa fa-user"></i></div>
        <div class="col-xs-5 name"><?php echo _l('Name',$this); ?></div>
        <div class="col-xs-6 value"><?php echo $data["fname"]; ?> <?php echo $data["lname"]; ?></div>
    </div>
<?php } ?>

<?php if($this->provider["payment_type"]==1 && $data["price"] > 0){ ?>
    <div class="alert alert-warning">
        <p>
            <?php echo _l("Your booking is not completed!", $this); ?>
            <?php echo _l("It will complete after payment.", $this); ?>
        </p>
    </div>
    <p class="text-center">
        <a target="_parent" id="paypal-btn" class="btn btn-success" href="<?php echo base_url().$lang; ?>/appointment-paypal/<?php echo $data["reservation_id"]; ?>/pay">
            <?php echo _l("Payment with Paypal", $this); ?>
        </a>
    </p>
    <hr>
<?php }elseif($this->provider["payment_type"]==2 && $data["price"] > 0){ ?>
    <div class="alert alert-info">
        <p>
            <?php echo _l("Save your time!", $this); ?>
            <?php echo _l("You can pay for your service now.", $this); ?>
        </p>
    </div>
    <p class="text-center">
        <a target="_parent" id="paypal-btn" class="btn btn-success" href="<?php echo base_url().$lang; ?>/appointment-paypal-again/<?php echo $data["reservation_id"]; ?>/pay">
            <?php echo _l("Payment with Paypal", $this); ?>
        </a>
    </p>
    <hr>
<?php } ?>
<script>
    $(function(){
        $("#paypal-btn").click(function(){
            Metronic.blockUI({
                target: '#reservation_wizard_form',
                animate: true
            });
        });
    });
</script>