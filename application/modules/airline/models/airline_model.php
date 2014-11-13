<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Airline_model extends CI_Model 
{
		public function signup_airline()
		{
			$data = array( 
					'Airline' => $this->input->post('airline_email'),
					
					'Phone' => $this->input->post('airline_phone'),
					
					'Email' => $this->input->post('airline_email'),
					
					'Summary' => $this->input->post('airline_summary')
					
			);
			
			$this->db->insert('airline',$data);
		}
}