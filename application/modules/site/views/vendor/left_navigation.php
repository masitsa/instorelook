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
                    
					


					<!-- <div class="widget">
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
				</div> -->
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