<style type="text/css">
.save-report {
	float:left;
	padding-left:50px;
	width:100px;
}
.this-text {
	font-size:12px;
}
#reportResults table {
	font-size:12px;
}
#reportType {
	font-size:14px;
	font-weight:bold;
}
</style>
<form action="/customeradmin" method="post">
    <div class = "row" style="height:150px">
        <div class="col_left">
            <div class="instructions">Select one of the following report types:</div>
            <input type="radio" name="reporttype" value="1" checked> <span class="this-text">Number by Report/Map Type</span><br />
            <input type="radio" name="reporttype" value="2"> <span class="this-text">Number by Username</span><br />
    <div class="row" style="margin-top:15px; padding:0; height:50px">
        <input src="/graphics/show_data_button.png" type="image" name="run_report" value="Show Data" onclick="runReport(); return false;" >
        <input src="/graphics/reports_icon2.png" type="image" name="save_report" value="Save" onclick="saveReport(); return false;" >
    </div>
        </div>
        <div class="col_left">
            <div class="instructions">Select the desired year:</div>
            <div>
                <select name="reportyear">
                	<?php foreach ($availableyears as $y) {
                		echo '<option value="'.$y->YEAR.'">'.$y->YEAR.'</option>';
                    } ?>
                </select>
            </div>
        </div>
    </div>
</form>
<div style="margin:10px">
<div id="reportType"></div>
<div id="reportResults"></div>
</div>

<script type="text/javascript">
	function runReport() {
		var rtype = $('input[name=reporttype]:checked').val();
		var ryear = $('select[name=reportyear]').val();
		$.get(
				'/customeradmin/run_report',
				'rtype=' + rtype + '&year=' + ryear,
				function(data) {
					$("#reportResults").html(data.Results);
					if (rtype == 1) {
						$("#reportType").html("Reports/Maps By Type");
					} else {
						$("#reportType").html("Number By Username");
					}
				},
				"json"
		);
		return false;
	}
	function saveReport() {
		var rtype = $('input[name=reporttype]:checked').val();
		var ryear = $('select[name=reportyear]').val();
		var format = "pdf";
		var url = '/customeradmin/save_report?rtype='+rtype+'&year='+ryear+'&format='+format;
		popupWindow(url);
	}
	function popupWindow(url) {
		window.open(url,'popViewer','width=850,height=600,toolbars=no,resizable=yes,scrollbars=no,screenX=10,screenY=10,top=10,left=10');
	};
</script>



	

	
