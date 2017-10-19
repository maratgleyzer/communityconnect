
civic.load('.literacyDecision, .compareservices, .increaseServices, .findCustomers, .homePage, .modelSegments, .marketResearch', function($) {

	var increase_services_areas = null;
	var increase_services_segments = null;
	var all_distinct_segments = null;
	var	increase_services_items = null;
	var	increase_services_materials = null;
	var increase_services_chart_data = null;
	var increase_services_chart_width = 450;
	var increase_services_ops_table_data = null;

	var data_table_array = "";
	var inverted = false;

	function getJSON(url, data, success) {
		if (url == null) {
			url = "common_ajax/delegate";
		}
		$.ajax({
			type: 'GET',
			url: url,
			data: data,
			dataType: 'json',
			success: success,
			error: function(x, y, z) {
				console.log ("error: " + x + " : " + y + " : " + z);
			}
		});
	}

	$('select').entwine({
		loadData: function(data) {
			this.html('');
			for(var i=0; i<data.length; i++) {
				this.append('<option value="' + data[i].value + '">' + data[i].label + '</option>');
			}
		}
	});

	$('#serviceArea').entwine({
		setAreas: function (data) {
			increase_services_areas = data;
		},
		onchange: function() {
			this.refreshMethods();
		},
		refreshMethods: function() {
			var this_page = $('body').attr("class");
			if (this_page == "homePage" || this_page == "increaseServices") {
			if ('Whole_District' == this.val()) {
				if (this_page == "homePage") {
					$('.analysis_level').loadAllSegments();
				} else {
					$('.analysis_level').loadData(increase_services_areas);
				}
				$('#op_analysis_level').loadData(increase_services_areas);
			} else {
				$('.analysis_level').loadSegments(this.val());
				$('#op_analysis_level').loadSegments(this.val());
			}
		}
		}
	});

	$('.analysis_level').entwine({
		setSegments: function (data) {
			increase_services_segments = data;
		},
		setAllSegments: function (data) {
			all_distinct_segments = data;
		},
		loadSegments: function(sa) {
			this.html('');
			for(var i=0; i<increase_services_segments.length; i++) {
				if (sa == increase_services_segments[i].area_id) {
					this.append('<option value="' + increase_services_segments[i].value + '">' +
						increase_services_segments[i].label + '</option>');
				}
			}
		},
		loadAllSegments: function() {
			this.html('');
			for(var i=0; i<all_distinct_segments.length; i++) {
				this.append('<option value="' + all_distinct_segments[i].label + '">' + all_distinct_segments[i].label + '</option>');
			}
		}
	});


	$('.services_choice').entwine({
		setMaterials: function (data) {
			increase_services_materials = data;
		},
		setItems: function (data) {
			increase_services_items = data;
		},
		onchange: function() {
			this.processMenuChange();
		},
		onblur: function() {
			this.processMenuChange();
		},
		processMenuChange : function() {
			var choice = $(this).val();
			var parent_div = "#" + $(this).parent().parent().attr("id");
			var parent_form = "#" + $(this).parent().parent().parent().attr("id");
			// clean up the checkboxes and selections
			// when we switch data variable
			$(parent_div + ' .data_variable_items input').attr("checked", false);
			$(parent_div + ' .data_variable_items select').attr("checked", false);
			$(parent_div + " .other_items_choice").each(function() {
				$(parent_div + " .other_items_choice option").attr("selected", "");
			});
			$(parent_div + " .material_type").each(function() {
				$(parent_div + " .material_type option").attr("selected", "");
			});

			$(parent_div + ' .data_variable_items select').attr("checked", false);
			// set the approriate widgets
			if (choice == 'materials') {
				$(parent_form + " .toggle_analysis_way").html("Material Types");
				$(parent_div + " .data_variable_items").hide();
				$(parent_div + " .data_variable").show();
				$(parent_div + ' .data_variable select').loadTypes($(this).val());
			} else if (choice == 'items_specific') {
				$(parent_form  + " .toggle_analysis_way").html("Item Types");
				$(parent_div + " .data_variable_items").hide();
				$(parent_div + " .data_variable").show();
				$(parent_div + ' .data_variable select').loadTypes($(this).val());
			} else if (choice == 'items_category') {
				$(parent_form + " .toggle_analysis_way").html("Item Types");
				$(parent_div + " .data_variable").hide();
				$(parent_div + " .data_variable_items").show();
			}
			$(parent_form + ' input[type="image"]').removeAttr('disabled');

		}
	});

	$('.data_variable select').entwine({
		loadTypes: function(type) {
			var self = this;
			if (type == 'materials') {
				self.parent().show();
				$('#performance_form input[type="image"]').removeAttr('disabled');
				return self.loadData(increase_services_materials);
			}
			if (type == 'items_specific') {
				self.parent().show();
				$('#performance_form input[type="image"]').removeAttr('disabled');
				return self.loadData(increase_services_items);
			}
			$('#performance_form input[type="image"]').attr('disabled', 'disabled');
			self.parent().hide();
		}
	});

	$('.checkouts input').click(function() {
		var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");
		if ($(this).val() == 'range') {
			$(current_subtab + ' .daterange input').removeAttr('disabled');
			$(current_subtab + ' .startdate, .enddate').datepicker({
				buttonImage: '/graphics/calendar.png',
				buttonImageOnly: true,
				showOn: 'button'
			});
			$('.date').datepicker('enable');
		}
		else {
			$(current_subtab + ' .daterange input').attr('disabled', 'disabled');
			$(current_subtab + ' .daterange').datepicker('disable');
		}
		return true;
	});

	$('.range_selection input[type="radio"]').click(function() {
		var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");
		var datarange = $(current_subtab + " .datarange_fillin");
		var selection = $(this).val();
		if (selection == 'range') {
			$(datarange).show();
		} else {
			$(datarange).hide();
		}
	});

	function invertData(data) {
		var inverted = [];
		for(var row=0; row<data[0].length; row++) {
			inverted[row] = [];
		}
		for(var row=0;row<data.length;row++) {
			for(var col=0;col<data[row].length;col++) {
				inverted[col][row] = data[row][col];
			}
		}
		return inverted;
	}

	$('.table').entwine({
		register: function(data) {
			this.data('data', data);
		},
		pivot: function(invert) {
			if (invert) {
				inverted = true;
				this.render(invertData(this.data('data')));
			} else {
				inverted = false;
				this.render(this.data('data'));
			}
		},
		render: function(data) {
			this.html('');
			var html = '<table class="pivot tableSorter"><thead>';
			var foot = '';
			var align = '';
			for(var row=0; row<data.length; row++) {
				if (data[row][0] == '') continue;
				if (row == 0) {
					html += '<tr class="header">';
				} else {
					if (inverted) html += '<tr>';
					else html += '<tr class="clickable">';
				}
				for(var col=0; col<data[row].length; col++) {
					align = (col > 0) ? 'style="text-align: right;"' : '';
					html += (0 == row || 0 == col ? '<th class="header inner {sorter: \'commaDigit\'}">' : '<td ' + align + '>');
					html += data[row][col];
					html += (0 == row || 0 == col ? '</th>' : '</td>');
				}
				html += '</tr>';
				if (row == 0) html += '</thead><tbody>';
			}
			html += '</tbody></table>';
			this.html(html);
		}
	});

	$(".table").delegate("tr", "click", function(){
		if (inverted) return false;
		var trc = $(".table tbody").children();
		var idx = trc.index(this)+1;
		if (idx > 0) {
			var i = 0;
			var tdc = $(this).children();
				tdc.each(function() {
					++i;
				if (($(this).html().match(/[^0-9\.\,]+/i)) && (i > 1)) {
					alert("This row contains textual information, and cannot be rendered on the map.");
					return false;
				}
			});
			trc.each(function(){
				var etrc = $(this).children();
				etrc.css("background-color","").length;
			});
			tdc.css("background-color","#ff0").length;
			map.queryAndDisplayTableData_ChangeDisplayIndex(idx);
		}
	});

	function validate_increase_services(form_id) {
		// some validation
		var pal = $(form_id + " .analysis_level").val();
		if (pal == "" || pal == null) {
			alert ("Please select a library/segment");
			return false;
		}
		var psc = $(form_id + " .services_choice").val();
		if (psc == "__default") {
			alert ("Please select a way to analyze the data.");
			return false;
		}
		if (form_id == "#performance_form") {
			var pmt = null;
			if (psc != 'items_category') {
				pmt = $(form_id + " .material_type").val();
				if (pmt == "" || pmt == null) {
					alert ("Please select a material or item type.");
					return false;
				}
			} else {
				pmt = $(form_id + ' input[name="data_variable[]"]:checked').val();
				if (pmt == "" || pmt == null) {
					alert ("Please select an item category.");
					return false;
				}
			}
		}

		var get_total_checkouts = false;
		if ($(form_id + ' input[name="checkouts_mode"]:checked').val() == 'total') {
			get_total_checkouts = true;
		}
		if (!get_total_checkouts) {  // check end and start dates
			var startdate = new Date($(form_id + ' input[name="startdate"]').val());
			var enddate = new Date($(form_id + ' input[name="enddate"]').val());
			if (enddate < startdate) {
				alert ("Start date must be prior to end date.");
				return false;
			}
		}

		var get_all_data = false;
		if ($(form_id + ' input[name="datarange"]:checked').val() == 'all') {
			get_all_data = true;
		}
		if (!get_all_data) {  // check min and max
			var min = $(form_id + ' input[name="mindata"]').val();
			var max = $(form_id + ' input[name="maxdata"]').val();
			if (min == '') min = '0';
			if (max == '') max = '0';
			if (isNaN(min) || isNaN(max)) {
				alert("Minimum/Maximum values must be numeric.");
				return false;
			}
			min = parseInt(min);
			max = parseInt(max);
			if (max < min && max != 0) {
				alert("Minimum value must be smaller than the maximum value.");
				return false;
			}
		}
		return true;
	}

	$('#performance_form').submit(function() {
		var ret = validate_increase_services("#performance_form");
		if (!ret) return false;

		var get_all_data = false;
		if ($('#performance_form input[name="datarange"]:checked').val() == 'all') {
			get_all_data = true;
		}
		var all_number_type = $('#performance_form input[name="all_data_number_type"].selected').val();
		var selected_number_type = $('#performance_form input[name="selected_data_number_type"].selected').val();
		var number_type = selected_number_type;
		if (get_all_data) {
			number_type = all_number_type;
		}
		var params = 'number_type='+number_type+'&' + $(this).serialize();
		var sa = $('#serviceArea').val();

		if ('Whole_District' != sa) {
			params += '&sa=' + sa;
		}

		var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");
		$(current_subtab + ' .col_right .table ').html('<img class="ajax-loader" src="/css/images/ajax-loader.gif" />');
		$(current_subtab + ' .controls').show();
		// reset the chart sort
		$("#chart_sort select").val("");
		getJSON(
			"increaseservices/renderPerformance",
			params,
			function(data) {
				//alert(data);
				$('#performance_form .table').register(data.table_data.data);
				$('#performance_form .table').pivot(false);
				$('#performance_form .tableSorter').tablesorter();

				data_table_array = data.table_data.data;
				increase_services_chart_data = data.chart_data;
				var row_count = data.row_count;
				var col_count = data.col_count;
				increase_services_chart_width = row_count * col_count * 30;
				if (increase_services_chart_width < 300) increase_services_chart_width = 450;
				draw_2d_chart("is_performance_chart", "performance_chart", increase_services_chart_data, increase_services_chart_width);
				show_report_button('#performance_form');
				$('#performance_form .refreshButton').attr('src','/graphics/refresh_data_button.png');

				if (sa == 'Whole_District' || sa == "__urban" || sa == "__rural") {
					map.queryAndDisplayTableData(data.table_data.data, map.spatialTypes.serviceareas, map.spatialTypes.dataattributes, null, null, 1, map.classifyByRowOrCol.col, true);
				} else {
					var area_text = ($('#serviceArea option[value='+$("#serviceArea").val()+']').text());
					map.queryAndDisplayTableData(data.table_data.data, map.spatialTypes.segments, map.spatialTypes.dataattributes, map.spatialTypes.serviceareas, area_text, 1, map.classifyByRowOrCol.col, true);
				}
				$("#visualize").css("height", "auto");
				FocusFirstRow();
			});

		return false;
	});

	function draw_2d_chart(chart_id, div_id, data, width, height) {
		// height is optional and will default to 300 if not specified
		height = (typeof height == "undefined")?'300':height;
		var myChart = new FusionCharts('/js/fusioncharts/FusionCharts_Website/Charts/MSColumn2D.swf', chart_id, width, height, '0', '1');
		myChart.setJSONData(data);
		myChart.render(div_id);
	}

	function show_report_button(div_id) {
		$.ajax({
			url: '/common_ajax/valid_user',
			success: function(user_id) {
				if (user_id > 0) {
					$(div_id + ' .generate_pdf_report').show();
				}
			}
		});
	}

	function convertOpDataForMapping(data) {
		data = invertData(data);
		// make the 3rd column the first
		var first_row = data[0];
		var second_row = data[1];
		var third_row = data[2];
		data[0] = third_row;
		data[1] = first_row;
		data[2] = second_row;

		return data;
	}

	$('#opportunities_form').submit(function() {
		var form_id = "#opportunities_form";
		var ret = validate_increase_services(form_id);
		if (!ret) return false;
		var get_all_data = false;
		if ($(form_id + ' input[name="datarange"]:checked').val() == 'all') {
			get_all_data = true;
		}
		var all_number_type = $(form_id + ' input[name="all_data_number_type"].selected').val();
		var selected_number_type = $(form_id + ' input[name="selected_data_number_type"].selected').val();
		var number_type = selected_number_type;
		if (get_all_data) {
			number_type = all_number_type;
		}
		var sa = $("#serviceArea").val();
		var params = 'sa='+sa+'&data_variable[]=_all&number_type='+number_type+'&' + $(this).serialize();
		var saName = ($('#serviceArea option[value='+$("#serviceArea").val()+']').text());

		if ('Whole_District' != sa) {
			params += '&sa=' + sa;
		}

		var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");
		$(current_subtab + ' .col_right .table ').html('<img class="ajax-loader" src="/css/images/ajax-loader.gif" />');

		//$(form_id + " .controls").show();
		// reset the chart sort
		getJSON(
			"increaseservices/renderOpportunities",
			params,
			function(data) {
				var tabledata = data.table_data;
				var service_tabs  = data.checkout_ranking;

				// load "all" first
				$(current_subtab + ' .controls').show();
				data_table_array = convertOpDataForMapping(tabledata[0].data);
				$('#opportunities_form .table').register(data_table_array);
				$('#opportunities_form .table').pivot(false);
				$('#opportunities_form .tableSorter').tablesorter();


				// save all the other table data around for when someone clicks
				// on another service tab
				increase_services_ops_table_data = tabledata;

				// let's save them service tabs on the left hand side.
				$.each(service_tabs, function (idx, obj) {
					var new_div_id = "is_op_st_" + idx;
					$("#is_op_st_" + idx + " .service").html(obj.chart.service);
					var per = obj.chart.percent;
					if (obj.chart.percent == 100)
						per = 82;
					$("#is_op_st_" + idx + " .actual").css("width", per + "%");
					if (number_type == "percent") {
						$("#is_op_st_" + idx + " .mylabel").html(obj.chart.percent + "%");
					} else {
						$("#is_op_st_" + idx + " .mylabel").html(obj.chart.checkouts+ " checkouts");
					}
					$("#is_op_st_" + idx).show();

				});
				// default with the "all" service tab selected
				$('.service-tab').removeClass('service-tab-selected');
				$("#is_op_st_0").addClass("service-tab-selected");
				$("#opportunities_chartcolumn").show();
				$(form_id + ' .service_rank').show();
				show_report_button(form_id);
				// $(form_id + ' .generate_pdf_report').show();
				$(form_id + ' .table_title').show();
				$('#opportunities_form .refreshButton').attr('src','/graphics/refresh_data_button.png');
				$('#opportunities_form #opportunities_chartcolumn').css('background-color','#c3daf9');

				map_for_is_opportunities(data_table_array);
			});

		return false;
	});

	function map_for_is_opportunities(data_table_array) {
		var sa = $("#serviceArea").val();
		var saName = ($('#serviceArea option[value='+$("#serviceArea").val()+']').text());

		var analysis_text = ($('#opportunities_form .analysis_level option[value='+$("#opportunities_form .analysis_level").val()+']').text());

		if (sa == 'Whole_District' || sa == "__urban" || sa == "__rural") {
			if ('-- All --' != analysis_text)
				map.queryAndDisplayTableData(data_table_array, map.spatialTypes.blockgroups, map.spatialTypes.dataattributes, null, null, 1, map.classifyByRowOrCol.col, true);
			else map.queryAndDisplayTableData(data_table_array, map.spatialTypes.serviceareas, map.spatialTypes.dataattributes, null, null, 1, map.classifyByRowOrCol.col, true);
		} else {
			map.queryAndDisplayTableData(data_table_array, map.spatialTypes.blockgroups, map.spatialTypes.dataattributes, map.spatialTypes.serviceareas, saName, 1, map.classifyByRowOrCol.col, true);
		}
		$("#visualize").css("height", "auto");
		FocusFirstRow();
	}

	$('.service-tab').click(function() {
		$("#is_op_st_0 .actual").css("width", "87%");
		$('.service-tab').removeClass('service-tab-selected');
		$($(this)).addClass('service-tab-selected');
		// determine index
		var idx = $(this).attr("id").split("_")[3];
		if (idx == 0) {
			$("#is_op_st_0 .actual").css("width","82%");
			$(".ops_data_table").css("padding-top", "0em");
		}
		if (idx > 0) {
			var dif = (6.8 * idx) + 0;
			$(".ops_data_table").css("padding-top", dif+"em");
		}
		var tabledata = convertOpDataForMapping(increase_services_ops_table_data[idx].data) ;
		$('#opportunities_form .table').html("");
		$('#opportunities_form .table').register(tabledata);
		$('#opportunities_form .table').pivot(false);
		$('#opportunities_form .tableSorter').tablesorter();

		map_for_is_opportunities(tabledata);
	});

	$('#is_ops_gen_report').click(function() {
		var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");
        var tabledata = increase_services_ops_table_data;

		var html = "";
        $.each(tabledata, function(idx, table) {
			var data = table.data;
			var title = $("#is_op_st_"+idx+" .service").html() + ": " + $("#is_op_st_"+idx+" .mylabel").html();
			//html += $("#is_op_st_"+idx).html();
			html += '<h2>'+title+"</h2>";
			html += '<table>';
			var align = '';
			for(var row=0; row<data.length; row++) {
				if (data[row][0] == '') continue;
				if (row == 0) {
					html += '<tr>';
				} else {
					html += '<tr>';
				}
				for(var col=0; col<data[row].length; col++) {
					//align = (col > 0) ? 'align="right"' : '';
					html += (0 == row || 0 == col ? '<th>' : '<td>');
					html += (data[row][col]);
					html += (0 == row || 0 == col ? '</th>' : '</td>');
				}
				html += '</tr>';
			}
			html += '</table>';
        });
		ReportInfo.Init(ReportType.IncreaseServices, "Opportunities", $('#serviceArea :selected').text(), 'Block Group Opportunities');
       	ReportInfo.AddReportItem(ReportItemType.Html, html, '');
	   	ShowSaveDialog('/reports/show_save_dialog');
	});

	$('.controls div.pivottype').click(function() {
		var current_subtab = $(".full .ultabs .ui-tabs-selected a").attr("href");
		var table = $(current_subtab).find(".table");
		$(this).parent().find('div.pivottype').not(this).removeClass('selected');
		$(this).addClass('selected');
		$(table).pivot($(this).is('.inverted'));
		$(current_subtab + ' .tableSorter').tablesorter();
	});

	$('.controls div.displaytype').click(function() {
		var current_subtab = $(".full .ultabs .ui-tabs-selected a").attr("href");
		var table = $(current_subtab).find(".table");
		$(this).parent().find('div.displaytype').not(this).removeClass('selected');
		$(this).addClass('selected');
		var display_type = $(this).html().toLowerCase();
		if (display_type == 'chart') {
			$(table).addClass("offscreen");
			$("#performance_chart, " + current_subtab + ' .chart').removeClass("offscreen");
			$(".pivottype").hide();
			$("#chart_sort, " + current_subtab + ' .chart_sort').show();
		}
		else {
			$(table).removeClass("offscreen");
			$("#performance_chart, "  + current_subtab + ' .chart').addClass("offscreen");
			$(".pivottype").show();
			$("#chart_sort," + current_subtab + ' .chart_sort').hide();
		}
	});

	function sort_chart(sort_type, sort_field) {

		var categories = increase_services_chart_data.categories;
		var dataset = increase_services_chart_data.dataset;

		if (sort_type == 'a_to_z' || sort_type == 'z_to_a') {

			// sort the category names
			categories.sort(function( a, b) {
				var compA = a.category.label.toUpperCase();
				var compB = b.category.label.toUpperCase();
				return (compA < compB) ? -1: (compA > compB) ? 1 : 0;
			});
			if (sort_type == 'z_to_a') {
				categories.reverse();
			}

			// then sort the datasets by category as well
			$.each(dataset, function (idx, item) {
				item.data.sort(function(a, b) {
					var compA = a.category_name.toUpperCase();
					var compB = b.category_name.toUpperCase();
					return (compA < compB) ? -1: (compA > compB) ? 1 : 0;
				});
				if (sort_type == 'z_to_a') {
					item.data.reverse();
				}
			});

			increase_services_chart_data.categories = categories;
			increase_services_chart_data.dataset = dataset;
		} else {
			var new_cat_sort = null;
			$.each(dataset, function (idx, item) {
				// let's sort by the greatest Total and gather a list of
				// the categories in the sorted order.
				if (item.seriesName == sort_field) {
					item.data.sort(function(a, b) {
						var compA = a.value;
						var compB = b.value;
						return (+compA < +compB) ? -1: (+compA > +compB) ? 1 : 0;
					});
					if (sort_type == 'high_to_low') {
						item.data.reverse();
					}
					new_cat_sort = item.data;
				}
			});
			// armed with the new sorted list of categories, let's
			// re-arrange the datasets from within each set of data.
			for (var x = 0; x < dataset.length; x++) {
				var new_data = dataset[x];
				var new_data_data = [];

				for (var i = 0; i < new_cat_sort.length; i++) {

					for (var j = 0; j < dataset[x].data.length; j++) {
						if (dataset[x].data[j].category_name == new_cat_sort[i].category_name) {
							new_data_data.push(dataset[x].data[j]);
						}
					}
				}
				dataset[x].data = new_data_data;
			}

			// now finally sort the categories in the order det. above.
			var new_categories_list = [];
			for (var i = 0; i < new_cat_sort.length; i++) {
				for (var j = 0; j < categories.length; j++) {
					if (categories[j].category.label == new_cat_sort[i].category_name) {
						new_categories_list.push(categories[j]);
					}
				}
			}
			increase_services_chart_data.categories = new_categories_list;
			increase_services_chart_data.dataset = dataset;
		}
	}

	$("#chart_sort select").change(function() {
		var sort_type = $(this).val();
		sort_chart(sort_type, "Total");

		if (window['utility']) {
			draw_2d_chart("ccf_chart", "the_chart", window[window['utility']+'_chart_data'],window[window['utility']+'_chart_width'], '99%');
		}
		else {
			draw_2d_chart("is_performance_chart", "performance_chart", increase_services_chart_data, increase_services_chart_width);
		}

	});

	$('#serviceArea').change(function() {
		setServiceArea();
	});
	// set page heading to selected SA
	$("#profiletitle").html($('#serviceArea :selected').text());

	$('.analysis_level').change(function() {
		var parent_div = "#" + $(this).parent().parent().attr("id");
		var parent_form = "#" + $(this).parent().parent().parent().attr("id");
		var area = $("#serviceArea").val();
		var area_text = ($('#serviceArea option[value='+area+']').text());
		var option_val = $(this).val();
		if (option_val.length > 1) {
			if (area == 'Whole_District') {
				$(parent_form + " .toggle_analysis_area").html("Whole District");
			} else {
				$(parent_form + " .toggle_analysis_area").html(area_text);
			}
		} else {
			if (option_val == '__all') {
				$(parent_form + " .toggle_analysis_area").html(area_text);
			} else {
				var lib_seg = ($(parent_form + ' .analysis_level option[value='+option_val+']').text());
				$(parent_form + " .toggle_analysis_area").html(lib_seg);
			}
		}
	});

	$(".item_checkbox_major input").click(function() {
		if ($(this).is(":checked")) {
			$(this).parent().parent().parent().find(".item_checkbox_leaf input").attr("checked", true);
			$(this).parent().parent().parent().find(".item_checkbox_leaf input").attr("disabled", true);
			if ($(this).val() == 'O') {
				$("#other_items_choice").each(function() {
					$("#other_items_choice option").attr("selected", "selected");
				});
			}
		} else {
			$(this).parent().parent().parent().find(".item_checkbox_leaf input").attr("checked", false);
			$(this).parent().parent().parent().find(".item_checkbox_leaf input").attr("disabled", false);
			if ($(this).val() == 'O') {
				$("#other_items_choice").each(function() {
					$("#other_items_choice option").attr("selected", "");
				});
			}
		}
	});
	$(".item_checkbox_leaf input.minor").click(function() {
		if ($(this).is(":checked")) {
			$(this).parent().find("input.leaf").attr("checked", true);
			$(this).parent().find("input.leaf").attr("disabled", true);
		} else {
			$(this).parent().find("input.leaf").attr("checked", false);
			$(this).parent().find("input.leaf").attr("disabled", false);
		}
	});

	$('.controls span.biggify').toggle(function() {
		var current_subtab = $(".full .ultabs .ui-tabs-selected a").attr("href");
		$(current_subtab + " .col_right").removeClass().addClass('full_width');
		$('.full_width').fadeTo('fast', 0.95);
		$(this).html('<a href="#">[ - ]</a> &nbsp;&nbsp;&nbsp;&nbsp;');
	}, function() {
		var current_subtab = $(".full .ultabs .ui-tabs-selected a").attr("href");
		$(current_subtab + " .full_width").removeClass().addClass('col_right');
		$(this).html('<a href="#">[ + ]</a> &nbsp;&nbsp;&nbsp;&nbsp;');
	});

	/* MODEL SEGMENT  ---- BEGIN --- */

	global_segment_info = null;
	global_ms_tabledata = null;

    $('#selectArea').entwine({
        setAreas: function (data) {
            global_areas = data;
        },
        onchange: function() {
            this.refreshMethods();
        },
        refreshMethods: function(call_service_area) {
            if ('Whole_District' == this.val()) {
				// is a segment already selected?
				var current_segment = $('#selectSegment').val();
                $('#selectSegment').loadAllSegments();
				if (current_segment != '') {
					$('#selectSegment').val(current_segment);
				}
            } else {
                $('#selectSegment').loadSegments(this.val());
				var this_page = $('body').attr("class");
				if (this_page == "modelSegments") {
					var current_segment = $('#selectSegment').val();
					set_segment_info(current_segment);
				}
            }
			if (typeof call_service_area == 'undefined') {
				call_service_area = true;
			}
			if (call_service_area) {
				setServiceArea();
			}
        }
	});

    $('#selectSegment').entwine({
		setSegmentData: function (data) {
            global_segment_info = data;
		},
        setSegments: function (data) {
            global_segments = data;
        },
        setAllSegments: function (data) {
            global_all_segments = data;
        },
        loadSegments: function(sa) {
            this.html('');
            for(var i=0; i<global_segments.length; i++) {
                if (sa == global_segments[i].area_id) {
                    this.append('<option value="' + global_segments[i].label + '">' +
                        global_segments[i].label + '</option>');
                }
            }
        },
        loadAllSegments: function() {
            this.html('');
            for(var i=0; i<global_all_segments.length; i++) {
                this.append('<option value="' + global_all_segments[i].label + '">' + global_all_segments[i].label + '</option>');
            }
        },
		refreshInfo: function(current_segment) {
			set_segment_info(current_segment);
		}
    });




	function set_segment_info(segment) {
		$("#profiletitle").html(segment);
		var segment_data = global_segment_info;
		for (var i = 0; i < segment_data.length; i++) {
			if (segment_data[i].segment == segment) {
				$("#aboutmetab .sumText span").html(segment_data[i].about_me);
				$("#myprefstab .sumText span").html(segment_data[i].my_preferences);
				$("#connecttab .sumText span").html(segment_data[i].connect_with_me);
			}
		}
	}

    $("#selectSegment").change(function() {
		var this_page = $('body').attr("class");
		if (this_page == "modelSegments") {
			var current_segment = $(this).val();
			set_segment_info(current_segment);
			setServiceArea();
		}
    });


	$('#ms_summary_form').submit(function() {
		var form_id = "#ms_summary_form";
		var fields = [];
		$(form_id + ' input[name=fields[]]:checked').each(function() {
			fields.push(this.value);
		});
		if (fields.length == 0) {
			alert('You must select at least one field to display.');
			return false;
		}
		var sa = $("#selectArea").val();
		var sg = $("#selectSegment").val();
		var params = 'sg=' + sg + '&sa='+sa+'&' + $(this).serialize();
		getJSON(
			"modelsegments/get_summary_data",
			params,
			function(data) {
				$(form_id + ' .controls').show();
				tabledata = invertData(data.table_data);
				global_ms_tabledata = tabledata;
				$(form_id + ' .table').register(tabledata);
				$(form_id + ' .table').pivot(false);
				$(form_id + ' .tableSorter').tablesorter();

				var cdata = data.chart_data;
				increase_services_chart_data = data.chart_data;
				var row_count = data.row_count;
				var col_count = data.col_count;
				var this_width = row_count * col_count * 30;
				if (this_width < 300) this_width = 450;
				increase_services_chart_width = this_width;
				draw_2d_chart("ms_summary_chart", "summary_chart", cdata, this_width);
				show_report_button(form_id);
				$(form_id + ' .refreshButton').attr('src','/graphics/refresh_data_button.png');
				if (sa == "Whole_District") {
					map.queryAndDisplayTableData(tabledata, map.spatialTypes.blockgroups, map.spatialTypes.dataattributes, null, null, 1, map.classifyByRowOrCol.col, true);
				} else {
					var saName = ($('#selectArea option[value='+$("#selectArea").val()+']').text());
					map.queryAndDisplayTableData(tabledata, map.spatialTypes.blockgroups, map.spatialTypes.dataattributes, map.spatialTypes.serviceareas, saName, 1, map.classifyByRowOrCol.col, true);
				}
				$("#visualize").css("height", "auto");
				FocusFirstRow();
			});

		return false;
	});

	$("#ms_summary_form .chart_sort select").change(function() {
		var sort_type = $(this).val();
		if (sort_type == "") return false;

		var form_id = "#ms_summary_form";
		var fields = [];
		$(form_id + ' input[name=fields[]]:checked').each(function() {
			var field_name = $(this).parent().parent().find("strong").html();
			fields.push(field_name);
		});
		console.log("attempting to sort by " + sort_type + " and by " + fields[0]);
		sort_chart(sort_type, fields[0]);
		draw_2d_chart("ms_summary_chart", "summary_chart", increase_services_chart_data, increase_services_chart_width);
	});
	/* MODEL SEGMENT  ---- END --- */

	/* FIND CUSTOMERS */
	// SUMMARY

	$('#customers_summary_form').submit(function() {
		var form_id = "#customers_summary_form";
		var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");
		// process form and generate data
		var sa = $('#serviceArea').val();
		var saName = ($('#serviceArea option[value='+$("#serviceArea").val()+']').text());
		var fields = [];
		var start, end;
		$(current_subtab + ' input[name=fields]:checked').each(function() {
			fields.push(this.value);
		});
		if (fields.length == 0) {
			alert('You must select at least one field to display.');
			return false;
		}
		$(current_subtab + ' .col_right .table ').html('<img class="ajax-loader" src="/css/images/ajax-loader.gif" />');
		if ($(current_subtab + ' input[name=checkouts]:checked').val() == 'range') {
			start = $('input[name=startdate]').val();
			end = $('input[name=enddate]').val();
		}
		var format = $('input[name=format].selected').val();
		$.ajax({
			url: '/findcustomers/ajax_summary',
			type: 'POST',
			data: {
				start:	start,
				end:	end,
				sa:		sa,
				fields:	fields,
				format: format
			},
			success: function(data){
				var obj = jQuery.parseJSON(data);
				$(current_subtab + ' .controls').show();
				//$(current_subtab + ' .col_right .table').html(obj.table);
				$(current_subtab + ' #summary_show_data').attr('src','/graphics/refresh_data_button.png');
				$(current_subtab + ' .col_right .table').register(obj.common);
				$(current_subtab + ' .col_right .table').pivot(false);
				$(current_subtab + ' .col_right .tableSorter').tablesorter();
				draw_2d_chart("fc_summary_chart", "summary_chart", obj.chart, 450);
				show_report_button('#customers_summary_form');
				// $('#customers_summary_form .generate_pdf_report').show();
				map.queryAndDisplayTableData(obj.common, map.spatialTypes.segments, map.spatialTypes.dataattributes, map.spatialTypes.serviceareas, saName, 1, map.classifyByRowOrCol.col, true);
				$('#visualize').css('height','auto');
				FocusFirstRow();

			}
		});
		return false;
	});
	// OPPORTUNITIES
	$('#customers_opportunities_form').submit(function() {
		var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");
		$(current_subtab + ' .col_right .table').html('<img class="ajax-loader" src="/css/images/ajax-loader.gif" />');

		// process form and generate data
		var sa = $('#serviceArea').val();
		var saName = $('#serviceArea').text();
		var fields = [];
		var start, end;
		$('#opportunitiestab input[name=fields]:checked').each(function() {
			fields.push(this.value);
		});
		if (fields.length == 0) {
			alert('You must select at least one field to display.');
			return false;
		}
		if ($('#opportunitiestab input[name=checkouts]:checked').val() == 'range') {
			start = $('input[name=startdate]').val();
			end = $('input[name=enddate]').val();
		}
		var format = $(current_subtab + ' input[name=format].selected').val();
		$.ajax({
			url: '/findcustomers/ajax_opportunities',
			type: 'POST',
			data: {
				start:	start,
				end:	end,
				sa:		sa,
				fields:	fields,
				format: format
			},
			success: function(data){
				var obj = jQuery.parseJSON(data);
				$(current_subtab + ' .controls').show();
				//$(current_subtab + ' .col_right .content .table').html(obj.table);
				$('#opportunities_show_data').attr('src','/graphics/refresh_data_button.png');
				//$(current_subtab + ' .tableSorter').tablesorter();
				//$(current_subtab + ' span.biggify').show();
				$(current_subtab + ' .col_right .table').register(obj.common);
				$(current_subtab + ' .col_right .table').pivot(false);
				$(current_subtab + ' .col_right .tableSorter').tablesorter();
				draw_2d_chart("fc_opportunities_chart", "opportunities_chart", obj.chart, 450);
				// $('#customers_opportunities_form .generate_pdf_report').show();
				show_report_button('#customers_opportunities_form');
				if ('Whole_District' == sa)
					map.queryAndDisplayTableData(obj.common, map.spatialTypes.serviceareas, map.spatialTypes.dataattributes, null, null, 1, map.classifyByRowOrCol.col, true);
				else map.queryAndDisplayTableData(obj.common, map.spatialTypes.blockgroups, map.spatialTypes.dataattributes, null, null, 1, map.classifyByRowOrCol.col, true);
				$("#visualize").css("height", "auto");
				FocusFirstRow();
			}
		});
		return false;
	});
/* END FIND CUSTOMERS */

/* MARKET RESEARCH */
	$('.demographics_list li span').toggle(function() {
		var li = $(this).parent('li').attr('id');
		$('#' + li + ' > ul').show();
	}, function() {
		var li = $(this).parent('li').attr('id');
		$('#' + li + ' > ul').hide();
	});
	$('.demographics_list input').click(function() {
		var demographics =	$('.demographics_list input[name=demographic]:checked').get().length;
		if (demographics > 5) { // technically not possible, but just in case.
			alert('Sorry, you can only select 5 demographic categories');
			return false;
		}
		else if (demographics == 5) {
			$('.demographics_list input[name=demographic]:not(:checked)').attr('disabled', 'disabled');
		}
		else if (demographics < 5) {
			$('.demographics_list input[name=demographic]:disabled').attr('disabled', false);
		}

	});

	$('#checkall').toggle(function() {
		$('input[name=service_area]').attr('checked',true);
		$('#checkall').text('uncheck all');
	}, function() {
		$('input[name=service_area]').attr('checked',false);
		$('#checkall').text('check all');
	});
	$('form#market_research_demographics').submit(function() {
		var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");
		$(current_subtab + ' .col_right .table').html('<img class="ajax-loader" src="/css/images/ajax-loader.gif" />');

		// process form and generate data
		var sa = $('#serviceArea').val();
		var saName = $('#serviceArea').text();
		var demographics = [];
		var sas = [];
		$('.demographics_list input[name=demographic]:checked').each(function() {
			demographics.push(this.value);
		});
		if (demographics.length == 0) {
			alert('You must select at least one field to display.');
			return false;
		}
		$('#service-area-list input[name=service_area]:checked').each(function() {
			sas.push(this.value);
		});
		if (sas.length == 0) {
			alert('You must select at least one Service Area to display.');
			return false;
		}
		var format = $(current_subtab + ' input[name=format].selected').val();
		$.ajax({
			url: '/marketresearch/ajax_demographics',
			type: 'POST',
			data: {
				demographics: demographics,
				sas:	sas,
				format: format
			},
			success: function(data){
				var obj = jQuery.parseJSON(data);
				$(current_subtab + ' .controls').show();
				$('#demographics_show_data').attr('src','/graphics/refresh_data_button.png');
				$(current_subtab + ' .col_right .table').register(obj.common);
				$(current_subtab + ' .col_right .table').pivot(false);
				$(current_subtab + ' .col_right .tableSorter').tablesorter();
				draw_2d_chart("demographics_chart", "mr_demographics_chart", obj.chart, 450);
				show_report_button('#demographics_form');
				if ('Whole_District' == sa)
					map.queryAndDisplayTableData(obj.common, map.spatialTypes.serviceareas, map.spatialTypes.dataattributes, null, null, 1, map.classifyByRowOrCol.col, true);
				else map.queryAndDisplayTableData(obj.common, map.spatialTypes.serviceareas, map.spatialTypes.dataattributes, null, null, 1, map.classifyByRowOrCol.col, true);
				$("#visualize").css("height", "auto");
				FocusFirstRow();
			}
		});
		return false;
	});


/* END MARKET RESEARCH */

    //literacy Decision
	$('#literacy_summary_form').submit(function() {
		var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");
		// process form and generate data
        var levels = [];
        var sa = $(current_subtab + ' input[name=areas]:checked').val();
        var sa_name = $(current_subtab + ' input[name=areas]:checked').parent('label').text();
        if (!sa) {
            alert('You must select an area to display.');
            return false;
        }
        $(current_subtab + ' input[name=levels]:checked').each(function() {
            levels.push(this.value);
        });
        if (levels.length == 0) {
            alert('You must select at least one level to display.');
            return false;
        }
		$(current_subtab + ' .col_right .table ').html('<img class="ajax-loader" src="/css/images/ajax-loader.gif" />');
        $.ajax({
            url: '/literacydecision/ajax_summary',
            type: 'POST',
            data: {
                sa: sa,
                levels: levels
            },
			success: function(data){
				var obj = jQuery.parseJSON(data);
				if (obj.error) {
					$(current_subtab + ' .col_right .table').html(obj.error);
					$(current_subtab + ' .col_right .controls').hide();
				}
				else {
					$(current_subtab + ' .controls').show();
					$(current_subtab + ' .refreshButton').attr('src','/graphics/refresh_data_button.png');
					$(current_subtab + ' .col_right .table').register(obj.table);
					$(current_subtab + ' .col_right .table').pivot(false);
					$(current_subtab + ' .col_right .tableSorter').tablesorter();
					//$(current_subtab + ' .generate_pdf_report').show();
					draw_2d_chart("summary_chart", "ldsummary_chart", obj.chart,450);
					map.queryAndDisplayTableData(obj.table, map.spatialTypes.blockgroups, map.spatialTypes.dataattributes, null, null, 1, map.classifyByRowOrCol.col, true);
					$("#visualize").css("height", "auto");
					FocusFirstRow();
				}
				setServiceArea(sa, sa_name);
			}
		});
		return false;
	});

	function FocusFirstRow() {
		var trc = $(".table tbody").children();
		var i = 0;
		trc.each(function(){ ++i;
			var etrc = $(this).children();
			etrc.css("background-color","").length;
			if (i == 1) {
				var tdc = $(this).children();
				tdc.css("background-color","#ff0").length;
			}
		});
	}


	/*
	 * COMPARE SERVICES CUSTOMIZE
	 */

	function validate_compare_customize_form(f) {
		//do some validation
		var selectedAction = false;
		var selectedItem = false;
		var selectedArea = false;
		var selectedMode = false;

		f = document.forms[f];

		for (var i = 0; i < f.CustomizeData.length; ++i)
			if (f.CustomizeData[i].checked == true)
				selectedAction = true;

		for (var i = 0; i < f.DataItem.length; ++i)
			if (f.DataItem[i].checked == true)
				selectedItem = true;

		for (var i = 0; i < f.cd_area.length; ++i)
			if (f.cd_area[i].checked == true)
				selectedArea = true;

		//if ((f.totalcompare.checked == true) || (f.rangecompare.checked == true))
		selectedMode = true;

		if (selectedAction == false) {
			alert("You have not selected any data to customize (eg. Summary Profile, etc..)");
			return false;
		}

		if (selectedItem == false) {
			alert("You have not selected one or more data items to examine (eg. Population, Patron Potential, etc..)");
			return false;
		}

		if (selectedArea == false) {
			alert("You have not selected one or more locations to study (eg. Clark County Lib., Las Vegas Lib., etc..)");
			return false;
		}
/*
		if (selectedMode == false) {
			alert("You have not selected a checkout mode to apply (eg. Total Checkouts, Checkout date range)");
			return false;
		}
*/
		return true;
	}

	function build_get_compare_customize_form(f) {
		var params = "";
		var l = f.length;

		for (var i = 0; i < l; ++i) {
			switch (f.elements[i].type) {
				case "radio":
					if (f.elements[i].checked == true) params += f.elements[i].name+"="+f.elements[i].value+"&";
					break;
				case "checkbox":
					if (f.elements[i].checked == true) params += f.elements[i].name+"="+f.elements[i].value+"&";
					break;
				case "select-one":
					if (f.elements[i].value != "") params += f.elements[i].name+"="+f.elements[i].value+"&";
					break;
				case "text":
					if (f.elements[i].value != "") params += f.elements[i].name+"="+f.elements[i].value+"&";
					break;
			}
		}

		return params;

	}

		$('#refresh_button').click(function() {

			$(this).attr('disabled','true');

			var params = '';
			window['utility'] = this.value;
			window['form_id'] = '#'+this.value;

			if (window['utility'] == 'performance_form') 				var utilityFunction = 'increaseservices/renderPerformance';
			if (window['utility'] == 'opportunities_form') 				var utilityFunction = 'increaseservices/renderOpportunitiesPerformance';
			if (window['utility'] == 'customers_summary_form') 			var utilityFunction = 'findcustomers/ajax_summary';
			if (window['utility'] == 'customers_opportunities_form') 	var utilityFunction = 'findcustomers/ajax_opportunities';
			if (window['utility'] == 'compare_performance_form') 		var utilityFunction = 'compareservices/setRankingDistrictCharts';
			if (window['utility'] == 'compare_customize_form') 			var utilityFunction = 'compareservices/getCustomData';

			var validator = eval('validate_'+window['utility']);
			var ret = validator(window['utility']);
			if (!ret) return false;

			var number_type = $(window['form_id']+' input[name="all_data_number_type"].selected').val();

			switch (window['utility']) {

			case 'performance_form':
				if ($(window['form_id']+' input[name="datarange"]:checked').val() == 'all') {
					number_type = all_number_type;
				}
				var sa = $('#serviceArea').val();
				if ('Whole_District' != sa) {
					params += 'sa=' + sa;
				} break;

			case 'compare_customize_form':
				params = build_get_compare_customize_form(document.forms[window['utility']]);
				break;

			}

			params += '&checkouts_mode=total&number_type='+number_type;

			$(window['form_id']+' .controls').show();
			// reset the chart sort
			$("#chart_sort select").val("");

			var current_subtab = $(".ultabs .ui-tabs-selected a").attr("href");
			$(current_subtab + ' .col_right .table ').html('<img class="ajax-loader" src="/css/images/ajax-loader.gif" style="margin:40% 0 0 45%;" />');
			$(current_subtab + ' .col_right .chart ').html('<img class="ajax-loader" src="/css/images/ajax-loader.gif" style="margin:40% 0 0 0;" />');

			$.ajax({
				url: utilityFunction,
				type: 'POST',
				data: params,
				dataType: 'json',
				success: function(data) {
				//alert(data);
				//alert(data.table_data.data);
				$(window['form_id']+' .table').register(data.table_data.data);
				$(window['form_id']+' .table').pivot(false);

				data_table_array = data.table_data.data;
				window[window['utility']+'_chart_data'] = data.chart_data;
				window[window['utility']+'_chart_width'] = data.chart_width;

				increase_services_chart_data = data.chart_data;
				increase_services_chart_width = data.chart_width;

				draw_2d_chart("ccf_chart", "the_chart", window[window['utility']+'_chart_data'],window[window['utility']+'_chart_width'], '99%');
				show_report_button(window['form_id']);
				// $(window['form_id']+' .generate_pdf_report').show();

				var tab = $(".ultabs .ui-tabs-selected a").attr("href");
				$(tab + ' .controls').show();

				if (tab == "#customizetab") {
					$(tab+' #refresh_button').removeAttr('disabled');
					$(tab+' #refresh_button').attr('src','/graphics/refresh_data_button.png');
					if ($('#CustomizeData:checked').val() == 'summary_profile')
						map.queryAndDisplayTableData(data.table_data.data, map.spatialTypes.serviceareas, map.spatialTypes.dataattributes, null, null, 1, map.classifyByRowOrCol.col, true);
					else map.queryAndDisplayTableData(data.table_data.data, map.spatialTypes.serviceareas, map.spatialTypes.segments, map.spatialTypes.dataattributes, "Population", 1, map.classifyByRowOrCol.col, true);
					$("#visualize").css("height", "auto");
				}
				FocusFirstRow();
				},
				error: function(data) {
					alert('An error has occurred and the requested data cannot be rendered at this time. Please try again.');
					$('#customizetab #refresh_button').removeAttr('disabled');
				}
			});

			return false;

		});

		/*
		 * END COMPARE SERVICES
		 */

});


