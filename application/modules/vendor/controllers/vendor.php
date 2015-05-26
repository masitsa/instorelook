<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends MX_Controller 
{
	var $vendor_path;
	var $vendor_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('vendor_model');
		$this->load->model('products_model');
		$this->load->model('site/site_model');
		$this->load->model('admin/file_model');
		$this->load->model('site/cart_model');
		
		$this->load->library('image_lib');
		$this->load->library('encrypt');
		
		//path to image directory
		$this->vendor_path = realpath(APPPATH . '../assets/images/vendors');
		$this->vendor_location = base_url().'assets/images/vendors/';
		$this->load->library('Mandrill', $this->config->item('mandrill_key'));
	}
	
	public function index()
	{
		redirect('vendor/account');
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
		$this->form_validation->set_rules('vendor_email', 'Email', 'trim|valid_email|required|is_unique[vendor.vendor_email]|xss_clean');
		$this->form_validation->set_rules('vendor_phone', 'Phone', 'trim|required|min_length[8]|xss_clean');
		$this->form_validation->set_rules('vendor_password', 'Password', 'trim|required|matches[confirm_password]|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
		$this->form_validation->set_message('is_unique', 'This email has been registered');
		
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
		$v_data['vendor_logo_location'] = 'http://placehold.it/300x300&text=Upload+logo';
		$v_data['vendor_store_name_error'] = '';
		$v_data['vendor_store_phone_error'] = '';
		//$v_data['vendor_store_email_error'] = '';
		$v_data['vendor_store_summary_error'] = '';
		$v_data['vendor_logo_error'] = '';
		$v_data['vendor_store_address_error'] = '';
		$v_data['vendor_store_mobile_error'] = '';
		$v_data['vendor_store_state_error'] = '';
		$v_data['vendor_store_country_error'] = '';
		$v_data['vendor_business_type_error'] = '';
		$v_data['surburb_id_error'] = '';
		$v_data['country_id_error'] = '';
		$v_data['vendor_store_postcode_error'] = '';
		$v_data['return_policy_error'] = '';
		
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
		$this->form_validation->set_rules('vendor_store_name', 'Business Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vendor_store_phone', 'Phone', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('vendor_store_email', 'Store Email', 'trim|valid_email|required|xss_clean');
		$this->form_validation->set_rules('vendor_store_summary', 'Store Summary', 'trim|required|min_length[25]|xss_clean');
		$this->form_validation->set_rules('vendor_store_address', 'Address', 'trim|xss_clean');
		$this->form_validation->set_rules('vendor_store_mobile', 'Mobile Number', 'trim|xss_clean');
		$this->form_validation->set_rules('vendor_store_state', 'State', 'trim|xss_clean');
		$this->form_validation->set_rules('country_id', 'Country', 'trim|xss_clean');
		$this->form_validation->set_rules('vendor_business_type', 'Business Type', 'trim|xss_clean');
		$this->form_validation->set_rules('surburb_id', 'Surburb', 'required|xss_clean');
		$this->form_validation->set_rules('vendor_store_postcode', 'Postcode', 'trim|xss_clean');
		$this->form_validation->set_rules('return_policy', 'Return policy', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->vendor_model->register_store_details())
			{
				//redirect only if logo error isnt present
				if(empty($v_data['vendor_logo_error']))
				{
					redirect('vendor/sign-up/subscribe');
				}
			}
			
			else
			{
				$this->session->set_userdata('vendor_signup2_error_message', 'Unable to add user details. Please try again');
			}
		}
		$validation_errors = validation_errors();
		
		//repopulate form data if validation errors are present
		if(!empty($validation_errors))
		{
			//create errors
			$v_data['vendor_store_name_error'] = form_error('vendor_store_name');
			$v_data['vendor_store_phone_error'] = form_error('vendor_store_phone');
			//$v_data['vendor_store_email_error'] = form_error('vendor_store_email');
			$v_data['vendor_store_summary_error'] = form_error('vendor_store_summary');
			$v_data['vendor_store_address_error'] = form_error('vendor_store_address');
			$v_data['vendor_store_mobile_error'] = form_error('vendor_store_mobile');
			$v_data['vendor_store_state_error'] = form_error('vendor_store_state');
			$v_data['country_id_error'] = form_error('country_id');
			$v_data['vendor_business_type_error'] = form_error('vendor_business_type');
			$v_data['surburb_id_error'] = form_error('surburb_id');
			$v_data['vendor_store_postcode_error'] = form_error('vendor_store_postcode');
			$v_data['return_policy_error'] = form_error('return_policy');
			
			//repopulate fields
			$v_data['vendor_store_name'] = set_value('vendor_store_name');
			$v_data['vendor_store_phone'] = set_value('vendor_store_phone');
			//$v_data['vendor_store_email'] = set_value('vendor_store_email');
			$v_data['vendor_store_summary'] = set_value('vendor_store_summary');
			$v_data['vendor_store_address'] = set_value('vendor_store_address');
			$v_data['vendor_store_mobile'] = set_value('vendor_store_mobile');
			$v_data['vendor_store_state'] = set_value('vendor_store_state');
			$v_data['country_id'] = set_value('country_id');
			$v_data['vendor_business_type'] = set_value('vendor_business_type');
			$v_data['surburb_id'] = set_value('surburb_id');
			$v_data['vendor_store_postcode'] = set_value('vendor_store_postcode');
			$v_data['return_policy'] = set_value('return_policy');
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
				//$v_data['vendor_store_email'] = $this->session->userdata('vendor_store_email');
				$v_data['vendor_store_summary'] = $this->session->userdata('vendor_store_summary');
				$v_data['vendor_store_address'] = $this->session->userdata('vendor_store_address');
				$v_data['vendor_logo_location'] = $this->vendor_location.$this->session->userdata('vendor_logo_file_name');
				$v_data['vendor_store_mobile'] = $this->session->userdata('vendor_store_mobile');
				$v_data['vendor_store_state'] = $this->session->userdata('vendor_store_state');
				$v_data['country_id'] = $this->session->userdata('country_id');
				$v_data['vendor_business_type'] = $this->session->userdata('vendor_business_type');
				$v_data['surburb_id'] = $this->session->userdata('surburb_id');
				$v_data['vendor_store_postcode'] = $this->session->userdata('vendor_store_postcode');
				$v_data['return_policy'] = $this->session->userdata('return_policy');
			}
			
			else
			{
				$v_data['vendor_store_name'] = '';
				$v_data['vendor_store_phone'] = '';
				//$v_data['vendor_store_email'] = '';
				$v_data['vendor_store_summary'] = '';
				$v_data['vendor_store_address'] = '';
				$v_data['vendor_store_mobile'] = '';
				$v_data['vendor_store_state'] = '';
				$v_data['country_id'] = '';
				$v_data['vendor_business_type'] = '';
				$v_data['surburb_id'] = '';
				$v_data['vendor_store_postcode'] = '';
				$v_data['return_policy'] = '';
			}
		}
		
		$v_data['countries_query'] = $this->vendor_model->get_all_countries();
		$v_data['surburbs_query'] = $this->vendor_model->get_all_surburbs();
		$data['content'] = $this->load->view('vendor_signup2', $v_data, true);
		
		$data['title'] = 'Sign Up';
		$this->load->view('site/templates/general_page', $data);
		
		
	}
    
	/*
	*
	*	Vendor Signup 3
	*
	*/
	public function vendor_signup3($page = 1) 
	{
		$v_data['page'] = $page;
		$this->session->set_userdata('page', $page);
		$v_data['current_plan'] = $this->session->userdata('subscription_id');
		$data['content'] = $this->load->view('vendor_signup3', $v_data, true);
		
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
		$v_data['page'] = $this->session->userdata('page');
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('categories', 'Categories', 'required');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			//save categories
			if($v_data['page'] == 1)
			{
				if($this->vendor_model->save_categories($this->input->post('categories'), $type))
				{
					$vendor_id = $this->vendor_model->register_vendor($type);
					if($vendor_id > 0)
					{
						$response = $this->vendor_model->send_account_verification_email($this->session->userdata('vendor_email'), $this->session->userdata('vendor_first_name'), $this->session->userdata('vendor_store_email'));
						//new session array
						$newdata = array(
							   'vendor_login_status'   		=> TRUE,
							   'first_name'     			=> $this->session->userdata('vendor_user_first_name'),
							   'vendor_name'     			=> $this->session->userdata('vendor_name'),
							   'email'     					=> $this->session->userdata('vendor_user_email'),
							   'vendor_id' 					=> $vendor_id,
							   'vendor_activation_status'  	=> 0,
							   'vendor_subscription_status'	=> 1
						   );
						
						//unset sign up session
						$this->session->sess_destroy();
						
						//create user session
						$this->session->set_userdata($newdata);
						
						//update user's last login date time
						//$this->vendor_model->update_vendor_login($vendor_id);
						redirect('vendor/success');
						/*$v_data['response'] = $response;
						$data['content'] = $this->load->view('success', $v_data, true);
						
						$data['title'] = 'Success';
						$this->load->view('site/templates/general_page', $data);*/
						
						//unset page session
						$this->session->unset_userdata('page');
					}
					
					else
					{
						$this->session->set_userdata('vendor_signup3_error_message', 'Unable to add user details. Please try again');
						$this->load->view('select');
					}
				}
			}
			
			else
			{
				//update categories
				if($this->vendor_model->update_categories($this->input->post('categories'), $this->session->userdata('vendor_id'), $v_data['page'], $type))
				{
					//subscribe vendor
					$this->vendor_model->subscribe_vendor($this->session->userdata('vendor_id'), $type);
					
					//change the vendor's subscription type
					$this->session->set_userdata('subscription_id', $type);
					
					$this->session->unset_userdata('categories');
					$this->session->set_userdata('success_message', 'Your categories have been updated successfully');
					
					//go to account page
					redirect('vendor/account-profile/subscription');
				}
			}
		}
		
		else
		{
			$this->session->set_userdata('vendor_signup3_error_message', 'Please select at least 1 category');
		}
		$v_data['vendor_categories'] = $this->vendor_model->get_vendor_categories($this->session->userdata('vendor_id'));
		
		$subscription_name = $this->vendor_model->get_subscription_name($type);
		
		if($subscription_name != 'Unable to find subscription')
		{
			$data['title'] = $subscription_name.' subscription';
			$v_data['title'] = $subscription_name.' subscription';
		}
		else
		{
			$data['title'] = $subscription_name;
			$v_data['title'] = $subscription_name;
		}
		$v_data['categories'] = $this->vendor_model->get_parent_categories();
		$data['content'] = $this->load->view('subscription', $v_data, true);
		$this->load->view('site/templates/general_page', $data);
	}
	
	public function success()
	{
		$data['content'] = $this->load->view('success', '', true);
		
		$data['title'] = 'Success';
		$this->load->view('site/templates/general_page', $data);
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
	
	public function get_surburbs()
	{
		$data['result'] = 'success';
		$data['response'] = array(
			0 => 'asdf',
			1 => 'uytg',
			2 => 'nhd',
			3 => 'gfsfg',
		);
		
		echo json_encode($data);
	}
	
	public function test() 
	{
		
		$data['content'] = $this->load->view('test', '', true);
		
		$data['title'] = 'Test';
		$this->load->view('site/templates/general_page', $data);
	}
	
	public function verify_email($email = NULL)
	{
		if($email)
		{
			if($this->vendor_model->verify_email($email))
			{
				$this->session->set_userdata('success_message', 'Your account is now active. Please sign in to access your account');
				redirect('vendor/sign-in');
			}
		}
		
		else
		{
			redirect('home');
		}
	}
    
	/*
	*
	*	Vendor Sign in
	*
	*/
	public function vendor_signin() 
	{
		//initialize required variables
		$v_data['vendor_email_error'] = '';
		$v_data['vendor_password_error'] = '';
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('vendor_email', 'Email', 'trim|valid_email|required|exists[vendor.vendor_email]|xss_clean');
		$this->form_validation->set_rules('vendor_password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_message('exists', 'This email has not been registered');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->vendor_model->login_vendor())
			{
				//echo 'Your account is now verified. YAY!';
				redirect('vendor/account');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to sign into your account. Please try again');
			}
		}
		$validation_errors = validation_errors();
			
		//repopulate form data if validation errors are present
		if(!empty($validation_errors))
		{
			//create errors
			$v_data['vendor_email_error'] = form_error('vendor_email');
			$v_data['vendor_password_error'] = form_error('vendor_password');
			
			//repopulate fields
			$v_data['vendor_email'] = set_value('vendor_email');
			$v_data['vendor_password'] = set_value('vendor_password');
		}
		
		//populate form data on initial load of page
		else
		{
			$v_data['vendor_email'] = '';
			$v_data['vendor_password'] = '';
		}
		
		$data['content'] = $this->load->view('vendor_signin', $v_data, true);
		
		$data['title'] = 'Sign In';
		$this->load->view('site/templates/general_page', $data);
	}
	
	public function encrypt($receiver_email = 'amasitsa@live.com')
	{
		$check = FALSE;//Used to check for forward slashes in string
		
		while($check == FALSE)
		{
			$encrypted_email = $this->encrypt->encode($receiver_email);
			$pos = strpos($encrypted_email, '/');
			if($pos === FALSE)
			{
				$check = TRUE;
			}
		}
		echo $encrypted_email;
	}
	
	public function decrypt($receiver_email)
	{
		$encrypted_email = $this->encrypt->decode($receiver_email);
		echo $encrypted_email;
	}
	
	public function encrypt_md5($key)
	{
		echo md5($key);
	}
	
	public function vendor_signout()
	{
		$this->session->sess_destroy();
		$this->session->set_userdata('success_message', 'Your have been signed out of your account');
		redirect('vendor/sign-in');
	}
	
	public function goodbye()
	{
		$data['content'] = $this->load->view('goodbye', '', true);
		
		$data['title'] = 'Goodbye';
		$this->load->view('site/templates/general_page', $data);
	}
}
?>