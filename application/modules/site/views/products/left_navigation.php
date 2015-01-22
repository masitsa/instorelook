<?php $price_range = $this->site_model->generate_price_range();?>
<style type="text/css">
	div.brand-checkbox input[type="checkbox"] {
		display: none;
		margin: 4px 0 0 -20px;
	}
</style>
    	<section class="left-nav">
            
        	<!-- Filter Brand -->
        	<h4>Brand</h4>
            <div class="product-brand-filter">
                <form action="<?php echo site_url().'products/filter-brands';?>" id="filter_brand" method="POST">
                <?php
                    if($brands->num_rows() > 0)
                    {
                        $brands_result = $brands->result();
                        
                        foreach($brands_result as $brand)
                        {
                            $brand_name = $brand->brand_name;
                            $brand_id = $brand->brand_id;
                            
                            echo 
                            '
                                <div class="block-element">
                                    <label> <input type="checkbox" name="brand[]" value="'.$brand_id.'"  /> '.$brand_name.' </label>
                                </div>
                
                            ';
                        }
                    }
                ?>
                <div class="center-align">
                    <button type="submit" class="btn btn-primary center-align">Filter Brands</button>
                </div>
                </form>
            </div>
        	<!-- End: Filter Brand -->
        	<!-- Filter Price -->
        	<h4>Price</h4>
            <div class="product-price-filter">
                <form action="<?php echo site_url().'products/price_range';?>" id="filter_price">
    				<?php echo $price_range;?>
                    <button type="submit" class="btn btn-default">Filter Price</button>
                    </form>
                    <hr>
                    <p>Enter a Price range </p>
                    <form class="form-inline price_range" role="form" action="<?php echo site_url().'products/price_range';?>" id="filter_custom_price">
                    <div class="form-group">
                    <input type="text" class="form-control col-md-2" name="start_price" placeholder="2000">
                    </div>
                    <div class="form-group sp"> - </div>
                    <div class="form-group">
                    <input type="text" class="form-control col-md-2" name="end_price" placeholder="3000">
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
        	<!-- End: Filter Price -->
		</section>
    
<script type="text/javascript">

//Sort by price range
$(document).on("submit","form#filter_price",function(e)
{
	e.preventDefault();
	
	var range = $('input[name="agree"]:checked').val();
	
	window.location.href = '<?php echo site_url();?>products/price-range/'+range;
});

//Sort by custom price range
$(document).on("submit","form#filter_custom_price",function(e)
{
	e.preventDefault();
	
	var start = $('input[name="start_price"]').val();
	var end = $('input[name="end_price"]').val();
	
	window.location.href = '<?php echo site_url();?>products/price-range/'+start+'-'+end;
});
</script>