<div class="beta-products-list product-items">
    
    <div class="row beta-products-details">
        <h4>Featured Products</h4>
    </div>
    
    <?php
    	if($featured->num_rows() > 0)
		{
			?>
            <div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid">
            <ul>
            	<?php
				$product = $featured->result();
				
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
						<a class="cbp-vm-image" href="'.site_url().'products/view-product/'.$product_code.'"><img src="'.$image.'"></a>
						<h3 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_code.'">'.$brand_name.'</a></h3>
						<h6 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_code.'">'.$product_name.'</a></h6>
						'.$price.'
						<div >'.$balance_status.'</div>
						<a class="cbp-vm-icon cbp-vm-add add_to_wishlist" href="'.$product_id.'" product_id="'.$product_id.'" data-toggle="modal" data-target=".wishlist-modal"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
						<a class="cbp-vm-icon cbp-vm-add add_to_cart" href="'.$product_id.'" product_id="'.$product_id.'"><i class="glyphicon glyphicon-shopping-cart"> </i></a>
						<a class="beta-btn primary" href="'.site_url().'products/view-product/'.$product_code.'">Details <i class="glyphicon glyphicon-chevron-right"></i></a>
					</li>
					';
				}
		?>
            </ul>
        </div>
            <?php
		}
		
		else
		{
			echo '<p>No products have been featured yet :-(</p>';
		}
	?>
    
</div>

<!-- Coupon -->
<!-- <div class="beta-promobox">
    <a class="beta-btn pull-right mt5" href="#">Get Coupon</a>
    <h2 >
        <span class="white">FREE</span>
        Standard Delivery on orders OVER $150!
    </h2>
    <div class="clear"></div>
</div> -->
<!-- End Coupon -->