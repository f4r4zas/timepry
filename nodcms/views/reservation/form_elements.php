<?php
if(!function_exists('input_number_form_validation')){
    function input_number_form_validation($name,$caption,$require=0,$min=0,$max=0){
        $id = str_replace(array('[',']'),'__',$name);
        $data_validation = 'number';
        $data_validation .= $require!=0?' required':'';
        if($min>0 && $max>0){
            $data_validation_allowing = 'data-validation-allowing="range['.$min.';'.$max.']"';
        }else{
            $data_validation_allowing = '';
        }
        ?>
        <div class="form-group">
            <label for="<?php echo $id; ?>"><?php echo $caption; ?></label>
            <input name="<?php echo $name; ?>" id="<?php echo $id; ?>" type="text" class="form-control" data-validation="<?php echo $data_validation; ?>" <?php echo $data_validation_allowing; ?>>
        </div>
        <?php
    }
}
if(!function_exists('input_alphanumeric_form_validation')){
    function input_alphanumeric_form_validation($name,$caption,$require=0,$min=0,$max=0){
        $id = str_replace(array('[',']'),'__',$name);
        $data_validation = 'alphanumeric';
        $data_validation .= $require!=0?' required':'';
        if($min>0 && $max>0) {
            $data_validation .= ' length';
            $data_validation_length = 'data-validation-length="'.$min.'-'.$max.'"';
        }elseif($min>0 && $max<=0){
            $data_validation .= ' length';
            $data_validation_length = 'data-validation-length="min'.$min.'"';
        }elseif($min<=0 && $max>0){
            $data_validation .= ' length';
            $data_validation_length = 'data-validation-length="max'.$max.'"';
        }else{
            $data_validation_length = '';
        }
        ?>
        <div class="form-group">
            <label for="<?php echo $id; ?>"><?php echo $caption; ?></label>
            <input name="<?php echo $name; ?>" id="<?php echo $id; ?>" type="text" class="form-control" data-validation="<?php echo $data_validation; ?>" <?php echo $data_validation_length; ?>>
        </div>
        <?php
    }
}
if(!function_exists('input_text_form_validation')){
    function input_text_form_validation($name,$caption,$require=0,$min=0,$max=0){
        $id = str_replace(array('[',']'),'__',$name);
        $data_validation = $require!=0?'required':'';
        if($min>0 && $max>0) {
            $data_validation .= ' length';
            $data_validation_length = 'data-validation-length="'.$min.'-'.$max.'"';
        }elseif($min>0 && $max<=0){
            $data_validation .= ' length';
            $data_validation_length = 'data-validation-length="min'.$min.'"';
        }elseif($min<=0 && $max>0){
            $data_validation .= ' length';
            $data_validation_length = 'data-validation-length="max'.$max.'"';
        }else{
            $data_validation_length = '';
        }
        ?>
        <div class="form-group">
            <label for="<?php echo $id; ?>"><?php echo $caption; ?></label>
            <input name="<?php echo $name; ?>" id="<?php echo $id; ?>" type="text" class="form-control" data-validation="<?php echo $data_validation; ?>" <?php echo $data_validation_length; ?>>
        </div>
        <?php
    }
}
if(!function_exists('input_textarea_form_validation')){
    function input_textarea_form_validation($name,$caption,$require=0,$min=0,$max=0){
        $id = str_replace(array('[',']'),'__',$name);
        $data_validation = $require!=0?'required':'';
        if($min>0 && $max>0) {
            $data_validation .= ' length';
            $data_validation_length = 'data-validation-length="'.$min.'-'.$max.'"';
        }elseif($min>0 && $max<=0){
            $data_validation .= ' length';
            $data_validation_length = 'data-validation-length="min'.$min.'"';
        }elseif($min<=0 && $max>0){
            $data_validation .= ' length';
            $data_validation_length = 'data-validation-length="max'.$max.'"';
        }else{
            $data_validation_length = '';
        }
        ?>
        <div class="form-group">
            <label for="<?php echo $id; ?>"><?php echo $caption; ?></label>
            <textarea class="form-control" name="<?php echo $name; ?>" id="<?php echo $id; ?>" data-validation="<?php echo $data_validation; ?>" <?php echo $data_validation_length; ?>></textarea>
        </div>
        <?php
    }
}
if(!function_exists('input_checkbox_form_validation')){
    function input_checkbox_form_validation($name,$caption,$require=0,$min=0,$max=0){
        $id = str_replace(array('[',']'),'__',$name);
        $data_validation = $require!=0?'required':'';
        ?>
        <div class="checkbox">
            <label style="display: block; width: 100%;">
                <input name="<?php echo $name; ?>" id="<?php echo $id; ?>" type="checkbox" data-validation="<?php echo $data_validation; ?>" > <?php echo $caption; ?>
            </label>
        </div>
    <?php
    }
}
if(!function_exists('input_url_form_validation')){
    function input_url_form_validation($name,$caption,$require=0,$min=0,$max=0){
        $id = str_replace(array('[',']'),'__',$name);
        $data_validation = 'url';
        $data_validation .= $require!=0?' required':'';
        ?>
        <div class="form-group">
            <label for="<?php echo $id; ?>"><?php echo $caption; ?></label>
            <input name="<?php echo $name; ?>" id="<?php echo $id; ?>" type="text" class="form-control" data-validation="<?php echo $data_validation; ?>">
        </div>
    <?php
    }
}