<div class="container main-container headerOffset"> 
  
  <?php echo $this->load->view('vendor/breadcrumbs');?>
  
  <div class="row">
  
	<!--left column-->
	<div class="col-lg-3 col-md-3 col-sm-12">
  		<?php echo $this->load->view('vendor/left_navigation');?>
        <?php //echo $this->load->view('home/home_left_navigation');?>
    </div>
    
    <!--right column-->
    <div class="col-lg-9 col-md-9 col-sm-12 product-content">

  	  
      
      <div class="row category-product">
      	
        <div id="cbp-vm" class="cbp-vm-switcher cbp-vm-view-grid">
        	<?php echo $this->load->view('vendor/top_navigation');?>
            <ul>
            	<?php
        	if($vendor->num_rows() > 0)
			{
				$vendor_results = $vendor->result();
				
				foreach($vendor_results as $vend)
				{
					$vendor_id = $vend->vendor_id;
					$vendor_logo = $vend->vendor_logo;
					$vendor_first_name = $vend->vendor_first_name;
					$vendor_last_name = $vend->vendor_last_name;
					$surburb_id = $vend->surburb_id;
					$surburb_name = $vend->surburb_name;
					$name = $vendor_last_name." ".$vendor_first_name;
					 $image = $this->products_model->image_display($vendor_path, $vendor_location, $vendor_logo);
					
					// $sale = '';
					// $button = '';
					// $balance_status = '';
					// if($product_balance == 0)
					// {
					// 	$button = '';
					// 	$balance_status = 'Product out of stock';
					// }
					// else
					// {
					// 	$button = '<a class="cbp-vm-icon cbp-vm-add add_to_cart" href="'.$product_id.'" product_id="'.$product_id.'"><i class="glyphicon glyphicon-shopping-cart"> </i></a>';
					// 	$balance_status = $product_balance.' Available in stock';
					// }
					// if($sale_price > 0)
					// {
					// 	$sale = '<div class="promotion"> <span class="discount">'.$sale_price.'% OFF</span> </div><div class="clear-both"></div>';
					// }
					$vendor_name = $this->vendor_model->get_vendor_name($vendor_id);
					echo
					'
					<li>
						<a class="cbp-vm-image" href="'.site_url().'vendors/'.$vendor_name.'-products/'.$vendor_id.'"><img src="'.$image.'"></a>
						<h3 class="cbp-vm-title">'.$name.'</h3>
						<h6 class="cbp-vm-title">'.$surburb_name.'</h6>
						<a class="btn btn-success" href="'.site_url().'vendor-details/'.$vendor_name.'-profile/'.$vendor_id.'">Info <i class="glyphicon glyphicon-chevron-right"></i></a>

						<a class="btn btn-info" href="'.site_url().'vendors/'.$vendor_name.'-products/'.$vendor_id.'"> Products <i class="glyphicon glyphicon-chevron-right"></i></a>
					</li>
					';
				}
			}
			
			else
			{
				echo 'There are no vendor :-(';
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
//Sort vendor
$(document).on("change","select#sort_vendor",function()
{
	var order_by = $('#sort_vendor :selected').val();
	
	window.location.href = '<?php echo site_url();?>vendor/sort-by/'+order_by;
});
</script>
