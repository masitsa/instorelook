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
				'vendor_categories' => $categories,
				'vendor_store_summary' => $this->input->post('vendor_store_summary'),
				'vendor_store_mobile' => $this->input->post('vendor_store_mobile'),
				'vendor_store_state' => $this->input->post('vendor_store_state'),
				'country_id' => $this->input->post('country_id'),
				'vendor_business_type' => $this->input->post('vendor_business_type'),
				'vendor_store_surburb' => $this->input->post('vendor_store_surburb')
		);
		
		$this->session->set_userdata($data);
		
		return TRUE;
	}
	
	public function register_vendor($subscription_id)
	{
		$data = array( 
				'vendor_first_name' => $this->session->userdata('vendor_first_name'),
				'vendor_last_name' => $this->session->userdata('vendor_last_name'),
				'vendor_email' => $this->session->userdata('vendor_email'),
				'vendor_phone' => $this->session->userdata('vendor_phone'),
				'vendor_password' => $this->session->userdata('vendor_password'),
				'vendor_store_name' => $this->session->userdata('vendor_store_name'),
				'vendor_store_phone' => $this->session->userdata('vendor_store_phone'),
				'vendor_store_email' => $this->session->userdata('vendor_store_email'),
				//'vendor_categories' => $categories,
				'vendor_store_summary' => $this->session->userdata('vendor_store_summary'),
				'vendor_logo' => $this->session->userdata('vendor_logo_file_name'),
				'vendor_thumb' => $this->session->userdata('vendor_logo_thumb_name'),
				'vendor_store_mobile' => $this->session->userdata('vendor_store_mobile'),
				'vendor_store_state' => $this->session->userdata('vendor_store_state'),
				'country_id' => $this->session->userdata('country_id'),
				'vendor_business_type' => $this->session->userdata('vendor_business_type'),
				'vendor_store_surburb' => $this->session->userdata('vendor_store_surburb')
		);
		
		if($this->db->insert('vendor', $data))
		{
			$vendor_id = $this->db->insert_id();
			
			//save vendor categories
			/*$categories = $this->session->userdata('vendor_categories');
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
			}*/
			
			//subscribe vendor
			$vendor_subscription_id = $this->subscribe_vendor($vendor_id, $subscription_id);
			
			return $vendor_id;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function get_all_countries()
	{
		$this->db->order_by('country_name');
		$query = $this->db->get('countries');
		
		return $query;
	}
	
	public function subscribe_vendor($vendor_id, $subscription_id)
	{
		$this->db->where('subscription_id', $subscription_id);
		$query = $this->db->get('subscription');
		$subscription_amount = 0;
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$subscription_amount = $row->subscription_amount;
		}
		//disable all other subscriptions for vendor
		$this->db->where('vendor_id', $vendor_id);
		$this->db->update('vendor_subscription', array('vendor_subscription_status' => 0));
		
		//subscribe vendor
		$data = array( 
			'subscription_id' => $subscription_id,
			'vendor_id' => $vendor_id,
			'payment_amount' => $subscription_amount
		);
		
		if($this->db->insert('vendor_subscription', $data))
		{
			$vendor_subscription_id = $this->db->insert_id();
		}
		
		else
		{
			$vendor_subscription_id = FALSE;
		}
		
		return $vendor_subscription_id;
	}
    
	/*
	*
	*	Vendor Account Verification Email
	*
	*/
	public function send_account_verification_email($receiver_email, $receiver_name, $cc) 
	{
		$this->load->library('Mandrill', 'yPN5McI91NQbs7spbOUpPA');
		$this->load->model('site/email_model');
		
		$subject = "Thanks for registering your shop";
		$message = '
				<p>Thank you for registering at In Store Look.</p> <p>Please activate your account here</p>
				';
		$sender_email = "info@instorelook.com.au";
		$shopping = "";
		$from = "In Store Look";
		$button = NULL;
		$response = $this->email_model->send_mandrill_mail($receiver_email, "Hi ".$receiver_name, $subject, $message, $sender_email, $shopping, $from, $button, $cc);
		
		//echo var_dump($response);
		
		return $response;
	}
}