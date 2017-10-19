<?php
class Compareservices extends CV_Controller {

	var $data = array();
	private $allSelection = array(
		'label' => '-- All --',
		'value' => '__all'		
	);

	function __construct () 
	{
		parent::CV_Controller();

		(isset($_REQUEST['serviceArea']) ? $this->area = $_REQUEST['serviceArea'] :
			(isset($_REQUEST['sa']) ? $this->area = $_REQUEST['sa'] : $this->area = ""));

		$this->load->model("block_model");
		$this->load->model("patron_model");
		$this->load->model("checkout_sum_model");
		$this->load->model("serviceareas_model");
		$this->load->model("rank_checkout_model");
		$this->load->model("rank_patron_model");
		$this->load->model("rank_population_model");
		$this->load->model("rank_market_share_model");
		$this->load->model("rank_potential_model");
		
		$this->rank_population_model->getAreaSums();
		$this->rank_patron_model->getAreaSums();
		$this->rank_checkout_model->getAreaSums();
		$this->rank_market_share_model->getAreaSums();
		$this->rank_potential_model->getAreaSums();

		$this->population_max = $this->rank_population_model->getMaxSum();
		$this->patron_max = $this->rank_patron_model->getMaxSum();
		$this->checkout_max = $this->rank_checkout_model->getMaxSum();
		$this->market_share_max = $this->rank_market_share_model->getMaxSum();
		$this->potential_max = $this->rank_potential_model->getMaxSum();
		
		$this->load->library('adodb');
		
	}

	function index () 
	{
		$data = $this->data;
		$data['extraJS'] = array('reports');
        $data['pageTitle'] = "Compare Service Areas";
        $data['pageClass'] = "compareservices";
		$data['skip_studyarea'] = true;
		$data['currentServiceArea'] = "Whole District";
		$data['summary_text'] = 'Compare service areas will help the you rank service area across a range of measures in order to strategically target resources that fit the needs of the local community. In the <strong>Performance tab</strong>, you can rank each service area in terms of population, patrons, checkouts, open market rate, and potential. In the <strong>Customize Data tab</strong> you can view specific data sets (e.g., demographic, segmentation, usage) for service areas of your choice.';
		$data['data_at_a_glance'] = $this->common->getDataAtAGlance('compare');

		$chartStyle = (isset($_REQUEST['display']) ? $_REQUEST['display'] : "number"); 
		
		$this->service_areas = $this->serviceareas_model->get_service_areas_without_whole_district();
		$data['service_areas'] = $this->service_areas;
		$this->service_area_menu = $this->buildServiceAreaList($this->service_areas, $this->area);

		$this->population_sum = "0";
		$this->population_rank = $this->rank_population_model->getAreaRank();
		$this->patron_sum = "0";
		$this->patron_rank = $this->rank_patron_model->getAreaRank();
		$this->checkout_sum = "0";
		$this->checkout_rank = $this->rank_checkout_model->getAreaRank();
		$this->market_share_sum = "0";
		$this->market_share_rank = $this->rank_market_share_model->getAreaRank();
		$this->potential_sum = "0";
		$this->potential_rank = $this->rank_potential_model->getAreaRank();

		$this->population_max = "1";
		$this->patron_max = "1";
		$this->checkout_max = "1";
		$this->market_share_max = "1";
		$this->potential_max = "1";
		
		if ($chartStyle == "percent") {
			$this->population_sum = round(($this->population_sum / $this->population_max)*100,2);
			$this->population_max = "100";
			$this->patron_sum = round(($this->patron_sum / $this->patron_max)*100,2);
			$this->patron_max = "100";
			$this->checkout_sum = round(($this->checkout_sum / $this->checkout_max)*100,2);
			$this->checkout_max = "100";
			$this->market_share_sum = round(($this->market_share_sum / $this->market_share_max)*100,2);
			$this->market_share_max = "100";
			$this->potential_sum = round(($this->potential_sum / $this->potential_max)*100,2);
			$this->potential_max = "100";
		}

		$this->chartPopulation = "<chart adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->population_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->population_max."' name=''  /></colorRange><pointers><pointer value='".$this->population_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>";
		$this->chartPatron = "<chart adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->patron_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->patron_max."' name=''  /></colorRange><pointers><pointer value='".$this->patron_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>";
		$this->chartCheckout = "<chart adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->checkout_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->checkout_max."' name=''  /></colorRange><pointers><pointer value='".$this->checkout_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>";
		$this->chartMarketShare = "<chart adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".ceil($this->market_share_max)."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".ceil($this->market_share_max)."' name=''  /></colorRange><pointers><pointer value='".$this->market_share_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>";
		$this->chartPotential = "<chart adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".ceil($this->potential_max)."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".ceil($this->potential_max)."' name=''  /></colorRange><pointers><pointer value='".$this->potential_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>";
		
		$this->setInitialDistrictCharts();
		$this->serviceAreasToCheckboxArray();
		$data['ranks'] = array(
			'population' => array('rank' => $this->population_rank, 'chart' => $this->chartPopulation),
			'patron' => array('rank' => $this->patron_rank, 'chart' => $this->chartPatron),
			'checkout' => array('rank' => $this->checkout_rank, 'chart' => $this->chartCheckout),
			'market_share' => array('rank' => $this->market_share_rank, 'chart' => $this->chartMarketShare),
			'potential' => array('rank' => $this->potential_rank, 'chart' => $this->chartPotential)
		);
		$this->load->view('compareservices/index', $data);

	}
	
