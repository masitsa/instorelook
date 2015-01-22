<?php

	//communication messages
	$success_message = $this->session->userdata('completion_success_message');
	$error_message = $this->session->userdata('completion_error_message');
?>

<div id="checkout-content">
<div class="box-header">                                                                                                    
    <h3>Order Confirmation</h3>                                                    
</div>



<div class="box-content">
    <div class="shipping-methods">
        <div class="row">
            <div class="col-lg-12">
                
				<?php
                    if(!empty($success_message))
                    {
                        echo '<div class="alert alert-success">'.$success_message.'</div>';
                        $this->session->unset_userdata('completion_success_message');
                    }
                    if(!empty($error_message))
                    {
                        echo '<div class="alert alert-danger">'.$error_message.'</div>';
                        $this->session->unset_userdata('completion_error_message');
                    }
                ?>
            </div>
           
        </div>
    </div>
</div>



<div class="box-footer">
    <div class="pull-left">
        <a href="<?php echo site_url().'products';?>" class="btn btn-default btn-small">
            <i class="icon-chevron-left"></i> &nbsp; Keep shopping
        </a>
    </div>

    <div class="pull-right">                            
        <a href="<?php echo site_url().'account';?>" class="btn btn-primary btn-small">
            My account &nbsp; <i class="icon-chevron-right"></i>
        </a>
    </div>
</div>          
</div>