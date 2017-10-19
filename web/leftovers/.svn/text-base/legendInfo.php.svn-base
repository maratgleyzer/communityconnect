		<?php 
		
		$token = $_GET['token'];
		$serviceUrl = $_GET['legendService'];
		$soapUrl = $_GET['soapUrl'];
		
		$user = "CommConnect";
		$pw = "Books.2010";
		$ref = "http://184.106.220.22/civic";
		$url = $serviceUrl . "?token=" . $token . "&soapUrl=" . $soapUrl . "&f=pjson";
		
		$legendInfo = file_get_contents($url);
		//echo($url);
		echo($legendInfo);
		
		?>