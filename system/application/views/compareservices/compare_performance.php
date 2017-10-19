
<div class="col_left" id="compare_performance_listing" style="float: none;">
	<div class="instructions" style="float: left;">Select a Study Area: <?php echo $this->service_area_menu; ?> &nbsp;</div>
	<div class="imageToggle" style="float: left;width: 60px;">
		<input type="image" value="#" onclick="ChartsToNumbers();" class="selected" src="/graphics/number_button.png"><input type="image" value="%" onclick="ChartsToPercent();" src="/graphics/percent_button.png">
	</div>
	<div class="chartMedian" style="width: 360px;float: right;vertical-align: top;">
		<img src="/graphics/median.gif" alt="Median" /><span id="median" style="width: 260px;vertical-align: top;font-size: 18px;"> = Median, <?php echo $this->median; ?></span>
	</div>
	<br class="clear" />
	<div id="rankCharts">
		<?php
		$i = 0;
		foreach ($ranks as $r => $array):
			++$i;
		?>
			<div id="<?php echo $r; ?>" class="rank_listing_<?php echo ($r == 'population') ? '' : 'in' ?>active">
				<a href="javascript:" onmousedown="setDistrictCharts('<?php echo $r; ?>');"><img src="/graphics/layer.png" alt="" class="chart_layer" /></a>
			<?php echo $this->common->split_and_cap($r, '_'); ?> Rank : <span id="<?php echo $r ?>_rank"><?php echo $array['rank']; ?></span><br />
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="355" height="50" id="myChart<?php echo $i; ?>" >
				<param name="movie" value="/js/fusioncharts/FusionWidgets_Website/Code/Charts/HLinearGauge.swf" />
				<param name="FlashVars" value="&dataXML=<?php echo $array['chart']; ?>">
				<param name="wmode" value="transparent">
				<param name="quality" value="high" />
				<embed src="/js/fusioncharts/FusionWidgets_Website/Code/Charts/HLinearGauge.swf" flashVars="&dataXML=<?php echo $array['chart']; ?>" quality="high" width="355" height="50" name="myChart<?php echo $i; ?>" wmode="transparent" swliveconnect="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			</object>
		</div>
		<?php endforeach; ?>
		</div>
		<div class="district_ranking" id="district_ranking">
		<?php echo $this->districtCharts; ?>
	</div>
	<br style="clear:both;">
</div>