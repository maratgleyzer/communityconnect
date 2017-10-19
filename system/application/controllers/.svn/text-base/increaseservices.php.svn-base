<?php
class Increaseservices extends CV_Controller {

	var $data = array();
	var $item_categories = array();
	private $allSelection = array(
		'label' => '-- All --',
		'value' => '__all'		
	);

	function __construct () 
	{
		parent::CV_Controller();
        $this->data['pageTitle'] = "Increase Services";
		$this->data['skip_studyarea'] = false;
		$this->load->model("serviceareas_model");
		$this->load->model("block_model");
		$this->load->library('adodb');
		$this->item_categories['A'] = "<i><strong>Adult</strong><i>";
		$this->item_categories['AP'] = "<i>Adult Print</i>";
		$this->item_categories['APF'] = "Adult Print Fiction";
		$this->item_categories['APNF'] = "Adult Print Non-Fiction";
		$this->item_categories['AAV'] = "<i>Adult AV</i>";
		$this->item_categories['AAVG'] = "Adult AV General";
		$this->item_categories['AAVS'] = "Adult AV Specialized";
		$this->item_categories['J'] = "<i><strong>Juvenile</strong></i>";
		$this->item_categories['JP'] = "<i>Juvenile Print</i>";
		$this->item_categories['JPF'] = "Juvenile Print Fiction";
		$this->item_categories['JPNF'] = "Juvenile Print Non-Fiction";
		$this->item_categories['JAV'] = "<i>Juvenile AV</i>";
		$this->item_categories['JAVG'] = "Juvenile AV General";
		$this->item_categories['JAVS'] = "Juvenile AV Specialized";
		$this->item_categories['YA'] = "<i><strong>Young Adult</strong></i>";
		$this->item_categories['YAP'] = "<i>Young Adult Print</i>";
		$this->item_categories['YAAV'] = "<i>Young Adult AV</i>";
		$this->item_categories['O'] = "<i><strong>Other</strong></i>";
		$this->item_categories['OD'] = "Other Days";
		$this->item_categories['OAV'] = "Other AV";
	}

	function index () 
	{
//echo "<pre>"; print_r($_SERVER); exit;
        $data = $this->data;
		$data['extraJS'] = array('reports');
		$data['pageClass'] = "increaseServices";
		$data['currentServiceArea'] = "Whole District";
		$data['data_at_a_glance'] = $this->common->getDataAtAGlance('increase');
		$show_urban_rural = true;
		$data['service_areas'] = $this->common->get_service_areas($show_urban_rural);
       	$data['areas_json'] = $this->common->get_service_areas_json();
       	$data['segments_json'] = $this->get_segments_json();
       	$data['items_json'] = $this->get_items_json();
       	$data['materials_json'] = $this->get_materials_json();
		$data['summary_text'] = '
		Increase Services will help the library better reach existing and prospective customers, optimize its collection, and target marketing efforts. In the <b>Performance</b> tab, you can see a range of statistics to determine which materials/item types are being used by each segment. In the <b>Opportunities</b> tab, you can identify locations to target efforts for increasing usage of specific materials/items types to each segment. '; //In the <b>Marketing</b> tab, you can select a segment that’s successfully using materials and find other, similar segments that have a good chance of being interested in the same services.
	
		//echo "<Pre>"; print_r($data); exit;
		// fields to be sorted in opportunities tab
		$fields = array(
			'opportunities_population' => array(
				'label' => 'Population',
				'class' => '',
				'title' => 'This presents the total number or percent of people for each segment. This shows you the size and relative strength of each segment in terms of its population.'
				),
			'opportunities_new_market' => array(
				'label' => 'Market Potential',
				'class' => '',
				'title' => 'This presents the number or percent of non-patrons for each segment. This shows you the size and relative strength of each segment in terms of its non-patrons. We use non-patrons to characterize the size of the market opportunity.'
				),
			'opportunities_market_share' => array(
				'label' => 'Market Share',
				'class' => '',
				'title' => 'This presents the total number or percent of people for each segment. This shows you the size and relative strength of each segment in terms of its population.'
				),
			'opportunities_userate' => array(
				'label' => 'Use Rate',
				'class' => '',
				'title' => 'This measures the share of checkouts by census block group. It is a useful measure to gauge the relative strength of checkouts by block group.'
				),
			'opportunities_segment' => array(
				'label' => 'Segment',
				'class' => '',
				'title' => 'This displays a list of segments'
				),
		);
		$data['fields'] = $fields;
       	$this->load->view('increaseservices/index', $data);

	}

