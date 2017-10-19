<form id="market_research_demographics" action="" method="post">
	<div class="col_left" id="customers_summary_field_order">
		<div class="instructions">
			<a style="float: right;" href="/support" target="_blank">Learn More</a>
			<?php echo $this->common->tool_tip('Select data to view in the map below and table/chart to the right. Click on the + sign to drill down to find the data you’re interested in.', 'Select up to 5 values to view <br />in map'); ?>
		</div>
		<div id="sortlist">
			<ul id="field-list" class="demographics_list">
				<?php
				$i = 1;
				foreach ($demographics as $d) {
					$class = ($i % 2) ? 'even' : 'odd';
					echo '<li id="listItem_' . $i . '" class="' . $class . '"><span><strong> + ' . $d->NAME . '</strong></span>';
					if (isset($d->subs) && count($d->subs) > 0) {
						echo '<ul class="dem_subs" id="dem_subs_' . $i . '">';
						$x = 1;
						foreach ($d->subs as $s) {
							$subclass = ($x % 2) ? 'even' : 'odd';
							++$x;
							echo '<li class="' . $subclass . '"  id="sub_' . $s->ID . '"><span><strong> + ' . $s->NAME . '</strong></span>';
							if (isset($s->rows) && count($s->rows) > 0) {
								echo '<ul class="dem_rows" id="dem_rows_' . $i . '">';
								$y = 1;
								foreach ($s->rows as $row) {
									$rowclass = ($y % 2) ? 'even' : 'odd';
									++$y;
									echo '
									<li class="row ' . $rowclass . '" id="row_' . $row->ID . '">
										<input type="checkbox" value="' . $row->ID . '" name="demographic" id="demographic_' . $row->ID . '">
										<label for="demographic_' . $row->ID . '"><strong>' . $row->NAME . '</strong></label>
									</li>';
								}
								echo '</ul>';
							}
							echo '</li>';
						}
						echo '</ul>';
					}
					elseif (isset($d->rows) && count($d->rows) > 0) {
						echo '<ul class="dem_rows">';
						$z = 1;
						foreach ($d->rows as $row) {
							$class = ($z % 2) ? 'even' : 'odd';
							++$z;
							echo '
							<li class="row ' . $class . '" id="row_' . $row->ID . '">
								<input type="checkbox" value="' . $row->ID . '" name="demographic" id="demographic_' . $row->ID . '">
								<label for="demographic_' . $row->ID . '"><strong>' . $row->NAME . '</strong></label>
							</li>';
						}
						echo '</ul>';
					}
					echo '</li>';
					++$i;
				}
				?>
			</ul>
		</div>
	</div>
	<div class="col_left" id="service_area_select">
		<div class="instructions">
			<?php echo $this->common->tool_tip('Select larger geographic areas you’d like to compare local data to in the table/chart to the right. (The larger geographic area is not be shown in the map below.) For example, you can compare the data in a Census block group that you select to a service area, Clark County, or the State of Nevada. This will help you to “normalize” or see how the local data stacks up to other areas.', 'Compare geographies (for the chart <br />or table)'); ?>
			</div>
			<div id="selectList">
			<?php if (isset($service_areas)): ?>
					<div class="checkToggle">
						<a href="#" style="padding:4px;" id="checkall">check all</a>
					</div>
					<ul id="service-area-list">
				<?php foreach ($service_areas as $sa): ?>
						<li><label for="sa_<?php echo $sa->AREA_ID ?>"><input name="service_area" type="checkbox" id="sa_<?php echo $sa->AREA_ID ?>" value="<?php echo $sa->AREA_ID ?>"><strong> <?php echo $sa->AREA ?></strong></label></li>
				<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
		<br class="clear" />
		<div class="buttonCont"><input style="float: right;" type="image" src="/graphics/show_data_button.png" value="Show Data" id="demographics_show_data" />
			<img class="generate_pdf_report" src="/graphics/reports_icon2.png" style="cursor:pointer; display:none" onclick="SaveSummaryReport()">
		</div>
	</div>
</form>
<div class="col_right" id="mr_demographics_rightcolumn">
	<div class="controls" style="display: none;">
		<div style="float:left;">
			<span class="biggify"> [ + ] &nbsp;&nbsp;&nbsp;&nbsp;</span>
			<div class="displaytype normal toggleSelect selected">Table</div>
			<div class="displaytype inverted toggleSelect">Chart</div>
			<span class="pivottype">Toggle View:</span>
			<div id="toggle_analysis_way" class="toggle_analysis_way pivottype inverted toggleSelect">By Statistic</div>
			<div id="toggle_analysis_area" class="toggle_analysis_area pivottype normal toggleSelect selected">By Area</div>
		</div>
	</div>
	<br style="clear:both;" />
	<div id="mr_demographics_chartcolumn">
		<div class="table" id="table" style="width:100%;"></div>
		<div id="mr_demographics_chart" class="chart offscreen" align="center" style="height:100%;">The chart will appear within this DIV. This text will be replaced by the chart.</div>
	</div>
</div>