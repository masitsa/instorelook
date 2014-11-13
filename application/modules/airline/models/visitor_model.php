<?php

class Visitor_model extends CI_Model 
{
		public function visitor_signup()
		{
			$data = array(
					'First Name'=>$this->input->post('visitor_first_name'),
					
					'Last Name'=>$this->input->post('visitor_last_name'),
					
					'Email'=>$this->input->post('visitor_email'),
					
					'Phone'=>$this->input->post('visitor_phone'),
					
					'Password'=>$this->input->post('visitor_password'),
					
					'Confirm Password'=>$this->input->post('visitor_password')
			);
			
			$this->db->insert('visitor',$data);
		}
}