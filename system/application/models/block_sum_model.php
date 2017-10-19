<?php 
class Block_sum_model extends Model {

	function Block_sum_model ()
	{
		parent::Model();
	}

	public function dataUpdate()
	{
		$i = 0;
		$sql = "delete from block_sum";
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
b.AREA_ID,
c.BLOCK_ID,
c.MATERIAL_ID,
c.ITEM_ID,
DATE_FORMAT(c.CHECKOUT_TIME, '%Y-%m-%d') as CHECKOUT_DATE,
count(*) as `CHECKOUTS`
from checkout `c`, block `b`
where c.BLOCK_ID = $block
  and c.BLOCK_ID = b.BLOCK_ID
group by c.BLOCK_ID, c.MATERIAL_ID, c.ITEM_ID, CHECKOUT_DATE
";
				$query = $this->db->query($sql);
				if ($query->num_rows() > 0) {
					$data = $query->result(); $sql = "";

					$sql = "insert into block_sum (`BLOCK_ID`, `AREA_ID`, `MATERIAL_ID`, `ITEM_ID`, `CHECKOUT_DATE`, `CHECKOUTS`) values ";
					foreach ($data as $key => $row) {
						++$i;
						$sql .=
"(".$row->BLOCK_ID.", \"".$row->AREA_ID."\", \"".$row->MATERIAL_ID."\", \"".$row->ITEM_ID."\", \"".$row->CHECKOUT_DATE."\", ".$row->CHECKOUTS."), ";
						//if ($i >= 500) {
						//	$this->db->query(substr($sql, 0, -2).";");
						//	$sql = "insert into block_sum (`BLOCK_ID`, `AREA_ID`, `MATERIAL_ID`, `ITEM_ID`, `CHECKOUT_DATE`, `CHECKOUTS`) values ";
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