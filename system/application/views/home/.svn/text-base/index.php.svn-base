<?php $this->load->view('includes/header'); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#serviceArea").setAreas(<?php echo $areas_json ?>);
		$(".analysis_level").setSegments(<?php echo $segments_json ?>);
		$(".analysis_level").setAllSegments(<?php echo $distinct_segments_json ?>);
		$("#serviceArea").refreshMethods();

	});
</script>

<div id="home">
	<div class="ptitle">Welcome to CommunityConnect with LiteracyDecision</div>
	<p>CommunityConnect is an interactive application designed to assist you to deliver better library services to your community.</p>

	<div id = "connectBy">
		<h2>Connect to my community by:</h2>
		<p>To get started, click on one of the tabs above or select one of the options below.</p>
		<ul class="connectBy">
			<li><a href="/findcustomers">Find new customers</a></li>
			<li><a href="/increaseservices">Increase services</a></li>
			<li><a href="/literacydecision">Improve literacy</a></li>
			<li><a href="/compareservices">Get service area information</a></li>
			<li><a href="/marketresearch">Prepare market research</a></li>
			<?php if ($this->session->userdata('uid') > 0): ?>
				<li><a href="/reports">Go to reports</a></li>
			<?php endif; ?>
		</ul>
	</div>

	<?php /*
	  <div id ="beenHere">
	  <h2>Been Here Before?</h2>
	  <div id="serviceAreas">
	  <h3>Service Areas <?php echo $this->common->tool_tip('Select a service area to study or compare with others'); ?></h3>
	  <p>Jump to a particular service area</p>
	  <form action="modelsegment.php">
	  <?php echo _buildServiceAreaList($service_areas, ''); ?>
	  <input type="image" class="gobutton" src="css/images/gobutton.png" value = "Go" onclick="window.location='modelsegment.php';"/>
	  </form>
	  </div>
	  </div>
	 */ ?>
	<div id="segments">
		<h2><?php echo $this->common->tool_tip('There are XX segments in the Las Vegas Clark County Library District. For more information about segments, click here.', 'Segments'); ?></h2>
		<p>To jump to a particular segment, first select the geography and then select the segment:</p>
		<form method="post" id = "segmentSelect" action="/modelsegments">
			<select id="serviceArea" class="styled" name="serviceArea" onChange="setServiceArea()">
				<option value="Whole_District">Whole District</option>
				<?php
				$user_sa = $this->session->userdata('STUDYAREA');
				$excluded = $this->config->item('excluded_service_areas'); // these have 'no data' per daag
				foreach ($service_areas as $sa) {
					if (in_array($sa->AREA_ID, $excluded))
						continue;
					$selected = ($user_sa != '' && $user_sa == $sa->AREA_ID) ? 'selected="selected"' : '';
					?>
					<option value="<?php echo $sa->AREA_ID; ?>" <?php echo $selected; ?>><?php echo $sa->AREA; ?></option>
<?php } ?>
			</select>

			<br /><br />
			<select class="analysis_level" name="sg" id="selectSegment">
				<option value="">All Segments</option>
			</select><br /><br />
			<input type="image" class="gobutton" src="css/images/gobutton.png" value = "Go"/>
		</form>
	</div>

</div>
</div>
<?php $this->load->view('includes/footer'); ?>
