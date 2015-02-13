<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Promotion_charges extends admin 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('promotion_charges_model');
	}
    
	/*
	*
	*	Default action is to show all the promotion_charges
	*
	*/
	public function index() 
	{
		$where = 'promotion_charge_id > 0';
		$table = 'promotion_charge';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/all-promotion-charges';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = 3;
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
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->promotion_charges_model->get_all_promotion_charges($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('promotion_charges/all_promotion_charges', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'admin/add-promotion-charge" class="btn btn-success pull-right">Add Promotion charge</a>There are no promotion charges';
		}
		$data['title'] = 'All promotion charges';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new promotion_charge
	*
	*/
	public function add_promotion_charge() 
	{
		//form validation rules
		$this->form_validation->set_rules('promotion_charge_name', 'Charge Name', 'required|xss_clean');
		$this->form_validation->set_rules('promotion_charge_cost', 'Charge Cost', 'required|xss_clean');
		$this->form_validation->set_rules('promotion_charge_status', 'Promotion charge Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->promotion_charges_model->add_promotion_charge())
			{
				$this->session->set_userdata('success_message', 'Promotion charge added successfully');
				redirect('admin/add-promotion-charge');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add promotion_charge. Please try again');
			}
		}
		
		//open the add new promotion_charge
		$data['title'] = 'Add new charge';
		$data['content'] = $this->load->view('promotion_charges/add_promotion_charge', '', true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing promotion_charge
	*	@param int $promotion_charge_id
	*
	*/
	public function edit_promotion_charge($promotion_charge_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('promotion_charge_name', 'Charge Name', 'required|xss_clean');
		$this->form_validation->set_rules('promotion_charge_cost', 'Charge Cost', 'required|xss_clean');
		$this->form_validation->set_rules('promotion_charge_status', 'Promotion charge Status', 'required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update promotion_charge
			if($this->promotion_charges_model->update_promotion_charge($promotion_charge_id))
			{
				$this->session->set_userdata('success_message', 'Promotion charge updated successfully');
				redirect('admin/all-promotion-charges');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update promotion charge. Please try again');
			}
		}
		
		//open the add new promotion_charge
		$data['title'] = 'Edit promotion charge';
		
		//select the promotion_charge from the database
		$query = $this->promotion_charges_model->get_promotion_charge($promotion_charge_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['promotion_charge'] = $query->result();
			
			$data['content'] = $this->load->view('promotion_charges/edit_promotion_charge', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Promotion charge does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing promotion_charge
	*	@param int $promotion_charge_id
	*
	*/
	public function delete_promotion_charge($promotion_charge_id)
	{
		//delete promotion_charge image
		$query = $this->promotion_charges_model->get_promotion_charge($promotion_charge_id);
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			$image = $result[0]->promotion_charge_image_name;
			
			$this->load->model('file_model');
			//delete image
			$this->file_model->delete_file($this->promotion_charges_path."/images/".$image);
			//delete thumbnail
			$this->file_model->delete_file($this->promotion_charges_path."/thumbs/".$image);
		}
		$this->promotion_charges_model->delete_promotion_charge($promotion_charge_id);
		$this->session->set_userdata('success_message', 'Promotion charge has been deleted');
		redirect('admin/all-promotion-charges');
	}
    
	/*
	*
	*	Activate an existing promotion_charge
	*	@param int $promotion_charge_id
	*
	*/
	public function activate_promotion_charge($promotion_charge_id)
	{
		$this->promotion_charges_model->activate_promotion_charge($promotion_charge_id);
		$this->session->set_userdata('success_message', 'Promotion charge activated successfully');
		redirect('admin/all-promotion-charges');
	}
    
	/*
	*
	*	Deactivate an existing promotion_charge
	*	@param int $promotion_charge_id
	*
	*/
	public function deactivate_promotion_charge($promotion_charge_id)
	{
		$this->promotion_charges_model->deactivate_promotion_charge($promotion_charge_id);
		$this->session->set_userdata('success_message', 'Promotion charge disabled successfully');
		redirect('admin/all-promotion-charges');
	}
}
?>