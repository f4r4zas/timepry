<div class="portlet">
    <div class="portlet-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="row static-info">
                    <div class="col-xs-6 name"><?php echo _l("Appointment Date:", $this); ?></div>
                    <div class="col-xs-6 value">
                        <?php echo isset($min_app_date)?_l("From", $this).': '.$min_app_date:''; ?>
                        <?php echo isset($max_app_date)?_l("To", $this).': '.$max_app_date:''; ?>
                        <?php echo (!isset($max_app_date) && !isset($min_app_date))?_l("All", $this):''; ?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-xs-6 name"><?php echo _l("Service", $this); ?></div>
                    <div class="col-xs-6 value">
                        <?php if(isset($service_id)){ ?>
                            <?php foreach($services as $item){ ?>
                                <?php if($service_id == $item["service_id"]){ ?>
                                    <?php echo $item["service_name"]; ?>
                                <?php } ?>
                            <?php } ?>
                        <?php }else{ ?>
                            <?php echo _l("All Services", $this); ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-xs-6 name"><?php echo _l("Search name:", $this); ?></div>
                    <div class="col-xs-6 value">
                        <?php echo isset($search_text)?'"'.$search_text.'"':'-'; ?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-xs-6 name"><?php echo _l("Created Date:", $this); ?></div>
                    <div class="col-xs-6 value">
                        <?php echo isset($min_date)?$min_date:''; ?>
                        <?php echo isset($max_date)?$max_date:''; ?>
                        <?php echo (!isset($max_date) && !isset($min_date))?_l("All", $this):''; ?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-xs-6 name"><?php echo _l("Languages", $this); ?></div>
                    <div class="col-xs-6 value">
                        <?php if(isset($language_id)){ ?>
                            <?php foreach($languages as $item){ ?>
                                <?php if(in_array($item["language_id"], $language_id)){ ?>
                                    <span class="label label-primary"><?php echo $item["language_name"]; ?></span>
                                <?php } ?>
                            <?php } ?>
                        <?php }else{ ?>
                            <?php echo _l("All Languages", $this); ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="row static-info">
                    <div class="col-xs-6 name"><?php echo _l("Other Filters", $this); ?></div>
                    <div class="col-xs-6 value">
                        <?php if(isset($filters)){ ?>
                            <?php if(in_array("validated", $filters)){ ?>
                                <span class="label label-success"><?php echo _l("Validated", $this); ?></span>
                            <?php } ?>
                            <?php if(in_array("invalidated", $filters)){ ?>
                                <span class="label label-danger"><?php echo _l("Invalidated", $this); ?></span>
                            <?php } ?>
                            <?php if(in_array("closed", $filters)){ ?>
                                <span class="label label-success"><?php echo _l("Closed", $this); ?></span>
                            <?php } ?>
                            <?php if(in_array("unclosed", $filters)){ ?>
                                <span class="label label-danger"><?php echo _l("Unclosed", $this); ?></span>
                            <?php } ?>
                            <?php if(in_array("paypal_paid", $filters)){ ?>
                                <span class="label label-success"><?php echo _l("PayPal paid", $this); ?></span>
                            <?php } ?>
                            <?php if(in_array("paypal_unpaid", $filters)){ ?>
                                <span class="label label-danger"><?php echo _l("PayPal unpaid", $this); ?></span>
                            <?php } ?>
                        <?php }else{ ?>
                            -
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row static-info">
                    <div class="col-xs-6 name"><?php echo _l("Total results:", $this); ?></div>
                    <div class="col-xs-6 value"><?php echo isset($count)?$count:0; ?></div>
                </div>
                <div class="row static-info">
                    <div class="col-xs-6 name"><?php echo _l("Total price:", $this); ?></div>
                    <div class="col-xs-6 value"><?php echo isset($sum_price)?$this->currency->format($sum_price):0; ?></div>
                </div>
            </div>
        </div>
        <?php if(isset($data) && count($data)!=0){ $i=0; ?>
            <table class="table table-striped table-bordered table-advance table-hover">
                <thead>
                <tr class="gray-gallery">
                    <th><?php echo _l("Row",$this); ?></th>
                    <th><?php echo _l("ID",$this); ?></th>
                    <th><?php echo _l("Appointment",$this); ?></th>
                    <th><?php echo _l("Name & Family",$this); ?></th>
                    <th><?php echo _l("Service",$this); ?></th>
                    <th><?php echo _l("Price",$this); ?></th>
                    <th><?php echo _l("Created",$this); ?></th>
                    <th><?php echo _l("Language",$this); ?></th>
                    <th><?php echo _l("PayPal Paid", $this); ?></th>
                    <th><?php echo _l("Validated",$this); ?></th>
                    <th><?php echo _l("Closed", $this); ?></th>
                    <th><?php echo _l("Reminded", $this); ?></th>
                </tr>
                </thead>
                <?php foreach($data as $item){ $i++; ?>
                    <tr class="<?php echo $item['color']; ?>" id="row<?php echo $item['reservation_id']; ?>">
                        <td><?php echo $i; ?>.</td>
                        <td><?php echo $item['reservation_id']; ?></td>
                        <td>
                            <?php echo my_int_date($item["reservation_date_time"]); ?>
                            <strong><?php echo my_int_justTime($item["reservation_date_time"]); ?></strong>
                            <?php if($item["reservation_date"] < mktime(0,0,0,date("m"),date("d"),date("Y"))){ ?>
                                <span class="label label-danger"><?php echo _l("Expired", $this); ?></span>
                            <?php }elseif($item["reservation_date"] == mktime(0,0,0,date("m"),date("d"),date("Y"))){ ?>
                                <span class="label label-warning"><?php echo _l("Today", $this); ?></span>
                            <?php } ?>
                        </td>
                        <td><?php echo $item["fname"]; ?> <?php echo $item["lname"]; ?></td>
                        <td><?php echo $item["service_name"]; ?></td>
                        <td><?php echo $this->currency->format($item["price"]); ?></td>
                        <td>
                            <?php echo my_int_date($item["created_date"]); ?>
                        </td>
                        <td>
                            <img src="<?php echo base_url().$item["image"]; ?>" style="width:16px;" alt="<?php echo $item["language_name"]; ?>" title="<?php echo $item["language_name"]; ?>">
                            <?php echo $item["language_name"]; ?>
                        </td>
                        <td>
                            <i class="<?php echo $item['paypal_paid']!=1?'fa fa-times font-yellow':'fa fa-check font-green'; ?>"></i>
                        </td>
                        <td>
                            <i id="validateIcon<?php echo $item['reservation_id']; ?>" class="<?php echo $item['checked']!=1?'fa fa-times font-yellow':'fa fa-check font-green'; ?>"></i>
                        </td>
                        <td>
                            <i id="closeIcon<?php echo $item['reservation_id']; ?>" class="<?php echo $item['closed']!=1?'fa fa-times font-yellow':'fa fa-check font-green'; ?>"></i>
                        </td>
                        <td>
                            <?php if($item['reminded']!=0){ ?>
                                <?php echo $item['reminded']; ?>
                            <?php }else{ ?>
                                -
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php }elseif(!isset($data) || count($data) == 0){ ?>
            <div class="note note-info">
                <h4 class="block"><i class="icon-info"></i> <?php echo _l("Not found!",$this); ?></h4>
                <p><?php echo _l("There were no results from that report. You need to adjust your report parameters.",$this); ?></p>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    window.print();
</script>