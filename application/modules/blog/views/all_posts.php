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
				$month = date('M',strtotime($created));
				
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
					<div class="blogpostcategory">
                         <div class="blogimage">
                              <a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'"><img src="'.$image.'" alt="'.$post_title.'"></a>
                         </div>

                         <div class="entry">
                              <div class="leftholder">
                                   <div class="posted-date">
                                        <div class="date-inside">
                                             <a href="#"></a>

                                             <div class="day">
                                                  '.$day.'
                                             </div>

                                             <div class="month">
                                                  '.$month.'
                                             </div>
                                        </div>
                                   </div>

                                   <div class="commentblog">
                                        <div class="circleHolder">
                                             <div class="comment-inside">
                                                  <a href="'.site_url().'blog/post/'.$post_id.'" title="Commens">'.$comments.'</a>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div class="meta">
                                   <h2 class="title"><a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'">'.$post_title.'</a></h2>

                                   <div class="authorblog">
                                        <strong>By:</strong> <a href="#" title="Posts by '.$created_by.'" rel="author">'.$created_by.'</a>
                                   </div>

                                   <div class="categoryblog">
                                        <strong>Categories:</strong> 
										'.$categories.'
                                   </div>

                                   <div class="blogcontent">
                                        '.$mini_desc.'...
                                   </div>

									<a class="blogmore" href="'.site_url().'blog/post/'.$post_id.'">Read more &#8594;</a>
                              </div>
                         </div>
                    </div>
				';
			}
		}
		
		else
		{
			$result .= "There are no posts :-(";
		}
		
		echo $result;
?>


<?php
    if(isset($links)){echo $links;}
?>
