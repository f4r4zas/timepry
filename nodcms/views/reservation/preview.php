<!--<img src="--><?php //echo $page_data["avatar"]; ?><!--" style="width: 100%;">-->
<div class="bg-box-light">
    <h1 class="text-center" style="margin: 0;padding: 10px"><?php echo $page_data["title_caption"]; ?></h1>
    <div class="container">
        <?php if(isset($data_list) && count($data_list)!=0){ ?>
            <div class="row">
                <?php $i=0; foreach($data_list as $item){ $i++; $right_pic=($i>2)?1:0; if($i>4){ $i=1; } ?>
                    <div class="col-sm-6 col-xs-12">
                        <article class="reservation-service">
                            <div class="row">
                                <div class="col-sm-6 <?php echo ($right_pic)?'pull-right':''; ?>">
                                    <a href="<?php echo base_url().$lang; ?>/reservation/service/<?php echo $item['service_id']; ?>">
                                        <div class="reservation-service-img">
                                            <img src="<?php echo base_url().image($item['image'],image($page_data["avatar"],image($settings['default_image'],'',250,200),250,200),250,200); ?>">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <h2 class="reservation-service-title"><a href="<?=base_url().$lang?>/reservation/service/<?=$item["service_id"]?>"><?php echo $item['name']?></a></h2>
                                    <div class="reservation-service-body">
                                        <?php echo $item['description']; ?>
                                    </div>
                                    <a class="btn btn-default" href="<?php echo base_url().$lang; ?>/reservation/service/<?php echo $item['service_id']; ?>"><i class="fa fa-calendar"></i> <?php echo _l('Set a Date',$this); ?></a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div><script>
    $('.reservation-service').mouseover(function(){
        $('.reservation-service').addClass('transparent');
    }).mouseleave(function(){
        $('.reservation-service').removeClass('transparent');
    });
</script>