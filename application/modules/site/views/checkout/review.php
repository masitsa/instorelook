<div id="checkout-content">
    <div class="box-header">                                                                                                    
        <h3>Order Review</h3>
        <h5>Review your order.</h5>                                                    
    </div>
    <?php
		$error_message = $this->session->userdata('error_message');
		if(!empty($error_message))
		{
			echo '<div class="alert alert-danger center-align"> Oh snap! '.$error_message.' </div>';
			$this->session->unset_userdata('error_message');
		}
	?>
    <?php //echo $this->load->view('cart/cart');?>
    <div class="row">
        <div class="col-md-2">
            Business
        </div>
        <div class="col-md-2">
            Shipping address
        </div>
        <div class="col-md-2">
            Items
        </div>
        <div class="col-md-2">
            Order total ($)
        </div>
        <div class="col-md-2">
            Shipping cost ($)
        </div>
        <div class="col-md-2">
             Total ($)
        </div>
    </div>
	
    <div class="panel-group order-review" id="accordionNo">
		<?php
					
		$orders = array();
		$vendor_ids = array();
		
		foreach ($this->cart->contents() as $items): 
			
			$row_id = $items['rowid'];
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
			
			$query = $this->cart_model->get_product_details($cart_product_id);
			
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
						'row_id' => $row_id,
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
			for($r = 0; $r < $total_orders; $r++)
			{
				//get order data
				$vendor_id = $vendor_ids[$r];
				$vendor_query = $this->cart_model->get_vendor($vendor_id);
				$vendor_email = '';
				$vendor_total = 0;
				$total_price = 0;
				$total_additional_price = 0;
				$shipping2 = 0;
				$shipping_cost2 = 0;
				
				if($vendor_query->num_rows() > 0)
				{
					$row = $vendor_query->row();
					$vend[0] = $row;
					$vendor_email = $row->vendor_email;
					$vendor_store_name = $row->vendor_store_name;
					$vendor_shipping = $row->vendor_shipping;
					$vendor_shipping_rate = $row->vendor_shipping_rate;
					$surburb_id = $row->surburb_id;
					$surburb_name = $vend[0]->surburb_name;
					$vendor_logo = $vend[0]->vendor_logo;
					$vendor_store_mobile = $vend[0]->vendor_store_mobile;
					$vendor_business_type = $vend[0]->vendor_business_type;
					$vendor_store_postcode = $vend[0]->vendor_store_postcode;
					$vendor_store_address = $vend[0]->vendor_store_address;
					$vendor_store_email = $vend[0]->vendor_store_email;
					$vendor_store_phone = $vend[0]->vendor_store_phone;
					$vendor_store_summary = $vend[0]->vendor_store_summary;
					$post_code = $row->post_code;
					$return_policy = $row->return_policy;
					$vendor_path = realpath(APPPATH . '../assets/images/vendors');
					$vendor_location = base_url().'assets/images/vendors/';
					$vendor_image = $this->products_model->image_display($vendor_path, $vendor_location, $vendor_logo);
					$web_name = $this->site_model->create_web_name($vendor_store_name);
					$shipping_method = '<option value="3">Pick up</option>';
					
					//vendor surburb
					$surburb_query = $this->cart_model->get_surburb($surburb_id);
					
					if($surburb_query->num_rows() > 0)
					{
						$sur_row = $surburb_query->row();
						$from_post_code = $sur_row->post_code;
					}
					
					//shipping
					if($vendor_shipping == 1)
					{
						$shipping_method .= '<option value="1">Auspost</option>';
					}
					
					else if($vendor_shipping == 2)
					{
						$shipping_method .= '<option value="2">Delivery</option>';
					}
				}
				
				//check number of order items
				$total_order_items = count($orders[$vendor_id]);
				
				//add shipping cost
				//$total_additional_price += $shipping_cost;
				
				if($total_order_items > 0)
				{
					$grand_total = 0;
					for($s = 0; $s < $total_order_items; $s++)
					{
						$products = '';
						$shipping2 = $orders[$vendor_id][$s]['shipping'];
						$shipping_cost2 += $orders[$vendor_id][$s]['shipping_cost'];
						$row_id = $orders[$vendor_id][$s]['row_id'];
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
						
						$features_display = '';
						//if features are in cart
						if($feature_data != NULL)
						{
							//count total features for product
							$total_prod_features = count($feature_data);
							
							$features_display = '<table class="table table-condensed">
											<tr>
												<th>Feature</th>
												<th>Selected</th>
												<th>Added price ($)</th>
											</tr>';
							
							if($total_prod_features > 0)
							{
								for($s = 0; $s < $total_prod_features; $s++)
								{
									$product_feature_id = $feature_data[$s]['product_feature_id'];
									$additional_price = $feature_data[$s]['additional_price'];
									
									$product_features_query = $this->products_model->get_product_features2($product_feature_id);
									
									if($product_features_query->num_rows() > 0)
									{
										
										foreach($product_features_query->result() as $res)
										{
											$feature_name = $res->feature_name;
											$price = $res->price;
											$feature_value = $res->feature_value;
											
											$features_display .= '
											<tr>
												<td>'.$feature_name.'</td>
												<td>'.$feature_value.'</td>
												<td>'.$price.'</td>
											</tr>';
										}
										$features_display .= '
											<tr>
												<th></th>
												<th></th>
												<th>'.number_format($total_additional_price, 2).'</th>
											</tr>
										</table>';
									}
								}
							}
						}
						
					
						//increment total cost of all items for order
						$total = $total_price + $total_additional_price;
						$grand_total += $total;
				
						$product_details = $this->products_model->get_product($product_id);
						
						if($product_details->num_rows() > 0)
						{
							$product = $product_details->row();
							
							$product_thumb = $product->product_thumb_name;
							$product_code = $product->product_code;
							$sale_price = $product->sale_price;
							$sale_price_type = $product->sale_price_type;
							$product_selling_price = $product->product_selling_price;
							$product_sale_price = number_format($this->products_model->get_product_discount_price($product_selling_price, $sale_price, $sale_price_type), 2);	
							
							$product_location = base_url().'assets/images/products/images/';
							$product_path = realpath(APPPATH . '../assets/images/products/images');
							$product_thumb = $this->products_model->image_display($product_path, $product_location, $product_thumb);
							
							$discount = $product_selling_price - $product_sale_price;
							//$total_features_price = $total_additional_price * $items['qty'];
							
							$products.= '              
								<tr>
									<td data-title="Product" class="col_product text-left">
									<div class="row">
										<div class="col-md-3">
											<div class="image visible-desktop">
												<a href="'.site_url().'products/view-product/'.$product_code.'">
													<img src="'.$product_thumb.'" alt="'.$product_name.'" class="img-responsive">
												</a>
											</div>
										</div>
										
										<div class="col-md-9">
											<h5>
												<a href="'.site_url().'products/view-product/'.$product_code.'">'.$product_name.'</a>
											</h5>
											'.$features_display.'
										</div>
									</div>
								</td>
								
								<td data-title="Qty" class="col_qty text-left">
									'.$order_item_quantity.'
								</td>
								
								<td data-title="Single" class="col_single text-left">
									$'.number_format($order_item_price, 2).'
								</td>
								
								<td data-title="Discount" class="col_discount text-left">
									<span class="single-price">$'.$discount.'</span>
								</td>
								
								<td data-title="Discount" class="col_discount text-left">
									<span class="single-price">$'.number_format($total_additional_price, 2).'</span>
								</td>
								
								<td data-title="Total" class="col_total text-left">
									<span class="total-price">$'.number_format($total, 2).'</span>
								</td>
							</tr>';
						}
					}
				}
				$from = '';
				$to = '';
				$shipping = 'from ';
				if(empty($from))
				{
					$shipping .= ' - ';
				}
				else
				{
					$shipping .= $from;
				}
				$shipping .= ' to ';
				if(empty($to))
				{
					$shipping .= ' - ';
				}
				else
				{
					$shipping .= $to;
				}
				
				$total_price = $shipping_cost2 + $total;
				//display vendor
				?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse"  href="#collapse-order<?php echo $vendor_id;?>" class="collapseWill"> 
							<h4 class="panel-title"> 
								<div class="row">
									<div class="col-md-2">
										<span class="pull-left"> <i class="fa fa-caret-right"></i></span>
										<?php echo $vendor_store_name;?>
									</div>
									<div class="col-md-2">
										 <?php echo $shipping;?>
									</div>
									<div class="col-md-2">
										<?php echo $total_order_items;?>
									</div>
									<div class="col-md-2">
										<?php echo number_format($total, 2);?>
									</div>
									<div class="col-md-2">
										<?php echo number_format($shipping_cost2, 2);?>
									</div>
									<div class="col-md-2">
										<?php echo number_format($total_price, 2);?>
									</div>
								</div>
							</h4>
						</a>
					</div>
					
					<div id="collapse-order<?php echo $vendor_id;?>" class="panel-collapse collapse">
						<div class="panel-body">
							<table class="styled-table">
								<thead>
									<tr>
										<th class="col_product text-left">Product</th>
										<th class="col_qty text-left">Qty</th>
										<th class="col_single text-left">Price</th>
										<th class="col_discount text-left">Discount</th>
										<th class="col_discount text-left">Features</th>
										<th class="col_discount text-left">Shipping</th>
										<th class="col_total text-left">Total</th>
										<th class="col_remove text-left">&nbsp;</th>
									</tr>
								</thead>
								<?php echo $products;?>
							</table>
							
							<h4>About business</h4>
							<div class="row">
								<div class="col-md-4">
									<a href="<?php echo site_url().'businesses/'.$web_name.'&'.$vendor_id?>"><img src="<?php echo $vendor_image;?>" class="img-responsive"></a>
								</div>
								
								<div class="col-md-8">
									<div class="details">
										<a href="<?php echo site_url().'businesses/'.$web_name.'&'.$vendor_id?>"><h3><?php echo $vendor_store_name;?></h3></a>         
										<h6><?php echo $post_code.', '.$surburb_name;?></h6>
										<!-- <div class="prices"><span class="price"><?php echo $price;?></span></div> -->
		
										<div class="row" style="margin-top:5px;">
											<div class="phone col-md-6" >
												<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
												<span rel="tooltip" title="" data-original-title="SKU is 0092"> Phone number : <?php echo $vendor_store_phone?> </span>
											</div>
											<div class="email col-md-6" >
												<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
												<span rel="tooltip" title="" data-original-title="SKU is 0092"> Email : <?php echo $vendor_store_email;?> </span>
											</div>
										</div>
									</div>
									
									<h5>Summary</h5>
									<?php echo $vendor_store_summary;?>
									
									<h5>Return policy</h5>
									<?php echo $return_policy;?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
    </div>
	
    <div class="box-footer">
        <div class="pull-left">
            <a href="<?php echo site_url().'checkout-progress/payment';?>" class="btn btn-default btn-small">
                <i class="icon-chevron-left"></i> &nbsp; Payment method
            </a>
        </div>
    
        <div class="pull-right">                            
            <a href="<?php echo site_url().'save-order';?>" class="btn btn-warning btn-small">
                Save order &nbsp; <i class="glyphicon glyphicon-save"></i>
            </a>                     
            <a href="<?php echo site_url().'checkout/confirm-order';?>" class="btn btn-primary btn-small">
                Confirm Order &nbsp; <i class="icon-chevron-right"></i>
            </a>
        </div>
    </div>					
</div>