<?php
$popular = $this->products_model->get_popular_products();
$top_sellers = $this->products_model->get_top_sellers();
$states = $this->site_model->get_states();

//if there are no sellers
if($top_sellers->num_rows() == 0)
{
	$top_sellers = $this->products_model->get_top_sellers2();
}
?>
<div class="panel-group" id="accordionNo">
	
    <!-- Postcode --> 
    <div class="panel panel-default">
		<div class="panel-heading">
            <a data-toggle="collapse"  href="#collapse-location" class="collapseWill"> 
                <h4 class="panel-title"> 
                    <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Location 
                </h4>
            </a>
		</div>
        
        <div id="collapse-location" class="panel-collapse collapse in">
            <div class="panel-body">
				<!-- Panel content -->
				<ul class="list-unstyled">
				<?php 
				echo form_open('products/filter-postcode', array('class' => 'form-horizontal', 'role' => 'form'));
				echo form_hidden('post_brands', $filter_brands);
				echo form_hidden('post_businesses', $filter_businesses);
				echo form_hidden('category_w_name', $category_w_name);
				echo form_hidden('post_price_range', $filter_price_range);
				?>
                    <li>
                        <input class="form-control" type="text" placeholder="Search post code" name="search_item">
                        <div class="center-align" style="margin-top:10px;">
                            <button type="submit" class="control-form col-md-12 col-sm-12 col-lg-12 btn btn-primary">Filter post code</button>
                        </div>
                    </li>
                <?php
                echo form_close();
                
				/*echo form_open('products/filter-locations');
				echo form_hidden('post_brands', $filter_brands);
				echo form_hidden('post_businesses', $filter_businesses);
				echo form_hidden('category_w_name', $category_w_name);
				echo form_hidden('post_price_range', $filter_price_range);
				
				if($states->num_rows() > 0)
				{
					$states_result = $states->result();
					
					foreach($states_result as $sel)
					{
						$state_name = $sel->state_name;
						$state_id = $sel->state_id;
						$state_abbr = $sel->state_abbr;
						
						if(is_array($locations_array))
						{
							$total_locations = count($locations_array);
							$checked = '';
							
							for($r = 0; $r < $total_locations; $r++)
							{
								if($locations_array[$r] == $state_abbr)
								{
									$checked = 'checked = "checked"';
									break;
								}
							}
						
							echo 
							'
								<li>
									<input type="checkbox" name="state_abbr[]" value="'.$state_abbr.'" id="state_abbr'.$state_id.'" '.$checked.'/>
									<label for="state_abbr'.$state_id.'"><span></span> '.$state_name.'</label>
								</li>
				
							';
						}
						
						else
						{
						
							echo 
							'
								<li>
									<input type="checkbox" name="state_abbr[]" value="'.$state_abbr.'" id="state_abbr'.$state_id.'"/>
									<label for="state_abbr'.$state_id.'"><span></span> '.$state_name.'</label>
								</li>
				
							';
						}
					}
					
					echo 
					'
						<div class="center-align">
							<button type="submit" class="control-form col-md-12 btn btn-primary">Filter Surburb</button>
						</div>
					';
				}
				
				else
				{
					echo '<p>There are no locations :-(</p>';
				}
				echo form_close();*/
                ?>
                </ul>
				<!-- End panel content -->
			</div>
		</div>
	</div> <!-- End postcode --> 
	
    <!-- sellers --> 
    <div class="panel panel-default">
		<div class="panel-heading">
            <a data-toggle="collapse"  href="#collapse-latest-sellers" class="collapseWill"> 
                <h4 class="panel-title"> 
                    <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Latest sellers
                </h4>
            </a> 
		</div>
        
        <div id="collapse-latest-sellers" class="panel-collapse collapse in">
            <div class="panel-body">
				<!-- Panel content -->
				<ul class="list-unstyled">
				<?php
                    echo form_open('products/filter-businesses');
                    echo form_hidden('post_brands', $filter_brands);
                    echo form_hidden('post_locations', $filter_locations);
                    echo form_hidden('category_w_name', $category_w_name);
                    echo form_hidden('post_price_range', $filter_price_range);
                    
                    if($top_sellers->num_rows() > 0)
                    {
                        $top_sellers_result = $top_sellers->result();
                        
                        foreach($top_sellers_result as $sel)
                        {
                            $vendor_store_name = $sel->vendor_store_name;
                            $vendor_id = $sel->vendor_id;
                            $web_name = $this->site_model->create_web_name($vendor_store_name);
                            //var_dump($filter_businesses);
                            if(is_array($businesses_array))
                            {
                                $total_businesses = count($businesses_array);
                                $checked = '';
                                
                                for($r = 0; $r < $total_businesses; $r++)
                                {
                                    if($businesses_array[$r] == $web_name)
                                    {
                                        $checked = 'checked = "checked"';
                                        break;
                                    }
                                }
                            
                                echo 
                                '
                                    <li>
                                        <input type="checkbox" name="vendor_store_name[]" value="'.$web_name.'" id="vendor_store_name'.$vendor_id.'" '.$checked.'/>
                                        <label for="vendor_store_name'.$vendor_id.'"><span></span> '.$vendor_store_name.'</label>
                                    </li>
                    
                                ';
                            }
                            
                            else
                            {
                                echo 
                                '
                                    <li>
                                        <input type="checkbox" name="vendor_store_name[]" value="'.$web_name.'" id="vendor_store_name'.$vendor_id.'"/>
                                        <label for="vendor_store_name'.$vendor_id.'"><span></span> '.$vendor_store_name.'</label>
                                    </li>
                    
                                ';
                            }
                        }
                        
                        echo 
                        '
                            <div class="center-align">
                                <button type="submit" class="control-form col-md-12 col-sm-12 col-lg-12 btn btn-primary">Filter latest sellers</button>
                            </div>
                        ';
                    }
                    
                    else
                    {
                        echo '<p>There are no top sellers :-(</p>';
                    }
                    echo form_close();
                ?>
                </ul>
				<!-- End panel content -->
			</div>
		</div>
	</div> <!-- End sellers --> 
	
    <!-- brands --> 
    <div class="panel panel-default">
		<div class="panel-heading">
            <a data-toggle="collapse"  href="#collapse-brands" class="collapseWill"> 
                <h4 class="panel-title"> 
                    <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Brands
                </h4>
            </a>
		</div>
        
        <div id="collapse-brands" class="panel-collapse collapse in">
            <div class="panel-body">
				<!-- Panel content -->
				<ul class="list-unstyled">
				<?php
                    echo form_open('products/filter-brands');
                    echo form_hidden('post_businesses', $filter_businesses);
                    echo form_hidden('post_locations', $filter_locations);
                    echo form_hidden('category_w_name', $category_w_name);
                    echo form_hidden('post_price_range', $filter_price_range);
                    
                    if($brands->num_rows() > 0)
                    {
                        $brands_result = $brands->result();
                        
                        foreach($brands_result as $brand)
                        {
                            $brand_name = $brand->brand_name;
                            $brand_id = $brand->brand_id;
                            $web_name = $this->site_model->create_web_name($brand_name);
                            
                            if(is_array($brands_array))
                            {
                                $total_brands = count($brands_array);
                                $checked = '';
                                
                                for($r = 0; $r < $total_brands; $r++)
                                {
                                    if($brands_array[$r] == $web_name)
                                    {
                                        $checked = 'checked = "checked"';
                                        break;
                                    }
                                }
                            
                                echo 
                                '
                                    <li>
                                        <input type="checkbox" name="brand_name[]" value="'.$web_name.'" id="brand_name'.$brand_id.'" '.$checked.'/>
                                        <label for="brand_name'.$brand_id.'"><span></span> '.$brand_name.'</label>
                                    </li>
                    
                                ';
                            }
                            
                            else
                            {
                                echo 
                                '
                                    <li>
                                        <input type="checkbox" name="brand_name[]" value="'.$web_name.'" id="brand_name'.$brand_id.'"/>
                                        <label for="brand_name'.$brand_id.'"><span></span> '.$brand_name.'</label>
                                    </li>
                    
                                ';
                            }
                        }
                        
                        echo 
                        '
                            <div class="center-align" style="width:100%;">
                                <button type="submit" class="control-form col-md-12 col-sm-12 col-lg-12 btn btn-primary">Filter brand</button>
                            </div>
                        ';
                    }
                    
                    else
                    {
                        echo '<p>There are no brands</p>';
                    }
                    echo form_close();
                ?>
                </ul>
				<!-- End panel content -->
			</div>
		</div>
	</div> <!-- End brands --> 
	
    <!-- price range --> 
    <div class="panel panel-default">
		<div class="panel-heading">
            <a data-toggle="collapse"  href="#collapse-price-range" class="collapseWill"> 
                <h4 class="panel-title"> 
                    <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Price range
                </h4>
            </a> 
		</div>
        
        <div id="collapse-price-range" class="panel-collapse collapse in">
            <div class="panel-body">
				<!-- Panel content -->

				<?php 
                echo form_open('products/filter-price', array('class' => 'form-horizontal', 'role' => 'form'));
                echo form_hidden('post_brands', $filter_brands);
                echo form_hidden('post_businesses', $filter_businesses);
                echo form_hidden('post_locations', $filter_locations);
                echo form_hidden('category_w_name', $category_w_name);
                ?>
				<div class="price-filter">
								
                    <div class="price-box">
                          <div class="price-slider">
                            <p>Between</p>
                            <div class="col-sm-12 slide-price">
                              <div id="slider"></div>
                            </div>
                             <input type="hidden" id="amount" name="low_price" class="form-control">
                          </div>
                          <div class="price-slider">
                            <p>and</p>
                            <div class="col-sm-12 slide-price">
                              <div id="slider2"></div>
                            </div>
                            <input type="hidden" id="duration" name="high_price" class="form-control">
                          </div>
                          <!--<div class="price-form">
                            <div class="row">
                                <div class="col-md-6">
                                    Between
                                    <p class="price lead" id="amount-label"></p>
                                    <span class="price">.00</span>
                                </div>
                                
                                <div class="col-md-6">
                                    & 
                                    <p class="price lead" id="duration-label"></p>
                                    <span class="price">.00</span>
                                </div>
                            </div>
                
                          </div>
                
                          <div class="form-group">
                            <div class="col-sm-12">
                              <button type="submit" class="btn btn-primary btn-lg btn-block">Proceed <span class="glyphicon glyphicon-chevron-right pull-right" style="padding-right: 10px;"></span></button>
                            </div>
                          </div>-->
                
                      </div>
                    
                    <div class="clearfix"></div>
                </div>
                <div class="clear-both"></div>
                <div class="center-align" style="width:100%;">
                    <button type="submit" class="control-form col-md-12 col-sm-12 col-lg-12 btn btn-primary">Filter price</button>
                </div>
                
				<?php echo form_close(); ?>
				<!-- End panel content -->
			</div>
		</div>
	</div> <!-- End price range --> 
	
    <!-- best sellers --> 
    <div class="panel panel-default">
		<div class="panel-heading">
            <a data-toggle="collapse"  href="#collapse-best-sellers" class="collapseWill"> 
                <h4 class="panel-title"> 
                    <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Best sellers
                </h4>
            </a>
		</div>
        
        <div id="collapse-best-sellers" class="panel-collapse collapse in">
            <div class="panel-body">
				<!-- Panel content -->
				<ul class="best-sellers">
				<?php
                if($popular->num_rows() > 0)
                {
                    $popular_products = $popular->result();
                    $count = 0;
                    
                    foreach($popular_products as $prods)
                    {
                        $sale_price = $prods->sale_price;
                        $thumb = $prods->product_image_name;
                        $product_id = $prods->product_id;
                        $product_code = $prods->product_code;
                        $product_name = $prods->product_name;
                        $brand_name = $prods->brand_name;
                        $product_price = $prods->product_selling_price;
                        $description = $prods->product_description;
                        $mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
                        $price = number_format($product_price, 2, '.', ',');
                        $sale = '';
                        $image = $this->products_model->image_display($products_path, $products_location, $thumb);
                        $count++;
                        
                        echo 
                        '
                        <li>
                            <a class="cbp-vm-image" href="'.site_url().'products/view-product/'.$product_code.'"><img src="'.$image.'"></a>
                            <h3 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_code.'">'.$brand_name.'</a></h3>
                            <h6 class="cbp-vm-title"><a href="'.site_url().'products/view-product/'.$product_code.'">'.$product_name.'</a></h6>
                            <div class="cbp-vm-price">$'.$price.'</div>
                        </li>
                                                            ';
                    }
                }
                
                else
                {
                    echo '<p>No products have been added yet :-(</p>';
                }
            ?>
            </ul>
				<!-- End panel content -->
			</div>
		</div>
	</div> <!-- best sellers --> 
    
