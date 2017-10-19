<?php

class Findcustomers extends CV_Controller {

	var $data = array();
	private $allSelection = array(
		'label' => '-- All --',
		'value' => '__all'
	);

	function __construct() {
		parent::CV_Controller();
		$this->data['pageTitle'] = "Find Customers";
		$this->data['pageClass'] = "findCustomers";
		$this->data['skip_studyarea'] = false;
		$this->load->model("serviceareas_model");
		$this->load->library('adodb');
	}


	function index() {
		$data = $this->data;
		$data['extraJS'] = array('reports');
		$data['currentServiceArea'] = "Whole District";
		$data['service_areas'] = $this->serviceareas_model->get_service_areas();
		$data['data_at_a_glance'] = $this->common->getDataAtAGlance('find');
		$data['has_data'] = $data['data_at_a_glance']['has_data'];
		$data['summary_text'] = 'Finding new customers will help the library strengthen 
			communities, increase return on investment, and build political support.
			Information provided in this section pin-points where to find new customers.
			In the <strong>Summary</strong> tab, you can see a range of statistics by segment.
			In the <strong>Opportunities</strong> tab, you can identify locations to target
			efforts for increasing the number of patrons.';
		$this->load->view('findcustomers/index', $data);
	}
	function ajax_summary() {
		$this->load->model('block_model');
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$format = $this->input->post('format');
		$sa = $this->input->post('sa');
		if ($sa == 'Whole_District' || $sa == '')
			$sa = null;
		$segments = $this->block_model->get_segments_by_sa($sa);
		$area_checkouts = $this->serviceareas_model->getSACheckouts($sa);
		$fields = $this->input->post('fields');
		$out = array();
		$totals = array();
		foreach ($fields as $f) { // iterating through maintains the user's order.
			switch (strtolower($f)) {
				case('population'):
					$rows = $this->block_model->getSegmentPopulation($sa);
					foreach ($segments as $s) {
						foreach ($rows as $r) {
							if ($r->segment == $s->TAPSEGNAM) {
								$totals['population'][] = $r->population;
								$out[$r->segment]['population'] = $r->population;
								break;
							}
						}
					}
					break;
				case ('patrons'):
					$rows = $this->block_model->getSegmentPatrons($sa);
					foreach ($segments as $s) {
						foreach ($rows as $r) {
							if ($r->segment == $s->TAPSEGNAM) {
								$totals['patrons'][] = $r->patrons;
								$out[$r->segment]['patrons'] = $r->patrons;
								break;
							}
						}
					}
					break;
				case ('checkouts'):
					$rows = $this->block_model->getSegmentCheckouts($sa, $start, $end);
					foreach ($segments as $s) {
						foreach ($rows as $r) {
							if ($r->segment == $s->TAPSEGNAM) {
								$totals['checkouts'][] = $r->checkouts;
								$out[$r->segment]['checkouts'] = $r->checkouts;
								break;
							}
						}
					}
					break;
				case ('market_share'):
					$rows = $this->block_model->getSegmentMarketShare($sa);
					foreach ($segments as $s) {
						foreach ($rows as $r) {
							if ($r->segment == $s->TAPSEGNAM) {
								$totals['market_share'][] = $r->market_share; // store as array to find median
								$out[$r->segment]['market_share'] = $r->market_share;
								break;
							}
						}
					}
					break;
				case ('market_potential'):
					$rows = $this->block_model->getSegmentMarketPotential($sa);
					foreach ($segments as $s) {
						foreach ($rows as $r) {
							if ($r->segment == $s->TAPSEGNAM) {
								$totals['market_potential'][] = $r->market_potential;
								$out[$r->segment]['market_potential'] = $r->market_potential;
								break;
							}
						}
					}
					break;
				case ('patron_potential'):
					$rows = $this->block_model->getSegmentMarketPotential($sa);
					foreach ($segments as $s) {
						foreach ($rows as $r) {
							if ($r->segment == $s->TAPSEGNAM) {
								$totals['patron_potential'][] = $r->patron_potential;
								$out[$r->segment]['patron_potential'] = $r->patron_potential;
								break;
							}
						}
					}
					break;
				case ('checkout_potential'):
					$rows = $this->block_model->getSegmentCheckouts($sa);
					foreach ($segments as $s) {
						foreach ($rows as $r) {
							if ($r->segment == $s->TAPSEGNAM) {
								$co_potential = round(($r->checkouts / $area_checkouts), 3);
								$totals['checkout_potential'][] = $co_potential;
								$out[$r->segment]['checkout_potential'] = $co_potential;
								break;
							}
						}
					}
					break;
			}
		}
		$foot = array(); // footer content, also used for calculating % if that is selected
		foreach ($totals as $key => $values) {
			$median = $this->common->median($values);
			if ($key == 'market_share') {
				$foot['Median'][] = $this->common->percent($median);
			} else {
				$decimals = ($median < 10) ? 2 : 0;
				$foot['Median'][] = number_format($median, $decimals);
			}
			if (!preg_match('/potential|market_share/', $key)) {
				$total = 0;
				foreach ($values as $v) {
					$total += $v;
				}
				$foot['Total'][] = $total;
			} else {
				$foot['Total'][] = '';
			}
		}
		// assemble header
		$thead = '<table class="pivot tableSorter"><thead><tr class="header"><th>Segment Name</th>';
		foreach ($fields as $f) {
			$f = $this->common->split_and_cap($f, '_');
			$thead .= '<th style="white-space:nowrap;">' . $f . '</th>';
		}
		$thead .= '</tr></thead>';
		$tbody = $this->get_tbody_content($out, $fields, $format, $foot);
		$tfoot = $this->get_tfoot_content($foot, count($out), $fields);
		$chart_data = $this->common->FIND_CUSTOMERS_generate_FC_MSColumn2D_chart_json($fields, $out);
		$return->chart = $chart_data;
		$return->table = $thead . $tbody . $tfoot;
		$return->common = $this->common->convert_data_to_common_structure($out,$data_title="Segment Name",$calc_total=true);
		$json = json_encode($return);
		echo $json;
	}

