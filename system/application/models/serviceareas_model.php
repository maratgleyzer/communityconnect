<?php 
class Serviceareas_model extends Model {
	function Serviceareas_model ()
	{
		parent::Model();
	}

	function get_area($area_id) 
	{
		$this->db->select('AREA')->from("area");
		$this->db->where("AREA_ID", $area_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function get_service_areas() 
	{
		$this->db->select('*')->from('area');
		$this->db->order_by('AREA', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function get_service_areas_by_type($type) 
	{
		$this->db->select('*')->from('area');
		$this->db->where("TYPE", $type);
		$this->db->order_by('AREA', 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

    function get_service_areas_whole() 
	{
        $sql = "select concat('LITAREA_',LITAREA_ID) as AREA_ID, LITAREA as AREA, case when LITAREA_ID=1 then concat('01',LITAREA) else concat('00',LITAREA) end as orderby from litarea union select AREA_ID, AREA, AREA as orderby from area order by orderby";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
	}
	
	function get_service_areas_without_whole_district() {
		$excludes = $this->config->item('excluded_service_areas');
		$tmp = array();
		foreach($excludes as $x) {
			$tmp[] = "'$x'";
		}
		$IN = implode(',',$tmp);
		$this->db->select('*')
				 ->from("area")
				 ->where("AREA_ID NOT IN ($IN)")
				 ->order_by("AREA", 'asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	function get_service_area_population($sa) {
		$this->db->select('SUM(TOTPOP_CY) AS population');
		$query = $this->db->get_where('block',array('AREA_ID'=>$sa));
		$pop = $query->row()->population;
		return $pop;
	}

	public function getSAData($start = null, $end = null) {
		$sql = '
			SELECT SUM(b.TOTPOP_CY) AS population,
			a.*
			FROM area a, block b
			WHERE b.AREA_ID = a.AREA_ID AND b.AREA_ID != 1111
			GROUP BY b.AREA_ID
			ORDER BY AREA
		';
		$query = $this->db->query($sql);
		$pop = $this->get_district_population();
		$return = array();
		foreach ($query->result() as $row) {
			$row->patrons = $this->getSAPatrons($row->AREA_ID);
			$row->new_market = $row->population - $row->patrons;
			$row->market_share = round($row->patrons / $row->population, 2);
			$row->potential = round(( ($row->population / $pop) * $row->market_share ) + 1, 3);
			$row->checkouts = $this->getSACheckouts($row->AREA_ID, $start, $end);
			$return[]= $row;
		}
		return $return;
	}

	public function getSAPatrons($sa) {
		$sql = '
			SELECT COUNT(PATRON_ID) AS patrons
			FROM patron p, block b
			WHERE b.BLOCK_ID = p.BLOCK_ID
			AND b.AREA_ID = "' . $sa . '"';
		$query = $this->db->query($sql);
		return $query->row()->patrons;
	}

	public function getSACheckouts($area_id, $start = null, $end = null) {
		$where = '';
		if ($start && $end) {
			$where = ' AND CHECKOUT_DATE >= "'. $start .'" AND CHECKOUT_DATE <= "'. $end . '" ';
		}
		$sql = '
			SELECT SUM(CHECKOUTS) AS checkouts
			FROM block_sum WHERE AREA_ID = "'.$area_id.'" ' . $where;
		$query = $this->db->query($sql);
		return $query->row()->checkouts;
	}

	public function get_district_population() {
		$this->db->select('SUM(TOTPOP_CY) AS population');
		$query = $this->db->get('block');
		return $query->row()->population;
	}

	function get_population_per_service_area() {
		$SQL = '
			SELECT `AREA_ID`, SUM(TOTPOP_CY) AS `population`
			FROM `BLOCK`
			ORDER BY `population` DESC';
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_iso_checkouts($area_id = "", $type = "", $id = "") {
		$groupby = "";
		$select = "";
		$select_checkouts = "sum(bs.CHECKOUTS) as checkouts, ";
		$from = "";
		if (!empty($type)) {
			if ($type == "material") {
				$groupby = ", data_variable";
				if (!empty($id)) {
					$select_checkouts = "SUM(CASE WHEN bs.MATERIAL_ID = '$id' THEN bs.CHECKOUTS ELSE 0 END) AS checkouts, ";
					$select = " m.MATERIAL AS data_variable, ";
					$from = " LEFT JOIN material AS m ON (m.MATERIAL_ID = '$id') ";
					$groupby = "";
				}
			} elseif ($type == 'item') {
				$groupby = ", data_variable";
				if (!empty($id)) {
					$select_checkouts = "SUM(CASE WHEN bs.ITEM_ID in ( $id) THEN bs.CHECKOUTS ELSE 0 END) AS checkouts, ";
					//$select = " i.ITEM AS data_variable, ";
					$groupby = "";
					//$from = " LEFT JOIN item AS i ON (i.ITEM_ID = '$id') ";
					$select = "";
					$from = "";
				}
			}
		}
		$sql = "
			SELECT 
				a.AREA, 
				$select
				$select_checkouts
				rp.POPULATION as population,
				p.PATRONS as patrons,
				(rp.POPULATION - p.PATRONS) as new_market
			FROM 
				area AS a LEFT JOIN
				block_sum AS bs ON (a.AREA_ID = bs.AREA_ID) LEFT JOIN 
				rank_patron as p ON (a.AREA_ID = p.AREA_ID) LEFT JOIN
				rank_population AS rp ON (a.AREA_ID = rp.AREA_ID)
				$from
			GROUP BY a.AREA $groupby
		";
		//echo $sql; 
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_iso_totals($area_id = "", $type = "", $id = "") {
		$where = "";
		$bswhere = "";
		if (!empty($area_id)) {
			$where = " WHERE AREA_ID = '$area_id' " ;
		}
		$select_checkouts = "SUM(bs.CHECKOUTS) AS value, ";
		if ($type == "material") {
			$select_checkouts = "SUM(CASE WHEN bs.MATERIAL_ID = '$id' THEN bs.CHECKOUTS ELSE 0 END) AS value, ";
		}
		if ($type == "item") {
			$select_checkouts = "SUM(CASE WHEN bs.ITEM_ID in ( $id ) THEN bs.CHECKOUTS ELSE 0 END) AS value, ";
		}
		$sql = "
		 	SELECT 
           		$select_checkouts 'checkouts' as name
            FROM block_sum as bs
			$where 
			UNION 
			SELECT 
                SUM(rp.POPULATION) as value, 'population' as name
			FROM rank_population as rp
			$where
			UNION 
			SELECT 
                SUM(p.PATRONS) as value, 'patrons' as name
			FROM rank_patron as p	
			$where
		";
		//echo $sql; 
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_iso_cos_segments($area_id, $segment="", $type="", $id="") {
		$groupby = "b.TAPSEGNAM";
		$select = "";
		$select_checkouts = "sum(bs.CHECKOUTS) as checkouts, ";
		$from = "";
//echo "aid = $area_id, seg = $segment, type = $type, id = $id\n";
		if (!empty($type)) {
			if ($type == "material") {
				$groupby = "bs.BLOCK_ID, data_variable";
				if (!empty($id)) {
					$select_checkouts = "SUM(CASE WHEN bs.MATERIAL_ID = '$id' THEN bs.CHECKOUTS ELSE 0 END) AS checkouts, ";
					$select = " m.MATERIAL AS data_variable, ";
					$from = " LEFT JOIN material AS m ON (m.MATERIAL_ID = '$id') ";
					$groupby = "bs.BLOCK_ID";
				} else {
					$select_checkouts = "SUM(CASE WHEN bs.MATERIAL_ID = m.MATERIAL_ID THEN bs.CHECKOUTS ELSE 0 END) AS checkouts, ";
					$select = " m.MATERIAL AS data_variable, ";
					$from = " LEFT JOIN material AS m ON (m.MATERIAL_ID = bs.MATERIAL_ID) ";
				}
			} elseif ($type == 'item') {
				$groupby = "bs.BLOCK_ID, data_variable";
				if (!empty($id)) {
					$select_checkouts = "SUM(CASE WHEN bs.ITEM_ID in ( $id ) THEN bs.CHECKOUTS ELSE 0 END) AS checkouts, ";
					//$select = " i.ITEM AS data_variable, ";
					$groupby = "bs.BLOCK_ID";
					//$from = " LEFT JOIN item AS i ON (i.ITEM_ID = '$id') ";
					$select = "";
					$from = "";
				}
			}
		}
		$where = "";
		if (!empty($segment)) {
			$where = " AND b.TAPSEGNAM = '$segment' " ;
			$groupby = "bs.BLOCK_ID";
		}
		$sql = "
			SELECT 
				b.BLOCK_ID,
				b.TAPSEGNAM,
				$select_checkouts
				$select
				b.TOTPOP_CY as population,
				bp.patrons, 
				(b.TOTPOP_CY - bp.patrons) as new_market

			FROM 
				block AS b 
					LEFT JOIN
				block_sum AS bs ON (b.BLOCK_ID = bs.BLOCK_ID) 
					LEFT JOIN
				(SELECT p.BLOCK_ID, count(p.BLOCK_ID) as patrons
				 FROM patron AS p
				 WHERE p.AREA_ID = '$area_id'
				 GROUP BY p.BLOCK_ID
				 ) bp ON (b.BLOCK_ID = bp.BLOCK_ID)
				 $from
			WHERE b.AREA_ID = '$area_id'
			$where
			GROUP BY $groupby
		";
		//echo $sql; 
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_iso_totals_segments($area_id, $segment, $type = "", $id = "") {
		$select_checkouts = "SUM(bs.CHECKOUTS) AS value, ";
		if ($type == "material") {
			$select_checkouts = "SUM(CASE WHEN bs.MATERIAL_ID = '$id' THEN bs.CHECKOUTS ELSE 0 END) AS value, ";
		}
		if ($type == "item") {
			$select_checkouts = "SUM(CASE WHEN bs.ITEM_ID in ( $id ) THEN bs.CHECKOUTS ELSE 0 END) AS value, ";
		}
		$sql = "
		 	SELECT 
           		$select_checkouts 'checkouts' as name
            FROM block_sum as bs, block as b
			WHERE bs.AREA_ID = '$area_id'
			AND bs.BLOCK_ID = b.BLOCK_ID
			AND b.TAPSEGNAM = '$segment'

			UNION 

			SELECT 
                sum(b.TOTPOP_CY), 'population' as name
			FROM block b
			WHERE b.TAPSEGNAM = '$segment'
			AND b.AREA_ID = '$area_id'

			UNION 

			SELECT 
                count(*) as value, 'patrons' as name
			FROM patron p JOIN block b
			WHERE p.BLOCK_ID = b.BLOCK_ID
			AND b.TAPSEGNAM = '$segment'
			AND b.AREA_ID = '$area_id'
		";
		//echo $sql; 
		$query = $this->db->query($sql);
		return $query->result();
	}
}
