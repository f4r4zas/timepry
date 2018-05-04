<style>
    .page-content{
        background-color: #518ed2;
    }
    .page-content div{
        background-color: #518ed2;
        color: white;
    }

    .portlet.light {
        padding: 16px;
        border: none;
        background-color: #518ed2;
    }

    .section-heading h1{
        color:white;
    }
    .cus-hr {
        background-color: white !important;
    }
    .checkout-parag{
        padding-top: 10px;
    }
    .checkout-sucess{
        border: none;
    }
</style>
<div class="container">
    <div class="portlet light">



        <div class="portlet-body text-center">
            <div class="<?php echo $message_class; ?> checkout-sucess">
                <div class="section-heading">
                    <h1><?php echo $message_title; ?></h1>
                    <div class="cus-hr"></div>
                </div>

                <p class="checkout-parag"><?php echo $message; ?></p>
            </div>
            <a class="btn btn-default btn-lg" href="<?php echo base_url().$lang; ?>">Back to Home</a>
        </div>
    </div>
</div>

