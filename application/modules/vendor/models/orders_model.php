<?php

class Orders_model extends CI_Model 
{
	/*
	*	Retrieve all orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_orders($table, $where, $per_page, $page)
	{
		//retrieve all orders
		$this->db->from($table);
		$this->db->select('orders.*, orders.order_status_id AS status,customer.customer_first_name AS first_name, customer.customer_surname AS other_names, order_status.order_status_name');
		$this->db->where($where);
		$this->db->order_by('orders.order_created, orders.order_number');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	/*
	*	Retrieve latest orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_latest_orders()
	{
		$where = 'orders.order_status_id != 4 AND orders.order_status_id = order_status.order_status_id AND customer.customer_id = orders.customer_id AND orders.vendor_id = '.$this->session->userdata('vendor_id');
		$table = 'orders, order_status, customer';
		
		//retrieve all orders
		$this->db->from($table);
		$this->db->select('orders.*, orders.order_status_id AS status,customer.customer_first_name AS first_name, customer.customer_surname AS other_names, order_status.order_status_name');
		$this->db->where($where);
		$this->db->order_by('orders.order_created', 'DESC');
		$query = $this->db->get('', 20);
		
		return $query;
	}
	
	/*
	*	Retrieve all orders of a user
	*
	*/
	public function get_user_orders($customer_id)
	{
		$this->db->select('payment_method.payment_method_name, orders.*, order_status.order_status_name');
		$this->db->where('orders.payment_method_id = payment_method.payment_method_id AND orders.order_status_id = order_status.order_status_id AND orders.customer_id = '.$customer_id);
		$this->db->order_by('order_created', 'DESC');
		$query = $this->db->get('orders, order_status, payment_method');
		
		return $query;
	}
	
	/*
	*	Retrieve all wishlist items of a user
	*
	*/
	public function get_user_wishlist($customer_id)
	{
		$this->db->select('brand.brand_name, product.*, wishlist.date_added, wishlist.wishlist_id');
		$this->db->where('product.brand_id = brand.brand_id AND product.product_id = wishlist.product_id AND wishlist.customer_id = '.$customer_id);
		$this->db->order_by('wishlist.date_added', 'DESC');
		$query = $this->db->get('product, wishlist, brand');
		
		return $query;
	}
	
	/*
	*	Retrieve an order
	*
	*/
	public function get_order($order_id)
	{
		$this->db->select('*');
		$this->db->where('orders.order_status = order_status.order_status_id AND users.user_id = orders.user_id AND orders.order_id = '.$order_id);
		$query = $this->db->get('orders, order_status, users');
		
		return $query;
	}
	
	/*
	*	Retrieve all order items of an order
	*
	*/
	public function get_order_items($order_id)
	{
		$this->db->select('product.product_name, product.product_thumb_name, order_item.*, vendor.vendor_store_name, vendor.vendor_id');
		$this->db->where('product.created_by = vendor.vendor_id AND product.product_id = order_item.product_id AND order_item.order_id = '.$order_id);
		$query = $this->db->get('order_item, product, vendor');
		
		return $query;
	}
	
	/*
	*	Retrieve all order item featuress of an order item
	*
	*/
	public function get_order_item_features($order_item_id)
	{
		$this->db->select('order_item_feature.*, product_feature.feature_value, product_feature.thumb, feature.feature_name');
		$this->db->where('product_feature.feature_id = feature.feature_id AND order_item_feature.product_feature_id = product_feature.product_feature_id AND order_item_feature.order_item_id = '.$order_item_id);
		$query = $this->db->get('order_item_feature, product_feature, feature');
		
		return $query;
	}
	
	/*
	*	Create order number
	*
	*/
	public function create_order_number()
	{
		//select product code
		$this->db->from('orders');
		$this->db->where("order_number LIKE 'ORD".date('y')."/%'");
		$this->db->select('MAX(order_number) AS number');
		$query = $this->db->get();
		$preffix = "ORD".date('y').'/';
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$number =  $result[0]->number;
			$real_number = str_replace($preffix, "", $number);
			$real_number++;//go to the next number
			$number = $preffix.sprintf('%06d', $real_number);
		}
		else{//start generating receipt numbers
			$number = $preffix.sprintf('%06d', 1);
		}
		
