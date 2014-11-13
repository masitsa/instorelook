
  
  <div class="width100 section-block">
    <h3 class="section-title"><span> BRANDS</span> <a id="nextBrand" class="link pull-right carousel-nav"> <i class="fa fa-angle-right"></i></a> <a id="prevBrand" class="link pull-right carousel-nav"> <i class="fa fa-angle-left"></i> </a> </h3>
    <div class="row">
      <div class="col-lg-12">
        <ul class="no-margin brand-carousel owl-carousel owl-theme">
        <?php
			if($brands->num_rows() > 0)
			{
				$active_brands = $brands->result();
				
				foreach($active_brands as $brand)
				{
					$brand_id = $brand->brand_id;
					$brand_name = $brand->brand_name;
					$brand_image = $brand->brand_image_name;
					
					if($brand_id > 0)
					{
						echo '<li><a href="'.site_url().'products/brand/'.$brand_id.'"><img src="'.base_url()."assets/images/brands/".'thumbnail_'.$brand_image.'" alt="'.$brand_name.'" ></a></li>';
					}
				}
			}
			else
			{
				echo '<li>There are no brands :-(</li>';
			}
		?>
        </ul>
      </div>
    </div>
    <!--/.row--> 
  </div>
  <!--/.section-block--> 