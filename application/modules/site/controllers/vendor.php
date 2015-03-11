<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends MX_Controller 
{
	var $vendor_path;
	var $vendor_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('vendor/products_model');
		$this->load->model('vendor_model');
		$this->load->model('site_model');
		$this->load->model('admin/file_model');
		$this->load->model('site/cart_model');

		$this->load->model('vendor/categories_model');
		$this->load->model('vendor/features_model');
		$this->load->model('vendor/brands_model');
		$this->load->model('vendor/slideshow_model');
		$this->load->model('vendor/static_banners_model');
		
		$this->load->library('image_lib');
		$this->load->library('encrypt');
		$this->load->model('admin/users_model');
		//$this->load->model('login/login_model');
		
		//path to image directory
		$this->vendor_path = realpath(APPPATH . '../assets/images/vendors');
		$this->vendor_location = base_url().'assets/images/vendors/';
		$this->load->library('Mandrill', $this->config->item('appID'));
		
		$this->slideshow_location = base_url().'assets/slideshow/';
		$this->products_path = realpath(APPPATH . '../assets/images/products/images');
		$this->products_location = base_url().'assets/images/products/images/';
	}
	
	public function index()
	{
		$where = 'vendor.vendor_id > 0 AND vendor.surburb_id = surburb.surburb_id';
		$table = 'vendor,surburb';
		$vendor_search = $this->session->userdata('vendor_search');
		
		if(!empty($vendor_search))
		{
			$where .= $vendor_search;
		}
		$segment = 3;
		$limit = NULL;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'vendor/all-vendors';
		$config['total_rows'] = $this->vendor_model->count_items($table, $where);
		$config['uri_segment'] = 2;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
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
		$query = $this->vendor_model->get_all_vendors($table, $where, $config["per_page"], $page);
		
		$v_data['latest'] = $this->products_model->get_latest_products();
		$v_data['featured'] = $this->products_model->get_featured_products();
		$v_data['brands'] = $this->brands_model->all_active_brands();
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		if ($query->num_rows() > 0)
		{
			$v_data['crumbs'] = $this->site_model->get_crumbs();
			$v_data['vendor'] = $query;
			$v_data['page'] = $page;
			$v_data['vendor_path'] = $this->vendor_path;
			$v_data['vendor_location'] = $this->vendor_location;
			$data['content'] = $this->load->view('vendor/all_vendors', $v_data, true);
		}
		
		else
		{
			$data['content'] = '';
		}
		$data['title'] = 'All Vendors';
		
		$this->load->view('templates/general_page', $data);
	}
	function vendor_products($vendor_name,$vendor_id ,$search = '__', $category_id = 0, $brand_id = 0, $order_by = 'created', $new_products = 0, $new_categories = 0, $new_brands = 0, $price_range = '__', $filter_brands = '__') 
	{
		$v_data['products_path'] = $this->products_path;
		$v_data['products_location'] = $this->products_location;
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		$v_data['brands'] = $this->brands_model->all_active_brands();
		$v_data['product_sub_categories'] = $this->categories_model->get_sub_categories($category_id);
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		$where = 'product.category_id = category.category_id AND product.brand_id = brand.brand_id AND product_status = 1 AND category_status = 1 AND brand_status = 1 AND product.created_by = '.$vendor_id;
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
		$v_data['vendor_name'] = $this->vendor_model->get_vendor_name($vendor_id);
		$data['content'] = $this->load->view('vendor/vendor_products', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	

	}
	public function vendor_details($vendor_name,$vendor_id)
	{
		$where = 'vendor.vendor_id > 0 AND vendor.surburb_id = surburb.surburb_id AND vendor.vendor_id = '.$vendor_id;
		$table = 'vendor,surburb';
		
		
		$v_data['latest'] = $this->products_model->get_latest_products();
		$v_data['featured'] = $this->products_model->get_featured_products();
		$v_data['brands'] = $this->brands_model->all_active_brands();
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$query = $this->vendor_model->get_vendor_details($vendor_id,$table,$where);
		if ($query->num_rows() > 0)
		{
			$v_data['crumbs'] = $this->site_model->get_crumbs();
			$v_data['vendor_details'] = $query;
			$v_data['vendor_path'] = $this->vendor_path;
			$v_data['vendor_location'] = $this->vendor_location;
			$data['content'] = $this->load->view('vendor/vendor_details', $v_data, true);
		}
		
		else
		{
			$data['content'] = '';
		}
		$data['title'] = 'Request Company';
		
		$this->load->view('templates/general_page', $data);
	}
    
}