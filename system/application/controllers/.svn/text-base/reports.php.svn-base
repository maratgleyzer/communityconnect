<?php
ini_set('display_errors', 1); 
error_reporting(E_WARNING | E_ERROR);

class Reports extends CV_Controller {

	var $data = array();

	function __construct () 
	{
		parent::CV_Controller();
	}

	function index () 
	{
       	$data = $this->data;
 		$data['extraJS'] = array('flexigrid.pack');
		$data['extraCSS'] = array('flexigrid');
		$this->load->helper('flexigrid');
        $data['pageTitle'] = "Reports";
		$data['userId'] = $this->session->userdata('uid');
		$reportgrid_js = '';
		for($i = 1; $i <= 5; $i++)
			$reportgrid_js .= $this->get_reportgrid_js($i);
		$data['reportgrid_js'] = $reportgrid_js;
		$this->load->view('reports/index', $data);
	}

	function show_save_dialog()
	{
        $data = $this->data;
		$this->load->model("reports_model");
        $data['pageTitle'] = "Save Report";
		$config = $this->reports_model->get_report_config($this->session->userdata('uid'));
		$data['reportConfig'] = $config[0];
		$this->load->view('reports/save_report', $data);
	}	

	function delete_reports()
	{
		$this->load->model("reports_model");
 		$ids = $_REQUEST['idlist'];
		$this->reports_model->delete_reports($ids);
	}	

	function open_report()
	{
		$this->load->model("reports_model");
 		$reportId = $_REQUEST['rid'];
 		$dest = $_REQUEST['d'];
		$uid = $this->session->userdata('uid');
		$report = $this->reports_model->get_report($reportId, $uid);
		if(!$report) die("Report not found.");
		$reportspath = realpath('../web/reports/');
		$reportpath = $reportspath . '/' . $uid;
		$filename = $reportId . '-' . $uid . '-' . $report->QUERYTYPE_ID . '.pdf';
		$path = $reportpath . '/' . $filename;
		if(!file_exists($path)) die("File not found.");
		$fsize = filesize($path); 
		if (ob_get_contents()) die('Some data has already been output, can\'t send PDF file');
		if (headers_sent()) die('Headers already sent to browser, can\'t send PDF file');
		
		header('Cache-Control: public, must-revalidate, max-age=0');
		header('Pragma: public');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		header('Content-Type: application/pdf');
		header('Content-Length: '.$fsize);
		if($dest == 'I') {
			header('Content-Disposition: inline; filename="'.$filename.'";');
		} else if ($dest == 'D') {
			header('Content-Description: File Transfer');
			header('Content-Type: application/force-download', false);
			header('Content-Type: application/octet-stream', false);
			header('Content-Type: application/download', false);
			header('Content-Type: application/pdf', false);
			header('Content-Disposition: attachment; filename="'.basename($name).'";');
			header('Content-Transfer-Encoding: binary');
		}
		
		$file = @fopen($path,"rb");
		if ($file) {
			while(!feof($file)) {
				print(fread($file, 1024*8));
				flush();
				if (connection_status()!=0) {
					@fclose($file);
					die();
				}
			}
			@fclose($file);
		}
	}
	
	function dialog_test()
	{
		$this->load->view('reports/save_dialog_test');

	}

