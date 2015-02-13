<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('login_model');
		$this->load->model('site/site_model');
		$this->load->model('site/cart_model');
	}
    
	/*
	*
	*	Login a user
	*
	*/
	public function login_admin() 
	{
		//form validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|exists[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if user has valid login credentials
			if($this->login_model->validate_user())
			{
				//redirect('dashboard');
				redirect('all-users');
			}
			
			else
			{
				$data['error'] = 'The email or password provided is incorrect. Please try again';
				$this->load->view('admin_login', $data);
			}
		}
		
		else
		{
			$this->load->view('admin_login');
		}
	}
	
	public function logout_admin()
	{
		$this->session->sess_destroy();
		redirect('login-admin');
	}
	
	public function logout_user()
	{
		//create user's login session
		$newdata = array(
			   'customer_login_status'     => '',
			   'customer_first_name'     => '',
			   'email'     => '',
			   'customer_id'     => '',
			   'user_type_id'  => ''
		   );
		$this->session->unset_userdata($newdata);
		$this->session->set_userdata('front_success_message', 'Your have been signed out of your account');
		redirect('checkout');
	}
	
	public function sign_in()
	{
		$data['content'] = $this->load->view('sign_in', '', true);
		
		$data['title'] = 'Sign in';
		$this->load->view('site/templates/general_page', $data);
	}
}
?>