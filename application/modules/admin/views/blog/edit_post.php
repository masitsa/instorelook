<div class="row">
    <div class="col-lg-12">
     <a href="<?php echo site_url();?>posts" class="btn btn-primary pull-right">Back to posts</a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
          <style type="text/css">
		  	.add-on{cursor:pointer;}
		  </style>
          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			
			//the post details
			$post_id = $post[0]->post_id;
			$post_title = $post[0]->post_title;
			$post_status = $post[0]->post_status;
			$post_content = $post[0]->post_content;
			$image = $post[0]->post_image;
			$created = date('Y-m-d',strtotime($post[0]->created));
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
				$post_title = set_value('post_title');
				$post_status = set_value('post_status');
				$post_content = set_value('post_content');
				$created = set_value('created');
				
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
            }
			
            ?>
            
            <?php echo form_open_multipart($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
             <div class="row">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- post category -->
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Post Category</label>
                            <div class="col-lg-8">
                            	<?php echo $categories;?>
                            </div>
                        </div>
                        <!-- post Name -->
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Post Title</label>
                            <div class="col-lg-8">
                            	<input type="text" class="form-control" name="post_title" placeholder="Post Title" value="<?php echo $post_title;?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Post Date</label>
                            
                            <div class="col-lg-8">
                                <div id="datetimepicker1" class="input-append">
                                    <input data-format="yyyy-MM-dd" class="form-control" type="text" name="created" placeholder="Post Date" value="<?php echo $created;?>">
                                    <span class="add-on">
                                        &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div>
                            </div>
                        </div>

                       
                         <div class="form-group">
                            <label class="col-lg-4 control-label">Activate Post ?</label>
                            <div class="col-lg-8">
                                <?php
                                    if($post_status == 1)
                                    {
                                        echo '<input type="radio" name="post_status"  checked value="1"> Yes
                                              <input type="radio" name="post_status"  value="2"> No';
                                    }
                                    else
                                    {
                                       echo '<input type="radio" name="post_status"   value="1"> Yes
                                            <input type="radio" name="post_status" checked value="2"> No'; 
                                    }
                                ?>
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Image -->
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Post Image</label>
                            <input type="hidden" value="<?php echo $image;?>" name="current_image"/>
                            <div class="col-lg-8">
                                
                                <div class="row">
                                
                                	<div class="col-md-4 col-sm-4 col-xs-8">
                                    	<div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:150px; height:150px;">
                                                <img src="<?php echo base_url()."assets/images/posts/".$image;?>">
                                            </div>
                                            <div>
                                                <span class="btn btn-file btn-info"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input type="file" name="post_image"></span>
                                                <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- post content -->
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Post Content</label>
                        <div class="col-lg-8" style="height:auto;">
                            <textarea class="cleditor" name="post_content" placeholder="Post Content"><?php echo $post_content;?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-actions center-align">
                        <button class="submit btn btn-success" type="submit">
                            Update post details
                        </button>
                    </div>
                </div>
            </div>
            <br />
            <?php echo form_close();?>
		</div>
    </div>
</div>
