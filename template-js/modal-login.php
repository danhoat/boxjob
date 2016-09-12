<!-- Modal -->
<div class="modal modal-login fade" id="modalLogin" data-target="#modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <form name="frm-login" class="form-login">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php _e('Login','boxtheme');?></h4>
      </div>
      <div class="modal-body">

          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 form-control-label"><?php _e('User name','boxtheme');?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="user_login" id="inputEmail3" placeholder="Username">
            </div>
          </div>
         <div class="form-group row">
            <label for="inputPassword3" name="password" class="col-sm-3 form-control-label"><?php _e('Password','boxtheme');?></label>
            <div class="col-sm-9">
              <input type="password" name="user_password"   class="form-control" id="inputPassword3" placeholder="<?php _e('Password','boxtheme');?>">
            </div>
            <?php wp_nonce_field( 'jb_login_action', 'nonce_login_field' ); ?>
         </div>
         <div class="form-group row">
            <label class="col-sm-3"></label>
            <div class="col-sm-9">
               <div class="checkbox">
                  <label>
                     <input type="checkbox" name="remember" value=1>  <?php _e('Remember me','boxtheme');?>
                  </label>
               </div>
            </div>
         </div>
         <div class="form-group row">
            <div class="col-sm-offset-3 col-sm-9">
              <button type="submit" class="btn btn-secondary">Fb</button>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','boxtheme');?></button>
        <button type="submit" class="btn btn-primary btn-login"><?php _e('Login','boxtheme');?></button>
      </div>
    </div>
     </form>
  </div>
</div>