<?php

class Static_banners_model extends CI_Model 
{	
	public function upload_static_banner_image($static_banner_path, $edit = NULL)
	{
		//upload product's gallery images
		
		if(!empty($_FILES['short_banner_image']['tmp_name']))
		{
			$resize['width'] = 500;
			$resize['height'] = 250;
			$image_name = 'short_banner_image';
		}
		
		else if(!empty($_FILES['long_banner_image']['tmp_name']))
		{
			$resize['width'] = 1000;
			$resize['height'] = 200;
			$image_name = 'long_banner_image';
		}
		
		if((!empty($_FILES['long_banner_image']['tmp_name'])) || (!empty($_FILES['short_banner_image']['tmp_name'])))
		{
			$image = $this->session->userdata('static_banner_file_name');
			
			if((!empty($image)) || ($edit != NULL))
			{
				if($edit != NULL)
				{
					$image = $edit;
				}
				
				//delete any other uploaded image
				if($this->file_model->delete_file($static_banner_path."\\".$image))
				{
					//delete any other uploaded thumbnail
					$this->file_model->delete_file($static_banner_path."\\thumbnail_".$image);
				}
				
				else
				{
					$this->file_model->delete_file($static_banner_path."/".$image);
					$this->file_model->delete_file($static_banner_path."/thumbnail_".$image);
				}
			}
			//Upload image
			$response = $this->file_model->upload_banner($static_banner_path, $image_name, $resize);
			if($response['check'])
			{
				$file_name = $response['file_name'];
				$thumb_name = $response['thumb_name'];
				
				//crop file to 1920 by 1010
				$response_crop = $this->file_model->crop_file($static_banner_path."/".$file_name, $resize['width'], $resize['height']);
				
				if(!$response_crop)
				{
					$this->session->set_userdata('static_banner_error_message', $response_crop);
				
					return FALSE;
				}
				
				else
				{
					//Set sessions for the image details
					$this->session->set_userdata('static_banner_file_name', $file_name);
					$this->session->set_userdata('static_banner_thumb_name', $thumb_name);
				
					return TRUE;
				}
			}
		
			else
			{
				$this->session->set_userdata('static_banner_error_message', $response['error']);
				
				return FALSE;
			}
		}
		
		else
		{
			$this->session->set_userdata('static_banner_error_message', '');
			return FALSE;
		}
	}
	
	public function get_all_static_banners($table, $where, $per_page, $page)
	{
		//retrieve all static_banners
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('static_banner_start, created', 'DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Delete an existing static_banner
	*	@param int $static_banner_id
	*
	*/
	public function delete_static_banner($static_banner_id)
	{
		if($this->db->delete('static_banner', array('static_banner_id' => $static_banner_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated static_banner
	*	@param int $static_banner_id
	*
	*/
	public function activate_static_banner($static_banner_id, $start = NULL, $end = NULL)
	{
		if($end == NULL)
		{
			if($this->db->query("UPDATE `static_banner` SET `static_banner_status` = 1, `static_banner_start` = DATE_ADD('".$start."',INTERVAL 1 DAY), `static_banner_expiry` = DATE_ADD('".$start."',INTERVAL 10 DAY) WHERE `static_banner_id` = ".$static_banner_id))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
		else
		{
			$data = array(
					'static_banner_status' => 1,
					'static_banner_start' => $start,
					'static_banner_expiry' => $end
				);
			$this->db->where('static_banner_id', $static_banner_id);
			
			if($this->db->update('static_banner', $data))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}
	
	/*
	*	Deactivate an activated static_banner
	*	@param int $static_banner_id
	*
	*/
	public function deactivate_static_banner($static_banner_id)
	{
		$data = array(
				'static_banner_status' => 0
			);
		$this->db->where('static_banner_id', $static_banner_id);
		
		if($this->db->update('static_banner', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function count_active_long_banners()
	{
		$table = 'static_banner';
		$where = array
		(
			'static_banner_status' => 1,
			'static_banner_type' => 1
		);
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	public function count_active_short_banners()
	{
		$table = 'static_banner';
		$where = array
		(
			'static_banner_status' => 1,
			'static_banner_type' => 0
		);
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	public function get_max_long_expiry_date()
	{	
		$query = $this->db->query("SELECT MAX(static_banner_expiry) AS start_date, DATE_ADD(MAX(static_banner_expiry),INTERVAL 10 DAY) AS end_date FROM static_banner WHERE static_banner_status = 1 AND static_banner_type = 1");
		return $query;
	}
	
	public function get_max_short_expiry_date()
	{	
		$query = $this->db->query("SELECT MAX(static_banner_expiry) AS start_date, DATE_ADD(MAX(static_banner_expiry),INTERVAL 10 DAY) AS end_date FROM static_banner WHERE static_banner_status = 1 AND static_banner_type = 0");
		return $query;
	}
	
	public function get_static_banner_images($order_method)
	{
		//deactivate aged static_banners
		$this->db->where("static_banner_expiry < '".date('Y-m-d')."'");
		$data['static_banner_status'] = 0;
		$this->db->update('static_banner', $data);
		
		//get active static_banners
		$this->db->where("static_banner_start >= '".date('Y-m-d')."' AND static_banner_status = 1");
		$this->db->order_by('static_banner_start', $order_method);
		$query = $this->db->get('static_banner', 6);
		
		return $query;
	}
	
	public function check_next_available_date()
	{
		/***** for long banners *****/
		$active_long = $this->static_banners_model->count_active_long_banners();
		
		//if active banners are < 10
		if($active_long < 2)
		{
			$start['long_start'] = date('Y-m-d');
		}
		
		//schedule to be activated next
		else
		{
			//get maximum expiry date
			$date_query = $this->static_banners_model->get_max_long_expiry_date();
			if($date_query->num_rows() > 0)
			{
				$row = $date_query->row();
				$start['long_start'] = $row->start_date;
			}
			else
			{
				$start['long_start'] = '-error-';
			}
		}
		/***** for short banners *****/
		$active_short = $this->static_banners_model->count_active_short_banners();
		
		//if active banners are < 10
		if($active_short < 4)
		{
			$start['short_start'] = date('Y-m-d');
		}
		
		//schedule to be activated next
		else
		{
			//get maximum expiry date
			$date_query = $this->static_banners_model->get_max_short_expiry_date();
			if($date_query->num_rows() > 0)
			{
				$row = $date_query->row();
				$start['short_start'] = $row->start_date;
			}
			else
			{
				$start['short_start'] = '-error-';
			}
		}
		
		return $start;
	}
	
	public function get_promotion_days($static_banner_id)
	{
		$query = $this->db->query('SELECT DATEDIFF(static_banner_expiry, static_banner_start) AS promotion_days, static_banner_type FROM static_banner WHERE static_banner_id = '.$static_banner_id);
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$return['days'] = $row->promotion_days+1;
			$return['static_banner_type'] = $row->static_banner_type;
		}
		else
		{
			$return['days'] = 0;
			$return['static_banner_type'] = 0;
		}
		return $return;
	}
	
	public function count_active_banners($static_banner_id, $type)
	{
		$table = 'static_banner';
		$where = 'static_banner_status = 1 AND static_banner_type = '.$type;
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	public function get_static_banner($static_banner_id)
	{
		$table = 'static_banner';
		$where = 'static_banner_id = '.$static_banner_id;
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}
}
