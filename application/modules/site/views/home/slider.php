<?php
	$slides = $captions = '';
	//echo $banners->num_rows(); die();
  	if($banners->num_rows() > 0)
	{
		$banner_no = $banners->num_rows();
		
		$count = 0;
		foreach($banners->result() as $cat)
		{			
			$slideshow_id = $cat->slideshow_id;
			$slideshow_status = $cat->slideshow_status;
			$slideshow_name = $cat->slideshow_name;
			$slideshow_description = $cat->slideshow_description;
			$slideshow_image_name = $cat->slideshow_image_name;
			$active = '';
			$count++;
			
			$slides .= 
			'
				<img src="'.$slideshow_location.$slideshow_image_name.'" alt="'.$slideshow_name.'" title="#htmlcaption'.$count.'"  />
				
			';
			
			$captions .= 
			'
				<div id="htmlcaption'.$count.'" class="nivo-html-caption slider-caption-1">
					<div class="container slider-height">
						<div class="row slider-height">
							<div class="col-md-12 slider-height">
								<div class="slide-text">
									<div class="cap-title wow zoomInUp" data-wow-duration="0.8s" data-wow-delay="0.5s">
										<h2>'.$slideshow_name.'</h2>
									</div>
									<div class="cap-style wow zoomInUp" data-wow-duration="1.2s" data-wow-delay="1s">
										<h2>'.$slideshow_description.'</h2>
									</div>                                 
								</div>
							</div>
						</div>
					</div>  
				</div>
			';
		}
	}
	
?>
		<!-- slider start -->
        <div class="slider_area">
            <div class="container">
                <div class="row">
                    <div class="hidden-xs hidden-sm col-md-3"></div>
                    <div class="col-sm-12 col-md-9">
                        <div class="slider-area">
                            <div id="ensign-nivoslider" class="slides"> 
                                <?php //echo $slides;?>
								<img src="<?php echo base_url().'assets/images/banner1.png';?>" title="#htmlcaption1">
								<img src="<?php echo base_url().'assets/images/banner2.png';?>" title="#htmlcaption2">
								<img src="<?php echo base_url().'assets/images/banner3.png';?>" title="#htmlcaption3">
                            </div>
							
							<?php //echo $captions;?>
							<div id="htmlcaption1" class="nivo-html-caption slider-caption-1">
								<div class="container slider-height">
									<div class="row slider-height">
										<div class="col-md-12 slider-height">
											<div class="slide-text">
												<div class="cap-title wow zoomInUp" data-wow-duration="0.8s" data-wow-delay="0.5s">
													<h2></h2>
												</div>                              
											</div>
										</div>
									</div>
								</div>  
							</div>
							<div id="htmlcaption2" class="nivo-html-caption slider-caption-1">
								<div class="container slider-height">
									<div class="row slider-height">
										<div class="col-md-12 slider-height">
											<div class="slide-text">
												<div class="cap-title wow zoomInUp" data-wow-duration="0.8s" data-wow-delay="0.5s">
													<h2></h2>
												</div>                              
											</div>
										</div>
									</div>
								</div>  
							</div>
                            
							<div id="htmlcaption3" class="nivo-html-caption slider-caption-1">
								<div class="container slider-height">
									<div class="row slider-height">
										<div class="col-md-12 slider-height">
											<div class="slide-text">
												<div class="cap-title wow zoomInUp" data-wow-duration="0.8s" data-wow-delay="0.5s">
													<h2></h2>
												</div>                              
											</div>
										</div>
									</div>
								</div>  
							</div>
                            
                            
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <!-- slider end -->
		
		<!-- banner start -->
        <div class="banner_area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-7">
                        <div class="single_banner">
                            <a href="#"><img src="<?php echo base_url().'assets/themes/timeplus/';?>img/banner/banner_1.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5">
                        <div class="single_banner">
                            <a href="#"><img src="<?php echo base_url().'assets/themes/timeplus/';?>img/banner/banner_2.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- banner end -->
        