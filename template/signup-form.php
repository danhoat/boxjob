<?php

?>
            <form class="form-horizontal frm-jobseekr-signup" method="POST">
                <div class="form-group">
                    <div class="col-md-12">
                         <h1 class="o-h2-bold m-md-bottom m-xs-top">
                            <span data-ng-hide="socialConnect.provider" class="">Create a Free Freelancer Account</span>
                            <span data-ng-show="socialConnect.provider" class="ng-hide">
                                You're almost there!  </span>
                        </h1>
                        <center>
                            <?php
                            if($role == JOBSEEKER){
                               printf(__('Looking to hire? <a href="%s" > Sign ups a client</a>','boxtheme'), bx_get_static_link('signup-employer'));
                            } else{
                                printf(__('Looking to work? <a href="%s" > Sign ups a jobseeker</a>','boxtheme'), bx_get_static_link('signup-jobseeker') );

                            } ?>
                        </center>
                        <?php bx_social_button_signup(); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php _e('Enter First Name...','boxtheme');?>" />
                    </div>
                </div>

            <div class="form-group">
                <div class="col-md-12">
                   <input type="text" class="form-control"  name="last_name" id="last_name" placeholder="<?php _e('Enter Last Name...','boxtheme');?>" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                     <input type="text" class="form-control" id="inputscreenname" placeholder="<?php _e('Enter your email','boxtheme');?>" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <select name="country" class="form-control">
                        <option value="">Your country</option>
                        <option value="">VietNam</option>
                        <option value="">England</option>
                        <option value="">Germany</option>
                        <option value="">France</option>
                        <option value="">USA</option>
                        <option value="">Australia</option>
                    </select>
               </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                     <input type="text" name="user_login" class="form-control" id="user_login" placeholder="<?php _e('User name','boxtheme');?>" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                     <input type="text" name="user_pass" class="form-control" id="user_pass" placeholder="<?php _e('Password');?>" />
                </div>
            </div>
            <div class="form-group">
                    <div class="col-md-12">
                    <label><input type="checkbox"  name="">
                        <small>
                            Yes, I understand and agree to the <a href="#" target="_blank"> Terms of Service</a>, including the
                            <a href="#" target="_blank">User Agreement</a> and
                            <a href="#" target="_blank">Privacy Policy</a>.
                        </small>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12" id="show_warning">
                </div>
            </div>
            <input type="hidden" name="role" value="<?php echo $role;?>">
            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-md btn-primary"> <?php _e('Get Started','boxtheme');?></button>
                </div>
             </div>


        </form>