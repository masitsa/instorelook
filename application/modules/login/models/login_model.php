<?php

class Login_model extends CI_Model 
{
	/*
	*	Check if user has logged in
	*
	*/
	public function check_login()
	{
		if($this->session->userdata('login_status'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	/*
	*	Check if customer has logged in
	*
	*/
	public function check_customer_login()
	{
		if($this->session->userdata('login_status'))
		{
			$type = $this->session->userdata('user_type_id');
			//var_dump($type); die();
			if($type == 3)
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
			return FALSE;
		}
	}
	/*
	*	Check if vendor has logged in
	*
	*/
	public function check_vendor_login()
	{
		$status = $this->session->userdata('login_status');
		
		if($this->session->userdata('login_status'))
		{
			$type = $this->session->userdata('user_type_id');
			
			if($type == 2)
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
			return FALSE;
		}
	}
	
	/*
	*	Validate a user's login request
	*
	*/
	public function validate_user()
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('email' => $this->input->post('email'), 'activated' => 1, 'password' => md5($this->input->post('password'))));
		$query = $this->db->get('users');
		
		//if users exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			//create user's login session
			$newdata = array(
                   'login_status'     => TRUE,
                   'first_name'     => $result[0]->first_name,
                   'email'     => $result[0]->email,
                   'user_id'  => $result[0]->user_id,
                   'user_type_id'  => 3
               );

			$this->session->set_userdata($newdata);
			
			//update user's last login date time
			$this->update_user_login($result[0]->user_id);
			return TRUE;
		}
		
		//if user doesn't exist
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Validate a customer's login request
	*
	*/
	public function validate_customer()
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('customer_email' => $this->input->post('customer_email'), 'activated' => 1, 'customer_password' => md5($this->input->post('customer_password'))));
		$query = $this->db->get('customer');
		
		//if users exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			//create user's login session
			$newdata = array(
                   'login_status'     => TRUE,
                   'customer_first_name'     => $result[0]->customer_first_name,
                   'email'     => $result[0]->customer_email,
                   'customer_id'     => $result[0]->customer_id,
                   'user_type_id'  => 3
               );
			   
			$this->session->set_userdata($newdata);
			
			//update user's last login date time
			$this->update_customer_login($result[0]->customer_id);
			return TRUE;
		}
		
		//if user doesn't exist
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Update customer's last login date
	*
	*/
	private function update_customer_login($customer_id)
	{
		$data['customer_last_login'] = date('Y-m-d H:i:s');
		$this->db->where('customer_id', $customer_id);
		$this->db->update('customer', $data); 
	}
	
	/*
	*	Update user's last login date
	*
	*/
	private function update_user_login($user_id)
	{
		$data['last_login'] = date('Y-m-d H:i:s');
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data); 
	}
	
	/*
	*	Reset a user's password
	*
	*/
	public function reset_password($user_id)
	{
		$new_password = substr(md5(date('Y-m-d H:i:s')), 0, 6);
		
		$data['password'] = md5($new_password);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data); 
		
		return $new_password;
	}
	
	/*
	*	Validate a customer's login request
	*
	*/
	public function validate_facebook_customer($user_profile)
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('customer_email' => $user_profile['email'], 'activated' => 1, 'customer_facebook' => 1));
		$query = $this->db->get('customer');
		
		//if users exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			//create user's login session
			$newdata = array(
                   'login_status'     => TRUE,
                   'customer_first_name'     => $result[0]->customer_first_name,
                   'email'     => $result[0]->customer_email,
                   'customer_id'     => $result[0]->customer_id,
                   'user_type_id'  => 3
               );
			   
			$this->session->set_userdata($newdata);
			
			//update user's last login date time
			$this->update_customer_login($result[0]->customer_id);
			return TRUE;
		}
		
		//if user doesn't exist
		else
		{
			return FALSE;
		}
	}
	
	public function check_email($email)
	{
		$this->db->where('customer_email', $email);
		$query = $this->db->get('customer');
		
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function register_facebook_customer($user_profile)
	{
		$data = array( 
				'customer_first_name' => $user_profile['first_name'],
				'customer_surname' => $user_profile['last_name'],
				'customer_email' => $user_profile['email'],
				'customer_facebook' => 1,
				'customer_created' => date('Y-m-d H:i:s'),
				'activated' => 1
		);
		
		if($this->db->insert('customer', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function register_customer()
	{
		$data = array( 
				'customer_first_name' => $this->input->post('customer_first_name'),
				'customer_surname' => $this->input->post('customer_surname'),
				'customer_email' => $this->input->post('customer_email'),
				'customer_phone' => $this->input->post('customer_phone'),
				'surburb_id' => $this->input->post('surburb_id'),
				'customer_address' => $this->input->post('customer_address'),
				'customer_password' => md5($this->input->post('customer_password')),
				'customer_created' => date('Y-m-d H:i:s'),
				'customer_last_login' => date('Y-m-d H:i:s'),
				'activated' => 1
		);
		
		if($this->db->insert('customer', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
}