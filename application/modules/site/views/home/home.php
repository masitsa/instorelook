<div class="container">
	<div class="row">
        
    	<div class="col-md-12 col-lg-12" style="padding:0; margin-bottom:10px;">
            <!-- Slider -->
            <?php echo $this->load->view('home/slider', '', TRUE); ?>
        </div>
	</div>
    
    <div class="row">
        
    	<div class="col-md-3" style="padding:0; padding-right:15px;">
        	<?php echo $this->load->view('home/home_left_navigation');?>
        </div>
        
    	<div class="col-md-9 col-lg-9" style="padding:0;">
            
            <!-- New Arrivals -->
            <?php echo $this->load->view('home/latest', '', TRUE); ?>
            
            <!-- Featured -->
            <?php echo $this->load->view('home/featured', '', TRUE); ?>
        </div>
	</div>
</div>
</div>