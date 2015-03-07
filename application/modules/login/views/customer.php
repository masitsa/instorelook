<?php
//initialize required variables
$customer_email_error = '';
$customer_password_error = '';

$validation_errors = validation_errors();
	
//repopulate form data if validation errors are present
if(!empty($validation_errors))
{
	//create errors
	$customer_email_error = form_error('customer_email');
	$customer_password_error = form_error('customer_password');
	
	//repopulate fields
	$customer_email = set_value('customer_email');
	$customer_password = set_value('customer_password');
}

//populate form data on initial load of page
else
{
	$customer_email = '';
	$customer_password = '';
}
		
?>
							<h2 class="center-align">Customer</h2>
                            <p class="center-align">Search and purchase goods and services</p>
                            
                            <?php
                                $error_message = $this->session->userdata('error_message');
                                if(!empty($error_message))
                                {
                                    echo '<div class="alert alert-danger center-align"> Oh snap! '.$error_message.' </div>';
                                    $this->session->unset_userdata('error_message');
                                }
                                
                                $success_message = $this->session->userdata('success_message');
                                if(!empty($success_message))
                                {
                                    echo '<div class="alert alert-success center-align"> '.$success_message.' </div>';
                                    $this->session->unset_userdata('success_message');
                                    
                                }
                                $attributes = array(
                                                'class' => 'form-horizontal',
                                                'role' => 'form',
                                            );
                                echo form_open('customer/sign-in', $attributes);
                            ?>
                            	<div id="modal-error-message"></div>
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10">
                    
                                        <div class="form-group">
                                            <div class="col-sm-8 col-md-offset-4">
                                                <a href="#" class="facebook fb-signin-button"><span>Sign in with Facebook</span></a>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-8 col-md-offset-4">
                                                <p class="center-align">or</p>
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
                                            <div class="col-sm-8 col-md-offset-4">
                                                <div class="center-align">
                                                    <button type="submit" class="btn btn-red">Sign in</button>
                                                    <p>Don't have an account?</p>
                                                    <a href="<?php echo site_url().'customer/join';?>">Sign up</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php echo form_close();?>