	function ajax_opportunities() {
		$this->load->model('block_model');
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$format = $this->input->post('format');
		$sa = $this->input->post('sa');
		$sas = $this->serviceareas_model->get_service_areas_without_whole_district();
		$this->load->model('checkout_sum_model');
		if ($sa == 'Whole_District' || $sa == '') {
			$sa = null;
			$tmp = array();
			foreach ($sas as $s) {
				$tmp[] = '"'.$s->AREA_ID.'"';
			}
			$areas = implode(',',$tmp);
			// $data = $this->checkout_sum_model->getSummaryProfileData($areas,$start,$end);
			$data = $this->serviceareas_model->getSAData($start, $end);
		}
		else {
			$areas = "'$sa'";
			// $data = $this->checkout_sum_model->getBlockProfileData($areas,$start,$end);
			$data = $this->block_model->getBlockDataForArea($sa);
		}
		$segments = $this->block_model->get_segments_by_sa($sa);
		$segment_checkouts = $this->block_model->getSegmentCheckouts($sa);
		$fields = $this->input->post('fields');
		$out = array();
		foreach ($fields as $f) { // iterating through maintains the user's order.
			switch (strtolower($f)) {
				case('population'):
					foreach ($data as $r) {
						$totals['population'][] = $r->population;
						if ($sa == null) {
							$out[$r->AREA]['population'] = $r->population;
						}
						else {
							$out[$r->BLOCK_ID]['population'] = $r->population;
						}
					}
					break;
				case ('market_potential'):
					foreach ($data as $r) {
						$totals['market_potential'][] = $r->market_potential;
						if ($sa == null) {
							$out[$r->AREA]['market_potential'] = $r->market_potential;
						}
						else {
							$out[$r->BLOCK_ID]['market_potential'] = $r->market_potential;
						}
					}
					break;
				case ('checkouts'):
					foreach ($data as $r) {
						$totals['checkouts'][] = $r->checkouts;
						if ($sa == null) {
							$out[$r->AREA]['checkouts'] = $r->checkouts;
						}
						else {
							$out[$r->BLOCK_ID]['checkouts'] = $r->checkouts;
						}
					}
					break;
				case ('market_share'):
					foreach ($data as $r) {
						$totals['market_share'][] = $r->market_share;
						if ($sa == null) {
							$out[$r->AREA]['market_share'] = $r->market_share;
						}
						else {
							$out[$r->BLOCK_ID]['market_share'] = $r->market_share;
						}
					}
					break;
				case ('patron_potential'):
					foreach ($data as $r) {
						$totals['patron_potential'][] = $r->patron_potential;
						if ($sa == null) {
							$out[$r->AREA]['patron_potential'] = $r->patron_potential;
						}
						else {
							$out[$r->BLOCK_ID]['patron_potential'] = $r->patron_potential;
						}
					}
					break;
				case ('checkout_pot'):
					foreach ($data as $r) {
						if ($sa == null) {
							$whole_checkouts = 0;
							foreach($segment_checkouts as $sc) {
								$whole_checkouts += $sc->checkouts;
							}
							$co_pot = round(($r->checkouts/$whole_checkouts), 2);
							$out[$r->AREA]['checkout_potential'] = $co_pot;
						}
						else {
							foreach($segment_checkouts as $sc) {
								if ($sc->segment == $r->TAPSEGNAM) {
									$co_pot = round(($r->checkouts/$sc->checkouts), 2);
								}
							}
							$out[$r->BLOCK_ID]['checkout_potential'] = $co_pot;
						}
						$totals['checkout_potential'][] = $co_pot;
					}
					break;
				case ('segments'):
					foreach ($data as $r) {
						$totals['segments'][$r->TAPSEGNAM] = 1;
						$out[$r->BLOCK_ID]['segments'] = $r->TAPSEGNAM;
					}
					break;
			}
		}
		if (!$totals) {
			echo '<h3>No data to display.</h3>';
			exit;
		}
		$foot = array(); // footer content, also used for calculating % if that is selected
		foreach ($totals as $key => $values) {
			$median = $this->common->median($values);
			if ($key == 'market_share') {
				$foot['Median'][] = $this->common->percent($median);
			}
			elseif (preg_match('/segment|block/',$key)) {
				$foot['Median'][] = '';
			}
			else {
				$decimals = ($median < 10) ? 2 : 0;
				$foot['Median'][] = number_format($median, $decimals);
			}
			if (!preg_match('/potential|market_share/', $key)) {
				$total = 0;
				foreach ($values as $v) {
					$total += $v;
					// if ($key == 'population') echo " + $v ";
				}
				$foot['Total'][] = $total;
			} 
			elseif (preg_match('/segment|block|section/',$key)) {
				$foot['Total'][] = count($values);
			}
			else {
				$foot['Total'][] = '';
			}
		}
		// assemble header
		$thead = '<table class="pivot tableSorter"><thead><tr class="header">';
		if ($sa == null) {
			$title = 'Service Area';
			$thead .= '<th>Service Area</th>';
		}
		else {
			$title = 'Block Group';
			$thead .= '<th>Block Group</th>';
		}
		foreach ($fields as $f) {
			$f = $this->common->split_and_cap($f, '_');
			$thead .= '<th style="white-space:nowrap;">' . $f . '</th>';
		}
		$thead .= '</tr></thead>';
		$tbody = $this->get_tbody_content($out, $fields, $format, $foot);
		$tfoot = $this->get_tfoot_content($foot, count($out), $fields);
		$chart_data = $this->common->FIND_CUSTOMERS_generate_FC_MSColumn2D_chart_json($fields, $out);
		$return->chart = $chart_data;
		$return->table = $thead . $tbody . $tfoot;
		$return->common = $this->common->convert_data_to_common_structure($out,$data_title=$title,$calc_total=true);
		echo json_encode($return);
	}

