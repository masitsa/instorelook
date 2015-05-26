   
        <!-- Jasny -->
        <link href="<?php echo base_url();?>assets/jasny/jasny-bootstrap.css" rel="stylesheet">		
        <script type="text/javascript" src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script> 
          <div class="padd">
          	<div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="alert alert-warning">
                        <p><strong>Warning!</strong> Banners that do not adhere to the dimensions specified (<strong>1600px by 600px</strong>) will be cropped</p>
                        <p><strong>Note: </strong>The next available date is <strong><?php echo date('jS M Y', strtotime($next_available_date));?></strong></p>
                        <p><strong>Note: </strong>Each banner is priced at <strong>$<?php echo $promotion_cost;?> per day</strong></p>
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
                            <label for="slideshow_name" class="col-md-3 control-label">Title</label>
                            <div class="col-md-9">
                            	<input type="text" class="form-control" name="slideshow_name" placeholder="Enter Title" value="<?php echo $slide_row->slideshow_name;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="slideshow_description" class="col-md-3 control-label">Description</label>
                            <div class="col-md-9">
                            	<textarea class="form-control" name="slideshow_description"><?php echo $slide_row->slideshow_description;?></textarea>
                            </div>
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
                                    <input type="text" class="form-control fieldset__input js__datepicker" name="date_from" placeholder="Start Date" value="<?php echo date('jS M Y', strtotime($slide_row->slideshow_start));?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon pickadate">
                                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                    </span>
                                    <input type="text" class="form-control fieldset__input js__datepicker" name="date_to" placeholder="End Date" value="<?php echo date('jS M Y', strtotime($slide_row->slideshow_expiry));?>">
                                </div>
                            </div>
                        </div>
                                        
                        <div class="form-group">
                        	<label class="control-label col-md-3" for="image">Banner Image</label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px;">
                                        <img src="<?php echo $slideshow_location;?>" class="img-responsive"/>
                                    </div>
                                        <div>
                                            <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="slideshow_image"></span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                			</div>
                		</div>
                	</div>
				
                    <div class="form-group center-align">
                        <input type="submit" value="Edit Banner" class="login_btn btn btn-success btn-lg">
                    </div>
                </div>
				<?php
					form_close();
				?>
		</div>