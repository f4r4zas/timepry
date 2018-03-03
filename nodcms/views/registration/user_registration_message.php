<div class="container">
    <div class="portlet light">
        <div class="portlet-body text-center">
            <div class="<?php echo $message_class; ?>">
                <h4 class="title"><?php echo $message_title; ?></h4>
                <p><?php echo $message; ?></p>
            </div>
            <a class="btn btn-default btn-lg" href="<?php echo base_url().$lang; ?>"><?php echo _l('Back to Home', $this); ?></a>
        </div>
    </div>
</div>