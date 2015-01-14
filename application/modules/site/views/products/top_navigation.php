
<div class="row top-navigation">
    <div class="breadcrumbDiv col-lg-12">
		<div class="row">
        	<div class="col-md-4">
            	<p>Showing <?php echo $first;?> – <?php echo $last;?> of <?php echo $total;?> results</p>
            </div>
        	<div class="col-md-4">
            </div>
        	<div class="col-md-4">
				<select class="form-control" name="orderby" id="sort_products">
                    <option selected="created" >Default Sorting (Newness)</option>
                    <option value="popularity">Sort by popularity</option> 
                    <option value="rating">Sort by average rating</option>
                    <option value="product_date">Sort by newness</option>
                    <option value="price">Sort by Price: low to high</option>
                    <option value="price_desc">Sort by Price: high to low</option>
				</select>
            </div>
        </div>
    </div>
</div>  <!-- /.row  --> 