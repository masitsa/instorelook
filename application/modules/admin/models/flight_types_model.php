<?php

class Flight_types_model extends CI_Model 
{	
	/*
	*	Retrieve all active flight_types
	*
	*/
	public function all_active_flight_types()
	{
		$this->db->where('flight_type_status = 1');
		$query = $this->db->get('flight_type');
		
		return $query;
	}
	
	/*
	*	Retrieve latest flight_type
	*
	*/
	public function latest_flight_type()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('flight_type');
		
		return $query;
	}
	
	/*
	*	Retrieve all flight_types
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_flight_types($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('flight_type_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new flight_type
	*	@param string $image_name
	*
	*/
	public function add_flight_type()
	{
		$data = array(
				'flight_type_name'=>$this->input->post('flight_type_name'),
				'flight_type_status'=>$this->input->post('flight_type_status'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'user_type_id'=>$this->session->userdata('user_type_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		if($this->db->insert('flight_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing flight_type
	*	@param string $image_name
	*	@param int $flight_type_id
	*
	*/
	public function update_flight_type($flight_type_id)
	{
		$data = array(
				'flight_type_name'=>$this->input->post('flight_type_name'),
				'flight_type_status'=>$this->input->post('flight_type_status'),
				'user_type_id'=>$this->session->userdata('user_type_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		$this->db->where('flight_type_id', $flight_type_id);
		if($this->db->update('flight_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single flight_type's details
	*	@param int $flight_type_id
	*
	*/
	public function get_flight_type($flight_type_id)
	{
		//retrieve all users
		$this->db->from('flight_type');
		$this->db->select('*');
		$this->db->where('flight_type_id = '.$flight_type_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing flight_type
	*	@param int $flight_type_id
	*
	*/
	public function delete_flight_type($flight_type_id)
	{
		if($this->db->delete('flight_type', array('flight_type_id' => $flight_type_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated flight_type
	*	@param int $flight_type_id
	*
	*/
	public function activate_flight_type($flight_type_id)
	{
		$data = array(
				'flight_type_status' => 1
			);
		$this->db->where('flight_type_id', $flight_type_id);
		
		if($this->db->update('flight_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated flight_type
	*	@param int $flight_type_id
	*
	*/
	public function deactivate_flight_type($flight_type_id)
	{
		$data = array(
				'flight_type_status' => 0
			);
		$this->db->where('flight_type_id', $flight_type_id);
		
		if($this->db->update('flight_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get all flight_type types
	*
	*/
	public function get_flight_type_types()
	{
		//retrieve all users
		$this->db->from('get_flight_type_type');
		$this->db->select('*');
		$query = $this->db->get();
		
		return $query;
	}
}
?>