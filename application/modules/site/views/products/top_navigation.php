
<div class="row top-navigation">
    <div class="breadcrumbDiv col-md-12 col-sm-12 col-lg-12">
		<div class="row">
        	<div class="col-md-4">
            	<p>Showing <?php echo $first;?> – <?php echo $last;?> of <?php echo $total;?> results</p>
            </div>
        	<div class="col-md-4">
                <div class="cbp-vm-options">
                    <a href="#" class="cbp-vm-icon cbp-vm-grid cbp-vm-selected" data-view="cbp-vm-view-grid">Grid View</a>
                    <a href="#" class="cbp-vm-icon cbp-vm-list" data-view="cbp-vm-view-list">List View</a>
                </div>
            </div>
        	<div class="col-md-4">
				<select class="form-control" name="orderby" id="sort_products">
                    <option selected="created" >Default Sorting (Newness)</option>
                    <option value="clicks">Sort by popularity</option> 
                    <option value="product_rating">Sort by average rating</option>
                    <option value="created">Sort by newness</option>
                    <option value="price">Sort by Price: low to high</option>
                    <option value="price_desc">Sort by Price: high to low</option>
				</select>
            </div>
        </div>
    </div>
</div>  <!-- /.row  --> 