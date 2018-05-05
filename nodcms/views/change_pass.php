<form id="changePassword" class="form-horizontal" method="post" action="<?php echo base_url() ?>updatePassword" role="form">
    <div class="form-group">
        <label for="email" class=" control-label col-sm-3">New password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password" name="password" placeholder="create your new password">
        </div>
    </div>
    <div class="form-group">
        <label for="email" class=" control-label col-sm-3">Confirm password</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="confirm your new password">
        </div>
    </div>
    <div class="form-group">
        <!-- Button -->
        <div class="  col-sm-offset-3 col-sm-9">
            <button id="btn-signup" type="submit" class="btn btn-success">Submit</button>
        </div>
    </div>
    <input type="hidden" name="password_user_id" value="<?php echo $userId; ?>" >
</form>
<script>
    $( "#changePassword" ).validate({
        rules: {
            password: "required",
            password_confirmation:{
                equalTo: "#password"
            }
        }
    });
</script>