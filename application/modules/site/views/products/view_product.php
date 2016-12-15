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
	$product_image = $product[0]->product_image_name;
	$product_thumb = $product[0]->product_thumb_name;
	$product_description = $product[0]->product_description;
	$description = $product_description;
	$product_balance = $product[0]->product_balance;
	$brand_name = $product[0]->brand_name;
	$category_name = $product[0]->category_name;
	$created_by = $product[0]->created_by;
	$tiny_url = $product[0]->tiny_url;
	$mini_desc = implode(' ', array_slice(explode(' ', $product_description), 0, 10));
	$button = '';
	$sale = '';
	$balance_status = '';
	if($product_balance == 0)
	{
		$button = '';
		$balance_status = 'Product out of stock';
	}
	else
	{
		$button = ' <a href="#register" product_id="'.$product_id.'" class="btn btn-primary add_to_cart_single" data-toggle="modal" data-target=".bs-example-modal-md">
		                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &nbsp; Add to cart 
		                          </a>';
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
					
	//business details
	$where = 'vendor.surburb_id = surburb.surburb_id AND vendor.vendor_id = '.$created_by;
	$table = 'vendor,surburb';
	$business_query = $this->vendor_model->get_vendor_details($created_by, $table, $where);

?>
<!-- single product start -->
        <div class="single_product_area">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="breadcrumb">
                            <a href="<?php echo site_url();?>"><i class="fa fa-home"></i>Home</a>
                            <span class="navigation-pipe"><i class="fa fa-angle-right"></i></span>
                            <a href="<?php echo site_url().'products';?>">Products</a>
                            <span class="navigation-pipe"><i class="fa fa-angle-right"></i></span>
                            <span class="navigation_page"><?php echo $product_name;?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="primary_block">
                        <div class="col-xs-12 col-sm-6 col-md-5">
                           <div class="zoomWrapper">
								<?php
				
								$product_location = base_url().'assets/images/products/images/';
								$product_path = realpath(APPPATH . '../assets/images/products/images');
								$product_image = $this->products_model->image_display($product_path, $product_location, $product_image);
								
								$gallery_location = base_url().'assets/images/products/gallery/';
								$gallery_path = realpath(APPPATH . '../assets/images/products/gallery');
								?>
                                <div id="img-1" class="zoomWrapper single-zoom">
                                    <a href="#">
                                        <img id="zoom1" src="<?php echo $product_image;?>" data-zoom-image="<?php echo $product_image;?>" alt="big-1">
                                    </a>
									<?php echo $sale;?>
                                </div>
                                <div class="product-thumb row">
                                    <ul class="p-details-slider" id="gallery_01">
								
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
												<li class="col-md-4">
													<a class="elevatezoom-gallery" href="#" data-image="<?php echo $image3;?>" data-zoom-image="<?php echo $image3;?>"><img src="<?php echo $image3;?>" alt=""></a>
												</li>
											<?php
											}
										}
										?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="primary_block_details">
                                <h1><?php echo $product_name;?></h1>
								
                                <p class="product_condition"><?php echo $description;?></p>
                                <div class="stock">
                                    <div class="stock_items">
                                        <p><?php echo $product_balance;?> Items</p>
                                    </div>
                                    <div class="stock_button">
                                        <a href="#">In stock</a>
                                    </div>
                                </div>
                                <span id="our_price_display"><?php echo $price;?></span>
                                <div class="product_attributes clearfix">
									 <!-- features -->
									<?php
									$color_features = $text_features = '';
									if($feature_names->num_rows() > 0)
									{
										$feat_count = 0;
										$color_features = $text_features = '<fieldset class="attribute_fieldset">';
										$prev_feature = '';
										$prev_feature_id = '';
										$colors = '';
										$first_text = 0;
										
										foreach($feature_names->result() as $feat)
										{
											$feat_count++;
											$feature_name = $feat->feature_name;
											$feature_id = $feat->feature_id;
											
											//display product features
											if($product_features->num_rows() > 0)
											{
												$prod_feat_count = 0;
												foreach($product_features->result() as $prod_feat)
												{
													$feat_name = $prod_feat->feature_name;
													
													if($feat_name == $feature_name)
													{
														$prod_feat_count++;
														//check if feature has images
														$feature_image = $prod_feat->image;
														$feature_value = $prod_feat->feature_value;
														$product_feature_id = $prod_feat->product_feature_id;
														$feature_location = base_url().'assets/images/products/features/';
														$feature_path = realpath(APPPATH . '../assets/images/products/features');
														$feature_image_display = $this->products_model->image_display($feature_path, $feature_location, $feature_image);
														
														//display feature images
														if($feature_image != 'None')
														{
															$colors = 'true';
															if($prod_feat_count == 1)
															{
																if(!empty($prev_feature) && ($prev_feature != $feature_name))
																{
																	$color_features .= '
																			</ul>
																		</div> 
																	</fieldset>
																	<label class="attribute_label">'.$feature_name.'</label>
																	<div class="attribute_list">
																		<ul class="clearfix" id="color_to_pick_list">
																			<li class="selected" id="feat-prev'.$product_feature_id.'">
																				<a class="preview-feature" data-image-preview="'.$feature_image_display.'" href="'.$product_feature_id.'" feature-id="'.$feature_id.'"><img src="'.$feature_image_display.'" /></a> <input type="hidden" name="selected_features[]" id="selected_features'.$feature_id.'" value=""/>
																			</li>';
																}
																
																else
																{
																	$color_features .= '
																	<label class="attribute_label">'.$feature_name.'</label>
																	<div class="attribute_list">
																		<ul class="clearfix" id="color_to_pick_list">
																			<li class="selected" id="feat-prev'.$product_feature_id.'">
																				<a class="preview-feature" data-image-preview="'.$feature_image_display.'" href="'.$product_feature_id.'" feature-id="'.$feature_id.'"><img src="'.$feature_image_display.'" /></a> <input type="hidden" name="selected_features[]" id="selected_features'.$feature_id.'" value=""/>
																			</li>';
																}
																$prev_feature = $feature_name;
																$prev_feature_id = $feature_id;
															}
															
															else
															{	
																$color_features .= '
																			<li class="selected" id="feat-prev'.$product_feature_id.'">
																				<a class="preview-feature" data-image-preview="'.$feature_image_display.'" href="'.$product_feature_id.'" feature-id="'.$feature_id.'"><img src="'.$feature_image_display.'" /></a> <input type="hidden" name="selected_features[]" id="selected_features'.$feature_id.'" value=""/>
																			</li>';
															}
														}
														
														//display features in dropdown
														else
														{
															if($prod_feat_count == 1)
															{
																//if image features were not displayed
																if(empty($colors))
																{
																	if(!empty($prev_feature) && ($prev_feature != $feature_name))
																	{
																		$text_features .= '
																			</select>
																		</div>
																		<label class="attribute_label">'.$feature_name.'</label>
																		<div class="attribute_list">
																			<input type="hidden" name="selected_features[]" id="selected_features'.$feature_id.'" value=""/>
																			<select class="form-control" feature-id="'.$feature_id.'">
																				<option value="" selected onclick="select_feature(\'\', '.$feature_id.')">'.$feature_name.'</option>
																				<option value="'.$product_feature_id.'" onclick="select_feature('.$product_feature_id.', '.$feature_id.')">'.$feature_value.'</option>';
																	}
																	
																	else
																	{
																		$text_features .= '
																			<label class="attribute_label">'.$feature_name.'</label>
																			<div class="attribute_list">
																				<input type="hidden" name="selected_features[]" id="selected_features'.$feature_id.'" value=""/>
																				<select class="form-control" feature-id="'.$feature_id.'">
																					<option value="" selected onclick="select_feature(\'\', '.$feature_id.')">'.$feature_name.'</option>
																					<option value="'.$product_feature_id.'" onclick="select_feature('.$product_feature_id.', '.$feature_id.')">'.$feature_value.'</option>';
																	}
																}
																
																//if image features were not displayed
																else
																{
																	$first_text++;
																	
																	if($first_text == 1)
																	{
																		$text_features .= '
																			<label class="attribute_label">'.$feature_name.'</label>
																			<div class="attribute_list">
																				<input type="hidden" name="selected_features[]" id="selected_features'.$feature_id.'" value=""/>
																				<select class="form-control" feature-id="'.$feature_id.'">
																					<option value="" selected onclick="select_feature(\'\', '.$feature_id.')">'.$feature_name.'</option>
																					<option value="'.$product_feature_id.'" onclick="select_feature('.$product_feature_id.', '.$feature_id.')">'.$feature_value.'</option>';
																	}
																	else
																	{
																		$text_features .= '
																			</select>
																		</div>
																		<label class="attribute_label">'.$feature_name.'</label>
																		<div class="attribute_list">
																			<input type="hidden" name="selected_features[]" id="selected_features'.$feature_id.'" value=""/>
																			<select class="form-control" feature-id="'.$feature_id.'">
																				<option value="" selected onclick="select_feature(\'\', '.$feature_id.')">'.$feature_name.'</option>
																				<option value="'.$product_feature_id.'" onclick="select_feature('.$product_feature_id.', '.$feature_id.')">'.$feature_value.'</option>';
																	}
																}
																$prev_feature = $feature_name;
															}
															
															else
															{
																$text_features .= '<option value="'.$product_feature_id.'" onclick="select_feature('.$product_feature_id.', '.$feature_id.')">'.$feature_value.'</option>';
															}
														}
													}
												}
											}
										}
										
										//$color_features .= '<li class=""> <a class="clear-feature-preview" href="'.$prev_feature_id.'" feature-id="'.$prev_feature_id.'">Back</a></li></ul></div></div>';
										$text_features .= '</select></div></div>';
										
									}
									?>
									<!-- end features -->
									<p style="display: none;" id="minimal_quantity_wanted_p">
                                        The minimum purchase order quantity for the product is <b id="minimal_quantity_label">1</b>
                                    </p>
                                    <div id="attributes">
                                        <div class="clearfix"></div>
                                        <?php
										echo $color_features;
										echo $text_features;
										?>
										
										<div class="button_content">
											<a href="'.$product_id.'" product_id="'.$product_id.'" class="cart_button add_to_cart">add to cart</a>
											<a href="'.$product_id.'" product_id="'.$product_id.'" class="heart add_to_wishlist"><i class="fa fa-heart"></i></a>
										</div>
									</div>
                                    </div>		 
								</div>
                            </div>
							<?php //echo $this->load->view('home/home_left_navigation');?>
					</div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="p-details-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#data" aria-controls="data" role="tab" data-toggle="tab">VENDOR</a></li>
                                <li role="presentation"><a href="#more-info" aria-controls="more-info" role="tab" data-toggle="tab">RETURNS</a></li>
                                <li role="presentation"><a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">RATINGS</a></li>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        <div class="tab-content review">
                            <div role="tabpanel" class="tab-pane active" id="data">
                                
								<!-- Business -->
								<?php
							
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
									$return_policy = $row->return_policy;
									$vendor_path = realpath(APPPATH . '../assets/images/vendors');
									$vendor_location = base_url().'assets/images/vendors/';
									$image = $this->products_model->image_display($vendor_path, $vendor_location, $vendor_logo);
									$web_name = $this->site_model->create_web_name($vendor_store_name);
									
									?>
									<div class="row">
										<div class="col-md-4">
											<a href="<?php echo site_url().'businesses/'.$web_name.'&'.$vendor_id?>"><img src="<?php echo $image;?>" class="img-responsive"></a>
										</div>
										
										<div class="col-md-8">
											<div class="details">
												<a href="<?php echo site_url().'businesses/'.$web_name.'&'.$vendor_id?>"><h3><?php echo $vendor_store_name;?></h3></a>         
												<h6><?php echo $post_code.', '.$surburb_name;?></h6>
												<!-- <div class="prices"><span class="price"><?php echo $price;?></span></div> -->
				
												<div class="meta" style="margin-top:5px;">
													<div class="phone" >
														<span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
														<span rel="tooltip" title="" data-original-title="SKU is 0092"> Phone number : <?php echo $vendor_store_phone?> </span>
													</div>
													<div class="email" >
														<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
														<span rel="tooltip" title="" data-original-title="SKU is 0092"> Email : <?php echo $vendor_store_email;?> </span>
													</div>
												</div>
											</div>
											
											<?php echo $vendor_store_summary;?>
										</div>
									</div>
									<?php
								}
								?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="more-info">
                                
								<!-- Returns -->
								<?php echo $return_policy;?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="reviews">
                                
								<!-- Ratings -->
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
												 <h3>Please share your thoughts on <?php echo $product_name;?></h3>
												<!--<h5>"<?php echo $product_name;?>" has been added to your favorite products</h5>-->
											</div>
										</div>

										<form enctype="multipart/form-data" product_code="<?php echo $product_code;?>" product_id="<?php echo $product_id;?>" action="<?php echo base_url();?>products/review-product/<?php echo $product_id;?>"  id = "product_review_form" method="post">
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

                                <div id="product-comments-block-tab">
									
                                    <a href="#" class="comment-btn"><span>Be the first to write your review!</span></a>
									
									<div class="social-sharing">
										<div class="widget widget_socialsharing_widget">
											<h3 class="widget-title-modal">Share this product</h3>
											<ul class="social-icons">
												<li><a href="#" onclick="facebook_share(\''.$product_name.'\', \''.$tiny_url.'\',  \''.$product_image.'\')" class="facebook social-icon"><i class="fa fa-facebook"></i></a></li>
												<li><a target="_blank" title="Twitter" href="https://twitter.com/intent/tweet?screen_name=Shopyard&text=Checkout%20<?php echo $product_name;?>%20and%20lots%20more%20on%20www.shopyard.co.ke%20<?php echo $tiny_url; ?>" class="twitter social-icon"><i class="fa fa-twitter"></i></a></li>
											</ul>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="featured_area">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="section_title">
                                            <h3><span class="angle"><i class="fa fa-clock-o"></i></span>Related Products</h3>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="featured_products single">
										
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
													$prod_image = $this->products_model->image_display($products_path, $products_location, $thumb);
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
													
													echo
													'
													<div class="col-xs-12">
														<div class="single_product">
															<div class="product_image">
																<a class="product_img_link" href="'.site_url().'products/view-product/'.$product_code.'">
																	<img src="'.$prod_image.'">
																</a>
																'.$sale.'
																<a href="#" class="quick-view modal-view" data-toggle="modal" data-target="#productModal'.$product_id.'">
																	<i class="fa fa-eye"></i>Quick view
																</a>
															</div>
															<div class="product_content">
																<a href="#" class="product-name">
																	'.$product_name.'
																</a>
																<div class="star_content">
																	<i class="fa fa-star-o color"></i>
																	<i class="fa fa-star-o color"></i>
																	<i class="fa fa-star-o"></i>
																	<i class="fa fa-star-o"></i>
																	<i class="fa fa-star-o"></i>
																</div>
																'.$price.'
																<div class="button_content">
																	<a href="'.$product_id.'" product_id="'.$product_id.'" class="cart_button add_to_cart">add to cart</a>
																	<a href="'.site_url().'products/view-product/'.$product_code.'" class="heart"><i class="fa fa-signal"></i></a>
																	<a href="'.$product_id.'" product_id="'.$product_id.'" class="heart add_to_wishlist"><i class="fa fa-heart"></i></a>
																							</div>
															</div>
														</div>
													</div>
													
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
																							<li><a href="#" onclick="facebook_share(\''.$product_name.'\', \''.$tiny_url.'\',  \''.$product_image.'\')" class="facebook social-icon"><i class="fa fa-facebook"></i></a></li>
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
                            </div>
                        </div>
                        <!-- featured end -->
                    </div>
                </div>
            </div>
        </div>                           
        <!-- shop grid end -->
		
		
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
