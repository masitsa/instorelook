<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vendor_auth extends MX_Controller 
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('auth/login_model');
		
		if($this->login_model->check_vendor_login())
		{
		}
		else
		{
			$this->session->userdata('error_message', 'Please sign in to access your account');
			redirect('vendor/sign-in');
		}
	}
}

?>