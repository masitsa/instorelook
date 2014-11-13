<?php

class Airports_model extends CI_Model 
{	
	/*
	*	Retrieve all active airports
	*
	*/
	public function all_active_airports()
	{
		$this->db->where('airport_status = 1');
		$query = $this->db->get('airport');
		
		return $query;
	}
	
	/*
	*	Retrieve latest airport
	*
	*/
	public function latest_airport()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('airport');
		
		return $query;
	}
	
	/*
	*	Retrieve all airports
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_airports($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('airport_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new airport
	*	@param string $image_name
	*
	*/
	public function add_airport()
	{
		$data = array(
				'airport_name'=>$this->input->post('airport_name'),
				'location_name'=>$this->input->post('location_name'),
				'airport_status'=>$this->input->post('airport_status'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'user_type_id'=>$this->session->userdata('user_type_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		if($this->db->insert('airport', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing airport
	*	@param string $image_name
	*	@param int $airport_id
	*
	*/
	public function update_airport($airport_id)
	{
		$data = array(
				'airport_name'=>$this->input->post('airport_name'),
				'location_name'=>$this->input->post('location_name'),
				'airport_status'=>$this->input->post('airport_status'),
				'user_type_id'=>$this->session->userdata('user_type_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		$this->db->where('airport_id', $airport_id);
		if($this->db->update('airport', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single airport's details
	*	@param int $airport_id
	*
	*/
	public function get_airport($airport_id)
	{
		//retrieve all users
		$this->db->from('airport');
		$this->db->select('*');
		$this->db->where('airport_id = '.$airport_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing airport
	*	@param int $airport_id
	*
	*/
	public function delete_airport($airport_id)
	{
		if($this->db->delete('airport', array('airport_id' => $airport_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated airport
	*	@param int $airport_id
	*
	*/
	public function activate_airport($airport_id)
	{
		$data = array(
				'airport_status' => 1
			);
		$this->db->where('airport_id', $airport_id);
		
		if($this->db->update('airport', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated airport
	*	@param int $airport_id
	*
	*/
	public function deactivate_airport($airport_id)
	{
		$data = array(
				'airport_status' => 0
			);
		$this->db->where('airport_id', $airport_id);
		
		if($this->db->update('airport', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get all airport types
	*
	*/
	public function get_airport_types()
	{
		//retrieve all users
		$this->db->from('get_airport_type');
		$this->db->select('*');
		$query = $this->db->get();
		
		return $query;
	}
}
?>