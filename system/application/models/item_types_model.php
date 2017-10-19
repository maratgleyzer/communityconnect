<?php 
class Item_types_model extends Model {
	function Item_types_model ()
	{
		parent::Model();
	}

	function get_item_types($cat = "") 
	{
		if ($cat) $this->db->where($cat,1);
		$this->db->select('*')->from("item");
		$this->db->group_by("ITEM");
		$this->db->order_by("ITEM", "asc");
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}
