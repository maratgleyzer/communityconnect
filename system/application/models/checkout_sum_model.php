<?php 
class Checkout_sum_model extends Model {

	function Checkout_sum_model ()
	{
		parent::Model();
	}
	
	public function getProfileData($sort_alpha=false,$sort_num=false) {
		
		$sql =
"
select
a.AREA,
a.AREA_ID,
b.TAPSEGNAM,
b.TOTPOP_CY as `population`,
b.patronSum as `patrons`,
b.checkoutSum as `checkouts`
from (
	select b.BLOCK_ID, b.TOTPOP_CY, b.AREA_ID, b.TAPSEGNAM, p.patronSum, c.checkoutSum
	from block `b`
	left join (
	    select count(distinct(PATRON_ID)) as `patronSum`, BLOCK_ID
	    from patron
		group by BLOCK_ID
	) as `p` on (b.BLOCK_ID = p.BLOCK_ID)
	left join (
	    select SUM(CHECKOUTS) as `checkoutSum`, BLOCK_ID
	    from block_sum
		group by BLOCK_ID
	) as `c` on (p.BLOCK_ID = c.BLOCK_ID)
	where b.AREA_ID != 'ood'
) as `b`, area `a`
where b.AREA_ID = a.AREA_ID
group by b.BLOCK_ID
".($sort_alpha ? "order by a.AREA $sort_alpha, b.TAPSEGNAM $sort_alpha" : "")."
".($sort_num ? "order by patrons $sort_num" : "")."
";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getSegmentProfileData($sort_alpha=false,$sort_num=false) {
		
		$sql =
"
select
a.AREA,
a.AREA_ID,
b.TAPSEGNAM,
b.TOTPOP_CY as `population`,
b.patronSum as `patrons`,
b.checkoutSum as `checkouts`
from (
	select b.BLOCK_ID, b.TOTPOP_CY, b.AREA_ID, b.TAPSEGNAM, p.patronSum, c.checkoutSum
	from block `b`
	left join (
	    select count(distinct(PATRON_ID)) as `patronSum`, BLOCK_ID
	    from patron
		group by BLOCK_ID
	) as `p` on (b.BLOCK_ID = p.BLOCK_ID)
	left join (
	    select SUM(CHECKOUTS) as `checkoutSum`, BLOCK_ID
	    from block_sum
		group by BLOCK_ID
	) as `c` on (p.BLOCK_ID = c.BLOCK_ID)
	where b.AREA_ID != 'ood'
) as `b`, area `a`
where b.AREA_ID = a.AREA_ID
group by b.BLOCK_ID
order by b.AREA_ID, b.TAPSEGNAM
";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getHighestPopulationSegment($areas="",$startdate=false,$enddate=false) {
		
		$sql =
"
select
a.AREA,
a.AREA_ID,
b.TAPSEGNAM,
MAX(b.populationSum) as `maxValue`
from (
	select BLOCK_ID, SUM(TOTPOP_CY) as `populationSum`, TAPSEGNAM, AREA_ID
	from block
	where AREA_ID IN ($areas)
	group by BLOCK_ID
) as `b`, area `a`
where b.AREA_ID = a.AREA_ID
group by b.AREA_ID, b.TAPSEGNAM
order by b.TAPSEGNAM
";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function getHighestPatronsSegment($areas="",$startdate=false,$enddate=false) {
		
		$sql =
"
select
a.AREA,
a.AREA_ID,
b.TAPSEGNAM,
MAX(b.patronSum) as `maxValue`
from (
	select b.BLOCK_ID, b.TOTPOP_CY, b.AREA_ID, b.TAPSEGNAM, p.patronSum, c.checkoutSum
	from block `b`
	left join (
	    select count(distinct(PATRON_ID)) as `patronSum`, BLOCK_ID
	    from patron
		group by BLOCK_ID
	) as `p` on (b.BLOCK_ID = p.BLOCK_ID)
	left join (
	    select SUM(CHECKOUTS) as `checkoutSum`, BLOCK_ID
	    from block_sum
		".(($startdate && $enddate) ? " where CHECKOUT_DATE BETWEEN '$startdate' AND '$enddate' " : "")."
		group by BLOCK_ID
	) as `c` on (p.BLOCK_ID = c.BLOCK_ID)
	where b.AREA_ID IN ($areas)
	group by b.BLOCK_ID
) as `b`, area `a`
where b.AREA_ID = a.AREA_ID
group by b.AREA_ID
order by a.AREA
";	

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getHighestCheckoutsSegment($areas="",$startdate=false,$enddate=false) {
		
		$sql =
"
select
a.AREA,
a.AREA_ID,
b.TAPSEGNAM,
MAX(c.checkoutSum) as `maxValue`
from (
	select b.BLOCK_ID, b.TOTPOP_CY, b.AREA_ID, b.TAPSEGNAM, p.patronSum, c.checkoutSum
	from block `b`
	left join (
	    select count(distinct(PATRON_ID)) as `patronSum`, BLOCK_ID
	    from patron
		group by BLOCK_ID
	) as `p` on (b.BLOCK_ID = p.BLOCK_ID)
	left join (
	    select SUM(CHECKOUTS) as `checkoutSum`, BLOCK_ID
	    from block_sum
		".(($startdate && $enddate) ? " where CHECKOUT_DATE BETWEEN '$startdate' AND '$enddate' " : "")."
		group by BLOCK_ID
	) as `c` on (p.BLOCK_ID = c.BLOCK_ID)
	where b.AREA_ID IN ($areas)
	group by b.BLOCK_ID
) as `b`, area `a`
where b.AREA_ID = a.AREA_ID
group by b.AREA_ID, b.TAPSEGNAM
order by a.AREA
";	

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getHighestPotentialSegment($areas="",$startdate=false,$enddate=false) {
		
		$sql =
"
select
a.AREA,
a.AREA_ID,
b.TAPSEGNAM,
MAX((((SUM(b.TOTPOP_CY) / (SELECT SUM(TOTPOP_CY) FROM block))*(SUM(b.patronSum) / (SELECT count(distinct(c.PATRON_ID)))))+1)) as `maxValue`
from (
	select count(distinct(c.PATRON_ID)) as `patronSum`, b.BLOCK_ID, b.AREA_ID, b.TAPSEGNAM, b.TOTPOP_CY
	from checkout_sum `c`, block `b`
	where ".(($startdate && $enddate) ? "c.CHECKOUT_DATE BETWEEN '$startdate' AND '$enddate' and " : "")."
		  c.BLOCK_ID = b.BLOCK_ID
	  and b.AREA_ID IN ($areas)
	group by c.BLOCK_ID
) as block `b`, area `a`
where b.AREA_ID = a.AREA_ID
group by b.AREA_ID, b.TAPSEGNAM
order by a.AREA
";	

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getHighestAverageCheckoutsSegment($areas="",$startdate=false,$enddate=false) {
		
		$sql =
"
select
a.AREA,
a.AREA_ID,
b.TAPSEGNAM,
MAX((SUM(b.checkoutSum) / SUM(b.patronSum))) as `maxValue`
from (
	select count(distinct(c.PATRON_ID)) as `patronSum`, SUM(c.CHECKOUTS) as `checkoutSum`, b.BLOCK_ID, b.AREA_ID, b.TAPSEGNAM
	from checkout_sum `c`, block `b`
	where ".(($startdate && $enddate) ? "c.CHECKOUT_DATE BETWEEN '$startdate' AND '$enddate' and " : "")."
		  c.BLOCK_ID = b.BLOCK_ID
	  and b.AREA_ID IN ($areas)
	group by c.BLOCK_ID
) as block `b`, area `a`
where b.AREA_ID = a.AREA_ID
group by b.AREA_ID, b.TAPSEGNAM
order by a.AREA
";	

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function getHighestOpenMarketRateSegment($areas="",$startdate=false,$enddate=false) {

		$sql =
"
select
a.AREA,
a.AREA_ID,
b.TAPSEGNAM,
MAX(((1-(SUM(b.patronSum) / SUM(b.TOTPOP_CY)))*100)) as `maxValue`
from (
	select count(distinct(c.PATRON_ID)) as `patronSum`, SUM(c.CHECKOUTS) as `checkoutSum`, b.BLOCK_ID, b.AREA_ID, b.TAPSEGNAM, b.TOTPOP_CY
	from checkout_sum `c`, block `b`
	where ".(($startdate && $enddate) ? "c.CHECKOUT_DATE BETWEEN '$startdate' AND '$enddate' and " : "")."
		  c.BLOCK_ID = b.BLOCK_ID
	  and b.AREA_ID IN ($areas)
	group by c.BLOCK_ID
) as block `b`, area `a`
where b.AREA_ID = a.AREA_ID
group by b.AREA_ID, b.TAPSEGNAM
order by a.AREA
";	

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	public function dataUpdate()
	{	
		$i = 0;
		$sql = "delete from checkout_sum";
		$this->db->query($sql); $sql = "";
		$sql = "select BLOCK_ID from block";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$data = $query->result();
			foreach ($data as $key => $row) {
				$block = $row->BLOCK_ID;
				$sql =
"
select
c.PATRON_ID,
c.BLOCK_ID,
c.MATERIAL_ID,
c.ITEM_ID,
DATE_FORMAT(c.CHECKOUT_TIME, '%Y-%m-%d') as CHECKOUT_DATE,
count(*) as `CHECKOUTS`
from checkout `c`
where c.BLOCK_ID = $block
group by c.PATRON_ID, c.BLOCK_ID, c.MATERIAL_ID, c.ITEM_ID, CHECKOUT_DATE
";
				$query = $this->db->query($sql);
				if ($query->num_rows() > 0) {
					$data = $query->result();
					$sql = "insert into checkout_sum (`PATRON_ID`, `BLOCK_ID`, `MATERIAL_ID`, `ITEM_ID`, `CHECKOUT_DATE`, `CHECKOUTS`) values ";
					foreach ($data as $key => $row) {
						++$i;
						$sql .=
"(".$row->PATRON_ID.", ".$row->BLOCK_ID.", \"".$row->MATERIAL_ID."\", \"".$row->ITEM_ID."\", \"".$row->CHECKOUT_DATE."\", ".$row->CHECKOUTS."), ";
						//if ($i >= 500) {
						//	$this->db->query(substr($sql, 0, -2).";");
						//	$sql = "insert into checkout_sum (`PATRON_ID`, `BLOCK_ID`, `MATERIAL_ID`, `ITEM_ID`, `CHECKOUT_DATE`, `CHECKOUTS`) values ";
						//	$i = 0;
						//}
					}
					$this->db->query(substr($sql, 0, -2).";");
				} else {
					continue;
				}
			}
		}
		else {
			return false;
		}
	}
		
}