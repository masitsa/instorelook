<?php
$surburbs = $this->site_model->get_surburbs();
$surburb_list = '';
$count = 0;

if($surburbs->num_rows() > 0)
{
	$surburbs_result = $surburbs->result();
	
	foreach($surburbs_result as $sel)
	{
		$count++;
		$surburb_name = $sel->surburb_name;
		$state_abbr = $sel->state_abbr;
		$post_code = $sel->post_code;
		$surburb_id = $sel->surburb_id;
		
		if($count == $surburbs->num_rows())
		{
			$surburb_list .= '"'.$surburb_name.' '.$state_abbr.' '.$post_code.'"';
		}
		
		else
		{
			$surburb_list .= '"'.$surburb_name.' '.$state_abbr.' '.$post_code.'", ';
		}
	}
}
?>

		<!-- footer start -->
        <footer class="footer_area">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
                        <div class="footer_widget">
                            <h4>Support</h4>
                        </div>
                        <div class="contact_info_footer">
                            <ul>
                                <li>
                                    <span class="lbl">Email</span>
                                    <p>info@shopyard.co.ke</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 hidden-sm hidden-md col-lg-2">
                        <div class="footer_widget">
                            <h4>Our Store</h4>
                            <ul class="toggle-footer" style="">
								<li class="item">> <a href="<?php echo base_url();?>home"> Home </a> </li>
								<li class="item">> <a href="<?php echo base_url();?>products"> Products </a> </li>
								<li class="item">> <a href="<?php echo base_url();?>vendors/all-vendors"> Vendors </a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 hidden-sm hidden-md col-lg-2">
                        <div class="footer_widget">
                            <h4>Information</h4>
                            <ul class="toggle-footer" style="">
							<li class="item"> <a href="<?php echo base_url();?>cart"> Cart </a> </li>
							<li class="item"> <a href="<?php echo base_url();?>about"> About us </a> </li>
							<li class="item"> <a href="<?php echo base_url();?>terms"> Terms &amp; Conditions </a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2">
                        <div class="footer_widget">
                            <h4>My Account</h4>
                            <ul class="toggle-footer" style="">
							<li class="item"> <a href="<?php echo base_url();?>sign-in"> Login </a> </li>
							<li class="item"> <a href="<?php echo base_url();?>join"> My Account </a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                        <div class="footer_widget">
                            <h4>Newsletter</h4>
                            <p>Subscribe to our mailing list to receive updates on new arrivals, special offers and other discount information.</p>
                            <form method="post" action="<?php echo site_url().'site/newsletter';?>">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter your e-mail" id="newsletter-input">
                                    <button class="button-small" type="submit">
                                        <span>Ok</span>
                                    </button>
                                </div>
                            </form>
                            <div id="social_block">
                                <a href="index.html#" class="facebook"><i class="fa fa-facebook"></i></a>
                                <a href="index.html#" class="twitter"><i class="fa fa-twitter"></i></a>
                                <a href="index.html#" class="rss"><i class="fa fa-instagram"></i></a>
                                <a href="index.html#" class="youtube"><i class="fa fa-pinterest"></i></a>
                                <a href="index.html#" class="google"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer end -->
            <!-- footer bottom start-->
            <div class="footer_bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="copyright">
                                <p>COPYRIGHT &copy; <?php echo date('Y')?> <a href="https://www.omnis.co.ke/">Omnis Limited</a> ALL RIGHTS RESERVED</p>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </footer>
        <!-- footer bottom end -->
