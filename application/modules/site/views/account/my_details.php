<?php
	//communication messages
	$success_message = $this->session->userdata('billing_success_message');
	$error_message = $this->session->userdata('billing_error_message');
	
	if($customer_query->num_rows() > 0)
	{
		$customer = $customer_query->row();
		$first_name_error = '';
		$last_name_error = '';
		$phone_error = '';
		$email_error = '';
		$company_error = '';
		$address_error = '';
		$surburb_id_error = '';
		$current_password_error = '';
		$new_password_error = '';
		$confirm_password_error = '';
		$customer_company_error = '';
		$password = $customer->customer_password;
		
		$validation_errors = validation_errors();
		
		//repopulate form data if validation errors are present
		if(!empty($validation_errors))
		{
			//get errors
			$first_name_error = form_error('customer_first_name');
			$last_name_error = form_error('customer_surname');
			$phone_error = form_error('customer_phone');
			$email_error = form_error('customer_email');
			$company_error = form_error('customer_company');
			$address_error = form_error('customer_address');
			$surburb_id_error = form_error('surburb_id');
			$current_password_error = form_error('current_password');
			$new_password_error = form_error('new_password');
			$confirm_password_error = form_error('confirm_password');
			$customer_company_error = form_error('customer_company');
			
			//repopulate prefilled values
			$first_name = set_value('customer_first_name');
			$last_name = set_value('customer_surname');
			$phone = set_value('customer_phone');
			$email = set_value('customer_email');
			$company = set_value('customer_company');
			$address = set_value('customer_address');
			$surburb_id = set_value('surburb_id');
			$current_password = set_value('current_password');
			$new_password = set_value('new_password');
			$confirm_password = set_value('confirm_password');
			$customer_company = set_value('customer_company');
		}
		
		else
		{
			$first_name = $customer->customer_first_name;
			$last_name = $customer->customer_surname;
			$phone = $customer->customer_phone;
			$email = $customer->customer_email;
			$company = $customer->customer_company;
			$address = $customer->customer_address;
			$surburb_id = $customer->surburb_id;
			$customer_company = $customer->customer_company;
			$current_password = "";
			$new_password = "";
			$confirm_password = "";
		}
	}
?>
<div class="container main-container headerOffset">
  <div class="row">
    <div class="breadcrumbDiv col-lg-12">
      <ul class="breadcrumb">
        <li><a href="<?php echo site_url();?>">Home</a> </li>
        <li><a href="<?php echo site_url().'customer/account';?>">My Account</a> </li>
        <li class="active"> Personal Information </li>
      </ul>
    </div>
  </div><!--/.row-->

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

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h1 class="section-title-inner"><span><i class="glyphicon glyphicon-user"></i> My personal information </span></h1>
            <div class="row userInfo">
				<div class="col-lg-12">
					<h2 class="block-title-2"> Please be sure to update your personal information if it has changed. </h2>
					<p class="required"><span class="required">*</span> Required field</p>
				</div>
				
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                	<?php echo form_open('account/update-billing-details', array('class' => 'form-horizontal', 'role' => 'form'));?>
                        <div class="form-group">
                            <label for="customer_first_name" class="col-sm-4 control-label">First name <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <?php
                                    //case of an input error
                                    if(!empty($first_name_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="customer_first_name" placeholder="<?php echo $first_name_error;?>" onFocus="this.value = '<?php echo $first_name;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="customer_first_name" placeholder="First name" value="<?php echo $first_name;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label for="customer_last_name" class="col-sm-4 control-label">Last name <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <?php
                                    //case of an input error
                                    if(!empty($last_name_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="customer_last_name" placeholder="<?php echo $last_name_error;?>" onFocus="this.value = '<?php echo $last_name;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="customer_last_name" placeholder="Last name" value="<?php echo $last_name;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
						
                        <div class="form-group">
                            <label for="customer_company" class="col-sm-4 control-label">Company</label>
                            <div class="col-sm-8">
                                <?php
                                    //case of an input error
                                    if(!empty($customer_company_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="customer_customer_company" placeholder="<?php echo $customer_company_error;?>" onFocus="this.value = '<?php echo $customer_company;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="customer_customer_company" placeholder="Company" value="<?php echo $customer_company;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="customer_email" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                               <input type="text" class="form-control" name="customer_email" readonly placeholder="Email" value="<?php echo $email;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="customer_phone" class="col-sm-4 control-label">Phone <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <?php
                                    //case of an input error
                                    if(!empty($phone_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="customer_phone" placeholder="<?php echo $phone_error;?>" onFocus="this.value = '<?php echo $phone;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="customer_phone" placeholder="Phone" value="<?php echo $phone;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="customer_address" class="col-sm-4 control-label">Address <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <?php
                                    //case of an input error
                                    if(!empty($address_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="customer_address" placeholder="<?php echo $address_error;?>" onFocus="this.value = '<?php echo $address;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="customer_address" placeholder="Address" value="<?php echo $address;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="surburb_id" class="col-sm-4 control-label">Surburb <span class="required">*</span></label>
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
                        <div class="row">
                            <div class="col-md-8 col-md-offset-4">
                            	<div class="center-align">
                                <button type="submit" class="btn   btn-primary"><i class="fa fa-save"></i> &nbsp; Update Account </button>
                                </div>
                            </div>
                        </div>
					 <?php echo form_close();?>
				</div>
                
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<form action="<?php echo site_url().'account/update-password';?>" method="POST" role="form" class="form-horizontal">
                        <div class="form-group">
                            <label for="current_password" class="col-sm-4 control-label">Current password <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <?php
                                    //case of an input error
                                    if(!empty($current_password_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="current_password" placeholder="<?php echo $current_password_error;?>" onFocus="this.value = '<?php echo $current_password;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="current_password" placeholder="Current password" value="<?php echo $current_password;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_password" class="col-sm-4 control-label">New password <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <?php
                                    //case of an input error
                                    if(!empty($new_password_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="new_password" placeholder="<?php echo $new_password_error;?>" onFocus="this.value = '<?php echo $new_password;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="new_password" placeholder="New password" value="<?php echo $new_password;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="col-sm-4 control-label">Confirm password <span class="required">*</span></label>
                            <div class="col-sm-8">
                                <?php
                                    //case of an input error
                                    if(!empty($confirm_password_error))
                                    {
                                        ?>
                                        <input type="text" class="form-control alert-danger" name="confirm_password" placeholder="<?php echo $confirm_password_error;?>" onFocus="this.value = '<?php echo $confirm_password;?>';">
                                        <?php
                                    }
                                    
                                    else
                                    {
                                        ?>
                                        <input type="text" class="form-control" name="confirm_password" placeholder="Confirm password" value="<?php echo $confirm_password;?>">
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-4">
                            	<div class="center-align">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> &nbsp; Update Password </button>
                                </div>
                            </div>
                        </div>
					</form>
                </div>
			</div>
			<div class="col-lg-12 clearfix">
				<ul class="pager">
				<li class="previous pull-right"><a href="<?php echo site_url().'products/all-products';?>"> <i class="fa fa-home"></i> Go to Shop </a></li>
				<li class="next pull-left"><a href="<?php echo site_url().'account';?>"> &larr; Back to My Account</a></li>
				</ul>
			</div>
		</div>
		<!--/row end--> 
    </div>
    <!--/row-->
    
    <div style="clear:both"></div>
</div>
<!-- /main-container -->

<div class="gap"> </div>