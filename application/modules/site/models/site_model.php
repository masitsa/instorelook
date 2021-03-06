<?php

class Site_model extends CI_Model 
{
	public function display_page_title()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		
		$page_url = ucwords(strtolower($page[0]));
		
		if($total > 1)
		{
			$sub_page = explode("-",$page[1]);
			$total_sub = count($sub_page);
			$page_name = '';
			
			for($r = 0; $r < $total_sub; $r++)
			{
				$page_name .= ' '.$sub_page[$r];
			}
			$page_url .= ' | '.ucwords(strtolower($page_name));
			
			if($page[1] == 'category')
			{
				$category_name = $page[2];
				
				$page_url .= ' | '.ucwords(strtolower($category_name));
			}
			
			else if($page[1] == 'brand')
			{
				$brand_id = $page[2];
				$brand_details = $this->brands_model->get_brand($brand_id);
				
				if($brand_details->num_rows() > 0)
				{
					$brand = $brand_details->row();
					$brand_name = $brand->brand_name;
				}
				
				else
				{
					$brand_name = 'No Brand';
				}
				
				$page_url .= ' | '.ucwords(strtolower($brand_name));
			}
			
			else if($page[1] == 'view-product')
			{
				$product_code = $page[2];
				$product_id = $this->get_product_id($product_code);
				$product_details = $this->products_model->get_product($product_id);
				
				if($product_details->num_rows() > 0)
				{
					$product = $product_details->row();
					$product_name = $product->product_name;
				}
				
				else
				{
					$product_name = 'No Product';
				}
				
				$page_url .= ' | '.ucwords(strtolower($product_name));
			}
		}
		
