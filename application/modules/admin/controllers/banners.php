<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Banners extends admin 
{
	var $slideshow_path;
	var $slideshow_location;
	var $static_banner_path;
	var $static_banner_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('promotion_charges_model');
		$this->load->model('vendor/slideshow_model');
		$this->load->model('vendor/static_banners_model');
		
		//path to revolving banners directory
		$this->slideshow_path = realpath(APPPATH . '../assets/slideshow');
		$this->slideshow_location = base_url().'assets/slideshow/';
		
		//path to static banners directory
		$this->static_banner_path = realpath(APPPATH . '../assets/static_banner');
		$this->static_banner_location = base_url().'assets/static_banner/';
	}
    
	/*
	*
	*	List all revolving banners
	*
	*/
	public function revolving_banners() 
	{
		$where = 'slideshow_id > 0';
		$table = 'slideshow';
		$segment = 4;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/banners/revolving-banners';
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
			$data['content'] = $this->load->view('banners/all_revloving_banners', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'There are no revolving banners';
		}
		$data['title'] = 'All revolving banners';
		
		$this->load->view('templates/general_admin', $data);
	}
	
	/*
	*
	*	Activate an existing revolving banner
	*	@param int $slideshow_id
	*
	*/
	function activate_revolving_banner($slideshow_id, $page)
	{
		if($this->slideshow_model->activate_slideshow($slideshow_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be activated');
		}
		redirect('admin/banners/revolving-banners/'.$page);
	}
	
	/*
	*
	*	Deactivate an existing revolving banner
	*	@param int $slideshow_id
	*
	*/
	function deactivate_revolving_banner($slideshow_id, $page)
	{
		if($this->slideshow_model->deactivate_slideshow($slideshow_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been deactivated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be deactivated');
		}
		redirect('admin/banners/revolving-banners/'.$page);
	}
    
	/*
	*
	*	List all static banners
	*
	*/
	public function static_banners() 
	{
		$where = 'static_banner_id > 0';
		$table = 'static_banner';
		$segment = 4;
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/banners/static-banners';
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
			$data['content'] = $this->load->view('banners/all_static_banners', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'There are no static banners';
		}
		$data['title'] = 'All static banners';
		
		$this->load->view('templates/general_admin', $data);
	}
	
	/*
	*
	*	Activate an existing revolving banner
	*	@param int $static_banner_id
	*
	*/
	function activate_static_banner($static_banner_id, $page)
	{
		if($this->static_banners_model->activate_static_banner($static_banner_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been activated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be activated');
		}
		redirect('admin/banners/static-banners/'.$page);
	}
	
	/*
	*
	*	Deactivate an existing revolving banner
	*	@param int $static_banner_id
	*
	*/
	function deactivate_static_banner($static_banner_id, $page)
	{
		if($this->static_banners_model->deactivate_static_banner($static_banner_id))
		{
			$this->session->set_userdata('success_message', 'Banner has been deactivated');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Banner could not be deactivated');
		}
		redirect('admin/banners/static-banners/'.$page);
	}
}
?>