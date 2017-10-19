<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <!--The viewport meta tag is used to improve the presentation and behavior of the samples 
      on iOS devices-->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no"/>
		<title>Community Connect</title>
    <link rel="stylesheet" type="text/css" href="http://serverapi.arcgisonline.com/jsapi/arcgis/2.1/js/dojo/dijit/themes/claro/claro.css">
    <style>
		html, body { height: 100%; width: 100%; margin: 0; padding: 0; }
		#layerListx li {
			list-style: none;
			margin-left:0;
			padding-left:0;
			text-indent:0;
		}
		#layerList {
			list-style:none;
			margin-left:0;
			padding:0;
		}
    </style>
    <script type="text/javascript">var djConfig = {parseOnLoad: true};</script>
    <script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.1"></script>
		<!-- ArcGIS API for JavaScript -->
		<!--<script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.1compact"></script>-->
		<script type="text/javascript" src = "js/jquery-1.4.2.min.js"></script>
		
		<?php 
		$user = "CommConnect";
		$pw = "Books.2010";
		$ref = "http://184.106.220.22/civic";
		$url = 
		"https://www.gartrellgroup.net/arcgis/tokens?request=gettoken&username=" . $user . "&password=" . $pw . "&clientid=ref." . $ref . "&expiration=1440";

		$token = file_get_contents($url);
		
		// get a non-clientid token for legend service
		$url = 		"https://www.gartrellgroup.net/arcgis/tokens?request=gettoken&username=" . $user . "&password=" . $pw .  "&expiration=1440";
		$legendtoken = file_get_contents($url);

		
		?>

		<script type="text/javascript">
		var token = "<?php print $token ?>";
		var legendtoken="<?php print $legendtoken ?>";
		</script>

		<script type="text/javascript">
		
		
		/*************
		* variables
		**************/
		var _basemapMapService = "http://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer";
		var _layersMapService = "https://www.gartrellgroup.net/ArcGIS/rest/services/CivicTechnologies/CommunityConnectSvc/MapServer";
		var _blockgroupsQueryService = "https://www.gartrellgroup.net/ArcGIS/rest/services/CivicTechnologies/BlockGroups/MapServer/0";
		var _legendService = "https://www.gartrellgroup.net/SuperMap/Legend.ashx";
		var _legendSoapUrl = "https://www.gartrellgroup.net/ArcGIS/services/CivicTechnologies/CommunityConnectSvc/MapServer";
		var _legendInfoUrl = "legendInfo.php";
		
		var _classificationData = {
    "summary": {
        "serviceArea": "Enterprise Library",
        "segment": "Pleasant-Ville",
        "totalCount": 285,
        "groups": 3,
        "checkoutDescription": "Materials - Audiobooks on CD"
    },
    "fipsData": {
        "320030028093": {
            "group": 0,
            "count": 23
        },
        "320030029532": {
            "group": 2,
            "count": 121
        },
        "320030034101": {
            "group": 1,
            "count": 59
        },
        "320030058042": {
            "group": 1,
            "count": 82
        }
    },
    "groupData": [
        {
            "label": "0 - 50 Checkouts",
            "color": "#FF0000"
        },
        {
            "label": "51 - 100 Checkouts",
            "color": "#00FF00"
        },
        {
            "label": "101 - 150 Checkouts",
            "color": "#0000FF"
        }
    ]
};

		/*************
		* Dojo stuff
		*************/
      
		dojo.require("esri.map");
		dojo.require("esri.tasks.query");

		var map;
		var ccLayer;
		function init() {		
			console.log("init");
			var initExtent = new esri.geometry.Extent({"xmin":-12877384,"ymin":4288919,"xmax":-12770372,"ymax":4365356,"spatialReference":{"wkid":102100}});        //map = new esri.Map("map",{extent:initExtent,slider: true});
			map = new esri.Map("map",{extent:initExtent, slider:true});
			var basemap = new esri.layers.ArcGISTiledMapServiceLayer(_basemapMapService);
			map.addLayer(basemap);  
			
			var imageParameters = new esri.layers.ImageParameters();
			imageParameters.format = "png8";  //set the image type to PNG24, note default is PNG8.

			ccLayer = new esri.layers.ArcGISDynamicMapServiceLayer(_layersMapService+"?token="+token, {"opacity":0.5, "imageParameters":imageParameters});
			map.addLayer(ccLayer);

			QueryAndDisplayBlockGroups(_classificationData);
			// register for some map events
			dojo.connect(ccLayer, "onLoad", initLayerDisplay);	
			
		}

		function QueryAndDisplayBlockGroups(classificationData)
		{
			//build query task
			queryTask = new esri.tasks.QueryTask(_blockgroupsQueryService+"?token="+token);

			//Can listen for onComplete event to process results or can use the callback option in the queryTask.execute method.
			//dojo.connect(queryTask, "onComplete", showResults);

			//build query filter
			query = new esri.tasks.Query();
			query.outSpatialReference = {"wkid": 102100};
			query.returnGeometry = true;
			query.outFields = ["FIPS"];
			query.where="1=1"; // default get everthing
			
			//Execute task and call showResults on completion
			queryTask.execute(query, function(fset) {
				//if (fset.features.length === 1) {
				//	showFeature(fset.features[0],evt);
				//} else if (fset.features.length !== 0) {
					showFeatureSet(fset,classificationData);
				//}
			});
		}
		  
		function showFeatureSet(fset,classificationData) {
			//remove all graphics on the maps graphics layer
			map.graphics.clear();

			featureSet = fset;

			var numFeatures = featureSet.features.length;

			//QueryTask returns a featureSet.  Loop through features in the featureSet and add them to the infowindow.
			//var content = "";
			
			// create array of symbols
			var symbols = new Array();
			for(var i=0;i<classificationData.groupData.length;i++)
			{
				symbols[i] = new esri.symbol.SimpleFillSymbol(esri.symbol.SimpleFillSymbol.STYLE_SOLID, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([0,0,0]), 1), new dojo.Color(classificationData.groupData[i].color));
			}
			
			//var symbol = new esri.symbol.SimpleFillSymbol(esri.symbol.SimpleFillSymbol.STYLE_SOLID, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([0,0,0]), 1), new dojo.Color([255,255,0,0.5]));
			
			for (var i=0; i<numFeatures; i++) {
			  var graphic = featureSet.features[i];
			 // content = content + graphic.attributes.FIELD_NAME + " Field (<A href='#' onclick='showFeature(featureSet.features[" + i + "]);'>show</A>)<br/>";
				
				// check to see if we have data for this graphic
				if(classificationData.fipsData.hasOwnProperty(graphic.attributes.FIPS))
				{
					graphic.symbol = symbols[classificationData.fipsData[graphic.attributes.FIPS].group];
					map.graphics.add(graphic);
				}
			}
			//map.infoWindow.setContent(content);
			//map.infoWindow.show(evt.screenPoint);
      }		
		
		function getLegendGraphics(legendInfoUrl, legendService, legendSoapUrl, atoken)
		{
			var serviceUrl = legendInfoUrl+"?legendService=" + legendService + "&token="+atoken + "&soapUrl=" + legendSoapUrl;
			//var legendGraphics;
			$.get(serviceUrl, function(data) {
				createLegend(data);
				},"json");
			//return legendGraphics;
		}
		
		
		function initLayerDisplay()
		{
			console.log("initLayerDisplay");
			
			getLegendGraphics(_legendInfoUrl, _legendService, _legendSoapUrl, legendtoken);
		}
		
		function createLegend(legendGraphics)
		{
					// get layerInfos
			var layerInfos = ccLayer.layerInfos;
			//for(var i=0; i<layerInfos.length;i++)
			//{
			//	$("#layers").append("<p>"+layerInfos[i].name + "  " + layerInfos[i].defaultVisibility + "</p>");
			//}
			
			
			var layerContainer = $("ul#layerList");
			$.each( layerInfos, function( iteration, item ) 
			{ 
				layerContainer.append( 
					$(document.createElement("li")) 
						.append( 
							$(document.createElement("input")).attr({ 
								type:  'checkbox' 
								,id:    'topicFilter-' + item 
								,name:  item.name 
								,value: item.id 
								,checked: item.defaultVisibility
							}) 
								.click( function( event ) 
								{ 
									//var cbox = $(this)[0]; 
									//alert( cbox.value + "  " + cbox.checked); 
									var setVisibleLayersIds=new Array();
									$("ul#layerList li input:checked").each(function() {
										setVisibleLayersIds.push(this.value);
									});
									ccLayer.setVisibleLayers(setVisibleLayersIds);
									//alert(setVisibleLayers);
									
								} ) 
						) 
						.append(
							$(document.createElement('img')).attr({src: legendGraphics.layers[iteration].legend[0].url,
																	alt: 'legend swatch', 
																	align:'top'})
						)
						.append( 
							$(document.createElement('label')).attr({ 
							'for':  'topicFilter' + '-' + item.name 
							}) 
							.text(" "+item.name ) 
						) 
				) 
			} );	
		}
		
		
		
		
		dojo.addOnLoad(init);		
				
			// register for some map events
//			dojo.connect(map, "onLoad", function() {
			//console.log("Map onLoad event");
	//		});
			
			/*****************
			* Hook up jQuery
			*****************/
          $(document).ready(jQueryReady);
		
		function jQueryReady() {
			console.log("jQuery ready event");
		}
		</script>
		
	</head>
	<body>
		<p><?php print $url?></p>
		<p>the token is <?php print $token ?></p>
		
		<div id="map" class="tundra" style="width:900px; height:600px; border:1px solid #000;position:relative; overflow:hidden;">
		<div style="border:1px solid black;width:200px;margin-top:20px;position:absolute;left:20px;bottom:20px;z-Index:998;background-color:white;padding:5px;"><div>layers</div><ul id="layerList"></ul></div>
		</div>
		
		
		
	</body>
</html>
