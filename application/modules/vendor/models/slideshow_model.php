<?php

class Slideshow_model extends CI_Model 
{	
	public function upload_slideshow_image($slideshow_path, $edit = NULL)
	{
		//upload product's gallery images
		$resize['width'] = 1600;
		$resize['height'] = 600;
		
		if(!empty($_FILES['slideshow_image']['tmp_name']))
		{
			$image = $this->session->userdata('slideshow_file_name');
			
			if((!empty($image)) || ($edit != NULL))
			{
				if($edit != NULL)
				{
					$image = $edit;
				}
				
				//delete any other uploaded image
				if($this->file_model->delete_file($slideshow_path."\\".$image))
				{
					//delete any other uploaded thumbnail
					$this->file_model->delete_file($slideshow_path."\\thumbnail_".$image);
				}
				
				else
				{
					$this->file_model->delete_file($slideshow_path."/".$image);
					$this->file_model->delete_file($slideshow_path."/thumbnail_".$image);
				}
			}
			//Upload image
			$response = $this->file_model->upload_banner($slideshow_path, 'slideshow_image', $resize);
			if($response['check'])
			{
				$file_name = $response['file_name'];
				$thumb_name = $response['thumb_name'];
				
				//crop file to 1920 by 1010
				$response_crop = $this->file_model->crop_file($slideshow_path."/".$file_name, $resize['width'], $resize['height']);
				
				if(!$response_crop)
				{
					$this->session->set_userdata('slideshow_error_message', $response_crop);
				
					return FALSE;
				}
				
				else
				{
					//Set sessions for the image details
					$this->session->set_userdata('slideshow_file_name', $file_name);
					$this->session->set_userdata('slideshow_thumb_name', $thumb_name);
				
					return TRUE;
				}
			}
		
			else
			{
				$this->session->set_userdata('slideshow_error_message', $response['error']);
				
				return FALSE;
			}
		}
		
		else
		{
			$this->session->set_userdata('slideshow_error_message', '');
			return FALSE;
		}
	}
	
	public function get_all_slides($table, $where, $per_page, $page)
	{
		//retrieve all slideshows
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('slideshow_start, created', 'DESC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Delete an existing slideshow
	*	@param int $slideshow_id
	*
	*/
	public function delete_slideshow($slideshow_id)
	{
		if($this->db->delete('slideshow', array('slideshow_id' => $slideshow_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated slideshow
	*	@param int $slideshow_id
	*
	*/
	public function activate_slideshow($slideshow_id, $start = NULL, $end = NULL)
	{
		//removed condition
		if($end != NULL)
		{
			if($this->db->query("UPDATE `slideshow` SET `slideshow_status` = 1, `slideshow_start` = DATE_ADD('".$start."',INTERVAL 1 DAY), `slideshow_expiry` = DATE_ADD('".$start."',INTERVAL 10 DAY) WHERE `slideshow_id` = ".$slideshow_id))
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
					'slideshow_status' => 1,
					//'slideshow_start' => $start,
					//'slideshow_expiry' => $end
				);
			$this->db->where('slideshow_id', $slideshow_id);
			
			if($this->db->update('slideshow', $data))
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
	*	Deactivate an activated slideshow
	*	@param int $slideshow_id
	*
	*/
	public function deactivate_slideshow($slideshow_id)
	{
		$data = array(
				'slideshow_status' => 0
			);
		$this->db->where('slideshow_id', $slideshow_id);
		
		if($this->db->update('slideshow', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function count_active_banners()
	{
		$table = 'slideshow';
		$where = array
		(
			'slideshow_status' => 1
		);
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	public function get_max_expiry_date()
	{	
		$query = $this->db->query("SELECT MAX(slideshow_expiry) AS start_date, DATE_ADD(MAX(slideshow_expiry),INTERVAL 10 DAY) AS end_date FROM slideshow WHERE slideshow_status = 1");
		return $query;
	}
	
	public function get_slideshow_images()
	{
		//deactivate aged slides
		$this->db->where("slideshow_expiry < '".date('Y-m-d')."'");
		$data['slideshow_status'] = 0;
		$this->db->update('slideshow', $data);
		
		//get active slides
		$this->db->where("slideshow_start >= '".date('Y-m-d')."' AND slideshow_status = 1");
		$this->db->order_by('slideshow_start', 'DESC');
		$query = $this->db->get('slideshow', 10);
		
		return $query;
	}
	
	public function check_next_available_date()
	{
		$active = $this->slideshow_model->count_active_banners();
		
		//if active banners are < 10
		if($active < 10)
		{
			$start = date('Y-m-d');
		}
		
		//schedule to be activated next
		else
		{
			//get maximum expiry date
			$date_query = $this->slideshow_model->get_max_expiry_date();
			if($date_query->num_rows() > 0)
			{
				$row = $date_query->row();
				$start = $row->start_date;
			}
			else
			{
				$start = '-error-';
			}
		}
		return $start;
	}
	
	public function get_promotion_days($slideshow_id)
	{
		$query = $this->db->query('SELECT DATEDIFF(slideshow_expiry, slideshow_start) AS promotion_days FROM slideshow WHERE slideshow_id = '.$slideshow_id);
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$days = $row->promotion_days+1;
		}
		else
		{
			$days = 0;
		}
		return $days;
	}
}
