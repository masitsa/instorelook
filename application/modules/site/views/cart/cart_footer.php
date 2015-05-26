<h3 class="text-right subtotal" id="cart_sub_total"> 
   	Subtotal: $ <?php echo $this->load->view('site/cart/cart_total', '', TRUE);?> 
</h3>
<div id="cart-footer-buttons">
<?php
if(count($this->cart->contents()) > 0)
{
	if($this->session->userdata('customer_id') > 0)
	{
	?>
	<a class="btn btn-sm btn-warning" href="<?php echo site_url().'save-order';?>"> Save Order </a>
	<?php
	}
	else
	{

	}


	?>
	<a class="btn btn-sm btn-success" href="<?php echo site_url().'cart';?>"> <i class="fa fa-shopping-cart"> </i> VIEW CART </a> 
	<a class="btn btn-sm btn-primary" href="<?php echo site_url().'checkout';?>"> CHECKOUT </a> 
	<?php
}
?>
</div>


