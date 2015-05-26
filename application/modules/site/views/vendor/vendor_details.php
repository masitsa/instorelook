<?php
	$vend = $vendor_details->result();

	$vendor_id = $vend[0]->vendor_id;
	
	$surburb_name = $vend[0]->surburb_name;
	$post_code = $vend[0]->post_code;
	$vendor_logo = $vend[0]->vendor_logo;
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
	$longitude = $vend[0]->lon;
	$latitude = $vend[0]->lat;
	$tiny_url = $vend[0]->tiny_url;
	$image = $this->products_model->image_display($vendor_path, $vendor_location, $vendor_logo);
?>
<!-- styles needed by smoothproducts.js for product zoom  -->
<link rel="stylesheet" href="<?php echo base_url()."assets/themes/image_viewer/";?>css/smoothproducts.css">

<div class="container main-container headerOffset">
  
  <?php echo $this->load->view('vendor/breadcrumbs');?>
  
  <div class="row transitionfx">
  <div class="product-info">
   <!-- left column -->

    <div class="col-lg-4 col-md-4 col-sm-4">

    	<div class="product-images">
        	<div class="sp-loading"><img src="<?php echo site_url().'assets/themes/image_viewer/';?>images/sp-loading.gif" alt=""><br>LOADING IMAGES</div>
            <div class="sp-wrap">
                <a href="<?php echo $image;?>"><img src="<?php echo $image;?>" class="img-responsive"></a>
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
				
                <div class="details">
                	<h3 style="margin-top:0;"><?php echo $vendor_store_name;?></h3>

                    <div class="meta2" style="margin-top:5px;">
                    	<div class="row">
                        	<div class="col-md-5">
                            	<ul>
                                <li><span class="fa fa-phone"></span>
                                <span> <strong>Phone number: </strong> <?php echo $vendor_store_phone;?> </span></li>
                                
                                <li><span class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                                <span> <strong>Mobile number: </strong> <?php echo $vendor_store_mobile;?> </span></li>
                                
                                <li><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                                <span> <strong>Email:</strong> <?php echo $vendor_store_email;?> </span></li>
                                </ul>
                            </div>
                            
                            <div class="col-md-3">
                               
                            	<ul>
                                <li><span class="glyphicon glyphicon-tags" aria-hidden="true"> </span>  
                                    <span>
                                       <strong>Address: </strong>
                                       <?php echo $vendor_store_address?><br/>
                                       <?php echo $post_code;?><br/>
                                       <?php echo $surburb_name;?>
                                    </span>
                                </li>
                            </div>
                            
                        
                            <div class="col-md-4">
                                <div class="clearfix" style="float:right;">
                                    <p> SHARE </p>
                                    <div class="socialIcon"> 
                                        <a href="#" onclick="facebook_share('<?php echo $vendor_store_name;?>', '<?php echo $tiny_url;?>', '<?php echo $image;?>')"> <i class="fa fa-facebook"></i></a> 
                                        <a target="_blank" href="https://twitter.com/intent/tweet?screen_name=Instorelook&text=Shop%20at%20<?php echo $vendor_store_name;?>%20and%20lots%20more%20on%20www.instorelook.com.au%20<?php echo $tiny_url; ?>"> <i class="fa fa-twitter"></i></a> 
                                        <!--<a href="#"> <i class="fa fa-google-plus"></i></a> 
                                        <a href="#"> <i class="fa fa-pinterest"></i></a> -->
                                    </div>
                                </div>
                                <!--/.product-share--> 
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="row">
                	<div class="col-md-12">
                        <div class="short-description">
                            <p><?php echo $vendor_store_summary;?></p>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
      
  	</div>
  	<!--end of right column-->
 	
  </div>
                
                <div class="row">
                	<div class="col-md-12">
                    	<div id="map_canvas" style="width: 100%; height:400px"></div>
                    </div>
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
<script type="text/javascript"   src="http://maps.google.com/maps/api/js?sensor=false"> </script>

<script type="text/javascript">
$(document).ready(function() {
	initialize()
});
  function initialize() {
    var position = new google.maps.LatLng('<?php echo $latitude ?>', '<?php echo $longitude ?>');
	 <!-- var position = new google.maps.LatLng(latitude, longitude);-->
    var myOptions = {
      zoom: 18,
      center: position,
      mapTypeId: google.maps.MapTypeId.ROADMAP
	//mapTypeId: google.maps.MapTypeId.HYBRID
    };
    var map = new google.maps.Map(
        document.getElementById("map_canvas"),
        myOptions);
 
    var marker = new google.maps.Marker({
        position: position,
        map: map,
        title:"<?php echo $surburb_name;?>"
    });  
 
    var contentString = '<br/><span itemprop="streetAddress"><?php echo $surburb_name;?></span>, <span itemprop="addressLocality"><?php echo $vendor_store_name;?></span>';
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });
       infowindow.open(map,marker);
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map,marker);
    });
 
  }
 
</script>