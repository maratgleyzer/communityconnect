<?php 
class Material_types_model extends Model {
	function Material_types_model ()
	{
		parent::Model();
	}

	function get_material_types() 
	{
		$this->db->select('*')->from("material");
		$this->db->where("MATERIAL not like", 'zz%');
		$this->db->group_by("MATERIAL");
		$this->db->order_by("MATERIAL", "asc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

}
