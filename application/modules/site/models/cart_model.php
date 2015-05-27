<?php

class Cart_model extends CI_Model 
{
	public function check_features($product_features, $product_id)
	{
		//check features
		if($product_features != NULL)
		{
			//check if feature has already been added to cart session
			$in_cart = $this->item_in_cart($product_id);
			//If item is already in cart check if it has the said feature
			if($in_cart['result'])
			{
				$row_id = $in_cart['row_id'];
				$feature_data = array();
				
				$selected_features = explode(",", $product_features);
				$total_features = count($selected_features);
				$total_additional_price = 0;
				
				for($r = 0; $r < $total_features; $r++)
				{
					$product_feature_id = $selected_features[$r];
					
					//save if doesnt exist
					if(!empty($product_feature_id))
					{
						$location = $r;
						$feature_data[$location]['product_feature_id'] = $product_feature_id;
						$feature_data[$location]['additional_price'] = $this->check_feature_price($product_feature_id);
						$total_additional_price += $feature_data[$location]['additional_price'];
					}
				}
				$feature_data_save = array(
				   'rowid' => $row_id,
				   'options'   => array('product_features' => $feature_data, 'additional_price' => $total_additional_price)
				);
				//var_dump($feature_data);
				$this->cart->update($feature_data_save);
			}
		}
	}
	
	public function check_features2($product_features, $product_id)
	{
		//check features
		if($product_features != NULL)
		{
			$selected_features = explode("-,", $product_features);
			$total_features = count($selected_features);
			$total_additional_price = 0;
			$total_saved = 0;
			
			//check if feature has already been added to cart session
			$in_cart = $this->item_in_cart($product_id);
			//If item is already in cart check if it has the said feature
			if($in_cart['result'])
			{
				$row_id = $in_cart['row_id'];
				foreach ($this->cart->contents() as $items) 
				{
					$cart_row_id = $items['rowid'];
					
					if($cart_row_id == $row_id)
					{
						//if features are in cart
						if(isset($items['options']['product_features']))
						{
							//get previously entered features
							$feature_data = $items['options']['product_features'];
							//count total features for product
							$total_prod_features = count($feature_data);
							
							if($total_prod_features > 0)
							{
								$current_feature_id = '';
								$to_save;
								$saved = array();
								
								for($s = 0; $s < $total_prod_features; $s++)
								{
									$saved_feature_id = $feature_data[$s]['product_feature_id'];
									
									//count of features to be saved
									if($total_features > 0)
									{
										//check to see if the feature save request contains the $saved feature ID: 
										//helps to avoid duplicates
										for($r = 0; $r < $total_features; $r++)
										{
											$product_feature_id = $selected_features[$r];
											$to_save = $product_feature_id;
											
											//check to see if the feature has already been saved
											if($saved_feature_id == $product_feature_id)
											{
												$current_feature_id = $saved_feature_id;
												break;
											}
										}
									}
									
									//if feature hadnt been saved save it
									if(empty($current_feature_id))
									{
										//add to the existing saved options array by appending to the end
										$location = $total_prod_features + $total_saved;
										$feature_data[$location]['product_feature_id'] = $to_save;
										$feature_data[$location]['additional_price'] = $this->check_feature_price($to_save);
										$total_additional_price += $feature_data[$location]['additional_price'];
										$total_saved++;
										
										//add to the array of saved product feature IDs
										array_push($saved, $to_save);
									}
								}
								$save_total = $total_saved;
								
								//save the new features that did not exist in the previously saved array
								for($r = 0; $r < $total_features; $r++)
								{
									$product_feature_id = $selected_features[$r];
									$to_save = '';
									for($s = 0; $s < $save_total; $s++)
									{
										$prev_save = $saved[$s];
										//check to see if the feature has already been saved
										if($prev_save == $product_feature_id)
										{
											$to_save = $prev_save;
											break;
										}
									}
									
									//save if doesnt exist
									if(empty($to_save))
									{
										$location = $total_prod_features + $total_saved;
										$feature_data[$location]['product_feature_id'] = $to_save;
										$feature_data[$location]['additional_price'] = $this->check_feature_price($product_feature_id);
										$total_additional_price += $feature_data[$location]['additional_price'];
										$total_saved++;
									}
								}
							}
							
							//create a new feature for the product
							else
							{
								$feature_data[$r]['product_feature_id'] = $product_feature_id;
								$feature_data[$r]['additional_price'] = $this->check_feature_price($product_feature_id);
								$total_additional_price += $feature_data[$r]['additional_price'];
							}
						}
							
						//create a new feature for the product
						else
						{
							$feature_data = array();
							for($r = 0; $r < $total_features; $r++)
							{
								$product_feature_id = $selected_features[$r];
								
								$feature_data[$r]['product_feature_id'] = $product_feature_id;
								$feature_data[$r]['additional_price'] = $this->check_feature_price($product_feature_id);
								$total_additional_price += $feature_data[$r]['additional_price'];	
							}
						}
					}
				}
				$feature_data_save = array(
				   'rowid' => $row_id,
				   'options'   => array('product_features' => $feature_data, 'additional_price' => $total_additional_price)
				);
				var_dump($feature_data);
				$this->cart->update($feature_data_save);
				foreach ($this->cart->contents() as $items)
				{
					//var_dump($items);
				}
			}
		}
	}
	
