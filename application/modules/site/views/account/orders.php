<!-- styles needed by footable  -->
<link href="<?php echo base_url().'assets/footable';?>/css/footable-0.1.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url().'assets/footable';?>/css/footable.sortable-0.1.css" rel="stylesheet" type="text/css" />

<div class="container main-container headerOffset">
  <div class="row">
    <div class="breadcrumbDiv col-lg-12">
      <ul class="breadcrumb">
        <li><a href="<?php echo site_url();?>">Home</a> </li>
        <li><a href="<?php echo site_url().'customer/account';?>">My Account</a> </li>
        <li class="active"> Wishlist </li>
      </ul>
    </div>
  </div> <!--/.row-->
  
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h1 class="section-title-inner"><span><i class="fa fa-list-alt"></i> Order List </span></h1>
      <div class="row userInfo">
        <div class="col-lg-12">
          <h2 class="block-title-2"> Your Order List  </h2>
        </div>
        
        <div class="col-xs-12 col-sm-12">
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
                <th data-hide="phone,tablet" data-sort-ignore="true">No. of items</th>
                <th data-hide="phone,tablet" data-sort-ignore="true">Details</th>
                <th data-hide="phone,tablet"><strong>Payment Method</strong></th>
                <th data-hide="default"> Price </th>
                <th data-hide="default" data-type="numeric"> Date </th>
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
					$total_cost = number_format($this->orders_model->calculate_order_cost($order_id), 2, '.', ',');
					$items = '';
					$total_items = 0;
					
					//order items
					if($order_items->num_rows() > 0)
					{
						$order = $order_items->result();
						
						foreach($order as $item)
						{
							$product_name = $item->product_name;
							$quantity = $item->order_item_quantity;
							$price = $item->order_item_price;
							
							$items .= $quantity.' unit(s) of '.$product_name.' @ '.number_format($price, 2).'<br/>';
							
							$total_items++;
						}
					}
					
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
                <td data-value="78025368997"><?php echo $created;?></td>
                <td><?php echo $total_items;?> <small><?php echo $display;?></small></td>
                <td><?php echo $items;?></td>
                <td><?php echo $method;?></td>
                <td>$<?php echo $total_cost;?></td>
                <td><?php echo $created;?></td>
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
