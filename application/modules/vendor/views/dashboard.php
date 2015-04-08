<input type="hidden" value="<?php echo site_url();?>" id="config_url" />
<div class="divider-line"></div>
<h1 class="center-align">My dashboard</h1>
<div class="divider-line" style="margin-bottom:2%;"></div>

<?php echo $this->load->view('dashboard/line_graph');?>
        
<?php echo $this->load->view('dashboard/bar_graph');?>
<?php echo $this->load->view('dashboard/orders');?>


<!-- jQuery Flot -->
<script src="<?php echo base_url()."assets/themes/bluish";?>/js/excanvas.min.js"></script>
<script src="<?php echo base_url()."assets/themes/bluish";?>/js/jquery.flot.js"></script>
<script src="<?php echo base_url()."assets/themes/bluish";?>/js/jquery.flot.resize.js"></script>
<script src="<?php echo base_url()."assets/themes/bluish";?>/js/jquery.flot.pie.js"></script>
<script src="<?php echo base_url()."assets/themes/bluish";?>/js/jquery.flot.stack.js"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/themes/bluish/js/vendor_reports.js';?>"></script>