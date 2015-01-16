<?php
	$product = $product_details->result();
	//the product details
	$sale_price = $product[0]->sale_price;
	$featured = $product[0]->featured;
	$category_id = $product[0]->category_id;
	$brand_id = $product[0]->brand_id;
	$product_id = $product[0]->product_id;
	$product_name = $product[0]->product_name;
	$product_code = $product[0]->product_code;
	$product_buying_price = $product[0]->product_buying_price;
	$product_status = $product[0]->product_status;
	$product_selling_price = $product[0]->product_selling_price;
	$image = $product[0]->product_image_name;
	$thumb = $product[0]->product_thumb_name;
	$product_description = $product[0]->product_description;
	$product_balance = $product[0]->product_balance;
	$brand_name = $product[0]->brand_name;
	$category_name = $product[0]->category_name;
	$mini_desc = implode(' ', array_slice(explode(' ', $product_description), 0, 10));
	
	if($sale_price > 0)
	{
		$selling_price = $product_selling_price - ($product_selling_price * ($sale_price/100));
		$price = '<span class="price-sales" style="text-decoration: line-through;"> $ '. number_format($selling_price, 0, '.', ',').'</span> <span class="price-standard">$ '. number_format($product_selling_price, 0, '.', ',').'</span> ';
	}
	
	else
	{
		$price = '<span class="price-sales">$ '. number_format($product_selling_price, 0, '.', ',').'</span>';
	}
?>
<!-- styles needed by smoothproducts.js for product zoom  -->
<link rel="stylesheet" href="<?php echo base_url()."assets/themes/tshop/";?>css/smoothproducts.css">