	public function setInitialDistrictCharts ()
	{
			
		$this->districtCharts = "";
		
		$chartStyle = (isset($_REQUEST['display']) ? $_REQUEST['display'] : "number");  
		
		$this->serviceAreasToArray();
		$this->population_by_rank = $this->rank_population_model->getAreasByRank();

		$i = 0;
		$total = 0;
/*
		foreach ($this->population_by_rank as $population) {
			++$i; $total += $population->POPULATION;
		}
		
		$median = round($total / $i);
		$i = 0;
*/		
		$this->median = "0";
		$this->population_max = "1";
		
		foreach ($this->population_by_rank as $population) {

			if ($chartStyle == "percent") {
				//$population->POPULATION = round(($population->POPULATION / $this->population_max)*100,2);
				$population->POPULATION = "0";
				$this->population_max = "100";
			}
			
			$population->POPULATION = "0";
			++$i; $this->districtCharts .=

"
<div class='districtChartHeading' id='districtChartArea".$i."'>&nbsp;</div>
<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"350\" height=\"50\" id=\"districtChart".$i."\" >
<param name=\"movie\" value=\"js/fusioncharts/FusionWidgets_Website/Code/Charts/HBullet.swf\" />
<param name=\"FlashVars\" value=\"&dataXML=<chart chartRightMargin='5' adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' palette='1' lowerLimit='0' upperLimit='$this->population_max' caption='' subCaption='' roundRadius='5' numberPrefix='' showValue='1'><colorRange><color minValue='0' maxValue='".ceil($this->population_max*0.20)."' /><color minValue='".ceil($this->population_max*0.20)."' maxValue='".ceil($this->population_max*0.40)."' /><color minValue='".ceil($this->population_max*0.40)."' maxValue='".ceil($this->population_max*0.60)."' /><color minValue='".ceil($this->population_max*0.60)."' maxValue='".ceil($this->population_max*0.80)."' /><color1 minValue='".ceil($this->population_max*0.80)."' maxValue='".ceil($this->population_max)."' /></colorRange><value>$population->POPULATION</value><target>".$this->median."</target></chart>\">
<param name=\"quality\" value=\"high\" />
<embed src=\"js/fusioncharts/FusionWidgets_Website/Code/Charts/HBullet.swf\" flashVars=\"&dataXML=<chart chartRightMargin='5' adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' palette='1' lowerLimit='0' upperLimit='$this->population_max' caption='' subCaption='' roundRadius='5' numberPrefix='' showValue='1'><colorRange><color minValue='0' maxValue='".ceil($this->population_max*0.20)."' /><color minValue='".ceil($this->population_max*0.20)."' maxValue='".ceil($this->population_max*0.40)."' /><color minValue='".ceil($this->population_max*0.40)."' maxValue='".ceil($this->population_max*0.60)."' /><color minValue='".ceil($this->population_max*0.60)."' maxValue='".ceil($this->population_max*0.80)."' /><color1 minValue='".ceil($this->population_max*0.80)."' maxValue='".ceil($this->population_max)."' /></colorRange><value>$population->POPULATION</value><target>".$this->median."</target></chart>\" quality=\"high\" width=\"350\" height=\"50\" name=\"districtChart".$i."\" swliveconnect=\"true\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />
</object>
";

		}
		
	}

	public function setRankingCharts()
	{
		
		$chartStyle = (isset($_REQUEST['display']) ? $_REQUEST['display'] : "number");  
		
		$this->population_sum = $this->rank_population_model->getAreaSum($this->area);
		$this->population_rank = $this->rank_population_model->getAreaRank($this->area);
		$this->patron_sum = $this->rank_patron_model->getAreaSum($this->area);
		$this->patron_rank = $this->rank_patron_model->getAreaRank($this->area);
		$this->checkout_sum = $this->rank_checkout_model->getAreaSum($this->area);
		$this->checkout_rank = $this->rank_checkout_model->getAreaRank($this->area);
		$this->market_share_sum = $this->rank_market_share_model->getAreaSum($this->area);
		$this->market_share_rank = $this->rank_market_share_model->getAreaRank($this->area);
		$this->potential_sum = $this->rank_potential_model->getAreaSum($this->area);
		$this->potential_rank = $this->rank_potential_model->getAreaRank($this->area);

		if ($chartStyle == "percent") {
			$this->population_sum = round(($this->population_sum / $this->population_max)*100,2);
			$this->population_max = "100";
			$this->patron_sum = round(($this->patron_sum / $this->patron_max)*100,2);
			$this->patron_max = "100";
			$this->checkout_sum = round(($this->checkout_sum / $this->checkout_max)*100,2);
			$this->checkout_max = "100";
			$this->market_share_sum = round(($this->market_share_sum / $this->market_share_max)*100,2);
			$this->market_share_max = "100";
			$this->potential_sum = round(($this->potential_sum / $this->potential_max)*100,2);
			$this->potential_max = "100";
		}
		
		$this->chartPopulation = "\"<chart chartRightMargin='30' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->population_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->population_max."' name=''  /></colorRange><pointers><pointer value='".$this->population_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>\"";
		$this->chartPatron = "\"<chart chartRightMargin='30' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->patron_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->patron_max."' name=''  /></colorRange><pointers><pointer value='".$this->patron_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>\"";
		$this->chartCheckout = "\"<chart chartRightMargin='30' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->checkout_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->checkout_max."' name=''  /></colorRange><pointers><pointer value='".$this->checkout_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>\"";
		$this->chartMarketShare = "\"<chart chartRightMargin='30' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".ceil($this->market_share_max)."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".ceil($this->market_share_max)."' name=''  /></colorRange><pointers><pointer value='".$this->market_share_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>\"";	
		$this->chartPotential = "\"<chart chartRightMargin='30' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".ceil($this->potential_max)."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".ceil($this->potential_max)."' name=''  /></colorRange><pointers><pointer value='".$this->potential_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>\"";
		
		$JSONArray = array(
		"population_data" => array("rank" => $this->population_rank, "chart" => $this->chartPopulation),
		"patron_data" => array("rank" => $this->patron_rank, "chart" => $this->chartPatron),
		"checkout_data" => array("rank" => $this->checkout_rank, "chart" => $this->chartCheckout),
		"market_share_data" => array("rank" => $this->market_share_rank, "chart" => $this->chartMarketShare),
		"potential_data" => array("rank" => $this->potential_rank, "chart" => $this->chartPotential)
		);
		
		$JSONString = json_encode($JSONArray);
		
		echo $JSONString;
		exit;
		
	}
	
	public function setDistrictCharts ()
	{
		$chart = $_REQUEST['chart'];
		
		$chartStyle = (isset($_REQUEST['display']) ? $_REQUEST['display'] : "number");  

		$model = "rank_".$chart."_model";
		
		$this->service_areas = $this->serviceareas_model->get_service_areas_without_whole_district();
		$this->serviceAreasToArray();
		
		$this->areas_by_rank = $this->$model->getAreasByRank();

		switch ($chart) {
			case "population":
				$chart_max = "population_max";
				$chart_sum = "POPULATION";
				break;
			case "patron":
				$chart_max = "patron_max";
				$chart_sum = "PATRONS";
				break;
			case "checkout":
				$chart_max = "checkout_max";
				$chart_sum = "CHECKOUTS";
				break;
			case "market_share":
				$chart_max = "market_share_max";
				$chart_sum = "OPEN_MARKETS";
				break;
			case "potential":
				$chart_max = "potential_max";
				$chart_sum = "POTENTIAL";
				break;
		}
		
		$total = 0;
		$areas = count($this->areas_by_rank);
		
		for ($i = 1; $i <= $areas; ++$i)
			$total += $this->areas_by_rank[$i]->$chart_sum;
	
		$chart_max_copy = $this->areas_by_rank[1]->$chart_sum;
			
		$this->median = round($total / $areas);
		if ($chartStyle == "percent")
			$this->median = round(($this->median / $chart_max_copy)*100);

		for ($i = 1; $i <= $areas; ++$i) {
			if ($chartStyle == "percent") {
				$this->areas_by_rank[$i]->$chart_sum =
				round(($this->areas_by_rank[$i]->$chart_sum / $chart_max_copy)*100,2);
				$this->$chart_max = "100";
			}
			$this->areas_by_rank[$i]->chart = "\"<chart chartRightMargin='5' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' palette='1' lowerLimit='0' upperLimit='".$this->$chart_max."' caption='' subCaption='' roundRadius='5' numberPrefix='' showValue='1'><colorRange><color minValue='0' maxValue='".ceil($this->$chart_max*0.20)."' /><color minValue='".ceil($this->$chart_max*0.20)."' maxValue='".ceil($this->$chart_max*0.40)."' /><color minValue='".ceil($this->$chart_max*0.40)."' maxValue='".ceil($this->$chart_max*0.60)."' /><color minValue='".ceil($this->$chart_max*0.60)."' maxValue='".ceil($this->$chart_max*0.80)."' /><color1 minValue='".ceil($this->$chart_max*0.80)."' maxValue='".ceil($this->$chart_max)."' /></colorRange><value>".$this->areas_by_rank[$i]->$chart_sum."</value><target>".$this->median."</target></chart>\"";
			$this->areas_by_rank[$i]->AREA = $this->service_area_array[$this->areas_by_rank[$i]->AREA_ID];
		}

		$JSONArray['DistrictCharts'] = $this->areas_by_rank;
		$JSONArray['median'] = number_format($this->median);
		$JSONString = json_encode($JSONArray);
		
		echo $JSONString;
		exit;
		
	}
	
