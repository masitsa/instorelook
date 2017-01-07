<?php
$total_items = count($this->cart->contents());
?>
<div class="shopping_cart">
	<a href="index.html#">
		<img src="<?php echo base_url().'assets/themes/timeplus/';?>img/icon/icon_cart.png" alt="">
		<span><?php echo $total_items;?></span>
	</a>
	<div class="mini-cart-content">
		<div class="total_cart">
			
			<?php echo $this->cart_model->get_mini_cart();?>
			
		</div> 
		<?php echo $this->load->view('site/cart/cart_footer', '', TRUE);?>
		
		<div class="clear"></div>
	</div>
</div>    
                        