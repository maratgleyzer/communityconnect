<p style="margin: 10px;">Make changes and click the Save Preferences button below, or Reset Preferences to their previous settings.</p>
<div id="my_account_preferences_left">
	<form name="preferences_form" id="preferences_form">
		<div class="col_left" style="width: 50%;">
			<h3><?php echo $this->common->tool_tip('Set this preference to automatically jump to a study area map view of your choice when you open CommunityConnect.', 'Study Area and Map View'); ?></h3>
			<p>Select a default locale either districtwide or a particular service area for working with data and maps.</p>
			<select name="studyarea" id="studyarea">
				<!--option value="">Whole District</option-->
				<?php
				if ($study_areas) {
					if (is_array($study_areas)) {
						$studyarea = $user_info->STUDYAREA;
						if (!$user_info->STUDYAREA)
							$studyarea = "1111";
						for ($i = 0; $i < sizeof($study_areas); $i++) {
							$selected = "";
							if ($studyarea == $study_areas[$i]->AREA_ID) {
								$selected = "selected";
							}
							echo "<option value='" . $study_areas[$i]->AREA_ID . "' " . $selected . ">" . $study_areas[$i]->AREA . "</option>";
						}
					}
				}
				?>
			</select>
		</div>
		<div class="col_left" style="width: 45%;">
			<h3><?php echo $this->common->tool_tip('Set this preference to specify information you\'d like in the report header.', 'Reports'); ?></h3>
			<p>Select a default report format.</p>
			<p>
				<input type="radio" name="rptformat" value="pdf" <?php if ($user_info->RPTFORMAT != "xls")
					echo 'checked="checked"'; ?> id="pdfformat" /> <label for="pdfformat">PDF</label><br />
				<input type="radio" name="rptformat" value="xls" <?php if ($user_info->RPTFORMAT == "xls")
						   echo "checked"; ?> disabled="disabled" id="xlsformat"> <label for="xlsformat">Excel</label>
			</p>
			<div class="instructions">Note: all maps default to PDF</div>

			<table>
				<tr>
					<td><input type="checkbox" name="rptsubtitle_chk" id="rptsubtitle_chk" /></td>
					<td><p><label for="rptsubtitle_chk"><b>Create a custom subtitle that will appear in the report header</b></label>
							<br />
				Enter a subtitle that will appear on the report:<br />
							<input type="text" value="<?php echo $user_info->RPTSUBTITLE; ?>" name="rptsubtitle" id="rptsubtitle" size="35" maxlength="140"></p>
					</td>
				</tr>
				<tr>
					<td><input type="checkbox" name="rptusername_chk" id="rptusername_chk"></td>
				<td><p><label for="rptusername_chk"><b>Put my name in the report header</b></label><br />
					Enter your name:<br />
			<input type="text" value="<?php echo $user_info->RPTUSERNAME; ?>" name="rptusername" id="rptusername" size="35" maxlength="60"></p>
				</td>
				</tr>
			</table>
			<p id="savemsg"></p>
			<!--input type="image" src="graphics/save_changes_button.png" border="0"-->
			<a href="javascript:savePref();"><img src="css/images/save_preferences_button.png" border="0"></a>
			<a href="javascript:resetPref();"><img src="css/images/reset_preferences_button.png" border="0"></a>
		</div>
	</form>
</div>
<?php /*
						 <div class="col_left" style="width:370px;" id="my_account_preferences_right">
						 <h3><?php echo $this->common->tool_tip('Set this preference to compare literacy data in your study area to other locales.', 'Literacy Decision'); ?></h3>
						 <p><input type="checkbox" name="litcompare" id="litcompare" <?php if ($user_info->LITCOMPARE)
						 echo "checked"; ?>> <b>Compare:</b> always compare data from a study area to the city,<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; county, and state it is in.</p>
						 </div>

						* ?>
						*/
?>
<script language="javascript" type="text/javascript">
	function savePref(){
		var studyarea = $('#studyarea').val();
		var rptsubtitle = $('#rptsubtitle').val();
		var rptusername = $('#rptusername').val();
		var rptformat = $('input[name=rptformat]:checked').val();
		var litcompare = 0;
		// if (document.preferences_form.litcompare.checked == true) litcompare = 1;
		$.get(
		"/myaccount/save_preferences",
		"studyarea="+studyarea+"&rptsubtitle="+rptsubtitle+"&rptusername="+rptusername+"&rptformat="+rptformat+"&litcompare="+litcompare+"&act=save",
		function(data) {
			$('#savemsg').html(data.Message);
		},
		"json"
		);
	}

	function resetPref(){
		var saselect = $('#studyarea');
		saselect.val($('option:first', saselect).val());
		$('input[name=rptsubtitle]').val('');
		$('input[name=rptsubtitle_chk]').attr('checked',false);
		$('input[name=rptusername]').val('');
		$('input[name=rptusername_chk]').attr('checked',false);
		// document.preferences_form.litcompare.checked=false;
		$('input[name=rptformat]').val('pdf');
		$.get(
		"/myaccount/save_preferences",
		"studyarea=1111&rptsubtitle=&rptusername=&rptformat=pdf&litcompare=0&act=reset",
		function(data) {
			$('#savemsg').html(data.Message);
		},
		"json"
	);
	}
</script>
<br class="clear" /><br />