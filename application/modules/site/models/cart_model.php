<?php

class Cart_model extends CI_Model 
{
    
	/*
	*
	*	Add an item to the cart
	*	@param int product_id
	*
	*/
	public function add_item($product_id)
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
				$sale_price_type = $prods->sale_price_type;
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
					   //'options' => array('Size' => 'L', 'Color' => 'Red')
					);
		
				$this->cart->insert($data); 
			}
		}
		
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
				
				$product_thumb = $product->product_thumb_name;
				$total = number_format($items['qty']*$items['price'], 0, '.', ',');
			
				$cart .= '
							<tr class="miniCartProduct">
								<td style="20%" class="miniCartProductThumb">
									<div> 
										<a href="#"> 
											<img src="'.base_url().'assets/images/products/images/'.$product_thumb.'" alt="'.$items['name'].'"> 
										</a> 
									</div>
								</td>
								<td style="40%">
									<div class="miniCartDescription">
										<h4> <a href="#"> '.$items['name'].' </a> </h4>
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
    
	/*
	*
	*	Save the cart items to the db
	*
	*/
	public function save_order()
	{
		//get order number
		$order_number = $this->orders_model->create_order_number();
		
		//create order
		$data = array(
					'customer_id'=>$this->session->userdata('customer_id'),
					'order_created'=>date('Y-m-d H:i:s'),
					//'order_instructions'=>$this->session->userdata('delivery_instructions'),
					//'payment_method'=>$this->session->userdata('payment_option'),
					'order_number'=>$order_number,
					'order_created_by'=>$this->session->userdata('customer_id')
				);
				
		if($this->db->insert('orders', $data))
		{
			$order_id = $this->db->insert_id();
			$package_name = 'Order '.$order_number.': ';
			$total_price = 0;
			
			//save order items
			foreach ($this->cart->contents() as $items): 
	
				$cart_product_id = $items['id'];
				$quantity = $items['qty'];
				$price = $items['price'];
				
				$data = array(
						'product_id'=>$cart_product_id,
						'order_id'=>$order_id,
						'order_item_quantity'=>$quantity,
						'order_item_price'=>$price
					);
					
				if($this->db->insert('order_item', $data))
				{
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
			
			//create return data
			$return['package_name'] = $package_name;
			$return['price'] = $total_price;
			
			return $return;
		}
		
		return TRUE;
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
}

