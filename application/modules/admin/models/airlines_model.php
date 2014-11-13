<?php

class Airlines_model extends CI_Model 
{	
	/*
	*	Retrieve all active airlines
	*
	*/
	public function all_active_airlines()
	{
		$this->db->where('airline_status = 1');
		$query = $this->db->get('airline');
		
		return $query;
	}
	
	/*
	*	Retrieve latest airline
	*
	*/
	public function latest_airline()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('airline');
		
		return $query;
	}
	
	/*
	*	Retrieve all airlines
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_airlines($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('airline_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new airline
	*	@param string $image_name
	*
	*/
	public function add_airline($airline_logo, $airline_thumb)
	{
		$data = array(
				'airline_name'=>ucwords(strtolower($this->input->post('airline_name'))),
				'airline_phone'=>$this->input->post('airline_phone'),
				'airline_email'=>$this->input->post('airline_email'),
				'airline_status'=>$this->input->post('airline_status'),
				'created'=>date('Y-m-d H:i:s'),
				'airline_logo'=>$airline_logo,
				'airline_thumb'=>$airline_thumb
			);
			
		if($this->db->insert('airline', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing airline
	*	@param string $image_name
	*	@param int $airline_id
	*
	*/
	public function update_airline($file_name, $thumb_name, $airline_id)
	{
		$data = array(
				'airline_name'=>ucwords(strtolower($this->input->post('airline_name'))),
				'airline_phone'=>$this->input->post('airline_phone'),
				'airline_email'=>$this->input->post('airline_email'),
				'airline_status'=>$this->input->post('airline_status'),
				'airline_logo'=>$file_name,
				'airline_thumb'=>$thumb_name
			);
			
		$this->db->where('airline_id', $airline_id);
		if($this->db->update('airline', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single airline's details
	*	@param int $airline_id
	*
	*/
	public function get_airline($airline_id)
	{
		//retrieve all users
		$this->db->from('airline');
		$this->db->select('*');
		$this->db->where('airline_id = '.$airline_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing airline
	*	@param int $airline_id
	*
	*/
	public function delete_airline($airline_id)
	{
		if($this->db->delete('airline', array('airline_id' => $airline_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated airline
	*	@param int $airline_id
	*
	*/
	public function activate_airline($airline_id)
	{
		$data = array(
				'airline_status' => 1
			);
		$this->db->where('airline_id', $airline_id);
		
		if($this->db->update('airline', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated airline
	*	@param int $airline_id
	*
	*/
	public function deactivate_airline($airline_id)
	{
		$data = array(
				'airline_status' => 0
			);
		$this->db->where('airline_id', $airline_id);
		
		if($this->db->update('airline', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>