	function dragdrop()
	{
        $data = $this->data;
		$data['pageClass'] = "increaseServices";
		$data['currentServiceArea'] = "Whole District";
		$data['service_areas'] = $this->serviceareas_model->get_service_areas();
		$data['data_at_a_glance'] = $this->common->getDataAtAGlance('increase');

		//echo "<Pre>"; print_r($data); exit;

        $this->load->view('increaseservices/index2', $data);

	}

	function echoDataAtAGlance() {
		$content = $this->common->getDataAtAGlance('increase');
		echo $content;
	}


			
	/**
	 * Todo. Refactor. Sanitize. Use filter object... this is yuck.
	 */
	
	private function buildSQL() {
		
		$services_choice = $_REQUEST['services_choice'];
		$analysis_level = $_REQUEST['analysis_level'];			
		$data_type_values 	= (isset($_REQUEST['data_variable']) ? $_REQUEST['data_variable'] : "");		
		$startdate 		= (isset($_REQUEST['startdate']) ? date('Y-m-d', strtotime($_REQUEST['startdate'])) : "");
		$enddate		= (isset($_REQUEST['enddate']) ? date('Y-m-d', strtotime($_REQUEST['enddate'])) : "");	
				
		$usesDateRange 	= ('range' == $_REQUEST['checkouts_mode']); 		
		$data_range 	= (isset($_REQUEST['data_range']) ? $_REQUEST['data_range'] : "");		
		$showAllData 	= ('all' == $data_range);		
		$wholeDistrict 	= !isset($_REQUEST['sa']);
		$subDistrict	= false;
		if (isset($_REQUEST['sa']) && ($_REQUEST['sa'] == "__urban" || $_REQUEST['sa'] == "__rural")) {
			$subDistrict	= true;
		}

		
		$columnHeader = 'block.TAPSEGNAM';
		if ($wholeDistrict || $subDistrict) {$columnHeader = 'area.AREA';}

		$filters = array();
		$select = "";
						 			
		if (!$wholeDistrict && !$subDistrict) {
			$sa = ' block.AREA_ID = "'.$_REQUEST['sa'] .'"';
						
			if (count($analysis_level) > 0 && !in_array('__all', $analysis_level)) {
				
				foreach($analysis_level as $key => $value) {
					$analysis_level[$key] = "'$value'";			
					$select_analysis_level[] = "SUM(CASE WHEN block.TAPSEGNAM='$value' THEN block_sum.checkouts ELSE 0 END) AS ".'"'.$value.'"'; 
				}
				$filters[] = "block.TAPSEGNAM IN (" . implode(',', $analysis_level) . ")";		
				$select .= implode(',', $select_analysis_level);
			}
		} elseif (in_array('__all', $analysis_level)) {
	      	$sa = ' block.AREA_ID != ""';
			$service_areas = $this->serviceareas_model->get_service_areas();
			
			foreach ($service_areas as $area)  {
				$areaids[] = "'$area->AREA_ID'";
				$select_analysis_level[] = "SUM(CASE WHEN area.AREA='$area->AREA' THEN block_sum.checkouts ELSE 0 END) AS ".'"'.$area->AREA.'"'; 
			}
			$filters[] = "block.AREA_ID IN (" . implode(',', $areaids) . ")";		
			$select .= implode(',', $select_analysis_level);
		} else {
	      	$sa = ' block.AREA_ID != ""';
	      	
			if (count($analysis_level) > 0 && !in_array('__all', $analysis_level)) {
				$service_areas = $this->serviceareas_model->get_service_areas();
				
				foreach($analysis_level as $key => $value) {
					$area_name = "";
					foreach ($service_areas as $area)  {
						if ($area->AREA_ID == $value) {
							$area_name = $area->AREA;
							break;
						}
					}
					$analysis_level[$key] = "'$value'";			
					$select_analysis_level[] = "SUM(CASE WHEN area.AREA='$area_name' THEN block_sum.checkouts ELSE 0 END) AS ".'"'.$area_name.'"'; 
				}
				$filters[] = "block.AREA_ID IN (" . implode(',', $analysis_level) . ")";		
				$select .= implode(',', $select_analysis_level);
			}
		}
		$select .= ", SUM(block_sum.checkouts) as Total";
		//echo $select; exit;
							
		$filters[] = 'block.BLOCK_ID = block_sum.BLOCK_ID';
		$filters[] = 'area.AREA_ID = block.AREA_ID';
		$filters[] = $sa;
		
		if ($usesDateRange) {
			$filters[] = 'block_sum.CHECKOUT_DATE between "'.$startdate.'" and "'.$enddate.'"';
		}
								
		if ($services_choice == "items_category") {
			foreach($data_type_values as $it) { 
				$item_sql[] = "item.$it = 1";
			}
			$filters[] = "(". implode(' or ', $item_sql). ")";	
			$filters[] = 'block_sum.ITEM_ID = item.ITEM_ID';
			$data_name = "FULL_NAME";
			$data_table = "item";
		
		} elseif ($services_choice == "items_specific") {
			if (count($data_type_values) > 0 && !in_array('__all', $data_type_values)) {
				foreach($data_type_values as $key => $value) {
					$items[$key] = "'$value'";			
				}
				$filters[] = "block_sum.ITEM_ID IN (" . implode(',', $items) . ")";		
			}
			$filters[] = 'block_sum.ITEM_ID = item.ITEM_ID';
			$data_name = "FULL_NAME";
			$data_table = "item";
		} elseif ($services_choice == "materials") {
			if (count($data_type_values) > 0 && !in_array('__all', $data_type_values)) {
				foreach($data_type_values as $key => $value) {
					$materials[$key] = "'$value'";			
				}
				$filters[] = "block_sum.MATERIAL_ID IN (" . implode(',', $materials) . ")";		
			}
			$filters[] = 'block_sum.MATERIAL_ID = material.MATERIAL_ID';
			$filters[] = 'material.MATERIAL not like "zz%"';
			$data_name = "MATERIAL";
			$data_table = "material";
		}
		
		$filter = implode(' and ', $filters);	

		$sql = "
			SELECT $data_name, $select
			FROM block, block_sum, area, $data_table
			WHERE $filter
			GROUP BY $data_name
			";
		//print_r($sql); exit;
		return $sql;
	
	}
		
