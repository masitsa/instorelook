<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Flight_types extends admin 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('flight_types_model');
	}
    
	/*
	*
	*	Default action is to show all the registered flight_types
	*
	*/
	public function index() 
	{
		$where = 'flight_type_id > 0';
		$table = 'flight_type';
		$segment = 3;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'administration/all-flight-types';
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
		$query = $this->flight_types_model->get_all_flight_types($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('flight_types/all_flight_types', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'administration/add-flight_type" class="btn btn-success pull-right">Add Flight Type</a>There are no flight_types';
		}
		$data['title'] = 'All Flight Types';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new flight_type
	*
	*/
	public function add_flight_type() 
	{
		//form validation rules
		$this->form_validation->set_rules('flight_type_name', 'Flight Type Name', 'required|xss_clean');
		$this->form_validation->set_rules('flight_type_status', 'Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{	
			if($this->flight_types_model->add_flight_type())
			{
				$this->session->set_userdata('success_message', 'Flight type added successfully');
				redirect('administration/add-flight-type');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add flight type. Please try again');
			}
		}
		
		//open the add new flight_type
		$data['title'] = 'Add New Flight Type';
		$data['content'] = $this->load->view('flight_types/add_flight_type', $v_data, true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing flight_type
	*	@param int $flight_type_id
	*
	*/
	public function edit_flight_type($flight_type_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('flight_type_name', 'Flight Type Name', 'required|xss_clean');
		$this->form_validation->set_rules('flight_type_status', 'Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update flight_type
			if($this->flight_types_model->update_flight_type($flight_type_id))
			{
				$this->session->set_userdata('success_message', 'Flight type edited successfully');
				redirect('administration/edit-flight-type/'.$flight_type_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not edit flight_type. Please try again');
			}
		}
		
		//open the add new flight_type
		$data['title'] = 'Edit Flight Type';
		
		//select the flight_type from the database
		$query = $this->flight_types_model->get_flight_type($flight_type_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['flight_type'] = $query->result();
			
			$data['content'] = $this->load->view('flight_types/edit_flight_type', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Flight type does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing flight_type
	*	@param int $flight_type_id
	*
	*/
	public function delete_flight_type($flight_type_id, $page)
	{
		if($this->flight_types_model->delete_flight_type($flight_type_id))
		{
			$this->session->set_userdata('success_message', 'Flight Type has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Flight Type could not be deleted');
		}
		redirect('administration/all-flight-types/'.$page);
	}
    
	/*
	*
	*	Activate an existing flight_type
	*	@param int $flight_type_id
	*
	*/
	public function activate_flight_type($flight_type_id, $page)
	{
		if($this->flight_types_model->activate_flight_type($flight_type_id))
		{
			$this->session->set_userdata('success_message', 'Flight Type has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Flight Type could not be activated');
		}
		redirect('administration/all-flight-types/'.$page);
	}
    
	/*
	*
	*	Deactivate an existing flight_type
	*	@param int $flight_type_id
	*
	*/
	public function deactivate_flight_type($flight_type_id, $page)
	{
		if($this->flight_types_model->deactivate_flight_type($flight_type_id))
		{
			$this->session->set_userdata('success_message', 'Flight Type has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Flight Type could not be disabled');
		}
		redirect('administration/all-flight-types/'.$page);
	}
}
?>