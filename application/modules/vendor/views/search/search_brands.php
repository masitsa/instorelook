<div class="row" style="background-color:#fff; margin-bottom:5px;">
	<!-- Widget -->
	<div class="widget boxed" >
	    <!-- Widget head -->
	    <div class="widget-head">
	        <h3 style="text-align:center;"><i class="icon-reorder"></i>Search All Brands
	        </h3>
	        <div class="widget-icons pull-right">
	            <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
	            <a href="#" class="wclose"><i class="icon-remove"></i></a>
	        </div>
	    
	    	<div class="clearfix"></div>
	    
	    </div>             
	    
	    <!-- Widget content -->
	    <div class="widget-content">
	    	<div class="padd">
				<?php
				
				
				echo form_open("vendor/search-brands", array("class" => "form-horizontal"));
				
	            
	            ?>
	            <div class="row">
		                <div class="col-md-12 col-lg-12">
		                    <div class="form-group center-align">
		                        <label class="col-sm-4 control-label">Brand Name: </label>
		                        
		                        <div class="col-sm-4">
		                            <input type="text" class="form-control" name="brand_name" placeholder="Brand Name">
		                        </div>
		                    </div>
		                </div>
	            </div>
	            
	            <div class="row center-align">
	            	<button type="submit" class="btn btn-info btn-lg">Search</button>
	            </div>
	            <?php
	            echo form_close();
	            ?>
	    	</div>
	    </div>
	</div>
</div>