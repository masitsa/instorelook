
<div class="container main-container"> 
  
  <!-- Main component call to action -->
  
  <div class="row featuredPostContainer globalPadding style2">
    <h3 class="section-title style2 text-center"><span>NEW ARRIVALS</span></h3>
    
    <?php
    	if($latest->num_rows() > 0)
		{
			?>
            <div id="productslider" class="owl-carousel owl-theme">
            <?php
			$latest_products = $latest->result();
			
			foreach($latest_products as $prods)
			{
				$sale_price = $prods->sale_price;
				$thumb = $prods->product_image_name;
				$product_id = $prods->product_id;
				$product_name = $prods->product_name;
				$product_price = $prods->product_selling_price;
				$description = $prods->product_description;
				$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
				$price = number_format($product_price, 0, '.', ',');
				$sale = '';
				
				if($sale_price > 0)
				{
					$sale = '<div class="promotion"> <span class="discount">'.$sale_price.'% OFF</span> </div>';
				}
				
				echo 
				'
				<div class="item">
					<div class="product">
						<div class="image"> 
							<a href="'.site_url().'products/view-product/'.$product_id.'"><img src="'.base_url().'assets/images/products/images/'.$thumb.'" alt="img" class="img-responsive"></a>
							
							'.$sale.'
						</div>
						<div class="description">
							<h4><a href="'.site_url().'products/view-product/'.$product_id.'">'.$product_name.'</a></h4>
							<p>'.$mini_desc.'</p>
							<span class="size">XL / XXL / S </span> 
						</div>
						<div class="price"> <span>KES '.$price.'</span> </div>
						<div class="action-control"> <a class="btn btn-primary add_to_cart" href="'.$product_id.'"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Add to cart </span> </a> </div>
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
    
  </div>
  <!--/.featuredPostContainer--> 
</div>
<!-- /main container -->