<?php
global $profile;
// if( empty($profile->post_content) ){
//     $profile->post_content ='Introduce yourself and describe your career objectives';
// }
?>
<fieldset class="form-view profile-item-row row">
    <legend class="box-md" data-toggle="tooltip" data-placement="top" title="">
        <i class="fa fa-fw fa-list"></i> Summary
    </legend>
    <div id="profile_summary" class="relative col-md-12">
        <form class="form-horizontal box-md form-wrapper frm-profile-edit" id="profileForm" >
            <span class="form-btn-edit">
                <button type="button" class="btn btn-sm btn-default btn-edit">
                    <i class="glyphicon glyphicon-pencil"></i>
                </button>
            </span>
            <div class="form-group m-b-none ">
                <div class="view-field">
                    <div class="view-field">
                        <div class="view-control"><?php echo $profile->post_content;?></div>
                        <input type="hidden" name="ID" value="<?php echo $profile->ID;?>" />
                    </div>
                </div>
                <div class="edit-field">
                    <?php wp_editor( $profile->post_content, 'post_content', bx_editor_settings() );?>
                    <span class="msg-profile-valid error-message" hidden="hidden">Please do not enter phone number or email.</span>
                </div>
            </div>
            <!-- Buttons-->
            <div class="form-group push-top-md edit-field">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-cancel btn-default">Cancel</button>
                        <button type="submit" class="btn btn-save btn-primary" >Save</button>
                        <button type="button" style="display: none;" class="btn-sending btn btn-default" disabled=""><img src="http://images.vietnamworks.com/loading.gif" alt="">Sending</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</fieldset>