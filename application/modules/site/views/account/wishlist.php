<div class="container main-container headerOffset">
  <div class="row">
    <div class="breadcrumbDiv col-lg-12">
      <ul class="breadcrumb">
        <li><a href="<?php echo site_url();?>">Home</a> </li>
        <li><a href="<?php echo site_url().'customer/account';?>">My Account</a> </li>
        <li class="active"> Wishlist </li>
      </ul>
    </div>
  </div> <!--/.row-->
  
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h1 class="section-title-inner"><span><i class="glyphicon glyphicon-heart"></i> Wishlist </span></h1>
      <div class="row userInfo">
        <div class="col-lg-12">
          <h2 class="block-title-2"> Update your wishlist if it has changed. </h2>
        </div>
        <div class="col-xs-12 col-sm-12">
          <table>
            <tbody>
				<?php
					if($wishlist->num_rows() > 0)
					{
						foreach($wishlist->result() as $prods)
						{
							$sale_price = $prods->sale_price;
							$thumb = $prods->product_image_name;
							$product_id = $prods->product_id;
							$wishlist_id = $prods->wishlist_id;
							$product_name = $prods->product_name;
							$brand_name = $prods->brand_name;
							$product_price = $prods->product_selling_price;
							$description = $prods->product_description;
							$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
							$price = number_format($product_price, 2, '.', ',');
							$image = $this->products_model->image_display($products_path, $products_location, $thumb);
							
							echo 
							'
								<tr class="CartProduct">
                                    <td style="width:35%" class="CartProductThumb">
                                    	<div> <a href="'.site_url().'products/view-product/'.$product_id.'"><img src="'.$image.'" alt="'.$product_name.'"></a> </div>
                                    </td>
                                    <td style="width:40%">
                                    	<div class="CartDescription">
                                    		<h4> <a href="'.site_url().'products/view-product/'.$product_id.'">'.$product_name.' </a> </h4>
                                    		<div class="price"> <span>$'.$price.'</span> </div>
                                    	</div>
                                    </td>
                                    <td style="width:15%">
                                        <a class="btn btn-primary add_to_cart" href="'.$product_id.'" product_id="'.$product_id.'"> 
                                        	<span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Add to cart </span> 
                                        </a>
                                    </td>
                                    <td style="width:10%" class="delete">
                                    	<a class="delete_wishlist" title="Delete" href="'.$wishlist_id.'" wishlist_id="'.$wishlist_id.'" onclick="return confirm(\'Do you really want to delete '.$product_name.' from your wishlist?\')"> <i class="glyphicon glyphicon-trash"></i> </a>
                                    </td>
                                </tr>
							';
						}
					}
					else
					{
						echo '<tr class="CartProduct"><td style="width:100%" class="CartProductThumb">There are no products in your wishlist</tr>';
					}
                ?>
              
            </tbody>
          </table>
        </div>
        
        <?php echo $this->load->view('account/navigation', '', TRUE);?>
        
      </div>
      <!--/row end--> 
      
    </div>
    <div class="col-lg-3 col-md-3 col-sm-5"> </div>
  </div>
  <!--/.row-->
  
</div> <!-- /main-container -->