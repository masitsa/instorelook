<?php
$cat = $static_banners->result();
$static_banner1 = '';//$static_banner_location.$cat[0]->static_banner_image_name;
$static_banner2 = '';//$static_banner_location.$cat[1]->static_banner_image_name;

?>

<!-- Promotion banners -->
<!-- <div class="row promotion-banners">
	<div class="col-md-6" style="padding-right:10px;">
    	<img class="img-responsive" src="<?php echo base_url().'assets/images/banner2.jpg';?>"/>
        <h2>
        	Hot Blazers<br/>
        	<a href="#" class="promotion-btn">Shop Now</a>
        </h2>
    </div>
	<div class="col-md-6" style="padding-left:10px;">
    	<img class="img-responsive" src="<?php echo base_url().'assets/images/banner3.jpg';?>"/>
        <h2>
        	Funky Shoes<br/>
        	<a href="#" class="promotion-btn">Shop Now</a>
        </h2>
    </div>
</div> -->
<!-- End Promotion banners -->

<div class="beta-products-list product-items">
    <h4>New Products</h4>
    <div class="row beta-products-details">
        <div class="col-md-6">
            <div class="pull-left">
                <!--438 products found |-->
                <a href="<?php echo site_url().'products';?>">View all</a>
            </div>
        </div>
        <div class="col-md-6">
            <!--<div class="pull-right">
                <span class="sort-by">Sort by </span>
                <div class="beta-select beta-select-primary">
                    <span class="beta-select-title"></span>
                    <span class="beta-select-value">Select</span>
                    <select class="beta-select-primary" name="sortproducts">
                        <option value="desc">Latest</option>
                        <option value="popular">Popular</option>
                        <option value="rating">Rating</option>
                        <option value="best">Best</option>
                    </select><i class="fa fa-chevron-down"></i>
                </div>
            </div>-->
        </div>
        <div class="clear"></div>
	</div>
    
    <?php
    	if($latest->num_rows() > 0)
		{
			?>
            <div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid">
            
            <ul>
            	<?php
				$product = $latest->result();
				
				foreach($product as $prods)
				{
					$sale_price = $prods->sale_price;
					$sale_price_type = $prods->sale_price_type;
					$thumb = $prods->product_image_name;
					$product_id = $prods->product_id;
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
						<a class="cbp-vm-image" href="'.site_url().'products/view-product/'.$product_id.'"><img src="'.$image.'"></a>
						<h3 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_id.'">'.$brand_name.'</a></h3>
						<h6 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_id.'">'.$product_name.'</a></h6>
						'.$price.'
						<div >'.$balance_status.'</div>
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
			echo '<p>No products have been added yet :-(</p>';
		}
	?>
</div>
<!-- Promotion banners -->
<!-- <div class="row promotion-banners">
	<div class="col-md-6" style="padding-right:10px;">
    	<img class="img-responsive" src="<?php echo base_url().'assets/images/banner2.jpg';?>"/>
        <h2>
        	Hot Blazers<br/>
        	<a href="#" class="promotion-btn">Shop Now</a>
        </h2>
    </div>
	<div class="col-md-6" style="padding-left:10px;">
    	<img class="img-responsive" src="<?php echo base_url().'assets/images/banner3.jpg';?>"/>
        <h2>
        	Funky Shoes<br/>
        	<a href="#" class="promotion-btn">Shop Now</a>
        </h2>
    </div>
</div> -->
<!-- End Promotion banners -->
