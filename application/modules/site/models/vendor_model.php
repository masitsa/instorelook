<?php

class Vendor_model extends CI_Model 
{
	/*
	*	Count all items from a table
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function count_items($table, $where, $limit = NULL)
	{
		if($limit != NULL)
		{
			$this->db->limit($limit);
		}
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	/*
	*	Retrieve all users
	*	@param string $table
	* 	@param string $where
	*
	*/

	public function get_all_vendors($table, $where, $per_page, $page, $order_by, $order_method)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order_by, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Retrieve all products of a vendor
	*	@param int $vendor_id
	*
	*/

	public function get_vendor_products($vendor_id)
	{
		$where = 'product.category_id = category.category_id AND product.brand_id = brand.brand_id AND product.product_status = 1 AND category_status = 1 AND brand_status = 1 AND product.product_balance > 0 AND product.created_by = '.$vendor_id;
		$table = 'product, category, brand';
		
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('product.created', 'DESC');
		$query = $this->db->get('', 10);
		
		return $query;
	}
	public function get_vendor_name($vendor_id)
	{
		$this->db->from('vendor');
		$this->db->select('vendor_first_name,vendor_last_name');
		$this->db->where('vendor_id = '.$vendor_id);
		$this->db->order_by('vendor.vendor_id','desc');
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$query = $query->result();
			foreach ($query as $row) {
				# code...
				$vendor_last_name = $row->vendor_last_name;
				$vendor_first_name = $row->vendor_first_name;

				$name = $vendor_first_name."-".$vendor_last_name;
			}
		}
		else
		{
			$name = "";
		}
		return $name;

	}
	public function get_vendor_details($vendor_id,$table,$where)
	{
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('vendor.vendor_id','desc');
		$query = $this->db->get();
		
		return $query;		
	}

	
}