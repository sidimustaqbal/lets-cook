<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Kelurahan model
 *
 * @author Aditya Satrya
 */
class Kelurahan_m extends MY_Model {
	
	public function get_kelurahan($pagination_config = NULL, $filter = NULL)
	{
		$this->db->select('default_location_kelurahan.*');
		$this->db->select('default_location_kecamatan.kode kode_kecamatan, default_location_kecamatan.nama nama_kecamatan, default_location_kecamatan.slug slug_kecamatan');
		$this->db->select('default_location_kota.id id_kota, default_location_kota.kode kode_kota, default_location_kota.nama nama_kota, default_location_kota.slug slug_kota');
		$this->db->select('default_location_provinsi.id id_provinsi, default_location_provinsi.kode kode_provinsi, default_location_provinsi.nama nama_provinsi,default_location_provinsi.slug slug_provinsi');
		
		if(isset($filter)) {
			foreach ($filter as $key => $f) {
				$this->db->where($key,$f);
			}
		}

		$start = ($this->uri->segment($pagination_config['uri_segment'])) ? $this->uri->segment($pagination_config['uri_segment']) : 0;
		$this->db->limit($pagination_config['per_page'], $start);
		
		$query = $this->db->join('default_location_kecamatan','default_location_kelurahan.id_kecamatan=default_location_kecamatan.id');
		$query = $this->db->join('default_location_kota','default_location_kecamatan.id_kota=default_location_kota.id');
		$query = $this->db->join('default_location_provinsi','default_location_kota.id_provinsi=default_location_provinsi.id');
		$query = $this->db->get('default_location_kelurahan');
		$result = $query->result_array();
		
        return $result;
	}
	
	public function get_kelurahan_by_id($id)
	{
		$this->db->select('default_location_kelurahan.*');
		$this->db->select('default_location_kecamatan.kode kode_kecamatan, default_location_kecamatan.nama nama_kecamatan, default_location_kecamatan.slug slug_kecamatan');
		$this->db->select('default_location_kota.id id_kota, default_location_kota.kode kode_kota, default_location_kota.nama nama_kota, default_location_kota.slug slug_kota');
		$this->db->select('default_location_provinsi.id id_provinsi, default_location_provinsi.kode kode_provinsi, default_location_provinsi.nama nama_provinsi,default_location_provinsi.slug slug_provinsi');
		$this->db->where('default_location_kelurahan.id', $id);
		
		$query = $this->db->join('default_location_kecamatan','default_location_kelurahan.id_kecamatan=default_location_kecamatan.id');
		$query = $this->db->join('default_location_kota','default_location_kecamatan.id_kota=default_location_kota.id');
		$query = $this->db->join('default_location_provinsi','default_location_kota.id_provinsi=default_location_provinsi.id');
		$query = $this->db->get('default_location_kelurahan');
		$result = $query->row_array();
		
		return $result;
	}

	public function get_kelurahan_by_kecamatan($id)
	{
		$this->db->select('default_location_kelurahan.*');
		$this->db->select('default_location_kecamatan.kode kode_kecamatan, default_location_kecamatan.nama nama_kecamatan, default_location_kecamatan.slug slug_kecamatan');
		$this->db->select('default_location_kota.id id_kota, default_location_kota.kode kode_kota, default_location_kota.nama nama_kota, default_location_kota.slug slug_kota');
		$this->db->select('default_location_provinsi.id id_provinsi, default_location_provinsi.kode kode_provinsi, default_location_provinsi.nama nama_provinsi,default_location_provinsi.slug slug_provinsi');
		$this->db->where('default_location_kelurahan.id_kecamatan', $id);
		
		$query = $this->db->join('default_location_kecamatan','default_location_kelurahan.id_kecamatan=default_location_kecamatan.id');
		$query = $this->db->join('default_location_kota','default_location_kecamatan.id_kota=default_location_kota.id');
		$query = $this->db->join('default_location_provinsi','default_location_kota.id_provinsi=default_location_provinsi.id');
		$query = $this->db->get('default_location_kelurahan');
		$result = $query->result_array();
		
		return $result;
	}
	
	public function count_all_kelurahan($filter = NULL)
	{
		if(isset($filter)) {
			foreach ($filter as $key => $f) {
				$this->db->where($key,$f);
			}
		}

		$query = $this->db->join('default_location_kecamatan','default_location_kelurahan.id_kecamatan=default_location_kecamatan.id');
		$query = $this->db->join('default_location_kota','default_location_kecamatan.id_kota=default_location_kota.id');
		return $this->db->count_all_results('location_kelurahan');
	}
	
	public function delete_kelurahan_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('default_location_kelurahan');
	}
	
	public function insert_kelurahan($values)
	{
		unset($values['id_provinsi']);
		unset($values['id_kota']);
		$values['created_on'] = date("Y-m-d H:i:s");
		$values['created_by'] = $this->current_user->id;
		
		return $this->db->insert('default_location_kelurahan', $values);
	}
	
	public function update_kelurahan($values, $row_id)
	{
		unset($values['id_provinsi']);
		unset($values['id_kota']);
		$values['updated_on'] = date("Y-m-d H:i:s");
		
		$this->db->where('id', $row_id);
		return $this->db->update('default_location_kelurahan', $values); 
	}
	
}