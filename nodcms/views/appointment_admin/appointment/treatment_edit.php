<div class="portlet">
    <div class="portlet-body">
        <?php
		print_r($data);
        mk_hpostform(APPOINTMENT_ADMIN_URL."serviceManipulate/".(isset($data['service_id'])?$data['service_id']:""));
        ?>
        <div class="form-body">
            
		<div class="form-group" >
			<label for="data[price]" class="control-label col-lg-2">Title</label>
			<div class="col-lg-10">
				<input class=" form-control" id="title" name="title" type="text" value="1" style='max-width:200px;'/>
			</div>
		</div>
	
	<div class="form-group" >
        <label for="data[price]" class="control-label col-lg-2">Price</label>
        <div class="col-lg-10">
            <input class=" form-control" id="price" name="price" type="text" value="1" style='max-width:200px;'/>
        </div>
    </div>
	
	<div class="form-group" >
        <label for="data[price]" class="control-label col-lg-2">Description</label>
        <div class="col-lg-10">
			<textarea class="form-control" id="description" name="description">
			</textarea>
           
        </div>
    </div>

        <div class="form-actions">
            <?php
            mk_hsubmit(_l('Submit',$this),APPOINTMENT_ADMIN_URL.'services',_l('Cancel',$this));
            ?>
        </div>
        <?php
        mk_closeform();
        ?>
    </div>
</div>
