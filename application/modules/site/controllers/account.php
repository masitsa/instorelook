<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/site/controllers/site.php";

class Account extends site 
{
	var $customer_id;
		
	function __construct()
	{
		parent:: __construct();
		
		$this->load->model('vendor/orders_model');
		$this->load->model('vendor/vendor_model');
		$this->load->model('login/login_model');
		$this->load->model('site/checkout_model');
		
		//user has logged in
		if($this->login_model->check_customer_login())
		{
			$this->customer_id = $this->session->userdata('customer_id');
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
	*	Open the account page
	*
	*/
	public function my_account()
	{
		$data['content'] = $this->load->view('account/dashboard', '', true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Open the orders list
	*
	*/
	public function orders_list()
	{	
		//page data
		$v_data['all_orders'] = $this->orders_model->get_user_orders($this->customer_id);
		$data['content'] = $this->load->view('account/orders', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Open the user's details page
	*
	*/
	public function my_details()
	{
		//page data
		$v_data['surburbs_query'] = $this->vendor_model->get_all_surburbs();
		$v_data['customer_query'] = $this->checkout_model->get_customer_details($this->customer_id);
		$data['content'] = $this->load->view('account/my_details', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Open the user's shipping page
	*
	*/
	public function edit_shipping()
	{
		//page data
		$v_data['surburbs_query'] = $this->vendor_model->get_all_surburbs();
		$v_data['shipping_query'] = $this->checkout_model->get_shipping_details($this->customer_id);
		$data['content'] = $this->load->view('account/shipping_address', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Open the user's wishlist
	*
	*/
	public function my_addresses()
	{
		$v_data['surburbs_query'] = $this->vendor_model->get_all_surburbs();
		$v_data['customer_query'] = $this->checkout_model->get_customer_details($this->customer_id);
		$v_data['shipping_query'] = $this->checkout_model->get_shipping_details($this->customer_id);
		$data['content'] = $this->load->view('account/my_addresses', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Open the user's wishlist
	*
	*/
	public function wishlist()
	{
		$v_data['products_path'] = $this->products_path;
		$v_data['products_location'] = $this->products_location;
		$v_data['wishlist'] = $this->orders_model->get_user_wishlist($this->customer_id);
		$data['content'] = $this->load->view('account/wishlist', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
	
	public function delete_wishlist_item($wishlist_id)
	{
		$this->db->where('wishlist_id', $wishlist_id);
		$this->db->delete('wishlist');
		echo 'true';
		redirect('account/wishlist');
	}
    
	/*
	*
	*	Update a user's account
	*
	*/
	public function update_account()
	{
		//form validation rules
		$this->form_validation->set_rules('last_name', 'Last Names', 'required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('front_error_message', validation_errors());
		}
		
		else
		{
			//check if user has valid login credentials
			if($this->users_model->edit_frontend_user($this->session->userdata('user_id')))
			{
				$this->session->set_userdata('front_success_message', 'Your details have been successfully updated');
			}
			
			else
			{
				$this->session->set_userdata('front_error_message', 'Oops something went wrong and we were unable to update your details. Please try again');
			}
		}
		
		$this->my_details();
	}
    
	/*
	*
	*	Update a user's password
	*
	*/
	public function update_password()
	{
		//form validation rules
		$this->form_validation->set_rules('current_password', 'Current Password', 'required|xss_clean');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('front_error_message', validation_errors());
		}
		
		else
		{
			//update password
			$update = $this->users_model->edit_password($this->session->userdata('user_id'));
			if($update['result'])
			{
				$this->session->set_userdata('front_success_message', 'Your password has been successfully updated');
			}
			
			else
			{
				$this->session->set_userdata('front_error_message', $update['message']);
			}
		}
		
		$this->my_details();
	}
	
	public function cancel_order($order_preffix, $order_number)
	{
		$number = $order_preffix.'/'.$order_number;
		//confirm order is for the customer
		if($this->orders_model->request_cancel($number, $this->customer_id))
		{
			$this->session->set_userdata('success_message', 'Your cancel request for order number '.$number.' has been received. You will be notified once the request is confirmed');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Unable to cancel your order. Please try again');
		}
		
		redirect('account/orders-list');
	}
	
	public function make_payment($order_preffix, $order_number)
	{
		$number = $order_preffix.'/'.$order_number;
		//confirm order is for the customer
		if($this->checkout_model->make_payment($number, $this->customer_id))
		{
			$this->session->set_userdata('success_message', 'Your cancel request for order number '.$number.' has been received. You will be notified once the request is confirmed');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Unable to initiate payment for your order. Please try again');
		}
		
		redirect('account/orders-list');
	}
}