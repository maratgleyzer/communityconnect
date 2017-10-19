<?php 
class Rank_potential_model extends Model {
	function Rank_potential_model ()
	{
		parent::Model();
	}

	public function getAreaSums() 
	{
		$this->db->select(array("AREA_ID","POTENTIAL"))
				 ->from("rank_potential")
				 ->order_by("POTENTIAL", "DESC");
		$this->sums = $this->db->get();
		if ($this->sums->num_rows() < 1) {
			return false;
		}
	}
	
	public function getMaxSum()
	{
		$row = $this->sums->row_array();
		return $row['POTENTIAL'];
	}
	
	public function getAreaSum($area=false)
	{
		if ($area)
		foreach ($this->sums->result() as $row) {
			if ($row->AREA_ID == $area)
				return $row->POTENTIAL;
		}
		else return "0";
		
		return "0";
	}
	
	public function getAreaRank($area=false)
	{
		$i = 0; //iterator for ranking
		if ($area)
		foreach ($this->sums->result() as $row) { ++$i;
			if ($row->AREA_ID == $area) return $i;
		}		
		else return "No Selection";
		
		return "Not Ranked";
	}

	public function getAreasByRank()
	{
		$i = 0; //iterator for ranking
		foreach ($this->sums->result() as $row)
			$this->areas_by_rank[++$i] = $row;
		return $this->areas_by_rank;
	}

	public function dataUpdate()
	{	
		$sql = "select sum(POPULATION) as `total` from rank_population";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$data = $query->result();
			$total = $data[0]->total;
		} else {
			return false;
		}
		$sql = "select * from rank_patron";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$data = $query->result();
			foreach ($data as $key => $row)
				$patrons[$row->AREA_ID] = $row->PATRONS;
		} else {
			return false;
		}
		$sql = "select * from rank_population";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$data = $query->result();
			foreach ($data as $key => $row)
				$population[$row->AREA_ID] = $row->POPULATION;
		} else {
			return false;
		}
		foreach ($population as $area => $pop)
			if (isset($patrons[$area]))
				$potential[$area] = round(((($pop / $total) * (1-($patrons[$area] / $pop)))*100), 2);
			else $potential[$area] = round((($pop / $total)*100), 2);
		$sql = "delete from rank_potential";
		$this->db->query($sql); $sql = "";
		$config = array_flip($this->config->config['excluded_service_areas']);
		foreach ($potential as $area => $percent) {
			if (isset($config[$area]))
				continue;
			$sql = "insert into rank_potential (`AREA_ID`, `POTENTIAL`) values (\"".$area."\", $percent)";
			$this->db->query($sql);
		}	
	}

}