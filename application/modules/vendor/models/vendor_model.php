<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor_model extends CI_Model 
{
	public function upload_vendor_image($vendor_path)
	{
		//upload product's gallery images
		$resize['width'] = 300;
		$resize['height'] = 300;
		
		if(isset($_FILES['vendor_logo']['tmp_name']))
		{
			if(is_uploaded_file($_FILES['vendor_logo']['tmp_name']))
			{
				//delete any other uploaded image
				$this->file_model->delete_file($vendor_path."\\".$this->session->userdata('vendor_logo_file_name'));
				
				//delete any other uploaded thumbnail
				$this->file_model->delete_file($vendor_path."\\thumbnail_".$this->session->userdata('vendor_logo_file_name'));
				//Upload image
				$response = $this->file_model->upload_file($vendor_path, 'vendor_logo', $resize);
				if($response['check'])
				{
					$file_name = $response['file_name'];
					$thumb_name = $response['thumb_name'];
					
					//Set sessions for the image details
					$this->session->set_userdata('vendor_logo_file_name', $file_name);
					$this->session->set_userdata('vendor_logo_thumb_name', $thumb_name);
					
					return TRUE;
				}
			
				else
				{
					$this->session->set_userdata('vendor_logo_error_message', $response['error']);
					
					return FALSE;
				}
			}
			
			else{
				$this->session->set_userdata('vendor_logo_error_message', '');
				return FALSE;
			}
		}
		
		else
		{
			$this->session->set_userdata('vendor_logo_error_message', '');
			return FALSE;
		}
	}
	
	public function register_user_details()
	{
		$data = array( 
				'vendor_first_name' => $this->input->post('vendor_first_name'),
				'vendor_last_name' => $this->input->post('vendor_last_name'),
				'vendor_email' => $this->input->post('vendor_email'),
				'vendor_phone' => $this->input->post('vendor_phone'),
				'vendor_password' => $this->input->post('vendor_password')
		);
		
		$this->session->set_userdata($data);
		
		return TRUE;
	}
	
	public function register_store_details()
	{
		//categories
		if(isset($_POST['categories']))
		{
			$categories = $_POST['categories'];
		}
		
		else
		{
			$categories = NULL;
		}
		
		$data = array( 
				'vendor_store_name' => $this->input->post('vendor_store_name'),
				'vendor_store_phone' => $this->input->post('vendor_store_phone'),
				'vendor_store_email' => $this->input->post('vendor_store_email'),
				'vendor_user_phone' => $this->input->post('vendor_user_phone'),
				'vendor_categories' => $categories,
				'vendor_store_summary' => $this->input->post('vendor_store_summary')
		);
		
		$this->session->set_userdata($data);
		
		return TRUE;
	}
	
	public function register_vendor()
	{
		$data = array( 
				'vendor_first_name' => $this->input->post('vendor_first_name'),
				'vendor_last_name' => $this->input->post('vendor_last_name'),
				'vendor_email' => $this->input->post('vendor_email'),
				'vendor_phone' => $this->input->post('vendor_phone'),
				'vendor_password' => $this->input->post('vendor_password'),
				'vendor_store_name' => $this->input->post('vendor_store_name'),
				'vendor_store_phone' => $this->input->post('vendor_store_phone'),
				'vendor_store_email' => $this->input->post('vendor_store_email'),
				'vendor_user_phone' => $this->input->post('vendor_user_phone'),
				'vendor_categories' => $categories,
				'vendor_store_summary' => $this->input->post('vendor_store_summary'),
				'vendor_logo' => $this->session->userdata('vendor_logo_file_name'),
				'vendor_thumb' => $this->session->userdata('vendor_logo_thumb_name')
		);
		
		if($this->db->insert('vendor', $data))
		{
			$vendor_id = $this->db->insert_id();
			
			//save vendor categories
			$categories = $this->session->userdata('vendor_categories');
			if ($categories)
			{
				$data2['vendor_id'] = $vendor_id;
				foreach ($categories as $t)
				{
					$data2['category_id'] = $t;
					if($this->db->insert('vendor_category', $data2))
					{
					}
				}
			}
			
			return $vendor_id;
		}
		
		else
		{
			return FALSE;
		}
	}
}