function setServiceArea(service_area, service_area_name) {
	var sa = $("#serviceArea").val();
	if (service_area) {
		sa = service_area;
	}
	var path = window.location.pathname;
	path = path.match('find|increase|compare|literacy|model');
	if (path == null) return false;
	var sg = '';
	var page = '';
	if (path.length > 0) {
		page = path[0];
	}
	if (page == "model") {
		sa = $("#selectArea").val();
		sg = $("#selectSegment").val();
	}
	var profiletitle = $('#serviceArea :selected').text();
	if (service_area_name) {
		profiletitle = service_area_name;
	}
	$("#profiletitle").html(profiletitle);
	$('#dataglanceContent').html('<img class="ajax-loader" src="/css/images/ajax-loader.gif" style="margin: 5% 35%;" />');
	$.ajax({
		url : "/common_ajax/echoDataAtAGlance",
		dataType : "json",
		data: {
			page: page,
			sa:	sa,
			sg: sg
		},
		type: 'POST',
		success : function(resp) {
			/* Handle a successful callback here */
			var table = resp.table;
			var has_data = resp.has_data;
			$('#dataglanceContent').html(table);
			$('#dataglancetitle span.tip').text('Data at a Glance - ' + profiletitle);
		},
		error : function(resp) {
			/* Handle any errors that occur here */
			$("#performance_data_variable").html('Error Retrieving Data');
		}
	});
}

