<script type="text/javascript">
 
</script>


<!-- page start-->
<style>
#name {
	width: 100%;
	min-width: 100px;
}
.pado {
	margin-top: 72px;
}

</style>

<section class="inner-page-banner">
    <div class="banner_wrapper">
        <div class="banner_content">
            <h1>Contact</h1>
        </div>
    </div>
</section>


<div class="container">
<div class="row">
<div class="col-lg-6 col-md-6" >

<section class="inner-page-body">
<div class="">
 <div class="">
  <div class="col-md-12 box">
                <div class="section-heading">
                    <h1><?=_l('Contact form',$this);?></h1>
					<div class="cus-hr"></div>
                </div>
		<div class="contact-form">
                    <div class="form-fields">
                        <form action="<?php echo base_url(); ?>contact" method="post" enctype="multipart/form-data">
						<?php if($this->session->flashdata('message_success')){?>
                        <div class="alert alert-success fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong><?=_l('Success:',$this);?>  </strong> <?=_l('Your Request have been successfully sent!',$this);?>
                        </div>
                    <?php } ?>

                    <?php if($this->session->flashdata('message_error')){?>
                        <div class="alert alert-block alert-danger fade in">
                            <button type="button" class="close close-sm" data-dismiss="alert">
                                <i class="fa fa-times"></i>
                            </button>
                            <strong><?=_l('Oh snap!',$this);?></strong><?=_l('Problem with messages. Please notify the site administrator via the phone numbers listed',$this);?>
                        </div>
                    <?php } ?>
					
					<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<section class="panel">
					<div class="panel-body">
					<?php if($this->session->flashdata('message_success')){?>
					<div class="alert alert-success fade in">
					<button type="button" class="close close-sm" data-dismiss="alert">
					<i class="fa fa-times"></i>
					</button>
					<strong><?=_l('Success:',$this);?>  </strong> <?=_l('Your Request have been successfully sent!',$this);?>
					</div>
					<?php } ?>

					<?php if($this->session->flashdata('message_error')){?>
					<div class="alert alert-block alert-danger fade in">
					<button type="button" class="close close-sm" data-dismiss="alert">
					<i class="fa fa-times"></i>
					</button>
					<strong><?=_l('Oh snap!',$this);?></strong><?=_l('Problem with messages. Please notify the site administrator via the phone numbers listed',$this);?>
					</div>
					<?php } ?>

					<div class="contact-form">
					<div class="form-fields">
					<form class="" id="contact" action="" method="post" enctype="multipart/form-data">
					<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

					<div class="name">
						  <input id="name" name="name"  placeholder="Name" type="text" class="" required>

					</div>
					<div class="email">
					   
						<input type="text" id="email" name="email" class="" placeholder="<?=_l('Email address',$this);?>" required>
					</div>

					<div class="subject">
					   
						<input type="text" id="subject" name="subject" class="" placeholder="<?=_l('Subject',$this);?>" required>
					</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="msg">
						
						<textarea id="text" class="" rows="10" name="text" placeholder="<?=_l('Request',$this);?>" required></textarea>
					</div>
					</div>
					</div>


					<div class="form-group  form-btn-submit">
						<input type="submit" class="btn btn-danger contactform-btn" value="<?=_l('Send email',$this);?>" />
					</div>
					</form>
					</div>
					</div>
					</div>
					</section>
					</div>
					</div>

					</div>
    </div>
	</div>
</div>
</div>
</section>


</div>

<div class="col-md-6 box pado">
                <div class="contact_map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9916256937604!2d2.2922926153727525!3d48.85837007928744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sEiffel+Tower!5e0!3m2!1sen!2s!4v1509835230814" style="border:0" allowfullscreen="" width="100%" height="647px" frameborder="0"></iframe>
                </div>
            </div>




</div>

</div>

<script>

    function initMap() {
        var myLatLng = {lat: -25.363, lng: 131.044};

        var map = new google.maps.Map(document.getElementById('gmap_marker'), {
            zoom: 4,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfkzWoPeDKw-RbhGbYp3-RWGgzCVaHvZU&callback=initMap">
</script>

