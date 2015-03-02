 <!-- Join  -->
        <div class="content light-grey-background">
        	<div class="container">
        		<div class="search-flights">
                	<div class="divider-line"></div>
                	<h1 class="center-align">Customer sign up</h1>
                	<div class="divider-line" style="margin-bottom:2%;"></div>
                    
                    <p class="center-align">Please enter your details here.</p>
                    
                	<?php
						$error = $this->session->userdata('customer_signup_error_message');
						
						if(!empty($error))
						{
							echo '
							<div class="alert alert-danger center-align">'.$error.'</div>
							';
							$this->session->unset_userdata('customer_signup_error_message');
						}
                    	$attributes = array(
										'class' => 'form-horizontal',
										'role' => 'form',
									);
						echo form_open($this->uri->uri_string(), $attributes);
					?>
                    	<div class="row">
                        	<div class="col-md-offset-3 col-md-5">
                            	<div class="form-group">
                                    <label for="customer_first_name" class="col-sm-4 control-label">First Name <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($customer_first_name_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="customer_first_name" placeholder="<?php echo $customer_first_name_error;?>" onFocus="this.value = '<?php echo $customer_first_name;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="customer_first_name" placeholder="First Name" value="<?php echo $customer_first_name;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                            	<div class="form-group">
                                    <label for="customer_surname" class="col-sm-4 control-label">Last Name <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($customer_surname_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="customer_surname" placeholder="<?php echo $customer_surname_error;?>" onFocus="this.value = '<?php echo $customer_surname;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="customer_surname" placeholder="Last Name" value="<?php echo $customer_surname;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="customer_phone" class="col-sm-4 control-label">Phone</label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($customer_phone_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="customer_phone" placeholder="<?php echo $customer_phone_error;?>" onFocus="this.value = '<?php echo $customer_phone;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="customer_phone" placeholder="Phone" value="<?php echo $customer_phone;?>">
                                                <?php
											}
										?>
                                	</div>
                                </div>
                                <div class="form-group">
                                    <label for="customer_email" class="col-sm-4 control-label">Email <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($customer_email_error))
											{
												?>
                                                <input type="text" class="form-control alert-danger" name="customer_email" placeholder="<?php echo $customer_email_error;?>" onFocus="this.value = '<?php echo $customer_email;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="text" class="form-control" name="customer_email" placeholder="Email" value="<?php echo $customer_email;?>">
                                                <?php
											}
										?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="customer_password" class="col-sm-4 control-label">Password <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                    	<?php
											//case of an input error
                                        	if(!empty($customer_password_error))
											{
												?>
                                                <input type="password" class="form-control alert-danger" name="customer_password" placeholder="<?php echo $customer_password_error;?>" onFocus="this.value = '<?php echo $customer_password;?>';">
                                                <?php
											}
											
											else
											{
												?>
                                                <input type="password" class="form-control" name="customer_password" placeholder="Password" value="<?php echo $customer_password;?>">
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
                                <button type="submit" class="btn btn-red btn-lg">Register</button>
                                <p>already have an account?</p>
                                <a href="<?php echo site_url().'sign-in';?>">Sign in</a>
                            </div>
                        </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
        <!-- End Join -->