		return $number;
	}
	
	/*
	*	Create the total cost of an order
	*	@param int order_id
	*
	*/
	public function calculate_order_cost($order_id)
	{
		//select product code
		$this->db->from('order_item');
		$this->db->where('order_id = '.$order_id);
		$this->db->select('SUM(order_item_price * order_item_quantity) AS total_cost');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$total_cost =  $result[0]->total_cost;
		}
		
		else
		{
			$total_cost = 0;
		}
		
		return $total_cost;
	}
	
	/*
	*	Add a new order
	*
	*/
	public function add_order()
	{
		$order_number = $this->create_order_number();
		
		$data = array(
				'order_number'=>$order_number,
				'user_id'=>$this->input->post('user_id'),
				'payment_method'=>$this->input->post('payment_method'),
				'order_status'=>1,
				'order_instructions'=>$this->input->post('order_instructions'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		if($this->db->insert('orders', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an order
	*	@param int $order_id
	*
	*/
	public function _update_order($order_id)
	{
		$order_number = $this->create_order_number();
		
		$data = array(
				'user_id'=>$this->input->post('user_id'),
				'payment_method'=>$this->input->post('payment_method'),
				'order_status'=>1,
				'order_instructions'=>$this->input->post('order_instructions'),
				'modified_by'=>$this->session->userdata('user_id')
			);
		
		$this->db->where('order_id', $order_id);
		if($this->db->update('orders', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*
	*	Retrieve all orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_payment_methods()
	{
		//retrieve all orders
		$this->db->from('payment_method');
		$this->db->select('*');
		$this->db->order_by('payment_method_name');
		$query = $this->db->get();
		
		return $query;
	}

	/*
	*	Retrieve all orders
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_order_status()
	{
		//retrieve all orders
		$this->db->from('order_status');
		$this->db->select('*');
		$this->db->order_by('order_status_name');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Add a order product
	*
	*/
	public function add_product($order_id, $product_id, $quantity, $price)
	{
		//Check if item exists
		$this->db->select('*');
		$this->db->where('product_id = '.$product_id.' AND order_id = '.$order_id);
		$query = $this->db->get('order_item');
		
		if($query->num_rows() > 0)
		{
			$result = $query->row();
			$qty = $result->quantity;
			
			$quantity += $qty;
			
			$data = array(
					'quantity'=>$quantity
				);
				
			$this->db->where('product_id = '.$product_id.' AND order_id = '.$order_id);
			if($this->db->update('order_item', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		
		else
		{
			$data = array(
					'order_id'=>$order_id,
					'product_id'=>$product_id,
					'quantity'=>$quantity,
					'price'=>$price
				);
				
			if($this->db->insert('order_item', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
	}
	
	/*
	*	Update an order item
	*
	*/
	public function update_cart($order_item_id, $quantity)
	{
		$data = array(
					'quantity'=>$quantity
				);
				
		$this->db->where('order_item_id = '.$order_item_id);
		if($this->db->update('order_item', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Delete an existing order item
	*	@param int $product_id
	*
	*/
	public function delete_order_item($order_item_id)
	{
		if($this->db->delete('order_item', array('order_item_id' => $order_item_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function request_cancel($order_number, $customer_id)
	{
		$this->db->where(array(
				'order_number' => $order_number,
				'customer_id' => $customer_id
			)
		);
		$data['order_status_id'] = 6;
		if($this->db->update('orders', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_customer($customer_id)
	{
		$this->db->where('customer_id', $customer_id);
		$query = $this->db->get('customer');
		
		return $query;
	}
	
	/*
	*
	*	Refund order
	*
	*/
	public function refund_order($order_number, $vendor_id)
	{
		$vendor_data = array();
		$invoice_items = array();
		$order_details = array();
		$created_orders = '';
		
		$this->db->where(array('order_number' => $order_number, 'vendor_id' => $vendor_id));
		$query = $this->db->get('orders');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			
			$customer_id = $row->customer_id;
			$order_id = $row->order_id;
			$customer_query = $this->get_customer($customer_id);
			$customer_email = '';
			$customer_total = 0;
			$total_price = 0;
			$total_additional_price = 0;
			
			if($customer_query->num_rows() > 0)
			{
				$row = $customer_query->row();
				$customer_email = $row->customer_email;
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
					'email' => $customer_email, 
					'amount' => $total
				)
			);
			array_push($order_details, array(
					'receiver' => $customer_email, 
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