	public function check_feature_price($product_feature_id)
	{
		//get additional price
		$this->db->where('product_feature_id', $product_feature_id);
		$query_feat = $this->db->get('product_feature');
		if($query_feat->num_rows() > 0)
		{
			$row = $query_feat->row();
			$additional_price = $row->price;
		}
		else
		{
			$additional_price = 0;
		}
		
		return $additional_price;
	}
	
	/*
	*
	*	Add an item to the cart
	*	@param int product_id
	*
	*/
	public function add_item($product_id, $product_features = NULL)
	{
		//check if the item exists in the cart
		$in_cart = $this->item_in_cart($product_id);
		//If item is already in cart update its quantity
		if($in_cart['result'])
		{
			$row_id = $in_cart['row_id'];
			$quantity = $in_cart['quantity'] + 1;
			
			$data = array(
               'rowid' => $row_id,
               'qty'   => $quantity
            );

			$this->cart->update($data); 
		}
		
		//otherwise add a new product to cart
		else
		{
			//get product details
			$product_details = $this->products_model->get_product($product_id);
			
			if($product_details->num_rows() > 0)
			{
				$product = $product_details->row();
				
				//calculate selling price
				$selling_price = $product->product_selling_price;
				$sale_price = $product->sale_price;
				$sale_price_type = $product->sale_price_type;
				if($sale_price > 0)
				{
					$selling_price = $this->products_model->get_product_discount_price($selling_price, $sale_price, $sale_price_type);	
				}
				
				//add product to cart
				$data = array(
					   'id'      => $product_id,
					   'qty'     => 1,
					   'price'   => $selling_price,
					   'name'    => $product->product_name
					);
		
				$this->cart->insert($data); 
			}
		}
		$this->cart_model->check_features($product_features, $product_id);
		
		return TRUE;
	}
    
	/*
	*
	*	Add an item to the wishlist
	*	@param int product_id
	*
	*/
	public function add_wishlist_item($product_id, $customer_id)
	{
		$data = array(
			   'product_id'      => $product_id,
			   'date_added'     => date('Y-m-d H:i:s'),
			   'customer_id'   => $customer_id
			);

		$this->db->insert('wishlist', $data); 
		
		return TRUE;
	}
    
	/*
	*
	*	Check if cart contains a particular product
	*	@param int product_id
	*
	*/
	public function item_in_cart($product_id)
	{
		$data['result'] = FALSE;
		foreach ($this->cart->contents() as $items): 

			$cart_product_id = $items['id'];
			
			if($cart_product_id == $product_id)
			{
				$data['result'] = TRUE;
				$data['row_id'] = $items['rowid'];
				$data['quantity'] = $items['qty'];
				
				break;
			}
		
		endforeach; 
		
		return $data;
	}
    
