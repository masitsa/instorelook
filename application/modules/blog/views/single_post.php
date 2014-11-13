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
<div class="content singledefult">
    <div id="post-4170" class="post-4170 post type-post status-publish format-standard hentry category-blog category-sculptures tag-cards tag-print">
         <div class="blogpost">
              <div class="posttext">

                   <div class="blogsingleimage">
                        <a href="<?php echo $image;?>" rel="lightbox[single-gallery]" title="<?php echo $post_title;?>"><img src="<?php echo $image;?>"></a>
                   </div>
                    <div class="titleDate">
                        <h1 ><?php echo $post_title;?></h1>
                        <h2 class="datewrap"><a href=""><?php echo $day;?> <?php echo $month;?></a></h2>
                    </div>

                   <div class="sentry">
                        <div>
                             <p><?php echo $description;?></p>
                        </div>
                   </div>
              </div>

              <div class="tags">
                   <?php echo $categories;?>
              </div>

             <div class="socialsingle">
                  <div class="addthis_toolbox">
                         <div class="custom_images">
                            <a class="addthis_button_facebook" addthis:url="<?php echo site_url().'blog/post/'.$post_id;?>" addthis:title="<?php echo $post_title;?>" title="Facebook"><img src="<?php echo base_url().'assets/themes/darx/';?>images/facebookIcon.png" width="64" height="64" border="0" alt="Facebook"></a>
                            <a class="addthis_button_twitter" addthis:url="<?php echo site_url().'blog/post/'.$post_id;?>" addthis:title="<?php echo $post_title;?>" title="Twitter"><img src="<?php echo base_url().'assets/themes/darx/';?>images/twitterIcon.png" width="64" height="64" border="0" alt="Twitter"></a>
                            <!--<a class="addthis_button_digg" addthis:url="<?php echo site_url().'blog/post/'.$post_id;?>" addthis:title="Page with sidebar" title="Digg"><img src="images/diggIcon.png" width="64" height="64" border="0" alt="Vimeo"></a>
                            <a class="addthis_button" addthis:url="http://premiumcoding.com/darxHtml/single.html" addthis:title="Page with sidebar"><img src="images/socialIconShareMore.png" width="64" height="64" border="0" alt="More..."></a>-->
                       </div>
					   <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f3049381724ac5b">
                    </script>
                  </div>
             </div>
         </div>
        <div style="clear:both"></div>
        <div class="comments">
			<div class="commentsborder"></div>
            <h3><span style="color:#8f278f;">Add</span> Comment</h3>
            
            <div class="content contact">
        <div class="postcontent">
            
            <h2><strong>Comments</strong></h2>

            <?php echo $comments;?>

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
                  <label for="author">Name <small>(Required)</small></label> <input type="text" name="name" id="name" />
                </div>

                <div class="commentfield">
                  <label for="email">Email </label> <input type="text" name="email" id="email" />
                </div>

                <div class="commentfield">
                  <label for="message">Comment <small>(Required)</small></label>

                  <div class="commentfieldarea">
                    <textarea name="post_comment_description" id="testo" rows="12" cols="">
</textarea>
                  </div>
                </div>

                <div class="contactbutton">
                  <input type="submit" class="contact-button" name="submit" value="Comment" /> 
				  <input type="reset" class="contact-button" name="clear" value="Clear" />
                </div>
				<span id="result">There was an error while sending your message.</span> 
				<span id="resultsuccess">Email sent succesfully. We usually answer within 24 hours.</span>
              </div>
            </form>
            
          </div>
        </div>


      </div>
	  
        </div>
    </div>

    <div class="related">
         <div class="relatedtitle">
              <div class="titleborder relatedb"></div>

              <h3><span>Related</span> posts</h3>
         </div>
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
					<div class="one_fourth '.$last.'">
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