function setRankingCharts() {
	var sa = dojo.byId("serviceArea").value;
	var saName = dojo.byId("serviceArea").text;

	dojo.xhrGet({

		url : "compareservices/setRankingCharts?sa="+sa+"&display="+ChartStyle,
		handleAs : "xml",
		load : function(response, ioArgs) {
			/* Handle a successful callback here */
			//console.log(ioArgs.xhr.responseText);
			var resp = ioArgs.xhr.responseText;

			var JSON = eval('(' + resp + ')');

			dojo.byId("population_rank").innerHTML = JSON.population_data.rank;
			dojo.byId("patron_rank").innerHTML = JSON.patron_data.rank;
			dojo.byId("checkout_rank").innerHTML = JSON.checkout_data.rank;
			dojo.byId("market_share_rank").innerHTML = JSON.market_share_data.rank;
			dojo.byId("potential_rank").innerHTML = JSON.potential_data.rank;

			setFCNewData('myChart1', JSON.population_data.chart);
			setFCNewData('myChart2', JSON.patron_data.chart);
			setFCNewData('myChart3', JSON.checkout_data.chart);
			setFCNewData('myChart4', JSON.market_share_data.chart);
			setFCNewData('myChart5', JSON.potential_data.chart);
		},
		error : function(response, ioArgs) {
			/* Handle any errors that occur here */
			alert("An error has occurred, and the charts could not be rendered. Please try again.");
		}
	});
}