	/*
	*
	*	Get the items in cart
	*
	*/
	public function get_cart()
	{
		$cart = '
					<table  >
						<tbody>';
		
		foreach ($this->cart->contents() as $items): 

			$cart_product_id = $items['id'];
			
			//get product details
			$product_details = $this->products_model->get_product($cart_product_id);
			
			if($product_details->num_rows() > 0)
			{
				$product = $product_details->row();
				$products_path = realpath(APPPATH . '../assets/images/products/images');
				$products_location = base_url().'assets/images/products/images/';
				
				$product_thumb = $product->product_thumb_name;
				$product_code = $product->product_code;
				$total = number_format($items['qty']*$items['price'], 0, '.', ',');
				$image = $this->products_model->image_display($products_path, $products_location, $product_thumb);
			
				$cart .= '
							<tr class="miniCartProduct">
								<td style="20%" class="miniCartProductThumb">
									<div> 
										<a href="'.site_url().'products/view-product/'.$product_code.'"> 
											<img src="'.$image.'" alt="'.$items['name'].'"> 
										</a> 
									</div>
								</td>
								<td style="40%">
									<div class="miniCartDescription">
										<h4> <a href="'.site_url().'products/view-product/'.$product_code.'"> '.$items['name'].' </a> </h4>
										<div class="price"> <span> $'.number_format($items['price'], 2, '.', ',').' </span> </div>
									</div>
								</td>
								<td  style="10%" class="miniCartQuantity"><a > X '.$items['qty'].' </a></td>
								<td  style="15%" class="miniCartSubtotal"><span> $'.$total.' </span></td>
								<td  style="5%" class="delete"><a style="color:red;" href='.$items['rowid'].' class="delete_cart_item"> <i class="glyphicon glyphicon-trash"></i> </a></td>
							</tr>
				';
			}
		
		endforeach; 
		
		$cart .= '
						</tbody>
					</table>';
		
		return $cart;
	}



	/*
	*
	*	Get the items in cart
	*
	*/
	public function get_side_cart()
	{
		$cart = '
					<table  style="100%">
						<tr>
							<th style="width:45%;"> Name</th>
							<th style="width:21%;">Qty</th>
							<th style="width:21%;">Price</th>
							<th style="width:21%;">Total</th>
						</tr>
						<tbody>';
		
		foreach ($this->cart->contents() as $items): 

			$cart_product_id = $items['id'];
			
			//get product details
			$product_details = $this->products_model->get_product($cart_product_id);
			
			if($product_details->num_rows() > 0)
			{
				$product = $product_details->row();
				$products_path = realpath(APPPATH . '../assets/images/products/images');
				$products_location = base_url().'assets/images/products/images/';
				
				$product_thumb = $product->product_thumb_name;
				$product_code = $product->product_code;
				$total = number_format($items['qty']*$items['price'], 0, '.', ',');
				$image = $this->products_model->image_display($products_path, $products_location, $product_thumb);
			
				$cart .= '
							<tr class="miniCartProduct">
								
								<td style="width:45%;">
									<a href="'.site_url().'products/view-product/'.$product_code.'"> '.$items['name'].' </a>
									
								</td>
								<td   style="width:21%;"><a > X '.$items['qty'].' </a></td>
								<td  style="width:21%;"><a >  <span> $'.number_format($items['price'], 0, '.', ',').' </span> </td>
								<td  style="width:21%;"><span> $'.$total.' </span></td>
							</tr>
				';
			}
		
		endforeach; 
		
		$cart .= '
						</tbody>
					</table>';
		
		return $cart;
	}
    
	/*
	*
	*	Delete an item from the cart
	*	@param int row_id
	*
	*/
	public function delete_cart_item($row_id)
	{
		$data = array(
		   'rowid' => $row_id,
		   'qty'   => 0
		);

		$this->cart->update($data); 
		
		return TRUE;
	}
    
	/*
	*
	*	Update the cart
	*	@param int product_id
	*
	*/
	public function update_cart()
	{
		foreach ($this->cart->contents() as $items): 

			$row_id = $items['rowid'];
			$current_quantity = $items['qty'];
			
			$update_quantity = $this->input->post('quantity'.$row_id);
			
			if($update_quantity != $current_quantity)
			{
				$data = array(
				   'rowid' => $row_id,
				   'qty'   => $update_quantity
				);
	
				$this->cart->update($data); 
			}
		
		endforeach; 
		
		return TRUE;
	}
	
	public function get_product_details($product_id)
	{
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('product');
		
		return $query;
	}
	
