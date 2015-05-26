<div class="row">
<div class="col-md-12">
    <div class="widget boxed">
        <div class="widget-head">
            <h4 class="pull-left"><i class="icon-reorder"></i>Total orders for the last 7 days</h4>
                <div class="pull-right">
                	<a href="<?php echo site_url().'vendor/all-orders'?>" class="btn btn-sm btn-info">View all orders</a>
                </div>
            <div class="clearfix"></div>
                
        </div>
    
    <div class="widget-content">
        <div class="padd">
        
            <!-- Curve chart -->
            
            <div id="curve-chart"></div>
            
            <div id="curve-chart2"></div>
            <hr />
            <!-- Hover location -->
            <div id="hoverdata">
                Mouse hovers at
                (<span id="x">0</span>, <span id="y">0</span>). <span id="clickdata"></span>
            </div>          
            
            <!-- Skil this line. <div class="uni"><input id="enableTooltip" type="checkbox">Enable tooltip</div> -->
        </div>
    </div>
    </div>
</div>
</div>