<div class="container main-container headerOffset">
  
  <?php echo $this->load->view('products/breadcrumbs');?>
  
  <div class="row transitionfx">
  <div class="product-info">
   <!-- left column -->

    <div class="col-lg-4 col-md-4 col-sm-4">

    	<div class="product-images">
    			<h4>Product Image</h4>
                <div class="box">
                   	<div id="main">
						<div id="gallery">
							<div id="slides">
								<?php
								if($product_images->num_rows() > 0)
								{
									$galleries = $product_images->result();
									
									foreach($galleries as $gal)
									{
										$thumb = $gal->product_image_thumb;
										$image = $gal->product_image_name;
										?>
										<div class="slide"><img src="<?php echo base_url()."assets/images/products/gallery/".$image;?>" width="920" height="400" /></div>
									<?php
											}
										}
									?>
							</div>
							<div id="menu">
								<ul>
									<li class="fbar">&nbsp;</li>
									
									 <?php
										if($product_images->num_rows() > 0)
										{
											$galleries = $product_images->result();
											
											foreach($galleries as $gal)
											{
												$thumb = $gal->product_image_thumb;
												$image = $gal->product_image_name;
												?>
												<li class="menuItem"><a href="<?php echo base_url()."assets/images/products/gallery/".$image;?>"><img src="<?php echo base_url()."assets/images/products/gallery/".$image;?>" class="img-responsive" alt="img"/></a></li>
								                
												<?php
											}
										}
									?>
								</ul>
							</div>
						</div>
					</div>

                    <div class="social">
                        <div id="sharrre">
                            <div class="facebook sharrre"><button class="btn btn-mini btn-facebook"><i  class="fa fa-facebook"></i></button></div>
                            <div class="twitter sharrre"><button class="btn btn-mini btn-twitter"><i  class="fa fa-twitter"></i></button></div>
                            <div class="googleplus sharrre"><button class="btn btn-mini btn-twitter"><i  class="fa fa-google-plus"></i> </button></div>                                                   
                            <div class="pinterest sharrre"><button class="btn btn-mini btn-pinterest"><i  class="fa fa-pinterest"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!--/ left column end -->
    
    
    <!-- right column -->
    <div class="col-lg-8 col-md-8 col-sm-8">

    	<div class="product-content">
    		<div class="product-content-header">
    		<h4>Product details</h4>
    		</div>
            <div class="box">

                <!-- Tab panels' navigation -->
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product" data-toggle="tab">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            <span class="hidden-phone">Product</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#description" data-toggle="tab">
                       
                        	 <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                           
                            <span class="hidden-phone">Info</span>
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
                    
                    <!-- Product tab -->
                    <div class="tab-pane active" id="product">
                        <form enctype="multipart/form-data" action="#" onsubmit="return false;" method="post">
                            
                            <div class="details">
                                <h1><?php echo $product_name;?>  </h1>
                                <div class="prices"><span class="price"><?php echo $price;?></span></div>

                                <div class="meta">
                                    <div class="sku">
                                    
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        <span rel="tooltip" title="" data-original-title="SKU is 0092">Product Code : <?php echo $product_code;?></span>
                                    </div>

                                    <div class="categories">
                                       <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>  <span><a href="" title="<?php echo $brand_name;?>"><?php echo $brand_name;?></a></span>, <a href="" title="<?php echo $category_name;?>"><?php echo $category_name;?></a>
                                    </div>
                                </div>
                            </div>

                            <div class="short-description">
                                <p><?php echo $mini_desc;?></p>
                            </div>
                             <?php
						      	//product features
								if(($all_features->num_rows() > 0) && ($product_features->num_rows() > 0))
								{
									$feature = $all_features->result();
									$product_feature = $product_features->result();
								
									$count = 0;
									foreach($feature as $feat)
									{	
										//feature details
										$feature_id = $feat->feature_id;
										$feature_name = $feat->feature_name;
										$count = 0;
										
										//product feature details
										$feature_values = '';
										
										foreach($product_feature as $f)
										{
											$feat_id = $f->feature_id;
											
											if($feat_id == $feature_id)
											{
												$product_feature_id = $f->product_feature_id;
												$name = $f->feature_value;
												$price = $f->price;
												$quantity = $f->quantity;
												$image = $f->thumb;
												//$image = '<img src="'. base_url().'assets/images/features/'.$f->thumb.'" alt="'.$name.'"/>';
												
												if(!empty($image))
												{

						                                        
													//open section
													if($count == 0)
													{
														$feature_values .= '
														<div class="options">
						                                	<div class="row-fluid">
						                                    	<div class="span6">
						                                    	<div class="control-group">

						                                            <label for="product_options" class="control-label">'.$feature_name.'</label>
						                                            <div class="controls">
						                                               <ul class="swatches Color">';
																		}
																		//add values
																		$feature_values .= '<li> <a ><img src="'. base_url().'assets/images/features/'.$image.'" alt="'.$name.'"/></a> </li>';
																		//close section
																		if($count == (count($product_feature) - 1))
																		{
																			$feature_values .= '
																		</ul>
						                                            </div>dd
						                                        </div>
						                                    </div>
						                                </div>
						                            </div>';
													}
												}
												
												else
												{
													//open section
													if($count == 0)
													{
														$feature_values .= '
														<div class="productFilter">
															<div class="filterBox">
																<select>';
													}
													//add values
													$feature_values .= '<option value="'.$product_feature_id.'">'.$name.'"</option>';
													//close section
													if($count == (count($product_feature) - 1))
													{
														$feature_values .= '
															</select>
						        						</div>';
													}
													
												}
												
												$count++;
											}
										}
									}
								}
							  ?>
                            

                            <div class="add-to-cart">
                               
                                <a href="#register" class="btn btn-primary btn-small" data-toggle="modal" data-target=".bs-example-modal-md">
		                          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &nbsp; Add to cart 
		                          </a>
		                          <!-- Large modal -->

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
                        </form>						
                    </div>
                    <!-- End id="product" -->
                    
                    <!-- Description tab -->
                    <div class="tab-pane" id="description">
                        <?php echo $product_description;?>						
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

                            <article class="rating-item">
                                <div class="row-fluid">
                                    <div class="span9">
                                        <h5>Shaped for crush</h5>
                                        <p>I hope they release some more colours of this dress. It feels great and looks sexier.<br>
                                            <br>
                                            I love it!</p>
                                    </div>

                                    <div class="span3">
                                        <img src="img/thumbnails/avatar.png" class="gravatar" alt="">
                                        <h6>Sam Ritora</h6>
                                        <small>08/30/2013</small>
                                        <div class="rating rating-5">
                                            <i class="icon-heart"></i>
                                            <i class="icon-heart"></i>
                                            <i class="icon-heart"></i>
                                            <i class="icon-heart"></i>
                                        </div>
                                    </div>
                                </div>
                            </article>


                            <hr>
                        </div>

                        <div class="well">
                            <div class="row-fluid">
                                <div class="span8">
                                    <h6><i class="icon-comment-alt"></i> &nbsp; Share your opinion!</h6>
                                    <p>Let other people know your thoughts on this product!</p>
                                </div>
                                <div class="span4">
                                    <button class="btn btn-seconary btn-block" onclick="$('#review_form').modal('show')">Rate this product</button>
                                </div>
                            </div>
                        </div>
                        <div  class="modal fade bs-example3-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	                        <div class="modal-header">
	                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                            <div class="hgroup title">
	                                <h3>You're one step closer to owning this product!</h3>
	                                <h5>"Chaser Overalls" has been added to your cart</h5>
	                            </div>
	                        </div>
	                        <div class="modal-footer">	
	                            <div class="pull-right">				
	                                <a href="cart.html" class="btn btn-primary btn-small">
	                                    Go to cart &nbsp; <i class="icon-chevron-right"></i>
	                                </a>
	                            </div>
	                        </div>
	                    </div>

                        <!-- Review modal window -->
                        <div id="review_form" class="modal hide fade" tabindex="-1" role="dialog">
                            <form enctype="multipart/form-data" action="/product/chaser-overalls" method="post">

                                <input type="hidden" name="ls_session_key" value="lsk52286509c22077.63404603">		
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <div class="hgroup title">
                                        <h3>Modal header</h3>
                                        <h5>Modal header</h5>
                                    </div>
                                </div>

                                <div class="modal-body">
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label class="control-label">Rating</label>
                                                <div class="controls">
                                                    <select class="span12" name="rate">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="review_title" class="control-label">Review title</label>
                                                <div class="controls">
                                                    <input class="span12" id="review_title" name="review_title" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="review_author_name" class="control-label">Your name</label>
                                                <div class="controls">
                                                    <input class="span12" id="review_author_name" name="review_author_name" type="text" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="review_author_email" class="control-label">Your email</label>
                                                <div class="controls">
                                                    <input class="span12" id="review_author_email" name="review_author_email" type="text" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label for="review_text" class="control-label">Review</label>
                                                <div class="controls">
                                                    <textarea class="span12" id="review_text" name="review_text"></textarea>
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
                        
                        <!-- End id="review_form" -->

                    </div>
                    <!-- End id="ratings" -->
                    
                    
                </div>                                            
                <!-- End tab panels container -->
                
            </div>
            
        </div>
      
  	</div>
  	<!--end of right column-->
 	
  </div>
  
</div> <!-- /main-container -->


<div class="gap"></div>
</div>
<script type="text/javascript">
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
<!-- include smoothproducts // product zoom plugin  --> 
<script type="text/javascript" src="<?php echo base_url()."assets/themes/tshop/";?>js/smoothproducts.min.js"></script> 