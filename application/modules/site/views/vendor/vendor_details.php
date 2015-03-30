<?php
	$vend = $vendor_details->result();

	$vendor_id = $vend[0]->vendor_id;
	$vendor_logo = $vend[0]->vendor_logo;
	$vendor_first_name = $vend[0]->vendor_first_name;
	$vendor_last_name = $vend[0]->vendor_last_name;
	$surburb_id = $vend[0]->surburb_id;
	$surburb_name = $vend[0]->surburb_name;
	$post_code = $vend[0]->post_code;

	$vendor_email = $vend[0]->vendor_email;
	$vendor_phone = $vend[0]->vendor_phone;
	$vendor_store_name = $vend[0]->vendor_store_name;
	$vendor_store_mobile = $vend[0]->vendor_store_mobile;
	$country_id = $vend[0]->country_id;
	$country_name = '';
	
	$vendor_business_type = $vend[0]->vendor_business_type;
	$vendor_store_postcode = $vend[0]->vendor_store_postcode;
	$vendor_store_address = $vend[0]->vendor_store_address;

	$vendor_store_email = $vend[0]->vendor_store_email;
	$vendor_store_phone = $vend[0]->vendor_store_phone;
	$vendor_store_summary = $vend[0]->vendor_store_summary;

	if(empty($vendor_store_phone))
	{
		$vendor_store_phone = $vendor_phone;
	}
	 if(empty($vendor_store_address))
	 {
	 	$vendor_store_address = 'N/A';
	 }

	 if(empty($vendor_store_postcode))
	 {
	 	$vendor_store_address = 'N/A';
	 }
	 
	$name = $vendor_last_name." ".$vendor_first_name;
	$image = $this->products_model->image_display($vendor_path, $vendor_location, $vendor_logo);
?>


<div class="container main-container headerOffset">
  
  <?php echo $this->load->view('vendor/breadcrumbs');?>
  
  <div class="row transitionfx">
  <div class="product-info">
   <!-- left column -->

    <div class="col-lg-4 col-md-4 col-sm-4">

    	<div class="product-images">
    			<h4>Logo</h4>
                <div class="box">
                   	<img src="<?php echo $image;?>">

                    <div class="social">
                        <div id="sharrre">
                            <!--<div class="facebook sharrre"><button class="btn btn-mini btn-facebook"><i  class="fa fa-facebook"></i></button></div>
                            <div class="twitter sharrre"><button class="btn btn-mini btn-twitter"><i  class="fa fa-twitter"></i></button></div>
                            <div class="googleplus sharrre"><button class="btn btn-mini btn-twitter"><i  class="fa fa-google-plus"></i> </button></div>                                                   
                            <div class="pinterest sharrre"><button class="btn btn-mini btn-pinterest"><i  class="fa fa-pinterest"></i></button></div>-->
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
    		<h4>Business details</h4>
    		</div>
            <div class="box">

                <!-- Tab panels' navigation -->
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#product" data-toggle="tab">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            <span class="hidden-phone">Business Info</span>
                        </a>
                    </li>
                     <li >
                        <a href="#store" data-toggle="tab">
                            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                            <span class="hidden-phone">Store Info</span>
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
                            	<h3><?php echo $name;?></h3>
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

                            <div class="short-description">
                               <p><?php echo $vendor_store_summary;?></p>
                            </div>
                           
                        </form>						
                    </div>
                    <!-- End id="product" -->

                    <!-- Product tab -->
                    <div class="tab-pane " id="store">
                        <form enctype="multipart/form-data" action="#" onsubmit="return false;" method="post">
                            
                            <div class="details">
                            	<h3><?php echo $vendor_store_name;?></h3>
                                <!-- <div class="prices"><span class="price"><?php echo $price;?></span></div> -->

                                <div class="meta2" style="margin-top:5px;">
                                    <div class="phone" >
                                        <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                                        <span rel="tooltip" title="" data-original-title="SKU is 0092"> Phone number : <?php echo $vendor_store_mobile;?> </span>
                                    </div>
                                    <div class="email" >
                                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                        <span rel="tooltip" title="" data-original-title="SKU is 0092"> Email : <?php echo $vendor_store_email;?> </span>
                                    </div>

                                    <div class="categories">
                                       <span class="glyphicon glyphicon-tags" aria-hidden="true"> Address : <?php echo $vendor_store_postcode;?> , <?php echo $vendor_store_address?></span>  

                                    </div>
                                </div>
                            </div>

                            <div class="short-description">
                                <p><?php echo $vendor_store_summary;?></p>
                            </div>
                           
                        </form>						
                    </div>
                    <!-- End id="product" -->
                    
                    
                    
                    
                </div>                                            
                <!-- End tab panels container -->
                
            </div>
            
        </div>
      
  	</div>
  	<!--end of right column-->
 	
  </div>
  <div class="clear-both"></div>
  <!-- Vendor products -->
  <div class="beta-products-list product-items vendor-products">
    
    <div class="row beta-products-details">
        <h4>Business's latest products</h4>
    </div>

    <div class="owl-carousel" id="owl-recent">
            <?php
             if($products->num_rows() > 0)
                {
                    $related_product = $products->result();
                    
                    foreach($related_product as $prods)
                    {
                        $sale_price = $prods->sale_price;
                        $sale_price_type = $prods->sale_price_type;
                        $thumb = $prods->product_image_name;
                        $product_id = $prods->product_id;
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
                            <a class="cbp-vm-image" href="'.site_url().'products/view-product/'.$product_id.'"><img src="'.$image.'"></a>
                            <h3 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_id.'">'.$brand_name.'</a></h3>
                            <h6 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_id.'">'.$product_name.'</a></h6>
                            '.$price.'
                            <div >'.$balance_status.'</div>
                            <a class="cbp-vm-icon cbp-vm-add add_to_wishlist" href="'.$product_id.'" product_id="'.$product_id.'" data-toggle="modal" data-target=".wishlist-modal"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
                            '.$button.'
                            <a class="beta-btn primary" href="'.site_url().'products/view-product/'.$product_id.'">Details <i class="glyphicon glyphicon-chevron-right"></i></a>
                        </div>
                        ';
                    }
            ?>
        


    </div>
	<?php
    
    }
    
    else
    {
        echo 'This vendor has no products';
    }
    ?>
</div>
  <!-- End vendor products -->
  
</div> <!-- /main-container -->


<div class="gap"></div>
</div>