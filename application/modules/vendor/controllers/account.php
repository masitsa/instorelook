<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "./application/modules/auth/controllers/auth.php";

class Account extends auth 
{
	var $airlines_path;
	var $airlines_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('vendor_model');
	}
    
	/*
	*
	*	Airline Dashboard
	*
	*/
	public function index() 
	{
		
		$data['content'] = $this->load->view('dashboard', '', true);
		
		$data['title'] = 'My Account';
		$this->load->view('account_template', $data);
	}
    
	/*
	*
	*	Airline Dashboard
	*
	*/
	public function index() 
	{
		
		$data['content'] = $this->load->view('dashboard', '', true);
		
		$data['title'] = 'My Account';
		$this->load->view('account_template', $data);
	}
}