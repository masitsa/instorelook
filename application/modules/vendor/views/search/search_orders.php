
<div class="row" style="background-color:#fff; margin-bottom:5px;">
	<!-- Widget -->
	<div class="widget boxed" >
	    <!-- Widget head -->
	    <div class="widget-head">
	        <h4 style="text-align:center;"><i class="icon-reorder"></i>Search All Orders</h4>
	        <div class="widget-icons pull-right">
	            <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
	            <a href="#" class="wclose"><i class="icon-remove"></i></a>
	        </div>
	    
	    	<div class="clearfix"></div>
	    
	    </div>             
	    
	    <!-- Widget content -->
	    <div class="widget-content">
	    	<div class="padd">
				<?php
				
				
				echo form_open("vendor/search-orders", array("class" => "form-horizontal"));
				
	            
	            ?>
	            <div class="row">
	           		<div class="col-md-11">
		                <div class="col-md-6">
		                	<div class="form-group">
		                        <label class="col-lg-5 control-label">Order Number: </label>
		                        
		                        <div class="col-lg-7">
		                            <input type="text" class="form-control" name="order_number" placeholder="Order number">
		                        </div>
		                    </div>
		                    
		                    <div class="form-group">
		                        <label class="col-lg-5 control-label">Order Status: </label>
		                        
		                        <div class="col-lg-7">
		                            <select name="order_status_id" class="form-control">
		                                <?php
		                                echo '<option value="0">No selected status</option>';
		                                if($order_status_query->num_rows() > 0)
		                                {
		                                    $result = $order_status_query->result();
		                                    
		                                    foreach($result as $res)
		                                    {
		                                        if($res->order_status_id == set_value('order_status_id'))
		                                        {
		                                            echo '<option value="'.$res->order_status_id.'" selected>'.$res->order_status_name.'</option>';
		                                        }
		                                        else
		                                        {

		                                            echo '<option value="'.$res->order_status_id.'">'.$res->order_status_name.'</option>';
		                                        }
		                                    }
		                                }
		                                ?>
		                            </select>
		                        </div>
		                    </div>
		                    
		                </div>
		                
		                <div class="col-md-6">
		                     <div class="form-group">
		                        <label class="col-lg-5 control-label">Customer Surname: </label>
		                        
		                        <div class="col-lg-7">
		                            <input type="text" class="form-control" name="customer_surname" placeholder="Customer surname">
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-lg-5 control-label">Customer First name: </label>
		                        
		                        <div class="col-lg-7">
		                            <input type="text" class="form-control" name="customer_first_name" placeholder="Customer first name">
		                        </div>
		                    </div>
		                  
		                </div>
		              </div>
	            </div>
	            
	            <div class="center-align">
	            	<button type="submit" class="btn btn-info btn-lg">Search</button>
	            </div>
	            <?php
	            echo form_close();
	            ?>
	    	</div>
	    </div>
	</div>
</div>