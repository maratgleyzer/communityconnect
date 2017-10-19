<?php

class Block_model extends Model {

	function Block_model() {
		parent::Model();
	}

	function get_segments_by_sa($sa) {
		if ($sa)
			$this->db->where('AREA_ID', $sa);
		$this->db->select('TAPSEGNAM')->from("block");
		$this->db->distinct();
		$this->db->order_by('TAPSEGNAM');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	function get_segments() {
		$this->db->select('AREA_ID, TAPSEGNAM, LIFECODE')->from("block");
		$this->db->distinct();
		$this->db->order_by('TAPSEGNAM');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	function get_distinct_segments() {
		$this->db->select('TAPSEGNAM, LIFECODE')->from("block");
		$this->db->distinct();
		$this->db->order_by('TAPSEGNAM');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	function get_data_at_a_glance($area_id, $segment="") {
//echo "ai = $area_id, sg = $segment"; exit;
		$excluded = $this->config->item('excluded_service_areas');
		$IN = '';
		$tmp = array();
		foreach ($excluded as $e) {
			$tmp[] = "'$e'";
		}
		$IN = implode(',', $tmp);
		$where_sa = 'bg.AREA_ID =';
		$areatype = "";
		if ($area_id == "" || $area_id == 'Region' || $area_id == "__urban" || $area_id == "__rural") {
			if ($area_id == "__urban" ) {
				$areatype = " AND a.TYPE = 'urban' "; 
			} elseif ($area_id == "__rural") {
				$areatype = " AND a.TYPE = 'rural' "; 
			}
			$where_sa = 'bg.AREA_ID !=';
			$area_id = '';
		}
		$group_by = " GROUP BY bg.AREA_ID, bg.TAPSEGNAM";
		$where = "";
		if (!empty($segment) && !empty($area_id)) {
			$where = " AND bg.TAPSEGNAM = '$segment' ";
			$group_by = " GROUP BY bg.AREA_ID, bg.TAPSEGNAM";
		}
		elseif (!empty($segment)) {
			$group_by = " GROUP BY bg.TAPSEGNAM, bg.BLOCK_ID";
			$where = " AND bg.TAPSEGNAM = '$segment' ";
		}

		$sql = 'SELECT a.AREA AS area, bg.AREA_ID AS sa, bg.TAPSEGNAM, bg.BLOCK_ID AS block_id,
					(
						SELECT SUM(TOTPOP_CY) 
						FROM block
					) AS region_pop,
					(
						SELECT SUM(CHECKOUTS) AS cocnt 
						FROM block_sum
					) AS region_co,
					(
						SELECT COUNT(PATRON_ID) FROM patron
					) AS region_patrons,
					SUM(bg.TOTPOP_CY) AS totpop,
					SUM(ptemp.cnt) AS patrons,
					SUM(cotemp.cocnt) AS checkouts,
					SUM(bg.TOTPOP_CY) / SUM(ptemp.cnt) AS market_share,
					SUM(cotemp.cocnt) / SUM(ptemp.cnt) AS avg_patrons,
					((SUM(bg.TOTPOP_CY)/(SELECT SUM(TOTPOP_CY) FROM block))*(SUM(bg.TOTPOP_CY)/SUM(ptemp.cnt)) + 1) AS patron_potential,
					((SUM(bg.TOTPOP_CY)/(SELECT SUM(TOTPOP_CY) FROM block))*(SUM(cotemp.cocnt)/SUM(bg.TOTPOP_CY)) + 1) AS checkout_potential,
					SUM(cotemp.cocnt)/SUM(bg.TOTPOP_CY) AS use_rate
					FROM `block` AS bg
					LEFT JOIN (
						SELECT BLOCK_ID, count(BLOCK_ID) AS cnt
						FROM patron 
						GROUP BY BLOCK_ID
						) AS ptemp
					ON ptemp.BLOCK_ID = bg.BLOCK_ID
					LEFT JOIN (
						SELECT BLOCK_ID, SUM(CHECKOUTS) AS cocnt
						FROM block_sum AS c
						GROUP BY BLOCK_ID
						) AS cotemp
					ON cotemp.BLOCK_ID = bg.BLOCK_ID,
					`area` AS a
					WHERE a.AREA_ID = bg.AREA_ID
						'.$areatype.'
						AND ' . $where_sa . ' "' . $area_id . '"
						AND a.AREA_ID NOT IN (' . $IN . ')' . $where . $group_by;
		// echo $sql;

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	public function get_demographics($year = null) {
		if ($year)
			$this->db->where('YEAR', $year);
		$this->db->where('PARENT_ID IS NULL');
		$this->db->order_by('ID');
		$query = $this->db->get('demographics');
		$result = $query->result();
		$return = array();
		$i = 0;
		foreach ($result as $r) {
			$return[$i] = $r;
			$subs = $this->get_child_demographics($r->ID);
			if ($subs) {
				$new_subs = array();
				$x = 0;
				foreach ($subs as $s) {
					$new_subs[$x] = $s;
					$new_subs[$x]->rows = $this->get_dem_rows($s->ID);
					++$x;
				}
				$return[$i]->subs = $new_subs;
			}
			else {
				$return[$i]->rows = $this->get_dem_rows($r->ID);
			}
			++$i;
		}
		//	print '<pre>'; print_r($return);
		return $return;
	}

	public function get_dem_rows($parent_id) {
		$this->db->where('PARENT_ID', $parent_id);
		$query = $this->db->get('dem_data');
		return $query->result();
	}

	public function get_dem_data_by_id($id) {
		$query = $this->db->get_where('dem_data',array('ID'=>$id), 1);
		return $query->row();
	}
	
	public function get_demographic_data($dem_id, $area_id, $type) {
		if ($type != 'median') {
			$sql = '
				SELECT a.AREA AS AREA, ROUND('.$type.'(dbd.VALUE), 2) AS VALUE
				FROM area a, dem_data d, dem_block_data dbd, block b
				WHERE a.AREA_ID = b.AREA_ID
				AND dbd.BLOCK_ID = b.BLOCK_ID
				AND d.ID = dbd.DEM_DATA_ID
				AND dbd.DEM_DATA_ID = "'.$dem_id.'"
				AND b.AREA_ID = "'.$area_id.'"
				GROUP BY AREA
			';
			$query = $this->db->query($sql);
			return $query->row();
		}
		else { // medians are calc'ed in php
			$sql = '
				SELECT a.AREA AS AREA, dbd.VALUE AS VALUE
				FROM area a, dem_data d, dem_block_data dbd, block b
				WHERE a.AREA_ID = b.AREA_ID
				AND dbd.BLOCK_ID = b.BLOCK_ID
				AND d.ID = dbd.DEM_DATA_ID
				AND dbd.DEM_DATA_ID = "'.$dem_id.'"
				AND b.AREA_ID = "'.$area_id.'"
				ORDER BY VALUE
			';
			$query = $this->db->query($sql);
			$result = $query->result();
			$count = count($result);
			$h = intval($count / 2);
			if ($count % 2 == 0) {
				$h = ($h + ($h - 1) / 2);
			}
			return $result[$h];
		}
	}

	public function get_child_demographics($parent_id) {
		$this->db->where("PARENT_ID = $parent_id AND PARENT_ID IS NOT NULL", NULL, FALSE);
		$query = $this->db->get('demographics');
		return $query->result();
	}

	public function getSegmentPopulation($area) {
		$where = (isset($area)) ? ' AND b.AREA_ID = "' . mysqli_real_escape_string($this->db->conn_id, $area) . '" ' : '';
		$sql = '
			SELECT  b.TAPSEGNAM AS segment, b.AREA_ID, SUM(b.TOTPOP_CY) AS population
			FROM block AS b
			WHERE 1=1 ' . $where . '
			GROUP BY segment
			ORDER BY segment
		';
		$query = $this->db->query($sql);
		// print '<pre>'; print_r($query->result());
		return $query->result();
	}

	public function getSegmentPatrons($area) {
		$where = (isset($area)) ? ' AND b.AREA_ID = "' . mysqli_real_escape_string($this->db->conn_id, $area) . '" ' : '';
		$sql = '
			SELECT b.AREA_ID, b.TAPSEGNAM AS segment, COUNT(p.PATRON_ID) AS patrons
			FROM block AS b
			LEFT JOIN patron AS p ON (b.BLOCK_ID = p.BLOCK_ID)
			WHERE 1=1 ' . $where . '
			GROUP BY segment
			ORDER BY segment
		';
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getSegmentMarketShare($area) {
		$where = (isset($area)) ? ' AND b.AREA_ID = "' . mysqli_real_escape_string($this->db->conn_id, $area) . '" ' : '';
		$sql = '
			SELECT b.AREA_ID, b.TAPSEGNAM AS segment, SUM(DISTINCT(b.TOTPOP_CY)) AS population, ROUND(COUNT(DISTINCT(p.PATRON_ID)) / SUM(DISTINCT(b.TOTPOP_CY)),2) as market_share, COUNT(DISTINCT(p.PATRON_ID)) as patrons
			FROM block AS b
			LEFT JOIN patron AS p ON b.BLOCK_ID = p.BLOCK_ID
			WHERE 1=1 ' . $where . '
			GROUP BY segment
			ORDER BY segment
		';
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getSegmentCheckouts($area, $start = null, $end = null) {
		$where = (isset($area)) ? ' AND b.AREA_ID = "' . mysqli_real_escape_string($this->db->conn_id,$area) . '" ' : '';
		$on_where = '';
		if ($start && $end) {
			$on_where = ' AND CHECKOUT_DATE >= "' . $start . '" AND CHECKOUT_DATE <= "' . $end . '" ';
		}
		$sql = '
			SELECT b.AREA_ID, b.TAPSEGNAM AS segment, SUM(co.CHECKOUTS) AS checkouts
			FROM block AS b
			LEFT JOIN block_sum AS co ON (b.BLOCK_ID = co.BLOCK_ID ' . $on_where . ')
			WHERE 1=1 ' . $where . '
			GROUP BY segment
			ORDER BY segment
		';
		$query = $this->db->query($sql);
		// print_r($query->result());
		return $query->result();
	}

	public function getSegmentPotential($area) {
		if ($area) {
			$tmp_area = "'$area'";
			$tmp = $this->sumPopulationforArea($tmp_area);
			$totpop = $tmp[0]->populationSum; // one area means there's only ever one row.
		}
		else {
			$totpop = $this->get_district_population();
		}
		$oms = $this->getSegmentMarketShare($area);
		$return = array();
		foreach ($oms as $o) {
			$o->potential = round(( ($o->population / $totpop) * $o->market_share ) + 1, 3);
			$return[] = $o;
			;
		}
		return $return;
	}
	public function getSegmentMarketPotential($area) {
		$oms = $this->getSegmentMarketShare($area);
		$return = array();
	
		foreach ($oms as $o) {
			if ($o->population > 0) {
			$nonpatrons = $o->population - $o->patrons;
			$market_potential = round(($nonpatrons/$o->population), 3);
			$o->market_potential = $market_potential;
			$o->patron_potential = round((($o->population * $market_potential) + 1), 3);
			} else {
			$o->market_potential = 0;
			$o->patron_potential = 0;
			}
			;
			$return[] = $o;
		}

		return $return;
	}

	public function get_district_population() {
		$this->db->select('SUM(TOTPOP_CY) AS population');
		$query = $this->db->get('block');
		return $query->row()->population;
	}

	public function getBlocksForArea($area="") {
		$this->db->select('BLOCK_ID')
				->from("block")
				->where("AREA_ID", $area);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	public function getBlockDataForArea($sa, $start = null, $end = null) {
		$this->db->select('block.*,area.AREA');
		$this->db->order_by('AREA');
		$query = $this->db->get_where('block, area', array('block.AREA_ID' => $sa, 'area.AREA_ID =' => $sa));
		$this->load->model('serviceareas_model');
		$SA_pop = $this->serviceareas_model->get_service_area_population($sa);
		$segment_checkout_info = $this->getSegmentCheckouts($sa);
//print_r($segment_checkout_info); 
		$return = array();
		foreach ($query->result() as $row) {
			$pop = $row->population = $row->TOTPOP_CY;
			$row->patrons = $this->getBlockPatrons($row->BLOCK_ID);
			if ($pop == 0) {
				$row->market_share = 0;
				$row->market_potential = 0;
			} else {
				$row->market_share = round($row->patrons / $pop, 2);
				$row->market_potential = round((($pop - $row->patrons)/$pop), 2);
			}
			$row->patron_potential = round(($pop * $row->market_potential) + 1, 3);
			$row->checkouts = $this->getBlockCheckouts($row->BLOCK_ID, $start, $end);
			foreach ($segment_checkout_info as $s) {
				if ($s->segment == $row->TAPSEGNAM) {
					$row->checkout_potential = round(($row->checkouts / $s->checkouts), 2);
				}
			;
			}
//print_r($row->checkouts); exit;
//			$row->checkout_potential = round(($row->checkouts / $segment_checkouts), 2);
		//print_r($row); echo "sapop = ".$SA_pop;
			$return[] = $row;
		}
		return $return;
	}

	public function getBlockCheckouts($block_id, $start = null, $end = null) {
		$where = '';
		if ($start && $end) {
			$where = ' AND CHECKOUT_DATE >= "' . $start . '" AND CHECKOUT_DATE <= "' . $end . '" ';
		}
		$sql = '
			SELECT SUM(CHECKOUTS) AS checkouts
			FROM block_sum WHERE BLOCK_ID = "' . $block_id . '" ' . $where;
		$query = $this->db->query($sql);
		return $query->row()->checkouts;
	}

	public function getBlockPatrons($block_id) {
		$sql = 'SELECT COUNT(PATRON_ID) as patrons FROM patron WHERE BLOCK_ID = ' . $block_id;
		$query = $this->db->query($sql);
		return $query->row()->patrons;
	}

	public function avgPopulationForArea($areas="") {
		$sql = "
		select AVG(TOTPOP_CY) as `populationAvg`, AREA_ID
		from block
		where AREA_ID IN ($areas)
		group by AREA_ID
		order by AREA_ID
		";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	public function sumPopulationForArea($areas="") {
		$sql =
				"
			select SUM(TOTPOP_CY) as `populationSum`, AREA_ID
			from block
			where AREA_ID IN ($areas)
			group by AREA_ID
			order by AREA_ID
			";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	public function getBlockLiteracy($areas, $levels) {
		$area_arr = array();
		$litarea_arr = array();
		for ($i = 0; $i < sizeof($areas); $i++) {
			if (strpos($areas[$i], "LITAREA_") !== false) {
				$temp_litarea_id = str_replace('LITAREA_', '', $areas[$i]);
				array_push($litarea_arr, "'" . $temp_litarea_id . "'");
			}
			else {
				array_push($area_arr, "'" . $areas[$i] . "'");
			}
		}
		$sql = "";
		$level = implode(",", $levels);
		if (sizeof($litarea_arr) > 0) {
			$litarea = implode(",", $litarea_arr);
			$sql = "select 'Not Available' as BLOCK_ID, 'Not Available' as BLOCK_GROUP, LITAREA as AREA, LITLEVEL, LITSCORE, 'Not Available' as TAPSEGNAM, '0' as TOTPOP_CY from litarea where LITAREA_ID in (" . $litarea . ") and LITLEVEL in (" . $level . ")";
		}
		if (sizeof($area_arr) > 0) {
			if ($sql != "")
				$sql .= " union ";
			$area = implode(",", $area_arr);
			$sql .= "select BLOCK_ID, BLOCK_GROUP, AREA, LITLEVEL, LITSCORE, TAPSEGNAM, TOTPOP_CY from block b, area a where b.AREA_ID=a.AREA_ID and b.AREA_ID in (" . $area . ") and b.LITLEVEL in (" . $level . ") order by LITLEVEL";
			//$sql = "select b.*, a.AREA from block b, area a where b.AREA_ID=a.AREA_ID and b.AREA_ID in (".$area.") and b.LITLEVEL in (".$level.") order by b.LITLEVEL";
		}
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	public function getAllBlockPatrons($areas) {
		$area_arr = array();
		for ($i = 0; $i < sizeof($areas); $i++) {
			array_push($area_arr, "'" . $areas[$i] . "'");
		}
		$area = implode(",", $area_arr);
		$sql = "SELECT COUNT(PATRON_ID) as patrons, BLOCK_ID, sum(HISTCKO) as checkouts, avg(HISTCKO) as avg_checkouts FROM patron WHERE BLOCK_ID in (select BLOCK_ID from block where AREA_ID in (" . $area . ")) group by BLOCK_ID";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}
	public function get_area_id_by_block_id($block_id) {
		$this->db->select('AREA_ID');
		$query = $this->db->get_where('block', array('BLOCK_ID'=>$block_id),1);
		if ($query->num_rows() == 1)
			return $query->row()->AREA_ID;
		return false;
	}
	
	public function get_block_id_by_patron_id($patron_id) {
		$query = $this->db->get_where('patron', array('PATRON_ID'=>$patron_id),1);
		if ($query->num_rows() > 0) {
			return $query->row()->BLOCK_ID;
		}
		else {
			return false;
		}
	}

	public function getBlockDataBySegment($segment, $area_id = "") {
		$excluded = $this->config->item('excluded_service_areas');
		$IN = '';
		$tmp = array();
		foreach ($excluded as $e) {
			$tmp[] = "'$e'";
		}
		$IN = implode(',', $tmp);
		$exclude_areas = ' AND b.AREA_ID NOT IN (' . $IN . ') ';
		/*
		  if ($area_id == "" || $area_id == 'Region') {
		  $where_sa = 'bg.AREA_ID !=';
		  $area_id = '';
		  }
		 */


		$patron_where = "";
		if (!empty($area_id)) {
			$patron_where = " WHERE p.AREA_ID = '$area_id' ";
		}
		else {
			$patron_where = " WHERE p.AREA_ID NOT IN ($IN) ";
		}

		$sql = "
		SELECT 
			b.BLOCK_ID, 
			b.TOTPOP_CY as population,
			sum(bs.CHECKOUTS) as checkouts,
			bp.patrons
		FROM 
			block AS b LEFT JOIN
			block_sum as bs on (b.BLOCK_ID = bs.BLOCK_ID) LEFT JOIN
                (SELECT p.BLOCK_ID, count(p.BLOCK_ID) as patrons
                 FROM patron AS p
                 $patron_where
				 GROUP BY p.BLOCK_ID
				) bp ON (b.BLOCK_ID = bp.BLOCK_ID)
		WHERE b.TAPSEGNAM = '$segment'
		$exclude_areas
		GROUP BY b.BLOCK_ID
	";

		//echo $sql;
		$query = $this->db->query($sql);
		return $query->result();
	}

}

?>
