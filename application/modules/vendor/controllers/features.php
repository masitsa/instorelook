<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/vendor/controllers/account.php";

class Features extends account {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('admin/users_model');
		$this->load->model('features_model');
		$this->load->model('admin/categories_model');
	}
    
	/*
	*
	*	Default action is to show all the features
	*
	*/
	public function index() 
	{
		$where = 'feature.category_id = category.category_id AND feature.created_by IN (0, '.$this->session->userdata('vendor_id').')';
		$table = 'feature, category';
		$feature_search = $this->session->userdata('feature_search');
		
		if(!empty($feature_search))
		{
			$where .= $feature_search;
		}
		$segment = 3;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'vendor/all-features';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
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
        $data["links"] = $this->pagination->create_links();
		$query = $this->features_model->get_all_features($table, $where, $config["per_page"], $page);
		$v_data['all_categories'] = $this->categories_model->all_categories();
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('features/all_features', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'vendor/add-feature" class="btn btn-success pull-right">Add Feature</a>There are no features';
		}
		$data['title'] = 'All features';
		
		$this->load->view('account_template', $data);
	}
    
	/*
	*
	*	Add a new feature
	*
	*/
	public function add_feature() 
	{
		//form validation rules
		$this->form_validation->set_rules('category_id', 'Category Name', 'required|is_natural|xss_clean');
		$this->form_validation->set_rules('feature_name', 'Feature Name', 'required|xss_clean');
		$this->form_validation->set_rules('feature_status', 'Feature Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{	
			if($this->features_model->add_feature())
			{
				$this->session->set_userdata('success_message', 'feature added successfully');
				redirect('vendor/all-features');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add feature. Please try again');
			}
		}
		
		//open the add new feature
		$data['title'] = 'Add New feature';
		$v_data['all_categories'] = $this->categories_model->all_categories();
		$v_data['all_features'] = $this->features_model->all_features();
		$data['content'] = $this->load->view('features/add_feature', $v_data, true);
		$this->load->view('account_template', $data);
	}
    
	/*
	*
	*	Edit an existing feature
	*	@param int $feature_id
	*
	*/
	public function edit_feature($feature_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('category_id', 'Category Name', 'required|is_natural|xss_clean');
		$this->form_validation->set_rules('feature_name', 'feature Name', 'required|xss_clean');
		$this->form_validation->set_rules('feature_status', 'feature Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update feature
			if($this->features_model->update_feature($feature_id))
			{
				$this->session->set_userdata('success_message', 'feature updated successfully');
				redirect('vendor/all-features');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update feature. Please try again');
			}
		}
		
		//open the add new feature
		$data['title'] = 'Edit feature';
		
		//select the feature from the database
		$query = $this->features_model->get_feature($feature_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['feature'] = $query->result();
			$v_data['all_features'] = $this->features_model->all_features();
			$v_data['all_categories'] = $this->categories_model->all_categories();
			
			$data['content'] = $this->load->view('features/edit_feature', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'feature does not exist';
		}
		
		$this->load->view('account_template', $data);
	}
    
	/*
	*
	*	Delete an existing feature
	*	@param int $feature_id
	*
	*/
	public function delete_feature($feature_id)
	{
		$this->features_model->delete_feature($feature_id);
		$this->session->set_userdata('success_message', 'feature has been deleted');
		redirect('vendor/all-features');
	}
    
	/*
	*
	*	Activate an existing feature
	*	@param int $feature_id
	*
	*/
	public function activate_feature($feature_id)
	{
		$this->features_model->activate_feature($feature_id);
		$this->session->set_userdata('success_message', 'feature activated successfully');
		redirect('vendor/all-features');
	}
    
	/*
	*
	*	Deactivate an existing feature
	*	@param int $feature_id
	*
	*/
	public function deactivate_feature($feature_id)
	{
		$this->features_model->deactivate_feature($feature_id);
		$this->session->set_userdata('success_message', 'feature disabled successfully');
		redirect('vendor/all-features');
	}
	/*
	*
	*	Search a feature
	*	@param int $feature name 
	*
	*/
	public function search_features()
	{

		$feature_name = $this->input->post('feature_name');
		$category_id = $this->input->post('category_id');


		if(!empty($feature_name))
		{
			$feature_name = ' AND feature.feature_name LIKE \'%'.mysql_real_escape_string($feature_name).'%\' ';
		}
		if(!empty($category_id))
		{
			$category_id = ' AND feature.category_id = '.$category_id.'';
		}
		else
		{
			$category_id = '';
		}
		
		
		$search = $feature_name.$category_id;
		$this->session->set_userdata('feature_search', $search);
		
		$this->index();
		
	}
	/*
	*
	*	Close feature search
	*	@param int $feature_id
	*
	*/
	public function close_features_search()
	{
		$this->session->unset_userdata('feature_search');
		redirect('vendor/all-features');
	}
}
?>