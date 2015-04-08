<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/site/controllers/checkout.php";

class Paypal extends checkout 
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
	
	private function create_payment_packet($return, $return_url, $cancel_url)
	{
		$vendor_data = $return['vendor_data'];
		
		//create the pay request
		$create_packet = array(
			"actionType" => "PAY",
			"currencyCode" => "AUD",
			"receiverList" => array(
				"receiver" => array($vendor_data)
			),//end of receiverList
			"returnUrl" => $return_url,
			"cancelUrl" => $cancel_url,
			"requestEnvelope" => $this->request_envelope
		);//end of pay request
		
		$response = $this->paypal_send($create_packet, 'Pay');
		
		return $response;
	}
	
	private function set_payment_details($pay_key, $return)
	{
		//sort payment items
		$order_details = $return['order_details'];
		
		$details_packet = array(
			"requestEnvelope" => $this->request_envelope,
			"payKey" => $pay_key,
			"receiverOptions" => array($order_details)//end receiverOptions
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
		$return = $this->cart_model->save_order();
		//var_dump($return);die();
		//do paypal payment
		$return_url = site_url().'checkout/order-complete/'.$return['created_orders'];
		//$cancel_url = site_url().'checkout-progress/review/'.$return['created_orders'];
		$cancel_url = site_url().'checkout/order-cancel/'.$return['created_orders'];
		
		$create_paykey = $this->create_payment_packet($return, $return_url, $cancel_url);
		
		//get the paykey to be used to communicate payment details to Paypal
		$pay_key = $create_paykey['payKey'];
		
		$set_response = $this->set_payment_details($pay_key, $return);
		
		$payment_options = $this->get_payment_options($pay_key);
		
		//send them to Paypal to make the payment
		header("Location: ".$this->paypal_url.$pay_key);
	}
	
	//split the payment
	public function split_payment_account($order_preffix, $order_number)
	{
		//user has logged in
		if($this->login_model->check_customer_login())
		{
			$this->customer_id = $this->session->userdata('customer_id');
			
			$number = $order_preffix.'/'.$order_number;
			$return = $this->checkout_model->make_payment($number, $this->customer_id);
			
			//confirm order is for the customer
			if(count($return['vendor_data']) > 0)
			{
				//do paypal payment
				$return_url = site_url().'checkout/order-complete/'.$return['created_orders'];
				//$cancel_url = site_url().'checkout-progress/review/'.$return['created_orders'];
				$cancel_url = site_url().'account/orders-list';
				
				$create_paykey = $this->create_payment_packet($return, $return_url, $cancel_url);
				
				//get the paykey to be used to communicate payment details to Paypal
				$pay_key = $create_paykey['payKey'];
				
				$set_response = $this->set_payment_details($pay_key, $return);
				
				$payment_options = $this->get_payment_options($pay_key);
				
				//send them to Paypal to make the payment
				header("Location: ".$this->paypal_url.$pay_key);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to initiate payment for your order. Please try again');
				redirect('account/orders-list');
			}
		}
		
		//user has not logged in
		else
		{
			$this->session->set_userdata('error_message', 'Please sign up/in to continue');
				
			redirect('sign-in');
		}
	}
	
	//split the payment
	public function cancel_order($order_preffix, $order_number)
	{
		//user has logged in
		if($this->login_model->check_vendor_login())
		{
			$this->vendor_id = $this->session->userdata('vendor_id');
			
			$number = $order_preffix.'/'.$order_number;
			$return = $this->orders_model->refund_order($number, $this->vendor_id);
			//var_dump($return);die();
			//confirm order is for the customer
			if(count($return['vendor_data']) > 0)
			{
				//do paypal payment
				$return_url = site_url().'vendor/orders/cancel_order/'.$order_preffix.'/'.$order_number;
				//$cancel_url = site_url().'checkout-progress/review/'.$return['created_orders'];
				$cancel_url = site_url().'vendor/all-orders';
				
				$create_paykey = $this->create_payment_packet($return, $return_url, $cancel_url);
				
				//get the paykey to be used to communicate payment details to Paypal
				$pay_key = $create_paykey['payKey'];
				
				$set_response = $this->set_payment_details($pay_key, $return);
				
				$payment_options = $this->get_payment_options($pay_key);
				
				//send them to Paypal to make the payment
				header("Location: ".$this->paypal_url.$pay_key);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to initiate payment for your order. Please try again');
				redirect('account/orders-list');
			}
		}
		
		//user has not logged in
		else
		{
			$this->session->set_userdata('error_message', 'Please sign up/in to continue');
				
			redirect('sign-in');
		}
	}
}
?>