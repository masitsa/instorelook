
        <script type="text/javascript" src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script> 
        <div class="content light-grey-background">
        	<div class="container">
        		<div class="search-flights">
                	<div class="divider-line"></div>
                	<h1 class="center-align"><?php echo $title;?></h1>
                	<div class="divider-line" style="margin-bottom:2%;"></div>
                    
                    <!-- Steps -->
                    <div class="container">
                        <div class="process">
                            <div class="process-row">
                                <div class="process-step">
                                    <button type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-user fa-2x"></i></button>
                                    <p>Personal</p>
                                </div>
                                <div class="process-step">
                                    <button type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-building-o fa-2x"></i></button>
                                    <p>Business</p>
                                </div>
                                 <div class="process-step">
                                    <button type="button" class="btn blue-background btn-circle" disabled="disabled"><i class="fa fa-dollar fa-2x"></i></button>
                                    <p>Subscription</p>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- End: Steps -->
                    
                    <!--Subscription Error -->
                    <?php
                    $error = $this->session->userdata('subscription_error');
					
					if(!empty($error))
					{
						echo '<div class="alert alert-danger center-align">'.$error.'</div>';
						$this->session->unset_userdata('subscription_error');
					}
					?>
                    <!-- End subscription error -->
                    <div class="subscribe">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam egestas blandit dignissim. Aenean maximus ornare sem, et commodo risus tempor sed. Maecenas id purus diam. Pellentesque pellentesque massa leo, eu consectetur nulla consequat id. Quisque ut eros vitae dui consequat sodales. Aenean metus velit, fringilla sit amet nisl quis, pharetra tincidunt purus. Nam egestas volutpat lectus. Morbi libero diam, pulvinar id ipsum a, feugiat gravida metus. Mauris non est sed mi laoreet aliquam eget quis dui. Aliquam auctor massa eu rhoncus tempor. In euismod, nisl ut aliquet commodo, nibh orci eleifend quam, et interdum neque eros a purus. Proin rhoncus congue lorem, vel mollis tellus mattis at.</p>
                        
                        <p>Integer egestas nulla nec arcu ornare dignissim. Ut eget odio eu risus dapibus fermentum nec quis quam. Cras nisi quam, tincidunt non sodales pharetra, rhoncus ut eros. Nulla mollis aliquet urna. Vestibulum metus nulla, pretium id placerat ac, mattis at metus. Aenean lacus enim, tincidunt a euismod nec, viverra id ex. Ut vehicula est non fermentum sollicitudin. Donec id sagittis justo. Quisque non nisi sodales, tempus lorem sed, gravida purus. Suspendisse quis nulla sagittis, placerat orci id, ornare nulla. Fusce consequat placerat pharetra. Curabitur ornare magna sed nulla pharetra, at volutpat nulla lacinia. Curabitur placerat eros tortor, id ultrices justo fringilla elementum. Etiam et ultrices leo.</p>
                    </div>
                    <div class="row center-align">
                    	<?php
                        	$validation_errors = $this->session->userdata('vendor_signup3_error_message');
							
							if(!empty($validation_errors))
							{
								echo '<div class="alert alert-danger">'.$validation_errors.'</div>';
								$this->session->unset_userdata('vendor_signup3_error_message');
							}
						?>
                    </div>
                	<?php
                    	$attributes = array(
										'class' => 'form-horizontal',
										'role' => 'form',
									);
						echo form_open($this->uri->uri_string(), $attributes);
					?>
                    	<div class="row">
                        	
                        	<div class="col-md-6 col-md-offset-3">
                                
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
                            <div class="col-md-8 col-md-offset-3">
                                <a href="<?php echo site_url().'vendor/sign-up/subscribe';?>">Back</a>
                                <button type="submit" class="btn btn-red">Continue</button>
                                <p>already have an account?</p>
                                <a href="<?php echo site_url().'sign-in';?>">Sign In</a>
                            </div>
                        </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
        <!-- End Join -->
<?php echo $this->load->view('vendor/multiselect_js');?>
