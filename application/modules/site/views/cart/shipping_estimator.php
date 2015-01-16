<div class="box">
    <form enctype="multipart/form-data" action="#" method="post" onsubmit="return false;">

        <div class="box-header">
            <h3>Shipping estimator</h3>
            <h5>Get an estimated shipping cost for your order</h5>
        </div>

        <div class="box-content">
            <div class="row">

                <div class="col-lg-4">
                    <label for="country">Country</label>
                    <select  id="country" class="form-control" name="country">
                        <option value="3">Australia</option>
                        <option value="2">Canada</option>
                        <option value="17" selected="selected">United Kingdom</option>
                        <option value="1">United States</option>
                    </select>
                </div>

                 <div class="col-lg-4">
                    <label for="country">Country</label>
                    <select  id="country" class="form-control" name="country">
                        <option value="3">Australia</option>
                        <option value="2">Canada</option>
                        <option value="17" selected="selected">United Kingdom</option>
                        <option value="1">United States</option>
                    </select>
                </div>

                <div class="col-lg-4">
                    <label>ZIP</label>
                    <input  type="text" name="zip" class="form-control" value="">
                </div>

            </div>
        </div>

        <div class="box-footer">
            <a class="btn btn-default btn-small" href="#" data-toggle="modal" data-target=".bs-example-modal-lg">Estimate shipping cost</a>
        </div>
    </form>
</div>



<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
			 <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <div class="hgroup title">
                <h3>Shipping estimator</h3>
                <h5>Get an estimated shipping cost for your order</h5>
            </div>
        </div>

        <div class="modal-body">
            <div id="shipping_options">
                <table class="table table-striped table-bordered">                                         
                    <tbody><tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                    <tr>
                        <td>Free shipping</td>
                        <td>Delivered to your letterbox within 7-14 working days</td>
                        <td>£0.00</td>
                    </tr>
                    <tr>
                        <td>Standard</td>
                        <td>Delivered to your letterbox within 5 working days</td>
                        <td>£4.95</td>
                    </tr>
                    <tr>
                        <td>Speedy</td>
                        <td>Delivered to your letterbox within 3 working days</td>
                        <td>£8.95</td>
                    </tr>                                                
                </tbody></table>
                
            </div>
        </div>

        <div class="modal-footer">
            <div class="pull-right">
               <a href="<?php echo site_url().'checkout';?>" class="btn btn-primary btn-small">
    				Proceed to checkout &nbsp; <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
				</a>
            </div>
        </div>
			</div>
</div>
