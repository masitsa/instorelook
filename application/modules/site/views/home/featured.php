

<div class="container main-container"> 
  
  	<!-- Main component call to action -->
  
    <div class="morePost row featuredPostContainer style2 globalPaddingTop " >
        <h3 class="section-title style2 text-center"><span>FEATURED PRODUCT</span></h3>
        <div class="container">
        	<div class="row xsResponse">
            
			<?php
                if($featured->num_rows() > 0)
                {
                    $featured_products = $featured->result();
                    
                    foreach($featured_products as $prods)
                    {
                        $sale_price = $prods->sale_price;
                        $thumb = $prods->product_image_name;
                        $product_id = $prods->product_id;
                        $product_name = $prods->product_name;
                        $product_price = $prods->product_selling_price;
                        $description = $prods->product_description;
                        $mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
                        $price = number_format($product_price, 2, '.', ',');
                        $sale = '';
                        
                        if($sale_price > 0)
                        {
                            $sale = '<div class="promotion"> <span class="discount">'.$sale_price.'% OFF</span> </div>';
                        }
                        
                        echo 
                        '
                        <div class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                            <div class="product">
                                <div class="image"> 
                                    <a href="'.site_url().'products/view-product/'.$product_id.'"><img src="'.base_url().'assets/images/products/images/'.$thumb.'" alt="'.$product_name.'" class="img-responsive"></a>
                                    
                                    '.$sale.'
                                </div>
                                <div class="description">
                                    <h4><a href="#">'.$product_name.'</a></h4>
                                    <p>'.$mini_desc.'</p>
                                    <span class="size">XL / XXL / S </span> 
                                </div>
                                <div class="price"> <span>KES '.$price.'</span> </div>
                                <div class="action-control"> <a class="btn btn-primary add_to_cart" href="'.$product_id.'"> <span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Add to cart </span> </a> </div>
                            </div>
                        </div>
                        ';
                    }
                }
                
                else
                {
                    echo '<p>There are no :-(</p>';
                }
            ?>
            </div>
            <!-- /.row --> 
      
            <div class="row">
                <div class="load-more-block text-center">
                    <a class="btn btn-thin" href="<?php echo site_url().'products/all-products';?>">
                    <i class="fa fa-plus-sign">+</i>  load more products</a>
                </div>
            </div>
      
      
        </div>
        <!--/.container--> 
    </div>
    <!--/.featuredPostContainer-->
        
    <!-- Categories -->
    <?php //echo $this->load->view('home/categories', '', TRUE); ?>
    
    <!-- Brands -->
    <?php echo $this->load->view('home/brands', '', TRUE); ?>
</div>
<!--main-container-->