	public function setRankingDistrictCharts()
	{
		$chartStyle = (isset($_REQUEST['display']) ? $_REQUEST['display'] : "number"); 
		
		$this->population_sum = $this->rank_population_model->getAreaSum($this->area);
		$this->population_rank = $this->rank_population_model->getAreaRank($this->area);
		$this->patron_sum = $this->rank_patron_model->getAreaSum($this->area);
		$this->patron_rank = $this->rank_patron_model->getAreaRank($this->area);
		$this->checkout_sum = $this->rank_checkout_model->getAreaSum($this->area);
		$this->checkout_rank = $this->rank_checkout_model->getAreaRank($this->area);
		$this->market_share_sum = $this->rank_market_share_model->getAreaSum($this->area);
		$this->market_share_rank = $this->rank_market_share_model->getAreaRank($this->area);
		$this->potential_sum = $this->rank_potential_model->getAreaSum($this->area);
		$this->potential_rank = $this->rank_potential_model->getAreaRank($this->area);

		if ($chartStyle == "percent") {
			$this->population_sum = round(($this->population_sum / $this->population_max)*100,2);
			$this->population_max = "100";
			$this->patron_sum = round(($this->patron_sum / $this->patron_max)*100,2);
			$this->patron_max = "100";
			$this->checkout_sum = round(($this->checkout_sum / $this->checkout_max)*100,2);
			$this->checkout_max = "100";
			$this->market_share_sum = round(($this->market_share_sum / $this->market_share_max)*100,2);
			$this->market_share_max = "100";
			$this->potential_sum = round(($this->potential_sum / $this->potential_max)*100,2);
			$this->potential_max = "100";
		}
		
		$this->chartPopulation = "\"<chart chartRightMargin='30' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->population_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->population_max."' name=''  /></colorRange><pointers><pointer value='".$this->population_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>\"";
		$this->chartPatron = "\"<chart chartRightMargin='30' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->patron_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->patron_max."' name=''  /></colorRange><pointers><pointer value='".$this->patron_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>\"";
		$this->chartCheckout = "\"<chart chartRightMargin='30' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->checkout_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->checkout_max."' name=''  /></colorRange><pointers><pointer value='".$this->checkout_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>\"";
		$this->chartMarketShare = "\"<chart chartRightMargin='30' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".ceil($this->market_share_max)."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".ceil($this->market_share_max)."' name=''  /></colorRange><pointers><pointer value='".$this->market_share_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>\"";	
		$this->chartPotential = "\"<chart chartRightMargin='30' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".ceil($this->potential_max)."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".ceil($this->potential_max)."' name=''  /></colorRange><pointers><pointer value='".$this->potential_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>\"";
		
		$JSONArray['RankingCharts'] = array(
		"population_data" => array("rank" => $this->population_rank, "chart" => $this->chartPopulation),
		"patron_data" => array("rank" => $this->patron_rank, "chart" => $this->chartPatron),
		"checkout_data" => array("rank" => $this->checkout_rank, "chart" => $this->chartCheckout),
		"market_share_data" => array("rank" => $this->market_share_rank, "chart" => $this->chartMarketShare),
		"potential_data" => array("rank" => $this->potential_rank, "chart" => $this->chartPotential)
		);
		
		$chart = $_REQUEST['chart'];

		$model = "rank_".$chart."_model";
		
		$this->service_areas = $this->serviceareas_model->get_service_areas();
		$this->serviceAreasToArray();
		
		$this->areas_by_rank = $this->$model->getAreasByRank();

		switch ($chart) {
			case "population":
				$chart_max = "population_max";
				$chart_sum = "POPULATION";
				break;
			case "patron":
				$chart_max = "patron_max";
				$chart_sum = "PATRONS";
				break;
			case "checkout":
				$chart_max = "checkout_max";
				$chart_sum = "CHECKOUTS";
				break;
			case "market_share":
				$chart_max = "market_share_max";
				$chart_sum = "OPEN_MARKETS";
				break;
			case "potential":
				$chart_max = "potential_max";
				$chart_sum = "POTENTIAL";
				break;
		}
		
		$total = 0;
		$areas = count($this->areas_by_rank);
		
		for ($i = 1; $i <= $areas; ++$i)
			$total += $this->areas_by_rank[$i]->$chart_sum;

		$chart_max_copy = $this->areas_by_rank[1]->$chart_sum;
			
		$this->median = round($total / $areas);
		if ($chartStyle == "percent")
			$this->median = round(($this->median / $chart_max_copy)*100);

		for ($i = 1; $i <= $areas; ++$i) {
			if ($chartStyle == "percent") {
				$this->areas_by_rank[$i]->$chart_sum =
				round(($this->areas_by_rank[$i]->$chart_sum / $chart_max_copy)*100,2);
				$this->$chart_max = "100";
			}
			$this->areas_by_rank[$i]->chart = "\"<chart chartRightMargin='5' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' palette='1' lowerLimit='0' upperLimit='".$this->$chart_max."' caption='' subCaption='' roundRadius='5' numberPrefix='' showValue='1'><colorRange><color minValue='0' maxValue='".ceil($this->$chart_max*0.20)."' /><color minValue='".ceil($this->$chart_max*0.20)."' maxValue='".ceil($this->$chart_max*0.40)."' /><color minValue='".ceil($this->$chart_max*0.40)."' maxValue='".ceil($this->$chart_max*0.60)."' /><color minValue='".ceil($this->$chart_max*0.60)."' maxValue='".ceil($this->$chart_max*0.80)."' /><color1 minValue='".ceil($this->$chart_max*0.80)."' maxValue='".ceil($this->$chart_max)."' /></colorRange><value>".$this->areas_by_rank[$i]->$chart_sum."</value><target>".$this->median."</target></chart>\"";
			$this->areas_by_rank[$i]->AREA = $this->service_area_array[$this->areas_by_rank[$i]->AREA_ID];
		}

		$JSONArray['median'] = number_format($this->median);
		$JSONArray['DistrictCharts'] = $this->areas_by_rank;
		$JSONString = json_encode($JSONArray);
		
		echo $JSONString;
		exit;

	}

