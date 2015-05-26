<div id="checkout-content">
<div class="box-header">                                                                                                    
    <h3>Payment method</h3>                                                 
</div>
<div class="box-content">
    <div class="shipping-methods">
        <div class="row">
            <div class="col-lg-4 col-md-4  col-sm-4">
                <div class="highlight">
                    <div class="hgroup title">
                        <h3>Paypal</h3>
                        <h5>Complete your order using Paypal</h5>
                    </div>

                    <div class="box-content highlight">
                        <div class="price">
                            <strong></strong>
                        </div>

                        <input type="radio" value="1" name="payment_option" id="option1" checked="checked">
                    </div>      
                </div>
            </div>
           
        </div>
    </div>
</div>



<div class="box-footer">
    <div class="pull-left">
        <a href="<?php echo site_url().'checkout-progress/payment';?>" class="btn btn-default btn-small">
            <i class="icon-chevron-left"></i> &nbsp; Shipping method
        </a>
    </div>

    <div class="pull-right">                            
        <a href="<?php echo site_url().'checkout-progress/review';?>" class="btn btn-primary btn-small">
            Order review &nbsp; <i class="icon-chevron-right"></i>
        </a>
    </div>
</div>          
</div>