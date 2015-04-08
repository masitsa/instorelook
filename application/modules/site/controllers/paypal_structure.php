<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/site/controllers/site.php";

class Paypal extends site 
{
	var $request_envelope;
	var $paypal_api_url;
	var $paypal_url;
	var $headers;
	
	function __construct()
	{
		parent:: __construct();
		
		$this->request_envelope = array(
			"errorLanguage" => "en_US",
			"detailLevel" => "ReturnAll"
		);
		$this->paypal_api_url = $this->config->item('paypal_api_url');
		$this->paypal_url = $this->config->item('paypal_url');
		
		$this->headers = array(
			"X-PAYPAL-SECURITY-USERID: ".$this->config->item('paypal_api_user'),
			"X-PAYPAL-SECURITY-PASSWORD: ".$this->config->item('paypal_api_password'),
			"X-PAYPAL-SECURITY-SIGNATURE: ".$this->config->item('paypal_api_signature'),
			"X-PAYPAL-REQUEST-DATA-FORMAT: JSON",
			"X-PAYPAL-RESPONSE-DATA-FORMAT: JSON",
			"X-PAYPAL-APPLICATION-ID: ".$this->config->item('paypal_api_appID')
		);
	}
	
	//CURL wrapper used to send data to paypal
	private function paypal_send($data, $call)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->paypal_api_url.$call);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		
		return json_decode(curl_exec($ch), TRUE);
	}
	
	private function create_payment_packet()
	{
		//create the pay request
		$create_packet = array(
			"actionType" => "PAY",
			"currencyCode" => "AUD",
			"receiverList" => array(
				"receiver" => array(
					array(
						"amount" => "2.00",
						"email" => "alvaromasitsa104@gmail.com"
					),//end of receiver 1
					array(
						"amount" => "5.00",
						"email" => "alvaromasitsa104@yahoo.com"
					)//end of receiver 2
				)//end of receiver
			),//end of receiverList
			"returnUrl" => site_url()."payment-return",
			"cancelUrl" => site_url()."payment-cancel",
			"requestEnvelope" => $this->request_envelope
		);//end of pay request
		
		$response = $this->paypal_send($create_packet, 'Pay');
		
		return $response;
	}
	
	private function set_payment_details($pay_key)
	{
		$details_packet = array(
			"requestEnvelope" => $this->request_envelope,
			"payKey" => $pay_key,
			"receiverOptions" => array(
				array(
					"receiver" => array("email" => "alvaromasitsa104@gmail.com"),
					"invoiceData" => array(
						"item" => array(//list as many items as you want each in its own array
							array(
								"name" => "Product 1",
								"price" => "1.00",
								"identifier" => "1"
							),//end of item1
							array(
								"name" => "Product 2",
								"price" => "1.00",
								"identifier" => "2"
							)//end of item2
						)//end item
					)//end invoiceData
				),//end receiver1
				array(
					"receiver" => array("email" => "alvaromasitsa104@yahoo.com"),
					"invoiceData" => array(
						"item" => array(//list as many items as you want each in its own array
							array(
								"name" => "Product 3",
								"price" => "3.00",
								"identifier" => "1"
							),//end of item1
							array(
								"name" => "Product 4",
								"price" => "2.00",
								"identifier" => "1"
							)//end of item2
						)//end item
					)//end invoiceData
				),//end receiver2
			)//end receiverOptions
		);
		
		//send to paypal
		$response = $this->paypal_send($details_packet, "SetPaymentOptions");
		
		return $response;
	}
	
	private function get_payment_options($pay_key)
	{
		$packet = array(
			"requestEnvelope" => $this->request_envelope,
			"payKey" => $pay_key
		);
		
		return $this->paypal_send($packet, "GetPaymentOptions");
	}
	
	//split the payment
	public function split_payment()
	{
		$create_response = $this->create_payment_packet();
		
		//get the pay key to be used to communicate payment details to Paypal
		$pay_key = $create_response['payKey'];
		
		$set_response = $this->set_payment_details($pay_key);
		
		$payment_options = $this->get_payment_options($pay_key);
		//var_dump($payment_options);
		
		//send them to Paypal to make the payment
		header("Location: ".$this->paypal_url.$pay_key);
	}
}
?>