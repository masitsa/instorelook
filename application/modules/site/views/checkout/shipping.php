<?php
	
	//communication messages
	$success_message = $this->session->userdata('shipping_success_message');
	$error_message = $this->session->userdata('shipping_error_message');
	$validation_errors = validation_errors();
	
	//check if user has logged in
	$login_status = $this->session->userdata('customer_login_status');
	
	//If customer has logged in
	if((!empty($login_status)) && ($login_status == TRUE))
	{
		//get billing details
		$customer_query = $this->checkout_model->get_customer_details($this->session->userdata('customer_id'));
		
		if($customer_query->num_rows() > 0)
		{
			$customer = $customer_query->row();
			
			$first_name = $customer->customer_first_name;
			$last_name = $customer->customer_surname;
			$phone = $customer->customer_phone;
			$email = $customer->customer_email;
			$company = $customer->customer_company;
			$town = $customer->customer_town;
			$post_code = $customer->customer_post_code;
			$country_id = $customer->country_id;
			$state = $customer->customer_state;
			$address = $customer->customer_address;
		}
		
		//get shipping details
		$customer_query = $this->checkout_model->get_shipping_details($this->session->userdata('customer_id'));
		
		if($customer_query->num_rows() > 0)
		{
			$customer = $customer_query->row();
			
			$first_name2 = $customer->first_name;
			$last_name2 = $customer->last_name;
			$phone2 = $customer->phone;
			$email2 = $customer->email;
			$company2 = $customer->company;
			$town2 = $customer->town;
			$post_code2 = $customer->post_code;
			$country_id2 = $customer->country_id;
			$state2 = $customer->state;
			$address2 = $customer->address;
		}
		
		else
		{
			$first_name2 = '';
			$last_name2 = '';
			$phone2 = '';
			$email2 = '';
			$company2 = '';
			$town2 = '';
			$post_code2 = '';
			$country_id2 = '';
			$state2 = '';
			$address2 = '';
		}
	}
	
	//repopulate fields if validation errors are present
	if(!empty($validation_errors))
	{
		$first_name2 = set_value('first_name');
		$last_name2 = set_value('last_name');
		$phone2 = set_value('phone');
		$email2 = set_value('email');
		$company2 = set_value('company');
		$town2 = set_value('town');
		$post_code2 = set_value('post_code');
		$country_id2 = set_value('country_id');
		$state2 = set_value('state');
		$address2 = set_value('address');
	}