	public function zeroRankingDistrictCharts()
	{
		
		$chartStyle = (isset($_REQUEST['display']) ? $_REQUEST['display'] : "number"); 

		$this->population_sum = "0";
		$this->population_rank = $this->rank_population_model->getAreaRank();
		$this->patron_sum = "0";
		$this->patron_rank = $this->rank_patron_model->getAreaRank();
		$this->checkout_sum = "0";
		$this->checkout_rank = $this->rank_checkout_model->getAreaRank();
		$this->market_share_sum = "0";
		$this->market_share_rank = $this->rank_market_share_model->getAreaRank();
		$this->potential_sum = "0";
		$this->potential_rank = $this->rank_potential_model->getAreaRank();

		$this->population_max = "1";
		$this->patron_max = "1";
		$this->checkout_max = "1";
		$this->market_share_max = "1";
		$this->potential_max = "1";
		
		if ($chartStyle == "percent") {
			$this->population_sum = round(($this->population_sum / $this->population_max)*100,2);
			$this->population_max = "100";
			$this->patron_sum = round(($this->patron_sum / $this->patron_max)*100,2);
			$this->patron_max = "100";
			$this->checkout_sum = round(($this->checkout_sum / $this->checkout_max)*100,2);
			$this->checkout_max = "100";
			$this->market_share_sum = round(($this->market_share_sum / $this->market_share_max)*100,2);
			$this->market_share_max = "100";
			$this->potential_sum = round(($this->potential_sum / $this->potential_max)*100,2);
			$this->potential_max = "100";
		}

		$this->chartPopulation = "<chart adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->population_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->population_max."' name=''  /></colorRange><pointers><pointer value='".$this->population_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>";
		$this->chartPatron = "<chart adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->patron_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->patron_max."' name=''  /></colorRange><pointers><pointer value='".$this->patron_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>";
		$this->chartCheckout = "<chart adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".$this->checkout_max."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".$this->checkout_max."' name=''  /></colorRange><pointers><pointer value='".$this->checkout_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>";
		$this->chartMarketShare = "<chart adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".ceil($this->market_share_max)."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".ceil($this->market_share_max)."' name=''  /></colorRange><pointers><pointer value='".$this->market_share_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>";
		$this->chartPotential = "<chart adjustTM='0' tickValueStep='2' majorTMNumber='0' tickValueDecimals='0' defaultAnimation='0' bgColor='FFFFFF' lowerLimit='0' upperLimit='".ceil($this->potential_max)."' gaugeRoundRadius='5' showGaugeBorder='1' numberPrefix=''><colorRange><color minValue='0' maxValue='".ceil($this->potential_max)."' name=''  /></colorRange><pointers><pointer value='".$this->potential_sum."' borderColor='000000' borderThickness='0' bgColor='E545454' toolText='' /></pointers></chart>";
		
		$JSONArray['RankingCharts'] = array(
		"population_data" => array("rank" => $this->population_rank, "chart" => $this->chartPopulation),
		"patron_data" => array("rank" => $this->patron_rank, "chart" => $this->chartPatron),
		"checkout_data" => array("rank" => $this->checkout_rank, "chart" => $this->chartCheckout),
		"market_share_data" => array("rank" => $this->market_share_rank, "chart" => $this->chartMarketShare),
		"potential_data" => array("rank" => $this->potential_rank, "chart" => $this->chartPotential)
		);
		
		$chart = $_REQUEST['chart'];

		$model = "rank_".$chart."_model";
		
		$this->service_areas = $this->serviceareas_model->get_service_areas();
		$this->serviceAreasToArray();
		
		$this->areas_by_rank = $this->$model->getAreasByRank();

		switch ($chart) {
			case "population":
				$chart_max = "population_max";
				$chart_sum = "POPULATION";
				break;
			case "patron":
				$chart_max = "patron_max";
				$chart_sum = "PATRONS";
				break;
			case "checkout":
				$chart_max = "checkout_max";
				$chart_sum = "CHECKOUTS";
				break;
			case "market_share":
				$chart_max = "market_share_max";
				$chart_sum = "OPEN_MARKETS";
				break;
			case "potential":
				$chart_max = "potential_max";
				$chart_sum = "POTENTIAL";
				break;
		}
		
		$total = 0;
		$areas = count($this->areas_by_rank);

		$chart_max_copy = 1;
			
		$this->median = "0";

		for ($i = 1; $i <= $areas; ++$i) {
			$this->areas_by_rank[$i]->$chart_sum = 0;
			if ($chartStyle == "percent") {
				$this->areas_by_rank[$i]->$chart_sum =
				round((0 / $chart_max_copy)*100,2);
				$this->$chart_max = "100";
			}
			$this->areas_by_rank[$i]->chart = "\"<chart chartRightMargin='5' adjustTM='0' tickValueStep='2' majorTMNumber='7' tickValueDecimals='0' defaultAnimation='0' palette='1' lowerLimit='0' upperLimit='".$this->$chart_max."' caption='' subCaption='' roundRadius='5' numberPrefix='' showValue='1'><colorRange><color minValue='0' maxValue='".ceil($this->$chart_max*0.20)."' /><color minValue='".ceil($this->$chart_max*0.20)."' maxValue='".ceil($this->$chart_max*0.40)."' /><color minValue='".ceil($this->$chart_max*0.40)."' maxValue='".ceil($this->$chart_max*0.60)."' /><color minValue='".ceil($this->$chart_max*0.60)."' maxValue='".ceil($this->$chart_max*0.80)."' /><color1 minValue='".ceil($this->$chart_max*0.80)."' maxValue='".ceil($this->$chart_max)."' /></colorRange><value>".$this->areas_by_rank[$i]->$chart_sum."</value><target>".$this->median."</target></chart>\"";
			$this->areas_by_rank[$i]->AREA = $this->service_area_array[$this->areas_by_rank[$i]->AREA_ID];
		}

		$JSONArray['DistrictCharts'] = $this->areas_by_rank;
		$JSONString = json_encode($JSONArray);
		
		echo $JSONString;
		exit;

	}

