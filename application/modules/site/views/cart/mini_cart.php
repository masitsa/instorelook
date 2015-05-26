<!--- this part will be hidden for mobile version -->
<div class="nav navbar-nav navbar-right hidden-xs">
    <div class="dropdown  cartMenu "> 
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
			<i class="glyphicon glyphicon-shopping-cart"> </i>
			<span class="cartRespons" id="mini_menu_cart_total"> Cart ($<?php echo $this->load->view('site/cart/cart_total', '', TRUE);?>) </span> 
			<b class="caret"> </b> 
		</a>
		<div class="dropdown-menu col-lg-12 col-xs-12 col-md-4 ">
			<div class="w100 miniCartTable scroll-pane" id="mini_menu_cart">
				<?php echo $this->cart_model->get_cart();?>
			</div>
			<!--/.miniCartTable-->
		
			<div class="miniCartFooter text-right" id="mini-cart-footer">
				<?php
					echo $this->load->view('site/cart/cart_footer', '', TRUE);
				?>
			</div>
			<!--/.miniCartFooter--> 
		
		</div>
		<!--/.dropdown-menu--> 
	</div><!--/.cartMenu-->
</div><!--/.navbar-nav-->