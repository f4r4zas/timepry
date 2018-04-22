<?php
//Get the avg review for every provider
get_instance()->load->helper('reviews');
get_instance()->load->helper('distance');
get_instance()->load->helper('valid-date');

?>
<style>
    .search_content .thumb_img {
        max-height: 207px;
        overflow: hidden;
        border-radius: 4px !important;
    }

    .search_content div {
        padding: 10px 3px;
    }
    .title {
    }

    .details p {
        margin: 0px 4px;
        max-width: 100%;
        max-height: 40px;
        overflow: hidden;
        min-height: 12px;
    }

    .greyButton {
        margin: 0px 0px;
    }

    #map_canvas {
        height: 100%;
        position: relative;
        height: 100% !important;
        padding-bottom: 150% !important;
        width: 100%;
    }

    .listing-image {
        height: 430px !important;
        width: 100% !important;
        float: left;
        margin: 0 auto;
        background-size: cover;
        background-position: center;
    }

</style>
<!--<section class="inner-page-banner">
    <div class="banner_wrapper">
        <div class="banner_content">
            <h1>Search Result</h1>
        </div>
    </div>
</section>-->


<section class="inner-page-banner">
    <div class="listing-page banner_wrapper">


            <h1>Search Result</h1>

        <br>

        <div class="home-banner">

            <div class="search_bar">

                <div id="tabcontent-one" class="tab_content active">
                    <form autocomplete="off" action="appointment" id="search_by_location" method="get">
                        <div class="input_field fa fa-search">
                            <?php /*
                                $this->db->select('provider_id,address');
                                $this->db->from('r_providers');
                                $query = $this->db->get();
                                $locations = $query->result();?>
                                    <select required id="" class="e9" name="search_location">
                                        <?php foreach($locations as $location):
                                        $fetched = array();
                                        $location_city = explode(",",$location->address);
                                        end($location_city);
                                        $location_city = prev($location_city);
                                        if(!in_array($location_city,$fetched)):
                                        ?>
                                        <option value="<?= urlencode($location_city);?>"><?= $location_city;?></option>
                                        <?php
                                        $fetched[] = $location_city;
                                        endif;
                                        endforeach;?>
                                    </select>
                                    */ ?>

                            <div class="company-box"
                                 style="display:none; top: 50px; position: absolute; background: white; width: 100%; padding: 10px; line-height: 26px;"></div>
                            <input type="text" value="<?php echo $this->input->get("search_location") ?>" placeholder="Location" class="company_matrix" name="search_location">
                            <!--<input type="text" placeholder="Location" name="search_location">-->

                        </div>

                        <div class="input_field">

                            <?php /*
                                $this->db->select('subcat_id,subcat_name');
                                $this->db->from('subcategory');
                                $query = $this->db->get();
                                $treatments = $query->result();?>
                                    <select  id="" class="e10" name="search_treatment">
                                        <?php foreach($treatments as $treatment):
                                        $fetched = array();
                                        if(!in_array($treatment->subcat_name,$fetched)):
                                        ?>
                                        <option value="<?= urlencode($treatment->subcat_id);?>"><?= $treatment->subcat_name;?></option>
                                        <?php
                                        $fetched[] = $treatment->subcat_name;
                                        endif;
                                        endforeach;?>
                                    </select>

                                    */ ?>
                            <div class="treat-box"
                                 style="display:none; top: 50px; position: absolute; background: white; width: 100%; padding: 10px; line-height: 26px;"></div>
                            <input type="text" value="<?php echo $this->input->get("search_treatment") ?>" placeholder="Treatment" class="treat_matrix" name="search_treatment">
                            <input type="hidden" name="treatmentSubcatId">
                        </div>

                        <div class="input_field">

                            <input type="text" value="<?php echo $this->input->get("search_date") ?>" name="search_date" id="search_date">

                        </div>
                        <script>
                            $("#search_date").kendoDatePicker({
                                min: new Date(),
                                format: "dd/MM/yyyy"
                            });
                        </script>


                        <script>
                            $("body").on('click', ".fetched_companies", function () {
                                //function selectamazetal_companies(val){
                                var val = $(this).attr("data-val");
                                $(this).closest(".company-box").siblings(".company_matrix").val(val);
                                $(".company-box").hide();
                            });

                            $("body").on('blur', ".company_matrix", function () {
                                setTimeout(function () {
                                    $(".company-box").hide();
                                }, 300);

                            });

                            $("body").on('keyup', ".company_matrix", function () {
                                var thisinput = $(this);

                                if ($(this).val().length >= 2) {
                                    var formData = new FormData();
                                    formData.append('company', $(this).val());

                                    url = "<?php echo site_url('General/get_location_matrix');?>";
                                    $.ajax({
                                        url: url,
                                        type: "POST",
                                        data: formData,
                                        beforeSend: function () {
                                            thisinput.css("background", "url(https://amazetal.com/assets/images/LoaderIcon.gif) right center #fff no-repeat");
                                        },
                                        processData: false,
                                        contentType: false,
                                        success: function (data) {
                                            thisinput.css("background", "#fff");
                                            //var data_msg=$.parseJSON(data);
                                            //thisinput.prev().show();
                                            //thisinput.prev().html(data);
                                            $(".company-box").show();
                                            $(".company-box").html(data);
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) {
                                            $(".se-pre-con").fadeOut("slow");
                                            alert('Error adding / update data');
                                        }
                                    });
                                } else {
                                    $(".company-box").hide();
                                }
                            });

                            //Dental Office
                            $("body").on('keyup', "[name='search_dental_clinic']", function () {
                                var thisinput = $(this);

                                if ($(this).val().length >= 3) {
                                    var formData = new FormData();
                                    formData.append('provider', $(this).val());


                                    url = "<?php echo site_url('General/globalDentists');?>";
                                    $.ajax({
                                        url: url,
                                        type: "POST",
                                        data: formData,
                                        beforeSend: function () {
                                            thisinput.css("background", "url(https://amazetal.com/assets/images/LoaderIcon.gif) right center #fff no-repeat");
                                        },
                                        processData: false,
                                        contentType: false,
                                        success: function (data) {
                                            console.log(data);
                                            thisinput.css("background", "#fff");
                                            //var data_msg=$.parseJSON(data);
                                            //thisinput.prev().show();
                                            //thisinput.prev().html(data);
                                            $(".dental-box").show();
                                            $(".dental-box").html(data);
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) {
                                            $(".se-pre-con").fadeOut("slow");
                                            alert('Error adding / update data');
                                        }
                                    });
                                } else {
                                    $(".company-box").hide();
                                }
                            });


                            $("body").on('click', ".fetched_treats", function () {
                                //function selectamazetal_companies(val){
                                var val = $(this).attr("data-val");
                                var subCatId = $(this).val();
                                $(this).closest(".treat-box").siblings(".treat_matrix").val(val);
                                $(this).closest(".treat-box").siblings("[name='treatmentSubcatId']").val(subCatId);
                                $(".treat-box").hide();
                            });

                            $("body").on('click', ".fetched_providers", function () {
                                //function selectamazetal_companies(val){
                                var val = $(this).attr("data-val");
                                var subCatId = $(this).val();

                                $("[name='search_dental_clinic']").val(val);

                                $(".dental-box").hide();
                            });

                            $("body").on('blur', ".treat_matrix", function () {
                                setTimeout(function () {
                                    $(".treat-box").hide();
                                }, 300);

                            });

                            $("body").on('keyup', ".treat_matrix", function () {
                                var thisinput = $(this);

                                if ($(this).val().length >= 1) {
                                    var formData = new FormData();
                                    formData.append('company', $(this).val());


                                    url = "<?php echo site_url('General/get_treatment_matrix');?>";
                                    $.ajax({
                                        url: url,
                                        type: "POST",
                                        data: formData,
                                        beforeSend: function () {
                                            thisinput.css("background", "url(https://amazetal.com/assets/images/LoaderIcon.gif) right center #fff no-repeat");
                                        },
                                        processData: false,
                                        contentType: false,
                                        success: function (data) {
                                            thisinput.css("background", "#fff");
                                            //var data_msg=$.parseJSON(data);
                                            //thisinput.prev().show();
                                            //thisinput.prev().html(data);
                                            $(".treat-box").show();
                                            $(".treat-box").html(data);
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) {
                                            $(".se-pre-con").fadeOut("slow");
                                            alert('Error adding / update data');
                                        }
                                    });
                                } else {
                                    $(".treat-box").hide();
                                }
                            });
                        </script>

                        <!-- <div class="input_field range">

                            <label>Distance</label>

                            <input type="range" name="search_distance" class="range_slider">

                        </div> -->

                        <div class="input_field btn">

                            <input type="submit" class="toothBtn" value=" ">

                        </div>

                        <input type="button" class="searchBtnOnMobile" value="Search">

                        <div class="clearfix"></div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="search_body">
    <div class="container-fluid">
        <?php if (isset($data_list) && count($data_list) != 0){
        $i = 0; ?>
        <div class="row athicating">

            <div class="col-md-12 filter-section">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <form action="" id="zipform" method="get">
                        <div class="form-group">
                            <label>
                                <select name="distance" class="form-control" required>
                                    <option value="">Distance</option>
                                    <option <?php if ($this->input->get("distance") == "10") {
                                        echo "selected";
                                    } ?> value="10">Under 10KM
                                    </option>
                                    <option <?php if ($this->input->get("distance") == "20") {
                                        echo "selected";
                                    } ?> value="20">Under 20KM
                                    </option>
                                    <option <?php if ($this->input->get("distance") == "35") {
                                        echo "selected";
                                    } ?> value="35">Under 35KM
                                    </option>
                                    <option <?php if ($this->input->get("distance") == "50") {
                                        echo "selected";
                                    } ?> value="50">Under 50KM
                                    </option>
                                    <option <?php if ($this->input->get("distance") == "100") {
                                        echo "selected";
                                    } ?> value="100">Under 100KM
                                    </option>
                                    <option <?php if ($this->input->get("distance") == "200") {
                                        echo "selected";
                                    } ?> value="200">Under 200KM
                                    </option>
                                    <option <?php if ($this->input->get("distance") == "300") {
                                        echo "selected";
                                    } ?> value="300">Under 300KM
                                    </option>
                                </select>
                            </label>
                            <label>
                                <input type="text" placeholder="Zipcode" value="<?php echo $this->input->get("zip"); ?>"
                                       name="zip"
                                       class="form-control" required>
                            </label>
                            <label><input type="submit" value="Zip Search" class="btn btn-primary"></label>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="selectfilter" class="form-control">
                            <option value="">Most relevant</option>
                            <option value="desc" data-class="hiddenRating">Rating of the dental office</option>
                            <option value="asc" data-class="priceHidden">Lowest price on top</option>
                            <option value="desc" data-class="priceHidden">Highest price on top</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>


            <div class="col-md-6 listing-provider">

                <div class="col-md-12">
                    <blockquote>
                        <h3><strong><?php echo $this->input->get("search_location"); ?></strong></h3>
                    </blockquote>
                </div>

                <div id="listId" class="res_wrapper">
                    <ul class="row-not list">
                        <?php

                        $addresses = array();
                        $i = 0;
                        $total = 0;
                        $zipRecordsTotal = 0;
                        $totalDateRecords = 0;
                        $addOnsTotal = 0;
                        $count = count($data_list);
                        foreach ($data_list as $item) {


                            $total++;

                            $userZipcountry = end(explode(",", $item['address']));

                            if ($this->input->get("zip") && $this->input->get("distance")) {

                                $userZip = $this->input->get("zip");
                                $distance = getDistance($userZip . " ," . $userZipcountry, $item['address'], "k");
                                $userDistance = $this->input->get("distance");

                                if ($distance > $userDistance) {
                                    continue;
                                } else {
                                    $zipRecordsTotal++;
                                }
                            }

                            //Date Check
                            if (!empty($this->input->get('search_date'))) {

                                $checkValid = checkValidDate($this->input->get('search_date'), $item['provider_id']);

                                if (!empty($checkValid)) {
                                    $checkValid = $checkValid[0];
                                    if ($checkValid['closed'] == 1) {
                                        continue; // Dentist office is closed on this day
                                    } else {
                                        $totalDateRecords++;
                                    }
                                } else {
                                    continue; // Does not have opening on this day
                                }
                            }


                            ?>
                            <li class="row listing-row">
                                <div class="col-md-12">
                                    <div class="search_content">
                                        <div class="col-md-4">
                                            <div class="thumb_img">
                                                <?php if (!empty($item['image'])) { ?>
                                                    <?php $images = json_decode($item['image']); ?>
                                                    <?php if (is_array($images)) { ?>
                                                        <span style="background-image:url(<?php echo base_url(); ?><?php
                                                        echo $images[0]; ?>)" class="listing-image"></span>
                                                    <?php } else { ?>
                                                        <span style="background-image:url(<?php echo base_url(); ?><?php
                                                        echo $item['image']; ?>)" class="listing-image"></span>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <span style="background-image:url(<?php echo base_url(); ?>assets/front/images/search_re_thumb.png)"
                                                          class="listing-image"></span>
                                                    <?php } ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="title"><?php echo $item['provider_name']; ?></div>
                                            <div class="ratings">

                                                <?php $review = getReviews($item['provider_id']); ?>
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <?php if ($i < $review || $i == $review) { ?>
                                                        <i class="fa fa-star"></i>
                                                    <?php } else { ?>
                                                        <i class="fa fa-star no-ratings"></i>
                                                    <?php } ?>

                                                <?php } ?>

                                                <div style="display:none"
                                                     class="hiddenRating"><?php echo $review; ?></div>
                                                <div style="display:none"
                                                     class="priceHidden"><?php echo $item['price']; ?></div>
                                            </div>
                                            <div class="clinic_address"><?php echo $item['address']; ?></div>
                                            <?php if ($this->input->get("zip") & $this->input->get("distance")) { ?>
                                                <div class="distance">
                                                    <span><strong>Distance</strong></span>
                                                    <?php echo round($distance) . " KM" ?>
                                                </div>
                                            <?php } ?>


                                            <div class="details">
                                                <?php echo $item['provider_description']; ?>
                                            </div>
                                            <div class="readMore_button">
                                                <a style="background-color: #518ed2;border: #518ed2;
