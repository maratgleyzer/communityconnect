<img class="generate_pdf_report" src="/graphics/reports_icon2.png" style="cursor:pointer; display:none" onclick="<?php echo $saveFunction; ?>();">
<div style="text-align:right">
	<a href="#" onclick="EnableReportSaveButton('<?php echo $reportName; ?>');">enable</a><br/>
    <div id="<?php echo $reportName; ?>SaveBtn" onclick="$('#<?php echo $reportName; ?>SaveBtn').save_report();" style="cursor:pointer">
    	<img id="<?php echo $reportName; ?>SaveBtnImage" src="/graphics/disabled_report.png" height="32" width="32" alt="" />
    </div>
</div>
<script type="text/javascript">
	$("#<?php echo $reportName; ?>SaveBtn").entwine({
		IsEnabled: false,
		save_report: function() {
			if(!this.getIsEnabled())
				alert('Please run the report before attempting to save.');
			else {
				<?php echo $saveFunction; ?>();
				ShowSaveDialog('/reports/show_save_dialog?rname=<?php echo $reportName; ?>&icount=<?php echo $imageCount; ?>&rtype=<?php echo $reportType; ?>');
			}
     	}, 
     	enable_report: function() {
			this.setIsEnabled(true);
			$("#<?php echo $reportName; ?>SaveBtnImage").attr("src","/graphics/enabled_report.png");
		}
	});
	$(document).ready(function() {
		$('body').append('<input type="hidden" id="<?php echo $reportName; ?>DataList" value="<?php echo $dataList; ?>">');
		$('body').append('<input type="hidden" id="<?php echo $reportName; ?>ImageList" value="">');
	})
</script>
