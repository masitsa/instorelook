<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/site/controllers/site.php";

class Cart extends site {
	
	function __construct()
	{
		$this->load->model('login/login_model');
		$this->load->model('vendor/orders_model');
		parent:: __construct();
	}
	
	public function add_item($product_id, $product_features = NULL)
	{
		if($this->cart_model->add_item($product_id, $product_features))
		{
			$cart_items = $this->cart_model->get_cart();
			
			$data['result'] = 'success';
			$data['cart_items'] = $cart_items;
			$data['cart_total'] = $this->load->view('site/cart/cart_total', '', TRUE);
			$data['mini_cart_footer'] = $this->load->view('site/cart/cart_footer', '', TRUE);
		}
		
		else
		{
			$data['result'] = 'failure';
		}
		
		echo json_encode($data);
	}
	public function save_order()
	{
		if($this->cart_model->save_order($status = 4))
		{
			$this->session->set_userdata('success_message', 'Your order has been saved successfully. You have only two weeks to pay for this order');
			
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Sorry you order has not been saved');

		}
		 
		redirect('account');

	}
	
	public function add_to_wishlist($product_id)
	{
		//check if a customer is logged in
		if($this->login_model->check_customer_login())
		{
			if($this->cart_model->add_wishlist_item($product_id, $this->session->userdata('customer_id')))
			{
				$cart_items = $this->cart_model->get_cart();
				
				$data['result'] = 'success';
				$data['message'] = 'You have added the product to your wishlist';
			}
			
			else
			{
				$data['result'] = 'failure';
				$data['message'] = 'Unable to add the product to your wishlist. Please try again';
			}
		}
		
		//user has not logged in
		else
		{
			$data['result'] = 'Please sign in to continue';
			$data['message'] = $this->load->view('login/customer', '', TRUE);;
		}
		
		echo json_encode($data);
	}
	
	public function delete_cart_item($row_id, $page = 1)
	{
		if($this->cart_model->delete_cart_item($row_id))
		{
			$cart_items = $this->cart_model->get_cart();
			
			$data['result'] = 'success';
			$data['cart_items'] = $cart_items;
			$data['cart_total'] = $this->load->view('site/cart/cart_total', '', TRUE);
			$data['mini_cart_footer'] = $this->load->view('site/cart/cart_footer', '', TRUE);
		}
		
		else
		{
			$data['result'] = 'failure';
		}
		
		if($page == 1)
		{
			echo json_encode($data);
		}
		
		else
		{
			redirect('cart');
		}
	}
	
	public function view_cart()
	{
		//Required general page data
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		$data['content'] = $this->load->view('cart/view_cart', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
	
	public function update_cart()
	{
		if($this->cart_model->update_cart())
		{
			
		}
		
		else
		{
			
		}
		
		redirect('cart');
	}
}
?>