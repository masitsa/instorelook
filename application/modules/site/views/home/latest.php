<?php
$cat = $static_banners->result();
$static_banner1 = '';//$static_banner_location.$cat[0]->static_banner_image_name;
$static_banner2 = '';//$static_banner_location.$cat[1]->static_banner_image_name;

?>

<!-- Promotion banners -->
<div class="row promotion-banners">
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
</div>
<!-- End Promotion banners -->

<div class="beta-products-list product-items">
    <h4>New Products</h4>
    <div class="row beta-products-details">
        <div class="col-md-6">
            <div class="pull-left">
                438 products found |
                <a href="<?php echo site_url().'products';?>">View all</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
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
            </div>
        </div>
        <div class="clear"></div>
	</div>
    
    <?php
    	if($latest->num_rows() > 0)
		{
			?>
            <div class="row">
            <?php
			$latest_products = $latest->result();
			$count = 0;
			
			foreach($latest_products as $prods)
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
				$sale = '';
				$count++;
				
				//begin next row
				if($count == 5)
				{
					echo '</div><div class="row">';
				}
				
				//different css class for the first item
				if($count == 1)
				{
					echo '<div class="col-sm-3 first-product" style="visibility: visible;">';
				}
				
				else
				{
					echo '<div class="col-sm-3 other-product" style="visibility: visible;">';
				}
				
				if($sale_price > 0)
				{
					$offer = $price - ($price * ($sale_price/100));
					$sale = '<div class="ribbon-wrapper"><div class="ribbon sale">'.$sale_price.'%</div></div>';
					$price = '<span class="flash-del">$'.$price.'</span>
							<span>$'.$offer.'</span>';
				}
				
				else
				{
					$price = '<span>$'.$price.'</span>';
				}
				
				echo 
				'
				<div class="single-item">
					'.$sale.'
					<div class="single-item-header">
						<a href="#"><img alt="" src="'.base_url().'assets/images/products/images/'.$thumb.'"></a>
					</div>
					<div class="single-item-body">
						<p class="single-item-title">'.$brand_name.'</p>
						<p class="single-item-title">'.$product_name.'</p>
						<p class="single-item-price">
							'.$price.'
						</p>
					</div>
					<div class="single-item-caption">
						<a href="'.$product_id.'" product_id="'.$product_id.'" class="add_to_cart add-to-cart pull-left"><i class="fa fa-shopping-cart"></i></a>
						<a href="'.site_url().'products/view-product/'.$product_id.'" class="beta-btn primary">Details <i class="fa fa-chevron-right"></i></a>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
				';
			}
			?>
            </div>
    		<!--/.productslider--> 
            <?php
		}
		
		else
		{
			echo '<p>No products have been added yet :-(</p>';
		}
	?>

<!-- Promotion banners -->
<div class="row promotion-banners">
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
</div>
<!-- End Promotion banners -->

<!-- Coupon -->
<div class="beta-promobox">
	<img class="img-responsive" src="<?php echo $static_banner1;?>"/>
	
    <!--<a class="beta-btn pull-right mt5" href="#">Get Coupon</a>
    <h2 >
        <span class="white">FREE</span>
        Standard Delivery on orders OVER $150!
    </h2>
    <div class="clear"></div>-->
</div>
<!-- End Coupon -->