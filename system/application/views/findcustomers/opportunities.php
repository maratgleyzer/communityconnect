<?php $subtab = array("subtab" => "opportunities"); ?>
<form name="customers_opportunities_form" id="customers_opportunities_form">

	<script type="text/javascript">
		$(document).ready(function() {
			$('.non_whole').hide();
			$('#serviceArea').change(function() {
				if ($(this).val() == 'Whole_District') {
					$('.whole').show();
					$('.whole input').attr('checked',true).attr('disabled',true);
					$('.non_whole input').attr('checked',false);
					$('.non_whole').hide();
					$('#opportunities_field_order > p').html('Rank service areas by growth potential.');
				}
				else {
					$('.whole input').attr('checked',false);
					$('.whole').hide();
					$('.non_whole').show();
					$('#opportunities_field_order > p').html('Rank census block groups by growth potential.');
				}
			});
		});
	</script>
	<div class="col_left field_order" id="opportunities_field_order">
		<div class="instructions">Rank service areas by growth potential.</div>
		<div class="sortlist" id="fc_opportunities_sortlist" style="height: auto;">
			<div class="imageToggle" style="float: right;">
				<input name="format" type="image" value="number" class="selected" src="/graphics/number_button.png" /><input name="format" type="image" value="percent" src="/graphics/percent_button.png" />
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
						'title' => 'This presents the number or percent of non-patrons for each segment. This shows you the size and relative strength of each segment in terms of its non-patrons. We use non-patrons to characterize the size of the market opportunity.'
						),
					'patron_potential' => array(
						'label' => 'Patron Potential',
						'class' => '',
						'title'	=> 'This presents the growth potential for each segment. Potential is measured by the size of the segment population in relation to its open market rate:<ul>
							<li>High potential: the bigger the population and the higher the open market rate, the higher the potential of the segment</li>
							<li>Low potential: the lower the population and the lower the open market rate, the lower the potential of the segment</li></ul>'
					),
					'checkout_pot' => array(
						'label' => 'Checkout Potential',
						'class' => '',
						'title'	=> 'This presents the growth potential for each segment. Potential is measured by the size of the segment population in relation to its open market rate:<ul>
							<li>High potential: the bigger the population and the higher the open market rate, the higher the potential of the segment</li>
							<li>Low potential: the lower the population and the lower the open market rate, the lower the potential of the segment</li></ul>'
					),
					'segments' => array(
						'label' => 'Segments',
						'class' => 'non_whole',
						'title'	=> 'This displays a list of segments'
					),
				);
				foreach ($tmp as $field => $arr):
					$disabled = (preg_match('/new_market|potential/', $field)) ? 'disabled="disabled" checked="checked"' : '';
				?>
					<li class="<?php echo $arr['class'] ?> li_<?php echo $field; ?>"><img align="middle" class="handle" src="/css/images/dragger.png" /><label for="opp_label_<?php echo $field; ?>" class="normal"><input <?php echo $disabled; ?> name="fields" type="checkbox" value="<?php echo $field; ?>" id="opp_label_<?php echo $field; ?>"> <strong><?php echo $this->common->tool_tip($arr['title'], $arr['label']); ?> </strong></label></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php /*
	</div>

	<div class="col_left date_column" id="customers_opportunities_datecolumn">
		<div class="date_selectors">
			<?php $this->load->view('includes/checkouts', $subtab); ?>
		</div>
		*/ ?>
		<br class="clear" />
		<br />
		<div class="buttonCont"><input type="image" id="opportunities_show_data" class="refreshButton" src="/graphics/show_data_button.png" value="Show Data" />
			<img class="generate_pdf_report" src="/graphics/reports_icon2.png" style="cursor:pointer; display:none" onclick="SaveOpportunitiesReport()">
		</div>
		<div id="data_variable"></div>
	</div>
</form>
	<div class="col_right" id="fc_opportunities_chartcolumn">
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
		    <div id="opportunities_chart" class="chart offscreen" align="center" style="height:100%;">The chart will appear within this DIV. This text will be replaced by the chart.</div>
		</div>
	</div>

<script type="text/javascript">
	function SaveOpportunitiesReport() {
        var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");

		ReportInfo.Init(ReportType.FindNewCustomers, "Opportunities", $('#serviceArea :selected').text(), '');
		ReportInfo.AddReportItem(ReportItemType.Html, $(current_subtab + " .table").html(), '');

		ExportChart("fc_opportunities_chart");	
	}
</script>
