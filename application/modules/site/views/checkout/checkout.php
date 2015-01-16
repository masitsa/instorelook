
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
        <div class="col-xs-12 col-sm-6">
         
            <div class="login">
    <div class="box">
        <form onsubmit="return false;" enctype="multipart/form-data" action="<?php echo site_url().'checkout/register';?>" method="post">

            <div class="hgroup title">
                <h3>Customer login</h3>
                <h5>Please login using your existing account</h5>
            </div>

            <div class="box-content">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label" for="login_email">Email : </label>
                            <div class="controls">
                                <input class="col-sm-12" id="login_email" type="text" name="email" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6"> 
                        <div class="control-group">         
                            <label class="control-label" for="login_password">Password :</label>
                            <div class="controls">
                                <input class="col-sm-12" id="login_password" type="password" name="password">
                            </div>
                        </div>
                    </div>
                </div>  
            </div>

            <div class="buttons">
                <div class="pull-left">
                    <button type="submit" class="btn btn-success btn-small" name="login" value="Login">
                        Login
                    </button>
                    <a href="reset-password.html" class="btn btn-primary btn-small">
                        Reset my password
                    </a>
                </div>
            </div>               
        </form>   
    </div>
</div>
        </div>
        
        
        <div class="col-xs-12 col-sm-6">
          <div class="register">
               <div class="box">
                  <div class="hgroup title">
                      <h3>Want to Register?</h3>
                      <h5>Registration allows you to avoid filling in billing and shipping forms every time you checkout on this website. You'll also be able to track your orders with ease!</h5>
                  </div>

                    <div class="buttons">
                      <div class="pull-left">
                          <a href="#register" class="btn btn-success btn-small" data-toggle="modal" data-target=".bs-example2-modal-lg">
                          Register now &nbsp; <i class="icon-chevron-right"></i>
                          </a>
                     </div>
                    </div>
                </div>
            </div>
            <div class="guest">
                <div class="box">
                    <div class="hgroup title">
                        <h3>Checkout as Guest</h3>
                        <h5>Don't have an account and you don't want to register? Checkout as a guest instead!</h5>
                    </div>

                    <div class="buttons">
                        <div class="pull-left">
                            <a class="btn btn-small" href="checkout.html">
                             Checkout as guest &nbsp; <i class="icon-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
              </div>
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
            <div class="modal fade bs-example2-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                      <form onsubmit="return false;" enctype="multipart/form-data" action="#" method="post">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <div class="hgroup title">
                <h3>Register now</h3>
                <h5>Registered users get access to features such as order history and so much more!</h5>
            </div>
        </div>

        <div class="modal-body">

            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label" for="first_name">First name</label>
                        <div class="controls">
                            <input class="col-sm-12" type="text" id="first_name" name="first_name" value="">
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label" for="last_name">Last name</label>
                        <div class="controls">
                            <input class="col-sm-12" type="text" id="last_name" name="last_name" value="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="control-group">
                        <label class="control-label" for="email">Email address</label>
                        <div class="controls">
                            <input class="col-sm-12" type="text" id="email" name="email" value="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row"> 
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label" for="password">Password</label>
                        <div class="controls">
                            <input class="col-sm-12" type="password" id="password" name="password" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label" for="password_confirm">Password confirm</label>
                        <div class="controls">
                            <input class="col-sm-12" type="password" id="password_confirm" name="password_confirm" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-small" name="signup" value="Register">
                Register now &nbsp; <i class="icon-ok"></i>
            </button>
        </div>                           

    </form>
                  </div>
              </div>
  
  <div style="clear:both"></div>
</div>
<!-- /.main-container -->

<div class="gap"> </div>