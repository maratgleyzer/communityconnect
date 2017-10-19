<?php

class Marketresearch extends CV_Controller {

	var $data = array();
	private $allSelection = array(
		'label' => '-- All --',
		'value' => '__all'
	);

	function __construct() {
		parent::CV_Controller();
		$this->data['pageTitle'] = "Market Research";
		$this->data['skip_studyarea'] = false;
		$this->load->model("serviceareas_model");
	}

	function ajax_demographics() {
		$this->load->model('block_model');
		$this->load->model('serviceareas_model');
		$format = $this->input->post('format');
		$sas = $this->input->post('sas');
		$demographics = $this->input->post('demographics');
		$out = array();
		$totals = array();
		foreach ($demographics as $dem_id) {
			$dem_row = $this->block_model->get_dem_data_by_id($dem_id);
			$dem_name = $dem_row->NAME;
			$type = $dem_row->TYPE;
			foreach ($sas as $sa) {
				$data = $this->block_model->get_demographic_data($dem_id, $sa, $type);
				$out[$data->AREA][$dem_name] = $data->VALUE;
			}
		}
		$foot = array(); // footer content, also used for calculating % if that is selected
		if (!$totals) {

		}
		else {
			foreach ($totals as $key => $values) {

			}
		}
		// assemble header
		$thead = '<table class="pivot tableSorter"><thead><tr class="header">';
		$title = 'Service Area';
		$thead .= '<th>Service Area</th>';
		foreach ($sas as $s) {
			$area = $this->serviceareas_model->get_area($s);
			$thead .= '<th style="white-space:nowrap;">' . $area . '</th>';
		}
		$thead .= '</tr></thead>';
		$tbody = $this->get_tbody_content($out, $demographics, $format, $foot);
		$tfoot = $this->get_tfoot_content($foot, count($out), $demographics);
		$chart_data = $this->common->FIND_CUSTOMERS_generate_FC_MSColumn2D_chart_json($demographics, $out);
		$return->chart = $chart_data;
		$return->table = $thead . $tbody . $tfoot;
		$return->common = $this->common->convert_data_to_common_structure($out,$data_title=$title, false);
		echo json_encode($return);
	}

	function index() {
		$data = $this->data;
		$data['skip_studyarea'] = true;
		$data['skip_daag'] = true;
//		$data['extraJS'] = array('reports');
		$data['pageClass'] = "marketResearch";
		$data['currentServiceArea'] = "Whole District";
		$data['data_at_a_glance'] = $this->common->getDataAtAGlance('increase');
		$data['service_areas'] = $this->serviceareas_model->get_service_areas_without_whole_district();
		$data['summary_text'] =
			'Market Research will help you drill down to get specific demographic data, market
			potential data, and consumer spending data by service area. Data is for the current
			year estimate of population. <strong>Demographics</strong> includes population by age and sex,
			race/ethnicity, educational attainment, household income, net worth, home value,
			and industry/occupation. <strong>Market Potential</strong> includes data for more
			than 2,200 items in 35 categories of products, services, attitudes, and activities.
			<strong>Consumer Spending</strong> includes data for products and services area
			consumers buy with more than 760 items in 15 categories such as apparel, food, and financial.';
		$data['page_name'] = 'Market Research';
		$data['demographics'] = $this->block_model->get_demographics();
		$this->load->view('marketresearch/index', $data);
	}

	private function get_tbody_content($out, $fields, $format, $foot) {
		$tbody = '<tbody>';
		foreach ($out as $th => $values) {
			$tbody .= '<tr><th>' . $th . '</th>';
			$tds = 0;
			foreach ($values as $v) {
				if ($format == 'percent' && is_int($foot['Total'][$tds])) { // prevent division by zero errors
					$print = $this->common->percent($v / $foot['Total'][$tds], 1);
				}
				else {
					$decimals = ($v < 10 && ($v % 2 != 0)) ? 2 : 0;
					$print = number_format($v, $decimals);
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
					$decimals = ($v < 10 && ($v % 2 != 0)) ? 2 : 0;
					$print = number_format($v, $decimals);
					$tfoot .= '<td class="text-right">' . $print . '</td>';
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
}
?>
