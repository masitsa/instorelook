<?php
$surburbs = $this->site_model->get_surburbs();
$surburb_list = '';
$count = 0;

if($surburbs->num_rows() > 0)
{
	$surburbs_result = $surburbs->result();
	
	foreach($surburbs_result as $sel)
	{
		$count++;
		$surburb_name = $sel->surburb_name;
		$state_abbr = $sel->state_abbr;
		$post_code = $sel->post_code;
		$surburb_id = $sel->surburb_id;
		
		if($count == $surburbs->num_rows())
		{
			$surburb_list .= '"'.$surburb_name.' '.$state_abbr.' '.$post_code.'"';
		}
		
		else
		{
			$surburb_list .= '"'.$surburb_name.' '.$state_abbr.' '.$post_code.'", ';
		}
	}
}
?>
<!-- Footer  --> 
       	<div class="footer dark-grey-background">
            <div class="container">
                <div class="contacts row">
                    <!-- Contacts -->
                    <div class="col-md-3">
                        <h3>Contacts</h3>
                        <ul>
                            <li><a href="">In Store Look</li>
                            <li><a href="mailto:info@instorelook.com.au"><span class="glyphicon glyphicon-envelope"></span> info@instorelook.com.au</a></li>
                            <li><a href="tel:0405486426"><span class="glyphicon glyphicon-phone"></span> 0405 486 426</a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-map-marker"></span> 16 Winchcombe Place<br/>Castle Hill, NSW<br/>2154<br/></a></li>
                            <li><a href="#">ABN: 25 997 516 795</a></li>
                        </ul>
                        <div>
                            
                        </div>
                        <div>
                            
                        </div>
                    </div><!-- End Contacts -->
                
                    <!-- Quick Links -->
                    <div class="col-md-3">
                        <h3>Vendors</h3>
                        <ul>
                            <li><a href="<?php echo site_url().'vendor/sign-up/user-details';?>">Vendor Sign Up</a></li>
                            <li><a href="<?php echo site_url().'vendor/sign-in';?>">Vendor Sign In</a></li>
                            <li><a href="<?php echo site_url().'vendor/account';?>">My Account</a></li>
                        </ul>
                    </div><!-- End Quick Links -->
                
                    <!-- Quick Links -->
                    <div class="col-md-3">
                        <h3>Pages</h3>
                        <ul>
                            <li><a href="<?php echo site_url().'products';?>">Products</a></li>
                            <li><a href="<?php echo site_url().'products/view-product/39';?>">Single Product</a></li>
                            <li><a href="<?php echo site_url().'cart';?>">Cart</a></li>
                            <li><a href="<?php echo site_url().'checkout';?>">Checkout</a></li>
                        </ul>
                    </div><!-- End Quick Links -->
                
                    <!-- Quick Links -->
                    <div class="col-md-3">
                        <h3>Quick Links</h3>
                        <ul>
                            <li><a href="<?php echo site_url().'about';?>">About</a></li>
                            <li><a href="<?php echo site_url().'privacy';?>">Privacy</a></li>
                            <li><a href="<?php echo site_url().'terms';?>">Terms & Conditions</a></li>
                        </ul>
                    </div><!-- End Quick Links -->
                </div>
                <!-- End Contacts -->
                
            </div><!-- End Container -->
        </div>
        <!-- End Footer -->
        
        <div class='footer-bottom light-grey-background blue-text'>
            <div class="container">
                <div class="row">
                    <!-- Copyright -->
                    <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                        &copy; <?php echo date('Y');?> instorelook.com.au. All Rights Reserved.
                    </div>
                    <!-- Payment -->
                    <div class="col-xs-6 col-sm-6 col-md-6">
                    	<div class="pull-right">
                            <i class="fa fa-cc-visa fa-2x"></i>
                            <i class="fa fa-cc-mastercard fa-2x"></i>
                            <i class="fa fa-cc-paypal fa-2x"></i>
                            <i class="fa fa-cc-discover fa-2x"></i>
                    	</div>
                    </div>
            	</div>
            </div>
        </div>
        
        <div class="modal fade wishlist-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <input type="hidden" id="form_product_id" value=""/>
                    <div class="hgroup title" id="wishlist-modal-response">
                    </div>
                </div>
                <div class="modal-footer">	
                    <div class="pull-right">				
                        <a href="<?php echo site_url().'account';?>" class="btn btn-primary btn-small">
                            Go to your account &nbsp; <span class="glyphicon glyphicon-arrow-right"></span>
                        </a>
                    </div>
                </div>
            
            </div>
          </div>
        </div>
        
        <!-- Bootstrap--> 
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/bootstrap/js/bootstrap.min.js"></script> 
        <!-- Single page navigation --> 
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/custom/js/jquery.nav.js"></script> 
        <!-- Stellar --> 
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/custom/js/jquery.stellar.min.js"></script> 
        <!-- WOW --> 
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/custom/js/wow.min.js"></script> 
        <!-- Retina -->
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/custom/js/retina.min.js"></script>
        <!-- Owl Carousel -->
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/custom/js/owl.carousel.min.js"></script>
        <!-- Smooth Scroll -->
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/custom/js/bind-polyfill.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/custom/js/smooth-scroll.js"></script>
        <!-- Typeahead --> 
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/typeahead/js/typeahead.bundle.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/typeahead/js/typeahead.jquery.min.js"></script>
        <!-- View switch mode --> 
		<script src="<?php echo base_url().'assets/themes/view_mode_switch/';?>js/classie.js"></script>
        <script src="<?php echo base_url().'assets/themes/view_mode_switch/';?>js/cbpViewModeSwitch.js"></script>
 
        <!-- Custom --> 
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/custom/js/custom.js"></script> 

		<script type="text/javascript">
        //Add to cart
        $(document).on("click","a.add_to_cart",function()
        {
            var product_id = $(this).attr('product_id');
			
            $.ajax({
                type:'POST',
                url: '<?php echo site_url();?>site/cart/add_item/'+product_id,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success:function(data){
                    
                    if(data.result == "success")
                    {
                        var total = 'Cart ($'+data.cart_total+')';
                        var sub_total = 'Subtotal: $'+data.cart_total;
                        
                        $("#menu_cart_total").html(total);
                        $("#menu_cart_sub_total").html(sub_total);
                        
                        $("#mini_menu_cart_total").html(total);
                        $("#mini_menu_cart_sub_total").html(sub_total);
                        
                        $("#menu_cart").html(data.cart_items);
                        $("#mini_menu_cart").html(data.cart_items);
                    }
                    else
                    {
                        alert('Could not add items to cart');
                    }
                },
                error: function(xhr, status, error) {
                    alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
                }
            });
            
            return false;
        });
        //Add to cart
        $(document).on("click","a.add_to_wishlist",function()
        {
            var product_id = $(this).attr('product_id');
			
            $.ajax({
                type:'POST',
                url: '<?php echo site_url();?>site/cart/add_to_wishlist/'+product_id,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success:function(data)
				{
					if(data.result == 'Please sign in to continue')
					{
						$('#form_product_id').val(product_id);//will be used later if a customer successfully logs in
					}
                    $("#wishlist-modal-response").html(data.message);
                },
                error: function(xhr, status, error) {
                    alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
                }
            });
            
            return false;
        });
        
        //Submit modal form for customer sign in
        $(document).on("submit","div#wishlist-modal-response form",function(e)
		{
			e.preventDefault();
            var formData = new FormData(this);
            
            $.ajax({
                type:'POST',
                url: '<?php echo site_url();?>customer/sign-in/1',
				data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success:function(data){
                    
                    if(data.result == "success")
                    {
						//add to wishlist
						var product_id = $('#form_product_id').val();
						$.ajax({
							type:'POST',
							url: '<?php echo site_url();?>site/cart/add_to_wishlist/'+product_id,
							cache:false,
							contentType: false,
							processData: false,
							dataType: 'json',
							success:function(data)
							{
								$("#wishlist-modal-response").html(data.message);
							},
							error: function(xhr, status, error) {
								alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
							}
						});
                    }
                    else
                    {
                        $("#modal-error-message").html('<div class="alert alert-danger">'+data.message+"</div>");
                    }
                },
                error: function(xhr, status, error) {
                    alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
                }
            });
            
            return false;
        });
        
        //Delete from cart
        $(document).on("click","a.delete_cart_item",function()
        {
            var row_id = $(this).attr('href');
            
            $.ajax({
                type:'POST',
                url: '<?php echo site_url();?>site/cart/delete_cart_item/'+row_id,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success:function(data){
                    
                    if(data.result == "success")
                    {
                        var total = 'Cart ($'+data.cart_total+')';
                        var sub_total = 'Subtotal: $'+data.cart_total;
                        
                        $("#menu_cart_total").html(total);
                        $("#mini_menu_cart_total").html(total);
                        $("#cart_sub_total").html(sub_total);
                        
                        $("#menu_cart").html(data.cart_items);
                        $("#mini_menu_cart").html(data.cart_items);
                    }
                    else
                    {
                        alert('Could not delete item from cart');
                    }
                },
                error: function(xhr, status, error) {
                    alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
                }
            });
            
            return false;
        });
		