	function save_report()
	{
		$this->load->model("reports_model");
		$rtype = $_REQUEST['rtype'];
		$rtitle = $_REQUEST['rtitle'];
		$subtitle = $_REQUEST['subtitle_tb'];
		$rptusername = $_REQUEST['name_tb'];
		$rptformat = $_REQUEST['format'];
		$geoarea = $_REQUEST['geoarea'];
		$rijson = '['.preg_replace('/[\x00-\x1F\x80-\xFF]/', '', stripslashes($_REQUEST['reportitems'])).']';
		//$ritems = json_decode('[{\"type\": \"0\", \"source\": \"<table class=\"pivot\"><tr><td>testing</td></tr></table>"},{\"type\": \"1\", \"source\": \"graphics/fusion_charts_pdfs/FusionCharts_a7be423abb9c3cf22481ac0a7275ce64_31102010125215_49.jpg\", \"heading\": \"\"}]');
		$ritems = json_decode($rijson);
		$querydescr = $_REQUEST['querydescr'];
		$reportTypeName = $this->reports_model->get_reporttype_name($rtype);
		$rpttitle = "$reportTypeName: $rtitle";
		$uid = $this->session->userdata('uid');
		$id = $this->reports_model->save_report($uid, $rtype, $subtitle, $rpttitle);
		$reportspath = realpath('../web/reports/');
		$reportpath = $reportspath . '/' . $uid;
		if(!file_exists($reportpath)) mkdir($reportpath);
		$filename = $id . '-' . $uid . '-' . $rtype;
		$host = $this->config->config['base_url'].'/';
		if($rptformat  == 'pdf') {
			$filename .= '.pdf';
			$params = array('orientation' => 'L', 'format' => 'LETTER', 'author' => $rptusername, 'title' => $rpttitle, 'subtitle' => $subtitle, 'geoarea' => $geoarea);
			$this->load->library('reportpdf', $params);
			$margins = $this->reportpdf->getMargins();
			$pagewidth = $this->reportpdf->getPageWidth();
			$imagewidth = $pagewidth - $margins['left'] - $margin['right'] - .5;
	        $this->reportpdf->SetFont('times', '', 12);
	        $this->reportpdf->AddPage();
			$this->reportpdf->writeHTML('<p>'.$querydescr.'</p>', true, false, true, false, '');
			foreach($ritems as $ritem) {
				if($ritem->type == '0') {
					$this->reportpdf->writeHTML(urldecode($ritem->source), true, false, true, false, '');
				} else if ($ritem->type == '1') {
	        		$this->reportpdf->AddPage();
					//$this->reportpdf->Image($host.$ritem->source, $margins['left'], $this->reportpdf->GetY(), $imagewidth, '', '', '', 'T', true, 72, '', false, false, 0, false, false, false);
					$this->reportpdf->Image($host.$ritem->source, $margins['left'], $this->reportpdf->GetY());
				}
			}
			$filename = $reportpath . '/' . $filename;
	        $this->reportpdf->Output($filename, 'F');        
		}
		echo 'OK';
	}
	
	function getphpinfo() 
	{
		echo phpinfo();
	}
	