" href="<?php echo base_url() . $lang . '/provider/' . $item['provider_username']; ?>"
                                                   class="greyButton"><?php echo _l('Book a time', $this); ?></a>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="price-listing">From : <span><h2>£<?php echo $item['price']; ?></h2></span></p>
                                        </div>
                                    </div>
                                </div>


                            </li> <!-- Row List -->
                            <?php
                            $addresses[] = '"' . $item['address'] . '"';
                        }
                        $comma_seperated = implode(",", $addresses);
                        ?>
                    </ul><!-- List ID -->


                    <?php if ($this->input->get("zip") & $this->input->get("distance")) { ?>

                        <?php if ($zipRecordsTotal < 1) { ?>

                            <div class="note note-warning">
                                <h4 class="title"><?php echo _l('No result!', $this); ?></h4>
                                <p class="text-lg">
                                    <?php echo _l("Your search", $this); ?>
                                    - <strong><?php echo $search_word; ?></strong> -
                                    <?php echo _l("Cannot locate any nearby clinics try increasing distance.", $this); ?>
                                </p>
                            </div>

                        <?php } ?>

                    <?php } ?>

                    <?php if (!empty($this->input->get('search_date'))) { ?>

                        <?php if ($totalDateRecords < 1) { ?>

                            <div class="note note-warning">
                                <h4 class="title"><?php echo _l('No result!', $this); ?></h4>
                                <p class="text-lg">
                                    <?php echo _l("Your search", $this); ?>
                                    - <strong><?php echo $search_word; ?></strong> -
                                    <?php echo _l("No Clinics opened on this date.", $this); ?>
                                </p>
                            </div>

                        <?php } ?>

                    <?php } ?>


                    <ul class="pagination"></ul>
                </div>
            </div>

            <div class="col-md-6 provider-map">
                <div id="map_canvas" style=""></div>
            </div>
            <script>

                function initialize() {
                    var locations = [
                        ['DESCRIPTION', 41.926979, 12.517385, 10],
                        ['DESCRIPTION', 41.914873, 12.506486, 10],
                        ['DESCRIPTION', 61.918574, 12.507201, 10]
                    ];

                    var addresses = [<?php echo $comma_seperated;?>];

                    window.map = new google.maps.Map(document.getElementById('map_canvas'), {
                        //center: new google.maps.LatLng(45, -122),
                        zoom: 4,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });

                    var infowindow = new google.maps.InfoWindow();

                    var bounds = new google.maps.LatLngBounds();

                    //for (var x = 0; x < addresses.length-6; x++) {
                    for (var x = 0; x < addresses.length; x++) {
                        console.log("worked");
                        /* marker = new google.maps.Marker({
                             position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                             map: map
                         });*/

                        $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCkNq8UF0mXsrDKPk6QbA976GWi5lZqprI&address=' + addresses[x] + '&sensor=false', null, function (data) {

                            try {
                                var p = data.results[0].geometry.location;
                                var latlng = new google.maps.LatLng(p.lat, p.lng);
                            } catch (error) {
                                console.log("There is an error");
                                console.log(error);
                                console.log(data);
                            }

                            marker = new google.maps.Marker({
                                // center: new google.maps.LatLng(45, 13),
                                position: latlng,
                                map: map,
                                icon: '<?php echo base_url();?>assets/front/images/teeth_marker.png'
                            });

                            bounds.extend(marker.position);
                        });


                        /*google.maps.event.addListener(marker, 'click', (function (marker, i) {
                            return function () {
                                infowindow.setContent(locations[i][0]);
                                infowindow.open(map, marker);
                            }
                        })(marker, i));*/
                    }

                    map.fitBounds(bounds);

                    var listener = google.maps.event.addListener(map, "idle", function () {
                        map.setZoom(5);
                        google.maps.event.removeListener(listener);
                    });
                }

                function loadScript() {
                    var script = document.createElement('script');
                    script.type = 'text/javascript';
                    script.id = "bla";
                    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCkNq8UF0mXsrDKPk6QbA976GWi5lZqprI&v=3.exp&sensor=false&' + 'callback=initialize';
                    document.body.appendChild(script);
                }

                jQuery(document).ready(function () {
                    loadScript();
                    console.log("scripted");
                });

                $(function () {
                    // setTimeout(function() {

                    // }, 800);
                });
            </script>
            <?php } else { ?>
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
</section>

<script>


    jQuery(document).ready(function () {

        var options = {
            valueNames: ['priceHidden', 'hiddenRating'],
            page: 3,
            pagination: true
        };

        var listObj = new List('listId', options);

        //listObj.sort('hiddenRating', { order: "asc" });

        jQuery("[name='selectfilter']").change(function () {

            console.log($(this).val());
            if ($(this).val() == "") {
                console.log("redirect");
                window.location.href = window.location.href;

            } else {
                var values = $(this).val();
                var options = $("option:selected", this).attr('data-class');
                listObj.sort(options, {order: values});
            }


        });


        jQuery("#zipform").submit(function (e) {
            e.preventDefault();

            var zip = "";
            var distance = "";
            if (jQuery("[name='zip']").val() != "") {
                zip = jQuery("[name='zip']").val();
            } else {
                return false;
            }

            if (jQuery("[name='distance']").val() != "") {
                distance = jQuery("[name='distance']").val();
            } else {
                return false;
            }


            var fullUrl = updateQueryStringParameter(window.location.href, "distance", distance);

            var fullUrl = updateQueryStringParameter(fullUrl, "zip", zip);

            window.location.href = fullUrl;


        });

    });


    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        }
        else {
            return uri + separator + key + "=" + value;
        }
    }


</script>
<script>
    $(document).ready(function () {

        $("[name='selectfilter']").select2();
        $("#site_auto_popup").hide();


    })
</script>