function setDistrictCharts(div) {

	ActiveChart = div;

	dojo.byId("population").className = "rank_listing_inactive";
	dojo.byId("patron").className = "rank_listing_inactive";
	dojo.byId("checkout").className = "rank_listing_inactive";
	dojo.byId("market_share").className = "rank_listing_inactive";
	dojo.byId("potential").className = "rank_listing_inactive";

	dojo.byId(div).className = "rank_listing_active";

	dojo.xhrGet({

		url : "compareservices/setDistrictCharts?chart="+div+"&display="+ChartStyle,
		handleAs : "xml",
		load : function(response, ioArgs) {
			//alert(ioArgs.xhr.responseText);
			/* Handle a successful callback here */
			//console.log(ioArgs.xhr.responseText);
			var resp = ioArgs.xhr.responseText;

			var JSON = eval('(' + resp + ')');

			dojo.byId("median").innerHTML = " = Median, "+JSON['median'];
			
			for (var i in JSON['DistrictCharts']) {
				document.getElementById('districtChartArea'+i).innerHTML = JSON['DistrictCharts'][i].AREA;
				setFCNewData('districtChart'+i, JSON['DistrictCharts'][i].chart);
			}
		},
		error : function(response, ioArgs) {
			//alert(ioArgs.xhr.responseText);
			/* Handle any errors that occur here */
			alert("An error has occurred, and the charts could not be rendered propertly. Please try again.");
		}
	});

}

