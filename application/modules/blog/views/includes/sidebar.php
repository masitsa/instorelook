<?php
$recent_query = $this->blog_model->get_recent_posts();

if($recent_query->num_rows() > 0)
{
	$recent_posts = '';
	
	foreach ($recent_query->result() as $row)
	{
		$post_id = $row->post_id;
		$post_title = $row->post_title;
		$image = base_url().'assets/images/posts/thumbnail_'.$row->post_image;
		$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
		
		$recent_posts .= '
			<div class="widgett">
				  <div class="imgholder">
					   <a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'"><img src="'.$image.'" alt="'.$post_title.'"></a>
				  </div>
	
				  <div class="wttitle">
					   <h4><a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'">'.$post_title.'</a></h4>
				  </div>
	
				  <div class="details2">
					   <a href="'.site_url().'blog/post/'.$post_id.'" title="'.$post_title.'">'.$comments.' Comments</a>
				  </div>
			 </div>
		';
	}
}

else
{
	$recent_posts = 'No posts yet';
}

$categories_query = $this->blog_model->get_all_active_category_parents();
if($categories_query->num_rows() > 0)
{
	$categories = '';
	foreach($categories_query->result() as $res)
	{
		$category_id = $res->blog_category_id;
		$category_name = $res->blog_category_name;
		
		$children_query = $this->blog_model->get_all_active_category_children($category_id);
		
		//if there are children
		if($children_query->num_rows > 0)
		{
			$categories .= '<li><a href="'.site_url().'blog/category/'.$category_id.'" title="View all posts filed under '.$category_name.'">'.$category_name.'</a><ul class="sub-menu">';
			
			foreach($children_query->result() as $res2)
			{
				$child_id = $res2->blog_category_id;
				$child_name = $res2->blog_category_name;
				
				$categories .= '<li><a href="'.site_url().'blog/category/'.$child_id.'" title="View all posts filed under '.$child_name.'">'.$child_name.'</a></li>';
			}
			$categories .= '</ul></li>';
		}
		
		//no childrent
		else
		{
			$categories .= '<li><a href="'.site_url().'blog/category/'.$category_id.'" title="View all posts filed under '.$category_name.'">'.$category_name.'</a></li>';
		}
	}
}

else
{
	$categories = 'No Categories';
}
$popular_query = $this->blog_model->get_popular_posts();

if($popular_query->num_rows() > 0)
{
	$popular_posts = '';
	
	foreach ($popular_query->result() as $row)
	{
		$post_id = $row->post_id;
		$post_title = $row->post_title;
		$image = base_url().'assets/images/posts/thumbnail_'.$row->post_image;
		$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
		
		$popular_posts .= '
			<div class="widgett">
				  <div class="imgholder">
					   <a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'"><img src="'.$image.'" alt="'.$post_title.'"></a>
				  </div>
	
				  <div class="wttitle">
					   <h4><a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'">'.$post_title.'</a></h4>
				  </div>
	
				  <div class="details2">
					   <a href="'.site_url().'blog/post/'.$post_id.'" title="'.$post_title.'">'.$comments.' Comments</a>
				  </div>
			 </div>
		';
	}
}

else
{
	$popular_posts = 'No posts views yet';
}
?>
				<div class="sidebar">
                    <div class="widget-first widget recent_posts">
                        <h3><span>Recent</span> posts</h3>
                        
                        <div class="titleborder"></div>
						
                        <?php echo $recent_posts;?>
                         
                    </div>

                    <div class="widget widget_categories">
                         <h3><span>Our</span> Categories</h3>

                         <div class="titleborder"></div>

                         <ul>
                              <?php echo $categories;?>
                         </ul>
                    </div>


                    <div class="widget category_posts">
                         <h3><span>Popular</span> Posts</h3>

                         <div class="titleborder"></div>
						
                        <?php echo $popular_posts;?>
                    </div>

				</div>
		