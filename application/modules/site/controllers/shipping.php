<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/site/controllers/site.php";

class Shipping extends site {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('shipping_model');
	}
	
	public function ship_item()
	{
		$results = $this->shipping_model->create_shipment();
		if (isset($results['error']))
		{
			throw new Exception($results['error']['errorMessage']);
		}
		
		else
		{
			var_dump($results);
		}
	}
}