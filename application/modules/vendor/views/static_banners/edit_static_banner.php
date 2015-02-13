   
        <!-- Jasny -->
        <link href="<?php echo base_url();?>assets/jasny/jasny-bootstrap.css" rel="stylesheet">		
        <script type="text/javascript" src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script> 
        <!-- Pickadate -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/themes/pickadate/';?>lib/themes/default.css" id="theme_base">
        <link rel="stylesheet" href="<?php echo base_url().'assets/themes/pickadate/';?>lib/themes/default.date.css" id="theme_date">
        <link rel="stylesheet" href="<?php echo base_url().'assets/themes/pickadate/';?>lib/themes/default.time.css" id="theme_time">
          <div class="padd">
          	<div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="alert alert-warning">
                        <p><strong>Warning!</strong> Banners that do not adhere to the dimensions specified will be resized & cropped appropriately</p>
                        <p><strong>Note: </strong>The next available date for long banners is <strong><?php echo date('jS M Y', strtotime($next_available_date['long_start']));?></strong></p>
                        <p><strong>Note: </strong>The next available date for short banners is <strong><?php echo date('jS M Y', strtotime($next_available_date['short_start']));?></strong></p>
						<p><strong>Note: </strong>Long banners will cost $<?php echo $long_cost;?> per day and short banners will cost $<?php echo $short_cost;?> per day.</p>
                    </div>
                </div>
            </div>
            <?php
				$error2 = validation_errors(); 
				if(!empty($error2)){?>
					<div class="row">
						<div class="col-md-6 col-md-offset-2">
							<div class="alert alert-danger">
								<strong>Error!</strong> <?php echo validation_errors(); ?>
							</div>
						</div>
					</div>
				<?php }
			
				if(isset($_SESSION['error'])){?>
					<div class="row">
						<div class="col-md-6 col-md-offset-2">
							<div class="alert alert-danger">
								<strong>Error!</strong> <?php echo $_SESSION['error']; $_SESSION['error'] = NULL;?>
							</div>
						</div>
					</div>
				<?php }?>
			
				<?php
				$attributes = array('role' => 'form');
		
				echo form_open_multipart($this->uri->uri_string(), $attributes);
				
				if(!empty($error))
				{
					?>
					<div class="alert alert-danger">
						<?php echo $error;?>
					</div>
					<?php
				}
				?>
                <div class="row">
                	<div class="col-md-6">
                        <div class="form-group">
                            <label for="static_banner_type">Type</label>
                            <select class="form-control" name="static_banner_type" id="static_banner_type">
                            	<?php
                                	if($static_banner_row->static_banner_type == 1)
									{
										echo 
										'
                                            <option value="0">Short Banner</option>
                                            <option value="1" selected="selected">Long Banner</option>
										';
									}
									
									else
									{
										echo 
										'
                                            <option value="0" selected="selected">Short Banner</option>
                                            <option value="1">Long Banner</option>
										';
									}
								?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="static_banner_name">Title</label>
                            <input type="text" class="form-control" name="static_banner_name" placeholder="Enter Title" value="<?php echo $static_banner_row->static_banner_name;?>">
                        </div>
                        <div class="form-group">
                            <label for="static_banner_description">Description</label>
                            <textarea class="form-control" name="static_banner_description"><?php echo $static_banner_row->static_banner_description;?></textarea>
                        </div>
                        <input type="hidden" name="check" value="1"/>
					</div>
                	<div class="col-md-6">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon pickadate">
                                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                    </span>
                                    <input type="text" class="form-control fieldset__input js__datepicker" name="date_from" placeholder="Start Date" value="<?php echo date('jS M Y', strtotime($static_banner_row->static_banner_start));?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon pickadate">
                                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                    </span>
                                    <input type="text" class="form-control fieldset__input js__datepicker" name="date_to" placeholder="End Date" value="<?php echo date('jS M Y', strtotime($static_banner_row->static_banner_expiry));?>">
                                </div>
                            </div>
                        </div>
                                        
                        <div class="form-group">
                            <div class="short_banner">
                                <label class="control-label col-md-3" for="image">Short Banner Image (500px by 250px)</label>
                            	<div class="col-md-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 300px;">
                                        	<img src="<?php echo $static_banner_location;?>" />
                                        </div>
                                        <div>
                                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="short_banner_image"></span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                            	</div>
                            </div>
                            <div class="long_banner">
                                <label class="control-label col-md-3" for="image">Long Banner Image (1000px by 200px)</label>
                            	<div class="col-md-9">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 300px;">
                                        	<img src="<?php echo $static_banner_location;?>" />
                                        </div>
                                        <div>
                                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="long_banner_image"></span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                            	</div>
                            </div>
                		</div>
                	</div>
                </div>
				
				<div class="form-group center-align">
					<input type="submit" value="Update Banner" class="login_btn btn btn-success btn-lg">
				</div>
				<?php
					form_close();
				?>
		</div>
        <script src="<?php echo base_url().'assets/themes/pickadate/';?>lib/picker.js"></script>
        <script src="<?php echo base_url().'assets/themes/pickadate/';?>lib/picker.date.js"></script>
        <script src="<?php echo base_url().'assets/themes/pickadate/';?>lib/picker.time.js"></script>
        <script src="<?php echo base_url().'assets/themes/pickadate/';?>demo/scripts/demo.js"></script>
        
<script type="text/javascript">
	$( document ).ready(function() 
	{
		var static_banner_type = '<?php echo $static_banner_row->static_banner_type;?>';//alert(static_banner_type);
		
		if(static_banner_type == '0')
		{
			$('.long_banner').css('display', 'none');
			$('.short_banner').css('display', 'block');
		}
		else
		{
			$('.long_banner').css('display', 'block');
			$('.short_banner').css('display', 'none');
		}
	});
	
	$(document).on("change","select#static_banner_type",function(e)
	{//alert('here');
		var static_banner_type = $(this).val();
		
		if(static_banner_type == '0')
		{
			$('.long_banner').css('display', 'none');
			$('.short_banner').css('display', 'block');
		}
		else
		{
			$('.long_banner').css('display', 'block');
			$('.short_banner').css('display', 'none');
		}
	});
</script>