function setRankingDistrictCharts(div) {

	ActiveChart = div;

	var sa = dojo.byId("serviceArea").value;
	var saName = dojo.byId("serviceArea").text;

	if (sa == 'Whole_District') ZeroCharts = true;
	else ZeroCharts = false;

	if (ZeroCharts) var action = 'zeroRankingDistrictCharts';
	else var action = 'setRankingDistrictCharts';

	dojo.byId("population").className = "rank_listing_inactive";
	dojo.byId("patron").className = "rank_listing_inactive";
	dojo.byId("checkout").className = "rank_listing_inactive";
	dojo.byId("market_share").className = "rank_listing_inactive";
	dojo.byId("potential").className = "rank_listing_inactive";

	dojo.byId(div).className = "rank_listing_active";

	dojo.xhrGet({

		url : "compareservices/"+action+"?sa="+sa+"&chart="+div+"&display="+ChartStyle,
		handleAs : "xml",
		load : function(response, ioArgs) {
			/* Handle a successful callback here */
			//console.log(ioArgs.xhr.responseText);
			var resp = ioArgs.xhr.responseText;

			var JSON = eval('(' + resp + ')');

			dojo.byId("population_rank").innerHTML = JSON['RankingCharts'].population_data.rank;
			dojo.byId("patron_rank").innerHTML = JSON['RankingCharts'].patron_data.rank;
			dojo.byId("checkout_rank").innerHTML = JSON['RankingCharts'].checkout_data.rank;
			dojo.byId("market_share_rank").innerHTML = JSON['RankingCharts'].market_share_data.rank;
			dojo.byId("potential_rank").innerHTML = JSON['RankingCharts'].potential_data.rank;

			setFCNewData('myChart1', JSON['RankingCharts'].population_data.chart);
			setFCNewData('myChart2', JSON['RankingCharts'].patron_data.chart);
			setFCNewData('myChart3', JSON['RankingCharts'].checkout_data.chart);
			setFCNewData('myChart4', JSON['RankingCharts'].market_share_data.chart);
			setFCNewData('myChart5', JSON['RankingCharts'].potential_data.chart);

			dojo.byId("median").innerHTML = " = Median, "+JSON['median'];
			
			for (var i in JSON['DistrictCharts']) {
				document.getElementById('districtChartArea'+i).innerHTML = JSON['DistrictCharts'][i].AREA;
				setFCNewData('districtChart'+i, JSON['DistrictCharts'][i].chart);
			}
		},
		error : function(response, ioArgs) {
			/* Handle any errors that occur here */
			alert(response);
			alert("An error has occurred, and the charts could not be rendered. Please try again.");
		}
	});
}

