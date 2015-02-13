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
                <div class="aside">
                    <div class="widget">
						<h3 class="widget-title">Location</h3>
						<div class="widget-body">
							<ul class="list-unstyled">
                                <li>
                                    <div class="input-group">
                                        <div id="the-basics">
                                            <input class="typeahead" type="text" placeholder="Search Surburb">
                                        </div>
                                        <span class="input-group-btn">
                                        	<button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                        </span>
                                    </div>
                                </li>
							<?php
								if($states->num_rows() > 0)
								{
									$states_result = $states->result();
									
									foreach($states_result as $sel)
									{
										$state_name = $sel->state_name;
										$state_id = $sel->state_id;
										
										echo 
										'
                                            <li>
												<input type="checkbox" name="state[]" value="'.$state_id.'" id="state'.$state_id.'"/>
                                                <label for="brand'.$state_id.'"><span></span> '.$state_name.'</label>
                                            </li>
							
										';
									}
								}
								
								else
								{
									echo '<p>There are no locations :-(</p>';
								}
							?>
							</ul>
						</div>
					</div> <!-- states widget -->
                    
					<div class="widget">
						<h3 class="widget-title">Top Sellers</h3>
						<div class="widget-body">
							<ul class="list-unstyled">
							<?php
								if($top_sellers->num_rows() > 0)
								{
									$top_sellers_result = $top_sellers->result();
									
									foreach($top_sellers_result as $sel)
									{
										$vendor_store_name = $sel->vendor_store_name;
										$vendor_id = $sel->vendor_id;
										
										echo 
										'
                                            <li>
												<input type="checkbox" name="vendor[]" value="'.$vendor_id.'" id="vendor'.$vendor_id.'"/>
                                                <label for="vendor'.$vendor_id.'"><span></span> '.$vendor_store_name.'</label>
                                            </li>
							
										';
									}
								}
								
								else
								{
									echo '<p>There are no top sellers :-(</p>';
								}
							?>
								<!--<li>
									<input type="checkbox" value="beige" id="colors-beige" name="colors">
									<label for="colors-beige"><span></span> Beige <span>(35)</span></label>
								</li>
								<li>
									<input type="checkbox" value="blue" id="colors-blue" name="colors">
									<label for="colors-blue"><span></span> Blue <span>(256)</span></label>
								</li>
								<li>
									<input type="checkbox" value="cream" id="colors-cream" name="colors">
									<label for="colors-cream"><span></span> Cream <span>(15)</span></label>
								</li>
								<li>
									<input type="checkbox" value="green" id="colors-green" name="colors">
									<label for="colors-green"><span></span> Green <span>(85)</span></label>
								</li>
								<li>
									<input type="checkbox" value="multi" id="colors-multi" name="colors">
									<label for="colors-multi"><span></span> Multi <span>(99)</span></label>
								</li>
								<li>
									<input type="checkbox" value="orange" id="colors-orange" name="colors">
									<label for="colors-orange"><span></span> Orange <span>(358)</span></label>
								</li>
								<li>
									<input type="checkbox" value="purple" id="colors-purple" name="colors">
									<label for="colors-purple"><span></span> Purple <span>(74)</span></label>
								</li>
								<li>
									<input type="checkbox" value="silver" id="colors-silver" name="colors">
									<label for="colors-silver"><span></span> Silver <span>(33)</span></label>
								</li>
								<li>
									<input type="checkbox" value="white" id="colors-white" name="colors">
									<label for="colors-white"><span></span> White <span>(789)</span></label>
								</li>-->
							</ul>
						</div>
					</div> <!-- colors widget -->
                    
					<div class="widget">
						<h3 class="widget-title">Brands</h3>
						<div class="widget-body">
							<ul class="list-unstyled">
							<?php
								if($brands->num_rows() > 0)
								{
									$brands_result = $brands->result();
									
									foreach($brands_result as $brand)
									{
										$brand_name = $brand->brand_name;
										$brand_id = $brand->brand_id;
										
										echo 
										'
                                            <li>
												<input type="checkbox" name="brand[]" value="'.$brand_id.'" id="brand'.$brand_id.'"/>
                                                <label for="brand'.$brand_id.'"><span></span> '.$brand_name.'</label>
                                            </li>
							
										';
									}
								}
								
								else
								{
									echo '<p>There are no brands</p>';
								}
							?>
							</ul>
						</div>
					</div> <!-- brands widget -->

					<div class="widget">
						<h3 class="widget-title">Price Range</h3>
						<div class="widget-body">
							<div class="price-filter">
								
                                <div class="price-box">

                                    <form class="form-horizontal form-pricing" role="form">
                            
                                      <div class="price-slider">
                                        <p>Between</p>
                                        <div class="col-sm-12 slide-price">
                                          <div id="slider"></div>
                                        </div>
                                         <input type="hidden" id="amount" class="form-control">
                                      </div>
                                      <div class="price-slider">
                                        <p>and</p>
                                        <div class="col-sm-12 slide-price">
                                          <div id="slider2"></div>
                                        </div>
                                        <input type="hidden" id="duration" class="form-control">
                                      </div>
                                      
                                      <button type="button" class="btn btn-primary" style="width:80%;">Filter</button>
                            
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
                            
                                    </form>
                            
                                  </div>
                                
								<div class="clearfix"></div>
							</div>
						</div>
					</div> <!-- price range widget -->

					<div class="widget">
						<h3 class="widget-title">Best Sellers</h3>
						<div class="widget-body">
							<div class="beta-sales beta-lists">
                            
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
										$product_name = $prods->product_name;
										$brand_name = $prods->brand_name;
										$product_price = $prods->product_selling_price;
										$description = $prods->product_description;
										$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
										$price = number_format($product_price, 2, '.', ',');
										$sale = '';
										$count++;
										
										echo 
										'
										<div class="media beta-sales-item">
                                            <a href="'.site_url().'products/view-product/'.$product_id.'" class="pull-left"><img alt="" src="'.base_url().'assets/images/products/images/'.$thumb.'"></a>
                                            <div class="media-body">
                                                '.$brand_name.'
                                                <span class="beta-sales-price">$'.$price.'</span>
                                            </div>
                                        </div>
										';
									}
								}
								
								else
								{
									echo '<p>No products have been added yet :-(</p>';
								}
							?>
							</div>
						</div>
					</div> <!-- best sellers widget -->

					<!--<div class="widget">
						<h3 class="widget-title">Twitter Feeds</h3>
						<div class="widget-body">
							<div class="twitter-feed beta-lists">
								<div class="tweet">
									<i class="fa fa-twitter"></i>
									<div class="tweet-body">
										<p><a href="#">@ShopaHolic</a> Proin feugiat mattis ante sed adipiscing velit sodales.</p>
										<small class="tweet-time">25 Minutes ago</small>
									</div>
								</div>
								<div class="tweet">
									<i class="fa fa-twitter"></i>
									<div class="tweet-body">
										<p>Proin feugiat mattis ante sed adipiscing velit sodales. <a href="#">http://shopaholic.com</a></p>
										<small class="tweet-time">25 Minutes ago</small>
									</div>
								</div>
							</div>
						</div>
					</div>--> <!-- twitter feeds widget -->

					<div class="widget">
						<h3 class="widget-title">Tags</h3>
						<div class="widget-body">
							<div class="beta-tags">
								<a href="blog_fullwidth_2col.html">Amazing</a>
								<a href="blog_fullwidth_2col.html">Shop</a>
								<a href="blog_fullwidth_2col.html">Themes</a>
								<a href="blog_fullwidth_2col.html">Clean</a>
								<a href="blog_fullwidth_2col.html">Responsiveness</a>
								<a href="blog_fullwidth_2col.html">Multipurpose</a>
								<a href="blog_fullwidth_2col.html">Creative</a>
								<a href="blog_fullwidth_2col.html">Brands</a>
								<a href="blog_fullwidth_2col.html">Categories</a>
							</div>
						</div>
					</div> <!-- tags cloud widget -->
				</div>
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