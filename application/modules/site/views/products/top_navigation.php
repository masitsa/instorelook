<div class="content_scene_cat">
	<div class="content_banner">
	   <a class="white-hover" href="#"><img src="<?php echo base_url().'assets/themes/timeplus/';?>img/banner/banner_10.jpg" alt=""></a>
	</div>
</div>    
<h1 class="page-heading product-listing">
   <span class="cat-name">Products</span>
   <span class="heading-counter"><span class="heading-counter">Showing <?php echo $first;?> – <?php echo $last;?> of <?php echo $total;?> results</span></span>
</h1> 
<div class="content_sortPagiBar clearfix">
	<div class="sortPagiBar clearfix">
		<ul class="display" role="tablist">
			<li class="display-title">View:</li>
			<li role="presentation" class=" active"><a href="#grid" aria-controls="grid" role="tab" data-toggle="tab"><i class="fa fa-th-large"></i>Grid</a></li>
			<li role="presentation"><a href="#list" aria-controls="list" role="tab" data-toggle="tab"><i class="fa fa-th-list"></i>List</a></li>
		</ul>
		<div class="shop-tab-selectors">
			<form class="sort-form" action="#">
				<label>Sort by</label>
				<div class="selector" style="width: 190px;">
					<select class="selectProductSort form-control" name="orderby" id="sort_products">
						<option selected="created" >Default Sorting (Newness)</option>
						<option value="clicks">Sort by popularity</option> 
						<option value="product_rating">Sort by average rating</option>
						<option value="created">Sort by newness</option>
						<option value="price">Sort by Price: low to high</option>
						<option value="price_desc">Sort by Price: high to low</option>
					</select>
				</div>
			</form>
			
		</div>
	</div>
</div>
