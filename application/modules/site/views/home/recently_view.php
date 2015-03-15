<div class="row">
            <div class="span12">
            	<div class="divider-line"></div>
            		<h5 class="center-align">Recently Viewed  Products</h5>
            	<div class="divider-line"></div>
                <div class="owl-carousel" id="owl-carousel">
                		<?php
                		$related_products_array = $this->products_model->recently_viewed_products();
                		
	                     if($related_products_array->num_rows() > 0)
							{
								$related_product = $related_products_array->result();
								
								foreach($related_product as $prods)
								{
									$sale_price = $prods->sale_price;
									$sale_price_type = $prods->sale_price_type;
									$thumb = $prods->product_image_name;
									$product_id = $prods->product_id;
									$product_name = $prods->product_name;
									$brand_name = $prods->brand_name;
									$product_price = $prods->product_selling_price;
									$description = $prods->product_description;
									$product_balance = $prods->product_balance;
									$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
									$price = number_format($product_price, 2, '.', ',');
									$image = $this->products_model->image_display($products_path, $products_location, $thumb);
									$sale = '';
									$button = '';
									$balance_status = '';
									if($product_balance == 0)
									{
										$button = '';
										$balance_status = 'Product out of stock';
									}
									else
									{
										$button = '<a class="cbp-vm-icon cbp-vm-add add_to_cart" href="'.$product_id.'" product_id="'.$product_id.'"><i class="glyphicon glyphicon-shopping-cart"> </i></a>';
										$balance_status = $product_balance.' Available in stock';
									}
									
									if($sale_price > 0)
									{
										if($sale_price_type == 2)
										{
											$sale = '<div class="promotion"> <span class="discount">'.$sale_price.'% OFF</span> </div><div class="clear-both"></div>';
										}
										
										else
										{
											$sale = '<div class="promotion"> <span class="discount">$'.number_format($sale_price, 2).' OFF</span> </div><div class="clear-both"></div>';
										}
										
										$product_sale_price = number_format($this->products_model->get_product_discount_price($product_price, $sale_price, $sale_price_type), 2);	
										
										$price = 
										'
										<div class="cbp-vm-price">
											<span class="flash-del">$'.$product_price.'</span>
											<span class="flash-sale">$'.$product_sale_price.'</span>
										</div>
										';
									}
									else
									{
										$price = 
										'
										<div class="cbp-vm-price">$'.$product_price.'</div>
										';
									}
									
									echo
									'
									<li>
										'.$sale.'
										<a class="cbp-vm-image" href="'.site_url().'products/view-product/'.$product_id.'"><img src="'.$image.'"></a>
										<h3 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_id.'">'.$brand_name.'</a></h3>
										<h6 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_id.'">'.$product_name.'</a></h6>
										'.$price.'
										<div >'.$balance_status.'</div>
										<a class="cbp-vm-icon cbp-vm-add add_to_wishlist" href="'.$product_id.'" product_id="'.$product_id.'" data-toggle="modal" data-target=".wishlist-modal"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
										'.$button.'
										<a class="beta-btn primary" href="'.site_url().'products/view-product/'.$product_id.'">Details <i class="glyphicon glyphicon-chevron-right"></i></a>
									</li>
									';
								}
							}
							
							else
							{
								echo 'There are no products :-(';
							}
						?>
                    


                </div>
                
				<div class="center-align navigation-links">
                    <a class="prev2">PREV</a>
                    <a class="next2">NEXT</a>
                </div>

            </div>
          </div>