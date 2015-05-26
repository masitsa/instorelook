<?php
	if($vendor_details->num_rows() > 0)
	{
		$vendor_shipping_error = '';
		$vendor_shipping_rate_error = '';
		
		$vendor = $vendor_details->row();
		$validation_errors = validation_errors();
		
		//repopulate form data if validation errors are present
		if(!empty($validation_errors))
		{
			//create errors
			$vendor_shipping_error = form_error('vendor_shipping');
			$vendor_shipping_rate_error = form_error('vendor_shipping_rate');
			
			//repopulate fields
			$vendor_shipping = set_value('vendor_shipping');
			$vendor_shipping_rate = set_value('vendor_shipping_rate');
		}
		
		//populate form data on initial load of page
		else
		{
			$vendor_shipping = $vendor->vendor_shipping;
			$vendor_shipping_rate = $vendor->vendor_shipping_rate;
		}

		if($vendor_shipping == 1)
		{
			$auspost = 'checked="checked"';
			$auspost_style = 'display:block';
			$pick_up = '';
			$pick_up_style = 'display:none';
			$fixed_rate = '';
			$fixed_rate_style = 'display:none';
		}
		
		else if($vendor_shipping == 2)
		{
			$auspost = '';
			$auspost_style = 'display:none';
			$pick_up = '';
			$pick_up_style = 'display:none';
			$fixed_rate = 'checked="checked"';
			$fixed_rate_style = 'display:block';
		}
		
		else
		{
			$auspost = '"';
			$auspost_style = 'display:none';
			$pick_up = 'checked="checked"';
			$pick_up_style = 'display:block';
			$fixed_rate = '';
			$fixed_rate_style = 'display:none';
		}
?>
<p class="center-align">
	On this page you can update you preffered shipping method. In Store Look offers 3 methods by which your customers can pick their orders. Either:
</p>

<div class="row">
	<div class="col-md-12">
        <ol style="list-style:decimal;">
            <li>Pick up from your store at no extra cost to the customer</li>
            <li>You deliver to the customer and charge a fixed rate</li>
            <li>You use a third party, Auspost to deliver the order to your customer. Auspost fees will be calculated after you put the dimensions & weight of your product and automatically added to the order</li>
        </ol>
    </div>
</div>

<h3 class="center-align">Choose your shipping method</h3>
<div class="row" id="method_shipping">
    <div class="col-md-4">
        <input type="radio" name="shipping_method" id="pick_up" value="3" <?php echo $pick_up;?> /> Pick up
    </div>
    <div class="col-md-4">
        <input type="radio" name="shipping_method" id="auspost" value="1" <?php echo $auspost;?> /> Auspost
    </div>
    <div class="col-md-4">
        <input type="radio" name="shipping_method" id="fixed_rate" value="2" <?php echo $fixed_rate;?> /> Fixed rate
    </div>
</div>

<div id="show_auspost" style="padding-bottom:20px; <?php echo $auspost_style;?>">
    <p>
        If you choose this option you will be required to set the dimensions & weight of each of your products when you are adding them.
    </p>
    
    <div class="form-actions center-align">
        <a class="btn btn-primary" href="<?php echo site_url().'vendor/account/activate_shipping_method/1';?>">
            Activate Auspost
        </a>
    </div>
</div>

<div id="show_fixed_rate" style="padding-bottom:20px; <?php echo $fixed_rate_style;?>">
    <?php echo form_open('vendor/account/add_fixed_rate', array("class" => "form-horizontal", "role" => "form"));?>
    <p>
        Add a fixed rate that you will charge your customers to deliver their goods to them. You can set a general fixed rate here or add a rate per product in the product editting page.
    </p>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-lg-4 control-label">Default rate</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" name="vendor_fixed_rate" placeholder="Rate" value="<?php echo $vendor_shipping_rate;?>">
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-actions center-align">
        <button class="submit btn btn-primary" type="submit">
            Activate fixed rate
        </button>
    </div>
    <?php echo form_close();?>
</div>

<div id="show_pick_up" style="padding-bottom:20px; <?php echo $pick_up_style;?>">
    
    <p>
        Customers will not be charged to pick up their orders from your location. Please note that the customers will be directed to the location indicated in your profile.
    </p>
    
    <div class="form-actions center-align">
        <a class="btn btn-primary" href="<?php echo site_url().'vendor/account/activate_shipping_method/3';?>">
            Activate pick up
        </a>
    </div>
    
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
