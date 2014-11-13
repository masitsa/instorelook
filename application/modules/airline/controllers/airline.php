<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airline extends MX_Controller {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('airline_model');
		$this->load->model('visitor_model');
		$this->load->library('session');
	}
    
	/*
	*
	*	Airline Signup 1
	*
	*/
	public function airline_signup1() 
	{
		
		$data['content'] = $this->load->view('airline_signup1', '', true);
		
		$data['title'] = 'Sign Up';
		$this->load->view('site/templates/general_page', $data);
		$this->load->helper('url','file','form');
		
	}
    
	/*
	*
	*	Airline Signup 2
	*
	*/
	public function airline_signup2() 
	{
		
		$data['content'] = $this->load->view('airline_signup2', '', true);
		
		$data['title'] = 'Sign Up';
		$this->load->view('site/templates/general_page', $data);
		$this->load->helper('url','file','form');
		
	}
    
	/*
	*
	*	Airline Signup 3
	*
	*/
	public function airline_signup3() 
	{
		
		$data['content'] = $this->load->view('airline_signup3', '', true);
		
		$data['title'] = 'Sign Up';
		$this->load->view('site/templates/general_page', $data);
		$this->load->helper('url','file','form');
	}
    
	/*
	*
	*	Airline Dashboard
	*
	*/
	public function airline_dashboard() 
	{
		
		$data['content'] = $this->load->view('dashboard', '', true);
		
		$data['title'] = 'My Account';
		$this->load->view('account_template', $data);
	}
}
?>