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
				$category_id = $page[2];
				$category_details = $this->categories_model->get_category($category_id);
				
				if($category_details->num_rows() > 0)
				{
					$category = $category_details->row();
					$category_name = $category->category_name;
				}
				
				else
				{
					$category_name = 'No Category';
				}
				
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
				$product_id = $page[2];
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
				$category_id = $page[2];
				$category_details = $this->categories_model->get_category($category_id);
				
				if($category_details->num_rows() > 0)
				{
					$category = $category_details->row();
					$category_name = $category->category_name;
				}
				
				else
				{
					$category_name = 'No Category';
				}
				
				$crumb[1]['link'] = 'products/all-products/';
				$crumb[2]['name'] = ucwords(strtolower($category_name));
				$crumb[2]['link'] = 'products/category/'.$category_id;
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
				
				$crumb[1]['link'] = 'products/all-products/';
				$crumb[2]['name'] = ucwords(strtolower($brand_name));
				$crumb[2]['link'] = 'products/brand/'.$brand_id;
			}
			
			else if($page[1] == 'view-product')
			{
				$product_id = $page[2];
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
				
				$crumb[1]['link'] = 'products/all-products/';
				$crumb[2]['name'] = ucwords(strtolower($product_name));
				$crumb[2]['link'] = 'products/view-product/'.$product_id;
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
}

?>