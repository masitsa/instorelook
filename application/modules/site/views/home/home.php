
    	<!-- Slider -->
        <?php echo $this->load->view('home/slider', '', TRUE); ?>
        
    	<!-- New Arrivals -->
        <?php echo $this->load->view('home/latest', '', TRUE); ?>
        
    	<!-- Parallax -->
        <?php echo $this->load->view('home/paralax', '', TRUE); ?>
        
    	<!-- Featured -->
        <?php echo $this->load->view('home/featured', '', TRUE); ?>
        
    	<!-- Parallax 2 -->
        <?php echo $this->load->view('home/paralax2', '', TRUE); ?>

<!-- include custom script for only homepage  --> 
<script src="<?php echo base_url().'assets/themes/tshop/';?>js/home.js"></script> 