<?php

class Promotion_charges_model extends CI_Model 
{	
	/*
	*	Retrieve all promotion_charges
	*
	*/
	public function all_promotion_charges()
	{
		$this->db->where('promotion_charge_status = 1');
		$query = $this->db->get('promotion_charge');
		
		return $query;
	}
	/*
	*	Retrieve latest promotion_charge
	*
	*/
	public function latest_promotion_charge()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('promotion_charge');
		
		return $query;
	}
	/*
	*	Retrieve all parent promotion_charges
	*
	*/
	public function all_parent_promotion_charges()
	{
		$this->db->where('promotion_charge_parent = 0');
		$this->db->order_by('promotion_charge_name', 'ASC');
		$query = $this->db->get('promotion_charge');
		
		return $query;
	}
	/*
	*	Retrieve all children promotion_charges
	*
	*/
	public function all_child_promotion_charges()
	{
		$this->db->where('promotion_charge_parent > 0');
		$this->db->order_by('promotion_charge_name', 'ASC');
		$query = $this->db->get('promotion_charge');
		
		return $query;
	}
	
	/*
	*	Retrieve all promotion_charges
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_promotion_charges($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('promotion_charge_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new promotion_charge
	*	@param string $image_name
	*
	*/
	public function add_promotion_charge()
	{
		$data = array(
				'promotion_charge_name'=>ucwords(strtolower($this->input->post('promotion_charge_name'))),
				'promotion_charge_cost'=>$this->input->post('promotion_charge_cost'),
				'promotion_charge_status'=>$this->input->post('promotion_charge_status'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		if($this->db->insert('promotion_charge', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing promotion_charge
	*	@param string $image_name
	*	@param int $promotion_charge_id
	*
	*/
	public function update_promotion_charge($promotion_charge_id)
	{
		$data = array(
				'promotion_charge_name'=>ucwords(strtolower($this->input->post('promotion_charge_name'))),
				'promotion_charge_cost'=>$this->input->post('promotion_charge_cost'),
				'promotion_charge_status'=>$this->input->post('promotion_charge_status'),
				'modified_by'=>$this->session->userdata('user_id')
			);
			
		$this->db->where('promotion_charge_id', $promotion_charge_id);
		if($this->db->update('promotion_charge', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single promotion_charge's children
	*	@param int $promotion_charge_id
	*
	*/
	public function get_sub_promotion_charges($promotion_charge_id)
	{
		//retrieve all users
		$this->db->from('promotion_charge');
		$this->db->select('*');
		$this->db->where('promotion_charge_parent = '.$promotion_charge_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single promotion_charge's details
	*	@param int $promotion_charge_id
	*
	*/
	public function get_promotion_charge($promotion_charge_id)
	{
		//retrieve all users
		$this->db->from('promotion_charge');
		$this->db->select('*');
		$this->db->where('promotion_charge_id = '.$promotion_charge_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing promotion_charge
	*	@param int $promotion_charge_id
	*
	*/
	public function delete_promotion_charge($promotion_charge_id)
	{
		if($this->db->delete('promotion_charge', array('promotion_charge_id' => $promotion_charge_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated promotion_charge
	*	@param int $promotion_charge_id
	*
	*/
	public function activate_promotion_charge($promotion_charge_id)
	{
		$data = array(
				'promotion_charge_status' => 1
			);
		$this->db->where('promotion_charge_id', $promotion_charge_id);
		
		if($this->db->update('promotion_charge', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated promotion_charge
	*	@param int $promotion_charge_id
	*
	*/
	public function deactivate_promotion_charge($promotion_charge_id)
	{
		$data = array(
				'promotion_charge_status' => 0
			);
		$this->db->where('promotion_charge_id', $promotion_charge_id);
		
		if($this->db->update('promotion_charge', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>