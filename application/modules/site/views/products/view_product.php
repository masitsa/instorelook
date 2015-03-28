<?php
	$product = $product_details->result();
	//the product details
	$sale_price = $product[0]->sale_price;
	$sale_price_type = $product[0]->sale_price_type;
	$featured = $product[0]->featured;
	$category_id = $product[0]->category_id;
	$brand_id = $product[0]->brand_id;
	$product_id = $product[0]->product_id;
	$product_name = $product[0]->product_name;
	$product_code = $product[0]->product_code;
	$product_buying_price = $product[0]->product_buying_price;
	$product_status = $product[0]->product_status;
	$product_selling_price = $product[0]->product_selling_price;
	$product_price = number_format($product[0]->product_selling_price, 2);
	$image = $product[0]->product_image_name;
	$thumb = $product[0]->product_thumb_name;
	$product_description = $product[0]->product_description;
	$product_balance = $product[0]->product_balance;
	$brand_name = $product[0]->brand_name;
	$category_name = $product[0]->category_name;
	$created_by = $product[0]->created_by;
	$mini_desc = implode(' ', array_slice(explode(' ', $product_description), 0, 10));
	$button = '';
	$balance_status = '';
	if($product_balance == 0)
	{
		$button = '';
		$balance_status = 'Product out of stock';
	}
	else
	{
		$button = ' <a href="#register" product_id="'.$product_id.'" class="btn btn-primary add_to_cart" data-toggle="modal" data-target=".bs-example-modal-md">
		                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &nbsp; Add to cart 
		                          </a>';
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
					
	//business details
	$where = 'vendor.vendor_id > 0 AND vendor.surburb_id = surburb.surburb_id AND vendor.vendor_id = '.$created_by;
	$table = 'vendor,surburb';
	$business_query = $this->vendor_model->get_vendor_details($created_by, $table, $where);
	
	if($business_query->num_rows() > 0)
	{
		$row = $business_query->row();

		$vendor_id = $row->vendor_id;
		$vendor_logo = $row->vendor_logo;
		$vendor_first_name = $row->vendor_first_name;
		$vendor_last_name = $row->vendor_last_name;
		$surburb_id = $row->surburb_id;
		$surburb_name = $row->surburb_name;
		$post_code = $row->post_code;
	
		$vendor_email = $row->vendor_email;
		$vendor_phone = $row->vendor_phone;
		$vendor_store_name = $row->vendor_store_name;
		$vendor_store_mobile = $row->vendor_store_mobile;
		$country_id = $row->country_id;
		$country_name = '';
		
		$vendor_business_type = $row->vendor_business_type;
		$vendor_store_postcode = $row->vendor_store_postcode;
		$vendor_store_address = $row->vendor_store_address;
	
		$vendor_store_email = $row->vendor_store_email;
		$vendor_store_phone = $row->vendor_store_phone;
		$vendor_store_summary = $row->vendor_store_summary;
		$vendor_path = realpath(APPPATH . '../assets/images/vendors');
		$vendor_location = base_url().'assets/images/vendors/';
		$image = $this->products_model->image_display($vendor_path, $vendor_location, $vendor_logo);
	}

?>
<!-- styles needed by smoothproducts.js for product zoom  -->
<link rel="stylesheet" href="<?php echo base_url()."assets/themes/image_viewer/";?>css/smoothproducts.css">


<div class="container main-container headerOffset">
  
  <?php echo $this->load->view('products/breadcrumbs');?>
  
  <div class="row transitionfx">
	<div class="product-info">

    	<div class="product-content">
    		
    		<div class="col-lg-6 col-md-6 col-sm-6">

				<div class="sp-loading"><img src="<?php echo site_url().'assets/themes/image_viewer/';?>images/sp-loading.gif" alt=""><br>LOADING IMAGES</div>
                <div class="sp-wrap">
                <?php					
				$gallery_location = base_url().'assets/images/products/gallery/';
				$gallery_path = realpath(APPPATH . '../assets/images/products/gallery');
				
				$image = $this->products_model->image_display($gallery_path, $gallery_location, $image);
				?>
                    <a href="<?php echo $image;?>"><img src="<?php echo $image;?>" alt=""></a>
                <?php

				if($product_images->num_rows() > 0)
				{
					$galleries2 = $product_images->result();
					
					foreach($galleries2 as $gal2)
					{
						 $thumb2 = $gal2->product_image_thumb;
						 $image2 = $gal2->product_image_name;

						$image3 = $this->products_model->image_display($gallery_path, $gallery_location, $image2);
						?>
                        <a href="<?php echo $image3;?>"><img src="<?php echo $image3;?>" alt=""></a>
					<?php
					}
				}
				?>
                </div>
		    	
		    </div>
    		<div class="col-lg-6 col-md-6 col-sm-6">
    			<!-- code for the item -->
				<div class="product-share row">
					
					<div class="col-md-6">
						<h1 class="product-title"> <?php echo $product_name;?></h1>
						<h3 class="product-code">Product Code : <?php echo $product_code;?></h3>
						<div class="product-price"> 
							<?php echo $price;?>    
						</div>
					</div>
					
					<div class="share-icons col-md-6">
						<div class="clearfix" style="float:right;">
							<p> SHARE </p>
							<div class="socialIcon"> 
								<a href="#"> <i class="fa fa-facebook"></i></a> 
								<a href="#"> <i class="fa fa-twitter"></i></a> 
								<a href="#"> <i class="fa fa-google-plus"></i></a> 
								<a href="#"> <i class="fa fa-pinterest"></i></a> 
							</div>
						</div>
						<!--/.product-share--> 
					</div>
				</div>
				      <div class="details-description">
				        <p><?php echo $product_description;?></p>
				      </div>
				      
				            
				      <div class="cart-actions">
				        <div class="addto">
				        	<!-- <a href="91" class="add_to_cart"><button class="button btn-cart cart first" title="Add to Cart" type="button">Add to Cart</button></a> -->
				          <!--<a class="link-wishlist wishlist add_to_wishlist" href="91">Add to Wishlist</a> </div> -->
				          <a class="btn btn-warning add_to_wishlist " href="<?php echo $product_id;?>" product_id="<?php echo $product_id;?>" data-toggle="modal" data-target=".wishlist-modal"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Add to wishlist</a>
	                       <?php echo $button;?>
	                       <a class="btn btn-success add_to_cart_redirect " href="<?php echo $product_id;?>" product_id="<?php echo $product_id;?>"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span>  Buy Now</a>
			                
		                    <div class="sadd-to-cart">
								<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								  <div class="modal-dialog modal-md">
								    <div class="modal-content">
								      	 <div class="modal-header">
						                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						                    <div class="hgroup title">
						                        <h3>You're one step closer to owning this product!</h3>
						                        <h5>"<?php echo $product_name;?>" has been added to your cart</h5>
						                    </div>
						                </div>
						                <div class="modal-footer">	
						                    <div class="pull-right">				
						                        <a href="<?php echo site_url().'cart';?>" class="btn btn-primary btn-small">
						                            Go to cart &nbsp; <span class="glyphicon glyphicon-arrow-right"></span>
						                        </a>
						                    </div>
						                </div>
						            
								    </div>
								  </div>
								</div>

	                        </div>    
				          
				        <div style="clear:both"></div>
				        
				        <h3 class="incaps"><i class="fa fa fa-check-circle-o color-in success"></i> In stock</h3>        <h3 class="incaps"> <i class="glyphicon glyphicon-lock"></i> Secure online ordering</h3>
				      </div>
				      <!--/.cart-actions-->
				      
				      <div class="clear"></div>
				      
				    </div><!--/ right column end -->
				    
    			<!-- end of that code -->
	            
			</div> 
        </div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="box">

					<!-- Tab panels' navigation -->
					<ul class="nav nav-tabs">
						
						<li class="active">
							<a href="#description" data-toggle="tab">
								<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
								<span class="hidden-phone">Business</span>
							</a>
						</li>

						<li class="">
							<a href="#shipping" data-toggle="tab">
								<span class="glyphicon glyphicon-plane" aria-hidden="true"></span>
								<span class="hidden-phone">Shipping</span>
							</a>
						</li>

						<li class="">
							<a href="#returns" data-toggle="tab">
								<span class="glyphicon glyphicon-retweet" aria-hidden="true"></span>
								<span class="hidden-phone">Returns</span>
							</a>
						</li>

						<li class="">
							<a href="#ratings" data-toggle="tab">
								<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
								<span class="hidden-phone">Ratings</span>
							</a>
						</li>
					</ul>
					<!-- End Tab panels' navigation -->
						

					<!-- Tab panels container -->
					
					<div class="tab-content">
						
					  
						<!-- End id="product" -->
						
						<!-- Description tab -->
						<div class="tab-pane active" id="description">
                        	<div class="row">
                            	<div class="col-md-4">
                                	<img src="<?php echo $image;?>" class="img-responsive">
                                </div>
                                
                            	<div class="col-md-8">
                                	<div class="details">
                                        <h3><?php echo $vendor_store_name;?></h3>
                                        <h6><?php echo $post_code.', '.$surburb_name;?></h6>
                                        <!-- <div class="prices"><span class="price"><?php echo $price;?></span></div> -->
        
                                        <div class="meta" style="margin-top:5px;">
                                            <div class="phone" >
                                                <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                                                <span rel="tooltip" title="" data-original-title="SKU is 0092"> Phone number : <?php echo $vendor_phone?> </span>
                                            </div>
                                            <div class="email" >
                                                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                                <span rel="tooltip" title="" data-original-title="SKU is 0092"> Email : <?php echo $vendor_email;?> </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                	<?php echo $vendor_store_summary;?>
                                </div>
                            </div>
							
						</div>
						<!-- End id="description" -->

						<!-- Shipping tab -->
						<div class="tab-pane" id="shipping">
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
							<p><img class="img-polaroid" src="http://www.tfingi.com/repo/royal-mail.png" alt=""><img class="img-polaroid" src="http://www.tfingi.com/repo/ups-logo.png" alt=""></p>
							<p>Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
							<h6><em class="icon-gift"></em> Giftwrap?</h6>
							<p>Let us take care of giftwrapping your presents by selecting <strong>Giftwrap</strong> in the order process. Eligible items can be giftwrapped for as little as £0.99, and larger items may be presented in gift bags.</p>						
						</div>
						<!-- End id="shipping" -->

						<!-- Returns tab -->
						<div class="tab-pane" id="returns">
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
							<p class="lead">For any unwanted goods La Boutique offers a <strong>21-day return policy</strong>.</p>
							<p>If you receive items from us that differ from what you have ordered, then you must notify us as soon as possible using our <a href="#">online contact form</a>.</p>
							<p>If you find that your items are faulty or damaged on arrival, then you are entitled to a repair, replacement or a refund. Please note that for some goods it may be disproportionately costly to repair, and so where this is the case, then we will give you a replacement or a refund.</p>
							<p>Please visit our <a href="#">Warranty section</a> for more details.</p>						
						</div>
						<!-- End id="returns" -->

						
						<!-- Ratings tab -->
						<div class="tab-pane " id="ratings">
							<div class="ratings-items">
							<?php
							  $product_rating = $this->products_model->product_ratings($product_id);
							  if($product_rating->num_rows() > 0){
								$ratings = $product_rating->result();
							
								$count = 0;
									foreach($ratings as $rating)
									{	
										//feature details
										$content = $rating->product_review_content;
										$rating_value = $rating->product_review_rating;
										$author_email = $rating->product_review_reviewer_email;
										$author_name = $rating->product_review_reviewer_name;
										$author_phone = $rating->product_review_reviewer_phone;
										$review_created = $rating->product_review_created;
										?>
										<article class="rating-item">
											<div class="row">
												<div class="span9">
													<p><?php echo $content;?></p>
												</div>

												<div class="span3">
													<h6><?php echo $author_name;?></h6>
													<small><?php echo date('jS M Y H:i a',strtotime($review_created));?></small>
													<div class="rating rating-5">
														Rating
														<?php 
														if($rating_value > 0)
														{
															for($x=0;$x <$rating_value; $x++)
															{
																?>
																 <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
																<?php
															}
														}
														else
														{

														}
														?>
													   
													</div>
												</div>
											</div>
										</article>
									<?php
									}
								}

								?>


								<hr>
							</div>

							<div class="well">
								<div class="row">
									<div class="span8">
										<h6><i class="icon-comment-alt"></i> &nbsp; Share your opinion!</h6>
										<p>Let other people know your thoughts on this product!</p>

									</div>
									<div class="span4">
									
										<button class="btn btn-seconary btn-block" data-toggle="modal" data-target=".bs-example2-modal-lg">Rate this product</button>
									</div>
								</div>
							</div>
							<div class="modal fade bs-example2-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">

									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<div class="hgroup title">
											 <h3>You're one step closer to owning this product!</h3>
												<h5>"<?php echo $product_name;?>" has been added to your favorite products</h5>
										</div>
									</div>

									<form enctype="multipart/form-data" product_id="<?php echo $product_id;?>" action="<?php echo base_url();?>products/review-product/<?php echo $product_id;?>"  id = "product_review_form" method="post">
										<div class="modal-body">
											<div class="row">

												<div class="col-sm-6">
													<div class="control-group">
														<label class="control-label">Rating</label>
														<div class="controls">
															<select class="form-control" name="rate">
																<option value="1">1</option>
																<option value="2">2</option>
																<option value="3">3</option>
																<option value="4">4</option>
																<option value="5">5</option>
															</select>
														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="control-group">
														<label for="review_title" class="control-label">Phone Number</label>
														<div class="controls">
															<input class="form-control col-sm-12" id="review_author_phone" name="review_author_phone" type="text">
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-6">
													<div class="control-group">
														<label for="review_author_name" class="control-label">Your name</label>
														<div class="controls">
															<input class="form-control col-sm-12" id="review_author_name" name="review_author_name" type="text" value="">
														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="control-group">
														<label for="review_author_email" class="control-label">Your email</label>
														<div class="controls">
															<input  class="form-control col-sm-12" id="review_author_email" name="review_author_email" type="text" value="">
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-12">
													<div class="control-group">
														<label for="review_text" class="control-label">Review</label>
														<div class="controls">
															<textarea class="form-control col-sm-12" id="review_text" name="review_text"></textarea>
														</div>
													</div>

												</div>
											</div>

										</div>

										<div class="modal-footer">
											<div class="pull-right">
												<button class="btn btn-primary" type="submit" onclick="">Submit product review</button>
											</div>
										</div>                         
									</form>
								</div>
							</div>

						</div>
						<!-- End id="ratings" -->
						
						
					</div>                                            
					<!-- End tab panels container -->
					
				</div>
		
			</div>
				
		</div>
		
        <div class="clear-both"></div>
		<div class="beta-products-list product-items products-recent">
			
			<div class="row beta-products-details">
				<h4>Related products</h4>
			</div>

			<div class="owl-carousel" id="owl-recent">
					<?php
					$related_products_array = $this->products_model->related_products($product_id);
					
					 if($related_products_array->num_rows() > 0)
						{
							$related_product = $related_products_array->result();
							
							foreach($related_product as $prods)
							{
								$sale_price = $prods->sale_price;
								$sale_price_type = $prods->sale_price_type;
								$thumb = $prods->product_image_name;
								$product_id = $prods->product_id;
								$product_code = $prods->product_code;
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
								<div class="item">
									'.$sale.'
									<a class="cbp-vm-image" href="'.site_url().'products/view-product/'.$product_code.'"><img src="'.$image.'"></a>
									<h3 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_code.'">'.$brand_name.'</a></h3>
									<h6 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_code.'">'.$product_name.'</a></h6>
									'.$price.'
									<div >'.$balance_status.'</div>
									<a class="cbp-vm-icon cbp-vm-add add_to_wishlist" href="'.$product_id.'" product_id="'.$product_id.'" data-toggle="modal" data-target=".wishlist-modal"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
									'.$button.'
									<a class="beta-btn primary" href="'.site_url().'products/view-product/'.$product_code.'">Details <i class="glyphicon glyphicon-chevron-right"></i></a>
								</div>
								';
							}
					?>
				


			</div>
			<?php
			
			}
			
			else
			{
				echo 'There are no related products :-(';
			}
			?>
		</div>
  </div>
  
</div> <!-- /main-container -->


<div class="gap"></div>
</div>
<!-- include smoothproducts // product zoom plugin  --> 
<script type="text/javascript" src="<?php echo base_url()."assets/themes/image_viewer/";?>js/smoothproducts.min.js"></script> 
<script type="text/javascript">
	$(window).load(function() {
		$('.sp-wrap').smoothproducts();
	});
	$(document).ready(function(){
    /* This code is executed after the DOM has been completely loaded */
    	
    var totWidth=0;
    var positions = new Array();

    $('#slides .slide').each(function(i){
        /* Loop through all the slides and store their accumulative widths in totWidth */
        positions[i]= totWidth;
        totWidth += $(this).width();

        /* The positions array contains each slide's commulutative offset from the left part of the container */

        if(!$(this).width())
        {
            alert("Please, fill in width & height for all your images!");
            return false;
        }
    });

    $('#slides').width(totWidth);

    /* Change the cotnainer div's width to the exact width of all the slides combined */

    $('#menu ul li a').click(function(e){

        /* On a thumbnail click */
        $('li.menuItem').removeClass('act').addClass('inact');
        $(this).parent().addClass('act');

        var pos = $(this).parent().prevAll('.menuItem').length;

        $('#slides').stop().animate({marginLeft:-positions[pos]+'px'},450);
        /* Start the sliding animation */

        e.preventDefault();
        /* Prevent the default action of the link */
    });

    $('#menu ul li.menuItem:first').addClass('act').siblings().addClass('inact');
    /* On page load, mark the first thumbnail as active */
});
</script>