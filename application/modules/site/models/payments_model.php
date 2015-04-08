<?php

class Payments_model extends CI_Model 
{
	var $request_envelope;
	var $paypal_url;
	var $headers;
	
	function __construct()
	{
		parent:: __construct();
		
		$this->request_envelope = array(
			"errorLanguage" => "en_US",
			"detailLevel" => "ReturnAll"
		);
		$this->paypal_url = $this->config->item('paypal_api_url');
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
		curl_setopt($ch, CURLOPT_URL, $this->paypal_url.$call);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		
		return json_decode(curl_exec($ch), TRUE);
	}
	
	//split the payment
	public function split_payment()
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
	}
}
?>