	public function getCustomData() {
		
		$data = array(); $chart = ""; $table = "";
		$customizeData = $_REQUEST['CustomizeData'];
		$this->dataItems = $_REQUEST['DataItem'];
		$cd_mode = $_REQUEST['checkouts_mode'];
		$this->cd_area = $_REQUEST['cd_area'];
		$this->removeWholeDistrict();
		
		$number_type = (isset($_REQUEST['number_type']) ? $_REQUEST['number_type'] : 'number');

		$sort_num = false; $sort_alpha = false;
		$sort_method = (isset($_REQUEST['chart_sort']) ? $_REQUEST['chart_sort'] : "high_to_low");

		switch ($sort_method) {
			case "a_to_z": $sort_alpha = "ASC"; break;
			case "z_to_a": $sort_alpha = "DESC"; break;
			case "high_to_low": $sort_num = "DESC"; break;
			case "low_to_high": $sort_num = "ASC"; break;
		}
 		
		$area_count = count($this->cd_area);
		$data_count = count($this->dataItems);

		$areas = "'".implode("','",$this->cd_area)."'";

		if ($cd_mode == 'range') {
			$startdate = $_REQUEST['startdate'];
			$enddate = $_REQUEST['enddate'];
			$startdate = $this->translateDate($startdate);
			$enddate = $this->translateDate($enddate);
		}
		
		else {
			$startdate = false;
			$enddate = false;
		}

		$this->service_areas = $this->serviceareas_model->get_service_areas();
		$this->serviceAreasToArray();
		
		//var_dump($this->checkout_sum_model->getSummaryProfileData($this->areas,$this->startdate,$this->enddate));
		//exit;
		
		$this->dataItems = array_flip($this->dataItems);
		$this->flipped_cd_area = array_flip($this->cd_area);
		
		switch ($customizeData[0]) {
			case "summary_profile":
				$chart_width = $area_count*$data_count*30;
				if ($chart_width < 460) $chart_width = 460; 
				$this->chart_title = "Summary Profile";
				$data = $this->checkout_sum_model->getProfileData($sort_alpha,$sort_num);
				if ($data) {
					foreach ($data as $key => $row) {
						
						if (!isset($_data[$row->AREA_ID]['total_population'])) $_data[$row->AREA_ID]['total_population'] = 0;
						if (!isset($_data[$row->AREA_ID]['total_patrons'])) $_data[$row->AREA_ID]['total_patrons'] = 0;
						if (!isset($_data[$row->AREA_ID]['total_checkouts'])) $_data[$row->AREA_ID]['total_checkouts'] = 0;
						if (!isset($total_population)) $total_population = 0;
						
						$_data[$row->AREA_ID]['population'][] = $row->population;
						$_data[$row->AREA_ID]['patrons'][] = $row->patrons;
						$_data[$row->AREA_ID]['checkouts'][] = $row->checkouts;
						$_data[$row->AREA_ID]['total_population'] += $row->population;
						$_data[$row->AREA_ID]['total_patrons'] += $row->patrons;
						$_data[$row->AREA_ID]['total_checkouts'] += $row->checkouts;
						
						$total_population += $row->population;
					
					}
					foreach ($_data as $area => $stat) {
						
						if (array_key_exists("summary_population",$this->dataItems))
							$__data[$area]['Population'] = 
							$_data[$area]['total_population'];
							
						if (array_key_exists("summary_median_population",$this->dataItems))
							$__data[$area]['Median Population'] = 
							$this->common->median($_data[$area]['population']);

						if (array_key_exists("summary_patrons",$this->dataItems))
							$__data[$area]['Patrons'] = 
							$_data[$area]['total_patrons'];

						if (array_key_exists("summary_median_patrons",$this->dataItems))
							$__data[$area]['Median Patrons'] = 
							$this->common->median($_data[$area]['patrons']);

						if (array_key_exists("summary_checkouts",$this->dataItems))
							$__data[$area]['Checkouts'] = 
							$_data[$area]['total_checkouts'];

						if (array_key_exists("summary_median_checkouts",$this->dataItems))
							$__data[$area]['Median Checkouts'] = 
							$this->common->median($_data[$area]['checkouts']);

						if (array_key_exists("summary_patron_potential",$this->dataItems))
							$__data[$area]['Patron Potential'] = round(
							(($_data[$area]['total_population'] / $total_population) *
							 (1-($_data[$area]['total_patrons'] / $_data[$area]['total_population'])))*100,
							 2);

						if (array_key_exists("summary_checkout_potential",$this->dataItems))
							$__data[$area]['Checkout Potential'] = round(
							(($_data[$area]['total_population'] / $total_population) *
							 ($_data[$area]['total_checkouts'] / $_data[$area]['total_population']))*10,
							 2);
							 
						if (array_key_exists("summary_median_patron_potential",$this->dataItems))
							$__data[$area]['Median Patron Potential'] = round(
							(($this->common->median($_data[$area]['population']) / $_data[$area]['total_population']) *
							 (1-($this->common->median($_data[$area]['patrons']) / $this->common->median($_data[$area]['population']))))*100,
							 2);
							 
						if (array_key_exists("summary_median_checkout_potential",$this->dataItems))	
							$__data[$area]['Median Checkout Potential'] = round(
							(($this->common->median($_data[$area]['population']) / $_data[$area]['total_population']) *
							 ($this->common->median($_data[$area]['checkouts']) / $this->common->median($_data[$area]['population'])))*10,
							 2);
							 
						if (array_key_exists("summary_use_rate",$this->dataItems))
							$__data[$area]['Use Rate'] = round(
							($_data[$area]['total_checkouts'] /
							 $_data[$area]['total_population'])*10,
							2);
							
						if (array_key_exists("summary_median_use_rate",$this->dataItems))
							$__data[$area]['Median Use Rate'] = round(
							($this->common->median($_data[$area]['checkouts']) /
							 $this->common->median($_data[$area]['population']))*10,
							2);
							
						if (array_key_exists("summary_market_share_rate",$this->dataItems))
							$__data[$area]['Market Share Rate'] = round(
							((1-($_data[$area]['total_patrons'] / $_data[$area]['total_population']))*100),
							2);
							
						if (array_key_exists("summary_median_market_share_rate",$this->dataItems))
							$__data[$area]['Median Market Share Rate'] = round(
							((1-($this->common->median($_data[$area]['patrons']) / $this->common->median($_data[$area]['population'])))*100),
							2);

						if (array_key_exists("summary_average_patron_checkouts",$this->dataItems))
							$__data[$area]['Average Patron Checkouts'] = round(
							($_data[$area]['total_checkouts'] / $_data[$area]['total_patrons']),
							2);
						
					}
					if ($number_type == "percent") {
						foreach ($__data as $area => $stat) {
							foreach ($stat as $name => $value) {
								$maxname = "max$name" ;
								if (!isset($$maxname)) $$maxname = $value;
								if ($$maxname < $value) $$maxname = $value;
							}
						}
						foreach ($__data as $area => $stat) {
							foreach ($stat as $name => $value) {
								$maxname = "max$name" ;
								$__data[$area][$name] =
								round(($value / $$maxname)*100,2);
							}
						}
						
					}
					$custom_data = array();
					foreach ($__data as $area => $stat)
						if (array_key_exists($area,$this->flipped_cd_area))
							foreach ($stat as $name => $value)
								$custom_data[$this->service_area_array[$area]][$name] = $value;
				} break;
			case "segment_profile":	
				$this->chart_title = "Segment Profile";
				if (array_key_exists("segment_highest_name",$this->dataItems)) {
					$chart_width = "100%";
					$data = $this->checkout_sum_model->getProfileData($sort_alpha,$sort_num);
					if ($data) {
					foreach ($data as $key => $row) {				
						
						if (!isset($_data[$row->AREA_ID]['total_population'])) $_data[$row->AREA_ID]['total_population'] = 0;
						if (!isset($_data[$row->AREA_ID]['total_patrons'])) $_data[$row->AREA_ID]['total_patrons'] = 0;
						if (!isset($_data[$row->AREA_ID]['total_checkouts'])) $_data[$row->AREA_ID]['total_checkouts'] = 0;
						
						if (!isset($_data[$row->AREA_ID]['Population'][$row->TAPSEGNAM])) $_data[$row->AREA_ID]['Population'][$row->TAPSEGNAM] = 0;
						if (!isset($_data[$row->AREA_ID]['Patrons'][$row->TAPSEGNAM])) $_data[$row->AREA_ID]['Patrons'][$row->TAPSEGNAM] = 0;
						if (!isset($_data[$row->AREA_ID]['Checkouts'][$row->TAPSEGNAM])) $_data[$row->AREA_ID]['Checkouts'][$row->TAPSEGNAM] = 0;
						
						$_data[$row->AREA_ID]['Population'][$row->TAPSEGNAM] += $row->population;
						$_data[$row->AREA_ID]['Patrons'][$row->TAPSEGNAM] += $row->patrons;
						$_data[$row->AREA_ID]['Checkouts'][$row->TAPSEGNAM] += $row->checkouts;
						$_data[$row->AREA_ID]['total_population'] += $row->population;
						$_data[$row->AREA_ID]['total_patrons'] += $row->patrons;
						$_data[$row->AREA_ID]['total_checkouts'] += $row->checkouts;
						
						if (!isset($total_population)) $total_population = 0;
						$total_population += $row->population;
					}
					foreach ($_data as $area => $stat)
						foreach ($stat as $name => $segment) {
							if ($name == 'total_population' ||
								$name == 'total_patrons' ||
								$name == 'total_checkouts')
								continue;
							foreach ($segment as $key => $value) {
								if ($_data[$area]['Patrons'][$key] != 0 &&
									$_data[$area]['Population'][$key] != 0) {
									$_data[$area]['Average Patron Checkouts'][$key] = round(
									$_data[$area]['Checkouts'][$key] / $_data[$area]['Patrons'][$key],2);
									$_data[$area]['Market Share Rate'][$key] = round(
									((1-($_data[$area]['Patrons'][$key] / $_data[$area]['Population'][$key]))*100),2);
									$_data[$area]['Patron Potential'][$key] = round(
									(($_data[$area]['Population'][$key] / $_data[$area]['total_population']) *
								 	(1-($_data[$area]['Patrons'][$key] / $_data[$area]['Population'][$key])))*100,2);
								}
							}
						}
					foreach ($_data as $area => $stat)
						foreach ($stat as $name => $segment) {
							if ($name == 'total_population' ||
								$name == 'total_patrons' ||
								$name == 'total_checkouts')
								continue;
							asort($_data[$area][$name]); end($_data[$area][$name]);
							$__data[$area][$name] = key($_data[$area][$name])."<br />".
							$_data[$area][$name][key($_data[$area][$name])];
						}
					$custom_data = array();
					foreach ($__data as $area => $stat)
						if (array_key_exists($area,$this->flipped_cd_area))
							foreach ($stat as $name => $value)
								$custom_data[$this->service_area_array[$area]][$name] = $value;
					}
				}
				else {
					$chart_width = $area_count*800;
					if ($chart_width > 8000) $chart_width = 8000;		
					$data = $this->checkout_sum_model->getProfileData($sort_alpha,$sort_num);
					if ($data) {
					foreach ($data as $key => $row) {
						
						if (!isset($_data[$row->AREA_ID]['total_population'])) $_data[$row->AREA_ID]['total_population'] = 0;
						if (!isset($_data[$row->AREA_ID]['total_patrons'])) $_data[$row->AREA_ID]['total_patrons'] = 0;
						if (!isset($_data[$row->AREA_ID]['total_checkouts'])) $_data[$row->AREA_ID]['total_checkouts'] = 0;
						if (!isset($_data[$row->AREA_ID][$row->TAPSEGNAM]['total_population'])) $_data[$row->AREA_ID][$row->TAPSEGNAM]['total_population'] = 0;
						if (!isset($_data[$row->AREA_ID][$row->TAPSEGNAM]['total_patrons'])) $_data[$row->AREA_ID][$row->TAPSEGNAM]['total_patrons'] = 0;
						if (!isset($_data[$row->AREA_ID][$row->TAPSEGNAM]['total_checkouts'])) $_data[$row->AREA_ID][$row->TAPSEGNAM]['total_checkouts'] = 0;
						
						if (!isset($total_population)) $total_population = 0;

						$_data[$row->AREA_ID][$row->TAPSEGNAM]['population'][] = $row->population;
						$_data[$row->AREA_ID][$row->TAPSEGNAM]['patrons'][] = $row->patrons;
						$_data[$row->AREA_ID][$row->TAPSEGNAM]['checkouts'][] = $row->checkouts;
						$_data[$row->AREA_ID][$row->TAPSEGNAM]['total_population'] += $row->population;
						$_data[$row->AREA_ID][$row->TAPSEGNAM]['total_patrons'] += $row->patrons;
						$_data[$row->AREA_ID][$row->TAPSEGNAM]['total_checkouts'] += $row->checkouts;
						$_data[$row->AREA_ID]['total_population'] += $row->population;
						$_data[$row->AREA_ID]['total_patrons'] += $row->patrons;
						$_data[$row->AREA_ID]['total_checkouts'] += $row->checkouts;
						
						$total_population += $row->population;
					
					}
					foreach ($_data as $area => $segment) {
						foreach ($this->cd_area as $key => $cd_area) {
							foreach ($segment as $name => $value) {
								if ($name == 'total_population' ||
									$name == 'total_patrons' ||
									$name == 'total_checkouts')
									continue;

								if (array_key_exists("segment_population",$this->dataItems))
									if ($area == $cd_area) $__data[$area][$name] = $_data[$area][$name]['total_population'];
									elseif (!isset($__data[$cd_area][$name])) $__data[$cd_area][$name] = 0;

								if (array_key_exists("segment_patrons",$this->dataItems))
									if ($area == $cd_area) $__data[$area][$name] = $_data[$area][$name]['total_patrons'];
									elseif (!isset($__data[$cd_area][$name])) $__data[$cd_area][$name] = 0;

								if (array_key_exists("segment_median_patron_potential",$this->dataItems))
									if ($area == $cd_area && $_data[$area][$name]['total_population'] > 0) $__data[$area][$name] = round(
										(($this->common->median($_data[$area][$name]['population']) / $_data[$area][$name]['total_population']) *
									 	(1-($this->common->median($_data[$area][$name]['patrons']) / $this->common->median($_data[$area][$name]['population']))))*100,
							 			2);
									elseif (!isset($__data[$cd_area][$name])) $__data[$cd_area][$name] = 0;
							 
								if (array_key_exists("segment_use_rate",$this->dataItems))
									if ($area == $cd_area && $_data[$area][$name]['total_population'] > 0) $__data[$area][$name] = round(
										($_data[$area][$name]['total_checkouts'] /
							 			$_data[$area][$name]['total_population'])*10,
										2);
									elseif (!isset($__data[$cd_area][$name])) $__data[$cd_area][$name] = 0;

								if (array_key_exists("segment_median_market_share_rate",$this->dataItems))
									if ($area == $cd_area && $_data[$area][$name]['total_population'] > 0) $__data[$area][$name] = round(
										(1-($this->common->median($_data[$area][$name]['patrons']) / $this->common->median($_data[$area][$name]['population'])))*100,
										2);
									elseif (!isset($__data[$cd_area][$name])) $__data[$cd_area][$name] = 0;

								if (array_key_exists("segment_average_patron_checkouts",$this->dataItems))
									if ($area == $cd_area && $_data[$area][$name]['total_patrons'] > 0) $__data[$area][$name] = round(
										($_data[$area][$name]['total_checkouts'] / $_data[$area][$name]['total_patrons']),
										2);
									elseif (!isset($__data[$cd_area][$name])) $__data[$cd_area][$name] = 0;
							}
						}	
					}
					if ($number_type == "percent" &&
						!array_key_exists("segment_highest_name",$this->dataItems)) {
						
						foreach ($__data as $area => $stat) {
							foreach ($stat as $name => $value) {
								$maxname = "max$name" ;
								if (!isset($$maxname)) $$maxname = $value;
								if ($$maxname < $value) $$maxname = $value;
							}
						}
						foreach ($__data as $area => $stat) {
							foreach ($stat as $name => $value) {
								$maxname = "max$name" ;
								$__data[$area][$name] =
								round(($value / $$maxname)*100,2);
							}
						}
						
					}
					$custom_data = array();
					foreach ($__data as $area => $stat)
						if (array_key_exists($area,$this->flipped_cd_area))
							foreach ($stat as $name => $value)
								$custom_data[$this->service_area_array[$area]][$name] = $value;
								
				}
				} break;

		}	
		if ($data) {
			if (array_key_exists("segment_highest_name",$this->dataItems)) {
				$table = $this->common->convert_data_to_common_structure($custom_data,$this->chart_title,true);
			}
			else {
				$table = $this->common->convert_data_to_common_structure($custom_data,$this->chart_title,true);
				$chart = $this->common->generate_FC_MSColumn2D_chart_json($this->RemoveNumberFormattingFromArray($table));
			}
		}
		
		$results = array();
		$results['success'] = true;
		
		$results['data'] = $table;  

		//echo json_encode($results);

		$jdata->table_data = $results;
		$jdata->chart_data = $chart;
		$jdata->chart_width = $chart_width;
		echo json_encode($jdata);
		exit;
	}
	
