<?php

function getNoReservations($email){
	 $CI = get_instance();
	 
	 $query = $CI->db->query("SELECT * FROM r_reservation where email = '".$email."'");
	 return $query->num_rows();
}

function getReservationUserId($email){

    $CI = get_instance();

    $query = $CI->db->query("SELECT * FROM users where email = '".$email."'");

    if($query->num_rows() > 0){
        return $query->result_array();
    }else{
        return false;
    }
}

function getUserProfile($id){

    $CI = get_instance();

    $query = $CI->db->query("SELECT * FROM user_questions where user_id = ".$id);

    if($query->num_rows()){
        return $query->result_array();
    }else{
        return false;
    }

}


function generateUserProfile($userId){

    $CI = get_instance();

    $allUsers = $CI->Appointment_admin_model->getAllUser();


    $userProfile = $CI->Appointment_admin_model->getProfile($userId);


    if($userProfile){
        $data['currentProfile'] = $userProfile;
    }

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

        <div class="form-group ">
            <label class="control-label " for="select">Freinds</label>

            <?php $freinds = "";

            if(!empty($userProfile["friends"])){
                $freinds = explode(",",$userProfile["friends"]);
            }
            ?>

            <select multiple="multiple" class="select freindUser form-control" id="freinds" name="freinds[]">
                <?php foreach($allUsers as $allUsers){ ?>

                    <?php if(in_array($allUsers['user_id'], $freinds)){ ?>

                        <option <?php if(in_array($allUsers['user_id'], $freinds)){ echo "selected"; } ?>  value="<?php echo $allUsers['user_id']; ?>"><?php echo $allUsers['fullname']; ?></option>

                   <?php } ?>


                <?php } ?>
            </select>
        </div>
    </form>
    <script>

    </script>
<?php
}

?>


<?php

if(getReservationUserId($data["email"])){
    $id = getReservationUserId($data["email"])[0]['user_id'];

    if(getUserProfile($id)){
        ?>

        <?php
    }else{
        echo "None";
    }

}//User Details Popup




?>