	/*
	*
	*	Save the cart items to the db
	*
	*/
	public function save_order($status = 4)
	{
		//we will need this to store all orders that could be created
		//we will have one order per vendor if multiple were selected
		$orders = array();
		$vendor_ids = array();
		$isl_email = 'info@instorelook.com.au';
		$isl_refferal_total = 0;
		
		foreach ($this->cart->contents() as $items): 
			
			$cart_product_id = $items['id'];
			$quantity = $items['qty'];
			$price = $items['price'];//check who is the vendor of the product
			$features = NULL;
			$additional_price = NULL;
			//shipping
			$shipping = 0;
			$shipping_cost = 0;
			//shipping
			if(isset($items['options']))
			{
				$shipping = $items['options']['shipping'];
				
				if($shipping >= 1)
				{
					$shipping_cost = $items['options']['cost'];
					$from = $items['options']['from'];
					$to = $items['options']['to'];
				}
			}
			
			if(isset($items['options']['product_features']))
			{
				$features = $items['options']['product_features'];
			}
			
			if(isset($items['options']['additional_price']))
			{
				$additional_price = $items['options']['additional_price'] * $items['qty'];
			}
			
			$query = $this->get_product_details($cart_product_id);
			
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				$vendor_id = $row->created_by;
				$product_name = $row->product_name;
				$sale_price = $row->sale_price;
				$sale_price_type = $row->sale_price_type;
				$product_sale_price = $this->products_model->get_product_discount_price($price, $sale_price, $sale_price_type);
				$price = $product_sale_price;
				
				//create array for vendor product data
				if(!isset($orders[$vendor_id]))
				{
					$orders[$vendor_id] = array();
				}
				
				//check if vendor_id exists in array
				$total_vendors = count($vendor_ids);
				
				if($total_vendors > 0)
				{
					$check = 0;
					for($r = 0; $r < $total_vendors; $r++)
					{
						if($vendor_ids[$r] == $vendor_id)
						{
							$check = 1;
							break;
						}
					}
					
					//add vendor id to array if it doesnt exist
					if($check == 0)
					{
						array_push($vendor_ids, $vendor_id);
					}
				}
				
				else
				{
					array_push($vendor_ids, $vendor_id);
				}
				
				array_push($orders[$vendor_id], array(
						'product_id'=>$cart_product_id,
						'order_item_quantity'=>$quantity,
						'order_item_price'=>$price,
						'features' => $features,
						'additional_price' => $additional_price,
						'product_name' => $product_name,
						'shipping' => $shipping,
						'shipping_cost' => $shipping_cost
					)
				);
			}
		
		endforeach;
		
		//save orders and order items per vendor
		$total_orders = count($orders);
		$vendor_data = array();
		$invoice_items = array();
		$order_details = array();
		$created_orders = '';
		
