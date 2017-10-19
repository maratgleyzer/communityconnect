<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 
?>

    <div class="col_left" style="width:350px;" id="my_account_preferences_left">
        <style>
            h3 {
                font-size: 1.4em;
                font-weight: bold;
}
        </style>
        <h3>Service Areas and Map View</h3>
        <br><br>
        <p>Select a default locale -- either districtwide or a particular service area -- for working with data and maps.</p>
        <?php
            /*
             * here is where we get the preferences from the user table
             * by the $_SESSION['uid'];
             * then set the prefs in an array to be used throughout the site
             */
             $prefs = array("sa"=>"EN13","report_header"=>'My Custom Report Header','user_name'=>'Marc Futterman');
            $sql = "select * from serviceareas";
            $r = mysql_query($sql);
            echo "<select name=\"sa\">";
            while ($row = mysql_fetch_assoc($r)) {
                if ($row['sa'] == $prefs['sa']) {
                    $sel = " selected ";
                } else {
                    $sel = "";
                }
                echo "<option $sel value=\"".$row['sa']."\">".$row['serviceArea']."</option>\n";

            }
            echo "</select>";
        ?>

        <br><br>
        <input type="checkbox" name="account_preference_report_header_chk" id="account_preference_report_header"> Create a custom subtitle that will appear in the report header<br><br>
        &nbsp;&nbsp;&nbsp; Enter a subtitle that will appear on the report:<br><br>
        &nbsp;&nbsp;&nbsp; <input type="text" value="<?php echo $prefs['report_header']; ?>"name="account_preference_report_header" id="account_preference_report_header" size="35">

        <br><br>
        <input type="checkbox" name="account_preference_user_name_chk" id="account_preference_user_name_chk"> Create a custom subtitle that will appear in the report header<br><br>
        &nbsp;&nbsp;&nbsp; Enter a subtitle that will appear on the report:<br><br>
        &nbsp;&nbsp;&nbsp; <input type="text" value="<?php echo $prefs['user_name']; ?>" name="account_preference_user_name" id="account_preference_user_name" size="35">
          <br><br>
 <INPUT TYPE="image" SRC="graphics/save_changes_button.png" BORDER="0">

    </div>

<div class="col_left" style="width:350px;" id="my_account_preferences_right">
  
    <h3>Literacy Decision</h3>
        <br><br>
        <input type="checkbox" name="account_preference_literacy_decision_chk" id="account_preference_literacy_decision_chk"> <b>Compare:</b> always compare data from a study area to the city, county, and state it is in.<br><br>

    </div>