</div><!-- End panel group -->

<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>           
<script type="text/javascript">
	$(document).ready(function() {
          $("#slider").slider({
              animate: true,
              value:1,
              min: 0,
              max: 1000,
              step: 10,
              slide: function(event, ui) {
                  update(1,ui.value); //changed
              }
          });

          $("#slider2").slider({
              animate: true,
              value:0,
              min: 0,
              max: 500,
              step: 1,
              slide: function(event, ui) {
                  update(2,ui.value); //changed
              }
          });

          //Added, set initial value.
          $("#amount").val(0);
          $("#duration").val(0);
          $("#amount-label").text(0);
          $("#duration-label").text(0);
          
          update();
      });

      //changed. now with parameter
      function update(slider,val) {
        //changed. Now, directly take value from ui.value. if not set (initial, will use current value.)
        var $amount = slider == 1?val:$("#amount").val();
        var $duration = slider == 2?val:$("#duration").val();

        /* commented
        $amount = $( "#slider" ).slider( "value" );
        $duration = $( "#slider2" ).slider( "value" );
         */

         $total = "$" + ($amount * $duration);
         $( "#amount" ).val($amount);
         $( "#amount-label" ).text($amount);
         $( "#duration" ).val($duration);
         $( "#duration-label" ).text($duration);
         $( "#total" ).val($total);
         $( "#total-label" ).text($total);

         $('#slider a').html('<label><span class="glyphicon glyphicon-chevron-left"></span> '+$amount+' <span class="glyphicon glyphicon-chevron-right"></span></label>');
         $('#slider2 a').html('<label><span class="glyphicon glyphicon-chevron-left"></span> '+$duration+' <span class="glyphicon glyphicon-chevron-right"></span></label>');
      }
</script>