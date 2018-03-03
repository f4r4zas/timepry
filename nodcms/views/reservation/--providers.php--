<div class="container">
    <?php if(isset($data_list) && count($data_list)!=0){ $i = 0; ?>
        <div class="row">
            <?php foreach($data_list as $item){ $i++; ?>
                <div class="col-md-6">
                    <div class="portlet light">
                        <div class="portlet-title">
                            <h3 class="caption">
                                <a class="caption-subject bold font-green" href="<?php echo base_url().$lang.'/provider/'.$item['provider_username']; ?>"><?php echo $item['provider_name']; ?></a>
                                <span class="caption-helper"><i class="fa fa-calendar"></i> <?php echo my_int_date($item['created_date']); ?></span>
                            </h3>
                        </div>
                        <div class="portlet-body">
                            <div>
                                <?php echo $item['provider_description']; ?>
                            </div>
                            <p>
                                <a href="<?php echo base_url().$lang.'/provider/'.$item['provider_username']; ?>" class="btn blue">
                                    <?php echo _l('Book a time', $this); ?> <i class="m-icon-swapright m-icon-white"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <?php if((($i+1)%2)!=0){ ?>
                    <div class="clearfix"></div>
                <?php } ?>
            <?php } ?>
        </div>
        <?php echo isset($pagination)?$pagination:""; ?>
    <?php }else{ ?>
        <div class="portlet light">
            <div class="portlet-body">
                <div class="note note-warning">
                    <h4 class="title"><?php echo _l('No result!', $this); ?></h4>
                    <p class="text-lg">
                        <?php echo _l("Your search", $this); ?>
                        - <strong><?php echo $search_word; ?></strong> -
                        <?php echo _l("did not match any providers.", $this); ?>
                    </p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>