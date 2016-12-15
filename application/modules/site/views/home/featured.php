
    <?php
		$featured_products = $quick_view = '';
    	if($featured->num_rows() > 0)
		{
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
					$balance_status = $product_balance.' in stock';
				}
				
				if($sale_price > 0)
				{
					if($sale_price_type == 2)
					{
						$sale = '<a href="'.site_url().'products/view-product/'.$product_code.'" class="new-box"><span>SALE</span></a>';
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
				
				$featured_products .=
				'
				<div class="col-xs-12">
					<div class="single_product">
						<div class="product_image">
							<a class="product_img_link" href="'.site_url().'products/view-product/'.$product_code.'">
								<img src="'.$image.'" alt="'.$product_name.'">
							</a>
							'.$sale.'
							<a href="#" class="quick-view modal-view" data-toggle="modal" data-target="#productModal'.$product_id.'">
								<i class="fa fa-eye"></i>Quick view
							</a>
						</div>
						<div class="product_content">
							<a href="'.site_url().'products/view-product/'.$product_code.'" class="product-name">
								'.$product_name.'
							</a>
							<p class="price">'.$balance_status.'</p>
							
							<div class="price_box">
								'.$price.'
							</div>
							<div class="button_content">
								<a href="'.$product_id.'" product_id="'.$product_id.'" class="cart_button add_to_cart">add to cart</a>
								<a href="'.site_url().'products/view-product/'.$product_code.'" class="heart"><i class="fa fa-signal"></i></a>
								<a href="'.$product_id.'" product_id="'.$product_id.'" class="heart add_to_wishlist"><i class="fa fa-heart"></i></a>
							</div>
						</div>
					</div>
				</div>
				';
			
				$quick_view .= 
				'
				<!-- QUICKVIEW PRODUCT -->
				<div id="quickview-wrapper">
					<!-- Modal -->
					<div class="modal fade" id="productModal'.$product_id.'" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<div class="modal-product">
										<div class="product-images">
											<div class="main-image images">
												<img src="'.$image.'">
											</div>
										</div><!-- .product-images -->

										<div class="product-info">
											<h1>'.$product_name.'</h1>
											<div class="price-box">
												'.$price.'
											</div>
											<a href="'.site_url().'products/view-product/'.$product_code.'" class="see-all">See all features</a>
											<div class="quick-add-to-cart">
												<a href="'.$product_id.'" product_id="'.$product_id.'" class="single_add_to_cart_button add_to_cart">add to cart</a>
											</div>
											<div class="quick-desc">
												'.$description.'
											</div>
											<div class="social-sharing">
												<div class="widget widget_socialsharing_widget">
													<h3 class="widget-title-modal">Share this product</h3>
													<ul class="social-icons">
														<li><a target="_blank" title="Facebook" href="index.html#" class="facebook social-icon"><i class="fa fa-facebook"></i></a></li>
														<li><a target="_blank" title="Twitter" href="index.html#" class="twitter social-icon"><i class="fa fa-twitter"></i></a></li>
														<li><a target="_blank" title="Pinterest" href="index.html#" class="pinterest social-icon"><i class="fa fa-pinterest"></i></a></li>
														<li><a target="_blank" title="Google +" href="index.html#" class="gplus social-icon"><i class="fa fa-google-plus"></i></a></li>
														<li><a target="_blank" title="LinkedIn" href="index.html#" class="linkedin social-icon"><i class="fa fa-linkedin"></i></a></li>
													</ul>
												</div>
											</div>
										</div><!-- .product-info -->
									</div><!-- .modal-product -->
								</div><!-- .modal-body -->
							</div><!-- .modal-content -->
						</div><!-- .modal-dialog -->
					</div>
					<!-- END Modal -->
				</div>
				<!-- END QUICKVIEW PRODUCT -->

				';
			}
	
		}
		
		else
		{
			echo '<p>No products have been featured yet :-(</p>';
		}
	?>
    
</div>


        <!-- featured start -->
        <div class="featured_area">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section_title">
                            <h3><span class="angle"><i class="fa fa-clock-o"></i></span>Featured Products</h3>
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="featured_products without_tab">
                        <?php echo $featured_products;?>
					</div>
                </div>
            </div>
			<?php echo $quick_view;?>
        </div>
        <!-- featured end -->
		
		<!-- banner start -->
        <div class="banner_area two section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="single_banner">
                            <a href="#"><img src="<?php echo base_url().'assets/themes/timeplus/';?>img/banner/banner_7.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="single_banner">
                            <a href="#"><img src="<?php echo base_url().'assets/themes/timeplus/';?>img/banner/banner_8.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- banner end -->
        