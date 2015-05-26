 <!-- Join  -->
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
                                    <button type="button" class="btn blue-background btn-circle" disabled="disabled"><i class="fa fa-user fa-2x"></i></button>
                                    <p>Account</p>
                                </div>
                                <div class="process-step">
                                    <button type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-building-o fa-2x"></i></button>
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
                    
                    <p class="center-align">Please enter your personal details here.</p>
                    
                	<?php
                    	$attributes = array(
										'class' => 'form-horizontal',
										'role' => 'form',
									);
						echo form_open($this->uri->uri_string(), $attributes);
					?>
                    	<div class="row">
                        	<div class="col-md-offset-3 col-md-5">
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
                                    <label for="vendor_email" class="col-sm-4 control-label">Business email <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($vendor_email_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="vendor_email" placeholder="<?php echo $vendor_email_error;?>" onFocus="this.value = '<?php echo $vendor_email;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="vendor_email" placeholder="Email" value="<?php echo $vendor_email;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vendor_password" class="col-sm-4 control-label">Password <span class="required">*</span></label>
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
                                                <input type="password" class="form-control" name="vendor_password" placeholder="Password" value="<?php echo $vendor_password;?>">
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
                            </div>
                        </div>
                        
                        <div class="row center-align">
                            <div class="col-sm-12">
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