var ZeroCharts = false;
var ChartStyle = 'number';
var ActiveChart = 'population';

function ChartsToNumbers() {
	ChartStyle = 'number';
	var sa = dojo.byId("serviceArea").value;
	if (sa == 'Whole_District') ZeroCharts = true;
	else ZeroCharts = false;
	setRankingDistrictCharts(ActiveChart);
}

function ChartsToPercent() {
	ChartStyle = 'percent';
	var sa = dojo.byId("serviceArea").value;
	if (sa == 'Whole_District') ZeroCharts = true;
	else ZeroCharts = false;
	setRankingDistrictCharts(ActiveChart);
}

function setFCNewData(objFlash, strXML) {
	//This function updates the data of a FusionCharts present on the page
	//Get a reference to the movie
	var FCObject = getObject(objFlash);
	//Set the data
	FCObject.SetVariable('_root.dataURL',"");
	//Set the flag
	FCObject.SetVariable('_root.isNewData',"1");
	//Set the actual data
	FCObject.SetVariable('_root.newData',strXML);
	//Go to the required frame
	FCObject.TGotoLabel('/', 'JavaScriptHandler');
}

function getObject(objectName) {
	if (navigator.appName.indexOf ("Microsoft") !=-1) {
		return window[objectName]
	} else {
		return document[objectName]
	}
}

