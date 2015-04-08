<div class="container main-container headerOffset">
  <div class="row">
    <div class="col-lg-12">
    	<a href="<?php echo site_url().'account/sign-out';?>" class="pull-right">Sign out</a>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <ul class="breadcrumb">
        <li><a href="<?php echo site_url();?>">Home</a> </li>
        <li class="active"> My Account </li>

      </ul>

    </div>
    
  </div> <!--/.row-->
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
?>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 product-content">
    <div class="accounts-dashboard">
      
        <div class="row userInfo">
        	<div class="col-md-12">
                <h4><i class="fa fa-unlock-alt"></i> My Account</h4>
            </div>
          <div class="col-xs-9 col-sm-9 col-md-offset-1">
            
            <ul class="myAccountList row">
              <li class="col-lg-3 col-md-3 col-sm-3 col-xs-4  text-center ">
                <div class="thumbnail equalheight"> <a title="Orders" href="<?php echo site_url().'account/orders-list';?>"><i class="fa fa-calendar"></i> Order history </a> </div>
              </li>
              <li class="col-lg-3 col-md-3 col-sm-3 col-xs-4  text-center ">
                <div class="thumbnail equalheight"> <a title="My addresses" href="<?php echo site_url().'account/my-addresses';?>"><i  class="fa fa-map-marker"></i> My addresses</a> </div>
              </li>
              <li class="col-lg-3 col-md-3 col-sm-3 col-xs-4  text-center ">
                <div class="thumbnail equalheight"> <a title="Personal information" href="<?php echo site_url().'account/personnal-information';?>"><i class="fa fa-cog"></i> Personal information</a> </div>
              </li>
              <li class="col-lg-3 col-md-3 col-sm-3 col-xs-4  text-center ">
                <div class="thumbnail equalheight"> <a title="My wishlists" href="<?php echo site_url().'account/wishlist';?>"><i class="fa fa-heart"></i> My wishlists </a> </div>
              </li>
            </ul>
            <div class="clear clearfix"> </div>
          </div>
        </div>
      </div>
      <!--/row end--> 
      
      <div class="row">
      	<div class="col-md-12 center-align">
        	<a href="<?php echo site_url().'customer/deactivate-account';?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to deactivate your account?')">Deactivate account</a>
        </div>
      </div>
      
    </div>
  </div>
  <!--/row-->
</div>
  
  