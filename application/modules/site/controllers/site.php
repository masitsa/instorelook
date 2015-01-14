<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MX_Controller {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('vendor/products_model');
		$this->load->model('vendor/categories_model');
		$this->load->model('vendor/features_model');
		$this->load->model('vendor/brands_model');
		$this->load->model('cart_model');
		$this->load->model('admin/users_model');
		//$this->load->model('login/login_model');
		
		$this->load->library('cart');
		$this->load->model('site/site_model');
	}
    
	/*
	*
	*	Default action is to go to the home page
	*
	*/
	public function index() 
	{
		$this->load->view('includes/top_navigation');
	}
    
	/*
	*
	*	Home Page
	*
	*/
	public function home_page() 
	{
		//get page data
		$v_data['latest'] = $this->products_model->get_latest_products();
		$v_data['featured'] = $this->products_model->get_featured_products();
		$v_data['brands'] = $this->brands_model->all_active_brands();
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$data['content'] = $this->load->view('home/home', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Filter products by brand
	*
	*/
	public function filter_brands()
	{
		$total_brands = sizeof($_POST['brand']);
		
		//check if any checkboxes have been ticked
		if($total_brands > 0)
		{
			$brands = '';
			
			for($r = 0; $r < $total_brands; $r++){
				
				$brand = $_POST['brand'];
				$brand_id = $brand[$r]; 
				
				if($r == 0)
				{
					$brands .= $brand_id;
				}
				
				else
				{
					$brands .= '-'.$brand_id;
				}
			}
			redirect('products/filter-brands/'.$brands);
		}
		
		else
		{
			redirect('products/all-products');
		}
	}
    
	/*
	*
	*	Products Page
	*
	*/
	public function products($search = '__', $category_id = 0, $brand_id = 0, $order_by = 'created', $new_products = 0, $new_categories = 0, $new_brands = 0, $price_range = '__', $filter_brands = '__') 
	{
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		$v_data['brands'] = $this->brands_model->all_active_brands();
		$v_data['product_sub_categories'] = $this->categories_model->get_sub_categories($category_id);
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['price_range'] = $this->site_model->generate_price_range();
		
		$where = 'product.category_id = category.category_id AND product.brand_id = brand.brand_id AND product_status = 1 AND category_status = 1 AND brand_status = 1';
		$table = 'product, category, brand';
		$limit = NULL;
		
		//ordering products
		switch ($order_by)
		{
			case 'created':
				$order_method = 'DESC';
			break;
			
			case 'price':
				$order_method = 'ASC';
			break;
			
			case 'price_desc':
				$order_method = 'DESC';
			break;
		}
		
		//case of filter_brands
		if($filter_brands != '__')
		{
			$brands = explode("-", $filter_brands);
			$total = count($brands);
			
			if($total > 0)
			{
				$where .= ' AND (';
				for($r = 0; $r < $total; $r++)
				{
					if($r ==0)
					{
						$where .= 'product.brand_id = '.$brands[$r];
					}
					
					else
					{
						$where .= ' OR product.brand_id = '.$brands[$r];
					}
				}
				$where .= ')';
			}
		}
		
		//case of price_range
		if($price_range != '__')
		{
			$range = explode("-", $price_range);
			$total = count($range);
			
			if($total == 2)
			{
				$start = $range[0];
				$end = $range[1];
				$where .= " AND (product.product_selling_price BETWEEN ".$start." AND ".$end.")";
			}
		}
		
		//case of search
		if($search != '__')
		{
			$where .= " AND (product.product_name LIKE '%".$search."%' OR category.category_name LIKE '%".$search."%' OR brand.brand_name LIKE '%".$search."%')";
		}
		
		//case of category
		if($category_id > 0)
		{
			$where .= ' AND (category.category_id = '.$category_id.' OR category.category_parent = '.$category_id.')';
		}
		
		//case of brand
		if($brand_id > 0)
		{
			$where .= ' AND brand.brand_id = '.$brand_id;
		}
		
		//case of latest products
		if($new_products == 1)
		{
			$limit = 30;
		}
		
		//case of latest category
		if($new_categories == 1)
		{
			$query = $this->categories_model->latest_category();
			
			if($query->num_rows() > 0)
			{
				$category = $query->row();
				$latest_category_id = $category->category_id;
				
				$where .= ' AND category.category_id = '.$latest_category_id;
			}
		}
		
		//case of latest brand
		if($new_brands == 1)
		{
			$query = $this->brands_model->latest_brand();
			
			if($query->num_rows() > 0)
			{
				$brand = $query->row();
				$latest_brand_id = $brand->brand_id;
				
				$where .= ' AND brand.brand_id = '.$latest_brand_id;
			}
		}
		
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'site/products';
		$config['total_rows'] = $this->users_model->count_items($table, $where, $limit);
		$config['uri_segment'] = 5;
		$config['per_page'] = 21;
		$config['num_links'] = 5;
		
		
		$config['full_tag_open'] = '<ul class="pagination no-margin-top">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = '»';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = '«';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		if($limit == NULL)
		{
        	$v_data["links"] = $this->pagination->create_links();
			$v_data["first"] = $page + 1;
			$v_data["total"] = $config['total_rows'];
			
			if($v_data["total"] < $config["per_page"])
			{
				$v_data["last"] = $page + $v_data["total"];
			}
			
			else
			{
				$v_data["last"] = $page + $config["per_page"];
			}
		}
		
		else
		{
			$v_data["first"] = $page + 1;
			$v_data["total"] = $config['total_rows'];
			$v_data["last"] = $config['total_rows'];
		}
		$v_data['products'] = $this->products_model->get_all_products($table, $where, $config["per_page"], $page, $limit, $order_by, $order_method);
		
		$data['content'] = $this->load->view('products/products', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Search for a product
	*
	*/
	public function search()
	{
		$search = $this->input->post('search_item');
		
		if(!empty($search))
		{
			redirect('products/search/'.$search);
		}
		
		else
		{
			redirect('products/all-products');
		}
	}
    
	/*
	*
	*	Products Page
	*
	*/
	public function view_product($product_id)
	{
		$this->products_model->update_clicks($product_id);
		//Required general page data
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		//get page data
		$v_data['all_features'] = $this->features_model->all_features();
		$v_data['similar_products'] = $this->products_model->get_similar_products($product_id);
		$v_data['product_details'] = $this->products_model->get_product($product_id);
		$v_data['product_images'] = $this->products_model->get_gallery_images($product_id);
		$v_data['product_features'] = $this->products_model->get_features($product_id);
		$data['content'] = $this->load->view('products/view_product', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	About Page
	*
	*/
	public function about() 
	{
		//get page data
		$data['content'] = $this->load->view('about', '', true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Terms Page
	*
	*/
	public function terms() 
	{
		//get page data
		$data['content'] = $this->load->view('terms', '', true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
}
?>