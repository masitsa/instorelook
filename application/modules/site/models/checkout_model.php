<?php

class Checkout_model extends CI_Model 
{
	public function get_customer_details($customer_id)
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('customer_id' => $customer_id));
		$query = $this->db->get('customer');
		
		return $query;
	}
	public function get_shipping_details($customer_id)
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('customer_id' => $customer_id));
		$query = $this->db->get('customer_shipping');
		
		return $query;
	}
	
	/*
	*	Update a front end user to the database
	*
	*/
	public function update_customer()
	{
		//check if user has logged in
		$login_status = $this->session->userdata('customer_login_status');
		
		//If customer has logged in
		if((!empty($login_status)) && ($login_status == TRUE))
		{
		}
		
		$data = array(
				'customer_first_name'=>ucwords(strtolower($this->input->post('first_name'))),
				'customer_surname'=>ucwords(strtolower($this->input->post('last_name'))),
				'customer_email'=>$this->input->post('email'),
				'customer_phone'=>$this->input->post('phone'),
				'customer_company'=>$this->input->post('company'),
				'customer_address'=>$this->input->post('address'),
				'surburb_id'=>$this->input->post('surburb_id')
			);
		
		$this->db->where('customer_id = '.$this->session->userdata('customer_id'));
		if($this->db->update('customer', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update a front end user's shipping details
	*
	*/
	public function update_shipping_details()
	{
		//check if user has logged in
		$login_status = $this->session->userdata('customer_login_status');
		
		//If customer has logged in
		if((!empty($login_status)) && ($login_status == TRUE))
		{
		}
		
		$data = array(
				'first_name'=>ucwords(strtolower($this->input->post('first_name'))),
				'last_name'=>ucwords(strtolower($this->input->post('last_name'))),
				'email'=>$this->input->post('email'),
				'phone'=>$this->input->post('phone'),
				'company'=>$this->input->post('company'),
				'surburb_id'=>$this->input->post('surburb_id'),
				'address'=>$this->input->post('address')
			);
		
		//check if customer exists in customer shipping table
		$this->db->where('customer_id = '.$this->session->userdata('customer_id'));
		$query = $this->db->get('customer_shipping');
		
		if($query->num_rows() > 0)
		{
			$this->db->where('customer_id = '.$this->session->userdata('customer_id'));
			if($this->db->update('customer_shipping', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		
		else
		{
			$data['customer_id'] = $this->session->userdata('customer_id');
			if($this->db->insert('customer_shipping', $data))
			{
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
	}
}