
        <script type="text/javascript" src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script> 
        <div class="content light-grey-background">
        	<div class="container">
        		<div class="search-flights">
                	<div class="divider-line"></div>
                	<h1 class="center-align">Business sign up</h1>
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
                                    <button type="button" class="btn blue-background btn-circle" disabled="disabled"><i class="fa fa-building-o fa-2x"></i></button>
                                    <p>Business</p>
                                </div>
                                 <div class="process-step">
                                    <button type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-dollar fa-2x"></i></button>
                                    <p>Subscription</p>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- End: Steps -->
                    
                    <p class="center-align">Please enter your store details here. You can register more stores under your name later in your account.</p>
                    
                	<?php
                    	$attributes = array(
										'class' => 'form-horizontal',
										'role' => 'form',
									);
						echo form_open_multipart($this->uri->uri_string(), $attributes);
					?>
                    	<div class="row">
                        	<div class="col-md-6 first">
                            	<div class="form-group">
                                    <label for="vendor_store_name" class="col-sm-4 control-label">Business Name <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_store_name_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_store_name" placeholder="<?php echo $vendor_store_name_error;?>" onFocus="this.value = '<?php echo $vendor_store_name;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_store_name" placeholder="Business Name" value="<?php echo $vendor_store_name;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vendor_store_abn" class="col-sm-4 control-label">Business Type</label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_business_type_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_business_type" placeholder="<?php echo $vendor_business_type_error;?>" onFocus="this.value = '<?php echo $vendor_business_type;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_business_type" placeholder="Business Type" value="<?php echo $vendor_business_type;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vendor_store_phone" class="col-sm-4 control-label">Phone <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_store_phone_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_store_phone" placeholder="<?php echo $vendor_store_phone_error;?>" onFocus="this.value = '<?php echo $vendor_store_phone;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_store_phone" placeholder="Phone" value="<?php echo $vendor_store_phone;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vendor_store_mobile" class="col-sm-4 control-label">Mobile</label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_store_mobile_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_store_mobile" placeholder="<?php echo $vendor_store_mobile_error;?>" onFocus="this.value = '<?php echo $vendor_store_mobile;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_store_mobile" placeholder="Mobile" value="<?php echo $vendor_store_mobile;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vendor_store_email" class="col-sm-4 control-label">Business Email <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_store_email_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_store_email" placeholder="<?php echo $vendor_store_email_error;?>" onFocus="this.value = '<?php echo $vendor_store_email;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_store_email" placeholder="Business Email" value="<?php echo $vendor_store_email;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="country_id" class="col-sm-4 control-label">Country</label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($country_id_error))
											{
												?>
                                    			<select name="country_id" class="form-control alert-danger">
                                                <?php
											}
											
											else
											{
												?>
                                                <select name="country_id" class="form-control">
                                                <?php
											}
											if($countries_query->num_rows() > 0)
											{
												foreach($countries_query->result() as $res)
												{
													$country_id2 = $res->id;
													$country_name = $res->country_name;
													
													if($country_id2 == $country_id)
													{
														echo '<option value="'.$country_id2.'" selected="selected">'.$country_name.'</option>';
													}
													//australia
													else if($country_id2 == 15)
													{
														echo '<option value="'.$country_id2.'" selected="selected">'.$country_name.'</option>';
													}
													
													else
													{
														echo '<option value="'.$country_id2.'">'.$country_name.'</option>';
													}
												}
											}
										?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vendor_store_address" class="col-sm-4 control-label">Address</label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_store_address_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_store_address" placeholder="<?php echo $vendor_store_address_error;?>" onFocus="this.value = '<?php echo $vendor_store_address;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_store_address" placeholder="Address" value="<?php echo $vendor_store_address;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="country_id" class="col-sm-4 control-label">Surburb</label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($surburb_id_error))
											{
												?>
                                    			<select name="surburb_id" class="form-control alert-danger">
                                                <?php
											}
											
											else
											{
												?>
                                                <select name="surburb_id" class="form-control">
                                                <?php
											}
											if($surburbs_query->num_rows() > 0)
											{
												foreach($surburbs_query->result() as $res)
												{
													$surburb_id2 = $res->surburb_id;
													$surburb_name = $res->surburb_name;
													$post_code = $res->post_code;
													$state_name = $res->state_name;
													
													if($surburb_id2 == $surburb_id)
													{
														echo '<option value="'.$surburb_id2.'" selected="selected">'.$surburb_name.', '.$post_code.' '.$state_name.'</option>';
													}
													
													else
													{
														echo '<option value="'.$surburb_id2.'">'.$surburb_name.', '.$post_code.' '.$state_name.'</option>';
													}
												}
											}
										?>
                                        </select>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <label for="vendor_store_address" class="col-sm-4 control-label">State</label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_store_state_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_store_state" placeholder="<?php echo $vendor_store_state_error;?>" onFocus="this.value = '<?php echo $vendor_store_state;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_store_state" placeholder="State" value="<?php echo $vendor_store_state;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vendor_store_address" class="col-sm-4 control-label">Postcode</label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_store_postcode_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_store_postcode" placeholder="<?php echo $vendor_store_postcode_error;?>" onFocus="this.value = '<?php echo $vendor_store_postcode;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_store_postcode" placeholder="Postcode" value="<?php echo $vendor_store_postcode;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>-->
                            </div>
                            
                        	<div class="col-md-6">
                            
                                <div class="form-group">
                                    <label for="vendor_store_summary" class="col-sm-4 control-label">Description
                                        <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_store_summary_error))
											{
												?>
                                                <textarea class="form-control alert-danger" name="vendor_store_summary" onFocus="this.value = '<?php echo $vendor_store_summary;?>';" placeholder="<?php echo $vendor_store_summary_error;?>"></textarea>
                                                <?php
											}
											
											else
											{
												?>
                                                <textarea class="form-control" name="vendor_store_summary" placeholder="Business Description"><?php echo $vendor_store_summary;?></textarea>
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="vendor_logo" class="col-sm-4 control-label">Store Logo</label>
                                    <div class="col-sm-8">
                                    	<div class="center-align">
                                        	<?php
                                            	$error = $this->session->userdata('vendor_logo_error_message');
												
												if(!empty($error))
												{
													echo '<div class="alert alert-danger">'.$error.'</div>';
													$this->session->unset_userdata('vendor_logo_error_message');
												}
											?>
                                        </div>
                                    	<div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="cursor:pointer;">
                                                <img src="<?php echo $vendor_logo_location;?>" class="img-responsive">
                                            </div>
                                            <div>
                                                <span class="btn btn-file btn-primary"><span class="fileinput-new">Click here to upload image</span><span class="fileinput-exists">Change</span><input type="file" name="vendor_logo"></span>
                                                <a href="#" class="btn btn-success fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                        <div class="center-align">
                                        	<a href="http://www.fixpicture.org/" target="_blank">Free online image converter</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row center-align">
                            <div class="col-sm-12">
                            	<p>Help customers find you by adding further details within My Account</p>
                            </div>
                        </div>
                        
                        <div class="row center-align">
                            <div class="col-sm-12">
                                <a href="<?php echo site_url().'vendor/sign-up/personal-details';?>">Back</a>
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