<?php 
class Rank_market_share_model extends Model {
	function Rank_market_share_model ()
	{
		parent::Model();
	}

	public function getAreaSums() 
	{
		$this->db->select(array("AREA_ID","OPEN_MARKETS"))
				 ->from("rank_open_market")
				 ->order_by("OPEN_MARKETS", "DESC");
		$this->sums = $this->db->get();
		if ($this->sums->num_rows() < 1) {
			return false;
		}
	}
	
	public function getMaxSum()
	{
		$row = $this->sums->row_array();
		return $row['OPEN_MARKETS'];
	}
	
	public function getAreaSum($area=false)
	{
		if ($area)
		foreach ($this->sums->result() as $row) {
			if ($row->AREA_ID == $area)
				return $row->OPEN_MARKETS;
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
		foreach ($population as $area => $total)
			if (isset($patrons[$area]))
				$share[$area] = round(((1-($patrons[$area] / $total))*100), 2);
			else $share[$area] = '100';
		$sql = "delete from rank_open_market";
		$this->db->query($sql); $sql = "";
		$config = array_flip($this->config->config['excluded_service_areas']);
		foreach ($share as $area => $percent) {
			if (isset($config[$area]))
				continue;
			$sql = "insert into rank_open_market (`AREA_ID`, `OPEN_MARKETS`) values (\"".$area."\", $percent)";
			$this->db->query($sql);
		}	
	}

}
