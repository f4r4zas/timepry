<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
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
                    mk_htext("data[username]", _l('Username', $this), isset($data['username']) ? $data['username'] : '');
                    mk_hemail("data[email]", _l('Email', $this), isset($data['email']) ? $data['email'] : '');
                    mk_htext("data[fullname]", _l('Full Name', $this), isset($data['fullname']) ? $data['fullname'] : '');
                    mk_hpassword("data[password]", _l('Password', $this));
                    // mk_hselect("data[language_id]",_l('language',$this),$languages,"language_id","language_name",isset($data['language_id'])?$data['language_id']:null,null,'style="width:200px"');
                    mk_hsubmit(_l('Submit', $this), APPOINTMENT_ADMIN_URL, _l('Cancel', $this));
                    mk_closeform();
                    ?>
                </div>
            </div>
        </section>

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
        <div class="col-md-12">
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