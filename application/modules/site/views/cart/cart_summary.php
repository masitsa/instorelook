<div class="cart-details">
    <div class="box">
        <div class="hgroup title">
            <h3>Order totals <?php echo $this->cart->total_items();?> items</h3>
            <h5>Shipping costs and taxes will be evaluated during checkout</h5>
         </div>

         <ul class="price-list">
            <li>Subtotal: <strong>$ <?php echo $this->load->view('cart/cart_total');?></strong></li>
            <li class="important">Total: <strong>$ <?php echo $this->load->view('cart/cart_total');?> </strong></li>
        </ul>
    </div>
</div> 

<div class="coupon">
                                <div class="box">
                                    <div class="hgroup title">
                                        <h3>Coupon code</h3>
                                        <h5>Enter your coupon here to redeem</h5>
                                    </div>

                                    <form enctype="multipart/form-data" action="#" method="post" onsubmit="return false;">
                                        
                                        <label for="coupon_code">Coupon code</label>
                                        <div class="input-append">
                                            <input id="coupon_code" value="" type="text" name="coupon">

                                            <button type="submit" class="btn" value="Apply" name="set_coupon_code">
                                                <span class="glyphicon glyphicon-ok"></span>
                                            </button>
                                        </div>

                                    </form>             
                                </div>
                            </div>                              