    <?php
		$new_products = $quick_view = '';
		
    	if($latest->num_rows() > 0)
		{
			$product = $latest->result();
			
			foreach($product as $prods)
			{
				$sale_price = $prods->sale_price;
				$sale_price_type = $prods->sale_price_type;
				$thumb = $prods->product_image_name;
				$product_id = $prods->product_id;
				$product_code = $prods->product_code;
				$product_name = $prods->product_name;
				$brand_name = $prods->brand_name;
				$product_price = number_format($prods->product_selling_price, 2);
				$description = $prods->product_description;
				$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
				$sale = '';
				$image = $this->products_model->image_display($products_path, $products_location, $thumb);
				$product_balance = $prods->product_balance;
				if($product_balance == 0)
				{
					$button = '';
					$balance_status = 'Product out of stock';
				}
				else
				{
					$button = '<a class="cbp-vm-icon cbp-vm-add add_to_cart" href="'.$product_id.'" product_id="'.$product_id.'"><i class="glyphicon glyphicon-shopping-cart"> </i></a>';
					$balance_status = $product_balance.' in stock';
				}
				
				if($sale_price > 0)
				{
					if($sale_price_type == 2)
					{
						$$sale = '<a href="'.site_url().'products/view-product/'.$product_code.'" class="new-box"><span>SALE</span></a>';
					}
					
					else
					{
						$sale = '<a href="'.site_url().'products/view-product/'.$product_code.'" class="new-box"><span>SALE</span></a>';
					}
					
					$product_sale_price = number_format($this->products_model->get_product_discount_price($product_price, $sale_price, $sale_price_type), 2);	
					
					$price = 
					'
					<span class="old-price product-price">Kes '.$product_price.' </span>
					<span class="price">Kes '.$product_sale_price.'</span>
					';
				}
				else
				{
					$price = 
					'
					<span class="price">Kes '.$product_price.'</span>
					';
				}
				
				$new_products .= 
				'
				<div class="col-sm-3 col-xs-12">
					<div class="single_new">
						<div class="item">
							<div class="item_img">
								<a href="'.site_url().'products/view-product/'.$product_code.'"><img src="'.$image.'" alt=""></a>
							</div>
							<div class="item_info">
								<a class="product_name" href="'.site_url().'products/view-product/'.$product_code.'">'.$product_name.'</a>
								<p class="price">'.$balance_status.'</p>
								
								<div class="price_box">
									'.$price.'
								</div>
							</div>
						</div>
					</div>
				</div>
				';
			}
	
		}
		
		else
		{
			echo '<p>No products have been added yet :-(</p>';
		}
	?>
</div>


        <!-- new product start -->
        <div class="new_area">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section_title">
                            <h3><span class="angle"><i class="fa fa-star-o"></i></span>New Products</h3>
                        </div>
                    </div>    
                </div>
                <div class="single_new_product">
                    <div class="row">
                        <div class="single_new_product_owl">
							<?php echo $new_products;?>
							<?php echo $quick_view;?>
						</div>
                    </div>
                </div>     
            </div>
        </div>               
        <!-- new product end -->
        
