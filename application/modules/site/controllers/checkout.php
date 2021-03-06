<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/site/controllers/site.php";

class Checkout extends site 
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('vendor/orders_model');
		$this->load->model('vendor/vendor_model');
		$this->load->model('login/login_model');
		$this->load->model('checkout_model');
		$this->load->model('payments_model');
	}
    
	/*
	*
	*	Open the checkout page
	*
	*/
	public function checkout_user()
	{
		//check if customer has logged in
		if($this->login_model->check_customer_login())
		{
			redirect('checkout-progress');
		}
		
		else
		{
			//Required general page data
			$v_data['all_children'] = $this->categories_model->all_child_categories();
			$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
			$v_data['crumbs'] = $this->site_model->get_crumbs();
			
			$data['content'] = $this->load->view('checkout/checkout', $v_data, true);
			
			$data['title'] = $this->site_model->display_page_title();
			$this->load->view('templates/general_page', $data);
		}
	}
    /*
	*
	*	Open the checkout page
	*
	*/
	public function checkout_progress($page_name = NULL)
	{
		//user has logged in
		if($this->login_model->check_customer_login())
		{
			//Required general page data
			$v_data['all_children'] = $this->categories_model->all_child_categories();
			$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
			$v_data['crumbs'] = $this->site_model->get_crumbs();
			$v_data['surburbs_query'] = $this->vendor_model->get_all_surburbs();
			//$v_data['product'] = $this->products_model->get_all_surburbs();
			
			if($page_name == NULL)
			{
				$v_data['page_name'] = 'billing';
			}
			else
			{
				$v_data['page_name'] = $page_name;
			}
			
			$data['content'] = $this->load->view('checkout/checkout_progress', $v_data, true);
			
			$data['title'] = $this->site_model->display_page_title();
			$this->load->view('templates/general_page', $data);
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Please sign up/in before you can checkout');
			$this->session->set_userdata('redirect', 'checkout-progress');
			redirect('sign-in');
		}
		
	}
	/*
	*
	*	Register a front end user
	*
	*/
	public function register()
	{
		//form validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|is_unique[customer.customer_email]|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|xss_clean|matches[password]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_message('is_unique', 'That email has already been registered. Are you trying to login?');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('front_success_message', 'You have successfully created an account. You can login and proceed checking out');
			
			$this->checkout_user();
		}
		
		else
		{
			//check if user has valid login credentials
			if($this->users_model->add_frontend_user())
			{
				//check if user has valid login credentials
				$this->login_user(1);
			}
			
			else
			{
				$this->session->set_userdata('front_error_message', 'Could not add a new user. Please try again.');
				
				$this->checkout_user();
			}
		}
	}
    
	/*
	*
	*	Login a front end user
	*
	*/
	public function login_user($page)
	{
		//form validation rules
		$this->form_validation->set_rules('customer_email', 'Email', 'required|xss_clean|exists[customer.customer_email]');
		$this->form_validation->set_rules('customer_password', 'Password', 'required|xss_clean');
		$this->form_validation->set_message('exists', 'That email does not exist. Are you trying to sign up?');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('front_error_message', validation_errors());
				
			$this->checkout_user();
		}
		
		else
		{
			//check if user has valid login credentials
			if($this->login_model->validate_customer())
			{
				if($page == 1)
				{
					redirect('checkout-progress');
				}
			}
			
			else
			{
				$this->session->set_userdata('front_error_message', 'Could not create a login session. Please login again.');
				$this->checkout_user();
			}
		}
	}
    
	/*
	*
	*	Checkout page user's details
	*
	*/
	public function my_details()
	{
		//user has logged in
		if($this->login_model->check_customer_login())
		{
			//Required general page data
			$v_data['all_children'] = $this->categories_model->all_child_categories();
			$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
			$v_data['crumbs'] = $this->site_model->get_crumbs();
			
			$cart_items = $this->cart->total_items();
			
			//go to checkout if there are items in cart
			if($cart_items > 0)
			{
				//page datea
				$v_data['step'] = 1;
				$v_data['user_details'] = $this->users_model->get_user($this->session->userdata('user_id'));
				$data['content'] = $this->load->view('checkout/my_details', $v_data, true);
			}
			
			//go to account if there are no items in cart
			else
			{
				//page datea
				$v_data['user_details'] = $this->users_model->get_user($this->session->userdata('user_id'));
				$data['content'] = $this->load->view('user/my_account', $v_data, true);
			}
			
			$data['title'] = $this->site_model->display_page_title();
			$this->load->view('templates/general_page', $data);
		}
		
		//user has not logged in
		else
		{
			$this->session->set_userdata('front_error_message', 'Please sign up/in to continue');
				
			redirect('checkout');
		}
	}
    
	/*
	*
	*	Action of a forgotten password
	*
	*/
	public function forgot_password()
	{
		//form validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|exists[users.email]');
		$this->form_validation->set_message('exists', 'That email does not exist. Are you trying to sign up?');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$this->load->model('email_model');
			
			//reset password
			if($this->users_model->reset_password($this->input->post('email')))
			{
				$this->session->set_userdata('front_success_message', 'Your password has been reset and mailed to '.$this->input->post('email').'. Please use that password to sign in here');
				
				redirect('checkout');
			}
			
			else
			{
				$this->session->set_userdata('front_error_message', 'Could not add a new user. Please try again.');
			}
		}
		
		else
		{
			$this->session->set_userdata('front_error_message', validation_errors());
		}
		
		//Required general page data
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		//page datea
		$data['content'] = $this->load->view('checkout/reset_password', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Checkout page delivery method
	*
	*/
	public function delivery()
	{
		//user has logged in
		if($this->login_model->check_customer_login())
		{
			//Required general page data
			$v_data['all_children'] = $this->categories_model->all_child_categories();
			$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
			$v_data['crumbs'] = $this->site_model->get_crumbs();
			
			$cart_items = $this->cart->total_items();
			
			//go to delivery page if there are items in cart
			if($cart_items > 0)
			{
				//page datea
				$v_data['step'] = 2;
				$v_data['user_details'] = $this->users_model->get_user($this->session->userdata('user_id'));
				$data['content'] = $this->load->view('checkout/delivery', $v_data, true);
			}
			
			//go to account if there are no items in cart
			else
			{
				//page datea
				$v_data['user_details'] = $this->users_model->get_user($this->session->userdata('user_id'));
				$data['content'] = $this->load->view('user/my_account', $v_data, true);
			}
			
			$data['title'] = $this->site_model->display_page_title();
			$this->load->view('templates/general_page', $data);
		}
		
		//user has not logged in
		else
		{
			$this->session->set_userdata('front_error_message', 'Please sign up/in to continue');
				
			redirect('checkout');
		}
	}
    
	/*
	*
	*	Checkout page payment options
	*
	*/
	public function payment_options()
	{
		//user has logged in
		if($this->login_model->check_customer_login())
		{
			//Required general page data
			$v_data['all_children'] = $this->categories_model->all_child_categories();
			$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
			$v_data['crumbs'] = $this->site_model->get_crumbs();
			
			$cart_items = $this->cart->total_items();
			
			//go to delivery page if there are items in cart
			if($cart_items > 0)
			{
				//page datea
				$v_data['step'] = 3;
				$data['content'] = $this->load->view('checkout/payment', $v_data, true);
			}
			
			//go to account if there are no items in cart
			else
			{
				//page datea
				$v_data['user_details'] = $this->users_model->get_user($this->session->userdata('user_id'));
				$data['content'] = $this->load->view('user/my_account', $v_data, true);
			}
			
			$data['title'] = $this->site_model->display_page_title();
			$this->load->view('templates/general_page', $data);
		}
		
		//user has not logged in
		else
		{
			$this->session->set_userdata('front_error_message', 'Please sign up/in to continue');
				
			redirect('checkout');
		}
	}
    
	/*
	*
	*	Checkout page prder details
	*
	*/
	public function order_details()
	{
		//user has logged in
		if($this->login_model->check_customer_login())
		{
			//Required general page data
			$v_data['all_children'] = $this->categories_model->all_child_categories();
			$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
			$v_data['crumbs'] = $this->site_model->get_crumbs();
			
			$cart_items = $this->cart->total_items();
			
			//go to delivery page if there are items in cart
			if($cart_items > 0)
			{
				//page datea
				$v_data['step'] = 4;
				$data['content'] = $this->load->view('checkout/order', $v_data, true);
			}
			
			//go to account if there are no items in cart
			else
			{
				//page datea
				$v_data['user_details'] = $this->users_model->get_user($this->session->userdata('user_id'));
				$data['content'] = $this->load->view('user/my_account', $v_data, true);
			}
			
			$data['title'] = $this->site_model->display_page_title();
			$this->load->view('templates/general_page', $data);
		}
		
		//user has not logged in
		else
		{
			$this->session->set_userdata('front_error_message', 'Please sign up/in to continue');
				
			redirect('checkout');
		}
	}
    
	/*
	*
	*	Confirm order
	*
	*/
	public function confirm_order()
	{
		//user has logged in
		if($this->login_model->check_customer_login())
		{
			/*$return = $this->cart_model->save_order();
			//save order
			if($return['price'] > 0)
			{
				//do paypal payment
				$return_url = site_url().'checkout/order-complete';
				$cancel_url = site_url().'products';
				$this->load->library('paypal');
				$this->session->set_userdata('completion_success_message', 'Your order has been completed successfully');
				$this->paypal->doExpressCheckout($return['price'], $return['package_name'] ,'', 'AUD', $return_url, $cancel_url);
			}
			
			else
			{
				$this->session->set_userdata('completion_error_message', 'Unable to save complete order. Please try again');
			}*/
			redirect('payment');
		}
		
		//user has not logged in
		else
		{
			$this->session->set_userdata('completion_error_message', 'Please sign up/in to continue');
		}
	}
	
	public function order_complete($completed_orders)
	{
		//mark orders as complete
		$orders = explode("-", $completed_orders);
		$total = count($orders);
		
		if($total > 0)
		{
			for($r = 0; $r < $total; $r++)
			{
				$order_id = $orders[$r];
				
				if(!empty($order_id))
				{
					$order_data['order_status_id'] = 0;
					
					$this->db->where('order_id', $order_id);
					if($this->db->update('orders', $order_data))
					{
					}
				}
			}
		}
		
		//remove session data
		$array_items = array('delivery_instructions' => '', 'payment_option' => '');
		$this->session->unset_userdata($array_items);
		
		//clear the shopping cart
		$this->cart->destroy();
		
		/*$data['content'] = $this->load->view('complete_order', '', TRUE);
			
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);*/
		
		$this->session->set_userdata('success_message', 'Your payment has been received successfully');
		redirect('account/orders-list');
	}
	
	public function order_cancel($cancelled_orders)
	{
		//delete orders
		$orders = explode("-", $cancelled_orders);
		$total = count($orders);
		
		if($total > 0)
		{
			for($r = 0; $r < $total; $r++)
			{
				$order_id = $orders[$r];
				
				if(!empty($order_id))
				{
					//get order item ids for features
					$where = 'order_item.order_id = '.$order_id;
					$this->db->where($where);
					$query = $this->db->get('order_item');
					if($query->num_rows() > 0)
					{
						$result = $query->result();
						
						foreach($result as $res)
						{
							$order_item_id = $res->order_item_id;
							
							//delete order item features
							$where = 'order_item_id = '.$order_item_id;
							$this->db->where($where);
							if($this->db->delete('order_item_feature'))
							{
							}
						}
					}
					
					//delete order items
					$where = 'order_item.order_id = '.$order_id;
					$this->db->where($where);
					if($this->db->delete('order_item'))
					{
					}
					
					//delete order
					$where = 'order_id = '.$order_id;
					$this->db->where($where);
					if($this->db->delete('orders'))
					{
					}
				}
			}
		}
		
		$this->session->set_userdata('error_message', 'You have cancelled your payment');
		redirect('checkout-progress/review');
	}
    
	/*
	*
	*	Add delivery instructions
	*
	*/
	public function add_delivery_instructions()
	{
		//form validation rules
		$this->form_validation->set_rules('delivery_instructions', 'Delivery Instructions', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('front_error_message', validation_errors());
		}
		
		else
		{
			$this->session->set_userdata('front_success_message', 'Instructions added successfully');
			$this->session->set_userdata('delivery_instructions', $this->input->post('delivery_instructions'));
		}
		redirect('checkout/delivery');
	}
    
	/*
	*
	*	Add payment options
	*
	*/
	public function add_payment_options()
	{
		//form validation rules
		$this->form_validation->set_rules('radios', 'Payment Method', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('front_error_message', validation_errors());
			redirect('checkout/payment-options');
		}
		
		else
		{
			$this->session->set_userdata('payment_option', $this->input->post('radios'));
			redirect('checkout/order');
		}
	}
	
	public function update_billing_details($page = NULL)
	{
		//form validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|exists[customer.customer_email]|valid_email');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_rules('company', 'Company', 'trim|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
		$this->form_validation->set_rules('surburb_id', 'Surburb', 'required|trim|xss_clean|numeric');
		$this->form_validation->set_message('exists', 'That email does not exist. Are you trying to sign up?');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('billing_error_message', validation_errors());
		}
		
		else
		{
			//check if user has valid login credentials
			if($this->checkout_model->update_customer())
			{
				//check if user has valid login credentials
				$this->session->set_userdata('billing_success_message', 'Your billing details have been updated sucessfully');
			}
			
			else
			{
				$this->session->set_userdata('billing_error_message', 'Could not update your billing details. Please try again');
			}
		}
		
		if($page == 1)
		{
			redirect('account/personnal-information');
		}
		
		else
		{
			redirect('checkout-progress/billing');
		}
	}
	
	public function update_shipping_details($page = NULL, $customer_shipping_id = NULL)
	{
		//form validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_rules('company', 'Company', 'trim|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
		$this->form_validation->set_rules('surburb_id', 'Surburb', 'required|trim|xss_clean|numeric');
		$this->form_validation->set_message('exists', 'That email does not exist. Are you trying to sign up?');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('shipping_error_message', validation_errors());
		}
		
		else
		{
			if($customer_shipping_id > 0)
			{
				//check if user has valid login credentials
				if($this->checkout_model->update_shipping_details($customer_shipping_id))
				{
					//check if user has valid login credentials
					$this->session->set_userdata('shipping_success_message', 'Your shipping details have been updated sucessfully');
				}
				
				else
				{
					$this->session->set_userdata('shipping_error_message', 'Could not update your shipping details. Please try again');
				}
			}
			
			else
			{
				//check if user has valid login credentials
				if($this->checkout_model->add_shipping_details())
				{
					//check if user has valid login credentials
					$this->session->set_userdata('shipping_success_message', 'Your shipping details have been added sucessfully');
				}
				
				else
				{
					$this->session->set_userdata('shipping_error_message', 'Could not add your shipping details. Please try again');
				}
			}
		}
		
		if($page == 1)
		{
			redirect('account/edit-shipping');
		}
		
		else
		{
			redirect('checkout-progress/shipping');
		}
	}
	
	/*
	*	Split a payment between multiple merchants
	*
	*/
	public function split_payment()
	{
		$response = $this->payments_model->split_payment();
		var_dump($response);
	}
	
	public function delete_shipping_address($customer_shipping_id)
	{
		$data['delete'] = 1;
		$this->db->where('customer_shipping_id', $customer_shipping_id);
		if($this->db->update('customer_shipping', $data))
		{
			$this->session->set_userdata('shipping_success_message', 'Shipping address has been deleted successfully');
		}
		
		else
		{
			$this->session->set_userdata('shipping_error_message', 'Unable to delete shipping address. Please try again');
		}
		
		redirect('checkout-progress/shipping');
	}
}
?>