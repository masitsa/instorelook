<div class="box">
    <?php 
		$attributes = array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'estimate_shipping');
		echo form_open('site/estimate_shipping', $attributes);
	?>

        <div class="box-header">
            <h3>Shipping estimator</h3>
            <h5>Get an estimated shipping cost for your order</h5>
        </div>

        <div class="box-content">
            <div class="row">

                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Post code from <span class="required">*</span></label>
                        <div class="col-sm-8">
                        	<input class="form-control" name="from_postcode"/>
                        </div>
                    </div>
                </div>

                 <div class="col-lg-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Post code to <span class="required">*</span></label>
                        <div class="col-sm-8">
                        	<input class="form-control" name="to_postcode"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">
        	<button type="submit" class="btn btn-success btn-lg" data-toggle="modal" data-target=".bs-example-modal-lg">Estimate shipping cost</button>
        </div>
    <?php echo form_close();?>
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
				<div class="sp-loading"><img src="<?php echo site_url().'assets/themes/image_viewer/';?>images/sp-loading.gif" alt=""><br>Calculating shipping estimate...</div>
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
