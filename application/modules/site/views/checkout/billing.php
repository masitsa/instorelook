<?php
	
	//communication messages
	$success_message = $this->session->userdata('billing_success_message');
	$error_message = $this->session->userdata('billing_error_message');
	$validation_errors = validation_errors();
	
	//check if user has logged in
	
	//If customer has logged in
	$customer_query = $this->checkout_model->get_customer_details($this->session->userdata('customer_id'));
		
	if($customer_query->num_rows() > 0)
	{
		$customer = $customer_query->row();
		
		$first_name = $customer->customer_first_name;
		$last_name = $customer->customer_surname;
		$phone = $customer->customer_phone;
		$email = $customer->customer_email;
		$company = $customer->customer_company;
		$surburb_id = $customer->surburb_id;
		$address = $customer->customer_address;
	}
	
	//repopulate fields if validation errors are present
	if(!empty($validation_errors))
	{
		$first_name = set_value('first_name');
		$last_name = set_value('last_name');
		$phone = set_value('phone');
		$email = set_value('email');
		$company = set_value('company');
		$surburb_id = set_value('surburb_id');
		$address = set_value('address');
	}
?>
<!-- Checkout content -->
                <div id="checkout-content">
                    <div class="box-header">
                        <h3>Billing address</h3>
                    </div>
                    
                    <div class="center-align">
                    	Not <?php echo $this->session->userdata('customer_first_name');?>? <a href="<?php echo site_url().'account/sign-out';?>">Sign out</a>
                    </div>
					
                    <?php
                    	if(!empty($success_message))
						{
							echo '<div class="alert alert-success">'.$success_message.'</div>';
							$this->session->unset_userdata('billing_success_message');
						}
                    	if(!empty($error_message))
						{
							echo '<div class="alert alert-danger">'.$error_message.'</div>';
							$this->session->unset_userdata('billing_error_message');
						}
					?>
                    
                    <?php echo form_open('checkout/update-billing-details');?>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-6 col-md-6  col-sm-6">
                                <div class="form-group">
                                    <label for="first_name" class="control-label">First name <span class="required">*</span></label>
                                    <div class="controls">
                                        <input class="form-control" type="text" value="<?php echo $first_name;?>" name="first_name" id="first_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="last_name" class="control-label">Last name <span class="required">*</span></label>
                                    <div class="controls">
                                        <input class="form-control" type="text" value="<?php echo $last_name;?>" name="last_name" id="last_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label">Email <span class="required">*</span></label>
                                    <div class="controls">
                                        <input class="form-control" type="text" value="<?php echo $email;?>" name="email" id="email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="control-label">Phone <span class="required">*</span></label>
                                    <div class="controls">
                                        <input class="form-control" type="text" value="<?php echo $phone;?>" name="phone" id="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6  col-sm-6">
                                <div class="form-group">
                                    <label for="company" class="control-label">Company</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" value="<?php echo $company;?>" name="company" id="company">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="street_address" class="control-label">Address</label>
                                    <div class="controls">
                                        <input class="form-control" type="text" value="<?php echo $address;?>" name="address" id="address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="surburb_id" class="control-label">Surburb <span class="required">*</span></label>
                                    <div class="controls">
                                    	<select name="surburb_id" class="form-control">
                                        <?php
                                            
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
                        </div>  
                    </div>
                    
                    <div class="center-align" style="margin-top:20px;">
                        <button type="submit" class="btn btn-success">
                            Update Billing Details &nbsp; <i class="icon-chevron-right"></i>
                        </button>
                    </div>
                    <?php echo form_close();?>
                    
                    <div class="box-footer">
                        <div class="pull-left">
                            <a href="<?php echo site_url().'cart';?>" class="btn btn-default btn-small">
                                <i class="icon-chevron-left"></i> &nbsp; Back to cart
                            </a>
                        </div>

                        <div class="pull-right">                           
                            <a href="<?php echo site_url().'checkout-progress/shipping';?>" class="btn btn-primary btn-small">
                                Shipping address &nbsp; <i class="icon-chevron-right"></i>
                            </a>
                        </div>
                    </div>                  
                </div>  
                <!-- End id="checkout-content" -->