	/*
	public function renderPerformanceChart() {
		$data = $this->getRenderPerformanceData();
		$chart_data = $this->common->generate_FC_MSColumn2D_chart_json($data);
		echo json_encode($chart_data);
	}
	public function renderPerformanceChartXML() {
		$data = $this->getRenderPerformanceData();
		$xml = $this->generate_chart_xml($data);
		echo $xml;
	}
	public function getRenderPerformanceData() {
		if ('materials' == $_REQUEST['services_choice']) {			
			$sql = $this->buildMaterialSQL();	
		} else {
			$sql = $this->buildItemSQL();
		}
				                  
		$result = $this->adodb->db_handle->Execute($sql);
		
		$results = array();
		$results['success'] = true;

		$data = $this->adodb->pivot2json($result, true);
		print_r($data);
		
		return $data;
	}
	*/



	public function renderPerformance() {
		$sql = $this->buildSQL();
		$datarange 		= $_REQUEST['datarange'];
		$mindata 		= $_REQUEST['mindata'];
		$maxdata 		= $_REQUEST['maxdata'];		
		$number_type	= $_REQUEST['number_type'];		
		$not_applicable = "-";
				                  
		$result = $this->adodb->db_handle->Execute($sql);
		
		$results = array();
		$results['success'] = true;

		$data = $this->adodb->pivot2json($result, true);
		//echo $sql;
		
		$rows = array();
		
		$totals = array();		
		$totals[0] = 'Total';
		$column_count = -1;
		foreach($data as $row) {
			$column_count++;
			if ($row[0] != '') {				
				$rows[] = $row;
				$row_count = 0;
				for($i=1;$i<count($row); $i++) {
					$row_count++;
					if(isset($totals[$i])) {
						if ($row[$i] != $not_applicable) {
						$totals[$i] += $row[$i];	
						}
					} else {
						if ($row[$i] != $not_applicable) {
						$totals[$i] = $row[$i];
						}
					}
				}							
			}
		}		

		
		$rows[] = $totals;
		$chart_data = $this->common->generate_FC_MSColumn2D_chart_json($rows);
		if ('items_specific' == $_REQUEST['services_choice']) {			
			$data = $this->sort_item_results($rows);
		} elseif ('items_category' == $_REQUEST['services_choice']) {			
			$data = $this->sort_item_results($rows, false);
		} else {
			$data = $rows;
		}

		//echo $sql; print_r($data);  exit;
		if ($datarange == 'range' && $number_type == 'number') {
			for ($j = 1; $j < count($data); $j++) {
				if ($data[$j][0] != '') {				
					$new_total = 0;
					$total_index = count($data[$j]) - 1;
					for($i=1;$i<count($data[$j]) - 1; $i++) {
						if (!empty($mindata) && $data[$j][$i] < $mindata) {
							$data[$j][$i] = $not_applicable;
						} elseif (!empty($maxdata) && $data[$j][$i] > $maxdata) {
							$data[$j][$i] = $not_applicable;
						} else {
							$new_total += $data[$j][$i];
						}
					}
					$data[$j][$total_index] = $new_total;
				}
			}
		} elseif ($datarange == "range" && $number_type == "percent") {
			for ($j = 1; $j < count($data); $j++) {
				if ($data[$j][0] != '') {				
					$new_total = 0;
					$total_index = count($data[$j]) - 1;
					for($i=1;$i<count($data[$j]) - 1; $i++) {
						if ($data[$j][$total_index] > 0) {
							$data[$j][$i] = round(($data[$j][$i]/$data[$j][$total_index])*100)."%";
						}
						$new_total += $data[$j][$i];
						if (!empty($mindata) && $data[$j][$i] < $mindata) {
							$data[$j][$i] = $not_applicable;
						} elseif (!empty($maxdata) && $data[$j][$i] > $maxdata) {
							$data[$j][$i] = $not_applicable;
						} 
					}
					$data[$j][$total_index] = $new_total;
				}
			}
		} elseif ($datarange == "all" && $number_type == "percent") {
			for ($j = 1; $j < count($data); $j++) {
				if ($data[$j][0] != '') {				
					$new_total = 0;
					$total_index = count($data[$j]) - 1;
					for($i=1;$i<count($data[$j]) - 1; $i++) {
							$data[$j][$i] = round(($data[$j][$i]/$data[$j][$total_index])*100)."%";
						$new_total += $data[$j][$i];
					}
					$data[$j][$total_index] = $new_total;
				}
			}
		}
		//print_r($data); exit;
		if ($number_type == 'number') {
			for ($j = 1; $j < count($data); $j++) {
				for ($i = 1; $i < count($data[$j]); $i++) {
					if (is_numeric($data[$j][$i])) {
						$data[$j][$i] = number_format($data[$j][$i]);
					}
				}
			}
		}
		
		$results['data'] = $data;  
					
		$result->Close();

		//echo json_encode($results);

		$jdata->table_data = $results;
		$jdata->chart_data = $chart_data;
		$jdata->col_count = $column_count;
		$jdata->row_count = $row_count;
		echo json_encode($jdata);
	}

