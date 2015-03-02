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
				$this->file_model->delete_file($vendor_path."\\".$this->session->userdata('vendor_logo_file_name'), $vendor_path);
				
				//delete any other uploaded thumbnail
				$this->file_model->delete_file($vendor_path."\\thumbnail_".$this->session->userdata('vendor_logo_file_name'), $vendor_path);
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
	
	public function update_user_details($vendor_id)
	{
		$data = array( 
				'vendor_first_name' => $this->input->post('vendor_first_name'),
				'vendor_last_name' => $this->input->post('vendor_last_name'),
				'vendor_phone' => $this->input->post('vendor_phone')
		);
		
		$this->db->where('vendor_id', $vendor_id);
		$this->db->update('vendor', $data);
		
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
				//'vendor_store_state' => $this->input->post('vendor_store_state'),
				'country_id' => $this->input->post('country_id'),
				'vendor_business_type' => $this->input->post('vendor_business_type'),
				'vendor_store_address' => $this->input->post('vendor_store_address'),
				'surburb_id' => $this->input->post('surburb_id'),
				//'vendor_store_postcode' => $this->input->post('vendor_store_postcode')
		);
		
		$this->session->set_userdata($data);
		
		return TRUE;
	}
	
	public function update_store_details($vendor_id)
	{
		$logo = $this->session->userdata('vendor_logo_file_name');
		if(!empty($logo))
		{
			$vendor_logo = $logo;
			$vendor_thumb = $this->session->userdata('vendor_logo_thumb_name');
		}
		else
		{
			$vendor_logo = $this->input->post('file_name');
			$vendor_thumb = $this->input->post('thumb_name');
		}
		$data = array( 
				'vendor_store_name' => $this->input->post('vendor_store_name'),
				'vendor_store_phone' => $this->input->post('vendor_store_phone'),
				'vendor_store_email' => $this->input->post('vendor_store_email'),
				'vendor_store_summary' => $this->input->post('vendor_store_summary'),
				'vendor_store_mobile' => $this->input->post('vendor_store_mobile'),
				//'vendor_store_state' => $this->input->post('vendor_store_state'),
				'country_id' => $this->input->post('country_id'),
				'vendor_business_type' => $this->input->post('vendor_business_type'),
				'surburb_id' => $this->input->post('surburb_id'),
				'vendor_logo' => $vendor_logo,
				'vendor_thumb' => $vendor_thumb,
				'vendor_store_address' => $this->input->post('vendor_store_address')
		);
		
		$this->db->where('vendor_id', $vendor_id);
		$this->db->update('vendor', $data);
		
		return TRUE;
	}
	
	public function register_vendor($subscription_id)
	{
		$data = array( 
				'vendor_first_name' => $this->session->userdata('vendor_first_name'),
				'vendor_last_name' => $this->session->userdata('vendor_last_name'),
				'vendor_email' => $this->session->userdata('vendor_email'),
				'vendor_phone' => $this->session->userdata('vendor_phone'),
				'vendor_password' => md5($this->session->userdata('vendor_password')),
				'vendor_store_name' => $this->session->userdata('vendor_store_name'),
				'vendor_store_phone' => $this->session->userdata('vendor_store_phone'),
				'vendor_store_email' => $this->session->userdata('vendor_store_email'),
				//'vendor_categories' => $categories,
				'subscription_id' => $subscription_id,
				'vendor_store_summary' => $this->session->userdata('vendor_store_summary'),
				'vendor_logo' => $this->session->userdata('vendor_logo_file_name'),
				'vendor_thumb' => $this->session->userdata('vendor_logo_thumb_name'),
				'vendor_store_mobile' => $this->session->userdata('vendor_store_mobile'),
				'vendor_store_address' => $this->session->userdata('vendor_store_address'),
				//'vendor_store_state' => $this->session->userdata('vendor_store_state'),
				'country_id' => $this->session->userdata('country_id'),
				'vendor_business_type' => $this->session->userdata('vendor_business_type'),
				'surburb_id' => $this->session->userdata('surburb_id'),
				//'vendor_store_postcode' => $this->session->userdata('vendor_store_postcode')
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
			
			//Add categories
			$this->add_subscription_categories($vendor_id);
			
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
	
	public function get_all_surburbs()
	{
		$this->db->select('surburb_id, surburb_name, state_name, post_code');
		$this->db->where('surburb.state = state.state_id');
		$this->db->order_by('surburb_name');
		$query = $this->db->get('surburb, state');
		
		return $query;
	}
	
	public function add_subscription_categories($vendor_id)
	{
		$categories = $this->session->userdata('categories');
		
		$total_categories = count($categories);
		$data['vendor_id'] = $vendor_id;
		
		for($r = 0; $r < $total_categories; $r++)
		{
			$category_id = $categories[$r];
			$data['category_id'] = $category_id;
			$data['created'] = date('Y-m-d H:i:s');
			
			$this->db->insert('vendor_category', $data);
		}
		
		return TRUE;
	}
	
	public function get_vendor_subscription($vendor_id)
	{
		$this->db->where(array('vendor_subscription_status' => 1, 'vendor_id' => $vendor_id));
		$query = $this->db->get('vendor_subscription');
		
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
			'vendor_subscription_created' => date('Y-m-d H:i:s'),
			'payment_amount' => $subscription_amount
		);
		
		if($this->db->insert('vendor_subscription', $data))
		{
			//add the subscription to the vendor table
			$data2['subscription_id'] = $subscription_id;
			$this->db->where('vendor_id', $vendor_id);
			$this->db->update('vendor', $data2);
			
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
		$encrypted_email = $this->encrypt_vendor_email($receiver_email);
		
		$button = '<a class="mcnButton " title="Confirm Account" href="'.site_url().'confirm-account/'.$encrypted_email.'" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Confirm My Account</a>';
		$response = $this->email_model->send_mandrill_mail($receiver_email, "Hi ".$receiver_name, $subject, $message, $sender_email, $shopping, $from, $button, $cc);
		
		//echo var_dump($response);
		
		return $response;
	}
	
	public function verify_email($encrypted_email)
	{
		//decrypt email
		$email = $this->encrypt->decode($encrypted_email);
		
		//activate account
		$data = array
		(
			'vendor_activation_status' => 1
		);
		
		$this->db->where('vendor_email', $email);
		if($this->db->update('vendor', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function encrypt_vendor_email($receiver_email)
	{
		$check = FALSE;//Used to check for forward slashes in string
		
		while($check == FALSE)
		{
			$encrypted_email = $this->encrypt->encode($receiver_email);
			$pos = strpos($encrypted_email, '/');
			if($pos === FALSE)
			{
				$check = TRUE;
			}
		}
		return $encrypted_email;
	}
	
	/*
	*	Validate a vendor's login request
	*
	*/
	public function login_vendor()
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('vendor_email' => $this->input->post('vendor_email'), 'vendor_status' => 1, 'vendor_password' => md5($this->input->post('vendor_password'))));
		$query = $this->db->get('vendor');
		
		//if users exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			
			//get vendor subscription
			
			//create user's login session 
			$newdata = array(
                   'login_status'     			=> TRUE,
                   'first_name'     			=> $result[0]->vendor_first_name,
                   'email'     					=> $result[0]->vendor_email,
                   'vendor_id'  				=> $result[0]->vendor_id,
                   'vendor_activation_status'  	=> $result[0]->vendor_activation_status,
                   'vendor_subscription_status' => $result[0]->vendor_subscription_status,
                   'subscription_id' 			=> $result[0]->subscription_id,
                   'user_type_id' 				=> 2
               );

			$this->session->set_userdata($newdata);
			
			//update user's last login date time
			$this->update_vendor_login($result[0]->vendor_id);
			return TRUE;
		}
		
		//if user doesn't exist
		else
		{
			return FALSE;
		}
	}
	
	public function update_vendor_login($vendor_id)
	{
		$data = array
		(
			'vendor_last_login' => date('Y-m-d H:i:s')
		);
		
		$this->db->where('vendor_id', $vendor_id);
		if($this->db->update('vendor', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function get_subscription_name($type)
	{
		$this->db->where('subscription_id', $type);
		$query = $this->db->get('subscription');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$name = $row->subscription_name;
		}
		else
		{
			$name = 'Unable to find subscription';
		}
		
		return $name;
	}
	
	public function get_subscription_categories($type)
	{
		$this->db->where('subscription_id', $type);
		$query = $this->db->get('subscription');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$categories = $row->subscription_categories;
		}
		else
		{
			$categories = 0;
		}
		
		return $categories;
	}
	
	public function save_categories($fields, $subscription_id)
	{
		//get subscription categories
		$categories = $this->vendor_model->get_subscription_categories($subscription_id);
		
		$total_categories = count($fields);
		
		if($total_categories <= $categories)
		{
			$this->session->set_userdata('categories', $fields);
			return TRUE;
		}
		
		else
		{
			$this->session->set_userdata('subscription_error', 'Invalid category selection. Please select at most '.$categories.' categories');
			return FALSE;
		}
	}
	
	public function update_categories($fields, $vendor_id, $page = NULL, $subscription_id = NULL)
	{
		if($subscription_id == NULL)
		{
			$subscription_id = $this->session->userdata('subscription_id');
		}
		//get subscription categories
		$categories = $this->vendor_model->get_subscription_categories($subscription_id);
		
		$total_categories = count($fields);
		
		if($total_categories <= $categories)
		{
			//deactivate a vendor's previous category selection
			$data['vendor_category_status'] = 0;
			$this->db->where('vendor_id', $vendor_id);
			$this->db->update('vendor_category', $data);
			
			//create new categories
			$this->session->set_userdata('categories', $fields);
			$this->add_subscription_categories($vendor_id);
			return TRUE;
		}
		
		else
		{
			if($page > 0)
			{
				$this->session->set_userdata('subscription_error', 'Invalid category selection. Please select at most '.$categories.' categories');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Invalid category selection. Please select at most '.$categories.' categories');
			}
			return FALSE;
		}
	}
	
	public function get_parent_categories()
	{
		$this->db->where(array('category_parent'=>0, 'category_status'=>1));
		$this->db->order_by('category_name');
		$query = $this->db->get('category');
		
		return $query;
	}
	
	public function get_vendor_categories($vendor_id)
	{
		$this->db->where(array('vendor_id'=>$vendor_id, 'vendor_category_status'=>1));
		$query = $this->db->get('vendor_category');
		
		return $query;
	}
	
	public function get_vendor($vendor_id)
	{
		$this->db->where(array('vendor_id'=>$vendor_id));
		$query = $this->db->get('vendor');
		
		return $query;
	}
	public function get_navigation($page_name)
	{
		$name = $page_name;
		
		$personnal = '';
		$business = '';
		$subscription = '';
		
		if($name == 'personnal')
		{
			$personnal = 'active';
		}
		
		else if($name == 'business')
		{
			$business = 'active';
		}
		
		else if($name == 'subscription')
		{
			$subscription = 'active';
		}
		
		else
		{
			$personnal = 'active';
		}
		
		$navigation = 
		'
			<li class="'.$personnal.' center-align">
				<a href="'.base_url().'vendor/account-profile/personnal">
					<i class="fa fa-user fa-2x"></i>
					<span>Personal</span>
				 </a>
			</li>
			<li class="'.$business.' center-align">
				<a href="'.base_url().'vendor/account-profile/business">
					<i class="fa fa-building-o fa-2x"></i>
					<span>Business</span>
				 </a>
			</li>
			<li class="'.$subscription.' center-align">
				 <a href="'.base_url().'vendor/account-profile/subscription">
					<i class="fa fa-dollar fa-2x"></i>
					<span>Subscription</span>
				 </a>
			</li>
                
		';
		
		return $navigation;
	}
	
	/*
	*	Edit an existing user's password
	*	@param int $user_id
	*
	*/
	public function update_vendor_password($vendor_id)
	{
		if($this->input->post('slug') == md5($this->input->post('vendor_current_password')))
		{
			if($this->input->post('vendor_password') == $this->input->post('confirm_password'))
			{
				$data['vendor_password'] = md5($this->input->post('vendor_password'));
		
				$this->db->where('vendor_id', $vendor_id);
				
				if($this->db->update('vendor', $data))
				{
					$return['result'] = TRUE;
				}
				else{
					$return['result'] = FALSE;
					$return['message'] = 'Oops something went wrong and your password could not be updated. Please try again';
				}
			}
			else{
					$return['result'] = FALSE;
					$return['message'] = 'New Password and Confirm Password don\'t match';
			}
		}
		
		else
		{
			$return['result'] = FALSE;
			$return['message'] = 'You current password is not correct. Please try again';
		}
		
		return $return;
	}
	
	public function deactivate_account($vendor_id)
	{
		//deactivate vendor
		$data = array(
				'vendor_status' => 0
			);
		$this->db->where('vendor_id', $vendor_id);
		
		if($this->db->update('vendor', $data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_subscription($vendor_id)
	{
		$where = array(
				'vendor_id' => $vendor_id
			);
		$this->db->where('vendor_subscription.subscription_id = subscription.subscription_id AND vendor_subscription.vendor_subscription_status = 1 AND vendor_subscription.vendor_id = '.$vendor_id);
		$query = $this->db->get('vendor_subscription, subscription');
		
		return $query;
	}
	
	public function get_vendor_surburb($vendor_id)
	{
		$this->db->select('surburb_id');
		$this->db->where('vendor_id = '.$vendor_id);
		$query = $this->db->get('vendor');
		$surburb_id = 0;
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$surburb_id = $row->surburb_id;
		}
		
		return $surburb_id;
	}
}