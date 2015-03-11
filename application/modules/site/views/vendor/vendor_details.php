<?php
	$vend = $vendor_details->result();
	//the product details
	

	$vendor_id = $vend[0]->vendor_id;
	$vendor_logo = $vend[0]->vendor_logo;
	$vendor_first_name = $vend[0]->vendor_first_name;
	$vendor_last_name = $vend[0]->vendor_last_name;
	$surburb_id = $vend[0]->surburb_id;
	$surburb_name = $vend[0]->surburb_name;

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
<!-- styles needed by smoothproducts.js for product zoom  -->
<link rel="stylesheet" href="<?php echo base_url()."assets/themes/tshop/";?>css/smoothproducts.css">


<div class="container main-container headerOffset">
  
  <?php echo $this->load->view('vendor/breadcrumbs');?>
  
  <div class="row transitionfx">
  <div class="product-info">
   <!-- left column -->

    <div class="col-lg-4 col-md-4 col-sm-4">

    	<div class="product-images">
    			<h4>Vendor Logo</h4>
                <div class="box">
                   	<div id="main">
						<div id="gallery">
							<img src="<?php echo $image;?>">
							
						</div>
					</div>

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
    		<h4>Vendor details</h4>
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
								<h6><?php echo $surburb_name;?>, Australia</h6>
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

                                    <div class="categories">
                                       <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>  <span><a href="" title=""> </a></span>, <a href="" title=""></a>
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