		if($total_orders > 0)
		{
			$order_number = $this->orders_model->create_order_number();
			
			for($r = 0; $r < $total_orders; $r++)
			{
				//get order data
				$vendor_id = $vendor_ids[$r];
				$vendor_query = $this->get_vendor($vendor_id);
				$vendor_email = '';
				$vendor_total = 0;
				$total_price = 0;
				$total_additional_price = 0;
				$shipping2 = 0;
				$shipping_cost2 = 0;
				
				if($vendor_query->num_rows() > 0)
				{
					$row = $vendor_query->row();
					$vendor_email = $row->vendor_email;
					$vendor_payment_email = $row->vendor_payment_email;
					
					if(!empty($vendor_payment_email))
					{
						$vendor_email = $vendor_payment_email;
					}
				}
				//create order
				$data = array(
							'customer_id'=>$this->session->userdata('customer_id'),
							'order_created'=>date('Y-m-d H:i:s'),
							'order_status_id'=>$status,
							'order_number'=>$order_number,
							'vendor_id'=>$vendor_id,
							'shipping'=>$shipping,
							'order_created_by'=>$this->session->userdata('customer_id')
						);
				
				if($shipping2 >= 1)
				{
					$data['shipping_from'] = $from;
					$data['shipping_to'] = $to;
				}
				
				if($this->db->insert('orders', $data))
				{
					//get order id
					$order_id = $this->db->insert_id();
					$created_orders .= $order_id.'-';
					
					//check number of order items
					$total_order_items = count($orders[$vendor_id]);
					
					if($total_order_items > 0)
					{
						for($s = 0; $s < $total_order_items; $s++)
						{
							$shipping2 = $orders[$vendor_id][$s]['shipping'];
							$shipping_cost2 += $orders[$vendor_id][$s]['shipping_cost'];
							$product_id = $orders[$vendor_id][$s]['product_id'];
							$order_item_quantity = $orders[$vendor_id][$s]['order_item_quantity'];
							$order_item_price = $orders[$vendor_id][$s]['order_item_price'];
							$product_name = $orders[$vendor_id][$s]['product_name'];
							$feature_data = $orders[$vendor_id][$s]['features'];
							$additional_price = $orders[$vendor_id][$s]['additional_price'];
							$total_price += ($order_item_quantity * $order_item_price);
							//calculate additional price from features
							if($additional_price != NULL)
							{
								$total_additional_price += $additional_price;
							}
				
							if($shipping2 >= 1)
							{
								$data_shipping['shipping_cost'] = $shipping_cost2;
							}
							
							$this->db->where('order_id', $order_id);
							$this->db->update('orders', $data_shipping);
							
							//save order item
							$data = array(
								'product_id' => $product_id,
								'order_id' => $order_id,
								'order_item_quantity' => $order_item_quantity,
								'order_item_price' => $order_item_price
							);
							
							if($this->db->insert('order_item', $data))
							{
								$order_item_id = $this->db->insert_id();
								
								//remove $1.00 from the product to go to ISL
								$to_business_total = ($total_price + $total_additional_price) - 1;
								$isl_refferal_total += 1;
								
								//create invoice items
								array_push($invoice_items, array(
										"name" => $product_name,
										"price" => $to_business_total,
										"identifier" => $order_item_id
									)
								);
								//if features are in cart
								if($feature_data != NULL)
								{
									//count total features for product
									$total_prod_features = count($feature_data);
									
									if($total_prod_features > 0)
									{
										for($s = 0; $s < $total_prod_features; $s++)
										{
											$product_feature_id = $feature_data[$s]['product_feature_id'];
											$additional_price = $feature_data[$s]['additional_price'];
											
											if(!empty($product_feature_id))
											{
												$feature_data_save = array(
																	'product_feature_id' => $product_feature_id,
																	'order_item_id' => $order_item_id,
																	'additional_price' => $additional_price
																);
												$this->db->insert('order_item_feature', $feature_data_save);
											}
										}
									}
								}
							}
						}
					}
				}
				
				//add shipping cost
				$total_additional_price += $shipping_cost2;
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
		}
		
		//add ISL refferal charge
		array_push($vendor_data, array(
				'email' => $isl_email, 
				'amount' => $isl_refferal_total
			)
		);
		
		//create return data
		$return['vendor_data'] = $vendor_data;
		$return['order_details'] = $order_details;
		$return['created_orders'] = $created_orders;
		
		return $return;
	}
	
	public function get_vendor($vendor_id)
	{
		$this->db->select('vendor.*, surburb.surburb_name, surburb.post_code');
		$this->db->where('vendor.surburb_id = surburb.surburb_id AND vendor_id = '.$vendor_id);
		$query = $this->db->get('vendor, surburb');
		
		return $query;
	}
	
	/*
	*
	*	Save the cart items to the db
	*
	*/
	public function save_order_express()
	{
		$total_price = 0;
		$total_additional_price = 0;
		$package_name = '';
		
		foreach ($this->cart->contents() as $items): 
			
			//calculate additional price from features
			if(isset($items['options']['additional_price']))
			{
				$total_additional_price += $items['options']['additional_price'] * $items['qty'];
			}
			
			$cart_product_id = $items['id'];
			$quantity = $items['qty'];
			$price = $items['price'];

			// get vendor id for every product
			$this->db->where('product_id = '.$cart_product_id);
			$this->db->order_by('product_id');
			$query = $this->db->get('product');

			if($query->num_rows() > 0)
			{
				$query_results = $query->result();
				
				foreach($query_results as $vend)
				{
					$vendor_id = $vend->created_by;
				}
			}

			// check whether 
			$this->db->where('vendor_id = '.$vendor_id);
			$this->db->order_by('vendor_id');
			$vendor_query = $this->db->get('orders');

			if($vendor_query->num_rows() > 0)
			{
				$vendor_query_results = $vendor_query->result();
				
				foreach($vendor_query_results as $row)
				{
					// use this order number for the consecutive order items
					$order_number = $row->order_number;
					$order_id = $row->order_id;
				}
			}
			else
			{
				// this is a new order so please enter the order
				//get order number
				$order_number = $this->orders_model->create_order_number();
				
				//create order
				$data = array(
							'customer_id'=>$this->session->userdata('customer_id'),
							'order_created'=>date('Y-m-d H:i:s'),
							//'order_instructions'=>$this->session->userdata('delivery_instructions'),
							//'payment_method'=>$this->session->userdata('payment_option'),
							'order_number'=>$order_number,
							'vendor_id'=>$vendor_id,
							'order_created_by'=>$this->session->userdata('customer_id')
						);
				if($this->db->insert('orders', $data))
				{
					$order_id = $this->db->insert_id();
					
				}
			}

			$package_name .= 'Order '.$order_number.': ';

			$data = array(
						'product_id'=>$cart_product_id,
						'order_id'=>$order_id,
						'order_item_quantity'=>$quantity,
						'order_item_price'=>$price
					);
					
			if($this->db->insert('order_item', $data))
			{
				$order_item_id = $this->db->insert_id();
				//if features are in cart
				if(isset($items['options']['product_features']))
				{
					//get previously entered features
					$feature_data = $items['options']['product_features'];
					//count total features for product
					
					$total_prod_features = count($feature_data);
					
					if($total_prod_features > 0)
					{
						for($s = 0; $s < $total_prod_features; $s++)
						{
							$product_feature_id = $feature_data[$s]['product_feature_id'];
							$additional_price = $feature_data[$s]['additional_price'];
							
							if(!empty($product_feature_id))
							{
								$feature_data_save = array(
													'product_feature_id' => $product_feature_id,
													'order_item_id' => $order_item_id,
													'additional_price' => $additional_price
												);
								$this->db->insert('order_item_feature', $feature_data_save);
							}
						}
					}
				}
				
				//get product name
				$this->db->where('product_id = '.$cart_product_id);
				$this->db->select('product_name');
				$query = $this->db->get('product');
				
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					$package_name .= $row->product_name.', ';
					$total_price += ($quantity * $price);
				}
			}

