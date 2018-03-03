<div class="container">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject bold"><?php echo $this->provider['provider_name']; ?></span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-6">
                    <?php echo $this->provider['provider_description']; ?>
                    <ul class="list-inline blog-tags">
                        <?php if($this->provider['phone']!=''){ ?>
                            <li><i class="fa fa-phone font-blue-steel"></i> <span class="font-blue-hoki"><?php echo $this->provider['phone']; ?></span></li>
                        <?php } ?>
                        <?php if($this->provider['address']!=''){ ?>
                            <li><i class="fa fa-map-marker font-blue-steel"></i> <span class="font-blue-hoki"><?php echo $this->provider['address']; ?></span></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption ">
                                <span class="caption-subject bold uppercase"><?php echo _l('Reservation Form',$this); ?></span>
                            </div>
                        </div>
                        <div class="portlet-body" id="reservation_wizard_form">
                            <?php include __DIR__."/reservation_wizard_form.php"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
