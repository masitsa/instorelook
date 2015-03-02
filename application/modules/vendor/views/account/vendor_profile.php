<div class="row">
	<div class="col-md-12">
		<div class="row userInfo">
			<div class="col-md-12">
				<div class="checkout-progress">
					<h4>My account</h4>
					<div class="box">
							
						<!-- Checkout progress -->
						<div id="checkout-progress">
							<ul class="nav nav-tabs">
							<?php echo $this->vendor_model->get_navigation($page_name);?>
							</ul>                   
						</div>
						<!-- End id="checkout-progress" -->
						<?php 
						if($page_name == 'personnal')
						{
							echo $this->load->view('account/personnal', '', true);
						}
						else if($page_name == 'subscription')
						{
							echo $this->load->view('account/subscription', '', true);
						}
						else
						{
							echo $this->load->view('account/business', '', true);
						}
						
						?>
					
					
					</div>
					
				</div>
				
			</div>
			
        </div> <!--/row end--> 
        
    </div>
</div> <!--/row-->