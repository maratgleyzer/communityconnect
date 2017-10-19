<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Common {

	private $allSelection = array(
		'label' => '-- All --',
		'value' => '__all'
	);
	private $ruralSelection = array(
		'label' => '-- All Rural --',
		'value' => '__rural'
	);
	private $urbanSelection = array(
		'label' => '-- All Urban --',
		'value' => '__urban'
	);

	function __construct() {
		$ci = & get_instance();
		$ci->ci_is_loaded[] = 'common';
	}

	function get_service_areas($show_urban_rural = false) {
		if ($show_urban_rural) {
			$urb->AREA_ID = "__urban";
			$urb->AREA = "Urban Libraries"; 
			$urb->TYPE = ""; 
			$sas[] = $urb;
			$rur->AREA_ID = "__rural";
			$rur->AREA = "Rural Libraries"; 
			$rur->TYPE = ""; 
			$sas[] = $rur;
		}
		$ci = & get_instance();
		$ci->load->model("serviceareas_model");
		$service_areas = $ci->serviceareas_model->get_service_areas();

		$excluded= $ci->config->item('excluded_service_areas'); // these have 'no data' per daag
		foreach ($service_areas as $sa) {
			if (in_array($sa->AREA_ID, $excluded)) continue;
			$sas[] = $sa;
		}
		//echo "<Pre>"; print_r($sas); exit;
		return $sas;
	}

	function get_service_areas_json($show_urban_rural = false) {
		$ci = & get_instance();
		$ci->load->model("serviceareas_model");
		$service_areas = $ci->serviceareas_model->get_service_areas();

		$excluded= $ci->config->item('excluded_service_areas'); // these have 'no data' per daag
		$results[] = $this->allSelection;
		if ($show_urban_rural) {
			$results[] = $this->urbanSelection;
			$results[] = $this->ruralSelection;
		}
		foreach ($service_areas as $sa) {
			if (in_array($sa->AREA_ID, $excluded)) continue;
			$rowData = array();
			$rowData['label'] = $sa->AREA;
			$rowData['value'] = $sa->AREA_ID;
			$results[] = $rowData;
		}
		return json_encode($results);
	}

	function get_segments_json($distinct = false, $all = true) {
		$ci = & get_instance();
		$ci->load->model("block_model");
		if (empty($distinct) || !$distinct) {
			$segments = $ci->block_model->get_segments();
		} else {
			$segments = $ci->block_model->get_distinct_segments();
		}

		if ($all) { $results[] = $this->allSelection; }
		foreach ($segments as $sa) {
			$rowData = array();
			$rowData['label'] = $sa->TAPSEGNAM;
			$rowData['value'] = $sa->LIFECODE;
			if (isset($sa->AREA_ID)) {
				$rowData['area_id'] = $sa->AREA_ID;
			}
			$results[] = $rowData;
		}
		return json_encode($results);
	}

	function getDataAtAGlance($page = null) {
		$ci = & get_instance();
		$segment = "";
		if ($ci->input->post('sa')) {
			$area_id = ($ci->input->post('sa') != 'Whole_District')?$ci->input->post('sa'):'';
		}
		elseif ($ci->session->userdata('STUDYAREA')) {
			$area_id = $ci->session->userdata('STUDYAREA');
		} else {
			$area_id = '';
		}
		if ($ci->input->post('sg')) {
			$segment = ($ci->input->post('sg') != '')?$ci->input->post('sg'):'';
		} else {
			$segment = '';
		}
		if ($page == null) {
			$page = ($ci->input->post('page'))?$ci->input->post('page'):'';
		}

		$ci->load->model('block_model');
		$ci->load->model('serviceareas_model');
//echo "area_id = $area_id; segment = $segment -- ".$ci->input->post('sg'); exit;
		$dag_data = $ci->block_model->get_data_at_a_glance($area_id, $segment);
		$service_areas = $ci->serviceareas_model->get_service_areas_without_whole_district();
		// echo '<pre>'; print_r($dag_data);
		$fieldArray = array(
			'basic' => array('pop', 'patrons', 'checkouts', 'market_share', 'avg_patrons', 'patron_potential', 'checkout_potential', 'use_rate'),
			'sa' => array('pop', 'patrons', 'checkouts', 'market_share', 'avg_patrons', 'use_rate', 'patron_potential', 'checkout_potential')
		);
		$pop = array(); //??
		$max = array();
		$median = array();
		$sa_max = array();
		$sa_median = array();
		$districtSegments = array(); // collect and count segments in dist.
		$districtPop = 0;
		$districtPatrons = 0;
		$districtCO = 0;
		$regionPop = 0;
		$regionPatrons = 0;
		$regionCO = 0;
		$sa_data = array();
		$return = array();
		if (is_array($dag_data) && count($dag_data) > 0) {
			$return['has_data'] = true;
			foreach ($dag_data as $row) {
				if (!isset($sa_data[$row->sa])) {
					$sa_data[$row->sa] = array(
						'area' => $row->area,
						'sa' => $row->sa,
						'pop' => 0,
						'patrons' => 0,
						'checkouts' => 0,
						'market_share' => 0,
						'avg_patrons' => 0,
						'use_rate' => 0,
						'patron_potential' => 0,
						'checkout_potential' => 0
					);
				}
				$sa_data[$row->sa]['sa'] = $row->sa;
				$sa_data[$row->sa]['pop'] += $row->totpop;
				$sa_data[$row->sa]['patrons'] += $row->patrons;
				$sa_data[$row->sa]['checkouts'] += $row->checkouts;
				$sa_data[$row->sa]['market_share'] += ( $row->totpop - $row->patrons);
				$districtPop = $row->region_pop;
				$districtPatrons = $row->region_patrons;
				$districtCO = $row->region_co;
				$regionPop += $row->totpop;
				$regionPatrons += $row->patrons;
				$regionCO += $row->checkouts;
				$districtSegments[$row->TAPSEGNAM] = 1;
				$pop[] = array(
					'area' => $row->area,
					'sa' => $row->sa,
					'segname' => $row->TAPSEGNAM,
					'pop' => $row->totpop,
					'patrons' => $row->patrons,
					'checkouts' => $row->checkouts,
					'market_share' => $row->market_share,
					'avg_patrons' => $row->avg_patrons,
					'patron_potential' => $row->patron_potential,
					'checkout_potential' => $row->checkout_potential,
					'use_rate' => $row->use_rate,
					'block_id' => $row->block_id
				);
			}
			foreach ($fieldArray['basic'] as $fld) {
				$key = $fld;
				$tmp = $this->sort_array_of_arrays($pop, $fld, 'block_id');
				$median[$key] = $this->calculate_median($tmp, $key);
				$max[$key] = array('name' => $tmp[count($tmp) - 1]['segname'], 'value' => $tmp[count($tmp) - 1][$key]);
			}
			// post-prosessing on sa data

			if ($regionPop == 0)
				$regionPop = 0.000001;
			if ($regionPatrons == 0)
				$regionPatrons = 0.001;

			if ($districtPop == 0)
				$districtPop = 0.00001;

			if ($districtPatrons == 0)
				$districtPatrons = 0.000001;

			$potential = ((($regionPop / $districtPop) * ($regionPatrons / $regionPop)) + 1);

			foreach ($sa_data as $k => $v) {
				$sa_data[$k]['avg_patrons'] = round($v['checkouts'] / ($v['patrons'] + .0001), 2); // pad for /0 error
				$sa_data[$k]['use_rate'] = round($v['checkouts'] / ($v['pop'] + .0001), 2);
				$sa_data[$k]['patron_potential'] =
						round(100 * ( ($v['pop'] / $districtPop) * ($v['pop'] / ($v['market_share'] + .0001))), 2);
				$sa_data[$k]['checkout_potential'] =
						round(100 * ( ($v['pop'] / $districtPop) * ($v['checkouts'] / ($v['pop'] + .0001))), 2);
			}
			$sa_median = array();
			$sa_max = array();
			$tmp = array();
			foreach ($sa_data as $k => $v) {
				$tmp[] = $v; // convert to non-assoc array so sorting works
			}
			$new = array();
			// print '<pre>'; print_r($tmp);
			foreach ($fieldArray['sa'] as $fld) {
				$new = $this->sort_array_of_arrays($tmp, $fld, 'sa');
				$sa_median[$fld] = $this->calculate_median($new, $fld);
				$sa_max[$fld] = array('name' => $new[count($new) - 1]['area'], 'value' => $new[count($new) - 1][$fld]);
			}
			$results = array(// key = Name, value = array(page/s | section index | show on sa/whole/both | cell 2 | cell 3 | cell 4)
				/* BASIC STATS */
				'Population'
				=> array(array('model', 'find',  'literacy',  'increase'), 0, 'both', number_format($regionPop), $this->percent($regionPop / $districtPop), ''),
				'Patrons'
				=> array(array('model', 'find',  'literacy',  'increase'), 0, 'both', number_format($regionPatrons), $this->percent($regionPatrons / $districtPatrons), ''),
				'Checkouts'
				=> array(array('model', 'find',  'literacy',  'increase'), 0, 'both', number_format($regionCO), '', ''),
				'Market Share'
				=> array(array('model', 'find', 'literacy',  'increase'), 0, 'both', number_format($regionPop - $regionPatrons), $this->percent(($regionPop - $regionPatrons) / $regionPop), ''),
				'Average Checkouts per Patron'
				=> array(array('model', 'find', 'literacy',  'increase'), 0, 'both', round($regionCO / $regionPatrons, 2), '', ''),
				'Use Rate'
				=> array(array('model', 'find', 'literacy',  'increase'), 0, 'both', round($regionPop / $regionPatrons, 2), '', ''),
				/* BASIC STATS ABOUT SEGMENTS */
				'Number of Segments'
				=> array(array('find', 'literacy',  'increase'), 1, 'whole', count($districtSegments), '', ''),
				'Segment with the Highest Population'
				=> array(array('find', 'literacy',  'increase'), 1, 'both', number_format($max['pop']['value']), $this->percent($max['pop']['value'] / $regionPop), $max['pop']['name']),
				'Segment with Highest Number of Patrons'
				=> array(array('find', 'literacy'), 1, 'both', number_format($max['patrons']['value']), $this->percent($max['patrons']['value'] / $regionPatrons), $max['patrons']['name']),
				'Segment with Highest Number of Checkouts'
				=> array(array('find', 'literacy'), 1, 'sa', number_format($max['checkouts']['value']), $this->percent($max['checkouts']['value'] / $regionCO), $max['patrons']['name']),
				'Segment with the Highest Market Share'
				=> array(array('find', 'literacy'), 1, 'both', number_format($max['market_share']['value']), '', $max['market_share']['name']),
				'Segment with Highest Average Checkout per Patron'
				=> array(array('find', 'literacy'), 1, 'sa', number_format($max['avg_patrons']['value'], 1), '', $max['avg_patrons']['name']),
				'Segment with Highest Use Rate'
				=> array(array('find', 'literacy'), 1, 'sa', number_format($max['use_rate']['value'], 1), '', $max['use_rate']['name']),
				'Segment with the Highest Patron Potential'
				=> array(array('find', 'literacy'), 1, 'both', number_format($max['patron_potential']['value'], 2), '', $max['patron_potential']['name']),
				'Segment with Highest Checkout Potential'
				=> array(array('find', 'literacy'), 1, 'sa', number_format($max['checkout_potential']['value'], 2), '', $max['checkout_potential']['name']),
				/* MEDIAN STATS ABOUT SEGMENTS */
				'Median Population by Segment'
				=> array(array('find', 'literacy'), 2, 'both', number_format($median['pop']['value']), '', ''),
				'Median Patrons by Segment'
				=> array(array('find', 'literacy'), 2, 'both', number_format($median['patrons']['value']), '', ''),
				'Median Checkouts by Segment'
				=> array(array('find', 'literacy'), 2, 'sa', number_format($median['checkouts']['value']), '', ''),
				'Median Market Share Rate by Segment'
				=> array(array('find', 'literacy'), 2, 'both', number_format($median['market_share']['value'], 2), '', ''),
				'Median Average Number of Checkouts per Patron by Segment'
				=> array(array('find', 'literacy'), 2, 'sa', number_format($median['avg_patrons']['value']), '', ''),
				'Median Use Rate by Segment'
				=> array(array('find', 'literacy'), 2, 'sa', number_format($median['use_rate']['value']), '', ''),
				'Median Patron Potential by Segment'
				=> array(array('find', 'literacy'), 2, 'both', number_format($median['patron_potential']['value'], 2), '', ''),
				'Median Checkout Potential by Segment'
				=> array(array('find', 'literacy'), 2, 'sa', number_format($median['checkout_potential']['value']), '', ''),
				/* BASIC STATS ABOUT SERVICE AREAS */
				'Number of Service Areas'
				=> array(array('find', 'literacy',  'increase'), 3, 'whole', count($service_areas), '', ''),
				'Number of Library Outlets'
				=> array(array('find', 'literacy',  'increase'), 3, 'whole', count($service_areas), '', ''), // SAME AS ABOVE!
				'Service Area with the Highest Population'
				=> array(array('find', 'literacy'), 3, 'whole', number_format($sa_max['pop']['value']), '', $sa_max['pop']['name']),
				'Service Area with the Highest Number of Patrons'
				=> array(array('find', 'literacy'), 3, 'whole', number_format($sa_max['patrons']['value']), '', $sa_max['patrons']['name']),
				'Service Area with the Highest Number of Checkouts'
				=> array(array('increase'), 3, 'whole', number_format($sa_max['checkouts']['value']), '', $sa_max['checkouts']['name']),
				'Service Area with the Highest Market Share'
				=> array(array('find', 'literacy'), 3, 'whole', number_format($sa_max['market_share']['value']), '', $sa_max['market_share']['name']),
				'Service Area with the Highest Average Checkouts per Patron'
				=> array(array('increase'), 3, 'whole', number_format($sa_max['avg_patrons']['value']), '', $sa_max['avg_patrons']['name']),
				'Service Area with the Highest Use Rate'
				=> array(array('increase'), 3, 'whole', number_format($sa_max['use_rate']['value']), '', $sa_max['use_rate']['name']),
				'Service Area with the Highest Patron Potential'
				=> array(array('find', 'literacy'), 3, 'whole', number_format($sa_max['patron_potential']['value']), '', $sa_max['patron_potential']['name']),
				'Service Area with the Highest Checkout Potential'
				=> array(array('increase'), 3, 'whole', number_format($sa_max['checkout_potential']['value']), '', $sa_max['checkout_potential']['name']),
				/* MEDIAN STATS ABOUT SERVICE AREAS */
				'Median Population by Service Area'
				=> array(array('find', 'literacy'), 4, 'whole', number_format($sa_median['pop']['value']), '', ''),
				'Median Patrons by Service Area'
				=> array(array('find', 'literacy'), 4, 'whole', number_format($sa_median['patrons']['value']), '', ''),
				'Median Open Market Rate by Service Area'
				=> array(array('find', 'literacy'), 4, 'whole', number_format($sa_median['market_share']['value']), '', ''),
				'Median Patron Potential by Service Area'
				=> array(array('find', 'literacy'), 4, 'whole', number_format($sa_median['patron_potential']['value']), '', ''),
			);

			$sections = array(
				0 => array('Basic Stats', 'both'),
				1 => array('Basic Stats about Segments', 'both'),
				2 => array('Median Stats about Segments', 'both'),
				3 => array('Basic Stats about Service Areas', 'whole'),
				4 => array('Median Stats about Service Areas', 'whole')
			);

			$dg = '<table width="100%">';
			$i = 0;
			$header = $sections[0][0];
			$prev_header = '';
			foreach ($results as $key => $value) {

				if ($page != 'compare')
					if ($page && !in_array($page, $value[0])) {
						continue;
					} elseif ($area_id == '' && $value[2] == 'sa') {
						continue;
					} elseif ($area_id != '' && $value[2] == 'whole') {
						continue;
					}
				if ($i == 0 || $header != $sections[$value[1]][0]) {
					if ($area_id == '' || $sections[$value[1]][1] == 'both') {
						$header = $sections[$value[1]][0];
						$dg .= '<tr class="header">';
						$dg .= '<td colspan="4">' . $header . '</td>';
						$dg .= '</tr>';
					}
				}
				$class = ($i % 2) ? '' : 'odd';
				++$i;
				if (($key == 'Population' || $key == 'Patrons') && $value[3] == '100%')
					$value[3] = '';
				$dg .= '<tr class="' . $class . '">
					<th>' . $key . '</th>
					<td class="text-right">' . $value[3] . '</td>
					<td class="text-right">' . $value[4] . '</td>
					<td>' . $value[5] . '</td>
					</tr>';
			}
			$dg .= '</table>';
		}
		else {
			$dg = '<table>';
			$dg .= '<tr> <th>No Data Available</th> </tr>';
			$dg .= '</table>';
			$return['has_data'] = false;
		}
		$return['table'] = $dg;
		return $return;
	}

	static function calculate_median($arr, $key) {
		$count = count($arr); //total numbers in array
		$middleval = floor(($count - 1) / 2); // find the middle value, or the lowest middle value
		if ($count % 2) { // odd number, middle is the median
			$median = $arr[$middleval][$key];
		} else { // even number, calculate avg of 2 medians
			$low = $arr[$middleval][$key];
			$high = $arr[$middleval + 1][$key];
			$median = (($low + $high) / 2);
		}
		// capture name so we can populate rows - segments/SAs 
		$name = isset($arr[$middleval]['segname']) ? $arr[$middleval]['segname'] : $arr[$middleval]['area'];
		return array('name' => $name, 'value' => $median);
	}

	function median() {
		$args = func_get_args();
		switch (func_num_args ()) {
			case 0:
				trigger_error('median() requires at least one parameter', E_USER_WARNING);
				return false;
				break;

			case 1:
				$args = array_pop($args);
			// fallthrough

			default:
				if (!is_array($args)) {
					trigger_error('median() requires a list of numbers to operate on or an array of numbers', E_USER_NOTICE);
					return false;
				}
				sort($args);
				$n = count($args);
				$h = intval($n / 2);
				if ($n % 2 == 0) {
					$median = ($args[$h] + $args[$h - 1]) / 2;
				}
				else {
					$median = $args[$h];
				}
				break;
		}
		return $median;
	}

	function percent($num, $decimals = 1) {
		if ($num == 1)
			return '100%';
		return number_format(100 * $num, $decimals) . '%';
	}

	function sort_array_of_arrays($ARRAY, $sortby_index, $key_index) {
		// *** NOTES
		/*
		  requires array of associative arrays -- not checked within array
		 */

		// *** DATA
		# order array
		$ORDERING = array();

		# return
		$SORTED = array();

		# internal
		$_DATA = array();
		$_key = '';
		$_sort_col_val = '';
		$_i = 0;


		// *** MANIPULATE
		# get ordering array
		foreach ($ARRAY as $_DATA) {
			$_key = $_DATA[$key_index];
			$ORDERING[$_key] = $_DATA[$sortby_index];
		}

		# sort ordering array
		asort($ORDERING);
		# DEBUG
		#trigger_notice($ORDERING);
		# map ARRAY back to ordering array
		foreach ($ORDERING as $_key => $_sort_col_val) {
			# get index for ARRAY where ARRAY[][$key_index] == $_key
			foreach ($ARRAY as $_i => $_DATA) {
				if ($_key == $_DATA[$key_index]) {
					$SORTED[] = $ARRAY[$_i];
					continue;
				}
			}
		}
		// *** RETURN
		return $SORTED;
	}


	function FIND_CUSTOMERS_generate_FC_MSColumn2D_chart_json($fields, $data) {
		//print_r($data); exit;
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
		$xml = '<chart caption="" showLabels="1" showvalues="1" decimals="2" numberPrefix=
"" placeValuesInside="1" rotateValues="1">';
		$chart->caption = '';
		$chart->showLabels = "1";
		$chart->rotateLabels = "1";
	//	$chart->slantLabels = "1";
		$chart->showValues = "0";
		$chart->rotateValues = "1";
		$chart->decimals = "2";
		$chart->numberPrefix = '';
		$chart->placeValuesInside = "1";
		$chart->exportEnabled = "1";
		$chart->exportHandler = "/js/fusioncharts/FusionCharts_Website/ExportHandlers/PHP/FCExporter.php";
		$chart->exportAtClient = "0";
		//$chart->exportShowMenuItem = "0";
		//$chart->showExportDialog = "0";
		$chart->exportAction = "save";
		$chart->exportCallback = 'fc_export_callback';
		$jo->chart = $chart;

		$categories = array();
		$dataset = array();
		$color_cnt = 0;
		foreach ($data as $key => $vals) {
			$categories['category'][] = array('label'=>ucfirst($key));
			$cnt = 0;
			foreach ($vals as $v) {
				if (!isset($dataset[$cnt]['seriesname']))
					$dataset[$cnt]['seriesname'] = $this->split_and_cap($fields[$cnt],'_');
				$dataset[$cnt]['data'][] = array('value'=>$v);
				if (!isset($dataset[$cnt]['color']))
					$dataset[$cnt]['color'] = $color[$color_cnt];
				++$cnt;
				++$color_cnt;
			}
		}
		if (isset($dataset)) {
			$jo->dataset = $dataset;
		}
		if (isset($categories)) {
			$jo->categories = $categories;
		}
		//print_r($data); print_r($jo); exit;
		return $jo;
	}

	function FIND_LITERACY_generate_FC_MSColumn2D_chart_json($data, $patron_data, $nonpatron_data) {
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
		$xml = '<chart caption="" showLabels="1" showvalues="1" decimals="2" numberPrefix=
"" placeValuesInside="1" rotateValues="1">';
		$chart->caption = '';
		$chart->showLabels = "1";
		$chart->rotateLabels = "1";
	//	$chart->slantLabels = "1";
		$chart->showValues = "0";
		$chart->rotateValues = "1";
		$chart->decimals = "2";
		$chart->numberPrefix = '';
		$chart->placeValuesInside = "1";
		$chart->exportEnabled = "1";
		$chart->exportHandler = "/js/fusioncharts/FusionCharts_Website/ExportHandlers/PHP/FCExporter.php";
		$chart->exportAtClient = "0";
		//$chart->exportShowMenuItem = "0";
		//$chart->showExportDialog = "0";
		$chart->exportAction = "save";
		$chart->exportCallback = 'fc_export_callback';
		$jo->chart = $chart;

        $categories = array();
        $dataset = array();
        for($i=0;$i<sizeof($data);$i++){
            $dataset[0]['seriesname'] = array('label'=>'Population');
            $dataset[1]['seriesname'] = array('label'=>'Patron');
            $dataset[2]['seriesname'] = array('label'=>'Non-Patron');
            $categories['category'][] = array('label'=>ucfirst($data[$i]->TAPSEGNAM));
            $dataset[0]["data"][] = array('value'=>$data[$i]->TOTPOP_CY);
            $dataset[1]["data"][] = array('value'=>$patron_data[$i]);
            $dataset[2]["data"][] = array('value'=>$nonpatron_data[$i]);
        }
        if (isset($dataset)) {
            $jo->dataset = $dataset;
        }
        if (isset($categories)) {
            $jo->categories = $categories;
        }
        //print_r($data); print_r($jo); exit;
        return $jo;
	}


	function generate_FC_MSColumn2D_chart_json($data) {
		//print_r($data); exit;
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
		$xml = '<chart caption="' . $type . '" showLabels="1" showvalues="1" decimals="2" numberPrefix=
"" placeValuesInside="1" rotateValues="1">';
		$chart->caption = "$type";
		$chart->showLabels = "1";
		$chart->showvalues = "1";
		$chart->decimals = "2";
		$chart->numberPrefix = '';
		$chart->placeValuesInside = "1";
		$chart->rotateValues = "1";
		$chart->exportEnabled = "1";
		$chart->exportHandler = "/js/fusioncharts/FusionCharts_Website/ExportHandlers/PHP/FCExporter.php";
		$chart->exportAtClient = "0";
		//$chart->exportShowMenuItem = "0";
		//$chart->showExportDialog = "0";
		$chart->exportAction = "save";
		$chart->exportCallback = 'fc_export_callback';
		$jo->chart = $chart;


		$cnt = 0;
		for ($i = 1; $i < count($data[0]); $i++) {
			if ($data[0][$i] != 'Total') {
				$catinfo[$cnt]->label = $data[0][$i];
				$categories[$cnt]->category = $catinfo[$cnt];
				$cnt++;
			}
		}
		if (isset($categories)) {
			$jo->categories = $categories;
		}

		$cnt = 0;
		for ($i = 1; $i < count($data); $i++) {
			$dataset[$cnt]->seriesName = $data[$i][0];
			$dataset[$cnt]->color = $color[$i];
			$jcnt = 0;
			for ($j = 1; $j < count($data[$i]) - 1; $j++) {
				$data_bit[$cnt][$jcnt]->value = $data[$i][$j];
				$data_bit[$cnt][$jcnt]->category_name = $categories[$j - 1]->category->label;
				$jcnt++;
			}
			$dataset[$cnt]->data = $data_bit[$cnt];
			$cnt++;
		}
		if (isset($dataset)) {
			$jo->dataset = $dataset;
		}
		//print_r($data); print_r($jo); exit;
		return $jo;
	}

	function split_and_cap($string, $delimiter = null) {
		$tmp = array($delimiter);
		if (!$delimiter) {
			$tmp = array('_','-','|');
		}
		foreach ($tmp as $d) {
			$string = preg_replace("/$d/",' ',$string);
		}
		if (preg_match('/\s/', $string)) {
			$str = ucwords($string);
		}
		else {
			$str = ucfirst($string);
		}
		return $str;
	}

	/* @params
	 * $data = array of arrays, per $array[AREA_ID][STATISTIC] (STATISTIC = 'population', 'patrons', 'median population', segment name, block group, etc..)
	 * $data_title = for charting, and map legend, a title for this data (eg. 'Service Area - Population')
	 * $calc_total = for certain data displays, a flag to count totals or not, default true
	 */
	function convert_data_to_common_structure($data=array(),$data_title="",$calc_total=true) {
		// set first member of first array to the chart title
		$result[0][0] = $data_title;
		
		// iterate through the data array of arrays
		foreach ($data as $area => $dataset) {
			// set the next member of the first array to the area name
			settype($area,"string");
			$result[0][] = $area;
			// add the data as values to succeeding array members
			foreach ($dataset as $key => $value) {
				// are we in a new dataset?
				$addkey = true;
//				$value = preg_replace('/[\"\'\,]+/i','',$value);
//				if (($key != "Segment")	&& ($key != "Service Area"))
//					settype(rtrim(ltrim($value)),"float");
				for ($i = 0; $i < count($result); ++$i) {
					if ($result[$i][0] == $this->split_and_cap($key, '_')) {
						if (is_numeric($value) && $value > 999) {
							$value = number_format($value);
						}
						$result[$i][] = $value;
						$addkey = false;
					}
				}
				// if we are, then add that dataset's name as the first member of a new array
				// and add the data value of the preceeding data row as that member value
				if ($addkey) {
					$result[$i][0] = $this->split_and_cap($key, '_');
					if (is_numeric($value) && $value > 999) {
						$value = number_format($value);
					}
					$result[$i][] = $value;
				}
			}
		}

		// calculate totals for each dataset array
		if ($calc_total) {
			for ($i = 1; $i < count($result); ++$i) {
				$total = 0;
				for ($j = 1; $j < count($result[$i]); ++$j)
					$total += preg_replace('/,/','',$result[$i][$j]);
				$result[$i][] = number_format($total);
			}
			$result[0][] = "Total";
		}
		// we still need a 'total' member for each array, even if totals weren't calculated
		// charts are fickle
		else {
			for ($i = 1; $i < count($result); ++$i)
				$result[$i][] = 0;
			$result[0][] = "Total";
		}
		return $result;
	}
	
	public function tool_tip($tip_text, $print_text = null, $extraclass = null, $id = null) {
		if (!$id) $id = time() . rand(0,100); // not sure if this is required.
		if (!$print_text) $print_text = 'tip';
		return '<span class="tip '.$extraclass.'" title="'.htmlspecialchars($tip_text).'" id="tip_'.$id.'">'.$print_text.'</span>';
	}
}

?>
