
<div class="row top-navigation">
    <div class="breadcrumbDiv col-lg-12">
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
				<select class="form-control" name="orderby" id="sort_vendor">
                    <option selected="vendor.vendor_created" >Default Sorting (Newness)</option>
                    <option value="surburb.post_code">Post code</option> 
                    <option value="vendor.vendor_store_name">Business name</option>
				</select>
            </div>
        </div>
    </div>
</div>  <!-- /.row  --> 