<div class="portlet">
    <div class="portlet-body">
        <?php
		
		$doctorer_array = explode(",",$data["dentists_id"]);
		
        mk_hpostform(APPOINTMENT_ADMIN_URL."treatmentUpdate/");
        ?>
        <div class="form-body">
            
		<div class="form-group" >
			<label for="data[price]" class="control-label col-lg-2">Title</label>
			<div class="col-lg-10">
				<input class=" form-control" id="title" required name="title" type="text" value="<?php echo $data['title'] ?>" style='max-width:200px;'/>
			</div>
		</div>
	
	<div class="form-group" >
        <label for="data[price]" class="control-label col-lg-2">Price</label>
        <div class="col-lg-10">
            <input class=" form-control" id="price" required name="price" type="text" value="<?php echo $data['price'] ?>" style='max-width:200px;'/>
        </div>
    </div>
	
	<div class="form-group" >
        <label for="data[price]" class="control-label col-lg-2">practitioners</label>
        <div style="width: 50%; display: inline-block; vertical-align: top; height: 40px;">
                                                                    <?php 
																	
																	
																	
                                                                    $this->db->select('*');
                                                                    $this->db->from('practitioners');
                                                                    $this->db->where('provider_id',$this->session->userdata('provider_id'));
                                                                    $query = $this->db->get();
                                                                    $practitioners = $query->result();?>
                                                                        <select required id="" class="practitioners" name="treatment_practitioner[]" multiple="">
                                                                            <?php foreach($practitioners as $practitioner):?>
                                                                            <option <?php if(in_array($practitioner->practitioner_id,$doctorer_array)){echo "selected"; } ?> value="<?= $practitioner->practitioner_id;?>"><?= $practitioner->practitioner_title;?> <?= $practitioner->practitioner_fullname;?></option>
                                                                            <?php endforeach;?>
                                                                        </select>
                                                                    </div>
    </div>
	
	<div class="form-group" >
        <label for="data[price]" class="control-label col-lg-2">Description</label>
        <div class="col-lg-10">
			<textarea class="form-control" id="description"  required name="description"><?php echo $data['service_description'] ?></textarea>
           
        </div>
    </div>
		<input type="hidden" value="<?php echo $data['id']; ?>" name="id">
        <div class="form-actions">
            <?php
            mk_hsubmit(_l('Submit',$this),APPOINTMENT_ADMIN_URL.'treatment',_l('Cancel',$this));
            ?>
        </div>
        <?php
        mk_closeform();
        ?>
    </div>
</div>
<script>
jQuery(document).ready(function(){
	jQuery(".practitioners").select2();
	
	
/* 	jQuery(".form-horizontal").validate({
		 ignore: [],
}); */
	
});
</script>
