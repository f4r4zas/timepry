<style>
    div.checker {
        margin-right: 0;
        margin-left: -19px;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <section class="panel">
            <header class="panel-heading">
                <?=_l('Public Profile',$this)?>
            </header>
            <div class="panel-body">
                <?php if($this->session->flashdata('form_error')){ ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('form_error'); ?>
                    </div>
                <?php } ?>
                <!-- HTML Form (wrapped in a .bootstrap-iso div) -->
        <?php
           $userProfile = "";
        if($data['currentProfile']){
            $userProfile = $data['currentProfile'][0];
        }

        ?>


                                <form id="public-profile" method="post">
                                    <div class="form-group ">
                                        <label class="control-label requiredField" for="date">
                                            Birth date
                                            <span class="asteriskField">
        *
       </span>
                                        </label>
                                        <input data-validation="required"  value="<?php if($userProfile["dob"]){ echo date("d/m/Y",strtotime($userProfile["dob"])); } ?>" class="form-control" id="dob" name="dob" placeholder="MM/DD/YYYY" type="text"/>
                                    </div>

                                    <div class="form-group ">
                                        <label class="control-label requiredField" for="text">
                                            City
                                            <span class="asteriskField">
        *
       </span>
                                        </label>
                                        <input class="form-control" value="<?php if($userProfile["city"]){ echo $userProfile["city"];} ?>" data-validation="required" id="city" name="city" type="text"/>
                                    </div>

                                    <div class="form-group ">
                                        <label class="control-label " for="text1">
                                            What would you enjoy to find in a Dental Clinic?
                                        </label>
                                        <input value="<?php if($userProfile["q1"]){ echo $userProfile["q1"];} ?>" class="form-control" data-validation="required" id="question1" name="question1" placeholder="Music, magzs, coffee etc&hellip;" type="text"/>
                                    </div>
                                    <div class="form-group" id="div_checkbox">
                                        <label class="control-label requiredField" for="checkbox">
                                            What equipment your dentist shall have and use?
                                            <span class="asteriskField">
        *
       </span>
                                        </label>
                                        <div class="">
                                            <?php
                                                $question2 = explode(",",$userProfile["q2"]);
                                            ?>
                                            <label class="checkbox-inline">
                                                <input name="question2[]"  <?php if(in_array("a1", $question2)){ echo "checked"; } ?> type="checkbox" value="a1"/>
                                                Dental Laser
                                            </label>
                                            <p></p>
                                            <label class="checkbox-inline">
                                                <input name="question2[]"  <?php if(in_array("a2", $question2)){ echo "checked"; } ?> type="checkbox" value="a2"/>
                                                Invisible tooth brace
                                            </label>
                                            <p></p>
                                            <label class="checkbox-inline">
                                                <input name="question2[]" type="checkbox" <?php if(in_array("a3", $question2)){ echo "checked"; } ?> value="a3"/>
                                                More comfortable Dental chair
                                            </label>
                                            <p></p>
                                            <label class="checkbox-inline">
                                                <input name="question2[]" type="checkbox"  <?php if(in_array("a4", $question2)){ echo "checked"; } ?> value="a4"/>
                                                Low dose X-Ray machine
                                            </label>
                                            <p></p>
                                            <label class="checkbox-inline">
                                                <input name="question2[]" type="checkbox" <?php if(in_array("a5", $question2)){ echo "checked"; } ?> value="a5"/>
                                                Premium implants
                                            </label>
                                            <p></p>
                                            <label class="checkbox-inline">
                                                <input name="question2[]" type="checkbox" <?php if(in_array("a6", $question2)){ echo "checked"; } ?> value="a6"/>
                                                Equipment with the highest hygiene standards
                                            </label>
                                            <p></p>
                                            <label class="checkbox-inline">
                                                <input name="question2[]" type="checkbox"  <?php if(in_array("a7", $question2)){ echo "checked"; } ?> value="a6"/>
                                                Software for guided implantology
                                            </label>
                                            <p></p>
                                            <label class="checkbox-inline">
                                                <input name="question2[]" type="checkbox"  <?php if(in_array("a8", $question2)){ echo "checked"; } ?> value="a7"/>
                                                Software for guided root canal treatment
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label " for="text">
                                            Address
                                        </label>
                                        <input data-validation="required" value="<?php if($userProfile["address"]){ echo $userProfile["address"];} ?>" class="form-control" id="address" name="address" type="text"/>
                                    </div>
                                    <div class="form-group ">
                                        <label data-validation="required" class="control-label " for="textarea">
                                            About
                                        </label>
                                        <textarea class="form-control" data-validation="required" cols="40" id="about" name="about" rows="10"><?php if($userProfile["about"]){ echo $userProfile["about"];} ?></textarea>
                                    </div>

                                   <!-- <div class="form-group ">
                                        <label class="control-label " for="select">
                                            Find freinds
                                        </label>

                                        <?php /*$freinds = "";

                                        if(!empty($userProfile["friends"])){
                                               $freinds = explode(",",$userProfile["friends"]);
                                        }
                                        */?>

                                        <select multiple="multiple" class="select freindUser form-control" id="freinds" name="freinds[]">
                                            <?php /*foreach($data['allUsers'] as $allUser){ */?>
                                                <option <?php /*if(in_array($allUser['user_id'], $freinds)){ echo "selected"; } */?>  value="<?php /*echo $allUser['user_id']; */?>"><?php /*echo $allUser['fullname']; */?></option>
                                            <?php /*} */?>
                                        </select>
                                    </div>
-->
                                    <div class="form-group">
                                        <div>
                                            <button class="btn btn-primary " name="submit" type="submit">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
            </div>
        </section>
    </div>
</div>
<script src="http://localhost/timepry/assets/form-validator/jquery.form-validator.js"></script>
<script>
    jQuery(document).ready(function(){
        $.validate();
       //$(".freindUser").select2();
       $( "#dob" ).datepicker({dateFormat: 'dd-mm-yy'});
    });
</script>