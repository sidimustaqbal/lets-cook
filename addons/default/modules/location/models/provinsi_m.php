<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Provinsi model
 *
 * @author Aditya Satrya
 */
class Provinsi_m extends MY_Model {
	
	public function get_provinsi($pagination_config = NULL)
	{
		$this->db->select('*');
		
		$start = ($this->uri->segment($pagination_config['uri_segment'])) ? $this->uri->segment($pagination_config['uri_segment']) : 0;
		$this->db->limit($pagination_config['per_page'], $start);
		$this->db->order_by('ordering_count');
		
		$query = $this->db->get('default_location_provinsi');
		$result = $query->result_array();
		
        return $result;
	}
	
	public function get_provinsi_by_id($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('default_location_provinsi');
		$result = $query->row_array();
		
		return $result;
	}
	
	public function count_all_provinsi()
	{
		return $this->db->count_all('location_provinsi');
	}
	
	public function delete_provinsi_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('default_location_provinsi');
	}
	
	public function insert_provinsi($values)
	{
		$values['created_on'] = date("Y-m-d H:i:s");
		$values['created_by'] = $this->current_user->id;
		$values['ordering_count'] = $this->count_all_provinsi()+1;
		
		return $this->db->insert('default_location_provinsi', $values);
	}
	
	public function update_provinsi($values, $row_id)
	{
		$values['updated_on'] = date("Y-m-d H:i:s");
		
		$this->db->where('id', $row_id);
		return $this->db->update('default_location_provinsi', $values); 
	}
	
	function move_provinsi($id, $order, $direction) {
		if($direction=='up') {
			$new_order = $order--;
		} elseif ($direction=='down') {
			$new_order = $order++;
		}

		$this->db->where('ordering_count', $order);
		$this->db->update('default_location_provinsi', array('ordering_count'=>$new_order));

		$this->db->where('id', $id);
		$this->db->update('default_location_provinsi', array('ordering_count'=>$order));

		return true;
	}	
}