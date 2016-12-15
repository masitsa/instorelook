<?php
	$products_grid = $products_list = $quick_view = '';
	if($products->num_rows() > 0)
	{
		$product = $products->result();
		
		foreach($product as $prods)
		{
			$sale_price = $prods->sale_price;
			$sale_price_type = $prods->sale_price_type;
			$thumb = $prods->product_image_name;
			$product_id = $prods->product_id;
			$product_code = $prods->product_code;
			$product_name = $prods->product_name;
			$brand_name = $prods->brand_name;
			$tiny_url = '';
			$product_price = number_format($prods->product_selling_price, 2);
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
			
			$products_grid .= 
			'
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
				<div class="single_product">
					<div class="product_image">
						<a class="product_img_link" href="'.site_url().'products/view-product/'.$product_code.'">
							<img src="'.$image.'">
						</a>
						'.$sale.'
						<a href="#" class="quick-view modal-view" data-toggle="modal" data-target="#productModal'.$product_id.'">
							<i class="fa fa-eye"></i>Quick view
						</a>
					</div>
					<div class="product_content">
						<a href="'.site_url().'products/view-product/'.$product_code.'" class="product-name">
							printed dress
						</a>
						<div class="star_content">
							<i class="fa fa-star-o color"></i>
							<i class="fa fa-star-o color"></i>
							<i class="fa fa-star-o"></i>
							<i class="fa fa-star-o"></i>
							<i class="fa fa-star-o"></i>
						</div>
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
			
			$products_list .= 
			'
			<li class="ajax_block_product col-xs-12">
				<div class="product-container">
					<div class="row">
						<div class="col-xs-12 col-sm-5 col-md-4">
							<div class="left-block">
								<a href="'.site_url().'products/view-product/'.$product_code.'" class="product_img_link"><img src="'.$image.'"></a>
								'.$sale.'
								<a href="'.site_url().'products/view-product/'.$product_code.'" class="quick-view modal-view" data-toggle="modal" data-target="#productModal'.$product_id.'">
									<i class="fa fa-eye"></i>Quick view
								</a>
							</div>
						</div>
						<div class="col-xs-12 col-sm-7 col-md-8">
							<div class="right-block">
								<h5><a href="'.site_url().'products/view-product/'.$product_code.'" class="product-name">'.$product_name.'</a></h5>
								<div class="comment_box">
									<div class="star_content clearfix">
										<i class="fa fa-star-o color"></i>
										<i class="fa fa-star-o color"></i>
										<i class="fa fa-star-o"></i>
										<i class="fa fa-star-o"></i>
										<i class="fa fa-star-o"></i>
									</div>
								</div>
								<div class="price-box">
									'.$price.'
								</div>
								<p class="product-desc">'.$mini_desc.'</p>
								<div class="button_content">
									<a href="'.$product_id.'" product_id="'.$product_id.'" class="cart_button add_to_cart">add to cart</a>
									<a href="'.site_url().'products/view-product/'.$product_code.'" class="heart"><i class="fa fa-signal"></i></a>
									<a href="'.$product_id.'" product_id="'.$product_id.'" class="heart add_to_wishlist"><i class="fa fa-heart"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
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
													<li><a href="#" onclick="facebook_share(\''.$product_name.'\', \''.$tiny_url.'\',  \''.$image.'\')" class="facebook social-icon"><i class="fa fa-facebook"></i></a></li>
													<li><a target="_blank" title="Twitter"  href="https://twitter.com/intent/tweet?screen_name=ShopYard&text=Checkout%20'.$product_name.'%20and%20lots%20more%20on%20www.shopyard.co.ke%20'.$tiny_url.'"class="twitter social-icon"><i class="fa fa-twitter"></i></a></li>
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
?>

<!-- shop grid start -->
        <div class="grid_area">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="breadcrumb">
							<?php echo $this->load->view('products/breadcrumbs');?>
                        </div>
                    </div>
                </div>
                <div class="row">
					
					<?php echo $this->load->view('home/home_left_navigation');?>
                    
					<div class="col-md-9 col-sm-8 col-xs-12">
						<?php echo $this->load->view('products/top_navigation');?>
						
						<div class="tab_container block_content">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="grid">
                                    <div class="shop_products_area">
                                        <div class="row">
											<?php echo $products_grid;?>
										</div>
									</div>
                                </div>
                                
								
								<div role="tabpanel" class="tab-pane" id="list">
                                    <ul class="product_list list row">
										<?php echo $products_list;?>
                                    </ul> 
                                </div>
                            </div>
                        </div>
						<?php echo $quick_view;?>
						<?php if(isset($links)){echo $links;}?>						
                    </div>
                </div>
            </div>
        </div>                           
        <!-- shop grid end -->
        

<script type="text/javascript">
//Sort Products
$(document).on("change","select#sort_products",function()
{
	var order_by = $('#sort_products :selected').val();
	
	window.location.href = '<?php echo site_url();?>products/sort-by/'+order_by;
});
</script>
