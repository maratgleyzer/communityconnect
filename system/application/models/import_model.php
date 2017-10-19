<?php

class Import_Model extends Model {

	function Import_Model() {
		parent::Model();
	}

	function lookup_field($field) {
		if (!$field || $field == '')
			return false;
		$query = $this->db->get_where('dem_data', array('ESRI' => $field), 1);
		if ($query->num_rows() == 1) {

			return $query->row()->ID;
		}
		return false;
	}

	private function demographic_row_exists($data) {
		$query = $this->db->get_where('dem_block_data', $data);
		if ($query->num_rows() == 1)
			return true;
		return false;
	}

	function add_demographic($block_id, $dem_data_id, $value) {
		$data = array(
			'BLOCK_ID' => $block_id,
			'DEM_DATA_ID' => $dem_data_id,
			'VALUE' => $value
		);
		if ($this->demographic_row_exists($data)) {
			return 'duplicate'; // check if this is a repeat insertion. we should add constraints on the db.
		}
		elseif ($this->db->insert('dem_block_data', $data)) {
			return 'inserted';
		}
		else {
			return false;
		}
	}

	private function patron_row_exists($data) {
		$query = $this->db->get_where('patron', $data);
		if ($query->num_rows() == 1)
			return true;
		return false;
	}

	function add_patron($data) {
		if ($this->patron_row_exists($data)) {
			return 'duplicate'; // check if this is a repeat insertion. we should add constraints on the db.
		}
		elseif ($this->db->insert('patron', $data)) {
			//	echo $this->db->last_query();
			return 'inserted';
		}
		else {
			return false;
		}
	}

	function update_block($block_id, $data) {
		$query = $this->db->update('block', $data, array('BLOCK_ID' => $block_id));
		if ($query)
			return 'updated';
		return false;
	}

	function add_checkout($data) {
		if ($this->db->insert('checkout', $data)) {
			return 'inserted';
		}
		else {
			return false;
		}
	}

}

?>