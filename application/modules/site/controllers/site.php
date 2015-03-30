<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MX_Controller 
{	
	var $slideshow_location;
	var $static_banner_location;
	var $products_path;
	var $products_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('vendor_model');
		$this->load->model('vendor/products_model');
		$this->load->model('vendor/categories_model');
		$this->load->model('vendor/features_model');
		$this->load->model('vendor/brands_model');
		$this->load->model('vendor/slideshow_model');
		$this->load->model('vendor/static_banners_model');
		$this->load->model('cart_model');
		$this->load->model('admin/users_model');
		//$this->load->model('login/login_model');
		
		$this->load->model('site/site_model');
		$this->slideshow_location = base_url().'assets/slideshow/';
		$this->products_path = realpath(APPPATH . '../assets/images/products/images');
		$this->products_location = base_url().'assets/images/products/images/';
	}
    
	/*
	*
	*	Default action is to go to the home page
	*
	*/
	public function index() 
	{
		redirect('home');
	}
    
	/*
	*
	*	Home Page
	*
	*/
	public function home_page() 
	{
		//get page data
		$v_data['products_path'] = $this->products_path;
		$v_data['products_location'] = $this->products_location;
		$v_data['latest'] = $this->products_model->get_latest_products();
		$v_data['featured'] = $this->products_model->get_featured_products();
		$v_data['brands'] = $this->brands_model->all_active_brands();
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['banners'] = $this->slideshow_model->get_slideshow_images();
		$v_data['static_banners'] = $this->static_banners_model->get_static_banner_images('DESC');
		$v_data['slideshow_location'] = $this->slideshow_location;
		$v_data['static_banner_location'] = $this->static_banner_location;
		$v_data['filter_locations'] = '';
		$v_data['filter_brands'] = '';
		$v_data['filter_businesses'] = '';
		$v_data['filter_price_range'] = '';
		$v_data['category_w_name'] = '__';
		
		$v_data['locations_array'] = '';
		$v_data['brands_array'] = '';
		$v_data['businesses_array'] = '';
		
		$data['content'] = $this->load->view('home/home', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/home_page', $data);
	}
    
	/*
	*
	*	Filter products by brand
	*
	*/
	public function filter_brands()
	{
		if(isset($_POST['brand_name']))
		{
			$total_brands = sizeof($_POST['brand_name']);
			$post_locations = $this->input->post('post_locations');
			$post_businesses = $this->input->post('post_businesses');
			$category_w_name = $this->input->post('category_w_name');
			
			//check if any checkboxes have been ticked
			if($total_brands > 0)
			{
				$brands = '';
				$brand = $_POST['brand_name'];
				
				for($r = 0; $r < $total_brands; $r++)
				{
					$brand_web_name = $brand[$r]; 
					
					if($r == 0)
					{
						$brands .= $brand_web_name;
					}
					
					else
					{
						$brands .= '_'.$brand_web_name;
					}
				}
				$this->products($search = '__', $category_w_name, $order_by = 'created', $price_range = '__', $post_businesses,  $brands, $post_locations);
				//redirect('products/filter-brands/'.$post_businesses.'/'.$brands.'/'.$post_locations);
			}
			
			else
			{
				redirect('products');
			}
		}
		
		else
		{
			redirect('products');
		}
	}
    
	/*
	*
	*	Filter products by brand
	*
	*/
	public function filter_locations()
	{
		if(isset($_POST['state_abbr']))
		{
			$total_states = sizeof($_POST['state_abbr']);
			$post_brands = $this->input->post('post_brands');
			$post_businesses = $this->input->post('post_businesses');
			$category_w_name = $this->input->post('category_w_name');
			
			//check if any checkboxes have been ticked
			if($total_states > 0)
			{
				$states = '';
				$state = $_POST['state_abbr'];
				
				for($r = 0; $r < $total_states; $r++)
				{	
					$state_abbr = $state[$r]; 
					
					if($r == 0)
					{
						$states .= $state_abbr;
					}
					
					else
					{
						$states .= '_'.$state_abbr;
					}
				}
				$this->products($search = '__', $category_w_name, $order_by = 'created', $price_range = '__', $post_businesses,  $post_brands, $states);
				//redirect('products/filter-locations/'.$post_businesses.'/'.$post_brands.'/'.$states);
			}
			
			else
			{
				redirect('products');
			}
		}
		
		else
		{
			redirect('products');
		}
	}
    
	/*
	*
	*	Filter products by brand
	*
	*/
	public function filter_businesses()
	{
		if(isset($_POST['vendor_store_name']))
		{
			$total_businesses = sizeof($_POST['vendor_store_name']);
			$post_brands = $this->input->post('post_brands');
			$post_locations = $this->input->post('post_locations');
			$category_w_name = $this->input->post('category_w_name');
			
			//check if any checkboxes have been ticked
			if($total_businesses > 0)
			{
				$businesses = '';
				$business = $_POST['vendor_store_name'];
				
				for($r = 0; $r < $total_businesses; $r++)
				{	
					$vendor_store_name = $business[$r]; 
					
					if($r == 0)
					{
						$businesses .= $vendor_store_name;
					}
					
					else
					{
						$businesses .= '_'.$vendor_store_name;
					}
				}
				$this->products($search = '__', $category_w_name, $order_by = 'created', $price_range = '__', $businesses,  $post_brands, $post_locations);
				//redirect('products/filter-businesses/'.$businesses.'/'.$post_brands.'/'.$post_locations);
			}
			
			else
			{
				redirect('products');
			}
		}
		
		else
		{
			redirect('products');
		}
	}
    
	/*
	*
	*	Filter products by price
	*
	*/
	public function filter_price()
	{
		if(isset($_POST['low_price']) && isset($_POST['high_price']))
		{
			$price_range = $_POST['low_price'].'-'.$_POST['high_price'];
			$post_locations = $this->input->post('post_locations');
			$post_businesses = $this->input->post('post_businesses');
			$category_w_name = $this->input->post('category_w_name');
			$post_brands = $this->input->post('post_brands');
			
			$this->products($search = '__', $category_w_name, $order_by = 'created', $price_range, $post_businesses,  $post_brands, $post_locations);
		}
		
		else
		{
			redirect('products');
		}
	}
    
	/*
	*
	*	List a vendor's products
	*
	*/
	public function vendor_products($vendor_name) 
	{
		$vendor = explode('&', $vendor_name);
		$name = $vendor[0];
		$vendor_id = $vendor[1];
		
		$this->products($search = '__', $category = '__', $order_by = 'created', $price_range = '__', $filter_businesses = '__',  $filter_brands = '__', $filter_locations = '__', $vendor_id);
	}
    
	/*
	*
	*	Products Page
	*
	*/
	public function products($search = '__', $category = '__', $order_by = 'created', $price_range = '__', $filter_businesses = '__',  $filter_brands = '__', $filter_locations = '__', $created_by = 0) 
	{
		$v_data['products_path'] = $this->products_path;
		$v_data['products_location'] = $this->products_location;
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		$v_data['brands'] = $this->brands_model->all_active_brands();
		//$v_data['product_sub_categories'] = $this->categories_model->get_sub_categories($category_id);
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['filter_locations'] = $filter_locations;
		$v_data['filter_brands'] = $filter_brands;
		$v_data['filter_businesses'] = $filter_businesses;
		$v_data['filter_price_range'] = $price_range;
		$v_data['category_w_name'] = $category;
		
		$v_data['latest'] = $this->products_model->get_latest_products();
		$v_data['featured'] = $this->products_model->get_featured_products();
		$v_data['brands'] = $this->brands_model->all_active_brands();
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['banners'] = $this->slideshow_model->get_slideshow_images();
		$v_data['static_banners'] = $this->static_banners_model->get_static_banner_images('DESC');
		$v_data['slideshow_location'] = $this->slideshow_location;
		$v_data['static_banner_location'] = $this->static_banner_location;
		
		$v_data['locations_array'] = '';
		$v_data['brands_array'] = '';
		$v_data['businesses_array'] = '';
		
		$where = 'product.category_id = category.category_id AND product.brand_id = brand.brand_id AND product.product_status = 1 AND category_status = 1 AND brand_status = 1 AND product.product_balance > 0';
		$table = 'product, category, brand';
		$limit = NULL;
		$order_method  = '';
		//ordering products
		switch ($order_by)
		{
			case 'created':
				$order_by = 'created';
				$order_method = 'DESC';
			break;
			
			case 'price':
				$order_by = 'product_selling_price';
				$order_method = 'ASC';
			break;
			case 'product_rating':
				$order_by = 'product_rating';
				$order_method = 'ASC';
			break;
			
			case 'price_desc':
				$order_by = 'product_selling_price';
				$order_method = 'DESC';
			break;
		}
		
		//case of filter categories
		if($category != '__')
		{
			$return = $this->site_model->create_category_query_filter($category, 'category.category_name');
			// $where .= $return['where'];
		}
		
		//case of filtering locations
		if($filter_locations != '__')
		{
			$table .= ', vendor, surburb, state';
			$where .= ' AND product.created_by = vendor.vendor_id AND vendor.surburb_id = surburb.surburb_id AND surburb.state = state.state_id ';
			$return = $this->site_model->create_query_filter($filter_locations, 'state.state_abbr');
			$where .= $return['where'];
			$v_data['locations_array'] = $return['parameters'];
		}
		
		//case of filter_brands
		if($filter_brands != '__')
		{
			$return = $this->site_model->create_query_filter($filter_brands, 'brand.brand_name');
			$where .= $return['where'];
			$v_data['brands_array'] = $return['parameters'];
		}
		
		//case of filter businesses
		if($filter_businesses != '__')
		{
			if(strpos($table, 'vendor') == FALSE)
			{
				$table .= ', vendor';
				$where .= '  AND product.created_by = vendor.vendor_id ';
			}
			$return = $this->site_model->create_query_filter($filter_businesses, 'vendor.vendor_store_name');
			$where .= $return['where'];
			$v_data['businesses_array'] = $return['parameters'];
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
			//if postcode search
			if($search > 0)
			{
				$table .= ', product_location, surburb';
				$where .= "  AND product.product_id = product_location.product_id AND product_location.surburb_id = surburb.surburb_id AND surburb.post_code = '".$search."'";
			}
			
			else
			{
				$where .= " AND (product.product_name LIKE '%".$search."%' OR category.category_name LIKE '%".$search."%' OR brand.brand_name LIKE '%".$search."%')";
			}
		}
		
		if($created_by > 0)
		{
			$where .= " AND product.created_by = ".$created_by;
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
		
		if($v_data["last"] == 0)
		{
			$v_data["first"] = 0;
		}
		
		$query = $this->products_model->get_all_products($table, $where, $config["per_page"], $page, $limit, $order_by, $order_method);
		if ($query->num_rows() > 0)
		{
			$v_data['products'] = $query;
			$data['content'] = $this->load->view('products/products', $v_data, true);
		}
		
		else
		{
			$v_data['came'] = 'products';
			$data['content'] = $this->load->view('unable', $v_data, true);
		}
		
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
			redirect('products');
		}
	}
    
	/*
	*
	*	Products Page
	*
	*/
	public function view_product($product_code)
	{
		$product_id = $this->site_model->get_product_id($product_code);//echo $product_id; die();
		$v_data['products_path'] = $this->products_path;
		$v_data['products_location'] = $this->products_location;
		$this->products_model->update_clicks($product_id);
		//Required general page data
		$v_data['all_children'] = $this->categories_model->all_child_categories();
		$v_data['parent_categories'] = $this->categories_model->all_parent_categories();
		$v_data['crumbs'] = $this->site_model->get_crumbs();
		
		//get page data
		$v_data['all_features'] = $this->features_model->all_features();
		$v_data['similar_products'] = $this->products_model->get_similar_products($product_id);
		$v_data['product_features'] = $this->products_model->get_product_features($product_id);
		$v_data['feature_names'] = $this->products_model->get_feature_names($product_id);
		$v_data['product_details'] = $this->products_model->get_product($product_id);
		$v_data['product_images'] = $this->products_model->get_gallery_images($product_id);
		$data['content'] = $this->load->view('products/view_product', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	About Privacy
	*
	*/
	public function privacy() 
	{
		//get page data
		$data['content'] = $this->load->view('privacy', '', true);
		
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
    
	/*
	*
	*	About Privacy
	*
	*/
	public function image() 
	{
		//get page data
		$data['content'] = $this->load->view('image', '', true);
		
		$data['title'] = 'Image';//$this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
	
	public function typeahead()
	{
		$data['content'] = $this->load->view('typeahead', '', true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/home_page', $data);
	}
	
	public function capitalize_surburbs()
	{
		$surburbs = $this->site_model->get_surburbs();
		
		if($surburbs->num_rows() > 0)
		{
			$surburbs_result = $surburbs->result();
			
			foreach($surburbs_result as $sel)
			{
				$surburb_name = $sel->surburb_name;
				$state_abbr = $sel->state_abbr;
				$post_code = $sel->post_code;
				$surburb_id = $sel->surburb_id;
				
				$data = array
				(
					"surburb_name" => ucwords(strtolower($surburb_name))
				);
				$this->db->where('surburb_id', $surburb_id);
				$this->db->update('surburb', $data);
			}
		}
	}
	
	public function search_surburbs($search)
	{
		/*$surburbs = $this->site_model->search_surburb($search);
		
		if($surburbs->num_rows() > 0)
		{
			$results = array();
			foreach ($surburbs->result() as $row) {
				$results[] = $row->surburb_name.', '.$row->state_abbr.' '.$row->post_code;
			}
		}
		
		else
		{
			$results[0] = 'No surburb found';
		}
		echo json_encode($results);*/
		header('Content-Type: application/json');
		
		function startsWith($haystack, $needle)
		{
			return !strncmp(strtoupper($haystack), strtoupper($needle), strlen($needle)); 	
		} 	 	
		
		$data[] = "Abrams, J.J."; 	
		$data[] = "Connery, Sean"; 	
		$data[] = "Darwin, Charles"; 	
		$data[] = "Davis, Ben"; 	
		$data[] = "Davis, Patrick"; 	
		$data[] = "Drake"; 	
		$data[] = "Ellington, Duke"; 	 	
		$query = $_GET['q']; 	
		if(ISSET($query)) 	
		{ 		
			foreach ($data as $value) 		
			{ 			
				if(startsWith($value, $query)) 			
				{ 				
					$result[] = $value; 			
				} 		
			} 		
			echo json_encode($result);      	
		} 	
		else 	
		{ 		
			echo json_encode($data); 	
		}
	}
	public function request_newsletter()
	{
		//form validation rules
		$this->form_validation->set_rules('email_address', 'Email', 'is_numeric|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run() == FALSE)
		{
			$this->site_model->request_newsletter();
		}
		
		else
		{
			$this->session->set_userdata("error_message","Could not send newsletter request. Please try again");	
		}
		redirect('home');
	}
	public function customer_requests()
	{
		$v_data['sender_phone_error'] = '';
		$v_data['vendor_password_error'] = '';
		
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('company_name', 'company_name', 'trim|required|xss_clean');
		
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->site_model->make_suggestion())
			{
				//echo 'Your account is now verified. YAY!';
				$this->session->set_userdata('success_message', 'Your request has been received. Thank you');
				redirect('customer-request');

			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to sign into your account. Please try again');
			}
		}
		$validation_errors = validation_errors();
			
		//repopulate form data if validation errors are present
		if(!empty($validation_errors))
		{
			//create errors
			$v_data['company_name_error'] = form_error('company_name');
			$v_data['company_description_error'] = form_error('company_desciption');
			
			//repopulate fields
			$v_data['company_name'] = set_value('company_name');
			$v_data['company_description'] = set_value('company_description');
		}
		
		//populate form data on initial load of page
		else
		{
			$v_data['company_name'] = '';
			$v_data['company_description'] = '';
		}
		
		$data['content'] = $this->load->view('customer/customer_requests', $v_data, true);
		
		$data['title'] = 'Sign In';
		$this->load->view('site/templates/general_page', $data);
	}
	public function rate_product($product_id)
	{
		//form validation rules
		$this->form_validation->set_rules('rate', 'Rating', 'required|xss_clean');
		$this->form_validation->set_rules('review_author_name', 'Customer', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update order
			if($this->site_model->add_product_review($product_id))
			{
				$data['result'] = 'success';
			}
			else
			{
				$data['result'] = 'failure';
			}
		}
		else
		{
			$data['result'] = 'failure';
		}
		
		echo json_encode($data);

	}
    
	/*
	*
	*	Contact admin
	*
	*/
	public function contact_admin()
	{
		$v_data['sender_name_error'] = '';
		$v_data['sender_email_error'] = '';
		$v_data['sender_phone_error'] = '';
		$v_data['message_error'] = '';
		
		//form validation rules
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('sender_name', 'Your Name', 'required|xss_clean');
		$this->form_validation->set_rules('sender_email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('sender_phone', 'phone', 'xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			$response = $this->site_model->contact_admin();
			$this->session->set_userdata('success_message', 'Your message has been sent successfully. We shall get back to you as soon as possible');
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				//create errors
				$v_data['sender_name_error'] = form_error('sender_name');
				$v_data['sender_email_error'] = form_error('sender_email');
				$v_data['sender_phone_error'] = form_error('sender_phone');
				$v_data['message_error'] = form_error('message');
				
				//repopulate fields
				$v_data['sender_name'] = set_value('sender_name');
				$v_data['sender_email'] = set_value('sender_email');
				$v_data['sender_phone'] = set_value('sender_phone');
				$v_data['message'] = set_value('message');
			}
			
			//populate form data on initial load of page
			else
			{
				$v_data['sender_name'] = '';
				$v_data['sender_email'] = '';
				$v_data['sender_phone'] = '';
				$v_data['message'] = '';
			}
		}
		
		$data['content'] = $this->load->view('contact_us', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
	
	public function owl()
	{
		
		$data['content'] = $this->load->view('owl', '', true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
}
?>