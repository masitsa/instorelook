<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Visitors extends admin 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('visitors_model');
	}
    
	/*
	*
	*	Default action is to show all the registered visitors
	*
	*/
	public function index() 
	{
		$where = 'visitor_type.visitor_type_id = visitor.visitor_type_id';
		$table = 'visitor, visitor_type';
		$segment = 3;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'administration/all-visitors';
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
		$query = $this->visitors_model->get_all_visitors($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('visitors/all_visitors', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'administration/add-visitor" class="btn btn-success pull-right">Add Visitor</a>There are no visitors';
		}
		$data['title'] = 'All Visitors';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new visitor
	*
	*/
	public function add_visitor() 
	{
		//form validation rules
		$this->form_validation->set_rules('visitor_first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('visitor_last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('visitor_email', 'Email', 'required|valid_email|is_unique[visitor.visitor_email]|xss_clean');
		$this->form_validation->set_rules('visitor_phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_rules('visitor_status', 'Status', 'required|xss_clean');
		$this->form_validation->set_rules('visitor_type_id', 'Status', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{	
			if($this->visitors_model->add_visitor())
			{
				$this->session->set_userdata('success_message', 'Visitor added successfully');
				redirect('administration/add-visitor');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add visitor. Please try again');
			}
		}
		
		//open the add new visitor
		$data['title'] = 'Add New Visitor';
		$v_data['visitor_types'] = $this->visitors_model->get_visitor_types();
		$data['content'] = $this->load->view('visitors/add_visitor', $v_data, true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing visitor
	*	@param int $visitor_id
	*
	*/
	public function edit_visitor($visitor_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('visitor_first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('visitor_last_name', 'Last Name', 'required|xss_clean');
		$this->form_validation->set_rules('visitor_email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('visitor_phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_rules('visitor_status', 'Status', 'required|xss_clean');
		$this->form_validation->set_rules('visitor_type_id', 'Status', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update visitor
			if($this->visitors_model->update_visitor($visitor_id))
			{
				$this->session->set_userdata('success_message', 'Visitor edited successfully');
				redirect('administration/edit-visitor/'.$visitor_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not edit visitor. Please try again');
			}
		}
		
		//open the add new visitor
		$data['title'] = 'Edit Visitor';
		
		//select the visitor from the database
		$query = $this->visitors_model->get_visitor($visitor_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['visitor'] = $query->result();
			$v_data['visitor_types'] = $this->visitors_model->get_visitor_types();
			
			$data['content'] = $this->load->view('visitors/edit_visitor', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Visitor does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing visitor
	*	@param int $visitor_id
	*
	*/
	public function delete_visitor($visitor_id, $page)
	{
		if($this->visitors_model->delete_visitor($visitor_id))
		{
			$this->session->set_userdata('success_message', 'Visitor has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Visitor could not be deleted');
		}
		redirect('administration/all-visitors/'.$page);
	}
    
	/*
	*
	*	Activate an existing visitor
	*	@param int $visitor_id
	*
	*/
	public function activate_visitor($visitor_id, $page)
	{
		if($this->visitors_model->activate_visitor($visitor_id))
		{
			$this->session->set_userdata('success_message', 'Visitor has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Visitor could not be activated');
		}
		redirect('administration/all-visitors/'.$page);
	}
    
	/*
	*
	*	Deactivate an existing visitor
	*	@param int $visitor_id
	*
	*/
	public function deactivate_visitor($visitor_id, $page)
	{
		if($this->visitors_model->deactivate_visitor($visitor_id))
		{
			$this->session->set_userdata('success_message', 'Visitor has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Visitor could not be disabled');
		}
		redirect('administration/all-visitors/'.$page);
	}
}
?>