		return $page_url;
	}
	
	public function get_crumbs()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		
		$crumb[0]['name'] = ucwords(strtolower($page[0]));
		$crumb[0]['link'] = $page[0];
		
		if($total > 1)
		{
			$sub_page = explode("-",$page[1]);
			$total_sub = count($sub_page);
			$page_name = '';
			
			for($r = 0; $r < $total_sub; $r++)
			{
				$page_name .= ' '.$sub_page[$r];
			}
			$crumb[1]['name'] = ucwords(strtolower($page_name));
			
			if($page[1] == 'category')
			{
				$category_name = $page[2];
				$category_web_name = $this->site_model->create_web_name($category_name);
				
				$crumb[1]['link'] = 'products';
				$crumb[2]['name'] = ucwords(strtolower($category_name));
				$crumb[2]['link'] = 'products/category/'.$category_web_name;
			}
			
			else if($page[1] == 'brand')
			{
				$brand_id = $page[2];
				$brand_details = $this->brands_model->get_brand($brand_id);
				
				if($brand_details->num_rows() > 0)
				{
					$brand = $brand_details->row();
					$brand_name = $brand->brand_name;
				}
				
				else
				{
					$brand_name = 'No Brand';
				}
				
				$crumb[1]['link'] = 'products';
				$crumb[2]['name'] = ucwords(strtolower($brand_name));
				$crumb[2]['link'] = 'products/brand/'.$brand_id;
			}
			
			else if($page[1] == 'view-product')
			{
				$product_code = $page[2];
				$product_id = $this->get_product_id($product_code);
				$product_details = $this->products_model->get_product($product_id);
				
				if($product_details->num_rows() > 0)
				{
					$product = $product_details->row();
					$product_name = $product->product_name;
				}
				
				else
				{
					$product_name = 'No Product';
				}
				
				$crumb[1]['link'] = 'products';
				$crumb[2]['name'] = ucwords(strtolower($product_name));
				$crumb[2]['link'] = 'products/view-product/'.$product_code;
			}
			
			else
			{
				$crumb[1]['link'] = '#';
			}
		}
		
		return $crumb;
	}
	
	function generate_price_range()
	{
		$max_price = $this->products_model->get_max_product_price();
		//$min_price = $this->products_model->get_min_product_price();
		
		$interval = $max_price/5;
		
		$range = '';
		$start = 0;
		$end = 0;
		
		for($r = 0; $r < 5; $r++)
		{
			$end = $start + $interval;
			$value = '$'.number_format(($start+1), 0, '.', ',').' - $'.number_format($end, 0, '.', ',');
			$range .= '<label> <input type="radio" name="agree" value="'.$start.'-'.$end.'"  /> '.$value.'</label> <br>';
			
			$start = $end;
		}
		
		return $range;
	}
	
	public function get_all_categories()
	{
		$this->db->where(array('category_status'=> 1, 'category_parent > ' => 0));
		return $this->db->get('category');
	}
	
	public function get_parent_categories()
	{
		$this->db->where(array('category_status'=> 1, 'category_parent' => 0));
		return $this->db->get('category');
	}
	
	public function get_states()
	{
		$this->db->order_by('state_name');
		$query = $this->db->get('state');
		
		return $query;
	}
	
	public function get_surburbs()
	{
		$this->db->order_by('surburb_name, state_name');
		$this->db->where('state.state_id = surburb.state');
		$query = $this->db->get('surburb, state');
		
		return $query;
	}
	
	public function search_surburb($search)
	{
		$where = "state.state_id = surburb.state AND (surburb.surburb_name LIKE '%".$search."%' OR surburb.post_code LIKE '%".$search."%' OR state.state_name LIKE '%".$search."%')";
		$this->db->where($where);
		$this->db->order_by('surburb_name, state_name');
		$query = $this->db->get('surburb, state');
		
		return $query;
	}
	public function request_newsletter()
	{
		$data = array(
			'created_on'=>date('Y-m-d'),
			'email_address'=>$this->input->post('email_address'),
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name')
		);
		
		if($this->db->insert('newsletter_requests', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	public function create_query_filter($parameter_array, $table_field)
	{
		$parameters = explode("_", $parameter_array);
		$total = count($parameters);
		$where = ' AND (';
		
		for($r = 0; $r < $total; $r++)
		{
			$parameter_name = str_replace("-", " ", $parameters[$r]);
			
			if($r == 0)
			{
				$where .= $table_field.' = \''.$parameter_name.'\'';
			}
			
			else
			{
				$where .= ' OR '.$table_field.' = \''.$parameter_name.'\'';
			}
		}
		
		$where .= ')';
		
		$return['where'] = $where;
		$return['parameters'] = $parameters;
		
		return $return;
	}
	
	public function create_category_query_filter($parameter_array, $table_field)
	{
		$parameters = explode("_", $parameter_array);
		$total = count($parameters);
		$where = ' AND (';
		
		//filter for category
		for($r = 0; $r < $total; $r++)
		{
			$parameter_name = str_replace("-", " ", $parameters[$r]);
			
			if($r == 0)
			{
				$where .= $table_field.' = \''.$parameter_name.'\'';
			}
			
			else
			{
				$where .= ' OR '.$table_field.' = \''.$parameter_name.'\'';
			}
		}
		
		//filter for parent
		for($r = 0; $r < $total; $r++)
		{
			$parameter_name = str_replace("-", " ", $parameters[$r]);
			
			$where .= ' OR category.category_parent = (SELECT category.category_id FROM category WHERE category_name = \''.$parameter_name.'\')';
		}
		
		$where .= ')';
		
		$return['where'] = $where;
		$return['parameters'] = $parameters;
		
		return $return;
	}
	
	public function create_web_name($field_name)
	{
		$web_name = str_replace(" ", "-", $field_name);
		
		return $web_name;
	}
	
	public function make_suggestion()
	{
		$data = array(
			'company_name'=>$this->input->post('company_name'),
			'company_description'=>$this->input->post('company_description')
		);
		
		if($this->db->insert('customer_requests', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	public function add_product_review($product_id)
	{
		$data = array(
			'product_review_content'=>$this->input->post('review_text'),
			'product_review_rating'=>$this->input->post('rate'),
			'product_review_reviewer_email'=>$this->input->post('review_author_email'),
			'product_review_reviewer_name'=>$this->input->post('review_author_name'),
			'product_review_reviewer_phone'=>$this->input->post('review_author_phone'),
			'product_id'=>$product_id,
			'product_review_created'=>date('Y-m-d')
		);
		
		if($this->db->insert('product_review', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
    
	/*
	*
	*	Vendor Account Verification Email
	*
	*/
	public function contact_admin() 
	{
		$this->load->model('site/email_model');
		$date = date('jS M Y H:i a',strtotime(date('Y-m-d H:i:s')));
		$subject = $this->input->post('sender_name')." needs some help";
		$message = '
				<p>A help message was sent on '.$date.' saying:</p> 
				<p>'.$this->input->post('message').'</p>
				<p>Their contact details are:</p>
				<p>
					Name: '.$this->input->post('sender_name').'<br/>
					Email: '.$this->input->post('sender_email').'<br/>
					Phone: '.$this->input->post('sender_phone').'
				</p>
				';
		$sender_email = $this->input->post('sender_email');
		$shopping = "";
		$from = $this->input->post('sender_name');
		
		$button = '';
		$response = $this->email_model->send_mandrill_mail('info@instorelook.com.au', "Hi Bryn", $subject, $message, $sender_email, $shopping, $from, $button, $cc = NULL);
		
		//echo var_dump($response);
		
		return $response;
	}
	
	public function get_product_id($product_code)
	{
		$this->db->where('product_code', $product_code);
		$query = $this->db->get('product');
		
		$row = $query->row();
		$product_id = $row->product_id;
		
		return $product_id;
	}
}

?>