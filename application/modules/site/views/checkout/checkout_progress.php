
<div class="container main-container headerOffset">
  
  <?php echo $this->load->view('products/breadcrumbs');?>
  
  <?php
      	$error = $this->session->userdata('front_error_message');
      	$success = $this->session->userdata('front_success_message');
		
		if(!empty($error))
		{
			?>
            <div class="alert alert-danger">
            	<p>
                	<?php 
					echo $error;
					$this->session->unset_userdata('front_error_message');
					?>
                </p>
            </div>
            <?php
		}
		
		if(!empty($success))
		{
			?>
            <div class="alert alert-success">
            	<p>
                	<?php 
					echo $success;
					$this->session->unset_userdata('front_success_message');
					?>
                </p>
            </div>
            <?php
		}
	  ?>
  
  <div class="row">
  
    <div class="col-lg-12 col-md-12  col-sm-12">

      
      <div class="row userInfo">
        <div class="col-lg-9 col-md-9  col-sm-9">
        <div class="checkout-progress">
            <h4>Shopping progress</h4>
             <div class="box">
                                            
                <!-- Checkout progress -->
                <div id="checkout-progress">
                    <ul class="nav nav-tabs">
                        <?php echo $this->cart_model->get_navigation($page_name);?>
                    </ul>                   
                </div>
                <!-- End id="checkout-progress" -->
                <?php 
                    if($page_name == 'billing')
                    {
                        echo $this->load->view('checkout/billing', '', true);
                    }
                    else if($page_name == 'shipping')
                    {
                        echo $this->load->view('checkout/shipping', '', true);
                    }
                    else if($page_name == 'method')
                    {
                        echo $this->load->view('checkout/method', '', true);
                    }
                    else if($page_name == 'payment')
                    {
                        echo $this->load->view('checkout/payment', '', true);
                    }
                    else if($page_name == 'review')
                    {
                        echo $this->load->view('checkout/review', '', true);
                    }
                    else
                    {
                        echo $this->load->view('checkout/billing', '', true);
                    }

                ?>
                
                
            </div>
        </div>
          
        </div>
        
        
        <div class="col-xs-12 col-sm-3">
            <?php echo $this->load->view('cart/cart_summary', '', TRUE);?>
           
        </div>
        <!-- Button trigger modal -->
<!-- Large modal -->

        <!-- <div class="col-xs-12 col-sm-4">
          <h2 class="block-title-2"><span>Checkout as Guest</span></h2>
          <p>Don't have an account and you don't want to register? Checkout as a guest instead!</p>
          <a href=" action="<?php echo site_url().'checkout/my-details';?>"" class="btn btn-primary"><i class="fa fa-sign-in"></i> Checkout as Guest</a> </div> -->
      </div> <!--/row end--> 
      
    </div>
  </div> <!--/row-->
         
  
  <div style="clear:both"></div>
</div>
<!-- /.main-container -->

<div class="gap"> </div>