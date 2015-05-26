<div class="row">
<div class="col-md-12">

  <!-- Widget -->
  <div class="widget boxed">
    <!-- Widget head -->
    <div class="widget-head">
      <h4 class="pull-left"><i class="icon-reorder"></i>Total sales per category</h4>
                <div class="pull-right">
                	<a href="<?php echo site_url().'vendor/all-categories'?>" class="btn btn-sm btn-info">Manage categories</a>
                	<a href="<?php echo site_url().'vendor/all-products'?>" class="btn btn-sm btn-success">Manage products</a>
                </div>
      <div class="clearfix"></div>
                
    </div>             

    <!-- Widget content -->
    <div class="widget-content">
      <div class="padd">

        <!-- Bar chart (Blue color). jQuery Flot plugin used. -->
        <div id="bar-chart"></div>
        <hr />

      </div>
    </div>
    <!-- Widget ends -->

  </div>
</div>
</div>