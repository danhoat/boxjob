
<form name="subit_job" id="frm_subit_job" class ="subit_job">
    <fieldset class="form-group">
        <label for="job_title">Job title</label>
        <input type="text" class="form-control required" required name="post_title" id="post_title" placeholder="Job title">
        <small class="text-muted">Enter job title</small>
    </fieldset>
    <fieldset class="form-group row-fluid">
        <div class="col-md-7">
        <label for="full_address" class=" form-control-label">Address</label>
        <input type="text" class="form-control required post-job-field" required name ="full_address" id="full_address" placeholder="<?php _e('Address','boxtheme');?>">
        <input type="hidden" name="jb_lat" id="jb_lat">
        <input type="hidden" name="jb_lng" id="jb_lng">
        </div>
        <div class="col-md-5">
            <label class="col-md-4"><?php _e('Location','boxtheme');?></label>
            <?php
                $args = array(
                'show_option_all'    => __('Select a location','boxtheme'),
                'child_of'           => 0,
                'hierarchical'       => 1,
                'name'               => 'location',
                'class'              => 'postform chosen-multi required tax-field',
                'taxonomy'           => 'location',
                'hide_if_empty'      => false,
                'value_field'        => 'id',
                 'hide_empty'         =>  0,
                );
                wp_dropdown_categories($args );
            ?>
        </div>
    </fieldset>
    <fieldset class="form-group">

    </fieldset>

    <fieldset class="form-group">
        <div class="col-md-6">
            <label class="col-md-4"><?php _e('Select type','boxtheme');?></label>
            <?php
                $args = array(
                'show_option_all'    => __('Select a type','boxtheme'),

                'hierarchical'       => 1,
                'hide_empty'         =>  0,
                'name'               => 'type',
                'class'              => 'postform chosen-multi required tax-field',
                'taxonomy'           => 'type',
                'hide_if_empty'      => false,
                'value_field'        => 'id',
                );
                wp_dropdown_categories($args );
            ?>
        </div>
         <div class="col-md-6">
            <label class="col-md-4"><?php _e('Job category','boxtheme');?></label>
            <?php
            $args = array(
            'show_option_all'    => __('Select categories','boxtheme'),
            'show_option_none'   => '',
            'child_of'           => 0,
            'echo'               => 0,
            'hierarchical'       => 1,
            'name'               => 'job_cat',
            'class'              => 'job_cat postform chosen-multi required tax-field',
            'taxonomy'           => 'job_cat',
            'hide_if_empty'      => false,
            'value_field'        => 'id',
            'hide_empty'         =>  0,
            );
            echo wp_dropdown_categories($args );
            ?>
        </div>
    </fieldset>
    <fieldset class="form-group">
        <?php
        // adjust values here
        $id = "img1"; // this will be the name of form field. Image url(s) will be submitted in $_POST using this key. So if $id == “img1" then $_POST[“img1"] will have all the image urls

        $svalue = ""; // this will be initial value of the above form field. Image urls.

        $multiple = true; // allow multiple files upload

        $width = null; // If you want to automatically resize all uploaded images then provide width here (in pixels)

        $height = null; // If you want to automatically resize all uploaded images then provide height here (in pixels)
        ?>

        <label>Featured job image</label>
        <input type="hidden" name="<?php echo $id; ?>" id="<?php echo $id; ?>" value="<?php echo $svalue; ?>" />
        <div class="plupload-upload-uic hide-if-no-js <?php if ($multiple): ?>plupload-upload-uic-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-upload-ui">
            <button  id="<?php echo $id; ?>plupload-browse-button" type="button"  class="button btn-upload-process" /> <i class='loading fa fa-refresh fa-spin hide'></i> <?php _e('Choose an image'); ?> <span class="glyphicon glyphicon-plus"></span>

            </button>
            <span class="ajaxnonceplu" id="ajaxnonceplu<?php echo wp_create_nonce($id . 'pluploadan'); ?>"></span>
            <?php if ($width && $height): ?>
                    <span class="plupload-resize"></span><span class="plupload-width" id="plupload-width<?php echo $width; ?>"></span>
                    <span class="plupload-height" id="plupload-height<?php echo $height; ?>"></span>
            <?php endif; ?>
            <div class="filelist"></div>
        </div>
        <ul class="plupload-thumbs <?php if ($multiple): ?>plupload-thumbs-multiple<?php endif; ?>" id="<?php echo $id; ?>plupload-thumbs">
        </ul>
        <div class="clear"></div>

    </fieldset>
    <!-- end pupload !-->

     <fieldset class="form-group">
        <label for="job_adress" class=" form-control-label">Job content</label>
        <?php wp_editor( __('Enter job content here','boxtheme'), 'post_content', bx_editor_settings() ); ?>
    </fieldset>
    <input type="hidden" name="_thumbnail_id" value="" id="_thumbnail_id" class="_thumbnail_id">

    <?php wp_nonce_field( 'jb_submit_job', 'nonce_insert_job' ); ?>

    <fieldset class="form-group">
            <button type="submit" class="btn btn-secondary btn-green"><?php _e('Next step','boxtheme');?></button>
   </fieldset>
</form>