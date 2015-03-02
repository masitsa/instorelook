<?php
if($vendor_subscription->num_rows() > 0)
{
	
	$subscription = $vendor_subscription->row();
	$subscription_name = $subscription->subscription_name;
?>

    <div class="row">
        <div class="col-md-12">
        	<div class="center-align">
                <p>You are currently subscribed to the <span class="blue-text"><?php echo $subscription_name?></span> plan</p>
            </div>
            <!--<div class="center-align">
                <p>You are currently subscribed to the <span class="blue"><?php echo $subscription_name?></span> plan</p>
            
            	<a href="<?php echo site_url().'manage-categories'?>" class="btn btn-danger">Subscribe to categories</a>
            	<a href="<?php echo site_url().'change-subscription'?>" class="btn btn-primary">Change subscription</a>
            </div>-->
            
            <div class="row">
            	<!-- Subscribe -->
            	<div class="col-md-6">
                	<p class="center-align">You can manage your categories here</p>
                	<?php
                    	$attributes = array(
										'class' => 'form-horizontal',
										'role' => 'form',
									);
						echo form_open('vendor/update-categories', $attributes);
					?>
                    	<div class="row">
                        	
                        	<div class="col-md-12">
                                
                                <div class="form-group multiselect_items">
                                    <label for="categories" class="col-sm-4 control-label">Store Categories</label>
                                    <div class="col-sm-8">
                                        <select type="text" class="form-control multiselect multiselect-icon" multiple="multiple" role="multiselect" name="categories[]">
                                        	<?php
                                            if($categories->num_rows() > 0)
											{
												foreach($categories->result() as $cat)
												{
													$selected = '';
													if($vendor_categories->num_rows() > 0)
													{
														foreach($vendor_categories->result() as $cat2)
														{
															$subscribed_category = $cat2->category_id;
															
															if($subscribed_category == $cat->category_id)
															{
																$selected = 'selected';
																break;
															}
														}
														echo '<option value="'.$cat->category_id.'" '.$selected.'>'.$cat->category_name.'</option>';
													}
													else
													{
														echo '<option value="'.$cat->category_id.'">'.$cat->category_name.'</option>';
													}
												}
											}
											?>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row center-align">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-red">Subscribe</button>
                            </div>
                        </div>
                    <?php echo form_close();?>
                </div>
                <!-- End subscribe -->
                
                <!-- Change subscription -->
                <div class="col-md-6">
                	<div class="center-align">
                    	<p>You can change your subscription plan here</p>
                        <a href="<?php echo site_url().'vendor/change-subscription'?>" class="btn btn-primary">Change subscription</a>
                    </div>
                </div>
                <!-- End change subscription -->
            </div>
            
            <div class="subscribe">
            	<h5>About the <?php echo $subscription_name?> plan</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam egestas blandit dignissim. Aenean maximus ornare sem, et commodo risus tempor sed. Maecenas id purus diam. Pellentesque pellentesque massa leo, eu consectetur nulla consequat id. Quisque ut eros vitae dui consequat sodales. Aenean metus velit, fringilla sit amet nisl quis, pharetra tincidunt purus. Nam egestas volutpat lectus. Morbi libero diam, pulvinar id ipsum a, feugiat gravida metus. Mauris non est sed mi laoreet aliquam eget quis dui. Aliquam auctor massa eu rhoncus tempor. In euismod, nisl ut aliquet commodo, nibh orci eleifend quam, et interdum neque eros a purus. Proin rhoncus congue lorem, vel mollis tellus mattis at.</p>
                
                <p>Integer egestas nulla nec arcu ornare dignissim. Ut eget odio eu risus dapibus fermentum nec quis quam. Cras nisi quam, tincidunt non sodales pharetra, rhoncus ut eros. Nulla mollis aliquet urna. Vestibulum metus nulla, pretium id placerat ac, mattis at metus. Aenean lacus enim, tincidunt a euismod nec, viverra id ex. Ut vehicula est non fermentum sollicitudin. Donec id sagittis justo. Quisque non nisi sodales, tempus lorem sed, gravida purus. Suspendisse quis nulla sagittis, placerat orci id, ornare nulla. Fusce consequat placerat pharetra. Curabitur ornare magna sed nulla pharetra, at volutpat nulla lacinia. Curabitur placerat eros tortor, id ultrices justo fringilla elementum. Etiam et ultrices leo.</p>
            </div>
        </div>
    </div>

<?php
}

else
{
?>
	<div class="row">
        <div class="col-md-12">
            <p>You have no subscription. Please contact the website administrator</p>
        </div>
    </div>
<?php
}
?>
<?php echo $this->load->view('vendor/multiselect_js');?>