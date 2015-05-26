<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MX_Controller
{
	var $vendor_path;
	var $vendor_location;
	var $vendor_id;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('orders_model');
		$this->load->model('products_model');
		$this->load->model('vendor_model');
		$this->load->model('site/site_model');
		$this->load->model('login/login_model');
		$this->load->model('admin/file_model');
		
		$this->load->library('image_lib');
		
		//user has logged in
		if($this->login_model->check_vendor_login())
		{
			//path to image directory
			$this->vendor_path = realpath(APPPATH . '../assets/images/vendors');
			$this->vendor_location = base_url().'assets/images/vendors/';
			$this->vendor_id = $this->session->userdata('vendor_id');
		}
		
		//user has not logged in
		else
		{
			$this->session->set_userdata('error_message', 'Please sign up/in to continue');
				
			redirect('sign-in');
		}
	}
    
	/*
	*
	*	Vendor Dashboard
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
	*	Vendor profile
	*
	*/
	public function vendor_profile($page_name = 'personnal') 
	{
		$v_data['page_name'] = $page_name;
		$v_data['countries_query'] = $this->vendor_model->get_all_countries();
		$v_data['surburbs_query'] = $this->vendor_model->get_all_surburbs();
		$v_data['vendor_location'] = $this->vendor_location;
		$v_data['vendor_details'] = $this->vendor_model->get_vendor($this->vendor_id);
		$v_data['vendor_subscription'] = $this->vendor_model->get_subscription($this->vendor_id);
		$v_data['vendor_categories'] = $this->vendor_model->get_vendor_categories($this->vendor_id);
		$v_data['categories'] = $this->vendor_model->get_parent_categories();
		$data['content'] = $this->load->view('account/vendor_profile', $v_data, true);
		
		$data['title'] = 'My Profile';
		$this->load->view('account_template', $data);
	}
    
	/*
	*
	*	Vendor update categories
	*
	*/
	public function update_categories() 
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('categories', 'Categories', 'required');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			//update categories
			if($this->vendor_model->update_categories($this->input->post('categories'), $this->vendor_id))
			{
				$this->session->unset_userdata('categories');
				$this->session->set_userdata('success_message', 'Your categories have been updated successfully');
			}
		}
		
		//go to the subscription page
		$this->vendor_profile('subscription');
	}
    
	/*
	*
	*	Update vendor details
	*
	*/
	public function update_vendor_details() 
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('vendor_first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vendor_last_name', 'Last Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vendor_phone', 'Phone', 'trim|required|min_length[8]|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->vendor_model->update_user_details($this->vendor_id))
			{
				$this->session->set_userdata('success_message', 'Your details have been updated successfully.');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to add user details. Please try again');
			}
		}
		
		$this->vendor_profile('personnal');
	}
    
	/*
	*
	*	Update vendor password
	*
	*/
	public function update_vendor_password() 
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('vendor_current_password', 'Current password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('vendor_password', 'New password', 'trim|required|matches[confirm_password]|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			$update = $this->vendor_model->update_vendor_password($this->vendor_id);
			if($update['result'])
			{
				$this->session->set_userdata('success_message', 'Your password has been successfully updated');
			}
			
			else
			{
				$this->session->set_userdata('error_message', $update['message']);
			}
		}
		
		$this->vendor_profile('personnal');
	}
    
	/*
	*
	*	Update store details
	*
	*/
	public function update_store_details() 
	{
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
			if($this->vendor_model->update_store_details($this->vendor_id))
			{
				//redirect only if logo error isnt present
				if(empty($v_data['vendor_logo_error']))
				{
					$this->session->unset_userdata('vendor_logo_thumb_name');
					$this->session->unset_userdata('vendor_logo_file_name');
					$this->session->set_userdata('success_message', 'Your store details have been updated successfully');
				}
			
				else
				{
					$this->session->set_userdata('error_message', 'Store logo upload error');
				}
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to add user details. Please try again');
			}
		}
		
		$this->vendor_profile('business');
	}
	
	public function deactivate_account()
	{
		if($this->vendor_model->deactivate_account($this->vendor_id))
		{
			//sign out vendor
			$this->session->sess_destroy();
			
			redirect('vendor/goodbye');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Apologies. We are unable to deactivate your account. Please try again later');
		
			$this->vendor_profile('personnal');
		}
	}
	
	public function activate_shipping_method($method = 3)
	{
		if($this->vendor_model->update_shipping_method($this->vendor_id, $method))
		{
			$this->session->set_userdata('success_message', 'Shipping method has been updated successfully');
		}
		else
		{
			$this->session->set_userdata('error_message', 'Shipping method could not be added updated. Please try again.');
		}
		
		redirect('vendor/account-profile/shipping');
	}
	
	public function add_fixed_rate()
	{
		$this->form_validation->set_rules('vendor_fixed_rate', 'Default rate', 'required|greater_than[0]|xss_clean');
			
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$this->vendor_model->add_fixed_rate($this->vendor_id);
			$this->session->set_userdata('success_message', 'Fixed rate added');
		}
		
		else
		{
			$this->session->set_userdata('error_message', validation_errors());
		}
		redirect('vendor/account-profile/shipping');
	}
	
	public function update_paypal_email()
	{
		$this->form_validation->set_rules('vendor_payment_email', 'Payment email', 'required|is_unique[vendor.vendor_payment_email]|valid_email|xss_clean');
		$this->form_validation->set_message('is_unique', 'That email has already been added. Please add another email address');
			
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$this->vendor_model->update_paypal_email($this->vendor_id);
			$this->session->set_userdata('success_message', 'Payment email has been updated successfully');
		}
		
		else
		{
			$this->session->set_userdata('error_message', validation_errors());
		}
		redirect('vendor/account-profile/payment');
	}
}