<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/vendor/controllers/account.php";

class Slideshow extends account 
{
	var $slideshow_path;
	var $slideshow_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('slideshow_model');
		$this->load->model('admin/users_model');
		$this->load->model('admin/file_model');
		$this->load->model('admin/promotion_charges_model');
		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->slideshow_path = realpath(APPPATH . '../assets/slideshow');
		$this->slideshow_location = base_url().'assets/slideshow/';
	}
    
	/*
	*
	*	Default action is to show all the registered slideshow
	*
	*/
	public function index() 
	{
		$where = 'created_by = '.$this->session->userdata('vendor_id');
		$table = 'slideshow';
		$segment = 3;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'vendor/all-banners';
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
		$query = $this->slideshow_model->get_all_slides($table, $where, $config["per_page"], $page);
		
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge(1);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$v_data['promotion_cost'] = number_format($row->promotion_charge_cost, 2);
		}
		else
		{
			$v_data['promotion_cost'] = 0.00;
		}
			
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$v_data['slideshow_location'] = $this->slideshow_location;
			$data['content'] = $this->load->view('slideshow/all_slides', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<p class="center-align">Add promotional banners to appear on the home page slide show. They will cost $'.$v_data['promotion_cost'].' per day.</p><a href="'.site_url().'vendor/add-banner" class="btn btn-success pull-right">Add Banner</a>You have not added any banners';
		}
		$data['title'] = 'Revolving Banners';
		
		$this->load->view('account_template', $data);
	}
	
	function add_slide()
	{
		$v_data['slideshow_location'] = 'http://placehold.it/800x300';
		
		$this->session->unset_userdata('slideshow_error_message');
		
		//upload image if it has been selected
		$response = $this->slideshow_model->upload_slideshow_image($this->slideshow_path);
		if($response)
		{
			$v_data['slideshow_location'] = $this->slideshow_location.$this->session->userdata('slideshow_file_name');
		}
		
		//case of upload error
		else
		{
			$v_data['slideshow_error'] = $this->session->userdata('slideshow_error_message');
		}
		
		$slideshow_error = $this->session->userdata('slideshow_error_message');
		
		$this->form_validation->set_rules('check', 'check', 'trim|xss_clean');
		$this->form_validation->set_rules('slideshow_name', 'Title', 'trim|xss_clean');
		$this->form_validation->set_rules('slideshow_description', 'Description', 'trim|xss_clean');
		$this->form_validation->set_rules('date_from', 'Start Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('date_to', 'End Date', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{	
			if(empty($slideshow_error))
			{
				$data2 = array(
					'slideshow_name'=>$this->input->post("slideshow_name"),
					'slideshow_description'=>$this->input->post("slideshow_description"),
					'slideshow_start'=>date('Y-m-d', strtotime($this->input->post("date_from"))),
					'slideshow_expiry'=>date('Y-m-d', strtotime($this->input->post("date_to"))),
					'slideshow_image_name'=>$this->session->userdata('slideshow_file_name'),
					'created_by'=>$this->session->userdata('vendor_id'),
					'slideshow_status'=>0,
					'created'=>date('Y-m-d H:i:s'),
				);
				
				$table = "slideshow";
				$this->db->insert($table, $data2);
				
				$slideshow_id = $this->db->insert_id();
				$this->session->unset_userdata('slideshow_file_name');
				$this->session->unset_userdata('slideshow_thumb_name');
				$this->session->unset_userdata('slideshow_error_message');
				$this->session->set_userdata('success_message', 'Banner has been added. <a href="'.site_url()."vendor/purchase-banner/".$slideshow_id.'/0">Make payment</a>');
				
				redirect('vendor/all-banners');
			}
		}
		
		$table = "slideshow";
		$where = 'created_by = '.$this->session->userdata('vendor_id');
		
		$this->db->where($where);
		$v_data['slides'] = $this->db->get($table);
		
		$slideshow = $this->session->userdata('slideshow_file_name');
		
		if(!empty($slideshow))
		{
			$v_data['slideshow_location'] = $this->slideshow_location.$this->session->userdata('slideshow_file_name');
		}
		$v_data['error'] = $slideshow_error;
		$v_data['next_available_date'] = $this->slideshow_model->check_next_available_date();
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge(1);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$v_data['promotion_cost'] = number_format($row->promotion_charge_cost, 2);
		}
		else
		{
			$v_data['promotion_cost'] = 0.00;
		}
		
		$data['content'] = $this->load->view("slideshow/add_slide", $v_data, TRUE);
		$data['title'] = 'Add Banner';
		
		$this->load->view('account_template', $data);
	}
	
	function edit_slide($slideshow_id, $page)
	{
		//get slideshow data
		$table = "slideshow";
		$where = "slideshow_id = ".$slideshow_id;
		
		$this->db->where($where);
		$slides_query = $this->db->get($table);
		$slide_row = $slides_query->row();
		$v_data['slide_row'] = $slide_row;
		$v_data['slideshow_location'] = $this->slideshow_location.$slide_row->slideshow_image_name;
		
		$this->session->unset_userdata('slideshow_error_message');
		
		//upload image if it has been selected
		$response = $this->slideshow_model->upload_slideshow_image($this->slideshow_path, $edit = $slide_row->slideshow_image_name);
		if($response)
		{
			$v_data['slideshow_location'] = $this->slideshow_location.$this->session->userdata('slideshow_file_name');
		}
		
		//case of upload error
		else
		{
			$v_data['slideshow_error'] = $this->session->userdata('slideshow_error_message');
		}
		
		$slideshow_error = $this->session->userdata('slideshow_error_message');
		
		$this->form_validation->set_rules('check', 'check', 'trim|xss_clean');
		$this->form_validation->set_rules('slideshow_name', 'Title', 'trim|xss_clean');
		$this->form_validation->set_rules('slideshow_description', 'Description', 'trim|xss_clean');

		if ($this->form_validation->run())
		{	
			if(empty($slideshow_error))
			{
		
				$slideshow = $this->session->userdata('slideshow_file_name');
				
				if($slideshow == FALSE)
				{
					$slideshow = $slide_row->slideshow_image_name;
				}
				$data2 = array(
					'slideshow_name'=>$this->input->post("slideshow_name"),
					'slideshow_description'=>$this->input->post("slideshow_description"),
					'slideshow_image_name'=>$slideshow
				);
				
				$table = "slideshow";
				$this->db->where('slideshow_id', $slideshow_id);
				$this->db->update($table, $data2);
				$this->session->unset_userdata('slideshow_file_name');
				$this->session->unset_userdata('slideshow_thumb_name');
				$this->session->unset_userdata('slideshow_error_message');
				$this->session->set_userdata('success_message', 'Banner has been edited');
				
				redirect('vendor/all-banners/'.$page);
			}
		}
		
		$slideshow = $this->session->userdata('slideshow_file_name');
		
		if(!empty($slideshow))
		{
			$v_data['slideshow_location'] = $this->slideshow_location.$slideshow;
		}
		$v_data['error'] = $slideshow_error;
		$v_data['next_available_date'] = $this->slideshow_model->check_next_available_date();
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge(1);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$v_data['promotion_cost'] = number_format($row->promotion_charge_cost, 2);
		}
		else
		{
			$v_data['promotion_cost'] = 0.00;
		}
		
		$data['content'] = $this->load->view("slideshow/edit_slide", $v_data, TRUE);
		$data['title'] = 'Edit Banner';
		
		$this->load->view('account_template', $data);
	}
    
	/*
	*
	*	Delete an existing slideshow
	*	@param int $slideshow_id
	*
	*/
	function delete_slide($slideshow_id, $page)
	{
		//get slideshow data
		$table = "slideshow";
		$where = "slideshow_id = ".$slideshow_id;
		
		$this->db->where($where);
		$slides_query = $this->db->get($table);
		$slide_row = $slides_query->row();
		$slideshow_path = $this->slideshow_path;
		
		$image_name = $slide_row->slideshow_image_name;
		
		//delete any other uploaded image
		$this->file_model->delete_file($slideshow_path."\\".$image_name, $slideshow_path);
		
		//delete any other uploaded thumbnail
		$this->file_model->delete_file($slideshow_path."\\thumbnail_".$image_name, $slideshow_path);
		
		if($this->slideshow_model->delete_slideshow($slideshow_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be deleted');
		}
		redirect('vendor/all-banners/'.$page);
	}
    
	/*
	*
	*	Activate an existing slideshow
	*	@param int $slideshow_id
	*
	*/
	public function activate_slide($slideshow_id, $page)
	{
		if($this->slideshow_model->activate_slideshow($slideshow_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be activated');
		}
		redirect('vendor/all-banners/'.$page);
	}
    
	/*
	*
	*	Deactivate an existing slideshow
	*	@param int $slideshow_id
	*
	*/
	public function deactivate_slide($slideshow_id, $page)
	{
		if($this->slideshow_model->deactivate_slideshow($slideshow_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be disabled');
		}
		redirect('vendor/all-banners/'.$page);
	}
    
	/*
	*
	*	Purchase a slideshow
	*	@param int $slideshow_id
	*
	*/
	public function purchase_slide($slideshow_id, $page)
	{
		//get slideshow data
		$promotion_days = $this->slideshow_model->get_promotion_days($slideshow_id);
		$promotion_cost_query = $this->promotion_charges_model->get_promotion_charge(1);
		if($promotion_cost_query->num_rows() > 0)
		{
			$row = $promotion_cost_query->row();
			$promotion_cost = $row->promotion_charge_cost;
			$total_cost = number_format(($promotion_cost * $promotion_days), 2);
			
			$return = site_url().'banner/purchase-success/'.$slideshow_id.'/'.$page;
			$cancel = site_url().'banner/purchase-cancel/'.$slideshow_id.'/'.$page;
			//do paypal payment
			$this->load->library('paypal');
			//$this->session->set_userdata('completion_success_message', 'Your order has been completed successfully');
			$this->paypal->doExpressCheckout($total_cost, 'Revolving banner pin up for '.$promotion_days.' days @ $'.number_format($promotion_cost, 2).' per day' ,'', 'AUD', $return, $cancel);
			//redirect('vendor/all-banners/'.$page);
		}
		
		else
		{
			redirect('banner/purchase-cancel/'.$slideshow_id.'/'.$page);
		}
	}
    
	/*
	*
	*	Renew a slideshow
	*	@param int $slideshow_id
	*
	*/
	public function renew_slide($slideshow_id, $page)
	{
		if($this->slideshow_model->deactivate_slideshow($slideshow_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been disabled');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be disabled');
		}
		redirect('vendor/all-banners/'.$page);
	}
    
	/*
	*
	*	A successfull banner purchase
	*	@param int $slideshow_id
	*	@param int $page
	*
	*/
	public function purchase_success($slideshow_id, $page)
	{
		//check number of active banners
		$active = $this->slideshow_model->count_active_banners();
		
		//if active banners are < 10
		if($active < 10)
		{
			if($this->slideshow_model->activate_slideshow($slideshow_id))
			{
				$this->session->set_userdata('success_message', 'Purchase has been made successfully and the banner is active.');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Purchase has been made successfully but the banner has not been activated. Please contact an administrator');
			}
		}
		
		//schedule to be activated next
		else
		{
			$this->session->set_userdata('error_message', 'Purchase has been made successfully but the banner has not been activated. Please contact an administrator.');
			
			//get maximum expiry date
			/*$date_query = $this->slideshow_model->get_max_expiry_date();
			if($date_query->num_rows() > 0)
			{
				$row = $date_query->row();
				$start = $row->start_date;
			
				if($this->slideshow_model->activate_slideshow($slideshow_id, $start))
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
		redirect('vendor/all-banners/'.$page);
	}
    
	/*
	*
	*	A cancelled banner purchase
	*	@param int $slideshow_id
	*	@param int $page
	*
	*/
	public function purchase_cancel($slideshow_id, $page)
	{
		$this->session->set_userdata('error_message', 'Purchase cancelled');
		redirect('vendor/all-banners/'.$page);
	}
	
	public function crop_file()
	{
		$image = '657e85203021ac8e61678845c62e6804.jpg';
		$slideshow_path = $this->slideshow_path;
		//unlink($slideshow_path."/".$image);
		//delete any other uploaded image
		$response_crop = $this->file_model->crop_file($slideshow_path."\\".$file_name, $resize['width'], $resize['height']);
	}
}
?>