function doPerfomanceAnalysis() {
//console.log(dojo.byId("performance_analysis_level").value);
}

function doPerformanceServices(tabName) {
	var tType=dojo.byId(tabName+"_services_choice").value;
	var sa=dojo.byId("serviceArea").value;
	var grouping=dojo.byId(tabName + "_analysis_level").value;
	var grouping=dojo.byId(tabName + "_analysis_level").value;

	if (jQuery.trim(tType) != "") {
		dojo.xhrGet({

			url : "functions.php?f=types&t="+tType+"&sa="+sa,
			handleAs : "xml",
			load : function(response, ioArgs) {
				/* Handle a successful callback here */
				//console.log(ioArgs.xhr.responseText);
				var resp = ioArgs.xhr.responseText;

				var parts = resp.split("\n");
				//console.log(parts);
				var selBox = '<br><select id="'+tabName+'_mtype" name="mtype">';
				selBox += '<option value=" ">Choose Data Variable</option>';
				for (var i=0;i<=parts.length - 1;i++){
					var p = parts[i].split(",");
					if (p[0]!=""){
						selBox += '<option value="'+p[0]+'">'+p[1]+'</option>';
					}

				}
				selBox += '</select>';

				dojo.byId(tabName+"_data_variable").innerHTML = selBox;

			//return response;
			},
			error : function(response, ioArgs) {
				/* Handle any errors that occur here */
				dojo.byId("performance_data_variable").innerHTML = "Error Retrieving Data";
			}
		});
	} else {
		dojo.byId(tabName+"_data_variable").innerHTML = "";
	}
}

