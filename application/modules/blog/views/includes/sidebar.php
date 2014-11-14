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
				<div class="row ">
					<div class="col-md-4">
					  <div class="imgholder">
						   <a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'"><img src="'.$image.'" alt="'.$post_title.'"></a>
					  </div>
					</div>
					<div class="col-md-8">
					  <div class="wttitle">
						   <h5><a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'">'.$post_title.'</a></h5>
					  </div>
		
					  <div class="details2">
						  <h6> <a href="'.site_url().'blog/post/'.$post_id.'" title="'.$post_title.'">'.$comments.' Comments</a></h6>
					  </div>
					</div>
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
		$categories .= '<a href="'.site_url().'blog/category/'.$category_id.'" title="View all posts filed under '.$category_name.'" class="list-group-item">'.$category_name.'</a>';
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
				<div class="row ">
					<div class="col-md-4">
					  <div class="imgholder">
						   <a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'"><img src="'.$image.'" alt="'.$post_title.'"></a>
					  </div>
					</div>
					<div class="col-md-8">
					  <div class="wttitle">
						   <h5><a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'">'.$post_title.'</a></h5>
					  </div>
		
					  <div class="details2">
						   <h6><a href="'.site_url().'blog/post/'.$post_id.'" title="'.$post_title.'">'.$comments.' Comments</a></h6>
					  </div>
					</div>
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
<div class="row " style="padding:5px;">
	<div class="list-group" >
	    <h3 style="margin-bottom:17px;"><span style="color:#2d2d2d;">Our</span> Categories</h3>
	    <div class="commentsborder"  style="margin-bottom:5px;"></div>
	     <?php echo $categories;?>
	 </div>
    <div class="list-group">
    	<h3 style="margin-bottom:17px;"><span style="color:#2d2d2d;">Recent</span> posts</h3>
    	<div class="commentsborder"  style="margin-bottom:5px;"></div>
        <?php echo $recent_posts;?>
    </div>
    
    <div class="list-group">
    	<h3 style="margin-bottom:17px;"><span style="color:#2d2d2d;">Popular</span> Posts</h3>
    	<div class="commentsborder"  style="margin-bottom:5px;"></div>
        <?php echo $popular_posts;?>
    </div>
</div>