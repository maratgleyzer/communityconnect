<?php 
class Patron_model extends Model {
	function Patron_model ()
	{
		parent::Model();
	}

	public function avgPatronsForArea($area="") 
	{	
		$this->db->select('AVG(s.patronSum) as `patronAvg`')
				 ->from("(select count(PATRON_ID) as `patronSum` from patron where AREA_ID = '$area' group by BLOCK_ID) as `s`");
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function sumPatronsForArea($area="") 
	{
		$this->db->select('count(PATRON_ID) as `patronSum`')
				 ->from("patron")
				 ->where("AREA_ID",$area);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
}
	
	
	
	
	
?>