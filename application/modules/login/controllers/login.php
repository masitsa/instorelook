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
			   'login_status'     => '',
			   'customer_first_name'     => '',
			   'email'     => '',
			   'customer_id'     => '',
			   'user_type_id'  => ''
		   );
		$this->session->unset_userdata($newdata);
		$this->session->set_userdata('success_message', 'Your have been signed out of your account');
		redirect('sign-in');
	}
	
	public function sign_in()
	{
		$data['content'] = $this->load->view('sign_in', '', true);
		
		$data['title'] = 'Sign in';
		$this->load->view('site/templates/general_page', $data);
	}
	
	public function sign_up()
	{
		$data['content'] = $this->load->view('sign_up', '', true);
		
		$data['title'] = 'Join';
		$this->load->view('site/templates/general_page', $data);
	}
    
	/*
	*
	*	Customer Signup
	*
	*/
	public function register_customer() 
	{
		//initialize required variables
		$v_data['customer_first_name_error'] = '';
		$v_data['customer_surname_error'] = '';
		$v_data['customer_email_error'] = '';
		$v_data['customer_phone_error'] = '';
		$v_data['customer_password_error'] = '';
		$v_data['confirm_password_error'] = '';
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('customer_first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('customer_surname', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('customer_email', 'Email', 'trim|valid_email|required|is_unique[customer.customer_email]|xss_clean');
		$this->form_validation->set_rules('customer_phone', 'Phone', 'trim|min_length[8]|xss_clean');
		$this->form_validation->set_rules('customer_password', 'Password', 'trim|required|matches[confirm_password]|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
		$this->form_validation->set_message('is_unique', 'This email has been registered');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->login_model->register_customer())
			{
				//sign in customer
				if($this->login_model->validate_customer())
				{
					redirect('account');
				}
				
				else
				{
					$this->session->set_userdata('error_message', 'Could not create a login session. Please login again.');
					redirect('sign-in');
				}
			}
			
			else
			{
				$this->session->set_userdata('customer_signup_error_message', 'Unable to add user details. Please try again');
			}
		}
		$validation_errors = validation_errors();
			
		//repopulate form data if validation errors are present
		if(!empty($validation_errors))
		{
			//create errors
			$v_data['customer_first_name_error'] = form_error('customer_first_name');
			$v_data['customer_surname_error'] = form_error('customer_surname');
			$v_data['customer_email_error'] = form_error('customer_email');
			$v_data['customer_phone_error'] = form_error('customer_phone');
			$v_data['customer_password_error'] = form_error('customer_password');
			$v_data['confirm_password_error'] = form_error('confirm_password');
			
			//repopulate fields
			$v_data['customer_first_name'] = set_value('customer_first_name');
			$v_data['customer_surname'] = set_value('customer_surname');
			$v_data['customer_email'] = set_value('customer_email');
			$v_data['customer_phone'] = set_value('customer_phone');
			$v_data['customer_password'] = set_value('customer_password');
			$v_data['confirm_password'] = set_value('confirm_password');
		}
		
		//populate form data on initial load of page
		else
		{
			$v_data['customer_first_name'] = '';
			$v_data['customer_surname'] = '';
			$v_data['customer_email'] = '';
			$v_data['customer_phone'] = '';
			$v_data['customer_password'] = '';
			$v_data['confirm_password'] = '';
		}
		
		$data['content'] = $this->load->view('customer_sign_up', $v_data, true);
		
		$data['title'] = 'Sign Up';
		$this->load->view('site/templates/general_page', $data);
	}
	
	public function redirect_account()
	{
		//get user type
		$user_type = $this->session->userdata('user_type_id');
		
		//if customer go to customer account
		if($user_type == 3)
		{
			redirect('customer/account');
		}
		
		else
		{
			redirect('vendor/account');
		}
	}
    
	/*
	*
	*	Customer Signup
	*
	*/
	public function sign_in_customer($page = NULL) 
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('customer_email', 'Email', 'required|xss_clean|exists[customer.customer_email]');
		$this->form_validation->set_rules('customer_password', 'Password', 'required|xss_clean');
		$this->form_validation->set_message('exists', 'That email does not exist. Are you trying to sign up?');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			//sign in customer
			if($this->login_model->validate_customer())
			{
				//sign in from modal via AJAX
				if($page == 1)
				{
					$data['result'] = 'success';
					echo json_encode($data);
				}
				
				//sign in from form in sign in page
				else
				{
					redirect('account');
				}
			}
			
			else
			{
				//sign in from modal via AJAX
				if($page == 1)
				{
					$data['result'] = 'failure';
					$data['message'] = 'Could not create a login session. Please login again.';
					echo json_encode($data);
				}
				
				//sign in from form in sign in page
				else
				{
					$this->session->set_userdata('error_message', 'Could not create a login session. Please login again.');
					$this->sign_in();
				}
			}
		}
		
		else
		{
			//sign in from modal via AJAX
			if($page == 1)
			{
				$data['result'] = 'failure';
				$data['message'] = validation_errors();
				echo json_encode($data);
			}
		}
		
		//this stage is not required for the AJAX sign in
		if($page == NULL)
		{
			$this->sign_in();
		}
	}
}
?>