	private function RemoveNumberFormattingFromArray($data=array()) {
		
		for ($i = 1; $i < count($data); ++$i)
			for ($j = 1; $j < count($data[$i]); ++$j) {
				$data[$i][$j] = preg_replace('/,/','',$data[$i][$j]);
				settype($data[$i][$j],'float');
			}
		
		return $data;
		
	}
	
	private function BuildGenericDataTable($data) {
		
		$table = "";

		for ($i = 0; $i < count($data); ++$i) {
			$row = "";
			for ($j = 0; $j < (count($data[$i])-1); ++$j) {
				if ($i == 0 || $j == 0)
					$row .= "<th>".$data[$i][$j]."</th>";
				else $row .= "<td>".$data[$i][$j]."</td>";
			} $table .= "<tr>$row</tr>";
		}
		
		$table = "<table class='pivot'><tbody>$table</tbody></table>";
		return $table;
		
	}
	
	private function BuildHighestDataTable($data) {
		
		$chart[0][0] = $this->chart_title;	
		
		foreach ($data as $area => $dataset) {
			$chart[0][] = $area;
			foreach ($dataset as $key => $value) {
				$AddDataKey = true;
				for ($i = 0; $i < count($chart); ++$i) {
					if ($chart[$i][0] == $key) {
						$chart[$i][] = $value;
						$AddDataKey = false;
					}
				}
				if ($AddDataKey) {
					$chart[$i][0] = $key;
					$chart[$i][] = $value;
				}
			}
		}

		$chart[0][] = "Total";
		
		for ($i = 1; $i < count($chart); ++$i)
			$chart[$i][] = 0;

		$table = "";

		for ($i = 0; $i < count($chart); ++$i) {
			$row = "";
			for ($j = 0; $j < (count($chart[$i])-1); ++$j) {
				if ($i == 0 || $j == 0)
					$row .= "<th colspan='2'>".$chart[$i][$j]."</th>";
				else $row .= "<td>".$chart[$i][$j]."</td>";
			} $table .= "<tr>$row</tr>";
		}
		
		$table = "<table class='pivot'><tbody>$table</tbody></table>";
		return $table;

	}

