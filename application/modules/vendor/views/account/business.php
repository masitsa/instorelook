<?php
	if($vendor_details->num_rows() > 0)
	{
		//initialize required variables
		$vendor_logo_location = 'http://placehold.it/300x300&text=Upload+logo';
		$vendor_store_name_error = '';
		$vendor_store_phone_error = '';
		$vendor_store_email_error = '';
		$vendor_store_summary_error = '';
		$vendor_logo_error = '';
		$vendor_store_address_error = '';
		$vendor_store_mobile_error = '';
		$vendor_store_state_error = '';
		$vendor_store_country_error = '';
		$vendor_business_type_error = '';
		$surburb_id_error = '';
		$country_id_error = '';
		$vendor_store_postcode_error = '';
		
		$vendor = $vendor_details->row();
		$validation_errors = validation_errors();
		
		//repopulate form data if validation errors are present
		if(!empty($validation_errors))
		{
			//create errors
			$vendor_store_name_error = form_error('vendor_store_name');
			$vendor_store_phone_error = form_error('vendor_store_phone');
			$vendor_store_email_error = form_error('vendor_store_email');
			$vendor_store_summary_error = form_error('vendor_store_summary');
			$vendor_store_address_error = form_error('vendor_store_address');
			$vendor_store_mobile_error = form_error('vendor_store_mobile');
			$vendor_store_state_error = form_error('vendor_store_state');
			$country_id_error = form_error('country_id');
			$vendor_business_type_error = form_error('vendor_business_type');
			$surburb_id_error = form_error('surburb_id');
			$vendor_store_postcode_error = form_error('vendor_store_postcode');
			
			//repopulate fields
			$vendor_store_name = set_value('vendor_store_name');
			$vendor_store_phone = set_value('vendor_store_phone');
			$vendor_store_email = set_value('vendor_store_email');
			$vendor_store_summary = set_value('vendor_store_summary');
			$vendor_store_address = set_value('vendor_store_address');
			$vendor_store_mobile = set_value('vendor_store_mobile');
			$vendor_store_state = set_value('vendor_store_state');
			$country_id = set_value('country_id');
			$vendor_business_type = set_value('vendor_business_type');
			$surburb_id = set_value('surburb_id');
			$vendor_store_postcode = set_value('vendor_store_postcode');
		}
		
		//populate form data on initial load of page
		else
		{
			$vendor_store_name = $vendor->vendor_store_name;
			$vendor_store_phone = $vendor->vendor_store_phone;
			$vendor_store_email = $vendor->vendor_store_email;
			$vendor_store_summary = $vendor->vendor_store_summary;
			$vendor_logo_location = $vendor_location.$vendor->vendor_logo;
			$vendor_store_mobile = $vendor->vendor_store_mobile;
			$vendor_store_state = $vendor->vendor_store_state;
			$country_id = $vendor->country_id;
			$vendor_business_type = $vendor->vendor_business_type;
			$surburb_id = $vendor->surburb_id;
			$vendor_store_postcode = $vendor->vendor_store_postcode;
			$vendor_store_address = $vendor->vendor_store_address;
		}
?>
<script type="text/javascript" src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script> 
<p class="center-align">Please update your store details here.</p>
                    
                	<?php
                    	$attributes = array(
										'class' => 'form-horizontal',
										'role' => 'form',
									);
						echo form_open_multipart('vendor/update-store', $attributes);
					?>
                    	<div class="row">
                        	<div class="col-md-6">
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
												$class = "alert-danger";
											}
											
											else
											{
												$class = '';
											}
											?>
											<select name="country_id" class="form-control <?php echo $class;?>">
											<?php
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
                                            	<input type="hidden" name="file_name" value="<?php echo $vendor->vendor_logo;?>">
                                            	<input type="hidden" name="thumb_name" value="<?php echo $vendor->vendor_thumb;?>">
                                                <img src="<?php echo $vendor_logo_location;?>" class="img-responsive">
                                            </div>
                                            <div>
                                                <span class="btn btn-file btn-primary"><span class="fileinput-new">Click here to update your logo</span><span class="fileinput-exists">Change</span><input type="file" name="vendor_logo"></span>
                                                <a href="#" class="btn btn-success fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row center-align">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-red">Update store details</button>
                            </div>
                        </div>
                    <?php echo form_close();
					
	}
	
	else
	{
		echo '<div class="alert alert-danger center-align"><strong>Error!</div>Unable to load your account details</div>';
	}
?>