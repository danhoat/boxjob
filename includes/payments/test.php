<?php
if ( ! defined( 'ABSPATH' ) ) exit;
	class Paypal_Checkout{

		protected $use_sandbox;
		protected $paypal_url;
		protected $debug_mode;

		function __construct(){

			$this->use_sandbox 	= 1;
			$this->debug_mode 	= 1;
			if( $this->use_sandbox) {
				$this->paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
			} else {
				$this->paypal_url = "https://www.paypal.com/cgi-bin/webscr";
			}
			add_action( 'parse_request', array($this, 'handle_api_requests'), 0);
			//add_action( 'http_api_curl', array( $this, 'http_api_curl' ), 10, 3 );
		}
		add_action( 'parse_request', 'handle_api_requests', 0);
		public function handle_api_requests() {

			if(!isset($_SESSION)){
			    session_start();
			}
	        if ( isset($_POST["txn_id"]) ){
	            // Buffer, we won't want any output here
	            ob_start();
	            handle_ipn_api_requests();
	            ob_end_clean();
	        }
    	}
		/**
		 * catch paypal IPN respond and save to database.
		 * @since   1.0
		 * @author danng
		 * @return  void
		 */
		function handle_ipn_api_requests() {
			$raw_post_data = file_get_contents('php://input');
			$raw_post_array = explode('&', $raw_post_data);
			$myPost = array();
			foreach ($raw_post_array as $keyval) {
				$keyval = explode ('=', $keyval);
				if (count($keyval) == 2)
					$myPost[$keyval[0]] = urldecode($keyval[1]);
			}
			// read the post from PayPal system and add 'cmd'
			$req = 'cmd=_notify-validate';
			if(function_exists('get_magic_quotes_gpc')) {
				$get_magic_quotes_exists = true;
			}
			foreach ($myPost as $key => $value) {
				if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
					$value = urlencode(stripslashes($value));
				} else {
					$value = urlencode($value);
				}

				$req .= "&$key=$value";
			}
			$is_sandbox= get_option('is_sandbox', true);
			if( $is_sandbox) {
				$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
			} else {
				$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
			}
			$ch = curl_init($paypal_url);
			if ($ch == FALSE) {
				//error_log( "False " . PHP_EOL, 3, LOG_FILE);
				return FALSE;
			}

			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			// Set TCP timeout to 30 seconds
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

			$res = curl_exec($ch);
			if (curl_errno($ch) != 0) {
				curl_close($ch);
				exit;

			} else {
				curl_close($ch);
			}

			$tokens = explode("\r\n\r\n", trim($res));
			$res = trim(end($tokens));

			if ( strcmp ($res, "VERIFIED") == 0 ) {
				 //insert order
				$job_id = isset($_POST['custom']) ? $_POST['custom'] : 'No job';
				$order_id = get_post_meta($job_id, 'has_order', true);
				if ( ! $order_id ) {

					$job = get_post($job_id);
					wp_update_post(array('ID'=> $job_id,'post_status' => 'publish') );
					global $user_ID;

					$meta_input = array(
	    				'package_id'		=> $_POST['item_number'],
					    'payment_date' 		=> $_POST['payment_date'],
					    'payer_email' 		=> $_POST['payer_email'],
					    'receiver_email' 	=> $_POST['receiver_email'],
					    'payment_amount' 	=> $_POST['payment_amount'],
					    'currency'   		=> $_POST['payment_currency'],
					    'payment_fee' 		=> $_POST['payment_fee'],
					    'txn_id' 			=> $_POST['txn_id'],
					    'address_street' 	=> $_POST['address_street'],
					    'address_city' 		=> $_POST['address_city'],
					    'address_country' 	=> $_POST['address_country'],
				    );

					$args = array(
						'post_type' 	=> 'order',
						'post_status' 	=> 'publish',
						'post_title' 	=> $job_id . '-'.date('[Y-m-d H:i e] '),
						'post_parent' 	=> $job_id,
						'post_author' 	=> $job->post_author,
						'meta_input' 	=> $meta_input,
					);
					$order_id = wp_insert_post($args);
					if( !is_wp_error( $order_id )){
						update_post_meta($job_id, 'has_order', $order_id);
					}
				}

			} else if (strcmp ($res, "INVALID") == 0) {
				// Invalid process here
			}

		}

		function __destruct(){

		}
	}
new Paypal_Checkout();