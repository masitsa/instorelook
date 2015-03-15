<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/vendor/controllers/account.php";

class Static_banners extends account 
{
	var $static_banner_path;
	var $static_banner_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('static_banners_model');
		$this->load->model('admin/users_model');
		$this->load->model('admin/file_model');
		$this->load->model('admin/promotion_charges_model');
		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->static_banner_path = realpath(APPPATH . '../assets/static_banner');
		$this->static_banner_location = base_url().'assets/static_banner/';
	}
    
	/*
	*
	*	Default action is to show all the registered static_banner
	*
	*/
	public function index() 
	{
		$where = 'created_by = '.$this->session->userdata('vendor_id');
		$table = 'static_banner';
		$segment = 3;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'vendor/all-static-banners';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 5;
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
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->static_banners_model->get_all_static_banners($table, $where, $config["per_page"], $page);
		
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge(2);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$v_data['long_cost'] = number_format($row->promotion_charge_cost, 2);
		}
		else
		{
			$v_data['long_cost'] = 0.00;
		}
		
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge(3);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$v_data['short_cost'] = number_format($row->promotion_charge_cost, 2);
		}
		else
		{
			$v_data['short_cost'] = 0.00;
		}
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$v_data['static_banner_location'] = $this->static_banner_location;
			$data['content'] = $this->load->view('static_banners/all_static_banners', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<p class="center-align">Add promotional banners to appear throughout the website. They will cost $5.00 per banner for a period of 10 days.</p><a href="'.site_url().'vendor/add-static-banner" class="btn btn-success pull-right">Add Banner</a><p>You have not added any banners</p>';
		}
		$data['title'] = 'Static Banners';
		
		$this->load->view('account_template', $data);
	}
	
	function add_static_banner()
	{
		$v_data['short_banner_location'] = 'http://placehold.it/500x250';
		$v_data['long_banner_location'] = 'http://placehold.it/1000x200';
		
		$this->session->unset_userdata('static_banner_error_message');
		
		//upload image if it has been selected
		$response = $this->static_banners_model->upload_static_banner_image($this->static_banner_path);
		if($response)
		{
			$v_data['static_banner_location'] = $this->static_banner_location.$this->session->userdata('static_banner_file_name');
		}
		
		//case of upload error
		else
		{
			$v_data['static_banner_error'] = $this->session->userdata('static_banner_error_message');
		}
		
		$static_banner_error = $this->session->userdata('static_banner_error_message');
		
		$this->form_validation->set_rules('check', 'check', 'trim|xss_clean');
		$this->form_validation->set_rules('static_banner_name', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('static_banner_description', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('date_from', 'Start Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('date_to', 'End Date', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{	
			if(empty($static_banner_error))
			{
				$data2 = array(
					'static_banner_type'=>$this->input->post("static_banner_type"),
					'static_banner_name'=>$this->input->post("static_banner_name"),
					'static_banner_description'=>$this->input->post("static_banner_description"),
					'static_banner_image_name'=>$this->session->userdata('static_banner_file_name'),
					'static_banner_start'=>date('Y-m-d', strtotime($this->input->post("date_from"))),
					'static_banner_expiry'=>date('Y-m-d', strtotime($this->input->post("date_to"))),
					'created_by'=>$this->session->userdata('vendor_id'),
					'static_banner_status'=>0,
					'created'=>date('Y-m-d H:i:s'),
				);
				
				$table = "static_banner";
				$this->db->insert($table, $data2);
				
				$static_banner_id = $this->db->insert_id();
				$this->session->unset_userdata('static_banner_file_name');
				$this->session->unset_userdata('static_banner_thumb_name');
				$this->session->unset_userdata('static_banner_error_message');
				$this->session->set_userdata('success_message', 'Banner has been added. <a href="'.site_url()."vendor/purchase-banner/".$static_banner_id.'/0">Make payment</a>');
				
				redirect('vendor/all-static-banners');
			}
		}
		
		$table = "static_banner";
		$where = 'created_by = '.$this->session->userdata('vendor_id');
		
		$this->db->where($where);
		$v_data['static_banners'] = $this->db->get($table);
		
		$static_banner = $this->session->userdata('static_banner_file_name');
		
		if(!empty($static_banner))
		{
			$v_data['static_banner_location'] = $this->static_banner_location.$this->session->userdata('static_banner_file_name');
		}
		$v_data['error'] = $static_banner_error;
		$v_data['next_available_date'] = $this->static_banners_model->check_next_available_date();
		
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge(2);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$v_data['long_cost'] = number_format($row->promotion_charge_cost, 2);
		}
		else
		{
			$v_data['long_cost'] = 0.00;
		}
		
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge(3);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$v_data['short_cost'] = number_format($row->promotion_charge_cost, 2);
		}
		else
		{
			$v_data['short_cost'] = 0.00;
		}
		
		$data['content'] = $this->load->view("static_banners/add_static_banner", $v_data, TRUE);
		$data['title'] = 'Add Banner';
		
		$this->load->view('account_template', $data);
	}
	
	function edit_static_banner($static_banner_id, $page)
	{
		//get static_banner data
		$table = "static_banner";
		$where = "static_banner_id = ".$static_banner_id;
		
		$this->db->where($where);
		$static_banners_query = $this->db->get($table);
		$static_banner_row = $static_banners_query->row();
		$v_data['static_banner_row'] = $static_banner_row;
		$v_data['static_banner_location'] = $this->static_banner_location.$static_banner_row->static_banner_image_name;
		
		$this->session->unset_userdata('static_banner_error_message');
		
		//upload image if it has been selected
		$response = $this->static_banners_model->upload_static_banner_image($this->static_banner_path, $edit = $static_banner_row->static_banner_image_name);
		if($response)
		{
			$v_data['static_banner_location'] = $this->static_banner_location.$this->session->userdata('static_banner_file_name');
		}
		
		//case of upload error
		else
		{
			$v_data['static_banner_error'] = $this->session->userdata('static_banner_error_message');
		}
		
		$static_banner_error = $this->session->userdata('static_banner_error_message');
		
		$this->form_validation->set_rules('check', 'check', 'trim|xss_clean');
		$this->form_validation->set_rules('static_banner_name', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('static_banner_description', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('date_from', 'Start Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('date_to', 'End Date', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{	
			if(empty($static_banner_error))
			{
		
				$static_banner = $this->session->userdata('static_banner_file_name');
				
				if($static_banner == FALSE)
				{
					$static_banner = $static_banner_row->static_banner_image_name;
				}
				$data2 = array(
					'static_banner_name'=>$this->input->post("static_banner_name"),
					'static_banner_description'=>$this->input->post("static_banner_description"),
					'static_banner_start'=>date('Y-m-d', strtotime($this->input->post("date_from"))),
					'static_banner_expiry'=>date('Y-m-d', strtotime($this->input->post("date_to"))),
					'static_banner_image_name'=>$static_banner
				);
				
				$table = "static_banner";
				$this->db->where('static_banner_id', $static_banner_id);
				$this->db->update($table, $data2);
				$this->session->unset_userdata('static_banner_file_name');
				$this->session->unset_userdata('static_banner_thumb_name');
				$this->session->unset_userdata('static_banner_error_message');
				$this->session->set_userdata('success_message', 'Banner has been edited');
				
				redirect('vendor/all-static-banners/'.$page);
			}
		}
		
		$static_banner = $this->session->userdata('static_banner_file_name');
		
		if(!empty($static_banner))
		{
			$v_data['static_banner_location'] = $this->static_banner_location.$static_banner;
		}
		$v_data['error'] = $static_banner_error;
		$v_data['next_available_date'] = $this->static_banners_model->check_next_available_date();
		
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge(2);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$v_data['long_cost'] = number_format($row->promotion_charge_cost, 2);
		}
		else
		{
			$v_data['long_cost'] = 0.00;
		}
		
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge(3);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$v_data['short_cost'] = number_format($row->promotion_charge_cost, 2);
		}
		else
		{
			$v_data['short_cost'] = 0.00;
		}
		
		$data['content'] = $this->load->view("static_banners/edit_static_banner", $v_data, TRUE);
		$data['title'] = 'Edit Banner';
		
		$this->load->view('account_template', $data);
	}
    
	/*
	*
	*	Delete an existing static_banner
	*	@param int $static_banner_id
	*
	*/
	function delete_static_banner($static_banner_id, $page)
	{
		//get static_banner data
		$table = "static_banner";
		$where = "static_banner_id = ".$static_banner_id;
		
		$this->db->where($where);
		$static_banners_query = $this->db->get($table);
		$static_banner_row = $static_banners_query->row();
		$static_banner_path = $this->static_banner_path;
		
		$image_name = $static_banner_row->static_banner_image_name;
		
		//delete any other uploaded image
		$this->file_model->delete_file($static_banner_path."\\".$image_name, $static_banner_path);
		
		//delete any other uploaded thumbnail
		$this->file_model->delete_file($static_banner_path."\\thumbnail_".$image_name, $static_banner_path);
		
		if($this->static_banners_model->delete_static_banner($static_banner_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be deleted');
		}
		redirect('vendor/all-static-banners/'.$page);
	}
    
	/*
	*
	*	Activate an existing static_banner
	*	@param int $static_banner_id
	*
	*/
	public function activate_static_banner($static_banner_id, $page)
	{
		if($this->static_banners_model->activate_static_banner($static_banner_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be activated');
		}
		redirect('vendor/all-static-banners/'.$page);
	}
    
	/*
	*
	*	Deactivate an existing static_banner
	*	@param int $static_banner_id
	*
	*/
	public function deactivate_static_banner($static_banner_id, $page)
	{
		if($this->static_banners_model->deactivate_static_banner($static_banner_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be disabled');
		}
		redirect('vendor/all-static-banners/'.$page);
	}
    
	/*
	*
	*	Purchase a static_banner
	*	@param int $static_banner_id
	*
	*/
	public function purchase_static_banner($static_banner_id, $page)
	{
		//get slideshow data
		$days = $this->static_banners_model->get_promotion_days($static_banner_id);
		$promotion_days = $days['days'];
		$type = $days['static_banner_type'];
		if($type == 0)
		{
			$type = 3;//short banner cost
		}
		else
		{
			$type = 2;//long banner cost
		}
		
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge($type);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$promotion_cost = $row->promotion_charge_cost;
			$total_cost = number_format(($promotion_cost * $promotion_days), 2);
			
			$return = site_url().'static-banner/purchase-success/'.$static_banner_id.'/'.$page;
			$cancel = site_url().'static-banner/purchase-cancel/'.$static_banner_id.'/'.$page;
			//do paypal payment
			$this->load->library('paypal');
			//$this->session->set_userdata('completion_success_message', 'Your order has been completed successfully');
			$this->paypal->doExpressCheckout($total_cost, 'Static banner pin up for '.$promotion_days.' days @ $'.number_format($promotion_cost, 2).' per day' ,'', 'AUD', $return, $cancel);
			//redirect('vendor/all-banners/'.$page);
		}
		
		else
		{
			redirect('banner/purchase-cancel/'.$slideshow_id.'/'.$page);
		}
	}
    
	/*
	*
	*	Renew a static_banner
	*	@param int $static_banner_id
	*
	*/
	public function renew_static_banner($static_banner_id, $page)
	{
		if($this->static_banners_model->deactivate_static_banner($static_banner_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be disabled');
		}
		redirect('vendor/all-static-banners/'.$page);
	}
    
	/*
	*
	*	A successfull banner purchase
	*	@param int $static_banner_id
	*	@param int $page
	*
	*/
	public function purchase_success($static_banner_id, $page)
	{
		//get static banner details
		$query = $this->static_banners_model->get_static_banner($static_banner_id);
		$row = $query->row();
		$static_banner_type = $row->static_banner_type;
		
		//check number of active banners
		$active = $this->static_banners_model->count_active_banners($static_banner_id, $static_banner_type);
		if($static_banner_type == 1)
		{
			$number_active = 2;//only 2 long banners can be active at a time
		}
		else
		{
			$number_active = 4;//only 4 long banners can be active at a time
		}
		
		//if active banners are < $number_active
		if($active < $number_active)
		{
			if($this->static_banners_model->activate_static_banner($static_banner_id))
			{
				$this->session->set_userdata('success_message', 'Purchase has been made successfully and the banner is active.');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Purchase has been made successfully but the banner has not been activated. Please contact an administrator.');
			}
		}
		
		//schedule to be activated next
		else
		{
			$this->session->set_userdata('error_message', 'Purchase has been made successfully but the banner has not been activated. Please contact an administrator.');
			//get maximum expiry date
			/*$date_query = $this->static_banners_model->get_max_expiry_date();
			if($date_query->num_rows() > 0)
			{
				$row = $date_query->row();
				$start = $row->start_date;
			
				if($this->static_banners_model->activate_static_banner($static_banner_id, $start))
				{
					$this->session->set_userdata('success_message', 'Purchase has been made successfully and the banner is active. The promotion will start on '.date('jS M Y', strtotime($start)).' & end in 10 days');
				}
				
				else
				{
					$this->session->set_userdata('error_message', 'Purchase has been made successfully but the banner has not been activated. Please contact an administrator');
				}
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Purchase has been made successfully but the banner has not been activated. Please contact an administrator');
			}*/
		}
		//$this->session->set_userdata('success_message', 'Purchase successfull');
		redirect('vendor/all-static-banners/'.$page);
	}
    
	/*
	*
	*	A cancelled banner purchase
	*	@param int $static_banner_id
	*	@param int $page
	*
	*/
	public function purchase_cancel($static_banner_id, $page)
	{
		$this->session->set_userdata('error_message', 'Purchase cancelled');
		redirect('vendor/all-static-banners/'.$page);
	}
	
	public function crop_file()
	{
		$image = '657e85203021ac8e61678845c62e6804.jpg';
		$static_banner_path = $this->static_banner_path;
		//unlink($static_banner_path."/".$image);
		//delete any other uploaded image
		$response_crop = $this->file_model->crop_file($static_banner_path."\\".$file_name, $resize['width'], $resize['height']);
	}
}
?>