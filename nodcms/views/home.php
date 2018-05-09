<section class="home-banner page-home">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-text">
                    <p class="light-font">FREE ONLINE BOOKING</p>
                </div>

                <div class="search_div">
                    <div class="search_tabs">
                        <div class="s_tab active" data-tab="one" onclick="s_tab(event)">Search By Location</div>
                        <div class="s_tab" data-tab="two" onclick="s_tab(event)">Search By Dental Office</div>
                    </div>
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
                                    */?>
                                    
                                    <div  class="company-box" style="display:none; top: 50px; position: absolute; background: white; width: 100%; padding: 10px; line-height: 26px;"></div>
                                <input type="text" placeholder="Location" class="company_matrix" name="search_location"><!--<input type="text" placeholder="Location" name="search_location">-->

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
                                    
                                    */?>
                                <div class="treat-box" style="display:none; top: 50px; position: absolute; background: white; width: 100%; padding: 10px; line-height: 26px;"></div>
                                <input type="text" placeholder="Treatment" class="treat_matrix" name="search_treatment">                        
								<input type="hidden" name="treatmentSubcatId">
                            </div>

                            <div class="input_field">
                                
                                <input type="text" name="search_date" id="search_date">                        

                            </div>
                            <script>
                                $("#search_date").kendoDatePicker({
                                    min: new Date(),
                                    format: "dd/MM/yyyy"
                                });
                            </script>
                            
                            
                            <script>
                              $("body").on('click',".fetched_companies",function(){
                              //function selectamazetal_companies(val){
                                var val = $(this).attr("data-val");
                                $(this).closest(".company-box").siblings(".company_matrix").val(val);
                                $(".company-box").hide();
                              });
                              
                              $("body").on('blur',".company_matrix",function(){
                                setTimeout(function(){
                                    $(".company-box").hide();    
                                },300);
                                
                              });
                              
                              $("body").on('keyup',".company_matrix",function(){
                                var thisinput = $(this);
                                
                                if($(this).val().length >= 2){
                                    var formData = new FormData();
                                    formData.append('company',$(this).val()); 
                                    
                                    url = "<?php echo site_url('General/get_location_matrix');?>";
                            			 $.ajax({
                            				  url: url,
                            				  type: "POST",
                            				  data: formData,
                            				  beforeSend:function()
                            				  {
                            					thisinput.css("background","url(https://amazetal.com/assets/images/LoaderIcon.gif) right center #fff no-repeat");
                            				  },
                            				  processData: false,
                            				  contentType: false,
                            				  success: function (data) {
                            				    thisinput.css("background","#fff");
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
                                }else{
                                    $(".company-box").hide();
                                }
                              });

								//Dental Office
							  $("body").on('keyup',"[name='search_dental_clinic']",function(){
                                var thisinput = $(this);
                                
                                if($(this).val().length >= 3){
                                    var formData = new FormData();
                                    formData.append('provider',$(this).val()); 
                                    
                                    
                                    url = "<?php echo site_url('General/globalDentists');?>";
                            			 $.ajax({
                            				  url: url,
                            				  type: "POST",
                            				  data: formData,
                            				  beforeSend:function()
                            				  {
                            					thisinput.css("background","url(https://amazetal.com/assets/images/LoaderIcon.gif) right center #fff no-repeat");
                            				  },
                            				  processData: false,
                            				  contentType: false,
                            				  success: function (data) {
												  console.log(data);
                            				    thisinput.css("background","#fff");
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
                                }else{
                                    $(".company-box").hide();
                                }
                              });
                              
                              
                              
                              
                              $("body").on('click',".fetched_treats",function(){
                              //function selectamazetal_companies(val){
                                var val = $(this).attr("data-val");
								var subCatId = $(this).val();
                                $(this).closest(".treat-box").siblings(".treat_matrix").val(val);
                                $(this).closest(".treat-box").siblings("[name='treatmentSubcatId']").val(subCatId);
                                $(".treat-box").hide();
                              });

							  $("body").on('click',".fetched_providers",function(){
                              //function selectamazetal_companies(val){
                                var val = $(this).attr("data-val");
								var subCatId = $(this).val();
								
								$("[name='search_dental_clinic']").val(val);
							  
                                $(".dental-box").hide();
                              });
                              
                              $("body").on('blur',".treat_matrix",function(){
                                setTimeout(function(){
                                    $(".treat-box").hide();    
                                },300);
                                
                              });
                              
                              $("body").on('keyup',".treat_matrix",function(){
                                var thisinput = $(this);
                                
                                if($(this).val().length >= 1){
                                    var formData = new FormData();
                                    formData.append('company',$(this).val()); 

                                    url = "<?php echo site_url('General/get_treatment_matrix'); ?>";
                            			 $.ajax({
                            				  url: url,
                            				  type: "POST",
                            				  data: formData,
                            				  beforeSend:function()
                            				  {
                            					thisinput.css("background","url(https://amazetal.com/assets/images/LoaderIcon.gif) right center #fff no-repeat");
                            				  },
                            				  processData: false,
                            				  contentType: false,
                            				  success: function (data) {
                            				    thisinput.css("background","#fff");
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
                                }else{
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

                        <div id="tabcontent-two" class="tab_content">
							<form action="appointment" id="search_by_dental" method="get">
                            <div class="input_field fa fa-search">
							 <div  class="dental-box" style="display:none; top: 50px; position: absolute; background: white; width: 100%; padding: 10px; line-height: 26px;"></div>
                                <input required type="text" placeholder="Dental Clinic" autocomplete="off" name="search_dental_clinic">
                            </div>

                            <div class="input_field btn">
                                <input type="submit" class="toothBtn">
                            </div>
                        </form>
                        </div>

                    </div>
                </div>

				<div class="col-md-12 errors_form text-center">
					
				</div>
			

                <div class="section-heading">

                    <h1>Nearby Dentist</h1>

                    <div class="cus-hr"></div>

                </div>

            </div>

        </div>    

    </div>    

</section>



<section class="map_wrapper">

    <div id="map"></div>

</section>



<section class="how-it-works">

    <div class="container">

        <div class="row">

            <div class="section-heading">

                <h1>How It Works</h1>

                <div class="cus-hr"></div>

            </div>

            <div class="col-md-4 box">

                <div class="work-img">

                    <img src="<?php echo base_url();?>assets/front/images/timepry_search_icon.png" alt="Search">

                </div>

                <div class="work-title">Search</div>

                <div class="work-content">

                    <p>

                        This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. 

                    </p>

                </div>

            </div>



            <div class="col-md-4 box">

                <div class="work-img">

                    <img src="<?php echo base_url();?>assets/front/images/timepry_browse_icon.png" alt="Browse">

                </div>

                <div class="work-title">Browse</div>

                <div class="work-content">

                    <p>

                        This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. 

                    </p>

                </div>

            </div>



            <div class="col-md-4 box">

                <div class="work-img">

                    <img src="<?php echo base_url();?>assets/front/images/timepry_book_icon.png" alt="Book">

                </div>

                <div class="work-title">Book</div>

                <div class="work-content">

                    <p>

                        This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. 

                    </p>

                </div>

            </div>



        </div>

    </div>

</section>



<section class="treatment">

    <div class="container">

        <div class="row">

            <div class="section-heading">

                <h1>Find The Right Treatment</h1>

                <div class="cus-hr"></div>

            </div>

            <div class="col-sm-6 col-md-3 box">

                <div class="img">

                    <img src="<?php echo base_url();?>assets/front/images/nhs_thumb.jpg" alt="">

                </div>

                <div class="title">NHS</div>

            </div>



            <div class="col-sm-6 col-md-3 box">

                <div class="img">

                    <img src="<?php echo base_url();?>assets/front/images/emergency_thumb.jpg" alt="">

                </div>

                <div class="title">Emergency</div>

            </div>



            <div class="col-sm-6 col-md-3 box">

                <div class="img">

                    <img src="<?php echo base_url();?>assets/front/images/private_thumb.jpg" alt="">

                </div>

                <div class="title">Private</div>

            </div>



            <div class="col-sm-6 col-md-3 box">

                <div class="img">

                    <img src="<?php echo base_url();?>assets/front/images/cosmetic_thumb.jpg" alt="">

                </div>

                <div class="title">Cosmetic</div>

            </div>

        </div>

    </div>

</section>
<script>
$(document).ready(function(){
$(".e9").select2({
    placeholder: "Location",
}); 

$(".e10").select2({
    placeholder: "Treatment",
}); 


jQuery("#search_by_dental").validate({
	errorPlacement: function(error, element) {
    jQuery(".errors_form").html("");
    error.appendTo('.errors_form');
}
});

jQuery("#search_by_location").validate({
		 ignore: [],
		errorPlacement: function(error, element) {
		jQuery(".errors_form").html("");
		error.appendTo('.errors_form');
	}
});





}); 
</script>