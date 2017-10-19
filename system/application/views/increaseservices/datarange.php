	    <div class="instructions">Select data range:</div>
	    <div class="range_selection radioset clearfix" style="width:150px;margin-bottom: 10px;">
	    	<label for="alldata<?php echo $subtab;?>" style="float: left;width:75px">
	    		<input id="alldata<?php echo $subtab;?>" type="radio" checked name="datarange" value="all" />
	    		All Data
	    	</label>
	    	<div class="imageToggle" style="width:60px; clear:right; float: right;">
	    		<input name="all_data_number_type" type="image" value="number" class="selected" src="/graphics/number_button.png"><input name="all_data_number_type" type="image" value="percent" src="/graphics/percent_button.png">
	    	</div>
	    	<label for="selectdata<?php echo $subtab;?>" style="width:75px;padding-top:4px;float:left; clear:left;">
	    		<input id="selectdata<?php echo $subtab;?>" type="radio" name="datarange" value="range" />
	    		Select Data
	    	</label>
	    	<div class="imageToggle" style="width:60px;clear:right; float: right;">
	    		<input name="selected_data_number_type" type="image" value="number" class="selected" src="/graphics/number_button.png"><input name="selected_data_number_type" type="image" value="percent" src="/graphics/percent_button.png">
	    	</div>
			 <br />
	    </div>       
	    <div class="datarange_fillin" style="margin-bottom: 10px; display: none;">			
		    <table style="margin-left: 10px">
		    	<tr><td>minimum</td><td> <input type="text" value="" name="mindata" size="5"></td></tr>
		    	<tr><td>maximum</td><td> <input type="text" value="" name="maxdata" size="5"></td></tr>
		    </table>   
	    </div>
