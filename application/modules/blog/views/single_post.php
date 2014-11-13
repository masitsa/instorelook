<?php
	$post_id = $row->post_id;
	$blog_category_id = $row->blog_category_id;
	$post_title = $row->post_title;
	$post_status = $row->post_status;
	$post_views = $row->post_views;
	$image = base_url().'assets/images/posts/'.$row->post_image;
	$created_by = $row->created_by;
	$modified_by = $row->modified_by;
	$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
	$categories_query = $this->blog_model->get_all_post_categories($blog_category_id);
	$description = $row->post_content;
	$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 50));
	$created = $row->created;
	$day = date('jS',strtotime($created));
	$month = date('M Y',strtotime($created));
	$tiny_url = '';//$row->tiny_url;
	
	$categories = '';
	$count = 0;
	//get all administrators
	$administrators = $this->users_model->get_all_administrators();
	if ($administrators->num_rows() > 0)
	{
		$admins = $administrators->result();
		
		if($admins != NULL)
		{
			foreach($admins as $adm)
			{
				$user_id = $adm->user_id;
				
				if($user_id == $created_by)
				{
					$created_by = $adm->first_name;
				}
			}
		}
	}
	
	else
	{
		$admins = NULL;
	}
	
	foreach($categories_query->result() as $res)
	{
		$count++;
		$category_name = $res->blog_category_name;
		$category_id = $res->blog_category_id;
		
		if($count == $categories_query->num_rows())
		{
			$categories .= '<a href="'.site_url().'blog/category/'.$category_id.'" title="View all posts in '.$category_name.'" rel="category tag">'.$category_name.'</a>';
		}
		
		else
		{
			$categories .= '<a href="'.site_url().'blog/category/'.$category_id.'" title="View all posts in '.$category_name.'" rel="category tag">'.$category_name.'</a>, ';
		}
	}
	
	//comments
	$comments = 'No Comments';
	if($comments_query->num_rows() > 0)
	{
		$comments = '';
		foreach ($comments_query->result() as $row)
		{
			$post_comment_user = $row->post_comment_user;
			$post_comment_description = $row->post_comment_description;
			$date = date('jS M Y H:i a',strtotime($row->comment_created));
			
			$comments .= 
			'
				<div class="user_comment">
					<h5>'.$post_comment_user.' - '.$date.'</h5>
					<p>'.$post_comment_description.'</p>
				</div>
			';
		}
	}
