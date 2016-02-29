<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Data model
 *
 * @author Riky Lesmana
 */
class Data_m extends MY_Model {

	public function get_data($pagination_config = NULL)
	{
		$this->db->select('*');

		$start = ($this->uri->segment($pagination_config['uri_segment'])) ? $this->uri->segment($pagination_config['uri_segment']) : 0;
		$this->db->limit($pagination_config['per_page'], $start);

		if($this->input->get('f-nama')){
			$this->db->like('nama', $this->input->get('f-nama'));
		}
		if($this->input->get('f-status')){
			$this->db->where('status', $this->input->get('f-status'));
		}

		$query = $this->db->get('default_daftar_data');
		$result = $query->result_array();

        return $result;
	}

	public function get_data_by_id($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		$query = $this->db->get('default_daftar_data');
		$result = $query->row_array();

		return $result;
	}

	public function count_all_data()
	{
		return $this->db->count_all('daftar_data');
	}

	public function delete_data_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('default_daftar_data');
	}

	public function insert_data($values)
	{
		$values['created_on'] = date("Y-m-d H:i:s");
		if(isset($this->current_user->id)){
			$values['created_by'] = $this->current_user->id;
		}else{
			$values['created_by'] = 0;
		}

		return $this->db->insert('default_daftar_data', $values);
	}

	public function update_data($values, $row_id)
	{
		$values['updated_on'] = date("Y-m-d H:i:s");
		$values['updated_by'] = $this->current_user->id;

		$this->db->where('id', $row_id);
		return $this->db->update('default_daftar_data', $values);
	}

}