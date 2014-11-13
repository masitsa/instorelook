<?php

class Airplane_types_model extends CI_Model 
{	
	/*
	*	Retrieve all active airplane_types
	*
	*/
	public function all_active_airplane_types()
	{
		$this->db->where('airplane_type_status = 1');
		$query = $this->db->get('airplane_type');
		
		return $query;
	}
	
	/*
	*	Retrieve latest airplane_type
	*
	*/
	public function latest_airplane_type()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('airplane_type');
		
		return $query;
	}
	
	/*
	*	Retrieve all airplane_types
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_airplane_types($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('airplane_type_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new airplane_type
	*	@param string $image_name
	*
	*/
	public function add_airplane_type($airplane_type_logo, $airplane_type_thumb)
	{
		$data = array(
				'airplane_type_name'=>$this->input->post('airplane_type_name'),
				'airplane_type_image'=>$airplane_type_logo,
				'airplane_type_thumb'=>$airplane_type_thumb,
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'user_type_id'=>$this->session->userdata('user_type_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		if($this->db->insert('airplane_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing airplane_type
	*	@param string $image_name
	*	@param int $airplane_type_id
	*
	*/
	public function update_airplane_type($airplane_type_logo, $airplane_type_thumb, $airplane_type_id)
	{
		$data = array(
				'airplane_type_name'=>$this->input->post('airplane_type_name'),
				'airplane_type_image'=>$airplane_type_logo,
				'airplane_type_thumb'=>$airplane_type_thumb,
				'user_type_id'=>$this->session->userdata('user_type_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		$this->db->where('airplane_type_id', $airplane_type_id);
		if($this->db->update('airplane_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single airplane_type's details
	*	@param int $airplane_type_id
	*
	*/
	public function get_airplane_type($airplane_type_id)
	{
		//retrieve all users
		$this->db->from('airplane_type');
		$this->db->select('*');
		$this->db->where('airplane_type_id = '.$airplane_type_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing airplane_type
	*	@param int $airplane_type_id
	*
	*/
	public function delete_airplane_type($airplane_type_id)
	{
		if($this->db->delete('airplane_type', array('airplane_type_id' => $airplane_type_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated airplane_type
	*	@param int $airplane_type_id
	*
	*/
	public function activate_airplane_type($airplane_type_id)
	{
		$data = array(
				'airplane_type_status' => 1
			);
		$this->db->where('airplane_type_id', $airplane_type_id);
		
		if($this->db->update('airplane_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated airplane_type
	*	@param int $airplane_type_id
	*
	*/
	public function deactivate_airplane_type($airplane_type_id)
	{
		$data = array(
				'airplane_type_status' => 0
			);
		$this->db->where('airplane_type_id', $airplane_type_id);
		
		if($this->db->update('airplane_type', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get all airplane_type types
	*
	*/
	public function get_airplane_type_types()
	{
		//retrieve all users
		$this->db->from('get_airplane_type_type');
		$this->db->select('*');
		$query = $this->db->get();
		
		return $query;
	}
}
?>