		endforeach;
		
		$total_price += $total_additional_price;
		//create return data
		$return['package_name'] = $package_name;
		$return['price'] = $total_price;
		
		return $return;
	}
	
	public function get_navigation($page_name)
	{

		// $page = explode("/",uri_string());
		// $total = count($page);
		
		$name = $page_name;
		
		$billing = '';
		$shipping = '';
		$method = '';
		$payment = '';
		$review = '';
		
		if($name == 'billing')
		{
			$billing = 'active';
		}
		
		else if($name == 'shipping')
		{
			$shipping = 'active';
		}
		
		else if($name == 'method')
		{
			$method = 'active';
		}
		
		else if($name == 'payment')
		{
			$payment = 'active';
		}
		
		else if($name == 'review')
		{
			$review = 'active';
		}
		
		else
		{
			$billing = 'active';
		}
		
		$navigation = 
		'

		 	 	<li class="'.$billing.'">
                    <a href="'.base_url().'checkout-progress/billing">
                            <span class="glyphicon glyphicon-map-marker"></span>
                            <span>Billing address</span>
                     </a>
                  	
                </li>
                <li class="'.$shipping.'">
                    <a href="'.base_url().'checkout-progress/shipping">
                            <span class="glyphicon glyphicon-envelope"></span>
                            <span>SHIPPING ADDRESS</span>
                     </a>
                </li>
                 <li class="'.$method.'">
                     <a href="'.base_url().'checkout-progress/method">
                            <span class="glyphicon glyphicon-transfer glyphicon-large"></span>
                            <span>SHIPPING METHOD</span>
                     </a>
                   
                </li>
                
                 <li class="'.$payment.'">
                 	 <a href="'.base_url().'checkout-progress/payment">
                            <span class="glyphicon glyphicon-check"></span>
                            <span>Payment Method</span>
                     </a>
                </li>
                 <li class="'.$review.'">
                     <a href="'.base_url().'checkout-progress/review">
                            <span class="glyphicon glyphicon-search"></span>
                            <span>ORDER REVIEW</span>
                     </a>
                </li>
                
		';
		
		return $navigation;
	}
	
	public function get_shipping_total()
	{
		$total = 0;
		$data['shipping'] = 0;
		$data['cost'] = 0;
		$data['from'] = '';
		$data['to'] = '';
		
		foreach ($this->cart->contents() as $items): 
		
			if(isset($items['options']))
			{
				$options = $items['options'];
				
				if(isset($options['shipping']))
				{
					$data['cost'] += $options['cost'];
					$data['shipping'] = $options['shipping'];
					$data['from'] = $options['from'];
					$data['to'] = $options['to'];
				}
			}
			
		endforeach;
		
		return $data;
	}

	public function get_surburb($surburb_id)
	{
		$this->db->where('surburb_id', $surburb_id);
		return $this->db->get('surburb');
	}
}