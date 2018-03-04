<div class="portlet">
    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
<!--                    <div class="btn-group">-->
<!--                        <a href="--><?php //echo APPOINTMENT_ADMIN_URL; ?><!--providerEdit" class="btn btn-primary"><i class="fa fa-plus"></i> --><?php //echo _l("Add New",$this); ?><!--</a>-->
<!--                    </div>-->
                </div>
            </div>
            <p><?php echo _l('Add property manager form:', $this); ?></p>
            <form method="post" action="" role="form" class="form-inline" autocomplete="off">
                <div class="form-group">
                    <label for="email" class="sr-only"><?php echo _l('Email', $this); ?></label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input type="text" placeholder="<?php echo _l('Email', $this); ?>" id="email" name="email" data-list="username-list" class="form-control">
                        <ul id="username-list" class="dropdown-menu"></ul>
                    </div>
                </div>
                <div class="form-group">
                    <label for="group" class="sr-only"><?php echo _l('Group', $this); ?></label>
                    <div class="input-icon">
                        <i class="fa fa-bolt"></i>
                        <select name="group" id="group" class="form-control">
                            <?php foreach($groups as $item){ ?>
                                <option value="<?php echo $item['group_id']; ?>"><?php echo $item['group_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <button class="btn btn-default" type="submit"><?php echo _l('Add', $this); ?></button>
            </form>
        </div>
        <?php if(isset($data) && count($data)!=0){ ?>
            <table class="table table-striped table-bordered table-advance table-hover">
                <thead>
                <tr>
                    <th></th>
                    <th><?php echo _l("Email",$this); ?></th>
                    <th></th>
                    <th><?php echo _l("Permission",$this); ?></th>
                    <th><?php echo _l("Created Date",$this); ?></th>
                    <th><?php echo _l("Active",$this); ?></th>
                    <th></th>
                </tr>
                </thead>
                <?php $i=0; foreach($data as $item){ $i++; ?>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td style="min-width:50%;">
                            <?php echo $item["email"]; ?>
                        </td>
                        <td>
                            <?php if($item["notification_email"] != 1){ ?>
                                <button type="button" data-type="toggle-notification" data-value="1" data-id="<?php echo $item["user_id"]; ?>" class="btn btn-default btn-xs"><?php echo _l("Get notification", $this); ?></button>
                            <?php }else{ ?>
                                <button type="button" data-type="toggle-notification" data-value="0" data-id="<?php echo $item["user_id"]; ?>" class="btn btn-primary btn-xs"><?php echo _l("Getting notification", $this); ?></button>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo $item["group_name"]; ?>
                        </td>
                        <td><?php echo my_int_date($item["created_date"]); ?></td>
                        <td>
                            <i class="<?php echo (isset($item["active"]) && $item["active"]==1)?'fa fa-check font-green':'fa fa-times font-red'; ?>"></i>
                        </td>
                        <td>
                            <!-- Single button -->
                            <div class="btn-group">
                                <?php if(isset($local_link) && $local_link){ ?>
                                    <a class="btn btn-danger btn-xs btn-ask" data-msg="<?php echo _l("panel_provider_manager_remove_confirmation",$this); ?>" href="<?php echo APPOINTMENT_ADMIN_URL."myProviderManagerRemove/".$item["user_id"]; ?>"><i class="fa fa-trash"></i> <?php echo _l("Remove",$this); ?></a>
                                <?php }else{ ?>
                                    <a class="btn btn-danger btn-xs btn-ask" data-msg="<?php echo _l("panel_provider_manager_remove_confirmation",$this); ?>" href="<?php echo APPOINTMENT_ADMIN_URL."providerManagerRemove/".$item["provider_id"]."/".$item["user_id"]; ?>"><i class="fa fa-trash"></i> <?php echo _l("Remove",$this); ?></a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php }else{ ?>
            <div class="alert alert-info"><i class="fa fa-exclamation"></i> <?php echo _l("Empty",$this); ?></div>
        <?php } ?>
    </div>
</div>
<!--<script src="--><?php //echo base_url('assets/hideseek/jquery.hideseek.js'); ?><!--"></script>-->
<script>
    (function( $ ) {

        $.fn.ajaxSearch = function(options) {
            var thisPlugin = this;
            var thisPluginList = $('#' + thisPlugin.attr('data-list'));
            thisPluginList.hide();
            var defaultOptions = {
                loadingURL : '',
                postURL : '',
                errorFunction : function(){
                    thisPlugin.closest('.form-group').addClass('has-error');
                },
                successFunction : function(result){
                    thisPlugin.closest('.form-group').removeClass('has-error');
                    alert(result);
                }
            };

            var settings = $.extend(defaultOptions, options );
            var textSearch = this.val();
            var searchText = function () {
                $.ajax({
                    method: "POST",
                    url: settings.postURL,
                    data: { 'text' : thisPlugin.val() }
                })
                    .done(function(data){
                        data = $.parseJSON(data);
                        if(data.status == 'success'){
                            thisPluginList.html('').show();
                            $.each(data.data, function(i, item) {
                                $("<li/>", {
                                    html : $("<a/>", {
                                        text : item.email,
                                        href : "javascript:;"
                                    }).click(function(){
                                        chooseItem(item.email);
                                    })
                                })
                                    .appendTo(thisPluginList)
                            });
                        }else if(data.status == 'error'){
                            thisPluginList.hide();
                            settings.errorFunction();
                        }
                    })
                    .fail(function(xhr){
                        settings.errorFunction(xhr.responseText)
                    });
            };

            var chooseItem = function (text) {
                thisPlugin.val(text);
                thisPlugin.closest('.form-group').removeClass('has-error').addClass('has-success');
                thisPluginList.hide();
            };

            var senseKey = function(event){
                searchText();
            };

            this.startAction = function () {
                this.keyup(function(event){
                    if (event.keyCode!=0) {
                        var regex = new RegExp("^[a-zA-Z ]+$");
                        var key = String.fromCharCode(!event.keyCode ? event.which : event.keyCode);
                        if (!regex.test(key)) {
                            event.preventDefault();
//                            return false;
                        }else{
                            searchText();
                        }
                    }
                });
            };

            if(this.length == 1){
                return this.startAction();
            }else if(this.length > 1){
                return this.each(function() {
                    this.ajaxSearch(options);
                });
            }

        };

    }( jQuery ));

    $(function(){
        $('#email').ajaxSearch({
            postURL : '<?php echo APPOINTMENT_ADMIN_URL; ?>getEmail',
            successFunction : function(data){
                data = $.parseJSON(data);

            }
        });
        $("button[data-type=toggle-notification]").each(function() {
            $(this).click(function () {
                var myBtn = $(this);
                var user_id = $(this).attr("data-id");
                var notification = $(this).attr("data-value");
                <?php if(isset($local_link) && $local_link){ ?>
                var url = "<?php echo APPOINTMENT_ADMIN_URL.'myProviderManagerNotificationEmail/'; ?>";
                <?php }else{ ?>
                var url = "<?php echo APPOINTMENT_ADMIN_URL.'providerManagerNotificationEmail/'.$provider_data["provider_id"]; ?>";
                <?php } ?>
                $.ajax({
                    method: "POST",
                    url: url,
                    data: { 'user_id' : user_id , 'notification_email' : notification},
                    beforeSend: function(){
                        Metronic.blockUI({
                            target: myBtn.parent(),
                            animate: true
                        });
                    },
                    complete: function(){
                        Metronic.unblockUI(myBtn.parent());
                    }
                })
                    .done(function(data){
                        data = $.parseJSON(data);
                        if(data.status == 'success'){
                            if(myBtn.text() == "<?php echo _l("Get notification", $this); ?>"){
                                myBtn.text("<?php echo _l("Getting notification", $this); ?>");
                            }else{
                                myBtn.text("<?php echo _l("Get notification", $this); ?>");
                            }
                            if(myBtn.attr("data-value") == 1){
                                myBtn.attr("data-value", 0);
                            }else{
                                myBtn.attr("data-value", 1);
                            }
                            myBtn.toggleClass("btn-default");
                            myBtn.toggleClass("btn-primary");
                        }else if(data.status == 'error'){
                            alert(data.error);
                        }
                    });
            });
        });
//        $('#search-custom-event').hideseek();
//        $('#search-custom-event').on("_after", function() {
//            alert('This alert comes after the search is finished!')
//        });
//        $('#username').hideseek();
//        $('#username').on("_after", function() {
//            alert('This alert comes after the search is finished!')
//        });
    });
</script>