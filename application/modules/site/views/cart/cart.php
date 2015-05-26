   
    <div class="box-content">
        <div class="cart-items">
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
    
                <tbody> 
                 <?php
                  foreach ($this->cart->contents() as $items): 
                    	
						$shipping = 0;
						$shipping_cost = 0;
                      $cart_product_id = $items['id'];
                      $features_display = '';
                      $total_additional_price = 0;
                        //shipping
                        if(isset($items['options']))
                        {
							if(isset($items['options']['shipping']))
							{
							  $shipping = $items['options']['shipping'];
							  
							  if($shipping >= 1)
							  {
								$shipping_cost = $items['options']['cost'];
							  }
							}
						}
                        //features
                        if(isset($items['options']['product_features']))
                        {
                            //get previously entered features
                            $feature_data = $items['options']['product_features'];
                            $total_additional_price = $items['options']['additional_price'];
                            //count total features for product
                            $total_prod_features = count($feature_data);
                            $data['product_features'] = $this->products_model->get_product_features($cart_product_id);
                            $data['feature_names'] = $this->products_model->get_feature_names($cart_product_id);
                            
                            if($total_prod_features > 0)
                            {
                                $features_display = '<table class="table table-condensed">
                                    <tr>
                                        <th>Feature</th>
                                        <th>Selected</th>
                                        <th>Added price ($)</th>
                                    </tr>';
                                for($s = 0; $s < $total_prod_features; $s++)
                                {
                                    $data['cart_product_feature_id'] = $feature_data[$s]['product_feature_id'];
                                    $data['added_price'] = $feature_data[$s]['additional_price'];
                                    
                                    $features_display .= $this->load->view('cart/display_features', $data, TRUE);
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
    
                      //get product details
                      $product_details = $this->products_model->get_product($cart_product_id);
    
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
                          $total_features_price = $total_additional_price * $items['qty'];
    
                          $total = number_format((($items['qty']*$items['price']) + $total_features_price + $shipping_cost) - $discount, 2);  
    
                          echo'              
                            <tr>
                                <td data-title="Product" class="col_product text-left">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="image visible-desktop">
                                                <a href="'.site_url().'products/view-product/'.$product_code.'">
                                                    <img src="'.$product_thumb.'" alt="'.$items['name'].'" class="img-responsive">
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-9">
                                            <h5>
                                                <a href="'.site_url().'products/view-product/'.$product_code.'">'.$items['name'].'</a>
                                            </h5>
                                            '.$features_display.'
                                        </div>
                                    </div>
                                </td>
    
                                <td data-title="Qty" class="col_qty text-left">
                                    <input type="text" name="quantity'.$items['rowid'].'" value="'.$items['qty'].'" class="form-control quanitySniper">
                                </td>
    
                                <td data-title="Single" class="col_single text-left">
                                    <span class="single-price">$'.number_format($items['price'], 2).'</span>
                                </td>
    
                                <td data-title="Discount" class="col_discount text-left">
                                    <span class="single-price">$'.number_format($discount, 2).'</span>
                                </td>
    
                                <td data-title="Discount" class="col_discount text-left">
                                    <span class="single-price">$'.number_format($total_additional_price, 2).'</span>
                                </td>
    
                                <td data-title="Discount" class="col_discount text-left">
                                    <span class="single-price">$'.number_format($shipping_cost, 2).'</span>
                                </td>
    
                                <td data-title="Total" class="col_total text-left">
                                    <span class="total-price">$'.number_format($total, 2).'</span>
                                </td>
    
                                <td data-title="Remove" class="col_remove text-left">
                                    <a href="'.site_url().'cart/delete-item/'.$items['rowid'].'/2">
                                   
                                       <span class=" glyphicon glyphicon-trash" aria-hidden="true"></span>
                                      
                                    </a>
                                </td>
                            </tr>';
                         
                          }
                     endforeach;
                    ?>
                   
                </tbody>
            </table>
        </div>
    </div>