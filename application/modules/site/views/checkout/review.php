<div id="checkout-content">
    <div class="box-header">                                                                                                    
        <h3>Order Review</h3>
        <h5>Review your order.</h5>                                                    
    </div>
    <?php
		$error_message = $this->session->userdata('error_message');
		if(!empty($error_message))
		{
			echo '<div class="alert alert-danger center-align"> Oh snap! '.$error_message.' </div>';
			$this->session->unset_userdata('error_message');
		}
	?>
    <?php echo $this->load->view('cart/cart');?>
    
    <div class="box-footer">
        <div class="pull-left">
            <a href="<?php echo site_url().'checkout-progress/payment';?>" class="btn btn-default btn-small">
                <i class="icon-chevron-left"></i> &nbsp; Payment method
            </a>
        </div>
    
        <div class="pull-right">                            
            <a href="<?php echo site_url().'save-order';?>" class="btn btn-warning btn-small">
                Save order &nbsp; <i class="glyphicon glyphicon-save"></i>
            </a>                     
            <a href="<?php echo site_url().'checkout/confirm-order';?>" class="btn btn-primary btn-small">
                Confirm Order &nbsp; <i class="icon-chevron-right"></i>
            </a>
        </div>
    </div>					
</div>