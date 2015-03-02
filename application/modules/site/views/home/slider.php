 <?php
  	if($banners->num_rows() > 0)
	{
		$banner_no = $banners->num_rows();
		?>
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
			<ol class="carousel-indicators">
			<?php
            for($r = 0; $r < $banner_no; $r++)
            {
                if($r == 0)
                {
                    $active = 'active';
                }
                else
                {
                    $active = '';
                }
                ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?php echo $r;?>" class="<?php echo $active;?>"></li>
                <?php
            }
            ?>
            </ol>
            
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
        <?php
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
			
			if($count == 1)
			{
				$active = 'active';
			}
			
			echo
			'
				<div class="item '.$active.'">
					<img src="'.$slideshow_location.$slideshow_image_name.'">
					<div class="carousel-caption">
						<h3>'.$slideshow_name.'</h3>
						<p>'.$slideshow_description.'</p>
					</div>
				</div>
			';
		}
		?>
  		</div>
  <?php
	if ($banner_no > 0)
	{
		?>
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
<?php
    }
	}
  ?>
    <!--<div class="item active">
    	<img src="http://placehold.it/1200x400/16a085/ffffff&text=About Us">
      <div class="carousel-caption">
        <h3>Headline</h3>
                <p>
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Lorem
                    ipsum dolor sit amet, consetetur sadipscing elitr.</p>
      </div>
    </div>
    <div class="item">
            <img src="http://placehold.it/1200x400/e67e22/ffffff&text=Projects">
      <div class="carousel-caption">
        <h3>Headline</h3>
                <p>
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Lorem
                    ipsum dolor sit amet, consetetur sadipscing elitr.</p>
      </div>
    </div>
    <div class="item">
            <img src="http://placehold.it/1200x400/8e44ad/ffffff&text=Services">
      <div class="carousel-caption">
        <h3>Headline</h3>
                <p>
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Lorem
                    ipsum dolor sit amet, consetetur sadipscing elitr.</p>
      </div>
    </div>-->

  <!-- Controls -->