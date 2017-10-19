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
		.color-swatch {
			border:1px solid black;
			width:15px;
			height:15px;
			margin-right:7px;
		}
		.classificationLegendDiv {
			display:block;
			float:left;
			padding-left:5px;
			width:100%;
			padding-bottom:2px;
		}
		
		div.classificationLegendDiv label, div.classificationLegendDiv div {
			display:inline;
			float:left;
		}
		
		.classificationLegendDescriptionDiv {
			padding-bottom:5px;
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
		var _token = "<?php print $token ?>";
		var _legendtoken="<?php print $legendtoken ?>";
		</script>

		<script type="text/javascript">
		
		
		/*************
		* variables
		**************/
		
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

		var _basemapMapService = "http://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer";
		var _layersMapService = "https://www.gartrellgroup.net/ArcGIS/rest/services/CivicTechnologies/CommunityConnectSvc/MapServer";
		var _blockgroupsQueryService = "https://www.gartrellgroup.net/ArcGIS/rest/services/CivicTechnologies/BlockGroups/MapServer/0";
		var _legendService = "https://www.gartrellgroup.net/SuperMap/Legend.ashx";
		var _legendSoapUrl = "https://www.gartrellgroup.net/ArcGIS/services/CivicTechnologies/CommunityConnectSvc/MapServer";
		var _legendInfoUrl = "legendInfo.php";

		/*************
		* Dojo stuff
		*************/
      
		dojo.require("esri.map");
		dojo.require("esri.tasks.query");

		var map;
		//var ccLayer;
		
		//dojo.addOnLoad(init);
		dojo.addOnLoad(dojo.partial("init",_basemapMapService,_layersMapService,_blockgroupsQueryService,_legendInfoUrl, _legendService, _legendSoapUrl, _token,_legendtoken, _classificationData));
		
		function init(basemapMapService,layersMapService,blockgroupsQueryService, legendInfoUrl, legendService, legendSoapUrl, token, legendToken, classificationData) {		
			console.log("init");
			var initExtent = new esri.geometry.Extent({"xmin":-12877384,"ymin":4288919,"xmax":-12770372,"ymax":4365356,"spatialReference":{"wkid":102100}});        //map = new esri.Map("map",{extent:initExtent,slider: true});
			map = new esri.Map("map",{extent:initExtent, slider:true});
			var basemap = new esri.layers.ArcGISTiledMapServiceLayer(basemapMapService);
			map.addLayer(basemap);  
			
			var imageParameters = new esri.layers.ImageParameters();
			imageParameters.format = "png8";  //set the image type to PNG24, note default is PNG8.

			ccLayer = new esri.layers.ArcGISDynamicMapServiceLayer(layersMapService+"?token="+token, {"opacity":0.5, "imageParameters":imageParameters});
			map.addLayer(ccLayer);

			QueryAndDisplayBlockGroups(classificationData,blockgroupsQueryService, token);
			createClassificationLegend(classificationData);
			// register for some map events
			//dojo.connect(ccLayer, "onLoad", initLayerDisplay);	
			dojo.connect(ccLayer, "onLoad", dojo.partial("getLegendGraphics",legendInfoUrl, legendService, legendSoapUrl, legendToken, ccLayer));
			
		}

		// query for block group data and then pass data to showFeatureSet
		//	classificationData is passed to showFeatureSet to control the rendering
		function QueryAndDisplayBlockGroups(classificationData, blockgroupsQueryService,token)
		{
			//build query task
			queryTask = new esri.tasks.QueryTask(blockgroupsQueryService+"?token="+token);

			//build query filter
			query = new esri.tasks.Query();
			query.outSpatialReference = {"wkid": 102100};
			query.returnGeometry = true;
			query.outFields = ["FIPS"];
			query.where="1=1"; // default get everthing
			
			//Execute task and call showResults on completion
			queryTask.execute(query, function(fset) {
				showFeatureSet(fset,classificationData);
			});
		}
		
		// show block groups on map if there is a match in the classificationData. 
		//	Use classificationData to determine symbology
		function showFeatureSet(fset,classificationData) {
			//remove all graphics on the maps graphics layer
			map.graphics.clear();

			featureSet = fset;

			var numFeatures = featureSet.features.length;
			
			// create array of symbols
			var symbols = new Array();
			for(var i=0;i<classificationData.groupData.length;i++)
			{
				symbols[i] = new esri.symbol.SimpleFillSymbol(esri.symbol.SimpleFillSymbol.STYLE_SOLID, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([0,0,0]), 1), new dojo.Color(classificationData.groupData[i].color));
			}
			
			for (var i=0; i<numFeatures; i++) {
			  var graphic = featureSet.features[i];
				// check to see if we have data for this graphic
				if(classificationData.fipsData.hasOwnProperty(graphic.attributes.FIPS))
				{
					graphic.symbol = symbols[classificationData.fipsData[graphic.attributes.FIPS].group];
					map.graphics.add(graphic);
				}
			}
      }		


		
		
		//function initLayerDisplay()
		//{
		//	console.log("initLayerDisplay");		
		//	getLegendGraphics(_legendInfoUrl, _legendService, _legendSoapUrl, legendtoken);
		//}
		
		// create legend for classified data
		//	classificationData contains the class info used for rendering the classes
		function createClassificationLegend(classificationData)
		{
			var classificationContainer = $("div#classificationLegend");
			classificationContainer.append(
				$(document.createElement("div")).attr("class","classificationLegendDescriptionDiv")
				.text(classificationData.summary.checkoutDescription)
			)
			for(var i = 0; i< classificationData.groupData.length;i++)
			{
				classificationContainer.append(
					$(document.createElement("div")).attr("class","classificationLegendDiv")
						.append(
							$(document.createElement("div")).attr({
								"class": "color-swatch"
								,style:"background-color:"+classificationData.groupData[i].color})
						)
						.append(
							$(document.createElement('label'))
							.text(" "+classificationData.groupData[i].label )
						)							
				)
			}
		}
		
		// get the graphics for the legend from a web service and pass data to createLegendFunction
		function getLegendGraphics(legendInfoUrl, legendService, legendSoapUrl, atoken, ccLayer)
		{
			var serviceUrl = legendInfoUrl+"?legendService=" + legendService + "&token="+atoken + "&soapUrl=" + legendSoapUrl;
			$.get(serviceUrl, function(data) {
				createLegend(data,ccLayer);
				},"json");
		}


		// create legend checkboxes and set handler for click events
		//	legendGraphics contains links to the legend images
		function createLegend(legendGraphics, ccLayer)
		{
			// get layerInfos
			var layerInfos = ccLayer.layerInfos;
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
									var setVisibleLayersIds=new Array();
									$("ul#layerList li input:checked").each(function() {
										setVisibleLayersIds.push(this.value);
									});
									ccLayer.setVisibleLayers(setVisibleLayersIds);									
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
			
		</script>
		
	</head>
	<body>
		<!--<p><?php print $url?></p>
		<p>the token is <?php print $token ?></p>
		-->
		<div id="map" class="tundra" style="width:900px; height:600px; border:1px solid #000;position:relative; overflow:hidden;">
		<div style="border:1px solid black;width:200px;margin-top:20px;position:absolute;left:20px;bottom:20px;z-Index:998;background-color:white;padding:5px;"><div>Layers</div><ul id="layerList"></ul><div id="classificationLegend"></div></div>
		</div>	
	</body>
</html>