	private function get_tbody_content($out, $fields, $format, $foot) {
		$tbody = '<tbody>';
		foreach ($out as $th => $values) {
			$tbody .= '<tr><th>' . $th . '</th>';
			$tds = 0;
			foreach ($values as $key => $v) {
				if ($format == 'percent' && is_int($foot['Total'][$tds])) { // prevent division by zero errors
					$print = $this->common->percent($v / $foot['Total'][$tds], 1);
				}
				elseif ($key == 'market_share') {
					$print = $this->common->percent($v, 1); // always expressed as %
				}
				else {
					$print = ($v > 999) ? number_format($v) : $v;
				}
				$tbody .= '<td class="text-right">' . $print . '</td>';
				++$tds;
			}
			while (count($fields) > $tds) {
				++$tds;
				$tbody .= '<td>&nbsp;</td>';
			}
			$tbody .= '</tr>';
		}
		$tbody .= '</tbody>';
		return $tbody;
	}
	
	private function get_tfoot_content($foot, $count, $fields) {
		$tfoot = '';
		if ($count > 1) {
			$tfoot = '<tfoot>';
			foreach ($foot as $key => $values) {
				$tfoot .= '<tr class="header"><th>' . $key . '</th>';
				$tds = 0;
				foreach ($values as $v) {
					$decimals = ($v < 10) ? 2 : 0;
					if ($v > 999)
						$v = number_format($v, $decimals);
					$tfoot .= '<td class="text-right">' . $v . '</td>';
					++$tds;
				}
				while (count($fields) > $tds) {
					++$tds;
					$tfoot .= '<td>&nbsp;</td>';
				}
				$tfoot .= '</tr>';
			}
			$tfoot .= '</tfoot>';
		}
		$tfoot .= '</table>';
		return $tfoot;
	}

	// The following functions are imported in from the original developer
	// they are AJAX functions returning JSON formatted data
	public function delegate() {
		$action = $_REQUEST['action'];
		$this->$action();
		//$controller = new $controller($db, $adodb);
	}
}
?>
