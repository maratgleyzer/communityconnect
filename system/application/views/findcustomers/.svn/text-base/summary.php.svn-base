<?php $subtab = array("subtab" => "summary"); ?>
<form name="customers_summary_form" id="customers_summary_form">
	<div class="col_left field_order" id="customers_summary_field_order">
		<div class="instructions">View and organize segments:</div>
		<div class="sortlist" id="fc_summary_sortlist" style="height: auto;">
			<div class="imageToggle" style="float: right;">
				<input name="format" type="image" value="number" class="selected" src="/graphics/number_button.png"><input name="format" type="image" value="percent" src="/graphics/percent_button.png">
			</div>
			<div class="instructions">Drag and drop to set field order:</div>
			<ul id="field-list" class="sortable" style="height: auto;">
				<?php
				$tmp = array(
					'population' => array(
						'label' => 'Population',
						'class' => '',
						'title' => 'This presents the total number or percent of people for each segment. This shows you the size and relative strength of each segment in terms of its population.'
						),
					'patrons' => array(
						'label' => 'Patrons',
						'class' => '',
						'title' => 'This presents the number or percent of patrons for each segment. This shows you the size and relative strength of each segment in terms of its patronage.'
						),
					'checkouts' => array(
						'label' => 'Checkouts',
						'class' => '',
						'title' => 'This presents the number or percent of checkouts for each segment. This shows you the number of checkouts and relative strength of each segment in terms of borrowing.'
						),
					'market_share' => array(
						'label' => 'Market Share',
						'class' => '',
						'title'	=> "This presents the open market rate for each segment. The open market rate is the number of patrons divided by population by segment. The higher the open market rate, the fewer patrons you have relative to the population of that segment. Conversely, the lower the open market rate, the more patrons you have relative to the population of that segment. The open market rate is a good way to measure how deeply you're penetrated by segment in the marketplace."
						),
					'market_potential' => array(
						'label' => 'Market Potential',
						'class' => '',
						'title'	=> 'This presents the growth potential for each segment. Potential is measured by the size of the segment population in relation to its open market rate:<ul>
							<li>High potential: the bigger the population and the higher the open market rate, the higher the potential of the segment</li>
							<li>Low potential: the lower the population and the lower the open market rate, the lower the potential of the segment</li></ul>'
					),
					'patron_potential' => array(
						'label' => 'Patron Potential',
						'class' => '',
						'title'	=> 'This presents the growth potential for each segment. Potential is measured by the size of the segment population in relation to its open market rate:<ul>
							<li>High potential: the bigger the population and the higher the open market rate, the higher the potential of the segment</li>
							<li>Low potential: the lower the population and the lower the open market rate, the lower the potential of the segment</li></ul>'
					),
					'checkout_potential' => array(
						'label' => 'Checkout Potential',
						'class' => '',
						'title'	=> 'This presents the growth potential for each segment. Potential is measured by the size of the segment population in relation to its open market rate:<ul>
							<li>High potential: the bigger the population and the higher the open market rate, the higher the potential of the segment</li>
							<li>Low potential: the lower the population and the lower the open market rate, the lower the potential of the segment</li></ul>'
					),
				);
				foreach ($tmp as $field => $arr): ?>
					<li class="li_<?php echo $field; echo $arr['class']?>"><img align="middle" class="handle" src="/css/images/dragger.png" /><label for="label_<?php echo $field; ?>" class="normal"><input name="fields" type="checkbox" value="<?php echo $field; ?>" id="label_<?php echo $field; ?>"> <strong><?php echo $this->common->tool_tip($arr['title'], $arr['label']); ?></strong></label></li>
				<?php endforeach; ?>
				</ul>
			</div>
		<?php /*
		</div>

		<div class="col_left date_column" id="customers_summary_datecolumn">
			<div class="date_selectors">
			<?php $this->load->view('includes/checkouts', $subtab); ?>
		</div>
		*/ ?>
		<br class="clear" />
		<br />
		<div class="buttonCont"><input type="image" src="/graphics/show_data_button.png" value="Show Data" id="summary_show_data" />
			<img class="generate_pdf_report" src="/graphics/reports_icon2.png" style="cursor:pointer; display:none" onclick="SaveSummaryReport()">
		</div>
		<div id="data_variable"></div>
	</div>
</form>

	<div class="col_right">
		<div class="controls" style="display:none;padding:8px;">
			<div style="float:left;width:130px">
			<span class="biggify"> [ + ] &nbsp;&nbsp;&nbsp;&nbsp;</span>
			<div class="displaytype normal toggleSelect selected">Table</div>
			<div class="displaytype inverted toggleSelect">Chart</div>	
			</div>
			<div style="float:right;width:230px">
			<span class="pivottype">Toggle View:</span>
			<div id="toggle_analysis_way" class="toggle_analysis_way pivottype inverted toggleSelect">By Statistic</div>
			<div id="toggle_analysis_area" class="toggle_analysis_area pivottype normal toggleSelect selected">By Area</div>			
			</div>
		</div>
		<br style="clear:both;" />
		<div id="customers_chartcolumn" style="margin-top:6px;overflow:auto;">
			<div class="table" id="table" style="width:100%;"></div>
		    <div id="summary_chart" class="chart offscreen" align="center" style="height:100%;">The chart will appear within this DIV. This text will be replaced by the chart.</div>
		</div>
	</div>
	
<script type="text/javascript">
	function SaveSummaryReport() {
        var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");

		ReportInfo.Init(ReportType.FindNewCustomers, "Summary", $('#serviceArea :selected').text(), '');
		ReportInfo.AddReportItem(ReportItemType.Html, $(current_subtab + " .table").html(), '');

		ExportChart("fc_summary_chart");	
	}
</script>