	private function translateDate($string="") {
		$string = preg_replace('/[^0-9]+/','',$string);
		$month = substr($string,0,2);
		$day = substr($string,2,2);
		$year = substr($string,4,4);
		return $year."-".$month."-".$day;
	}
	
	private function removeWholeDistrict() {
		for ($i = 0; $i < count($this->cd_area); ++$i)
			if ($this->cd_area[$i] == '1111')
				unset($this->cd_area[$i]);
	}
	
	private function getHighestPopulationSegment($areas="",$startdate=false,$enddate=false) {
		foreach ($this->cd_area as $key => $area) {
		$data = $this->checkout_sum_model->getHighestPopulationSegment($areas,$startdate,$enddate);
			foreach ($data as $key => $row)
				if ($area == $row->AREA_ID) $this->custom_data_chart[$row->AREA]['Population'] = "$row->TAPSEGNAM</td><td>$row->maxValue";
				elseif (!isset($this->custom_data_chart[$this->service_area_array[$area]]['Population']))
					$this->custom_data_chart[$this->service_area_array[$area]]['Population'] = "None</td><td>0";
		}
	}

	private function getHighestPatronsSegment($areas=array(),$startdate=false,$enddate=false) {
		$data = $this->checkout_sum_model->getHighestPatronsSegment($areas,$startdate,$enddate);
		foreach ($this->cd_area as $key => $area) {
			foreach ($data as $key => $row)
				if ($area == $row->AREA_ID) $this->custom_data_chart[$row->AREA]['Patrons'] = "$row->TAPSEGNAM</td><td>$row->maxValue";
				elseif (!isset($this->custom_data_chart[$this->service_area_array[$area]]['Patrons']))
					$this->custom_data_chart[$this->service_area_array[$area]]['Patrons'] = "None</td><td>0";
		}
	}
	
