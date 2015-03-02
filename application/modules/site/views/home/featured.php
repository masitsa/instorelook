<div class="beta-products-list product-items">
    <h4>Featured Products</h4>
    
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
					$thumb = $prods->product_image_name;
					$product_id = $prods->product_id;
					$product_name = $prods->product_name;
					$brand_name = $prods->brand_name;
					$product_price = $prods->product_selling_price;
					$description = $prods->product_description;
					$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
					$price = number_format($product_price, 2, '.', ',');
					$image = $this->products_model->image_display($products_path, $products_location, $thumb);
					$sale = '';
					
					if($sale_price > 0)
					{
						$sale = '<div class="promotion"> <span class="discount">'.$sale_price.'% OFF</span> </div><div class="clear-both"></div>';
					}
					
					echo
					'
					<li>
						<a class="cbp-vm-image" href="'.site_url().'products/view-product/'.$product_id.'"><img src="'.$image.'"></a>
						<h3 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_id.'">'.$brand_name.'</a></h3>
						<h6 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_id.'">'.$product_name.'</a></h6>
						<div class="cbp-vm-price">$'.$price.'</div>
						<a class="cbp-vm-icon cbp-vm-add add_to_wishlist" href="'.$product_id.'" product_id="'.$product_id.'" data-toggle="modal" data-target=".wishlist-modal"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
						<a class="cbp-vm-icon cbp-vm-add add_to_cart" href="'.$product_id.'" product_id="'.$product_id.'"><i class="glyphicon glyphicon-shopping-cart"> </i></a>
						<a class="beta-btn primary" href="'.site_url().'products/view-product/'.$product_id.'">Details <i class="glyphicon glyphicon-chevron-right"></i></a>
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
<div class="beta-promobox">
    <a class="beta-btn pull-right mt5" href="#">Get Coupon</a>
    <h2 >
        <span class="white">FREE</span>
        Standard Delivery on orders OVER $150!
    </h2>
    <div class="clear"></div>
</div>
<!-- End Coupon -->