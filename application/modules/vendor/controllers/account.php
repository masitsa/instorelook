<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "./application/modules/auth/controllers/vendor_auth.php";

class Account extends vendor_auth
{
	var $airlines_path;
	var $airlines_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('vendor_model');
		$this->load->model('site/site_model');
	}
    
	/*
	*
	*	Airline Dashboard
	*
	*/
	public function index() 
	{
		
		$data['content'] = $this->load->view('dashboard', '', true);
		$data['content'] = '<div class="alert alert-success center-align">Welcome to your account</div>';
		
		$data['title'] = 'My Account';
		$this->load->view('account_template', $data);
	}
}