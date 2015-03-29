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
    
	/*
	*
	*	Search for a business_name
	*
	*/
	public function search_business_name()
	{
		$search = $this->input->post('search_item');
		$post_postcode = $this->input->post('filter_postcode');
		$post_categories = $this->input->post('filter_categories');
		
		if(!empty($search))
		{
			$this->index($search, $order_by = 'surburb.post_code', $post_categories, $post_postcode);
		}
		
		else
		{
			redirect('vendors/all-vendors');
		}
	}
    
	/*
	*
	*	Search for a post code
	*
	*/
	public function search_post_code()
	{
		$search = $this->input->post('search_item');
		$post_search = $this->input->post('filter_search');
		$post_categories = $this->input->post('filter_categories');
		
		if(!empty($search))
		{
			$this->index($post_search, $order_by = 'vendor.vendor_store_name', $post_categories, $search);
		}
		
		else
		{
			redirect('vendors/all-vendors');
		}
	}
    
	/*
	*
	*	Filter vendors by category
	*
	*/
	public function filter_categories()
	{
		if(isset($_POST['category_name']))
		{
			$total_categories = sizeof($_POST['category_name']);
			$post_postcode = $this->input->post('filter_postcode');
			$post_search = $this->input->post('filter_search');
			
			//check if any checkboxes have been ticked
			if($total_categories > 0)
			{
				$categories = '';
				$category = $_POST['category_name'];
				
				for($r = 0; $r < $total_categories; $r++)
				{
					$category_web_name = $category[$r]; 
					
					if($r == 0)
					{
						$categories .= $category_web_name;
					}
					
					else
					{
						$categories .= '_'.$category_web_name;
					}
				}
				$this->index($post_search, $order_by = 'vendor.vendor_created', $categories, $post_postcode);
			}
			
			else
			{
				redirect('vendors/all-vendors');
			}
		}
		
		else
		{
			redirect('vendors/all-vendors');
		}
	}
	
	public function index($search = '__', $order_by = 'vendor.vendor_created', $categories = '__', $post_code = '__')
	{
		$v_data['categories_array'] = '';
		$v_data['filter_categories'] = $categories;
		$v_data['filter_search'] = $search;
		$v_data['filter_postcode'] = $post_code;
		
		$where = 'vendor.vendor_status = 1 AND vendor.surburb_id = surburb.surburb_id';
		$table = 'vendor, surburb';
		
		//case of filter categories
		if($categories != '__')
		{
			$return = $this->site_model->create_category_query_filter($categories, 'category.category_name');
			
			$table .= ', vendor_category, category';
			$where .= ' AND vendor_category.vendor_id = vendor.vendor_id AND vendor_category.category_id = category.category_id AND vendor_category.vendor_category_status = 1 '.$return['where'];
			
			$v_data['categories_array'] = $return['parameters'];
		}
		
		//case of search
		if($search != '__')
		{
			$where .= " AND (vendor.vendor_store_name LIKE '%".$search."%' OR surburb.surburb_name LIKE '%".$search."%') ";
		}
		
		//case of postcode
		if($post_code != '__')
		{
			$where .= "  AND surburb.post_code = '".$post_code."'";
		}
		
		//ordering products
		switch ($order_by)
		{
			case 'vendor.vendor_created':
				$order_method = 'DESC';
			break;
			
			case 'vendor.vendor_store_name':
				$order_method = 'ASC';
			break;
			
			case 'surburb.post_code':
				$order_method = 'ASC';
			break;
			
			default:
				$order_method = 'DESC';
			break;
			
		}
		
		$segment = 3;
		$limit = NULL;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'vendor/all-vendors';
		$config['total_rows'] = $this->vendor_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
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
		$query = $this->vendor_model->get_all_vendors($table, $where, $config["per_page"], $page, $order_by, $order_method);
		
		$v_data['latest'] = $this->products_model->get_latest_products();
		$v_data['featured'] = $this->products_model->get_featured_products();
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
			$v_data['came'] = $this->uri->uri_string();
			$data['content'] = $this->load->view('unable', $v_data, true);
		}
		$data['title'] = 'All Vendors';
		
		$this->load->view('templates/general_page', $data);
	}
	
	public function vendor_details($vendor_name)
	{
		$vendor = explode('&', $vendor_name);
		$name = $vendor[0];
		$vendor_id = $vendor[1];
		$where = 'vendor.vendor_id > 0 AND vendor.surburb_id = surburb.surburb_id AND vendor.vendor_id = '.$vendor_id;
		$table = 'vendor,surburb';
		
		$v_data['latest'] = $this->products_model->get_latest_products();
		$v_data['featured'] = $this->products_model->get_featured_products();
		$v_data['brands'] = $this->brands_model->all_active_brands();
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['products_path'] = $this->products_path;
		$v_data['products_location'] = $this->products_location;
		$query = $this->vendor_model->get_vendor_details($vendor_id,$table,$where);
		if ($query->num_rows() > 0)
		{
			$v_data['crumbs'] = $this->site_model->get_crumbs();
			$v_data['vendor_details'] = $query;
			$v_data['vendor_path'] = $this->vendor_path;
			$v_data['vendor_location'] = $this->vendor_location;
			$v_data['products'] = $this->vendor_model->get_vendor_products($vendor_id);
			$data['content'] = $this->load->view('vendor/vendor_details', $v_data, true);
		}
		
		else
		{
			$v_data['came'] = 'vendors/all-vendors';
			$data['content'] = $this->load->view('unable', $v_data, true);
		}
		$name = str_replace("-", " ", $vendor_name);
		$data['title'] = $name;
		
		$this->load->view('templates/general_page', $data);
	}
    
}