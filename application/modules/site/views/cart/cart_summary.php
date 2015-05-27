<?php
	$cart_items = $this->cart->total_items();
	
	if($cart_items == 1)
	{
		$item_title = 'item';
	}
	
	else
	{
		$item_title = 'items';
	}
?>
<div class="summary-cart">
     <h4><i class="glyphicon glyphicon-shopping-cart"></i>Order Details</h4>
    <div class="cart-details">
       
        <div class="box">
            <div class="hgroup title">
                 <?php echo $this->cart_model->get_side_cart();?>
             </div>

             <ul class="price-list">
             <table style="width:100%;">
                 <tr>
                     <td style="width:35%;"></td>
                     <td style="width:42%;">Shipping Cost:</td>
                     <td style="width:50%;">$ <?php echo $this->load->view('cart/shipping_total');?></td>
                 </tr>
                 <tr>
                     <td style="width:35%;"></td>
                     <td style="width:42%;">Total Cost:</td>
                     <td style="width:50%;"> $ <?php echo $this->load->view('cart/cart_total');?></td>
                 </tr>
             </table>
             
                <!--<li>Subtotal: <strong>$ <?php echo $this->load->view('cart/cart_total');?></strong></li>-->
                
            </ul>

        </div>
    </div> 
</div>
<!--<div class="coupon">
    <h4><i class="glyphicon glyphicon-shopping-cart"></i>Coupon code</h4>
    <div class="box">
        <div class="hgroup title">
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
</div> -->                             