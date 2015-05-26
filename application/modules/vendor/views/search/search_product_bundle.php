<div class="row">
	<!-- Widget -->
	<div class="widget boxed">
	    <!-- Widget head -->
        <div class="widget-head">
            <h4 class="pull-left"><i class="fa fa-search"></i>Search all product bundles</h4>
            <div class="clearfix"></div>
        </div>      
	    
	    <!-- Widget content -->
	    <div class="widget-content">
	    	<div class="">
				<?php
				echo form_open("vendor/search-product-bundle", array("class" => "form-inline"));
	            ?>
                <div class="row">
                    <div class="col-md-12 col-lg-12 center-align">
                        <div class="form-group">
                            <label class="control-label">Bundle Name: </label>
                            <input type="text" class="form-control" name="product_bundle_name" placeholder="Bundle name">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-lg">Search</button>
                        </div>
                    </div>
	            </div>
	            <?php
	            echo form_close();
	            ?>
	    	</div>
	    </div>
	</div>
</div>