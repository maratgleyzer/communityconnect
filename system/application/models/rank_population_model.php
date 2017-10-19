<?php

class Rank_population_model extends Model {

	function Rank_population_model() {
		parent::Model();
	}

	public function getAreaSums() {
		$this->db->select(array("AREA_ID", "POPULATION"))
				->from("rank_population")
				->order_by("POPULATION", "DESC");
		$this->sums = $this->db->get();
		if ($this->sums->num_rows() < 1) {
			return false;
		}
	}

	public function getMaxSum() {
		$row = $this->sums->row_array();
		return $row['POPULATION'];
	}

	public function getAreaSum($area=false) {
		if ($area)
		foreach ($this->sums->result() as $row) {
			if ($row->AREA_ID == $area)
				return $row->POPULATION;
		}
		else return "0";
		
		return "0";
	}

	public function getAreaRank($area=false) {
		$i = 0; //iterator for ranking
		if ($area)
		foreach ($this->sums->result() as $row) { ++$i;
			if ($row->AREA_ID == $area) return $i;
		}		
		else return "No Selection";
		
		return "Not Ranked";
	}

	public function getAreasByRank() {
		$i = 0; //iterator for ranking
		foreach ($this->sums->result() as $row)
			$this->areas_by_rank[++$i] = $row;
		return $this->areas_by_rank;
	}
	
	public function dataUpdate()
	{	
		$sql =
"
select
a.AREA_ID as `area`,
sum(b.TOTPOP_CY) as `population`
from block `b`, area `a`
where b.AREA_ID = a.AREA_ID
group by a.AREA_ID
";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$data = $query->result();
			$sql = "delete from rank_population";
			$this->db->query($sql); $sql = "";
			$config = array_flip($this->config->config['excluded_service_areas']);
			foreach ($data as $key => $row) {
				if (isset($config[$row->area]))
					continue;
				$sql = "insert into rank_population (`AREA_ID`, `POPULATION`) values (\"".$row->area."\", \"".$row->population."\")";
				$this->db->query($sql);
			}
		} else {
			return false;
		}
	}

}
