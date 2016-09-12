<?php
if ( ! defined( 'ABSPATH' ) ) exit;
	class JB_Paypal{

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
			//add_action( 'parse_request', array($this, 'handle_api_requests'), 0);
			//add_action( 'http_api_curl', array( $this, 'http_api_curl' ), 10, 3 );
		}
		public function handle_api_requests() {

			if(!isset($_SESSION)){
			    session_start();
			}
	        if ( isset($_POST["txn_id"]) && !isset( $_SESSION['order_id']) ){
	            // Buffer, we won't want any output here
	            ob_start();
	            $this->handle_ipn_api_requests();
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

			// Read POST data
			// reading posted data directly from $_POST causes serialization
			// issues with array data in POST. Reading raw POST data from input stream instead.
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
				//error_log($key .' = '. $value,  3, LOG_FILE);
				$req .= "&$key=$value";
			}

			// Post IPN data back to PayPal to validate the IPN data is genuine
			// Without this step anyone can fake IPN data


			$ch = curl_init($this->paypal_url);
			if ($ch == FALSE) {
				error_log( "False " . PHP_EOL, 3, LOG_FILE);
				return FALSE;
			}

			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

			if(DEBUG_PAYMENT == true) {
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
			}

			// CONFIG: Optional proxy configuration
			//curl_setopt($ch, CURLOPT_PROXY, $proxy);
			//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

			// Set TCP timeout to 30 seconds
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

			// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
			// of the certificate as shown below. Ensure the file is readable by the webserver.
			// This is mandatory for some environments.

			//$cert = __DIR__ . "./cacert.pem";
			//curl_setopt($ch, CURLOPT_CAINFO, $cert);

			$res = curl_exec($ch);
			if (curl_errno($ch) != 0) {

				// cURL error
				if(DEBUG_PAYMENT == true) {
					error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
				}
				curl_close($ch);
				exit;

			} else {
				curl_close($ch);
			}

			// Inspect IPN validation result and act accordingly

			// Split response headers and payload, a better way for strcmp
			$tokens = explode("\r\n\r\n", trim($res));
			$res = trim(end($tokens));

			if ( strcmp ($res, "VERIFIED") == 0 ) {
				// check whether the payment_status is Completed
				// check that txn_id has not been previously processed
				// check that receiver_email is your PayPal email
				// check that payment_amount/payment_currency are correct
				// process payment and mark item as paid.

				// assign posted variables to local variables
				$item_name = $_POST['item_name'];
				$item_number = $_POST['item_number'];
				$payment_status = $_POST['payment_status'];
				$payment_amount = $_POST['mc_gross'];
				$payment_currency = $_POST['mc_currency'];
				$txn_id = $_POST['txn_id'];
				$receiver_email = $_POST['receiver_email'];
				$payer_email = $_POST['payer_email'];
				$address_street = $_POST['address_street'];
				$address_name = $_POST['address_name'];
				$shipping_fee = $_POST['shipping'];
				$payment_date = $_POST['payment_date'];
				$address_street = $_POST['address_street'];
				$address_country_code  = $_POST['address_country_code'];
				$address_country  = $_POST['address_country'];
				$address_city  = $_POST['address_city'];
				$payment_fee  = $_POST['payment_fee'];
				//$address_city  = $_POST['address_city'];


				/*
				 * insert order
				 */

				$job_id = isset($_POST['custom']) ? $_POST['custom'] : 'No job';

				if ( ! is_job_has_order($job_id) ) {

					$post_args = array(
						'ID' 		  => $job_id,
						'post_status' => JB_Job::get_post_status_check_out(),
						);
					$job = get_post($job_id);
					wp_update_post( $post_args );
					global $user_ID;

					$meta_input = array(
	    				'package_id'		=> $item_number,
					    'payment_date' 		=> $payment_date,
					    'payer_email' 		=> $payer_email,
					    'receiver_email' 	=> $receiver_email,
					    'payment_amount' 	=> $payment_amount,
					    'currency'   		=> $payment_currency,
					    'payment_fee' 		=> $payment_fee,
					    'txn_id' 			=> $txn_id,
					    'address_street' 	=> $address_street,
					    'address_city' 		=> $address_city,
					    'address_country' 	=> $address_country,

				    );

					$args = array(
						'post_type' 	=> PT_ORDER,
						'post_status' 	=> 'publish',
						'post_title' 	=> $job_id . '-'.date('[Y-m-d H:i e] '),
						'post_parent' 	=> $job_id,
						'post_author' 	=> $job->post_author,
						'meta_input' 	=> $meta_input,
					);

					$order_id = wp_insert_post($args);
					if( !is_wp_error( $order_id )){
						//error_log(' vo update order. Package'.$item_number, 3, LOG_FILE);
						//foreach ($_POST as $key => $value) {
							//error_log($key.' = '.$value .'\n', 3, LOG_FILE);
						//}

						update_post_meta($job_id, 'has_order', $order_id);
						$_SESSION['order_id'] = $order_id;
					} else {
						error_log(' Error insert order',3, LOG_FILE);
					}
				}

				if(DEBUG_PAYMENT == true) {
					// error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
				}
			} else if (strcmp ($res, "INVALID") == 0) {
				// log for manual investigation
				// Add business logic here which deals with invalid IPN messages
				if(DEBUG_PAYMENT == true) {
					// error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
				}
			}

		}

		function __destruct(){

		}
	}
new JB_Paypal();