	private function sort_item_results($data, $show_specific_items = true) 
	{
		$item_categories = $this->item_categories;
		$top_level = array("A", "J");
		$mid_level = array("AP", "AAV", "JP", "JAV", "YA", "O");
		//$item_categories['CONTRACT'] = "Contract";
		$this->load->model("item_types_model");
		$_items = $this->item_types_model->get_item_types();
		$items = array();

		foreach ($_items as $i) {
			foreach (get_object_vars($i) as $key => $value) {
				if ($key == "FULL_NAME") {
					$current_item = $value;
				} else {
				if ($key != "FULL_NAME" && $key != "ITEM_ID" && $value == 1) {
					$items[$key][$current_item] = $value;
				}
				}
			}
		}

		$new_data = array();
		$new_data[0] = $data[0];
		$count_of_areas = count($data[0]) - 1;
		// print grand total
		foreach ($data as $d) {
			if ($d[0] == 'Total') {
				$new_data[1] = $d;
				$new_data[1][0] = "Grand Total";
			}
		}
		$new_data_row = 2;

		foreach ($item_categories as $ic_key => $ic_value) {
			$item_count = 0;
			foreach ($data as $d) {
				if (isset($items[$ic_key][$d[0]])) {
					$item_count++;
				}
			}
			if ($item_count == 1) {
				if ($show_specific_items) {
				foreach ($data as $d) {
					if (isset($items[$ic_key][$d[0]]) && !in_array($ic_key, $mid_level) && !in_array($ic_key, $top_level)) {
						$new_data[$new_data_row] = $d;
						$new_data_row++;
					}
				}
				}
			} elseif ($item_count > 1) {
				$foo = null;
				$foo[0] = $ic_value;
				$part_count = 1;
				for ($part_count = 1; $part_count <= $count_of_areas; $part_count++) { 
					$foo[$part_count] = 0;
					foreach ($data as $d) {
						if (isset($items[$ic_key][$d[0]])) {
							$foo[$part_count] += $d[$part_count];
						}
					}
				}
				$new_data[$new_data_row] = $foo;
				$new_data_row++;
				if ($show_specific_items) {
				foreach ($data as $d) {
					if (isset($items[$ic_key][$d[0]]) && !in_array($ic_key, $mid_level) && !in_array($ic_key, $top_level)) {
						$new_data[$new_data_row] = $d;
						$new_data_row++;
					}
				}
				}
			}
		}
		$data = $new_data;

		return $data;
		/*
		print_r($data);
		print_r($new_data);exit;

		print_r($item_categories);exit;
		print_r($items['APNF']);exit;
		*/
	}

	
	public function getMapDetails() {
				
	}
	
