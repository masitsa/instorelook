          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			
			//the airplane_type details
			$airplane_type_id = $airplane_type[0]->airplane_type_id;
			$airplane_type_name = $airplane_type[0]->airplane_type_name;
			$airplane_type_status = $airplane_type[0]->airplane_type_status;
			$image = $airplane_type[0]->airplane_type_image;
			$thumb = $airplane_type[0]->airplane_type_thumb;
            
            if(isset($error)){
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$validation_errors.' </div>';
				
				$airplane_type_name = set_value('airplane_type_name');
				$airplane_type_status = set_value('airplane_type_status');
            }
            
            $success = $this->session->userdata('success_message');
            
            if(!empty($success))
            {
                echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
				$this->session->unset_userdata('success_message');
            }
            
            $error = $this->session->userdata('error_message');
            
            if(!empty($error))
            {
                echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$error.' </div>';
				$this->session->unset_userdata('error_message');
            }
            ?>
            
            <?php echo form_open_multipart($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            
            <!-- airplane_type Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airplane Type</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="airplane_type_first_name" placeholder="First Name" value="<?php echo $airplane_type_first_name;?>" required>
                </div>
            </div>
            
            <!-- Image -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Airplane Type Image</label>
                <input type="hidden" value="<?php echo $image;?>" name="current_image"/>
                <div class="col-lg-4">
                    
                    <div class="row">
                    
                    	<div class="col-md-4 col-sm-4 col-xs-4">
                        	<div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:200px; height:200px;">
                                    <img src="<?php echo $image_location.$thumb;?>">
                                </div>
                                <div>
                                    <span class="btn btn-file btn_pink"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input type="file" name="airplane_type_image"></span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate Airplane Type?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                        	<?php
                            if($airplane_type_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="airplane_type_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="1" name="airplane_type_status">';}
							?>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        	<?php
                            if($airplane_type_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="airplane_type_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="0" name="airplane_type_status">';}
							?>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit airplane_type
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>