<style>
	#savereportdialog { font-size:1.1em; line-height:1.1em;}
	#savereportdialog h1 { color:#828d65; font-size:1.8em; margin-top:10px; margin-bottom:10px; }
	#savereportdialog ul, li { font-size:1.1em; line-height: 1.1em; }
	#savereportdialog  ul { margin-left:10px; margin-bottom:5px; }
	#savereportdialog td {font-size:1.1em; padding:2px; }
</style>
<div id="savereportdialog">
    <p>Your reports will include the information based on the configured report criteria. If you would like to revise your report criteria, select <a href="#" onclick="CloseSaveReportDialog();return false;">Cancel</a> and you will be returned to the previous page.</p>
    <h1>Contents</h1>
    <p>Your report will include the following from the previous page:</p>
    <ul>
        <li><b>Data Features Including:</b>
            <ul>
                <li>Findings</li>
                <li>Tables</li>
                <li>Charts/graphs</li>
            </ul>
        </li>
    </ul>
    <h1>Header</h1>
    <p>Your report will reflect your preferences, shown below. Check the box to make changes for this one instance, then edit. Click <a href="#" onclick="window.location='/myaccount';return false;">Preferences</a> to change them.</p>
    <form id="savereport" name="savereport">
        <table cellpadding="3" cellspacing="2" width="100%" border="0">
        	<tr>
            	<td style="width:33%"><b>Subtitle:</b></td>
                <td style="width:33%"><b>Your Name:</b></td>
                <td style="width:33%"><b>Format:</b></td>
            </tr>
            <tr>
                <td><input type="text" name="subtitle_tb" id="subtitle_tb" value="<?php echo $reportConfig->RPTSUBTITLE; ?>" size="25" /></td>
                <td><input type="text" name="name_tb" id="name_tb" value="<?php echo $reportConfig->RPTUSERNAME; ?>" size="25" /></td>
                <td>
                    <label for="format_pdf"><input type="radio" name="format" id="format_pdf" value="pdf"  onclick="" <?php echo $reportConfig->RPTFORMAT == "pdf" || $reportConfig->RPTFORMAT == "" ? "checked" : ""; ?> /> pdf</label><label for="format_excel"><input type="radio" name="format" id="format_excel" value="excel"  onclick="" disabled="disabled" <?php $reportConfig->RPTFORMAT == "xls" ? "checked" : ""; ?> /> excel</label>
                </td>
            </tr>
        </table>
        <input id="rtype" name="rtype" type="hidden" value="" />
        <input id="rtitle" name="rtitle" type="hidden" value="" />
        <input id="geoarea" name="geoarea" type="hidden" value="" />
        <input id="reportitems" name="reportitems" type="hidden" value="" />
        <input id="querydescr" name="querydescr" type="hidden" value="" />
    </form>
    <div style="margin-top:10px;margin-left:auto;margin-right:auto;text-align:center">
    	<input type="image" src="/graphics/save-and-view-reports.png" value="Save & View Reports" style="cursor:pointer" onclick="SaveReport(true);" />
    	<input type="image" src="/graphics/save.png" value="Save" style="cursor:pointer" onclick="SaveReport(false)" />
    	<input type="image" src="/graphics/cancel.png" value="Cancel" style="cursor:pointer" onclick="CloseSaveReportDialog()" />
    </div>
    <div style="color:Red;font-size:8pt" id="messages" />
</div>