	private function getMaterials() {	
		$this->load->model("material_types_model");
		$material_types = $this->material_types_model->get_material_types();
					
		$results = array();		
		$results[] = $this->allSelection;
		
		foreach ($material_types as $mt) {
			$results[] = array('label' => $mt->MATERIAL, 'value' => $mt->MATERIAL_ID);
		}
		//echo "XX-"; print_r($results);  echo "-XX";
		
		return $results;
	}
	
	private function getSpecificItems() {
		$this->load->model("item_types_model");
		$item_types = $this->item_types_model->get_item_types();
		
		$results = array();		
		$results[] = $this->allSelection;	
		
		foreach ($item_types as $it) {
			$results[] = array('label' => $it->FULL_NAME, 'value' => $it->ITEM_ID);
		}
		
		return $results;		
	}	

	private function get_segments_json() {
        $segments = $this->block_model->get_segments();

        //if ($all) { $results[] = $this->allSelection; }
        foreach ($segments as $sa) {
            $rowData = array();
            $rowData['label'] = $sa->TAPSEGNAM;
            $rowData['value'] = $sa->TAPSEGNAM;
            //$rowData['value'] = $sa->LIFECODE;
            if (isset($sa->AREA_ID)) {
                $rowData['area_id'] = $sa->AREA_ID;
            }
            $results[] = $rowData;
        }
		$areas = $this->serviceareas_model->get_service_areas_by_type("urban");
        foreach ($areas as $sa) {
            $rowData = array();
            $rowData['label'] = $sa->AREA;
            $rowData['value'] = $sa->AREA_ID;
            $rowData['area_id'] = "__urban";
            $results[] = $rowData;
        }
		$areas = $this->serviceareas_model->get_service_areas_by_type("rural");
        foreach ($areas as $sa) {
            $rowData = array();
            $rowData['label'] = $sa->AREA;
            $rowData['value'] = $sa->AREA_ID;
            $rowData['area_id'] = "__rural";
            $results[] = $rowData;
        }
        return json_encode($results);

	}

	static function calculate_median($arr,$key) {
            $count = count($arr); //total numbers in array
            $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
            if($count % 2) { // odd number, middle is the median
                $median = $arr[$middleval][$key];
            } else { // even number, calculate avg of 2 medians
                $low = $arr[$middleval][$key];
                $high = $arr[$middleval+1][$key];
                $median = (($low+$high)/2);
            }
            return array($key=>$median);
        }
 
