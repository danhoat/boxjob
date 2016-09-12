<?php
global $i;
?>
<li class="active heading-step">
  <div class="wizard-heading">
      <?php echo $i; ?>. Login Information
      <span class="icon-user"></span>
  </div>
    <div class="wizard-content">

      <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#tab_login" aria-controls="tab_login" role="tab" data-toggle="tab">Login</a></li>
      <li role="presentation"><a href="#tab_registration" aria-controls="tab_registration" role="tab" data-toggle="tab"><?php _e('Sign up','boxtheme');?></a></li>


      </ul>

      <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="tab_login">
            <form class="form-login">
              <div class="form-group row">
                <label  name="user_login" class="col-sm-2 form-control-label"><?php _e('User name','boxtheme');?></label>
                <div class="col-sm-10">
                    <input type="text" name ="user_login" class="form-control" placeholder="<?php _e('User name','boxtheme');?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="user_password" class="col-sm-2 form-control-label"><?php _e('Password','boxtheme');?></label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name ="user_password"  placeholder="Password">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2">&nbsp; </label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox"><?php _e('Remember me','boxtheme');?>
                    </label>
                  </div>
                </div>
              </div>
                  <input type="hidden" name="action" value="jb_signin">
              <?php wp_nonce_field( 'jb_login_action', 'nonce_login_field' ); ?>
              <div class="form-group row">
                 <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-secondary" value ="<?php _e("Sign in","boxtheme");?>" />
                 </div>
              </div>
          </form>
        </div> <!-- end tab_login !-->
        <div role="tabpanel" class="tab-pane fade" id="tab_registration">
            register form here
        </div> <!--end  tab_registration !-->

      </div>
      <button class="btn-green done" type="submit">Continue</button>
  </div>
</li>