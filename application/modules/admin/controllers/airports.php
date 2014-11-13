<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Airports extends admin 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('airports_model');
	}
    
	/*
	*
	*	Default action is to show all the registered airports
	*
	*/
	public function index() 
	{
		$where = 'airport_id > 0';
		$table = 'airport';
		$segment = 3;
		//pagination
		$this->load->library('pagination');
		$this->load->model('airlines_model');
		$config['base_url'] = base_url().'administration/all-airports';
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
		$query = $this->airports_model->get_all_airports($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('airports/all_airports', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'administration/add-airport" class="btn btn-success pull-right">Add Airport</a>There are no airports';
		}
		$data['title'] = 'All Airports';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new airport
	*
	*/
	public function add_airport() 
	{
		//form validation rules
		$this->form_validation->set_rules('airport_name', 'Airport Name', 'required|xss_clean');
		$this->form_validation->set_rules('location_name', 'Airport Location', 'required|xss_clean');
		$this->form_validation->set_rules('airport_status', 'Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{	
			if($this->airports_model->add_airport())
			{
				$this->session->set_userdata('success_message', 'Airport added successfully');
				redirect('administration/add-airport');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add airport. Please try again');
			}
		}
		
		//open the add new airport
		$data['title'] = 'Add New Airport';
		$data['content'] = $this->load->view('airports/add_airport', '', true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing airport
	*	@param int $airport_id
	*
	*/
	public function edit_airport($airport_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('airport_name', 'Airport Name', 'required|xss_clean');
		$this->form_validation->set_rules('location_name', 'Airport Location', 'required|xss_clean');
		$this->form_validation->set_rules('airport_status', 'Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update airport
			if($this->airports_model->update_airport($airport_id))
			{
				$this->session->set_userdata('success_message', 'Airport edited successfully');
				redirect('administration/edit-airport/'.$airport_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not edit airport. Please try again');
			}
		}
		
		//open the add new airport
		$data['title'] = 'Edit Airport';
		
		//select the airport from the database
		$query = $this->airports_model->get_airport($airport_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['airport'] = $query->result();
			
			$data['content'] = $this->load->view('airports/edit_airport', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Airport does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing airport
	*	@param int $airport_id
	*
	*/
	public function delete_airport($airport_id, $page)
	{
		if($this->airports_model->delete_airport($airport_id))
		{
			$this->session->set_userdata('success_message', 'Airport has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Airport could not be deleted');
		}
		redirect('administration/all-airports/'.$page);
	}
    
	/*
	*
	*	Activate an existing airport
	*	@param int $airport_id
	*
	*/
	public function activate_airport($airport_id, $page)
	{
		if($this->airports_model->activate_airport($airport_id))
		{
			$this->session->set_userdata('success_message', 'Airport has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Airport could not be activated');
		}
		redirect('administration/all-airports/'.$page);
	}
    
	/*
	*
	*	Deactivate an existing airport
	*	@param int $airport_id
	*
	*/
	public function deactivate_airport($airport_id, $page)
	{
		if($this->airports_model->deactivate_airport($airport_id))
		{
			$this->session->set_userdata('success_message', 'Airport has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Airport could not be disabled');
		}
		redirect('administration/all-airports/'.$page);
	}
}
?>