	private function generate_chart_xml($data) 
	{
		$color = array(
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00",
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00",
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00",
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00",
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00",
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00",
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00",
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00",
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00",
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00",
			"9bb42d", "5e7297", "9932cc", "fafad2", "66cdaa", "1e90ff", "ff8c00"
			);
		$type = $data[0][0];
		$xml = '<?xml version="1.0"?>';
		$xml .= '<chart caption="'.$type.'" showLabels="1" showvalues="1" decimals="0" numberPrefix="" placeValuesInside="1" rotateValues="1">';
		$xml .= "<categories>";
		for ($i = 1; $i < count($data[0]); $i++) {
			if ($data[0][$i] != 'Total') {
				$xml .= '<category label="'.$data[0][$i].'"/>';
			}
		}
		for ($i = 1; $i < count($data); $i++) {
			$xml .= '<dataset seriesName="'.$data[$i][0].'" color="'.$color[$i].'">';
			for ($j = 1; $j < count($data[$i]); $j++) {
				$xml .= '<set value="'.$data[$i][$j].'"/>';
			}
			$xml .= "</dataset>";
		}
		$xml .= "</chart>";
		return $xml;
	}

    function get_materials_json () {
        $this->load->model("material_types_model");
		$materials = $this->material_types_model->get_material_types();

        $results[] = $this->allSelection;
        foreach ($materials as $sa) {
            $rowData = array();
            $rowData['label'] = $sa->MATERIAL;
            $rowData['value'] = $sa->MATERIAL_ID;
            $results[] = $rowData;
        }
        return json_encode($results);
    }

    function get_items_json () {
        $this->load->model("item_types_model");
		$items = $this->item_types_model->get_item_types();

        $results[] = $this->allSelection;
        foreach ($items as $sa) {
            $rowData = array();
            $rowData['label'] = $sa->FULL_NAME;
            $rowData['value'] = $sa->ITEM_ID;
            $results[] = $rowData;
        }
        return json_encode($results);
    }