?>
<!-- Join  -->
<div class="content light-grey-background">
    <div class="container">
        <div class="search-flights">
        	
            <div class="divider-line"></div>
            <h1 class="center-align">Blog</h1>
            <div class="divider-line" style="margin-bottom:2%;"></div>
            
            <div class="row">
                <!-- Posts -->
            	<div class="col-md-9">
                
                    <!-- Begin Post -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="thumbnail">
                                <div class="row post-title">
                                    <div class="col-md-2">
                                        <div class="row post-date">
                                            <div class="col-md-12">
                                                <p><?php echo $day;?> <?php echo $month;?></p>
                                            </div>
                                        </div>
                                        <div class="row post-comments">
                                            <div class="col-md-12">
                                                <p>10 Comments</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-7">
                                        <h3><a href="#"><?php echo $post_title;?></a></h3>
                                    </div>
                                    
                                    <div class="col-md-3" style="padding-right:0; height:100%; padding-top: 10px;">
                                        <div class="share">
                                            <div class="center-align">
                                                <a href="#" class="btn btn-gray fb-share" onclick="post_facebook_share('<?php echo $image;?>', '<?php echo $post_title;?> ', '<?php echo $tiny_url;?>')"><i class="fa fa-facebook-square"></i> Share</a>
                                                
                                                <a target="_blank" href="https://twitter.com/intent/tweet?screen_name=autosparesk&text=<?php echo $post_title;?>%20<?php echo $tiny_url; ?>" class="btn btn-gray twitter-share"><i class="fa fa-twitter-square"></i> Share</a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <a href="#"><img src="<?php echo $image;?>" alt="<?php echo $post_title;?>" class="img-responsive post-image"></a>
                                <div class="caption">
                                    <p><?php echo $description;?></p>
                                </div>
                                
                                <div class="comments">
                                    <div class="commentsborder"></div>
                                    <h2 class="title"><span style="color:#2d2d2d;">Add</span> Comment</h3>
                                    
                                    <div class="posttext">
                                        <?php
                                        $validation_errors = validation_errors();
                                        $errors = $this->session->userdata('error_message');
                                        $success = $this->session->userdata('success_message');
                                        
                                        if(!empty($validation_errors))
                                        {
                                        echo '<div style="color:red;">'.$validation_errors.'</div>';
                                        }
                                        
                                        if(!empty($errors))
                                        {
                                        echo '<div style="color:red;">'.$errors.'</div>';
                                        $this->session->unset_userdata('error_message');
                                        }
                                        
                                        if(!empty($success))
                                        {
                                        echo '<div style="color:green;">'.$success.'</div>';
                                        $this->session->unset_userdata('success_message');
                                        }
                                        ?>
                                        <form method="post" action="<?php echo site_url().'blog/add_comment/'.$post_id;?>">
                                            <div id="contactform">
                                                <div class="commentfield">
                                                    <label for="author">Name <small>(Required)</small>:</label> <input type="text" name="name" id="name" />
                                                </div>
                                                <div class="clear-both"></div>
                                                <div class="commentfield">
                                                    <label for="email">Email:</label> <input type="text" name="email" id="email" />
                                                </div>
                                                <div class="clear-both"></div>
                                                <div class="commentfield">
                                                    <label for="message">Comment <small>(Required)</small>:</label>
                                                    
                                                    <div class="commentfieldarea">
                                                        <textarea name="post_comment_description" id="testo" rows="12" cols=""></textarea>
                                                    </div>
                                                </div>
                                                <div class="clear-both"></div>
                                                <div class="center-align contactbutton">
                                                    <input type="submit" class="contact-button btn-red" name="submit" value="Comment" /> 
                                                    <input type="reset" class="contact-button" name="clear" value="Clear" />
                                                </div>
                                            </div>
                                        </form>
                                    
                                    </div>
                                    <div class="clear-both"></div>
                                    <div class="commentsborder"></div>
                                    
                                    <div class="content">
                                        <div class="postcontent">
                                        
                                            <h2 class="title"><span style="color:#2d2d2d;"><?php echo $total_comments;?></span> <?php echo $title;?></h2>
                                            
                                            <?php echo $comments;?>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row related">
                                     <h2 class="title"><span style="color:#2d2d2d;">Related</span> Posts</h2>
                                    <?php
                                    //related posts
                                    $related_posts_query = $this->blog_model->get_related_posts($blog_category_id, $post_id);
                                    
                                    if($related_posts_query->num_rows() > 0)
                                    {
                                        $related_posts = '';
                                        $count = 0;
                                        
                                        foreach ($related_posts_query->result() as $row)
                                        {
                                            $post_id = $row->post_id;
                                            $post_title = $row->post_title;
                                            $image = base_url().'assets/images/posts/thumbnail_'.$row->post_image;
                                            $comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
                                            $count++;
                                            
                                            if($count == 4)
                                            {
                                                $last = 'last';
                                            }
                                            
                                            else
                                            {
                                                $last = '';
                                            }
                                            $related_posts .= '
                                                <div class="col-md-3">
                                                    <div class="image">
                                                       <a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'"><img src="'.$image.'"></a>
                                                    </div>
                                                    
                                                    <h4><a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'">'.$post_title.'</a></h4>
                                                </div>
                                            ';
                                        }
                                    }
                                    
                                    else
                                    {
                                        $related_posts = 'No posts views yet';
                                    }
                                    echo $related_posts;
                                    ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- End: Post -->
                </div>
                <!-- End: Posts -->
                
                <!-- Navigation -->
				<div class="col-md-3">
                <?php echo $this->load->view('includes/sidebar', '', TRUE);?>
            	</div>
                <!-- End: Navigation -->
            </div>
        </div>
    </div>
</div>
<!-- End Join -->
          
