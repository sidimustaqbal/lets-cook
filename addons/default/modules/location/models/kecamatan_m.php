<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Kecamatan model
 *
 * @author Aditya Satrya
 */
class Kecamatan_m extends MY_Model {
	
	public function get_kecamatan($pagination_config = NULL, $filter = NULL)
	{
		$this->db->select('default_location_kecamatan.*');
		$this->db->select('default_location_kota.kode kode_kota, default_location_kota.nama nama_kota, default_location_kota.slug slug_kota');
		$this->db->select('default_location_provinsi.id id_provinsi, default_location_provinsi.kode kode_provinsi, default_location_provinsi.nama nama_provinsi,default_location_provinsi.slug slug_provinsi');
		
		if(isset($filter)) {
			foreach ($filter as $key => $f) {
				$this->db->where($key,$f);
			}
		}

		$start = ($this->uri->segment($pagination_config['uri_segment'])) ? $this->uri->segment($pagination_config['uri_segment']) : 0;
		$this->db->limit($pagination_config['per_page'], $start);
		
		$query = $this->db->join('default_location_kota','default_location_kecamatan.id_kota=default_location_kota.id');
		$query = $this->db->join('default_location_provinsi','default_location_kota.id_provinsi=default_location_provinsi.id');
		$query = $this->db->get('default_location_kecamatan');
		$result = $query->result_array();
		
        return $result;
	}
	
	public function get_kecamatan_by_id($id)
	{
		$this->db->select('default_location_kecamatan.*');
		$this->db->select('default_location_kota.kode kode_kota, default_location_kota.nama nama_kota, default_location_kota.slug slug_kota');
		$this->db->select('default_location_provinsi.id id_provinsi, default_location_provinsi.kode kode_provinsi, default_location_provinsi.nama nama_provinsi,default_location_provinsi.slug slug_provinsi');
		$this->db->where('default_location_kecamatan.id', $id);
		$query = $this->db->join('default_location_kota','default_location_kecamatan.id_kota=default_location_kota.id');
		$query = $this->db->join('default_location_provinsi','default_location_kota.id_provinsi=default_location_provinsi.id');
		$query = $this->db->get('default_location_kecamatan');
		$result = $query->row_array();
		
		return $result;
	}

	public function get_kecamatan_by_kota($id_kota)
	{
		$this->db->select('default_location_kecamatan.*');
		$this->db->select('default_location_kota.kode kode_kota, default_location_kota.nama nama_kota, default_location_kota.slug slug_kota');
		$this->db->select('default_location_provinsi.id id_provinsi, default_location_provinsi.kode kode_provinsi, default_location_provinsi.nama nama_provinsi,default_location_provinsi.slug slug_provinsi');
		$this->db->where('default_location_kecamatan.id_kota', $id_kota);
		$query = $this->db->join('default_location_kota','default_location_kecamatan.id_kota=default_location_kota.id');
		$query = $this->db->join('default_location_provinsi','default_location_kota.id_provinsi=default_location_provinsi.id');
		$query = $this->db->get('default_location_kecamatan');
		$result = $query->result_array();
		
		return $result;
	}
	
	public function count_all_kecamatan($filter = NULL)
	{
		if(isset($filter)) {
			foreach ($filter as $key => $f) {
				$this->db->where($key,$f);
			}
		}
		$query = $this->db->join('default_location_kota','default_location_kecamatan.id_kota=default_location_kota.id');
		return $this->db->count_all_results('location_kecamatan');
	}
	
	public function delete_kecamatan_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('default_location_kecamatan');
	}
	
	public function insert_kecamatan($values)
	{
		unset($values['id_provinsi']);
		$values['created_on'] = date("Y-m-d H:i:s");
		$values['created_by'] = $this->current_user->id;
		
		return $this->db->insert('default_location_kecamatan', $values);
	}
	
	public function update_kecamatan($values, $row_id)
	{
		unset($values['id_provinsi']);
		$values['updated_on'] = date("Y-m-d H:i:s");
		
		$this->db->where('id', $row_id);
		return $this->db->update('default_location_kecamatan', $values); 
	}
	
}