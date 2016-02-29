<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Kota model
 *
 * @author Aditya Satrya
 */
class Kota_m extends MY_Model {
	
	public function get_kota($pagination_config = NULL, $filter = NULL)
	{
		$this->db->select('default_location_kota.*');
		$this->db->select('default_location_provinsi.kode kode_provinsi');
		$this->db->select('default_location_provinsi.nama nama_provinsi');
		$this->db->select('default_location_provinsi.slug slug_provinsi');

		if(isset($filter)) {
			foreach ($filter as $key => $f) {
				$this->db->where($key,$f);
			}
		}
		
		$start = ($this->uri->segment($pagination_config['uri_segment'])) ? $this->uri->segment($pagination_config['uri_segment']) : 0;
		$this->db->limit($pagination_config['per_page'], $start);
		
		$query = $this->db->join('default_location_provinsi','default_location_kota.id_provinsi=default_location_provinsi.id');
		$query = $this->db->get('default_location_kota');
		$result = $query->result_array();
		
        return $result;
	}
	
	public function get_kota_by_id($id)
	{
		$this->db->select('default_location_kota.*');
		$this->db->select('default_location_provinsi.kode kode_provinsi');
		$this->db->select('default_location_provinsi.nama nama_provinsi');
		$this->db->select('default_location_provinsi.slug slug_provinsi');
		$this->db->where('default_location_kota.id', $id);
		$query = $this->db->join('default_location_provinsi','default_location_kota.id_provinsi=default_location_provinsi.id');
		$query = $this->db->get('default_location_kota');
		$result = $query->row_array();
		
		return $result;
	}

	public function get_kota_by_provinsi($id_provinsi)
	{
		$this->db->select('default_location_kota.*');
		$this->db->select('default_location_provinsi.kode kode_provinsi');
		$this->db->select('default_location_provinsi.nama nama_provinsi');
		$this->db->select('default_location_provinsi.slug slug_provinsi');
		$this->db->where('default_location_kota.id_provinsi', $id_provinsi);
		$query = $this->db->join('default_location_provinsi','default_location_kota.id_provinsi=default_location_provinsi.id');
		$query = $this->db->get('default_location_kota');
		$result = $query->result_array();
		
		return $result;
	}
	
	public function count_all_kota($filter = NULL)
	{
		if(isset($filter)) {
			foreach ($filter as $key => $f) {
				$this->db->where($key,$f);
			}
		}
		return $this->db->count_all_results('location_kota');
	}
	
	public function delete_kota_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('default_location_kota');
	}
	
	public function insert_kota($values)
	{
		$values['created_on'] = date("Y-m-d H:i:s");
		$values['created_by'] = $this->current_user->id;
		
		return $this->db->insert('default_location_kota', $values);
	}
	
	public function update_kota($values, $row_id)
	{
		$values['updated_on'] = date("Y-m-d H:i:s");
		
		$this->db->where('id', $row_id);
		return $this->db->update('default_location_kota', $values); 
	}
	
}