	public function renderOpportunities() {

/*
$_REQUEST['analysis_level'] = "__all";
$_REQUEST['checkouts_mode'] = "total";
$_REQUEST['datarange'] = "all";
$_REQUEST['number_type'] = "number";
$_REQUEST['sa'] = "Whole_District";
$_REQUEST['services_choice'] = "materials";
*/

		// fetch from browser
		$services_choice = $_REQUEST['services_choice'];
		$analysis_level = $_REQUEST['analysis_level'];			
		//$data_type_values 	= (isset($_REQUEST['data_variable']) ? $_REQUEST['data_variable'] : "");		
		$startdate 		= (isset($_REQUEST['startdate']) ? date('Y-m-d', strtotime($_REQUEST['startdate'])) : "");
		$enddate		= (isset($_REQUEST['enddate']) ? date('Y-m-d', strtotime($_REQUEST['enddate'])) : "");	
		$min 			= (isset($_REQUEST['mindata']) ? $_REQUEST['mindata'] : "");
		$max			= (isset($_REQUEST['maxdata']) ? $_REQUEST['maxdata'] : "");	
		$number_type	= (isset($_REQUEST['number_type']) ? $_REQUEST['number_type'] : "");	
				
		$usesDateRange 	= ('range' == $_REQUEST['checkouts_mode']); 		
		$data_range 	= (isset($_REQUEST['datarange']) ? $_REQUEST['datarange'] : "");		
		$showAllData 	= ('all' == $data_range);		
		$serviceArea 	= $_REQUEST['sa'];
		$field_order_req = (isset($_REQUEST['field_list']) ? $_REQUEST['field_list'] : "");		

		$field_order_list = array();
		if (!empty($field_order_req)) {
			$fol = explode(",", $field_order_req);
			$idx = 4;
			foreach ($fol as $f) {
				if (!empty($f)) {
					$field_order_list[$f] = $idx;
					$idx++;
				}
			}
		}
		

		// fetch data
		if ($services_choice == "materials") {
			$this->load->model("material_types_model");
			$services = $this->material_types_model->get_material_types();
			$id = "MATERIAL_ID";
			$type = "material";
			$title = "All Materials";
			$name = "MATERIAL";
		} else {
			$this->load->model("item_types_model");
			$services = $this->get_categorized_item_types();
			$id = "ids";
			$type = "item";
			$title = "All Items";
			$name = "name";
		}
		$libraries_list = array("Whole_District", "__urban", "__rural");

		$block_group_type = "";
		$the_data = array();
		$the_data[0]->service = $title;
		$the_data[0]->service_id = "all";
		if ($serviceArea == 'Whole_District' && $analysis_level == "__all") {
			$block_group_type = "Service Area";
			$the_data[0]->checkouts = $this->serviceareas_model->get_iso_checkouts();
			$the_data[0]->totals = $this->serviceareas_model->get_iso_totals();
			$i = 1;
			foreach ($services as $srv) {
				$the_data[$i]->service = $srv->$name;
				$the_data[$i]->service_id = $srv->$id;
				$the_data[$i]->checkouts = $this->serviceareas_model->get_iso_checkouts("", $type, $srv->$id);
				$the_data[$i]->totals = $this->serviceareas_model->get_iso_totals("", $type, $srv->$id);
				$i++;
			}
		} elseif (in_array($serviceArea, $libraries_list)  && $analysis_level != "__all") {
			$block_group_type = "Segments";
			$the_data[0]->checkouts = $this->serviceareas_model->get_iso_cos_segments($analysis_level);
			$the_data[0]->totals = $this->serviceareas_model->get_iso_totals($analysis_level);
			$i = 1;
			foreach ($services as $srv) {
				$the_data[$i]->service = $srv->$name;
				$the_data[$i]->service_id = $srv->$id;
				$the_data[$i]->checkouts = $this->serviceareas_model->get_iso_cos_segments($analysis_level, "", $type, $srv->$id);
				$the_data[$i]->totals = $this->serviceareas_model->get_iso_totals($analysis_level, $type, $srv->$id);
				$i++;
			}
		} elseif ($serviceArea != 'Whole_District' && !empty($analysis_level)) {
			$block_group_type = "Block Group";
			$the_data[0]->checkouts = $this->serviceareas_model->get_iso_cos_segments($serviceArea, $analysis_level);
			$the_data[0]->totals = $this->serviceareas_model->get_iso_totals_segments($serviceArea, $analysis_level);
			$i = 1;
			foreach ($services as $srv) {
				$the_data[$i]->service = $srv->$name;
				$the_data[$i]->service_id = $srv->$id;
				$the_data[$i]->checkouts = $this->serviceareas_model->get_iso_cos_segments($serviceArea, $analysis_level, $type, $srv->$id);
				$the_data[$i]->totals = $this->serviceareas_model->get_iso_totals_segments($serviceArea, $analysis_level, $type, $srv->$id);
				$i++;
			}
		}


		$table_array = array();
		foreach ($the_data as $td) {
		//print_r($td); exit;
			$rows_of_data = array();
			$header_row = array();
			$header_row[0] = "Rank";
			$header_row[1] = "Use Potential";
			if ($block_group_type == "Service Area") { 
				$header_row[2] = $block_group_type;
			} else {
				$header_row[2] = "Block Group";
				$this->put_in_row($header_row, "Segment Name", "opportunities_segment", $field_order_list);
				//$header_row[] = "Segment Name";
			}
			$header_row[3] = "Checkouts";
			$this->put_in_row($header_row, "Use Rate", "opportunities_userate", $field_order_list);
			$this->put_in_row($header_row, "Population", "opportunities_population", $field_order_list);
			$this->put_in_row($header_row, "New Market", "opportunities_new_market", $field_order_list);
			$this->put_in_row($header_row, "Market Share", "opportunities_market_share", $field_order_list);
			ksort($header_row);
			$i = 1;
			foreach($td->checkouts as $info) {
				if (intval($td->totals[0]->value) == 0) {
					$use_rate = 0;
				} else {
					$use_rate = sprintf("%.2f", ($info->checkouts/$td->totals[0]->value) * 100); 
				}
				if ($data_range == "range" && $number_type == "number") {
				//echo "we are in range/number and min = $min and co = ".$info->checkouts;
					if (isset($min) && is_numeric($min) && $info->checkouts < $min) {
						continue;
					}
					if (isset($max) && is_numeric($max) && $info->checkouts > $max) {
						continue;
					}
				} elseif ($data_range == "range" && $number_type == "percent") {
					if (isset($min) && $use_rate < $min) continue;
					if (isset($max) && $use_rate > $max) continue;
				}
				
				$row = array();
				if ( $use_rate < 10.0) { 
					$use_potential = "High";
				} elseif ($use_rate >= 10.0 && $use_rate < 20.0) {
					$use_potential = "Medium";
				} else {
					$use_potential = "Low";
				}

				if (is_numeric($info->population) && $info->population > 0) {
					$market_share = sprintf("%.2f%%", ($info->new_market/$info->population) *100);
				} else $market_share = "NA";
				// going to store use rate here for sorting purposes.  this does get overwritten by a ranking value after it has been sorted.
				$row[0] = $use_rate;
				$row[1] = $use_potential;
				if ($block_group_type == "Service Area") { 
					$row[2] = $info->AREA;
				} else {
					$row[2] = $info->BLOCK_ID;
					$this->put_in_row($row, $info->TAPSEGNAM, "opportunities_segment", $field_order_list);
				}
				if ($number_type == "percent") {
					$row[3] = $use_rate."%";
				} else {
					$row[3] = number_format($info->checkouts);
				}
				$this->put_in_row($row, $use_rate, "opportunities_userate", $field_order_list);
				$this->put_in_row($row, number_format($info->population), "opportunities_population", $field_order_list);
				if ($info->population > 0) {
					$this->put_in_row($row, number_format($info->new_market), "opportunities_new_market", $field_order_list);
				} else {
					$this->put_in_row($row, 0, "opportunities_new_market", $field_order_list);
				}
				$this->put_in_row($row, $market_share, "opportunities_market_share", $field_order_list);

				$i++;
				ksort($row);
			// loop through 
				$rows_of_data[] = $row;
			}
			usort($rows_of_data, array(&$this, "cmp_userate"));
			array_unshift($rows_of_data, $header_row);
			$idx = 0;
			foreach ($rows_of_data as $r) {
				if ($idx > 0) {
					$rows_of_data[$idx][0] = $idx;
				} 
				$idx++;
			}
			$table_array[]->data = $rows_of_data;
			
		//	break;
		}

//print_r($table_array); exit;

		$gauges[]->chart = $this->generate_linear_gauge_json($the_data[0]->totals[0]->value, $the_data[0]->totals[0]->value, $title);
		foreach ($services as $srv) {
			foreach ($the_data as $td) {
				if ($td->service_id == $srv->$id) {
					$gauges[]->chart = $this->generate_linear_gauge_json($the_data[0]->totals[0]->value, $td->totals[0]->value, $srv->$name);
				}
			
			}
		}
		$x->table_data = $table_array;
		$x->checkout_ranking = $gauges;

		echo json_encode($x); 
		//print_r($table_array); exit;
	}