	function report_template()
	{
		$rptformat = 'pdf'; 
		$subtitle = 'This is a test report';
		$rptusername = 'David Perry';
		$rpttitle = 'Increase Services: Performance Report - Test';
		$geoarea = 'Utah County, UT, 49049, U.S. Counties';
		$host = $this->config->config['base_url'].'/';
		if($rptformat  == 'pdf') {
			$params = array('orientation' => 'L', 'format' => 'TABLOID', 'author' => $rptusername, 'title' => $rpttitle, 'subtitle' => $subtitle, 'geoarea' => $geoarea);
			$this->load->library('reportpdf', $params);
			$margins = $this->reportpdf->getMargins();
			$pagewidth = $this->reportpdf->getPageWidth();
			$imagewidth = $pagewidth - $margins['left'] - $margin['right'] - .5;
	        $this->reportpdf->SetFont('times', 'BI', 16);
	        $this->reportpdf->AddPage();
			$html = "<div>Hello World!</div><div>$imagewidth</div>";
			$this->reportpdf->writeHTML($html, true, false, true, false, '');
			$this->reportpdf->AddPage();
			//$this->reportpdf->Image($host.'graphics/fusion_charts_pdfs/FusionCharts_cd86db9e63d3f1b64cbb62b2b0a4f4d0_27102010153519_41.jpg', $margins['left'], $this->reportpdf->GetY());
			$this->reportpdf->Image($host.'graphics/fusion_charts_pdfs/FusionCharts_cd86db9e63d3f1b64cbb62b2b0a4f4d0_27102010153519_41.jpg', $margins['left'], $this->reportpdf->GetY(), $imagewidth);
			//$this->reportpdf->Image($host.'graphics/fusion_charts_pdfs/FusionCharts_cd86db9e63d3f1b64cbb62b2b0a4f4d0_27102010153519_41.jpg', $margins['left'], $this->reportpdf->GetY(), '', '', '', '', 'T', false, 72, '', false, false, 0, false, false, false);
			$this->reportpdf->writeHTML('<br/>Page Width: '.$this->reportpdf->getPageWidth(), true, false, true, false, '');
			$this->reportpdf->AddPage();
			//$this->reportpdf->setPageFormat('LEGAL');
			//$this->reportpdf->Image($host.'graphics/fusion_charts_pdfs/FusionCharts.jpg', $margins['left'], $this->reportpdf->GetY(), '', '', '', '', 'T', false, 72, '', false, false, 0, false, false, false);
			$this->reportpdf->Image($host.'graphics/fusion_charts_pdfs/FusionCharts.jpg', $margins['left'], $this->reportpdf->GetY(), '$imagewidth');
			$this->reportpdf->Image($host.'graphics/fusion_charts_pdfs/FusionCharts.jpg');
			$this->reportpdf->writeHTML('<br/>Page Width: '.$this->reportpdf->getPageWidth(), true, false, true, false, '');
	        $this->reportpdf->Output('example_001.pdf', 'I');        
			exit(0);
		}
	}

	
	function get_reportgrid_js($rtype) {
		//$columns['QUERY_ID'] = array('ID',40,true,'center',0);
		$columns['TITLE'] = array('Name',200,true,'left',0);
		$columns['SUBTITLE'] = array('Subtitle',180,true,'left',0);
		$columns['QUERYDATE'] = array('Date Prepared',120,true,'left',0);
		$columns['LASTVIEWDATE'] = array('Last Accessed',130, true,'left',0);
		$gridParams = array(
		'width' => 'auto',
		'height' => 200,
		'rp' => 10,
		'rpOptions' => '[10,15,20,25,40]',
		'pagestat' => 'Displaying: {from} to {to} of {total} items.',
		'blockOpacity' => 0.5,
		'showTableToggleBtn' => false
		);
		
		$buttons[] = array('Select All','selectall','DoGridCommand');
		$buttons[] = array('separator');
		$buttons[] = array('Deselect All','deselectall','DoGridCommand');
		$buttons[] = array('separator');
		$buttons[] = array('Open','open','DoGridCommand');
		$buttons[] = array('separator');
		$buttons[] = array('Download','download','DoGridCommand');
		$buttons[] = array('separator');
		$buttons[] = array('Delete','delete','DoGridCommand');

		$grid_js = build_grid_js('reportslist'.$rtype,site_url("/reports/get_reports?rtype=$rtype"),$columns,'QUERY_ID','asc',$gridParams,$buttons);
		return $grid_js."\n";	
	}
	
	function get_reports() {
		$this->load->model('reports_model');
		$this->load->library('flexigrid');
		$rtype = $_REQUEST['rtype'];
		$valid_fields = array('TITLE','SUBTITLE','QUERYDATE','LASTVIEWDATE');
		$this->flexigrid->validate_post('QUERY_ID','asc',$valid_fields);


		$records = $this->reports_model->get_reports($this->session->userdata('uid'), $rtype);
		
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->QUERY_ID,
				$row->TITLE,
				$row->SUBTITLE,
				$row->QUERYDATE,
				$row->LASTVIEWDATE
			);
		}
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
	}

	function tcpdftest() {
        $this->load->library('reportpdf');

        // set document information
        $this->pdf->SetSubject('TCPDF Tutorial');
        $this->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
        // set font
        $this->pdf->SetFont('times', 'BI', 16);
        
        // add a page
        $this->pdf->AddPage();
		
		$html = "<div>Hello World!</div>";
		// output the HTML content
		$this->pdf->writeHTML($html, true, false, true, false, '');
		
		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		
		// reset pointer to the last page
		//$pdf->lastPage();
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		$this->pdf->Output('example_061.pdf', 'I');		
	}
	
	function tcpdf()
    {
        $this->load->library('pdf');

        // set document information
        $this->pdf->SetSubject('TCPDF Tutorial');
        $this->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
        // set font
        $this->pdf->SetFont('times', 'BI', 16);
        
        // add a page
        $this->pdf->AddPage();
        
        // print a line using Cell()
        //$this->pdf->Cell(0, 12, 'Hello World!', 1, 1, 'C');
        $this->pdf->writeHTML('<div>Hello World!</div>');
        //Close and output PDF document
        $this->pdf->Output('example_001.pdf', 'I');        
    }

}
?>
