	reports_too_large_to_pdf = false;
	too_big_mesg = "Your current output data is too large to export into an Adobe Acrobat document. In the next release of this product, you will have the option to export such results to Microsoft Excel. For now, please reduce the amount of data displayed to be able to save your results.";

	function ShowSaveDialog(url) {
		window.open(url,'popViewer','width=850,height=600,toolbars=no,resizable=yes,scrollbars=no,screenX=10,screenY=10,top=10,left=10');
	};
	
	function EnableReportSaveButton(reportName) {
		$('#' + reportName + 'SaveBtn').enable_report();
	}
	
	function SetReportImages(reportName, imageList) {
		$('#' + reportName + 'ImageList').val(imageList);
	}

var ReportItemType = {"Html" : 0, "Image" : 1};
var ReportType = {"FindNewCustomers" : 1, "IncreaseServices" : 2, "LiteracyDecision" : 3, "CompareServiceAreas" : 4, "MarketResearch" : 5, "ModelSegments" : 6};

var ReportInfo = {
	AddReportItem: function(type, source, heading) {
		if (type == 0) {
			var first_row_pattern = /thead[\s\S]*?([^<]*)<\/thead>/gi;
			var matches = source.match(first_row_pattern);
			var first_row = matches[0];
			var ths = first_row.match(/<th /gi);
			if (ths && ths.length > 10) {
				alert(too_big_mesg + "  The table is too large for the pdf report. Please limit the table to 10 or less columns.");
				reports_too_large_to_pdf = true;
			}
		}
		var itemjson = '{"type": "' + type + '", "source": "' + escape(source.replace(/\r|\n|\r\n/g, '')) + '", "heading": "' + heading + '"}';
		var reportItems = $("#report_items").val();
		reportItems += (reportItems != '' ? ',' : '') + itemjson;
		$("#report_items").val(reportItems);
	},
	Init: function(reportType, reportName, geographicArea, queryDescr) {
		reports_too_large_to_pdf = false;
		$("#report_items").val('');
		$("#report_name").val(reportName);
		$("#report_type").val(reportType);
		$("#report_querydescr").val(queryDescr);
		$("#report_geographicarea").val(geographicArea);
	},
    Initialize: function() {
		$(document).ready(function() {
			$('body').append('<input type="hidden" id="report_items" value="">');
			$('body').append('<input type="hidden" id="report_name" value="">');
			$('body').append('<input type="hidden" id="report_type" value="">');
			$('body').append('<input type="hidden" id="report_querydescr" value="">');
			$('body').append('<input type="hidden" id="report_geographicarea" value="">');
			$('body').append('<div id="save_report_dialog" style="display:none" />');

			$('<div id="qtip-blanket">')
			  .css({
				 position: 'absolute',
				 top: $(document).scrollTop(),
				 left: 0,
				 height: $(document).height(),
				 width: '100%',
			
				 opacity: 0.7,
				 backgroundColor: 'black',
				 zIndex: 5000
			  })
			  .appendTo(document.body)
			  .hide(); 
		});

	}
};

ReportInfo.Initialize();

function ShowSaveDialog() {
	$('#save_report_dialog').qtip({
		content: {
			title: {
				text: 'Save Report',
				button: 'Close'
			},
		 	url: '/reports/show_save_dialog'
	  	},
	  	position: {
			target: $(document.body),
			corner: 'center'
	  	},
	  	hide: false,
		show: { ready: true
	  	},
		style: {
			width: '500px',
		 	padding: '14px',
		 	border: {
				width: 9,
				radius: 9,
				color: '#666666'
		 	},
		 	name: 'light'
	  	},
	  	api: {
			beforeShow: function() {
				$('#qtip-blanket').fadeIn(this.options.show.effect.length);
		 	},
		 	beforeHide: function() {
				$('#qtip-blanket').fadeOut(this.options.hide.effect.length);
		 	}
	  	}
	});
}

function ShowWaitDialog() {
	$('#save_report_dialog').qtip({
		content: {
			title: {
				text: 'Please Wait...'
			},
		 	text: 'Report assets are being prepared on the server.  This can take up to several minutes.  Thank you for your patience.'
	  	},
	  	position: {
			target: $(document.body),
			corner: 'center'
	  	},
	  	hide: false,
		show: { ready: true
	  	},
		style: {
			width: '300px',
			height: '50px',
		 	padding: '14px',
		 	border: {
				width: 9,
				radius: 9,
				color: '#666666'
		 	},
		 	name: 'light'
	  	},
	  	api: {
			beforeShow: function() {
				$('#qtip-blanket').show();
		 	},
		 	beforeHide: function() {
				$('#qtip-blanket').hide();
		 	}
	  	}
	});
}

function CloseWaitDialog() {
	$("#save_report_dialog").qtip("hide");
	$("#save_report_dialog").qtip("destroy");
}


function fc_export_callback(data){
	ReportInfo.AddReportItem(ReportItemType.Image, data.fileName, '');
	CloseWaitDialog();
	ShowSaveDialog();
}

function ExportChart(chartId) {
	if (reports_too_large_to_pdf) return false;

	var exportThisChart = getChartFromId(chartId);
	//alert('width = ' + exportThisChart.width);
	if (exportThisChart.width > 950) {
		alert(too_big_mesg + "  This chart is too large for the pdf report.  (> 950 pixels wide)");
	} else {
		if (typeof exportThisChart.hasRendered != 'function')  {
			alert('chart.hasRendered() missing');
		} else { 
	   	exportThisChart.exportChart();
	   	ShowWaitDialog();
		}
	}
}

// Save Report Dialog Functions/Vars
var redirect = false;

function SaveReport(r) {
	redirect = r;
	$('#rtype').val($('#report_type').val());
	$('#rtitle').val($('#report_name').val());
	$('#geoarea').val($('#report_geographicarea').val());
	$('#reportitems').val($('#report_items').val());
	$('#querydescr').val($('#report_querydescr').val());
	$.post("/reports/save_report", $("#savereport").serialize(), HandleSaveReportResults);
}

function CloseSaveReportDialog() {
	$("#save_report_dialog").qtip("hide");
	$("#save_report_dialog").qtip("destroy");
}

function HandleSaveReportResults(data) {
	if(data != "OK") {
		$("#messages").html(data);
	} else {
		var rtype = $('#rtype').val();
		CloseSaveReportDialog();
		if(redirect) window.location='/reports?rtype=' + rtype;
	}
}

