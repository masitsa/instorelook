<div class="container main-container headerOffset"> 
  
  <?php echo $this->load->view('products/breadcrumbs');?>
  
  <div class="row">
  
	<!--left column-->
	<div class="col-lg-3 col-md-3 col-sm-12">
  		<?php //echo $this->load->view('products/left_navigation');?>
        <?php echo $this->load->view('home/home_left_navigation');?>
    </div>
    
    <!--right column-->
    <div class="col-lg-9 col-md-9 col-sm-12 product-content">

  	  
      
      <div class="row category-product">
      	
        <div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid">
        	<?php echo $this->load->view('products/top_navigation');?>
            <ul>
            	<?php
        	if($products->num_rows() > 0)
			{
				$product = $products->result();
				
				foreach($product as $prods)
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
					$image = $this->products_model->image_display($products_path, $products_location, $thumb);
					$sale = '';
					
					if($sale_price > 0)
					{
						$sale = '<div class="promotion"> <span class="discount">'.$sale_price.'% OFF</span> </div><div class="clear-both"></div>';
					}
					
					echo
					'
					<li>
						<a class="cbp-vm-image" href="'.site_url().'products/view-product/'.$product_id.'"><img src="'.$image.'"></a>
						<h3 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_id.'">'.$brand_name.'</a></h3>
						<h6 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_id.'">'.$product_name.'</a></h6>
						<div class="cbp-vm-price">$'.$price.'</div>
						<a class="cbp-vm-icon cbp-vm-add add_to_wishlist" href="'.$product_id.'" product_id="'.$product_id.'" data-toggle="modal" data-target=".wishlist-modal"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span></a>
						<a class="cbp-vm-icon cbp-vm-add add_to_cart" href="'.$product_id.'" product_id="'.$product_id.'"><i class="glyphicon glyphicon-shopping-cart"> </i></a>
						<a class="beta-btn primary" href="'.site_url().'products/view-product/'.$product_id.'">Details <i class="glyphicon glyphicon-chevron-right"></i></a>
					</li>
					';
				}
			}
			
			else
			{
				echo 'There are no products :-(';
			}
		?>
            </ul>
        </div>
			
      	
    </div> <!--/.categoryProduct || product content end-->
      
      <div class="w100 categoryFooter">
        <div class="pagination pull-left no-margin-top">
          <?php if(isset($links)){echo $links;}?>
        </div>
      </div> <!--/.categoryFooter-->
   
    </div><!--/right column end-->
  </div><!-- /.row  --> 
</div>
<!-- /main container -->

<div class="gap"> </div>
<script type="text/javascript">
//Sort Products
$(document).on("change","select#sort_products",function()
{
	var order_by = $('#sort_products :selected').val();
	
	window.location.href = '<?php echo site_url();?>products/sort-by/'+order_by;
});
</script>
