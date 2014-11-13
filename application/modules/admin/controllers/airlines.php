<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Airlines extends admin {
	var $airlines_path;
	var $airlines_logo_path;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('airlines_model');
		$this->load->model('file_model');
		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->airlines_path = realpath(APPPATH . '../assets/images/airlines');
		$this->airlines_logo_path = base_url().'/assets/images/airlines/';
	}
    
	/*
	*
	*	Default action is to show all the registered airlines
	*
	*/
	public function index() 
	{
		$where = 'airline_id > 0';
		$table = 'airline';
		$segment = 3;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'administration/all-airlines';
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
		$query = $this->airlines_model->get_all_airlines($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('airlines/all_airlines', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'administration/add-airline" class="btn btn-success pull-right">Add Airline</a>There are no airlines';
		}
		$data['title'] = 'All Airlines';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new airline
	*
	*/
	public function add_airline() 
	{
		//form validation rules
		$this->form_validation->set_rules('airline_name', 'Airline Name', 'required|is_unique[airline.airline_name]|xss_clean');
		$this->form_validation->set_rules('airline_image', 'Airline Logo', 'xss_clean');
		$this->form_validation->set_rules('airline_email', 'Airline Email', 'required|valid_email|is_unique[airline.airline_email]|xss_clean');
		$this->form_validation->set_rules('airline_phone', 'Airline Phone', 'required|xss_clean');
		$this->form_validation->set_rules('airline_status', 'Airline Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//upload product's gallery images
			$resize['width'] = 600;
			$resize['height'] = 800;
			
			if(is_uploaded_file($_FILES['airline_image']['tmp_name']))
			{
				$airlines_path = $this->airlines_path;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$response = $this->file_model->upload_file($airlines_path, 'airline_image', $resize);
				if($response['check'])
				{
					$file_name = $response['file_name'];
					$thumb_name = $response['thumb_name'];
				}
			
				else
				{
					$this->session->set_userdata('error_message', $response['error']);
					
					$data['title'] = 'Add New Airline';
					$data['content'] = $this->load->view('airlines/add_airline', '', true);
					$this->load->view('templates/general_admin', $data);
					break;
				}
			}
			
			else{
				$file_name = '';
			}
			
			if($this->airlines_model->add_airline($file_name, $thumb_name))
			{
				$this->session->set_userdata('success_message', 'airline added successfully');
				redirect('administration/add-airline');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add airline. Please try again');
			}
		}
		
		//open the add new airline
		$data['title'] = 'Add New Airline';
		$data['content'] = $this->load->view('airlines/add_airline', '', true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing airline
	*	@param int $airline_id
	*
	*/
	public function edit_airline($airline_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('airline_name', 'Airline Name', 'required|xss_clean');
		$this->form_validation->set_rules('airline_image', 'Airline Logo', 'xss_clean');
		$this->form_validation->set_rules('airline_email', 'Airline Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('airline_phone', 'Airline Phone', 'required|xss_clean');
		$this->form_validation->set_rules('airline_status', 'Airline Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//upload product's gallery images
			$resize['width'] = 600;
			$resize['height'] = 800;
			
			if(is_uploaded_file($_FILES['airline_image']['tmp_name']))
			{
				$airlines_path = $this->airlines_path;
				
				//delete original image
				$this->file_model->delete_file($airlines_path."\\".$this->input->post('current_image'));
				
				//delete original thumbnail
				$this->file_model->delete_file($airlines_path."\\thumbnail_".$this->input->post('current_image'));
				/*
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$response = $this->file_model->upload_file($airlines_path, 'airline_image', $resize);
				if($response['check'])
				{
					$file_name = $response['file_name'];
					$thumb_name = $response['thumb_name'];
				}
			
				else
				{
					$this->session->set_userdata('error_message', $response['error']);
					
					$data['title'] = 'Edit Airline';
					$query = $this->airlines_model->get_airline($airline_id);
					if ($query->num_rows() > 0)
					{
						$v_data['airline'] = $query->result();
						$v_data['image_location'] = $this->airlines_logo_path;
						$data['content'] = $this->load->view('airlines/edit_airline', $v_data, true);
					}
					
					else
					{
						$data['content'] = 'Airline does not exist';
					}
					
					$this->load->view('templates/general_admin', $data);
					break;
				}
			}
			
			else{
				$file_name = $this->input->post('current_image');
			}
			//update airline
			if($this->airlines_model->update_airline($file_name, $thumb_name, $airline_id))
			{
				$this->session->set_userdata('success_message', 'Airline edited successfully');
				redirect('administration/edit-airline/'.$airline_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not edit airline. Please try again');
			}
		}
		
		//open the add new airline
		$data['title'] = 'Edit Airline';
		
		//select the airline from the database
		$query = $this->airlines_model->get_airline($airline_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['airline'] = $query->result();
			$v_data['image_location'] = $this->airlines_logo_path;
			
			$data['content'] = $this->load->view('airlines/edit_airline', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Airline does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing airline
	*	@param int $airline_id
	*
	*/
	public function delete_airline($airline_id, $page)
	{
		//delete airline image
		$query = $this->airlines_model->get_airline($airline_id);
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			$image = $result[0]->airline_logo;
			$thumb = $result[0]->airline_thumb;
			
			$this->load->model('file_model');
			//delete image
			$this->file_model->delete_file($this->airlines_path."\\".$image);
				
			//delete original thumbnail
			$this->file_model->delete_file($this->airlines_path."\\".$thumb);
		}
		
		if($this->airlines_model->delete_airline($airline_id))
		{
			$this->session->set_userdata('success_message', 'Airline has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Airline could not be deleted');
		}
		redirect('administration/all-airlines/'.$page);
	}
    
	/*
	*
	*	Activate an existing airline
	*	@param int $airline_id
	*
	*/
	public function activate_airline($airline_id, $page)
	{
		if($this->airlines_model->activate_airline($airline_id))
		{
			$this->session->set_userdata('success_message', 'Airline has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Airline could not be activated');
		}
		redirect('administration/all-airlines/'.$page);
	}
    
	/*
	*
	*	Deactivate an existing airline
	*	@param int $airline_id
	*
	*/
	public function deactivate_airline($airline_id, $page)
	{
		if($this->airlines_model->deactivate_airline($airline_id))
		{
			$this->session->set_userdata('success_message', 'Airline has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Airline could not be disabled');
		}
		redirect('administration/all-airlines/'.$page);
	}
}
?>