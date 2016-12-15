
		<div class="cart_shipping">
			<!--<h2 class="shipping">Shipping <strong>$7.00</strong></h2>-->
			<h2 class="total">Total <strong>Kes <?php echo $this->load->view('site/cart/cart_total', '', TRUE);?> </strong></h2>
		</div>
		<div class="check_out text-center">
			
			<?php
			if(count($this->cart->contents()) > 0)
			{
				if($this->session->userdata('customer_id') > 0)
				{
				?>
				<h1><a href="<?php echo site_url().'save-order';?>">Save Order</a></h1>
				<?php
				}
				else
				{

				}


				?>
				<h1><a href="<?php echo site_url().'cart';?>">View Cart</a></h1>
				<h1><a href="<?php echo site_url().'checkout';?>">Check Out</a></h1>
				<?php
			}
			?>
			
		</div>

