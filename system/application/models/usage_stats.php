<?php 
class Usage_Stats extends Model {
	function Usage_Stats ()
	{
		parent::Model();
	}

	function get_available_years() 
	{
		$sql = "SELECT DISTINCT(year(QUERYDATE)) AS YEAR FROM queries ORDER BY year(QUERYDATE) DESC";
        $query = $this->db->query($sql);
		return $query->result();
	}

	function get_bytype_report($year) 
	{
		$sql = 
		"SELECT QUERYTYPE AS FIRSTCOL, 
    	(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 1 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'JAN',
    	(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 2 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'FEB',
    	(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 3 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'MAR',
    	(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 4 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'APR',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 5 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'MAY',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 6 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'JUN',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 7 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'JUL',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 8 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'AUG',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 9 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'SEP',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 10 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'OCT',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 11 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'NOV',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 12 AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'DEC',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND QUERYTYPE_ID = Q2.QUERYTYPE_ID) AS 'YTD'
		FROM queries Q2 INNER JOIN querytypes ON Q2.QUERYTYPE_ID = querytypes.QUERYTYPE_ID
		WHERE year(QUERYDATE) = $year
		GROUP BY QUERYTYPE";
        $query = $this->db->query($sql);
		return $query->result();
	}

	function get_byusername_report($year) 
	{
		$sql = 
		"SELECT EMAIL AS FIRSTCOL, 
    	(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 1 AND USER_ID = Q2.USER_ID) AS 'JAN',
    	(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 2 AND USER_ID = Q2.USER_ID) AS 'FEB',
    	(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 3 AND USER_ID = Q2.USER_ID) AS 'MAR',
    	(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 4 AND USER_ID = Q2.USER_ID) AS 'APR',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 5 AND USER_ID = Q2.USER_ID) AS 'MAY',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 6 AND USER_ID = Q2.USER_ID) AS 'JUN',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 7 AND USER_ID = Q2.USER_ID) AS 'JUL',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 8 AND USER_ID = Q2.USER_ID) AS 'AUG',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 9 AND USER_ID = Q2.USER_ID) AS 'SEP',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 10 AND USER_ID = Q2.USER_ID) AS 'OCT',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 11 AND USER_ID = Q2.USER_ID) AS 'NOV',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND month(QUERYDATE) = 12 AND USER_ID = Q2.USER_ID) AS 'DEC',
		(SELECT count(QUERY_ID) FROM queries WHERE year(QUERYDATE) = $year AND USER_ID = Q2.USER_ID) AS 'YTD'
		FROM queries Q2 INNER JOIN users ON Q2.USER_ID = users.USER_ID
		WHERE year(QUERYDATE) = $year
		GROUP BY EMAIL";
        $query = $this->db->query($sql);
		return $query->result();
	}

}

?>