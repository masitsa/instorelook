<?php
	if($vendor_details->num_rows() > 0)
	{
		//initialize required variables
		$vendor_first_name_error = '';
		$vendor_last_name_error = '';
		$vendor_email_error = '';
		$vendor_phone_error = '';
		$vendor_password_error = '';
		$confirm_password_error = '';
		
		$vendor = $vendor_details->row();
		$validation_errors = validation_errors();
			
		//repopulate form data if validation errors are present
		if(!empty($validation_errors))
		{
			//create errors
			$vendor_first_name_error = form_error('vendor_first_name');
			$vendor_last_name_error = form_error('vendor_last_name');
			$vendor_email_error = form_error('vendor_email');
			$vendor_phone_error = form_error('vendor_phone');
			$vendor_password_error = form_error('vendor_password');
			$vendor_current_password_error = form_error('vendor_current_password');
			$confirm_password_error = form_error('confirm_password');
			
			//repopulate fields
			$vendor_first_name = set_value('vendor_first_name');
			$vendor_last_name = set_value('vendor_last_name');
			$vendor_email = set_value('vendor_email');
			$vendor_phone = set_value('vendor_phone');
			$vendor_password = set_value('vendor_password');
			$vendor_current_password = set_value('vendor_current_password');
			$confirm_password = set_value('confirm_password');
		}
		
		//populate form data on initial load of page
		else
		{
			$vendor_first_name = $vendor->vendor_first_name;
			$vendor_last_name = $vendor->vendor_last_name;
			$vendor_email = $vendor->vendor_email;
			$vendor_phone = $vendor->vendor_phone;
			$vendor_password = '';
			$vendor_current_password = '';
			$confirm_password = '';
		}
		$vendor_password_current = $vendor->vendor_password;
?>
                    	<div class="row">
                        	<div class="col-md-6">
                            	<p class="center-align">Please update your personal details here.</p>
								<?php
                                    $attributes = array(
                                                    'class' => 'form-horizontal',
                                                    'role' => 'form',
                                                );
                                    echo form_open('vendor/update-details', $attributes);
                                ?>
                            	<div class="form-group">
                                    <label for="vendor_first_name" class="col-sm-4 control-label">First Name <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_first_name_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_first_name" placeholder="<?php echo $vendor_first_name_error;?>" onFocus="this.value = '<?php echo $vendor_first_name;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_first_name" placeholder="First Name" value="<?php echo $vendor_first_name;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                            	<div class="form-group">
                                    <label for="vendor_last_name" class="col-sm-4 control-label">Last Name <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_last_name_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_last_name" placeholder="<?php echo $vendor_last_name_error;?>" onFocus="this.value = '<?php echo $vendor_last_name;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_last_name" placeholder="Last Name" value="<?php echo $vendor_last_name;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vendor_phone" class="col-sm-4 control-label">Phone <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_phone_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_phone" placeholder="<?php echo $vendor_phone_error;?>" onFocus="this.value = '<?php echo $vendor_phone;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_phone" placeholder="Phone" value="<?php echo $vendor_phone;?>">
                                                <?php
											}
										?>
                                	</div>
                                </div>
                                <div class="form-group">
                                    <label for="vendor_email" class="col-sm-4 control-label">Email <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<input type="text" class="form-control" name="vendor_email" placeholder="Email" value="<?php echo $vendor_email;?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <div class="row center-align" style="margin-top:10px;">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-red">Update details</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    			<?php echo form_close();?>
                            </div>
                        	<div class="col-md-6">
                            	<p class="center-align">Please update your password here.</p>
								<?php
                                    $attributes = array(
                                                    'class' => 'form-horizontal',
                                                    'role' => 'form',
                                                );
                                    echo form_open('vendor/update-password', $attributes);
                                ?>
                                <input type="hidden" name="slug" value="<?php echo $vendor_password_current;?>">
                                <div class="form-group">
                                    <label for="vendor_password" class="col-sm-4 control-label">Current password <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_current_password_error))
											{
												?>
                                                <input type="password" class="form-control alert-danger" name="vendor_current_password" placeholder="<?php echo $vendor_current_password_error;?>" onFocus="this.value = '<?php echo $vendor_current_password;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="password" class="form-control" name="vendor_current_password" placeholder="Current password" value="<?php echo $vendor_current_password;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vendor_password" class="col-sm-4 control-label">New password <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_password_error))
											{
												?>
                                                <input type="password" class="form-control alert-danger" name="vendor_password" placeholder="<?php echo $vendor_password_error;?>" onFocus="this.value = '<?php echo $vendor_password;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="password" class="form-control" name="vendor_password" placeholder="New password" value="<?php echo $vendor_password;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password" class="col-sm-4 control-label">Confirm Password <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($confirm_password_error))
											{
												?>
                                                <input type="password" class="form-control alert-danger" name="confirm_password" placeholder="<?php echo $confirm_password_error;?>" onFocus="this.value = '<?php echo $confirm_password;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" value="<?php echo $confirm_password;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <div class="row center-align" style="margin-top:10px;">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-red">Update password</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    			<?php echo form_close();?>
                            </div>
                        </div>
<?php
	}
	
	else
	{
		echo '<div class="alert alert-danger center-align"><strong>Error!</div>Unable to load your account details</div>';
	}
?>

<div class="row">
	<div class="col-md-12 center-align" style="margin-bottom:10px;">
    	<?php echo '<a href="'.site_url().'vendor/deactivate-account" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to deactivate your account?\');">Deactivate account</a>';?>
    </div>
</div>