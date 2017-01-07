<!doctype html>
<html class="no-js" lang="en">
    <head>
        <?php echo $this->load->view('site/includes/header', '', TRUE); ?>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
		
    	<!-- Top Navigation -->
        <?php echo $this->load->view('site/includes/home_navigation', '', TRUE); ?>
		
		<?php echo $content;?>
        
        <?php echo $this->load->view('site/includes/footer', '', TRUE); ?>
		
		<!-- all js here -->
		<!-- bootstrap js -->
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/bootstrap.min.js"></script>
		<!-- meanmenu js -->
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/jquery.meanmenu.js"></script>
		<!-- countdown js -->
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/jquery.countdown.min.js"></script>
        <!-- Nevo Slider js -->         
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/jquery.nivo.slider.pack.js"></script>
		<!-- owl.carousel js -->
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/owl.carousel.min.js"></script>
		<!-- price slider js -->
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/jquery-price-slider.js"></script>
		<!-- jquery-ui js -->
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/jquery-ui.min.js"></script>
		<!-- plugins js -->
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/plugins.js"></script>
        <!-- Elevatezoom JS -->		
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/jquery.elevateZoom-3.0.8.min.js"></script>
		<!-- wow js -->
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/wow.min.js"></script> 
		<!-- main js -->
        <script src="<?php echo base_url();?>assets/themes/timeplus/js/main.js"></script>
		
        <!-- Custom --> 
        <script type="text/javascript" src="<?php echo base_url();?>assets/themes/custom/js/custom.js"></script> 
		
        <!-- Include js plugin -->
		<script type="text/javascript">
		
			window.fbAsyncInit = function() {
				FB.init({
					 appId:'<?php echo $this->config->item('appID'); ?>',
					 xfbml      : true,
					 version    : 'v2.7'
				});
			};
		
			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));

		//Facebook sign up
		$(document).on("click","a.fb-login-button",function()
        {
			FB.getLoginStatus(function(response) 
			{
				if (response.status === 'connected') 
				{
					parent.location ='<?php echo base_url(); ?>login/facebook_sign_up';
				} 
				 
				else {
					FB.login(function(response) {
						// handle the response
						if(response.authResponse) 
						{
							parent.location ='<?php echo base_url(); ?>login/facebook_sign_up';
						}
					}, {scope: 'email, publish_stream'});/*{scope: 'email,publish_stream'});*/
				}
		 	});
		 	return false;
        });

        //Facebook sign up on the checkout page
        $(document).on("click","a.fb-login-button-tab",function()
        {
            FB.getLoginStatus(function(response) 
            {
                if (response.status === 'connected') 
                {
                    parent.location ='<?php echo base_url(); ?>login/facebook_sign_up/1';
                } 
                 
                else {
                    FB.login(function(response) {
                        // handle the response
                        if(response.authResponse) 
                        {
                            parent.location ='<?php echo base_url(); ?>login/facebook_sign_up/1';
                        }
                    }, {scope: 'email, publish_stream'});/*{scope: 'email,publish_stream'});*/
                }
            });
            return false;
        });

		//Facebook sign up
		$(document).on("click","a.fb-signin-button",function()
        {
			FB.getLoginStatus(function(response) 
			{
				if (response.status === 'connected') 
				{
					parent.location ='<?php echo base_url(); ?>login/facebook_sign_in';
				} 
				 
				else {
					FB.login(function(response) {
						// handle the response
						if(response.authResponse) 
						{
							parent.location ='<?php echo base_url(); ?>login/facebook_sign_in';
						}
					}, {scope: 'email, publish_stream'});/*{scope: 'email,publish_stream'});*/
				}
		 	});
		 	return false;
        });
		
		//facebook share product
		function facebook_share(name, item_link, image_url)
		{
			 FB.ui({
				method: 'feed',
				picture: image_url,
				link: "<?php echo site_url();?>"+item_link,
				description: "Checkout  "+name+" and lots more on www.instorelook.com.au",
			}, function(response){});
			
			return false;
		}
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
                        $("#mini-cart-footer").html(data.mini_cart_footer);
                        
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
        //Add to cart single product page
        $(document).on("click","a.add_to_cart_single",function()
        {
            var product_id = $(this).attr('product_id');
			var selected_features = $("input[name='selected_features\\[\\]']").map(function(){return $(this).val();}).get();
            
			$.ajax({
                type:'POST',
                url: '<?php echo site_url();?>site/cart/add_item/'+product_id+'/'+selected_features,
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
                        $("#mini-cart-footer").html(data.mini_cart_footer);
                        
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
        //Add to cart and redirect
        $(document).on("click","a.add_to_cart_redirect",function()
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
                        $("#mini-cart-footer").html(data.mini_cart_footer);
                        
                        $("#menu_cart").html(data.cart_items);
                        $("#mini_menu_cart").html(data.cart_items);
                        parent.location ='<?php echo base_url(); ?>checkout';
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
        //Add to cart and redirect


        //Add to cart and redirect
       $(document).on("submit","form#product_review_form",function(e)
         {
          e.preventDefault();
          
          var formData = new FormData(this);
          
           var product_id = $(this).attr('product_id');
           var product_code = $(this).attr('product_code');
          $.ajax({
           type:'POST',
           url: $(this).attr('action'),
           data:formData,
           cache:false,
           contentType: false,
           processData: false,
           dataType: 'json',
           success:function(data){
            
            if(data.result == "success")
            {
                alert('Thank you for the review, you comments shall be posted once review.');
                 parent.location ='<?php echo base_url(); ?>products/view-product/'+product_code;   
            }
            else
            {
                alert('Sorry, something went wrong make sure your have rated and entered your name.');
            }
           },
           error: function(xhr, status, error) {
            alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
           
           }
          });
          return false;
         });
        //Add to cart and redirect


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
                        $("#mini-cart-footer").html(data.mini_cart_footer);
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
        
        //Delete from wishlist
        $(document).on("click","a.delete_wishlist",function()
        {
            var wishlist_id = $(this).attr('href');
			//alert('<?php echo site_url();?>site/account/delete_wishlist_item/'+wishlist_id);
            
            $.ajax({
                type:'POST',
                url: '<?php echo site_url();?>site/account/delete_wishlist_item/'+wishlist_id,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data)
				{
                    window.location.href = '<?php echo site_url();?>account/wishlist';
                    
                },
                error: function(xhr, status, error) {
                    window.location.href = '<?php echo site_url();?>account/wishlist';
                    //alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
                }
            });
            
            return false;
        });

		//Preview feature image
		$(document).on("click","a.preview-feature",function()
        {
			//hide the primary images
			var image_location = $(this).attr('data-image-preview');
            var product_feature_id = $(this).attr('href');
            var feature_id = $(this).attr('feature-id');
			
			$('ul.features-prev'+feature_id+' li').removeClass( "selected" );
			$('#feat-prev'+product_feature_id).addClass( "selected" );
			$('#selected_features'+feature_id).val( product_feature_id );
			
			$('#primary-images').css( "display", "none" );
			$('#feature-image').attr("src", image_location);
			$('#preview-feature-image').attr("href", image_location);
			$('#preview-features').css( "display", "block" );
			
		 	return false;
        });

		//Preview feature image
		$(document).on("click","a.clear-feature-preview",function()
        {
            var product_feature_id = $(this).attr('href');
            var feature_id = $(this).attr('feature-id');
			
			$('ul.features-prev'+product_feature_id+' li').removeClass( "selected" );
			$('#selected_features'+feature_id).val('');
			//hide the primary images
			
			$('#primary-images').css( "display", "block" );
			$('#preview-features').css( "display", "none" );
		 	return false;
        });
		
		//get selected feature from dropdown
		function select_feature(product_feature_id, feature_id)
		{
			$('#selected_features'+feature_id).val( product_feature_id );
		}

		//Estimate shipping
		$(document).on("submit","form#estimate_shipping",function(e)
		{
			e.preventDefault();
			$('#shipping_options').html('<div class="sp-loading"><img src="<?php echo site_url().'assets/themes/image_viewer/';?>images/sp-loading.gif" alt=""><br>Calculating shipping estimate...</div>');
			
			var formData = new FormData(this);
			
			$.ajax({
				type:'POST',
				url: $(this).attr('action'),
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				dataType: 'json',
				success:function(data)
				{
					$('#shipping_options').html( data.message );
				},
				error: function(xhr, status, error) 
				{
					alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				}
			});
			return false;
		});
		
		//Add shipping
		$(document).on("click","button#add_shipping",function()
		{
			$('#shipping_addition').html('<div class="sp-loading"><img src="<?php echo site_url().'assets/themes/image_viewer/';?>images/sp-loading.gif" alt=""><br>Adding shipping...</div>');
			
			var from = $('#from_postcode').val();
			var to = $('#to_postcode').val();
			
			$.ajax({
				type:'GET',
				url: '<?php echo site_url().'site/add_shipping';?>/'+from+'/'+to,
				cache:false,
				contentType: false,
				processData: false,
				dataType: 'json',
				success:function(data)
				{
					$('#shipping_addition').html( data.message );
					$('#delivery').prop('checked', false);
				},
				error: function(xhr, status, error) 
				{
					$('#shipping_addition').html( error );
					//alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				}
			});
		});
		
		//Remove shipping
		$(document).on("click","#delivery",function()
		{
			$.ajax({
				type:'GET',
				url: '<?php echo site_url().'site/remove_shipping';?>',
				cache:false,
				contentType: false,
				processData: false,
				success:function(data)
				{
					$('#ship').prop('checked', false);
				},
				error: function(xhr, status, error) 
				{
					//$('#shipping_addition').html( error );
					alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				}
			});
		});
		
		//Enable shipping
		$(document).on("click","#ship",function()
		{
			$.ajax({
				type:'GET',
				url: '<?php echo site_url().'site/enable_shipping';?>',
				cache:false,
				contentType: false,
				processData: false,
				success:function(data)
				{
					$('#delivery').prop('checked', false);
				},
				error: function(xhr, status, error) 
				{
					//$('#shipping_addition').html( error );
					alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				}
			});
		});
		
		//Add shipping
		$(document).on("click","a.add_shipping_cost",function(e)
		{
			e.preventDefault();
			
			var vendor_id = $(this).attr('href');
			var shipping_method = $('#shipping_method'+vendor_id).val();
			var from_post_code = $('#from_post_code'+vendor_id).val();
			var to_post_code = $('#to_post_code'+vendor_id).val();
			var fixed_rate = $('#fixed_rate'+vendor_id).val();
			var row_id = $('#row_id'+vendor_id).val();
			
			$.ajax({
				type:'GET',
				url: '<?php echo site_url().'site/add_shipping_cost';?>/'+shipping_method+'/'+from_post_code+'/'+to_post_code+'/'+fixed_rate+'/'+vendor_id+'/'+row_id,
				cache:false,
				contentType: false,
				processData: false,
				dataType: 'json',
				success:function(data)
				{
					//$('#total_cost'+vendor_id).html('$'+data);
					window.location.href = '<?php echo site_url();?>checkout-progress/method';
				},
				error: function(xhr, status, error) 
				{
					$('#shipping_addition'+vendor_id).html( error );
					//alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				}
			});
			
			return false;
		});
		</script>
    </body>
</html>


