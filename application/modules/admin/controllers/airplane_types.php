<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Airplane_types extends admin 
{
	var $airplane_types_path;
	var $airplane_types_logo_path;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('airplane_types_model');
		$this->load->model('file_model');
		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->airplane_types_path = realpath(APPPATH . '../assets/images/airplane_types');
		$this->airplane_types_logo_path = base_url().'/assets/images/airplane_types/';
	}
    
	/*
	*
	*	Default action is to show all the registered airplane_types
	*
	*/
	public function index() 
	{
		$where = 'airplane_type_id > 0';
		$table = 'airplane_type';
		$segment = 3;
		//pagination
		$this->load->library('pagination');
		$this->load->model('airlines_model');
		$config['base_url'] = base_url().'administration/all-airplane-types';
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
		$query = $this->airplane_types_model->get_all_airplane_types($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$v_data['airplane_types_logo_path'] = $this->airplane_types_logo_path;
			$data['content'] = $this->load->view('airplane_types/all_airplane_types', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'administration/add-airplane-type" class="btn btn-success pull-right">Add Airplane Type</a>There are no airplane_types';
		}
		$data['title'] = 'All Airplane Types';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new airplane_type
	*
	*/
	public function add_airplane_type() 
	{
		//form validation rules
		$this->form_validation->set_rules('airplane_type_name', 'Airplane Type Name', 'required|is_unique[airplane_type.airplane_type_name]|xss_clean');
		$this->form_validation->set_rules('airplane_type_image', 'Airplane Type Image', 'xss_clean');
		$this->form_validation->set_rules('airplane_type_status', 'Airplane Type Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//upload product's gallery images
			$resize['width'] = 600;
			$resize['height'] = 800;
			
			if(is_uploaded_file($_FILES['airplane_type_image']['tmp_name']))
			{
				$airplane_types_path = $this->airplane_types_path;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$response = $this->file_model->upload_file($airplane_types_path, 'airplane_type_image', $resize);
				if($response['check'])
				{
					$file_name = $response['file_name'];
					$thumb_name = $response['thumb_name'];
				}
			
				else
				{
					$this->session->set_userdata('error_message', $response['error']);
					
					$data['title'] = 'Add New Airplane Type';
					$data['content'] = $this->load->view('airplane_types/add_airplane_type', $v_data, true);
					$this->load->view('templates/general_admin', $data);
					break;
				}
			}
			
			else{
				$file_name = '';
			}
			
			if($this->airplane_types_model->add_airplane_type($file_name, $thumb_name))
			{
				$this->session->set_userdata('success_message', 'Airplane type added successfully');
				redirect('administration/add-airplane-type');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add airplane type. Please try again');
			}
		}
		
		//open the add new airplane_type
		$data['title'] = 'Add New Airplane Type';
		$data['content'] = $this->load->view('airplane_types/add_airplane_type', '', true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing airplane_type
	*	@param int $airplane_type_id
	*
	*/
	public function edit_airplane_type($airplane_type_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('airplane_type_name', 'Airplane Type Name', 'required|is_unique[airplane_type.airplane_type_name]|xss_clean');
		$this->form_validation->set_rules('airplane_type_status', 'Airplane Type Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//upload product's gallery images
			$resize['width'] = 600;
			$resize['height'] = 800;
			
			if(is_uploaded_file($_FILES['airplane_type_image']['tmp_name']))
			{
				$airplane_types_path = $this->airplane_types_path;
				
				//delete original image
				$this->file_model->delete_file($airplane_types_path."\\".$this->input->post('current_image'));
				
				//delete original thumbnail
				$this->file_model->delete_file($airplane_types_path."\\thumbnail_".$this->input->post('current_image'));
				
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$response = $this->file_model->upload_file($airplane_types_path, 'airplane_type_image', $resize);
				if($response['check'])
				{
					$file_name = $response['file_name'];
					$thumb_name = $response['thumb_name'];
				}
			
				else
				{
					$this->session->set_userdata('error_message', $response['error']);
					
					$data['title'] = 'Edit Airplane Type';
					$query = $this->airplane_types_model->get_airplane_type($airplane_type_id);
					if ($query->num_rows() > 0)
					{
						$v_data['airplane_type'] = $query->result();
						$v_data['image_location'] = $this->airplane_types_logo_path;
						$data['content'] = $this->load->view('airplane_types/edit_airplane_type', $v_data, true);
					}
					
					else
					{
						$data['content'] = 'Airplane Type does not exist';
					}
					
					$this->load->view('templates/general_admin', $data);
					break;
				}
			}
			
			else{
				$file_name = $this->input->post('current_image');
			}
			//update airplane_type
			if($this->airplane_types_model->update_airplane_type($file_name, $thumb_name, $airplane_type_id))
			{
				$this->session->set_userdata('success_message', 'Airplane Type edited successfully');
				redirect('administration/edit-airplane-type/'.$airplane_type_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not edit airplane_type. Please try again');
			}
		}
		
		//open the add new airplane_type
		$data['title'] = 'Edit Airplane Type';
		
		//select the airplane_type from the database
		$query = $this->airplane_types_model->get_airplane_type($airplane_type_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['airplane_type'] = $query->result();
			$v_data['image_location'] = $this->airplane_types_logo_path;
			
			$data['content'] = $this->load->view('airplane_types/edit_airplane_type', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Airplane Type does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing airplane_type
	*	@param int $airplane_type_id
	*
	*/
	public function delete_airplane_type($airplane_type_id, $page)
	{
		//delete airline image
		$query = $this->airplane_types_model->get_airplane_type($airplane_type_id);
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			$image = $result[0]->airplane_type_image;
			$thumb = $result[0]->airplane_type_thumb;
			
			$this->load->model('file_model');
			//delete image
			$this->file_model->delete_file($this->airplane_types_path."\\".$image);
				
			//delete original thumbnail
			$this->file_model->delete_file($this->airplane_types_path."\\".$thumb);
		}
		
		if($this->airplane_types_model->delete_airplane_type($airplane_type_id))
		{
			$this->session->set_userdata('success_message', 'Airplane Type has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Airplane Type could not be deleted');
		}
		redirect('administration/all-airplane-types/'.$page);
	}
    
	/*
	*
	*	Activate an existing airplane_type
	*	@param int $airplane_type_id
	*
	*/
	public function activate_airplane_type($airplane_type_id, $page)
	{
		if($this->airplane_types_model->activate_airplane_type($airplane_type_id))
		{
			$this->session->set_userdata('success_message', 'Airplane Type has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Airplane Type could not be activated');
		}
		redirect('administration/all-airplane-types/'.$page);
	}
    
	/*
	*
	*	Deactivate an existing airplane_type
	*	@param int $airplane_type_id
	*
	*/
	public function deactivate_airplane_type($airplane_type_id, $page)
	{
		if($this->airplane_types_model->deactivate_airplane_type($airplane_type_id))
		{
			$this->session->set_userdata('success_message', 'Airplane Type has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Airplane Type could not be disabled');
		}
		redirect('administration/all-airplane-types/'.$page);
	}
}
?>