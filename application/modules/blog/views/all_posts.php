<?php
		
		$result = '';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{	
			//get all administrators
			$administrators = $this->users_model->get_all_administrators();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$post_id = $row->post_id;
				$blog_category_name = $row->blog_category_name;
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
				$day = date('j',strtotime($created));
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
				
				$result .= 
				'
				<!-- Begin Post -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="thumbnail">
                            	<div class="row post-title">
                                	<div class="col-md-2">
                                    	<div class="row post-date">
                                        	<div class="col-md-12">
                                            	<p>'.$day.' '.$month.'</p>
                                            </div>
                                        </div>
                                    	<div class="row post-comments">
                                        	<div class="col-md-12">
                                            	<p>10 Comments</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-10">
                            			<h3><a href="'.site_url().'blog/post/'.$post_id.'">'.$post_title.'</a></h3>
                                    </div>
                                </div>
                                <a href="'.site_url().'blog/post/'.$post_id.'"><img src="'.$image.'" alt="'.$post_title.'" class="img-responsive post-image"></a>
                                <div class="caption">
                                    <p>'.$mini_desc.'...</p>
                                    <div class="center-align">
                                        <a class="btn btn-read-more" href="'.site_url().'blog/post/'.$post_id.'">
                                            <span data-hover="Read more">
                                            	Read more
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                	<!-- End: Post -->
				';
			}
		}
		
		else
		{
			$result .= "There are no posts :-(";
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
                	<?php echo $result;?>
                    
					<?php
                        if(isset($links)){echo $links;}
                    ?>
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
