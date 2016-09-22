<?php
function bx_social_button_signup(){?>
    <p class="hidden-xs text-center ng-scope" >
        <span> You can also sign up with</span>
            <a href="#" data-eo-facebook-signup="" data-popup="true" data-auth-callback="facebookCallback(profile)" rel="nofollow" class="ng-isolate-scope">
            Facebook</a>,

            <a href="#" data-eo-linkedin-signup="" data-popup="true" data-auth-callback="linkedinCallback(profile)" rel="nofollow" class="ng-isolate-scope">
            Linkedin</a>,
     or
            <a href="#" data-eo-google-signup="" data-popup="true" data-auth-callback="googleCallback(profile)" rel="nofollow" class="ng-isolate-scope">
            Google</a>.
            <?php button_fb_log() ;?>

    </p>
<?php } ?>