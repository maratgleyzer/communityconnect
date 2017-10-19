		<?php 
		
		$token = $_GET['token'];
		$serviceUrl = $_GET['legendService'];
		$soapUrl = $_GET['soapUrl'];
		
		$url = $serviceUrl . "?token=" . $token . "&soapUrl=" . $soapUrl . "&f=pjson";
		
		$legendInfo = file_get_contents($url);
		//echo($url);
		echo($legendInfo);
		
		?>