function doOpportunitiesServices() {
	var tType=dojo.byId("services_choice").value;
	var sa=dojo.byId("serviceArea").value;
	var grouping=dojo.byId("analysis_level").value;
	var grouping=dojo.byId("analysis_level").value;

	dojo.xhrGet({
		url : "functions.php?f=types&t="+tType+"&sa=",
		handleAs : "xml",
		load : function(response, ioArgs) {
			/* Handle a successful callback here */
			//console.log(ioArgs.xhr.responseText);
			var resp = ioArgs.xhr.responseText;

			var parts = resp.split("\n");
			//console.log(parts);
			var selBox = '<p>Select Data Variable:</p><select id="mtype" name="mtype">';
			selBox += '<option value=" ">Choose Data Variable</option>';
			for (var i=0;i<=parts.length - 1;i++){
				var p = parts[i].split(",");
				if (p[0]!=""){
					selBox += '<option value="'+p[0]+'">'+p[1]+'</option>';
				}

			}
			selBox += '</select>';

			dojo.byId("performance_data_variable").innerHTML = selBox;

		//return response;
		},
		error : function(response, ioArgs) {
			/* Handle any errors that occur here */
			dojo.byId("performance_data_variable").innerHTML = "Error Retrieving Data";
		}
	});
}

function doMaterials(tabName) {
	tabName = 'performance';
	var sa = dojo.byId("serviceArea").value;
	var al=dojo.byId(tabName + "_analysis_level").value;
	var s = dojo.byId(tabName + "_services_choice").value;
	//var mt = dojo.byId(tabName + "_mtype").value;
	var co = dojo.byId(tabName + "_checkouts").value;
	//console.log(al);
	if (dojo.byId(tabName + "_startdate") != null)
		var sd = jQuery.trim(dojo.byId(tabName + "_startdate").value);
	else
		var sd = "";
	if (dojo.byId(tabName + "_enddate") != null)
		var ed = dojo.byId(tabName + "_enddate").value;
	else
		var ed = "";

	//var ed = dojo.byId("enddate").value;
	var ur = "functions.php?f=materials&sa="+sa+"&a="+al+"&s="+s+"&co="+co+"&sd="+sd+"&ed="+ed;
	//console.log(ur);
	dojo.xhrGet({

		url : ur,
		handleAs : "xml",
		load : function(response, ioArgs) {
			/* Handle a successful callback here */
			//console.log(ioArgs.xhr.responseText);
			var resp = ioArgs.xhr.responseText;

			dojo.byId("performance_chartcolumn").innerHTML = resp;
		//console.log(resp);

		//return response;
		},
		error : function(response, ioArgs) {
			/* Handle any errors that occur here */
			dojo.byId("performance_chartcolumn").innerHTML = "Error Retrieving Data";
		}
	});
}
