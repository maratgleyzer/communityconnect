<?php $this->load->view('includes/header'); ?>

<?php
$summary['page_name'] = 'Literacy Decision';
$this->load->view('includes/tab_summary_area', $summary);
?>
	<div id="discover" class="box full" style="height:370px">
		<div id="discovertitle" class="stitle">Discover</div>
		<div class="content">
		<ul class="ultabs">
			<li><a href="#literacytab"><?php echo $this->common->tool_tip('This provides a literacy profile for your selected areas', 'Literacy Profile'); ?></a></li>
			<!-- 
			<li><a href="#demographictab"><?php echo $this->common->tool_tip('This provides a demographic profile for your selected areas; use this data in relation to the Literacy Profile', 'Demographic Profile'); ?></a></li>
			<li><a href="#libraryusetab"><?php echo $this->common->tool_tip('This provides a library use profile for your selected areas; use this data in relation to the Literacy Profile', 'Library Use Profile'); ?></a></li>
			<li><a href="#schooltab"><?php echo $this->common->tool_tip('This provides a school profile for your selected areas; use this data in relation to the Literacy Profile', 'School Profile'); ?></a></li>
			<li><a href="#employmenttab"><?php echo $this->common->tool_tip('This provides a employment profile for your selected areas; use this data in relation to the Literacy Profile', 'Employment Profile'); ?></a></li>
	   		-->
		</ul>
		<div id="literacytab" class="tab"><?php $this->load->view('literacydecision/literacy.php');?></div>
		<!-- <div id="demographictab" class="tab"><?php $this->load->view('literacydecision/demographic.php'); ?></div>
		<div id="libraryusetab" class="tab"><?php $this->load->view('literacydecision/library_use.php'); ?></div>
		<div id="schooltab" class="tab"><?php $this->load->view('literacydecision/school.php'); ?></div>
		<div id="employmenttab" class="tab"><?php $this->load->view('literacydecision/employment_profile.php'); ?></div> -->
		</div>
	</div>

	<?php $this->load->view('includes/map'); ?>
</div><!--End DIV main-->
<?php $this->load->view('includes/footer'); ?>
