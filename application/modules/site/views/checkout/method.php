<div id="checkout-content">
<div class="box-header">                                                                                                    
    <h3>Shipping method</h3>
    <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h5>                                                    
</div>



<div class="box-content">
    <div class="shipping-methods">
        <div class="row">
            <div class="col-lg-4 col-md-4  col-sm-4">
                <div class="highlight">
                    <div class="hgroup title">
                        <h3>Free shipping</h3>
                        <h5>Delivered to your letterbox within 7-14 working days</h5>
                    </div>

                    <div class="box-content highlight">
                        <div class="price">
                            <strong>FREE!</strong>
                        </div>

                        <input type="radio" value="1" class="form-control" name="shipping_option" id="option1">
                    </div>			
                </div>
            </div>
            <div class="col-lg-4 col-md-4  col-sm-4">
                <div class="highlight">
                    <div class="hgroup title">
                        <h3>Standard</h3>
                        <h5>Delivered to your letterbox within 5 working days</h5>
                    </div>

                    <div class="box-content highlight">
                        <div class="price">
                            <strong>£4.95</strong>
                        </div>

                        <input type="radio" class="form-control" value="2" name="shipping_option" id="option2">
                    </div>			
                </div>
            </div>
            <div class="col-lg-4 col-md-4  col-sm-4">
                <div class=" highlight">
                    <div class="hgroup title">
                        <h3>Speedy</h3>
                        <h5>Delivered to your letterbox within 3 working days</h5>
                    </div>

                    <div class="box-content highlight">
                        <div class="price">
                            <strong>£8.95</strong>
                        </div>

                        <input type="radio" value="3" class="form-control" name="shipping_option" id="option3">
                    </div>			
                </div>
            </div>
        </div>
    </div>
</div>



<div class="box-footer">
    <div class="pull-left">
        <a href="<?php echo site_url().'checkout-progress/shipping';?>" class="btn btn-default btn-small">
            <i class="icon-chevron-left"></i> &nbsp; Shipping address
        </a>
    </div>

    <div class="pull-right">                                                    
        <a href="<?php echo site_url().'checkout-progress/payment';?>" class="btn btn-primary btn-small">
            Payment method &nbsp; <i class="icon-chevron-right"></i>
        </a>
    </div>
</div>					
</div>