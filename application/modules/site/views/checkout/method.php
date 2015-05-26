<?php
/*$shipping = $this->cart_model->get_shipping_total();
$cost = number_format($shipping['cost'], 2);
$ship = $shipping['shipping'];
$from = $shipping['from'];
$to = $shipping['to'];*/
$from = $to = '';
$grand_total = 0;

//customer postcode

$customer_query = $this->checkout_model->get_shipping_details($this->session->userdata('customer_id'));
$shipping_to = '';
if($customer_query->num_rows() > 0)
{
	foreach($customer_query->result() as $customer)
	{
		$customer_shipping_id = $customer->customer_shipping_id;
		$first_name2 = $customer->first_name;
		$last_name2 = $customer->last_name;
		$phone2 = $customer->phone;
		$email2 = $customer->email;
		$company2 = $customer->company;
		$surburb_id2 = $customer->surburb_id;
		$address2 = $customer->address;
		$post_code2 = $customer->post_code;
		
		$shipping_to .= '
			<option value="'.$post_code2.'">'.$first_name2.' '.$last_name2.', '.$post_code2.'</option>
		';
	}
}

?>
<div id="checkout-content">
    <div class="box-header">                                                                                                    
        <h3>Shipping method</h3>                                                
    </div>
    <div class="box-content">
        <div class="shipping-methods">
        	
            <div class="row">
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
                            $vendor_email = $row->vendor_email;
                            $vendor_store_name = $row->vendor_store_name;
                            $vendor_shipping = $row->vendor_shipping;
                            $vendor_shipping_rate = $row->vendor_shipping_rate;
                            $surburb_id = $row->surburb_id;
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
                            for($s = 0; $s < $total_order_items; $s++)
                            {
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
                                        }
                                    }
                                }
                            }
                        }
                            
                        //increment total cost of all items for order
                        $total = $total_price + $total_additional_price;
                        $grand_total += $total;
                        //display order
                        ?>
                        <div class="col-md-6">
                            <div class="highlight">
                                <div class="hgroup title">
                                    <h3>Order to <?php echo $vendor_store_name;?></h3>
                                    <h5>Total order cost $<?php echo number_format($total, 2);?></h5>
                                    
                                    <?php if($shipping_cost2 > 0){?>
                                    <h5>Ship from <?php echo $from;?> to <?php echo $to;?></h5>
                                    <?php }?>
                                    
                                    <div class="row">
                                        <div class="col-md-5">
                                            Shipping option
                                        </div>
                                        <div class="col-md-7">
                                            <select class="form-control" id="shipping_method<?php echo $vendor_id;?>">
                                                <?php echo $shipping_method;?>
                                            </select>
                                            <input type="hidden" class="form-control" id="row_id<?php echo $vendor_id;?>" readonly="readonly" value="<?php echo $row_id;?>" />
                                            <input type="hidden" class="form-control" id="fixed_rate<?php echo $vendor_id;?>" readonly="readonly" value="<?php echo $vendor_shipping_rate;?>" />
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-5">
                                            Shipping from
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" id="from_post_code<?php echo $vendor_id;?>" readonly="readonly" value="<?php echo $from_post_code;?>" />
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-5">
                                            Shipping to
                                        </div>
                                        <div class="col-md-7">
                                            <select class="form-control" id="to_post_code<?php echo $vendor_id;?>">
                                                <?php echo $shipping_to;?>
                                            </select>
                                        </div>
                                    </div>
                                    <a href="<?php echo $vendor_id;?>" class="btn btn-primary add_shipping_cost">Add shipping</a>
                                </div>
            
                                <div class="box-content highlight" id="shipping_addition<?php echo $vendor_id;?>">
                                    <div class="price">
                                        <strong id="total_cost<?php echo $vendor_id;?>">$<?php echo number_format(($shipping_cost2), 2);?></strong>
                                    </div>
                                </div>			
                            </div>
                        </div>
                       
                        <?php
                    }
                }
                ?>
            </div>
            
            <h4 style="margin-bottom:10px;">Total order cost $<?php echo number_format($grand_total, 2);?></h4>
        </div>
    </div>
    
    
    
    <div class="box-footer">
        <div class="pull-left">
            <a href="<?php echo site_url().'checkout-progress/shipping';?>" class="btn btn-default btn-small">
                <i class="icon-chevron-left"></i> &nbsp; Shipping address
            </a>
        </div>
    
        <div class="pull-right">                                                    
            <a href="<?php echo site_url().'checkout-progress/payment';?>" class="btn btn-primary btn-small">
                Payment method &nbsp; <i class="icon-chevron-right"></i>
            </a>
        </div>
    </div>					
</div>