	private function generate_linear_gauge_json($total_checkout, $this_checkout, $service) {
		if (empty($total_checkout)) {
			$percent = 0;
		} else {
			$percent = sprintf("%2d", ($this_checkout/$total_checkout)*100);
		}
		$chart->percent = $percent;
		$chart->checkouts = number_format($this_checkout);
		$chart->service = $service;
		return $chart;
	}

	private function cmp_userate($a, $b) {
		// we have stored the userate into the 0th element 
		// it will be replaced with a ranking value after this is called.
		if ($a[0] == $b[0]) return 0;
		return ($a[0] < $b[0]) ? -1 : 1;
	}

	function get_categorized_item_types() {
		$this->load->model("item_types_model");
		$cat_item_types = array();
		$i = 0;
		foreach (array_keys($this->item_categories) as $ic) {
			$its = $this->item_types_model->get_item_types($ic);
//echo "<pre>ic = $ic===><br />";
			$it_ids = array();
			foreach ($its as $it) {
				array_push($it_ids, $it->ITEM_ID);
//echo $it->ITEM."<br />";
			}
			$cat_item_types[$i]->ids = implode(",", $it_ids);
			$cat_item_types[$i]->name = $this->item_categories[$ic];
			$i++;
//print_r($its);
		}
//print_r($cat_item_types);
		return $cat_item_types;

	}
	private function put_in_row(&$header_row, $header_text, $field, $field_order_list) {
		if (isset($field_order_list[$field])) {
			$header_row[$field_order_list[$field]] = $header_text;
		}
	}
	
	
}
?>
