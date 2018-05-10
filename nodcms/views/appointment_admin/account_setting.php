<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">

        <div class="col-md-6">

            <section class="panel">
                <header class="panel-heading">
                    <?= _l('Account settings', $this) ?>
                </header>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('form_error')) { ?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('form_error'); ?>
                        </div>
                    <?php } ?>
                    <div class=" form">
                        <?php
                        mk_hpostform();
                        mk_htext("data[username]", _l('Username', $this), isset($data['username']) ? $data['username'] : '',"readonly");
                        mk_hemail("data[email]", _l('Email', $this), isset($data['email']) ? $data['email'] : '');
                        mk_htext("data[firstname]", _l('First Name', $this), isset($data['firstname']) ? $data['firstname'] : '');
                        mk_htext("data[lastname]", _l('Last Name', $this), isset($data['lastname']) ? $data['lastname'] : '');

                        // mk_hselect("data[language_id]",_l('language',$this),$languages,"language_id","language_name",isset($data['language_id'])?$data['language_id']:null,null,'style="width:200px"');
                        mk_hsubmit(_l('Submit', $this), APPOINTMENT_ADMIN_URL, _l('Cancel', $this));
                        mk_closeform();
                        ?>
                    </div>
                </div>
            </section>

        </div>

        <div class="col-md-6">

            <section class="panel">
                <header class="panel-heading">
                    <?php echo _l('Reset Password', $this); ?>
                </header>
                <div class="panel-body">

                    <?php if ($this->session->flashdata('reset_error')) { ?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('reset_error'); ?>
                        </div>
                    <?php } ?>

                    <?php if ($this->session->flashdata('reset_success')) { ?>
                        <div class="alert alert-success">
                            <?php echo $this->session->flashdata('reset_success'); ?>
                        </div>
                    <?php } ?>

                    <div class="form">
                          <?php
                          mk_hpostform(base_url()."admin-appointment/updatePassword");
                          mk_hpassword("currentPassword", _l('Current Password', $this));
                          mk_hpassword("newPassword", _l('New Password', $this));
                          mk_hpassword("confirmPassword", _l('Confirm Password', $this));
                          mk_hsubmit(_l('Submit', $this), APPOINTMENT_ADMIN_URL, _l('Cancel', $this));
                          mk_closeform();
                          ?>
                        </form>
                    </div>
                </div>

            </section>
            <!-- Reset Password -->


        </div>


        <div class="col-md-12">
            <section class="panel">
                <h1 class="text-center">Images Manager</h1>
                <form action="" method="post">
                    <header class="panel-heading">
                        <div class="row">

                            <?php
                            $allPictures = json_decode($userPictures);
                            $totalPics = count($allPictures);

                            if($totalPics > 0){

                            foreach($allPictures as $pics){

                            ?>
                            <div class="col-sm-6 col-md-4">
                                <i class="fa fa-remove remove-pic" data-link="<?php echo $pics; ?>"></i>
                                <div class="thumbnail">
                                    <img alt="100%x200" data-src="holder.js/100%x200"
                                         src="<?php echo base_url().$pics; ?>"
                                         data-holder-rendered="true"
                                         style="height: 200px; width: 100%; display: block;">
                                    <div class="caption"><h3>Thumbnail label</h3>
                                        <?php if($coverPic[0]['pic_url'] == $pics){ ?>
                                        <p><a data-link="<?php echo $pics; ?>" href="#" onclick="return false" class="btn btn-danger "  role="button">Cover image</a></p></div>
                                    <?php  }else{ ?>
                                    <p><a data-link="<?php echo $pics; ?>" href="#" onclick="return false" class="btn btn-default setCover" role="button">Set as cover</a></p></div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                        }
                        }else{
                            echo "Kindly upload some pics";
                        }

                        ?>
        </div>
        </header>
        </form>
        </section>
        </div>

        <div class="col-md-12 images_uploader">
            <form action="<?php echo base_url() ?>admin-appointment/imageUpload" method="post" enctype="multipart/form-data">
                Upload Pics:
                <input type="file" multiple name="file[]" accept="image/*" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
            </form>
        </div>
    </div>
</div>

<script>


    function setCover(pic){

    }

    $(document).ready(function(){

        $(".setCover").click(function(){

            var pic = $(this).attr("data-link");

            $.ajax({url: "<?php echo base_url(); ?>appointment_admin/changeCoverPic",type:"POST",data:{coverPic:pic}, success: function(data){
                 window.location.href="";
        }});

    });

        //Remove Pic
        $(".remove-pic").click(function(){

            var pic = $(this).attr("data-link");

            $.ajax({url: "<?php echo base_url(); ?>appointment_admin/removePic",type:"POST",data:{removePick:pic}, success: function(data){
                    window.location.href="";
            }});
        });

    });
</script>