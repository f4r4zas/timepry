<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <section class="portlet">
            <div class="portlet-body">
                <div class=" form">
                    <?php
                    mk_hpostform();
                    $option = "style='max-width:600px;'";
                    foreach ($languages as $item) {
                        mk_htext("data[options][".$item["language_id"]."][site_title]",_l('site title',$this)." (".$item["language_name"].")",isset($options[$item["language_id"]])?$options[$item["language_id"]]["site_title"]:"",$option);
                        mk_htextarea("data[options][".$item["language_id"]."][site_description]",_l('Site Description',$this)." (".$item["language_name"].")",isset($options[$item["language_id"]])?$options[$item["language_id"]]["site_description"]:"",$option);
                        mk_htextarea("data[options][".$item["language_id"]."][site_keyword]",_l('site keywords',$this)." (".$item["language_name"].")",isset($options[$item["language_id"]])?$options[$item["language_id"]]["site_keyword"]:"",$option);
                    }
                    mk_hsubmit(_l('Save',$this));
                    mk_closeform();
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>