	private function getHighestCheckoutsSegment($areas=array(),$startdate=false,$enddate=false) {
		$data = $this->checkout_sum_model->getHighestCheckoutsSegment($areas,$startdate,$enddate);
		foreach ($this->cd_area as $key => $area) {
			foreach ($data as $key => $row)
				if ($area == $row->AREA_ID) $this->custom_data_chart[$row->AREA]['Checkouts'] = "$row->TAPSEGNAM</td><td>$row->maxValue";
				elseif (!isset($this->custom_data_chart[$this->service_area_array[$area]]['Checkouts']))
					$this->custom_data_chart[$this->service_area_array[$area]]['Checkouts'] = "None</td><td>0";
		}
	}
	
	private function getHighestPotentialSegment($areas=array(),$startdate=false,$enddate=false) {
		$data = $this->checkout_sum_model->getHighestPotentialSegment($areas,$startdate,$enddate);
		foreach ($this->cd_area as $key => $area) {
			foreach ($data as $key => $row)
				if ($area == $row->AREA_ID) $this->custom_data_chart['Potential'][$row->AREA] = array($row->TAPSEGNAM, $row->maxValue);			
				if ($area == $row->AREA_ID) $this->custom_data_chart[$row->AREA]['Potential'][$row->TAPSEGNAM] = round($row->maxValue,2);
				elseif (!isset($this->custom_data_chart[$this->service_area_array[$area]]['Potential']))
					$this->custom_data_chart[$this->service_area_array[$area]]['Potential'][$row->TAPSEGNAM] = 0;
		}
	}
	
	private function getHighestAverageCheckoutsSegment($areas=array(),$startdate=false,$enddate=false) {
		$data = $this->checkout_sum_model->getHighestAverageCheckoutsSegment($areas,$startdate,$enddate);
		foreach ($this->cd_area as $key => $area) {
			foreach ($data as $key => $row)
				if ($area == $row->AREA_ID) $this->custom_data_chart['Average Patron Checkouts'][$row->AREA] = array($row->TAPSEGNAM, $row->maxValue);
				elseif (!isset($this->custom_data_chart[$this->service_area_array[$area]]['Average Patron Checkouts']))
					$this->custom_data_chart[$this->service_area_array[$area]]['Average Patron Checkouts'][$row->TAPSEGNAM] = 0;
		}
	}

	private function getHighestOpenMarketRateSegment($areas=array(),$startdate=false,$enddate=false) {
		$data = $this->checkout_sum_model->getHighestOpenMarketRateSegment($areas,$startdate,$enddate);
		foreach ($this->cd_area as $key => $area) {
			foreach ($data as $key => $row)
				if ($area == $row->AREA_ID) $this->custom_data_chart['Open Market Rate'][$row->AREA] = array($row->TAPSEGNAM, $row->maxValue);
				elseif (!isset($this->custom_data_chart[$this->service_area_array[$area]]['Market Share Rate']))
					$this->custom_data_chart[$this->service_area_array[$area]]['Market Share Rate'][$row->TAPSEGNAM] = 0;
		}
	}
	
	public function serviceAreasToArray ()
	{
		
		foreach ($this->service_areas as $area)
			$this->service_area_array[$area->AREA_ID] = $area->AREA;
		
	}
	
	public function serviceAreasToCheckboxArray ()
	{
		
		$this->service_area_checkboxes = "<li><input type=\"checkbox\" name=\"cd_area[]\" id=\"cd_area\" value=\"1111\" onclick=\"checkAll(this.checked);\"> <span>-- All --</span></li>\n";
		/*
		$this->service_area_checkboxes .= "<li><input type=\"checkbox\" name=\"cd_area[]\" id=\"cd_area\" value=\"urban\" onclick=\"checkUrban(this.checked);\"> <span>-- All Urban --</span></li>\n";
		$this->service_area_checkboxes .= "<li><input type=\"checkbox\" name=\"cd_area[]\" id=\"cd_area\" value=\"rural\" onclick=\"checkRural(this.checked);\"> <span>-- All Rural --</span></li>\n";
		*/ 
		
		foreach ($this->service_areas as $area)
			$this->service_area_checkboxes .= "<li><input type=\"checkbox\" name=\"cd_area[]\" id=\"cd_area\" value=\"$area->AREA_ID\"> <span>$area->AREA</span></li>\n";
		
	}
	
	public function buildServiceAreaList ($areas="", $selected_area_id)
	{
    	$out = "<select id=\"serviceArea\" class=\"styled\" style=\"width: 240px;\" name=\"serviceArea\" onchange=\"setRankingDistrictCharts(ActiveChart);\">\n";
    	$out .= "<option value=\"Whole_District\">Whole District (Only Data at a Glance)</option>\n";

		if ($selected_area_id == 'Region')
        	$selected = ' selected="selected" ';
        else $selected = "";
		$excluded_sas = $this->config->item('excluded_service_areas'); // 'no data' service areas globally excluded
		$user_sa = $this->session->userdata('STUDYAREA'); // if user acct has a 'favorite' SA 
        foreach ($areas as $area) {
			if (in_array($area->AREA_ID, $excluded_sas)) continue;
        	if ( ($selected_area_id != '' && $area->AREA_ID == $selected_area_id)
					|| ($selected_area_id == '' && $area->AREA_ID == $user_sa) ) {
            	$selected = ' selected="selected" ';
			}
        	else { 
				$selected = "";
			}

          $out .= "<option $selected value=\"".str_replace(" ","_",$area->AREA_ID)."\">".$area->AREA."</option>\n";
      	}

      	$out .= "</select>";
      	return $out;

	}
	
}
?>
