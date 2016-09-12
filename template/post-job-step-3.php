<?php
global $i;
?>
<li class="heading-step">
    <div class="wizard-heading">
        <?php $i = $i+1; echo $i;?>. Payment Method
        <span class="icon-mode"></span>
    </div>
    <div class="wizard-content">
        <p>Your payment methods detail section.</p>
        <ul class="payments">
            <li>
                <div class="form-group row">
                    <?php
                    $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                    $return     = bx_get_static_link('process-payment');
                    ?>
                    <div class="col-md-8">
                        <label> Paypal </label>
                        <p> 1$ for 50 job and expiry within 100 days</p>
                    </div>
                    <div class="col-md-4">

                        <form class="paypal" action="<?php echo $paypal_url; ?>" method="GET" id="paypal_form">
                            <input type="hidden" name="cmd" value="_xclick" />
                            <input type="hidden" name="no_note" value="1" />
                            <input type="hidden" name="lc" value="UK" />
                            <input type="hidden" name="currency_code" value="USD" />
                            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                            <input type="hidden" name="first_name" value="Customer's First Name"  />
                            <input type="hidden" name="last_name" value="Customer's Last Name"  />
                            <input type="hidden" name="payer_email" value="freelancer@testing.com"  />
                            <input type="hidden" name="business" value="testing@etteam.com">
                            <input type="hidden" name="item_number" id="item_number" value="123" / >
                            <input type="hidden" name="job_id" id="job_id" value="999" / >
                            <input type="hidden" name="item_name" value="Premium package" / >
                            <input type="hidden" name="custom" id="custom_field" value="">
                            <input type="hidden" name="amount" value="1" / >
                            <input type="hidden" name="return" value="<?php echo $return?>" / >
                            <input type="hidden" name="cancel_return" value="<?php echo $return;?>" / >
                            <input type="hidden" name="notify_url" value="<?php echo $return;?>" / >
                            <input type="submit" name="submit" class="btn btn-green" value="Select"/>
                        </form>
                    </div>
                </div>
            </li>
            <?php do_action('add_payment_gateways'); ?>
        </ul>
<!--         <button class="btn-green" type="submit">Done</button> -->
    </div>
</li>