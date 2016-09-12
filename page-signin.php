 <?php
/**
 * Template Name: Page Signin
*/
?>

	<?php get_header(); ?>
    <?php get_template_part( 'template/search', 'form' ); ?>

 	<!-- List job !-->
    <div class="container">
        <div class="row">
            <div class="col-md-8 list-job">
              <h2>Sign in</h2>

                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#tab_login" aria-controls="tab_login" role="tab" data-toggle="tab">Login</a></li>
                  <li role="presentation"><a href="#tab_registration" aria-controls="tab_registration" role="tab" data-toggle="tab"><?php _e('Sign up','boxtheme');?></a></li>
                </ul>

                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade in active" id="tab_login">
                      <form>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 form-control-label"><?php _e('User name','boxtheme');?></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="<?php _e('User name','boxtheme');?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 form-control-label"><?php _e('Password','boxtheme');?></label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="inputPassword3" placeholder="<?php _e('Password',ET_DOMAIN);?>">
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
                      <div class="form-group row">
                         <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-secondary"><?php _e('Sign in','boxtheme');?> </button>
                         </div>
                      </div>
                    </form>
                  </div> <!-- end tab_login !-->
                  <div role="tabpanel" class="tab-pane fade" id="tab_registration">
                      register form here
                  </div> <!--end  tab_registration !-->

                </div>
            ?>
            </div> <!-- list-job !-->
           <?php get_sidebar(); ?>
        </div>
    </div>
    <!-- End List Job !-->
<?php get_footer(); ?>