?>
<div id="checkout-content">
	<div class="box-header">
	    <div class="row">
	        <div class="span8">
	            <h3>Shipping address</h3>
	            <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h5>
	        </div>
	        <div class="span4">
	            <button class="btn btn-secondary btn-mini pull-right" id="copy_billing">
	                <i class="icon-copy"></i> &nbsp; Copy billing address
	            </button>
	        </div>
	    </div>
	</div>
	<div class="box-content">
					
		<?php
            if(!empty($success_message))
            {
                echo '<div class="alert alert-success">'.$success_message.'</div>';
                $this->session->unset_userdata('shipping_success_message');
            }
            if(!empty($error_message))
            {
                echo '<div class="alert alert-danger">'.$error_message.'</div>';
                $this->session->unset_userdata('shipping_error_message');
            }
        ?>
    
    	<!-- Billing Copy -->
        <div class="billing_copy">
			<?php echo form_open('checkout/update-shipping-details');?>
            <div class="row">
                <div class="col-lg-6 col-md-6  col-sm-6">
                    <div class="control-group">
                        <label for="first_name" class="control-label">First name</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $first_name;?>" name="first_name" id="first_name">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="last_name" class="control-label">Last name</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $last_name;?>" name="last_name" id="last_name">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="email" class="control-label">Email</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $email;?>" name="email" id="email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="phone" class="control-label">Phone</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $phone;?>" name="phone" id="phone">
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-6 col-md-6  col-sm-6">
                    <div class="control-group">
                        <label for="company" class="control-label">Company</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $company;?>" name="company" id="company">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="street_address" class="control-label">Street address</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $address;?>" name="address" id="address">
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-lg-6 col-md-6  col-sm-6">
                            <div class="control-group">
                                <label for="city" class="control-label">Town / City</label>
                                <div class="controls">
                                    <input class="form-control" type="text" value="<?php echo $town;?>" name="town" id="town">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6  col-sm-6">
                            <div class="control-group">
                                <label for="zip" class="control-label">Zip / Postcode</label>
                                <div class="controls">
                                    <input class="form-control" type="text" value="<?php echo $post_code;?>" name="post_code" id="post_code">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6 col-md-6  col-sm-6">
                            <div class="control-group">
                                <label for="country" class="control-label">Country</label>
                                <div class="controls">
                                    <select class="form-control" id="country" name="country">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6  col-sm-6">
                            <div class="control-group">
                                <label for="state" class="control-label">State</label>
                                <div class="controls">
                                    <div id="states">
                                        <select class="form-control" id="state" name="state">                                                                                
                                        </select>                           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="center-align" style="margin-top:20px;">
                <button type="submit" class="btn btn-success">
                    Update Shipping Details &nbsp; <i class="icon-chevron-right"></i>
                </button>
            </div>
        	<?php echo form_close();?>
        </div>
        <!-- End: Billing Copy -->
        
        <!-- Shipping Details -->
	    <div class="shipping_details">
			<?php echo form_open('checkout/update-shipping-details');?>
            <div class="row">
                <div class="col-lg-6 col-md-6  col-sm-6">
                    <div class="control-group">
                        <label for="first_name" class="control-label">First name</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $first_name2;?>" name="first_name" id="first_name">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="last_name" class="control-label">Last name</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $last_name2;?>" name="last_name" id="last_name">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="email" class="control-label">Email</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $email2;?>" name="email" id="email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="phone" class="control-label">Phone</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $phone2;?>" name="phone" id="phone">
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-6 col-md-6  col-sm-6">
                    <div class="control-group">
                        <label for="company" class="control-label">Company</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $company2;?>" name="company" id="company">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="street_address" class="control-label">Street address</label>
                        <div class="controls">
                            <input class="form-control" type="text" value="<?php echo $address2;?>" name="address" id="address">
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-lg-6 col-md-6  col-sm-6">
                            <div class="control-group">
                                <label for="city" class="control-label">Town / City</label>
                                <div class="controls">
                                    <input class="form-control" type="text" value="<?php echo $town2;?>" name="town" id="town">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6  col-sm-6">
                            <div class="control-group">
                                <label for="zip" class="control-label">Zip / Postcode</label>
                                <div class="controls">
                                    <input class="form-control" type="text" value="<?php echo $post_code2;?>" name="post_code" id="post_code">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6 col-md-6  col-sm-6">
                            <div class="control-group">
                                <label for="country" class="control-label">Country</label>
                                <div class="controls">
                                    <select class="form-control" id="country" name="country">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6  col-sm-6">
                            <div class="control-group">
                                <label for="state" class="control-label">State</label>
                                <div class="controls">
                                    <div id="states">
                                        <select class="form-control" id="state" name="state">                                                                                
                                        </select>                           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="center-align" style="margin-top:20px;">
                <button type="submit" class="btn btn-success">
                    Update Shipping Details &nbsp; <i class="icon-chevron-right"></i>
                </button>
            </div>
        	<?php echo form_close();?>
        </div>	
        <!-- End: Shipping Details -->
	</div>

	<div class="box-footer">
	    <div class="pull-left">
        	<a href="<?php echo site_url().'checkout-progress/billing';?>" class="btn btn-default btn-small">
	            <i class="icon-chevron-left"></i> &nbsp; Billing address
	        </a>
	    </div>

	    <div class="pull-right">
        	<a href="<?php echo site_url().'checkout-progress/method';?>" class="btn btn-primary btn-small">
	            Shipping method &nbsp; <i class="icon-chevron-right"></i>
	        </a>
	    </div>
	</div>					
</div>

<script type="text/javascript">
	
	$("button#copy_billing").click(function() {
		$('.shipping_details').fadeOut("slow").css('display', 'none');
		$('.billing_copy').fadeIn("slow").css('display', 'block');
	});
</script>