var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substrRegex;
 
    // an array that will be populated with substring matches
    matches = [];
 
    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');
 
    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        // the typeahead jQuery plugin expects suggestions to a
        // JavaScript object, refer to typeahead docs for more info
        matches.push({ value: str });
      }
    });
 
    cb(matches);
  };
};
 
var states = [<?php echo $surburb_list;?>];
/*var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
  'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
  'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
  'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
  'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
  'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
  'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
  'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
  'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
];*/
 
/*$('#the-basics .typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
  //remote: '<?php echo site_url();?>/site/search_surburbs/%QUERY'
},
{
  name: 'Surburbs',
  displayKey: 'value',
  source: substringMatcher(states)
});*/

/*var surburbs = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  //prefetch: states,
  //remote: '<?php echo site_url();?>site/search_surburbs/%QUERY'
  remote: {
        url: '<?php echo site_url();?>site/search_surburbs/%QUERY',
        filter: function (parsedResponse) {
            // parsedResponse is the array returned from your backend
            console.log(parsedResponse);

            // do whatever processing you need here
            return parsedResponse;
        }
    }
});
 
surburbs.initialize();
 
$('#the-basics .typeahead').typeahead(null, {
  name: 'Surburbs',
  displayKey: 'value',
  source: surburbs.ttAdapter()
});*/

/*source: function (query, process) {
        return $.get('/typeahead', { query: query }, function (data) {
            return process(data.options);
        });
    }*/
	$('#the-basics .typeahead').typeahead([
	{
		name: 'Surburbs',
		remote: '<?php echo site_url();?>site/search_surburbs/%QUERY',
	}]);
	
	$('.carousel').carousel({
	  interval: 2000
	});
</script>