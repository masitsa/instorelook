<div class="container main-container headerOffset"> 
  
  <?php echo $this->load->view('products/breadcrumbs');?>
  
  <div class="row">
  
	<!--left column-->
	<div class="col-lg-3 col-md-3 col-sm-12">
  		<?php echo $this->load->view('products/left_navigation');?>
    </div>
    
    <!--right column-->
    <div class="col-lg-9 col-md-9 col-sm-12 product-content">

  	  <?php echo $this->load->view('products/top_navigation');?>
      
      <?php
      /*if($product_sub_categories->num_rows() > 0)
	  {
		  ?>
          <div class="row subCategoryList clearfix">
		  <?php
		  $sub_categories = $product_sub_categories->result();
		  
		  foreach($sub_categories as $sub)
		  {
			  $category_image = $sub->category_image_name;
			  $category_id = $sub->category_id;
			  $category_name = $sub->category_name;
			  
			  if(!empty($category_image))
			  {
				  $image = base_url().'assets/images/categories/thumbnail_'.$category_image;
			  }
			  
			  else
			  {
				  $image = '';
			  }
			  
			  echo '
			  	<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4  text-center ">
				  <div class="thumbnail equalheight"> <a class="subCategoryThumb" href="'.site_url().'products/category/'.$category_id.'"><img src="'.$image.'" class="img-rounded " alt="'.$category_name.'"> </a> <a  class="subCategoryTitle"><span> '.$category_name.' </span></a></div>
				</div>
			  ';
		  }
		  ?>
		  </div><!--/.subCategoryList-->
		  <?php
	  }*/
	  ?>
      
      <div class="row category-product">
      
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
					$sale = '';
					
					if($sale_price > 0)
					{
						$sale = '<div class="promotion"> <span class="discount">'.$sale_price.'% OFF</span> </div><div class="clear-both"></div>';
					}
					
					echo
					'
					<div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
						<div class="product">
							<div class="image"> <a href="'.site_url().'products/view-product/'.$product_id.'"><img src="'.base_url().'assets/images/products/images/'.$thumb.'" alt="img" class="img-responsive"></a>
								'.$sale.'
							</div>
							
							<div class="description">
								<h4><a href="'.site_url().'products/view-product/'.$product_id.'">'.$brand_name.'</a></h4>
								<h6><a href="'.site_url().'products/view-product/'.$product_id.'">'.$product_name.'</a></h6>
								<!-- <span class="size">XL / XXL / S </span> -->
							</div>
							
							<div class="price-details row">
								
								<div class="col-md-3 price-number">
									<p>
										<span class="rupees">$'.$price.'</span>
									</p>
								</div>
								<div class="col-md-9 add-cart">
									<h4>
										<a class="add_to_cart" href="'.$product_id.'" product_id="'.$product_id.'"><i class="glyphicon glyphicon-shopping-cart"> </i></a>
										<a class="product_details" href="'.site_url().'products/view-product/'.$product_id.'">Details >></a>
									</h4>
								</div>
								<div class="clear"></div>
							</div>
							
							<!--<div class="action-control">
								<a class="btn btn-primary add_to_cart" href="'.$product_id.'"> 
									<span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Add to cart </span> 
								</a>
							</div>-->
						</div>
					</div><!--/.item-->
					';
				}
			}
			
			else
			{
				echo 'There are no products :-(';
			}
		?>
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
