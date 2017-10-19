<?php 
class Reports_Model extends Model {
	function Reports_Model ()
	{
		parent::Model();
	}

	function get_report_config($userId) 
	{
		$sql = "SELECT RPTUSERNAME, RPTSUBTITLE, RPTFORMAT FROM users WHERE USER_ID = $userId";
        $query = $this->db->query($sql);
		return $query->result();
	}

	function get_reporttype_name($reportType) 
	{
		$sql = "SELECT QUERYTYPE FROM querytypes WHERE QUERYTYPE_ID = $reportType";
        $query = $this->db->query($sql);
		return $query->row()->QUERYTYPE;
	}

	function get_report($id, $userId) 
	{
		$sql = "SELECT * FROM queries WHERE QUERY_ID = $id AND USER_ID = $userId";
        $query = $this->db->query($sql);
		if(!$query) return false;
		else return $query->row();
	}

	function delete_reports($ids) 
	{
		$sql = "DELETE FROM queries WHERE QUERY_ID IN ($ids)";
        $query = $this->db->query($sql);
	}

	function save_report($userId, $reportType, $subtitle, $title) 
	{
		$data = array('USER_ID'=>$userId, 'QUERYTYPE_ID'=>$reportType, 'SUBTITLE'=>$subtitle, 'LASTVIEWDATE'=>date('Y-m-d H:i:s'), 'TITLE'=>$title);
		$this->db->insert("queries", $data);
		return $this->db->insert_id();
	}

	public function get_reports($userId, $reportType) 
	{
		$this->CI =& get_instance();
		$tablename = 'queries';
		$this->db->select("QUERY_ID,QUERYTYPE,TITLE,SUBTITLE,QUERYDATE,LASTVIEWDATE")->from($tablename);
		$this->db->join('querytypes', 'querytypes.QUERYTYPE_ID = queries.QUERYTYPE_ID', 'inner');
		$this->db->where('USER_ID', $userId);
		$this->db->where('queries.QUERYTYPE_ID', $reportType);
		$this->db->order_by('QUERYDATE', 'DESC');
		$this->CI->flexigrid->build_query();
		
		$return['records'] = $this->db->get();
		
		$this->db->select('count(QUERY_ID) as record_count')->from($tablename);
		$this->db->join('querytypes', 'querytypes.QUERYTYPE_ID = queries.QUERYTYPE_ID', 'inner');
		$this->db->where('USER_ID', $userId);
		$this->db->where('queries.QUERYTYPE_ID', $reportType);
		$this->CI->flexigrid->build_query(false);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		$return['record_count'] = $row->record_count;
		return $return;
	}

}

?>