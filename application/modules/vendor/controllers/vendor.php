<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends MX_Controller {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('vendor_model');
		$this->load->model('admin/file_model');
		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->vendor_path = realpath(APPPATH . '../assets/images/vendors');
		$this->vendor_location = base_url().'assets/images/vendors/';
	}
	
	public function index()
	{
		redirect('vendor/vendor_signup1');
	}
    
	/*
	*
	*	Vendor Signup 1
	*
	*/
	public function vendor_signup1() 
	{
		//initialize required variables
		$v_data['vendor_first_name_error'] = '';
		$v_data['vendor_last_name_error'] = '';
		$v_data['vendor_email_error'] = '';
		$v_data['vendor_phone_error'] = '';
		$v_data['vendor_password_error'] = '';
		$v_data['confirm_password_error'] = '';
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('vendor_first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vendor_last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vendor_email', 'Email', 'trim|valid_email|required|xss_clean');
		$this->form_validation->set_rules('vendor_phone', 'Phone', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vendor_password', 'Password', 'trim|required|matches[confirm_password]|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->vendor_model->register_user_details())
			{
				redirect('vendor/sign-up/store-details');
			}
			
			else
			{
				$this->session->set_userdata('vendor_signup1_error_message', 'Unable to add user details. Please try again');
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				//create errors
				$v_data['vendor_first_name_error'] = form_error('vendor_first_name');
				$v_data['vendor_last_name_error'] = form_error('vendor_last_name');
				$v_data['vendor_email_error'] = form_error('vendor_email');
				$v_data['vendor_phone_error'] = form_error('vendor_phone');
				$v_data['vendor_password_error'] = form_error('vendor_password');
				$v_data['confirm_password_error'] = form_error('confirm_password');
				
				//repopulate fields
				$v_data['vendor_first_name'] = set_value('vendor_first_name');
				$v_data['vendor_last_name'] = set_value('vendor_last_name');
				$v_data['vendor_email'] = set_value('vendor_email');
				$v_data['vendor_phone'] = set_value('vendor_phone');
				$v_data['vendor_password'] = set_value('vendor_password');
				$v_data['confirm_password'] = set_value('confirm_password');
			}
			
			//populate form data on initial load of page
			else
			{
				$vendor_first_name = $this->session->userdata('vendor_first_name');
				
				//If session data already exists
				if(!empty($vendor_first_name))
				{
					$v_data['vendor_first_name'] = $vendor_first_name;
					$v_data['vendor_last_name'] = $this->session->userdata('vendor_last_name');
					$v_data['vendor_email'] = $this->session->userdata('vendor_email');
					$v_data['vendor_phone'] = $this->session->userdata('vendor_phone');
					$v_data['vendor_password'] = $this->session->userdata('vendor_password');
					$v_data['confirm_password'] = $this->session->userdata('vendor_password');
				}
				
				else
				{
					$v_data['vendor_first_name'] = '';
					$v_data['vendor_last_name'] = '';
					$v_data['vendor_email'] = '';
					$v_data['vendor_phone'] = '';
					$v_data['vendor_password'] = '';
					$v_data['confirm_password'] = '';
				}
			}
		}
		
		$data['content'] = $this->load->view('vendor_signup1', $v_data, true);
		
		$data['title'] = 'Sign Up';
		$this->load->view('site/templates/general_page', $data);
	}
    
	/*
	*
	*	Vendor Signup 2
	*
	*/
	public function vendor_signup2() 
	{
		//initialize required variables
		$v_data['vendor_logo_location'] = 'http://placehold.it/300x300';
		$v_data['vendor_store_name_error'] = '';
		$v_data['vendor_store_phone_error'] = '';
		$v_data['vendor_store_email_error'] = '';
		$v_data['vendor_store_summary_error'] = '';
		$v_data['vendor_categories_error'] = '';
		$v_data['vendor_logo_error'] = '';
		
		//upload image if it has been selected
		if($this->vendor_model->upload_vendor_image($this->vendor_path))
		{
			$v_data['vendor_logo_location'] = $this->vendor_location.$this->session->userdata('vendor_logo_file_name');
		}
		
		//case of upload error
		else
		{
			$v_data['vendor_logo_error'] = $this->session->userdata('vendor_logo_error_message');
		}
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('vendor_store_name', 'Store Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vendor_store_phone', 'Store Phone', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vendor_store_email', 'Store Email', 'trim|valid_email|required|xss_clean');
		$this->form_validation->set_rules('vendor_store_summary', 'Store Summary', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vendor_categories', 'Categories', 'trim|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->vendor_model->register_store_details())
			{
				redirect('vendor/sign-up/subscribe');
			}
			
			else
			{
				$this->session->set_userdata('vendor_signup2_error_message', 'Unable to add user details. Please try again');
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				//create errors
				$v_data['vendor_store_name_error'] = form_error('vendor_store_name');
				$v_data['vendor_store_phone_error'] = form_error('vendor_store_phone');
				$v_data['vendor_store_email_error'] = form_error('vendor_store_email');
				$v_data['vendor_store_summary_error'] = form_error('vendor_store_summary');
				$v_data['vendor_categories_error'] = form_error('vendor_categories');
				
				//repopulate fields
				$v_data['vendor_store_name'] = set_value('vendor_store_name');
				$v_data['vendor_store_phone'] = set_value('vendor_store_phone');
				$v_data['vendor_store_email'] = set_value('vendor_store_email');
				$v_data['vendor_store_summary'] = set_value('vendor_store_summary');
				$v_data['vendor_categories'] = set_value('vendor_categories');
			}
			
			//populate form data on initial load of page
			else
			{
				$vendor_store_name = $this->session->userdata('vendor_store_name');
				
				//If session data already exists
				if(!empty($vendor_store_name))
				{
					$v_data['vendor_store_name'] = $vendor_store_name;
					$v_data['vendor_store_phone'] = $this->session->userdata('vendor_store_phone');
					$v_data['vendor_store_email'] = $this->session->userdata('vendor_store_email');
					$v_data['vendor_store_summary'] = $this->session->userdata('vendor_store_summary');
					$v_data['vendor_categories'] = $this->session->userdata('vendor_categories');
					$v_data['vendor_logo_location'] = $this->vendor_location.$this->session->userdata('vendor_logo_file_name');
				}
				
				else
				{
					$v_data['vendor_store_name'] = '';
					$v_data['vendor_store_phone'] = '';
					$v_data['vendor_store_email'] = '';
					$v_data['vendor_store_summary'] = '';
					$v_data['vendor_categories'] = '';
				}
			}
		}
		
		$data['content'] = $this->load->view('vendor_signup2', $v_data, true);
		
		$data['title'] = 'Sign Up';
		$this->load->view('site/templates/general_page', $data);
		
		
	}
    
	/*
	*
	*	Vendor Signup 3
	*
	*/
	public function vendor_signup3() 
	{
		
		$data['content'] = $this->load->view('vendor_signup3', '', true);
		
		$data['title'] = 'Sign Up';
		$this->load->view('site/templates/general_page', $data);
	}
    
	/*
	*
	*	Vendor Subscription
	*
	*/
	public function subscribe($type) 
	{
		//if($vendor_id = $this->vendor_model->register_vendor())
		if(1 == 2)
		{
			//new session array
			$newdata = array(
				   'login_status'   => TRUE,
				   'first_name'     => $this->session->userdata('vendor_user_first_name'),
				   'vendor_name'     => $this->session->userdata('vendor_name'),
				   'email'     		=> $this->session->userdata('vendor_user_email'),
				   'user_id' 		=> $vendor_id,
				   'user_type_id'  	=> 2
			   );
			
			//unset sign up session
			$this->session->sess_destroy();
			
			//create user session
			$this->session->set_userdata($newdata);
			
			//update user's last login date time
			$this->vendor_model->update_vendor_login($vendor_id);
			redirect('vendor/account');
		}
		
		else
		{
			$this->session->set_userdata('vendor_signup3_error_message', 'Unable to add user details. Please try again');
			$this->load->view('select');
		}
	}
    
	/*
	*
	*	Vendor Dashboard
	*
	*/
	public function vendor_dashboard() 
	{
		
		$data['content'] = $this->load->view('dashboard', '', true);
		
		$data['title'] = 'My Account';
		$this->load->view('account_template', $data);
	}
    
	/*
	*
	*	Vendor Dashboard
	*
	*/
	public function test_email($receiver_email) 
	{
		$this->load->library('Mandrill', 'yPN5McI91NQbs7spbOUpPA');
		$this->load->model('site/email_model');
		
		$subject = "Thanks for registering your shop";
		$message = '
				<p>Please activate your account here</p>
				';
		$sender_email = "alvaromasitsa104@gmail.com";
		$shopping = "";
		$from = "In Store Look";
		$button = NULL;
		$response = $this->email_model->send_mandrill_mail($receiver_email, "Hi Alvaro", $subject, $message, $sender_email, $shopping, $from, $button);
		
		echo var_dump($response);
	}
}
?>