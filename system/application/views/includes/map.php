
<?php

$user = "CommConnect";
$pw = "Books.2010";
$ref = "http://184.106.220.22/civic";

$url = "https://www.gartrellgroup.net/arcgis/tokens?request=gettoken&username=" . $user . "&password=" . $pw . "&clientid=ref." . $ref . "&expiration=1440";
$token = file_get_contents($url);

// get a non-clientid token for legend service
$url = 	"https://www.gartrellgroup.net/arcgis/tokens?request=gettoken&username=" . $user . "&password=" . $pw .  "&expiration=1440";
$legendtoken = file_get_contents($url);

?>

<script>
var djConfig = {parseOnLoad: true};
var _token="<?php print $token ?>";
var _legendtoken="<?php print $legendtoken ?>";
var map;

dojo.addOnLoad(init);

function init() {		
	// console.log("init");
	map = new ccMap("visualizetab", _token, _legendtoken);//, _basemapMapService, _layersMapService);
}		
</script>
<script type="text/javascript" src="/js/ccmap.js"></script>
<script type="text/javascript" src="/js/ccEqualIntervalClassifier.js"></script>
<div id="visualize" class="box full" style="height: 0px;">
	<div id="visualizetitle" class="stitle">
		<?php // <span class="biggify"> [ + ] &nbsp;&nbsp;&nbsp;&nbsp;</span> ?>
		Visualize</div>
	<div id="visualizetab" class="tundra tab">
			<div id="legendContainer">
				<ul id="layerList"></ul>
				<div id="classificationLegend"></div>
			</div>
	</div>
</div>