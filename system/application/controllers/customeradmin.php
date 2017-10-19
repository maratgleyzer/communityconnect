<?php
class Customeradmin extends CV_Controller {

	var $data = array();

	function __construct () 
	{
		parent::CV_Controller();
        $this->data['pageTitle'] = "Customer Admin Center";
	}

	function index () 
	{
 		$this->load->model("usage_stats");
 		$this->load->model("users_model");
       	$data = $this->data;
		$data['pageClass'] = "increaseServices";
		$data['availableyears'] = $this->usage_stats->get_available_years();
		$data['all_users'] = $this->users_model->get_all_users();
		//echo "<pre>"; print_r($data); exit;
        $this->load->view('customeradmin/index', $data);
	}

	function run_report () 
	{
		$this->load->model("usage_stats");
		$rtype = $_REQUEST['rtype'];
		$year = $_REQUEST['year'];
//		$reportName = $rtype == "1" ? "Reports/Maps by Type" : "Number by Username";
		$firstColHeader = $rtype == "1" ? "Type" : "Username";
		$results = $rtype == "1" ? $this->usage_stats->get_bytype_report($year) : $this->usage_stats->get_byusername_report($year);
		$html = "";
		if (count($results) > 0) {
			$html .=	"<table>".
						'<tr class="row">'.
						"<th>$firstColHeader</th>".
						"<th>January $year</th>".
						"<th>February $year</th>".
						"<th>March $year</th>".
						"<th>April $year</th>".
						"<th>May $year</th>".
						"<th>June $year</th>".
						"<th>July $year</th>".
						"<th>August $year</th>".
						"<th>September $year</th>".
						"<th>October $year</th>".
						"<th>November $year</th>".
						"<th>December $year</th>".
						"<th>YTD Count</th>".
						"</tr>";
			for ($n = 0; $n < count($results); $n++)
			{
				$result = $results[$n];
                $html .= 	'<tr class="' . ($n % 2 ? "altrow" : "row") . '">'.
                			"<td>".$result->FIRSTCOL."</td>".
                            "<td>".$result->JAN."</td>".
                            "<td>".$result->FEB."</td>".
                            "<td>".$result->MAR."</td>".
                            "<td>".$result->APR."</td>".
                            "<td>".$result->MAY."</td>".
                            "<td>".$result->JUN."</td>".
                            "<td>".$result->JUL."</td>".
                            "<td>".$result->AUG."</td>".
                            "<td>".$result->SEP."</td>".
                            "<td>".$result->OCT."</td>".
                            "<td>".$result->NOV."</td>".
                            "<td>".$result->DEC."</td>".
                            "<td>".$result->YTD."</td>".
                        	"</tr>";
			}
			$html .= "</table>";
		} else {
			$html .= "<p>No records found.</p>";
		}
		echo json_encode(array("Results"=>$html));
	}
	
	function save_report () 
	{
		$this->load->model("usage_stats");
		$rtype = $_REQUEST['rtype'];
		$year = $_REQUEST['year'];
		$format = $_REQUEST['format'];
		if($format == "pdf") {
			$this->load->library('fpdf/fpdf');
			switch ($rtype) {
				case 1:		//usage report by type
					$reportName = "Reports/Maps by Type";
					$header = array("Type", "January $year", "February $year", "March $year", "April $year", "May $year", "June $year", "July $year", "August $year", "September $year", "October $year", "November $year", "December $year", "YTD");
					$colwidths = array(30,15,15,15,15,15,15,15,15,20,15,20,20,15);
					$results = $this->usage_stats->get_bytype_report($year);
					break;
				case 2:		//usage report by user
					$reportName = "Number by Username";
					$header = array("Username", "January $year", "February $year", "March $year", "April $year", "May $year", "June $year", "July $year", "August $year", "September $year", "October $year", "November $year", "December $year", "YTD");
					$colwidths = array(30,15,15,15,15,15,15,15,15,20,15,20,20,15);
					$results = $this->usage_stats->get_byusername_report($year);
					break;
			}
			$orientation = "L";
			$pageSize = "Letter";
			$units = "mm";
			$totalWidth = array_sum($colwidths);
			$pdf = new FPDF($orientation, $units, $pageSize);
			$pdf->AddPage();
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->SetTextColor(0);
			$pdf->Cell($totalWidth, 10, $reportName);
			$pdf->Ln();
			$pdf->SetFont('Arial', 'B', 6);

			if (count($results) > 0) {
				$pdf->SetFillColor(204, 204, 204);
				$pdf->SetDrawColor(0);
				$pdf->SetLineWidth(.3);
	
				for($i = 0; $i < count($header); $i++)
					$pdf->Cell($colwidths[$i], 7, $header[$i], 1, 0, 'C', true);
				$pdf->Ln();
	
				$pdf->SetFillColor(224,235,255);
	
				$fill = false;
				for($r = 0; $r < count($results); $r++) {
					$row = $results[$r];
					$i = 0;
					foreach($row as $key => $value) { 
						$align = is_numeric($value) ? 'R' : 'L';
						$text = is_numeric($value) ? number_format($value) : $value;
						$pdf->Cell($colwidths[$i], 6, $text, 'LR', 0, $align, $fill);
						$i++;
					}
					$pdf->Ln();
					$fill=!$fill;
				}
				$pdf->Cell($totalWidth,0,'','T');
			} else {
				$pdf->Cell($totalWidth, 10, "No records found.");
			}
			$pdf->Output();
			exit;
		}
	}	
}
?>
