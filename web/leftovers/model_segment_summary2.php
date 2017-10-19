
<script type="text/javascript" src="fusioncharts/FusionCharts_Website/Charts/FusionCharts.js"></script>
<div class="col_left" id="customers_summary_field_order">
	<div>View and Select Segments <div id="dataselecttip" class="tip"><img src="css/images/question.png" width="16" height="14" alt="" /></div></div>
	
    <div id="sortlist">
        <link rel='stylesheet' href='css/sort_list.css' type='text/css' media='all' />
	
        <ul id="field-list">
            <li id="listItem_1"><strong> + Population </strong></li>
            <li id="listItem_2"><strong> + Potential </strong></li>
            <li id="listItem_3"><strong> + Checkouts </strong></li>
            <li id="listItem_4"><strong> + Open Markets </strong></li>
			<li id="listItem_4"><strong> + Patrons </strong></li>
            <li id="listItem_5"><strong> <div class="imageToggle" >
        </ul>
  </div>
</div>

<div class="col_left" id="service_area_select">
	<div>Findings <div id="geographiestip" class="tip"><img src="css/images/question.png" width="16" height="14" alt="" /></div></div>
    <div id="selectList">
			<div class="checkToggle">
        <!-- <a href="#" style="padding:4px;">Check All</a> <a href="#" style="padding:4px;">Uncheck All</a> -->
			</div>
        <ul id="service-area-list">
					            </ul>
					      </div>
					    </div>

					 <div class="gen-chart-render">

                        <center>
                            <div id="chartContainer">FusionCharts will load here</div>

                            <script type="text/javascript"><!--

                                var myChart = new FusionCharts("fusioncharts/FusionCharts_Website/Charts/Column2D.swf", "myChartId", "430", "300", "0", "1");
                                myChart.setJSONUrl("json/ModelSegmentSample2.json");
                                myChart.render("chartContainer");

                                // -->
                            </script>
                        </center>

                    </div>