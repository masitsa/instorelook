<?php

class Checkout_model extends CI_Model 
{
	public function get_customer_details($customer_id)
	{
		//select the user by email from the database
		$this->db->select('customer.*, surburb.post_code');
		$this->db->where('customer.surburb_id = surburb.surburb_id AND customer.customer_id = '.$customer_id);
		$query = $this->db->get('customer, surburb');
		
		return $query;
	}
	public function get_shipping_details($customer_id)
	{
		//select the user by email from the database
		$this->db->select('customer_shipping.*, surburb.post_code');
		$this->db->where('customer_shipping.delete = 0 AND customer_shipping.surburb_id = surburb.surburb_id AND customer_shipping.customer_id = '.$customer_id);
		$query = $this->db->get('customer_shipping, surburb');
		
		return $query;
	}
	
	/*
	*	Update a front end user to the database
	*
	*/
	public function update_customer()
	{
		//check if user has logged in
		$login_status = $this->session->userdata('customer_login_status');
		
		//If customer has logged in
		if((!empty($login_status)) && ($login_status == TRUE))
		{
		}
		
		$data = array(
				'customer_first_name'=>ucwords(strtolower($this->input->post('first_name'))),
				'customer_surname'=>ucwords(strtolower($this->input->post('last_name'))),
				'customer_email'=>$this->input->post('email'),
				'customer_phone'=>$this->input->post('phone'),
				'customer_company'=>$this->input->post('company'),
				'customer_address'=>$this->input->post('address'),
				'surburb_id'=>$this->input->post('surburb_id')
			);
		
		$this->db->where('customer_id = '.$this->session->userdata('customer_id'));
		if($this->db->update('customer', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update a front end user's shipping details
	*
	*/
	public function update_shipping_details($customer_shipping_id)
	{
		//check if user has logged in
		$login_status = $this->session->userdata('customer_login_status');
		
		//If customer has logged in
		if((!empty($login_status)) && ($login_status == TRUE))
		{
		}
		
		$data = array(
				'first_name'=>ucwords(strtolower($this->input->post('first_name'))),
				'last_name'=>ucwords(strtolower($this->input->post('last_name'))),
				'email'=>$this->input->post('email'),
				'phone'=>$this->input->post('phone'),
				'company'=>$this->input->post('company'),
				'surburb_id'=>$this->input->post('surburb_id'),
				'address'=>$this->input->post('address')
			);
		
		//check if customer exists in customer shipping table
		$this->db->where('customer_shipping_id = '.$customer_shipping_id);
		if($this->db->update('customer_shipping', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update a front end user's shipping details
	*
	*/
	public function add_shipping_details()
	{
		//check if user has logged in
		$login_status = $this->session->userdata('customer_login_status');
		
		//If customer has logged in
		if((!empty($login_status)) && ($login_status == TRUE))
		{
		}
		
		$data = array(
				'first_name'=>ucwords(strtolower($this->input->post('first_name'))),
				'last_name'=>ucwords(strtolower($this->input->post('last_name'))),
				'email'=>$this->input->post('email'),
				'phone'=>$this->input->post('phone'),
				'company'=>$this->input->post('company'),
				'surburb_id'=>$this->input->post('surburb_id'),
				'address'=>$this->input->post('address'),
				'customer_id'=>$this->session->userdata('customer_id')
			);
		
		if($this->db->insert('customer_shipping', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}

	}
	
	/*
	*
	*	Pay for order from account
	*
	*/
	public function make_payment($order_number, $customer_id)
	{
		$vendor_data = array();
		$invoice_items = array();
		$order_details = array();
		$created_orders = '';
		
		$this->db->where(array('order_number' => $order_number, 'customer_id' => $customer_id));
		$query = $this->db->get('orders');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			
			$vendor_id = $row->vendor_id;
			$order_id = $row->order_id;
			$vendor_query = $this->cart_model->get_vendor($vendor_id);
			$vendor_email = '';
			$vendor_total = 0;
			$total_price = 0;
			$total_additional_price = 0;
			
			if($vendor_query->num_rows() > 0)
			{
				$row = $vendor_query->row();
				$vendor_email = $row->vendor_email;
			}
			$created_orders .= $order_id.'-';
			
			//check number of order items
			$order_items = $this->orders_model->get_order_items($order_id);
			$total_order_items = $order_items->num_rows();
			
			if($total_order_items > 0)
			{
				foreach($order_items->result() as $res)
				{
					$order_item_id = $res->order_item_id;
					$product_id = $res->product_id;
					$order_item_quantity = $res->order_item_quantity;
					$order_item_price = $res->order_item_price;
					$product_name = $res->product_name;
					$total_price += ($order_item_quantity * $order_item_price);
					
					//features
					$this->db->select('order_item_feature.*, product_feature.feature_value, product_feature.thumb, feature.feature_name');
					$this->db->where('product_feature.feature_id = feature.feature_id AND order_item_feature.product_feature_id = product_feature.product_feature_id AND order_item_feature.order_item_id = '.$order_item_id);
					$order_item_features = $this->db->get('order_item_feature, product_feature, feature');
					
					if($order_item_features->num_rows() > 0)
					{
						foreach($order_item_features->result() as $feat)
						{
							$product_feature_id = $feat->product_feature_id;
							$added_price = $feat->additional_price;
							$feature_name = $feat->feature_name;
							$feature_value = $feat->feature_value;
							$feature_image = $feat->thumb;
							$total_additional_price += $added_price;
						}
					}
					
					//create invoice items
					array_push($invoice_items, array(
							"name" => $product_name,
							"price" => ($total_price + $total_additional_price),
							"identifier" => $order_item_id
						)
					);
				}
			}
			$total = $total_price + $total_additional_price;
			//add vendor data to the vendor_data array
			array_push($vendor_data, array(
					'email' => $vendor_email, 
					'amount' => $total
				)
			);
			array_push($order_details, array(
					'receiver' => $vendor_email, 
					'invoiceData' => array(
						'item' => $invoice_items
					)
				)
			);
		}
		
		//create return data
		$return['vendor_data'] = $vendor_data;
		$return['order_details'] = $order_details;
		$return['created_orders'] = $created_orders;
		
		return $return;
	}
}