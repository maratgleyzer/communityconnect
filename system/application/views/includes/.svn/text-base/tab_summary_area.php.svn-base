<?php if (!$skip_studyarea): ?>
<?php //if ($this->uri->segment('1') != 'compareservices'): ?>
<div id="studySelect">
	<p>Select a Study Area:
	<select id="serviceArea" class="styled" name="serviceArea">
		<option value="Whole_District">Whole District</option>
		<?php
		$user_sa = $this->session->userdata('STUDYAREA');
		$excluded= $this->config->item('excluded_service_areas'); // these have 'no data' per daag
		foreach ($service_areas as $sa) {
			if (in_array($sa->AREA_ID, $excluded)) continue;
			$selected = ($user_sa != '' && $user_sa == $sa->AREA_ID)?'selected="selected"':'';
		?>
		<option value="<?php echo $sa->AREA_ID;?>" <?php echo $selected; ?>><?php echo $sa->AREA; ?></option>
	<?php } ?>
	</select>
	</p>
</div>
<div id="profiletitle" class="ptitle"><?php echo $currentServiceArea?></div>
<?php endif; ?>
<div id="profile" class="box narrow">
	<div id="servicestitle" class="stitle"><?php echo $this->common->tool_tip('This is a general description of '.$page_name, 'Summary'); ?>
		<p class="sumText"><span><?php echo $summary_text?> </span></p>
	</div>
</div>
<?php if (!isset($skip_daag) || !$skip_daag): ?>
<div id="dataglance" class="box wide" style="width: 550px">
	<div id="dataglancetitle" class="stitle"><?php echo $this->common->tool_tip('This presents key data about the geography you selected above
', 'Data at a Glance'); ?></div>
	<div id="dataglanceContent"> <?php echo $data_at_a_glance['table']; ?> </div>
</div>
<?php endif; ?>
