<?php

/**
 * @param $price
 */
function mycity_stripe_form($price)
{
    global $_POST;

    if (isset($_POST['stripeToken'])) {
        $ROOT = get_template_directory();
        require_once $ROOT . '/stripe-php-2.1.2/init.php';
 
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey("sk_test_pkdHCUuUGZaxA1Xv0C3HLo3l");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];
        $transactionHash = dechex(rand(10000000000000, 100000000000000));
        $serviceMessage = $transactionHash . " increase balance user#" . $user['id'];

        // Create the charge on Stripe's servers - this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                    "amount" => sanitize_text_field($_POST['price']), // amount in cents, again
                    "currency" => "usd",
                    "source" => sanitize_text_field($token),
                    "description" => sanitize_text_field($serviceMessage))
            );

            ?>

            <div id="stripe1">

                <div id="paymentWaitDisplay">
                    <?php esc_html_e('Wait for payment system response...', 'mycity'); ?>
                </div>

            </div>


            <script>
                var TIMEOUT_MAX = 5 * 60 * 1000; // 5 mins
                var CHECK_TIMEOUT = 5 * 1000; //10 secs
                var CHECK_URL = '<?php echo esc_url(get_template_directory_uri());?>/check_payment.php';

                var serviceMessage = '<?php echo esc_html($serviceMessage) ?>';
                var isWaiting = true;
                var checkerInterval = null;


                function stopWaiting() {
                    isWaiting = false;
                    clearInterval(checkerInterval);
                }

                checkerInterval = setInterval(function () {

                    jQuery.post(CHECK_URL, {descr: serviceMessage}, function (data) {
                        stopWaiting();
                    }).done(function () {
                        jQuery('#paymentWaitDisplay').html('Payment success');
                        //location.href = '/?p=balance&payment_status=1';
                    })
                        .fail(function () {
                            jQuery('#paymentWaitDisplay').html('There was an error during the payment');
                            //location.href = '/?p=balance&payment_status=0';
                        });

                }, CHECK_TIMEOUT);

                setTimeout(function () {
                    stopWaiting();
                    jQuery('#paymentWaitDisplay').html('There was an error during the payment');
                    location.href = '/?p=balance&payment_status=0';
                }, TIMEOUT_MAX);

            </script>

            <?php

        } catch (\Stripe\Error\Card $e) {
            // The card has been declined
        }
    }

    ?>
    <form action="" method="POST">
        <input type="hidden" name="price" value="<?php echo esc_html($price); ?>00"/>

        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="pk_test_hO7AvW6Ws6nDAlX8TheHP4E6"
            data-image="//stripe.com/img/documentation/checkout/marketplace.png"
            data-name="<?php echo esc_html($_SERVER['HTTP_HOST']) ?>"
            data-description="Buy coupon #<?php echo esc_html($post->id); ?>"
            data-amount="<?php echo esc_html($price) ?>00">
        </script>

    </form>
    <?php
}

?>