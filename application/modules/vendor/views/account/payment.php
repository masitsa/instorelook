<?php
	if($vendor_details->num_rows() > 0)
	{
		$vendor_payment_email_error = '';
		
		$vendor = $vendor_details->row();
		$validation_errors = validation_errors();
		
		//repopulate form data if validation errors are present
		if(!empty($validation_errors))
		{
			//create errors
			$vendor_payment_email_error = form_error('vendor_payment_email');
			
			//repopulate fields
			$vendor_payment_email = set_value('vendor_payment_email');
		}
		
		//populate form data on initial load of page
		else
		{
			$vendor_payment_email = $vendor->vendor_payment_email;
		}
		$vendor_email = $vendor->vendor_email;
		
		if(empty($vendor_payment_email))
		{
			$vendor_payment_email = $vendor_email;
		}
?>
<p class="center-align">
	In Store Look will send you the payment for orders made to you via Paypal. 
</p>

<p class="center-align" style="padding-bottom:20px;">
	By default all payments will be sent to the email address which you used to register on In Store Look. Kindly ensure that this email address is registered with Paypal otherwise please provide an alternative email address which has been registered at Paypal where we can send your payments.
</p>

<h3 class="center-align">Update your payment email</h3>
<div class="row" style="padding-bottom:20px;">
    <?php echo form_open('vendor/account/update_paypal_email', array("class" => "form-horizontal", "role" => "form"));?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-lg-4 control-label">Payment email</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" name="vendor_payment_email" placeholder="Payment email" value="<?php echo $vendor_payment_email;?>">
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-actions center-align">
        <button class="submit btn btn-primary" type="submit">
            Update payment email
        </button>
    </div>
    <?php echo form_close();?>
</div>      	
    <?php			
	}
	
	else
	{
		echo '<div class="alert alert-danger center-align"><strong>Error!</div>Unable to load your account details</div>';
	}
?>
<script src="<?php echo base_url().'assets/themes/tinymce/js/';?>tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
	menubar: "edit insert view format table tools",
    selector: "textarea",
    theme: "modern",
    skin: "light",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});
	
	//toggle shipping
	$(document).on("click","#method_shipping input",function()
	{
		var method = $(this).val();
		
		if(method == '1')
		{
			$('#show_auspost').css('display', 'block');
			$('#show_fixed_rate').css('display', 'none');
			$('#show_pick_up').css('display', 'none');
		}
		
		else if(method == '2')
		{
			$('#show_auspost').css('display', 'none');
			$('#show_fixed_rate').css('display', 'block');
			$('#show_pick_up').css('display', 'none');
		}
		
		else if(method == '3')
		{
			$('#show_auspost').css('display', 'none');
			$('#show_fixed_rate').css('display', 'none');
			$('#show_pick_up').css('display', 'block');
		}
	});
</script>
