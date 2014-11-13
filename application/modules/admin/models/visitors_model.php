<?php

class Visitors_model extends CI_Model 
{	
	/*
	*	Retrieve all active visitors
	*
	*/
	public function all_active_visitors()
	{
		$this->db->where('visitor_status = 1');
		$query = $this->db->get('visitor');
		
		return $query;
	}
	
	/*
	*	Retrieve latest visitor
	*
	*/
	public function latest_visitor()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('visitor');
		
		return $query;
	}
	
	/*
	*	Retrieve all visitors
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_visitors($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('visitor.*, visitor_type.visitor_type_name');
		$this->db->where($where);
		$this->db->order_by('visitor_first_name, visitor_last_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new visitor
	*	@param string $image_name
	*
	*/
	public function add_visitor()
	{
		$data = array(
				'visitor_first_name'=>ucwords(strtolower($this->input->post('visitor_first_name'))),
				'visitor_last_name'=>ucwords(strtolower($this->input->post('visitor_last_name'))),
				'visitor_phone'=>$this->input->post('visitor_phone'),
				'visitor_email'=>$this->input->post('visitor_email'),
				'visitor_status'=>$this->input->post('visitor_status'),
				'created'=>date('Y-m-d H:i:s')
			);
		
		$visitor_type_id = $this->input->post('visitor_type_id');
		
		if(!empty($visitor_type_id))
		{
			$data['visitor_type_id'] = $visitor_type_id;
		}
		if($this->db->insert('visitor', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing visitor
	*	@param string $image_name
	*	@param int $visitor_id
	*
	*/
	public function update_visitor($visitor_id)
	{
		$data = array(
				'visitor_first_name'=>ucwords(strtolower($this->input->post('visitor_first_name'))),
				'visitor_last_name'=>ucwords(strtolower($this->input->post('visitor_last_name'))),
				'visitor_phone'=>$this->input->post('visitor_phone'),
				'visitor_email'=>$this->input->post('visitor_email'),
				'visitor_status'=>$this->input->post('visitor_status')
			);
		
		$visitor_type_id = $this->input->post('visitor_type_id');
		
		if(!empty($visitor_type_id))
		{
			$data['visitor_type_id'] = $visitor_type_id;
		}
			
		$this->db->where('visitor_id', $visitor_id);
		if($this->db->update('visitor', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single visitor's details
	*	@param int $visitor_id
	*
	*/
	public function get_visitor($visitor_id)
	{
		//retrieve all users
		$this->db->from('visitor');
		$this->db->select('*');
		$this->db->where('visitor_id = '.$visitor_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing visitor
	*	@param int $visitor_id
	*
	*/
	public function delete_visitor($visitor_id)
	{
		if($this->db->delete('visitor', array('visitor_id' => $visitor_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated visitor
	*	@param int $visitor_id
	*
	*/
	public function activate_visitor($visitor_id)
	{
		$data = array(
				'visitor_status' => 1
			);
		$this->db->where('visitor_id', $visitor_id);
		
		if($this->db->update('visitor', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated visitor
	*	@param int $visitor_id
	*
	*/
	public function deactivate_visitor($visitor_id)
	{
		$data = array(
				'visitor_status' => 0
			);
		$this->db->where('visitor_id', $visitor_id);
		
		if($this->db->update('visitor', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get all visitor types
	*
	*/
	public function get_visitor_types()
	{
		//retrieve all users
		$this->db->from('visitor_type');
		$this->db->select('*');
		$query = $this->db->get();
		
		return $query;
	}
}
?>