<!-- styles needed by footable  -->
<link href="<?php echo base_url().'assets/footable';?>/css/footable-0.1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'assets/footable';?>/css/footable.sortable-0.1.css" rel="stylesheet" type="text/css" />

<div class="container main-container headerOffset">
  <div class="row">
    <div class="breadcrumbDiv col-lg-12">
      <ul class="breadcrumb">
        <li><a href="<?php echo site_url();?>">Home</a> </li>
        <li><a href="<?php echo site_url().'customer/account';?>">My Account</a> </li>
        <li class="active"> Orders </li>
      </ul>
    </div>
  </div> <!--/.row-->
  
  <div class="row">
	   <div class="col-lg-12 col-md-12 col-sm-12 product-content">
	   	 <div class="accounts-dashboard">
	      <!-- <h1 class="section-title-inner"><span><i class="fa fa-list-alt"></i> Order List </span></h1> -->
	      <div class="row userInfo">
	        <div class="col-xs-12 col-sm-12">
                <h4><i class="fa fa fa-list-alt"></i> Order List</h4>
              
                 <?php
                    $error_message = $this->session->userdata('error_message');
                    if(!empty($error_message))
                    {
                        echo '<div class="alert alert-danger center-align"> Oh snap! '.$error_message.' </div>';
                        $this->session->unset_userdata('error_message');
                    }
                    
                    $success_message = $this->session->userdata('success_message');
                    if(!empty($success_message))
                    {
                        echo '<div class="alert alert-success center-align"> '.$success_message.' </div>';
                        $this->session->unset_userdata('success_message');
                        
                    }
                ?>
            </div>
	        <div class="col-xs-12 col-sm-12" style="padding:0; margin-top:10px;">
	        	<?php
				
	            	if($all_orders->num_rows() > 0)
					{
						$orders = $all_orders->result();
				?>
	          <table class="footable">
	            <thead>
	              <tr>
	                <th data-class="expand" data-sort-initial="true"> <span title="table sorted by this column on load">Order ID</span> </th>
	                <th data-hide="phone,tablet" data-sort-ignore="false">Date</th>
	                <th data-hide="phone,tablet" data-sort-ignore="false">No. of items</th>
	                <th data-hide="phone,tablet" data-sort-ignore="false">Total Cost ($)</th>
	                <!--<th data-hide="phone,tablet" data-sort-ignore="true">Details</th>-->
	                <th data-hide="phone,tablet"><strong>Payment Method</strong></th>
	                <th data-hide="default"> Instructions </th>
	                <th data-hide="default" data-type="numeric"> Items ordered </th>
	                <th data-hide="phone" data-type="numeric"> Status </th>
	              </tr>
	            </thead>
	            <tbody>
	            <?php
	            	foreach($orders as $ord)
					{
						$instructions = $ord->order_instructions;
						$order_number = $ord->order_number;
						$method = $ord->payment_method_name;
						$created = date('jS M Y H:i a',strtotime($ord->order_created));
						$status = $ord->order_status_id;
						$status_name = $ord->order_status_name;
						$order_id = $ord->order_id;
						$order_items = $this->orders_model->get_order_items($order_id);
						$items = '';
						$cancel = '';
						$total_items = 0;
						
						//allow cancel on status < 4
						if($status < 4)
						{
							$cancel = '<a class="btn btn-danger btn-sm" href="'.site_url().'account/request-cancel-order/'.$order_number.'" ><i class="glyphicon glyphicon-remove-circle"> </i> Request cancel</span></a>';
						}
						
						//order items
						if($order_items->num_rows() > 0)
						{
							$items = '
							<table class="table table-striped table-condensed">
							<tr>
								<th>Item</th>
								<th></th>
								<th>Quantity</th>
								<th>Price ($)</th>
								<th>Added price ($)</th>
								<th>Total ($)</th>
							</tr>';
							$order_items = $order_items->result();
							$total_price = 0;
							$total_items = 0;
							
							foreach($order_items as $res)
							{
								$order_item_id = $res->order_item_id;
								$product = $res->product_name;
								$quantity = $res->order_item_quantity;
								$price = $res->order_item_price;
								$product_id = $res->product_id;
								$vendor_id = $res->vendor_id;
								$vendor_store_name = $res->vendor_store_name;
								$web_name = $this->site_model->create_web_name($vendor_store_name);
								$vendor_link = site_url().'businesses/'.$web_name.'&'.$vendor_id;
								$order_item_features = $this->orders_model->get_order_item_features($order_item_id);
								
								$total_items += $quantity;
								
								//display features
                            	$features_display = '';
								$total_additional_price = 0;
								
								if($order_item_features->num_rows() > 0)
								{
									$features_display = '<table class="table table-condensed">
										<tr>
											<th>Feature</th>
											<th>Selected</th>
											<th>Added price ($)</th>
										</tr>';
									foreach($order_item_features->result() as $feat)
									{
										$product_feature_id = $feat->product_feature_id;
										$added_price = $feat->additional_price;
										$feature_name = $feat->feature_name;
										$feature_value = $feat->feature_value;
										$feature_image = $feat->thumb;
										$total_additional_price += $added_price;
										
										$feature_location = base_url().'assets/images/products/features/';
										$feature_path = realpath(APPPATH . '../assets/images/products/features');
										$feature_image_display = $this->products_model->image_display($feature_path, $feature_location, $feature_image);
										
										//display feature images
										if($feature_image != 'None')
										{
											$features_display.= '
												<tr>
													<td>'.$feature_name.'</td>
													<td><img src="'.$feature_image_display.'" /></td>
													<td>'.number_format($added_price, 2).'</td>
												</tr>';
										}
										
										//display features in dropdown
										else
										{
											$features_display.= '
												<tr>
													<td>'.$feature_name.'</td>
													<td>'.$feature_value.'</td>
													<td>'.number_format($added_price, 2).'</td>
												</tr>';
										}
									}
									$features_display .= '
										<tr>
											<th></th>
											<th></th>
											<th>'.number_format($total_additional_price, 2).'</th>
										</tr>
									</table>';
								}
								
								$total_price += (($quantity*$price) + $total_additional_price);
								
								$items .= '
								<tr>
									<td>
									'.$product.'
									'.$features_display.'
									</td>
									<td><a class="btn btn-primary btn-sm add_to_cart" href="'.$product_id.'" product_id="'.$product_id.'"><span class="add2cart"><i class="glyphicon glyphicon-shopping-cart"> </i> Add to cart </span></a></td>
									<td>'.$quantity.'</td>
									<td>'.number_format($price, 2, '.', ',').'</td>
									<td>'.number_format($total_additional_price, 2, '.', ',').'</td>
									<td>'.number_format(($quantity*$price)+$total_additional_price, 2, '.', ',').'</td>
								</tr>
								<tr>
									<td colspan="5">This product was sold to you by <a href="'.$vendor_link.'" target="_blank">'.$vendor_store_name.'</a></td>
									<td>'.$cancel.'</td>
								</tr>
								';
							}
								
							$items .= '
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td colspan="5">'.number_format($total_price, 2, '.', ',').'</td>
								</tr>
							</table>
							';
						}
						
						else
						{
							$items = 'This order has no items';
						}
						$button = '';
						//order status
						if($status == 0)
						{
							$order_status = '<span class="label label-primary">'.$status_name.'</span>';
						}
						
						else if($status == 1)
						{
							$order_status = '<span class="label label-success">'.$status_name.'</span>';
						}
						
						else if($status == 2)
						{
							$order_status = '<span class="label label-danger">'.$status_name.'</span>';
						}
						
						else if($status == 3)
						{
							$order_status = '<span class="label label-default">'.$status_name.'</span>';
						}
						
						else if($status == 4)
						{
							$order_status = '<span class="label label-warning">'.$status_name.'</span> <a href="'.site_url().'account/make-payment/'.$order_number.'" class="btn btn-sm btn-info pull-right">Make payment</a>';
						}
						
						else if($status == 6)
						{
							$order_status = '<span class="label label-danger">'.$status_name.'</span>';
						}
						if($total_items == 1)
						{
							$display = 'item';
						}
						else
						{
							$display = 'items';
						}
				?>
	              <tr>
	                <td><?php echo $order_number;?></td>
	                <td data-value="<?php echo strtotime($ord->order_created);?>"><?php echo $created;?></td>
	                <td><?php echo $total_items;?> <small><?php echo $display;?></small></td>
	                <td><?php echo number_format($total_price, 2);?></td>
	                <!--<td><?php echo $items;?></td>-->
	                <td><?php echo $method;?></td>
	                <td><?php echo $instructions;?></td>
	                <td><?php echo $items;?></td>
	                <td data-value="3"><?php echo $order_status;?></td>
	              </tr>
	             <?php
					}
				 ?>
	            </tbody>
	          </table>
			  <?php
					}
					else
					{
						echo '<p>You have not placed any orders. Please <a href="'.site_url().'products">shop here</a></p>';
					}
				?>
	        </div>
	        
	        <?php echo $this->load->view('account/navigation', '', TRUE);?>
	        
	      </div>
	      <!--/row end--> 
	      
	    </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-5"> </div>
  </div>
  <!--/row-->
  
  <div style="clear:both"></div>
</div>
<!-- /main-container -->
<!-- include footable plugin --> 
<script src="<?php echo base_url().'assets/footable';?>/js/footable.js" type="text/javascript"></script> 
<script src="<?php echo base_url().'assets/footable';?>/js/footable.sortable.js" type="text/javascript"></script> 
<script type="text/javascript">
    $(function() {
      $('.footable').footable();
    });
  </script> 
