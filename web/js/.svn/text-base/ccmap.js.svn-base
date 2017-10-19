dojo.require("esri.map");
dojo.require("esri.tasks.query");
dojo.require("esri.layers.graphics");
//esri.config.defaults.io.proxyUrl = "../agsProxy/proxy.ashx";
esri.config.defaults.io.proxyUrl = "proxy.php";
dojo.require("dijit.TooltipDialog");

function ccMap(mapDiv, token, legendToken)
{
	//*****************************************************************************************
	//
	//   set fixed values for all map instances
	//
	//*****************************************************************************************

	//enum for spatial types
	this.spatialTypes = {"blockgroups":"blockgroups","segments":"segments","serviceareas":"serviceareas","dataattributes":"dataattributes"};
	this.classifyByRowOrCol = {"row":"row","col":"col"};
	
	this.queryServices = new Array();
	this.queryServices["blockgroups"] = "https://www.gartrellgroup.net/ArcGIS/rest/services/CivicTechnologies/BlockGroups/MapServer/0";
	this.queryServices["segments"] = "https://www.gartrellgroup.net/ArcGIS/rest/services/CivicTechnologies/BlockGroups/MapServer/0";
	this.queryServices["serviceareas"] = "https://www.gartrellgroup.net/ArcGIS/rest/services/CivicTechnologies/ServiceAreasWithWholeDistrict/MapServer/0";
		
	this.queryServiceFields = new Array();
	this.queryServiceFields["blockgroups"] = "FIPS";
	this.queryServiceFields["segments"] = "TAPSEGNAM";
	this.queryServiceFields["serviceareas"] = "ServiceAreaName";
	
	this.queryServiceOutFields = new Array();
	this.queryServiceOutFields["blockgroups"] = ["FIPS","TAPSEGNAM","ServiceAreaName"];
	this.queryServiceOutFields["serviceareas"] = ["ServiceAreaName"];
	this.queryServiceOutFields["segments"] = ["FIPS","TAPSEGNAM","ServiceAreaName"];
	
	this.spatialDisplayTypeAlias = new Array();
	this.spatialDisplayTypeAlias["serviceareas"] = "Service Area";
	this.spatialDisplayTypeAlias["blockgroups"] = "Blockgroup";
	this.spatialDisplayTypeAlias["segments"] = "Segment";
	
	this.allServiceAreasValue = "whole district";
	
	this.classifier = null;
	this.currentQueryGraphics = null;
	this.currentTableData = null;
	this.currentDisplayIndex = null;
	this.currentQueryGraphicsExtent = null;
	this.classificationSymbols = null;
	this.currentStudyAreaGraphic = null;
	this.currentStudyAreaExtent = null;
	this.currentSpatialDisplayType = null;
	
	this.currentColumnType = null;
	this.currentRowType = null;
	this.currentOverallFilterType = null;
	this.currentOverallFilterValue = null;
	this.currentClassifyByRowOrCol = null;
	this.currentClassifierIgnoreZero = null;
	
	//#5e7297 - low  $9db72d - medium  #cc3300 - high
	this.classifier = new ccEqualIntervalClassifier([{"label": "low","color": "#5e7297"},{"label": "medium","color": "#9db72d"},{"label": "high","color": "#cc3300"}]);
//	this.classifier = new Object();
//	this.classifier.classSymbolData =  [
//       	{
//            "label": "low",
//            "color": "#FF0000"
//        },
//        {
//            "label": "medium",
//            "color": "#00FF00"
//        },
//        {
//            "label": "high",
//            "color": "#0000FF"
//        }
//	];
	
	//*****************************************************************************************
	//
	//   symbol for service area outline
	//
	//*****************************************************************************************
	this.studyAreaGraphicSymbol = new esri.symbol.SimpleFillSymbol(esri.symbol.SimpleFillSymbol.STYLE_NULL, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([0,0,255,0.6]), 3), new dojo.Color([255,255,255]));
	
	//*****************************************************************************************
	//
	//   initialize the map
	//
	//*****************************************************************************************
	
	this.map = new esri.Map(mapDiv,{logo:false, slider:true});
	this.token = token;

	this.basemapMapService = "http://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer";
	this.layersMapService = "https://www.gartrellgroup.net/ArcGIS/rest/services/CivicTechnologies/CommunityConnectSvc/MapServer";

	//this.basemapMapService = basemapMapService;
	//this.layersMapService = layersMapService;
	//this.legendSoapUrl = legendSoapUrl;

	this.basemap = new esri.layers.ArcGISTiledMapServiceLayer(this.basemapMapService);
	this.map.addLayer(this.basemap);  
			
	var imageParameters = new esri.layers.ImageParameters();
	imageParameters.format = "png8";  //set the image type to PNG24, note default is PNG8.

	this.layers = new esri.layers.ArcGISDynamicMapServiceLayer(this.layersMapService+"?token="+this.token, {"opacity":0.5, "imageParameters":imageParameters});
	this.map.addLayer(this.layers);

	this.baseDynamicGraphicsLayer = new esri.layers.GraphicsLayer();//{id:"baseDynamicGraphicsLayer"});
	
    this.baseDynamicGraphicsLayerRenderer = new esri.renderer.SimpleRenderer(this.studyAreaGraphicSymbol);
    this.baseDynamicGraphicsLayer.setRenderer(this.baseDynamicGraphicsLayerRenderer);
	var self = this;
	dojo.connect(this.map, "onLoad", function() { 
		self.map.addLayer(self.baseDynamicGraphicsLayer);
	    dojo.connect(self.map.graphics, "onMouseOver", function(evt) { self.showTooltip(evt); });
	    dojo.connect(self.map.graphics, "onMouseOut", function() { self.closeDialog(); });
		});

	//*****************************************************************************************
	//
	//  define methods
	//
	//*****************************************************************************************

	if(typeof ccMap._initialized == "undefined")
    {
		//***********************************************************************************
		//
		// get the graphics for the legend from a web service and pass data to createLegendFunction
		//
		//***********************************************************************************
		ccMap.prototype.getLegendGraphics = function()
		{
			//return;
			var token = "";
			if(this.legendToken != undefined)
				token = this.legendToken;
			var legendInfoUrl = "http://commconnect.ggroupdev.com/legendInfo.php";
			var legendService = "https://www.gartrellgroup.net/SuperMap/Legend.ashx";
			var legendSoapUrl = this.layersMapService.replace("ArcGIS/rest","ArcGIS");
			var serviceUrl = legendInfoUrl+"?legendService=" + legendService + "&token="+token + "&soapUrl=" + legendSoapUrl;
			var self = this;
			$.get(serviceUrl, function(data) {
				self.createLegend(data);
				},"json");
		};

		//***********************************************************************************
		//
		// create legend checkboxes and set handler for click events
		//	legendGraphics contains links to the legend images
		//
		//***********************************************************************************
		ccMap.prototype.createLegend = function(legendGraphics)
		{
			// get layerInfos
			var layerInfos = this.layers.layerInfos;
			var layerContainer = $("ul#layerList");
			var self = this;
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
									self.layers.setVisibleLayers(setVisibleLayersIds);									
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
		};	
		
		//***********************************************************************************
		//
		// go out and get the spatial objects and render the intitial display
		//
		//***********************************************************************************	
		ccMap.prototype.queryAndDisplayTableData = function(tableData, columnType, rowType, overallFilterType, overallFilterValue,displayIndex,classifyByRowOrCol,classifierIgnoreZero) {
			// reset current display index
			this.currentDisplayIndex = null;
			
			this.currentClassifierIgnoreZero = classifierIgnoreZero;
			this.currentTableData = tableData;
			this.currentColumnType = columnType;
			this.currentRowType = rowType;
			this.currentOverallFilterType = overallFilterType;
			this.currentOverallFilterValue = overallFilterValue;
			this.currentClassifyByRowOrCol = classifyByRowOrCol;
			// what type of tableData
			// 2-factor query for blockgroups
			if((columnType == this.spatialTypes.serviceareas || columnType == this.spatialTypes.segments) && (rowType == this.spatialTypes.serviceareas || rowType == this.spatialTypes.segments))
			{
				this.currentSpatialDisplayType = this.spatialTypes.blockgroups;
				this.queryAndDisplayBy2Factors(this.spatialTypes.blockgroups,displayIndex);
				
				//******************************************************
				//
				// display graphics for column header objects
				//
				//******************************************************
				var columnHeaderValues = new Array();
				var j=0;
				for(var i= 1; i< this.currentTableData[0].length;i++)
				{
					if(this.currentTableData[0][i].toLowerCase() != "total" && this.currentTableData[0][i].toLowerCase() != "median" )
					{
						columnHeaderValues[j] = this.currentTableData[0][i];
						j++;
					}
				}
				this.queryAndDisplayDynamicGraphics(this.currentColumnType,columnHeaderValues);
			}
			else if((columnType == this.spatialTypes.serviceareas || columnType == this.spatialTypes.blockgroups) && rowType == this.spatialTypes.dataattributes)
			{
				this.currentSpatialDisplayType = columnType;
				this.queryAndDisplayBy1Factor(columnType,displayIndex,classifyByRowOrCol);			
			}
			else if((columnType == this.spatialTypes.segments) && rowType == this.spatialTypes.dataattributes)
			{
				if(this.currentOverallFilterType == this.spatialTypes.serviceareas && this.currentOverallFilterValue != "undefined")
				{
					this.queryAndDisplayDynamicGraphics(this.currentOverallFilterType,new Array(this.currentOverallFilterValue));
				}
				this.currentSpatialDisplayType = columnType;
				this.queryAndDisplayBy1Factor(columnType,displayIndex,classifyByRowOrCol);						
			}

		};

		ccMap.prototype.queryAndDisplayTableData_ChangeDisplayIndex = function(displayIndex) {
			if((this.currentColumnType == this.spatialTypes.serviceareas || this.currentColumnType == this.spatialTypes.segments) && (this.currentRowType == this.spatialTypes.serviceareas || this.currentRowType == this.spatialTypes.segments))
			{
				this.queryAndDisplayBy2Factors(this.spatialTypes.blockgroups,displayIndex);
			}
			else if((this.currentColumnType == this.spatialTypes.serviceareas || this.currentColumnType == this.spatialTypes.blockgroups || this.currentColumnType == this.spatialTypes.segments) && this.currentRowType == this.spatialTypes.dataattributes)
			{
				this.showClassifiedFeatureSet(displayIndex, false);
			}
		};
		
		ccMap.prototype.queryAndDisplayDynamicGraphics = function(spatialType,dataList) {
			var queryTask = new esri.tasks.QueryTask(this.queryServices[spatialType]+"?token="+this.token);

			//build query filter
			var query = new esri.tasks.Query();
			query.outSpatialReference = {"wkid": 102100};
			query.returnGeometry = true;
			query.outFields = [""];
			
			// build query string
			var queryString = "";
			for(var i= 0; i< dataList.length;i++)
			{
				if(queryString.length == 0)
					queryString += "lower("+this.queryServiceFields[spatialType]+")" + " = " + "'" + dataList[i].toLowerCase() + "' ";
				else 
					queryString += " or " + "lower("+this.queryServiceFields[spatialType] + ")" + " = " + "'" + dataList[i].toLowerCase() + "' ";
			}
			query.where= queryString;
			
			var self = this;  // need to make sure closure has the proper context for the object
			queryTask.execute(query, function(fset) {
				self.receiveDynamicGraphicsFeatureSet(fset);
			});
		};
		
		ccMap.prototype.receiveDynamicGraphicsFeatureSet = function(featureSet) {
					// determine extent of featureSet;
			this.currentQueryGraphicsExtent = this.calculateFeatureSetExtent(featureSet);
			//this.map.setExtent(this.currentQueryGraphicsExtent.expand(1.05),true);
			this.map.setExtent(this.currentQueryGraphicsExtent,true);
			this.baseDynamicGraphicsLayer.clear();
			for (var i=0; i<featureSet.features.length; i++) 
			{
				var graphic = featureSet.features[i];
				this.baseDynamicGraphicsLayer.add(graphic);
			}
		};
		
		ccMap.prototype.queryAndDisplayBy1Factor = function(spatialType,displayIndex,classifyByRowOrCol) {
			var queryTask = new esri.tasks.QueryTask(this.queryServices[spatialType]+"?token="+this.token);

			//build query filter
			var query = new esri.tasks.Query();
			query.outSpatialReference = {"wkid": 102100};
			query.returnGeometry = true;
			query.outFields = this.queryServiceOutFields[spatialType];
			
			// build query string
			var queryString = "";
			
			// process column headers
			if(classifyByRowOrCol == this.classifyByRowOrCol.col)
			{
				for(var i= 1; i< this.currentTableData[0].length;i++)
				{
					if(this.currentTableData[0][i].toLowerCase() != "total" && this.currentTableData[0][i].toLowerCase() != "median" )
					{
						if(queryString.length == 0)
							queryString += "(" + "lower("+this.queryServiceFields[this.currentColumnType] + ")" + " = " + "'" + this.currentTableData[0][i].toLowerCase() + "' ";
						else 
							queryString += " or " + "lower("+this.queryServiceFields[this.currentColumnType] + ")" + " = " + "'" + this.currentTableData[0][i].toLowerCase() + "' ";
					}
				}
				queryString += ")";
			}
			else
				return; // not implemented yet
			
			if(this.currentOverallFilterType != "undefined" && this.currentOverallFilterType == this.spatialTypes.serviceareas && this.currentOverallFilterValue != "undefined")
				// check to see if overall filter value is whole district -- in that case ignore that filter value
				if(this.currentOverallFilterType != this.spatialTypes.serviceareas || this.currentOverallFilterValue.toLowerCase() != this.allServiceAreasValue.toLowerCase())
				{
					queryString += " and (";
		
					queryString += "lower("+this.queryServiceFields[this.currentOverallFilterType] +")" + " = " + "'" + this.currentOverallFilterValue.toLowerCase() + "' ";
					queryString += ")";			
				}
			query.where= queryString;
			
			var self = this;  // need to make sure closure has the proper context for the object
			queryTask.execute(query, function(fset) {
				self.receiveFeatureSet(fset,displayIndex,true);
			});		
		};
		
		ccMap.prototype.queryAndDisplayBy2Factors = function(spatialType,displayIndex) {
			//build query task
			var queryTask = new esri.tasks.QueryTask(this.queryServices[spatialType]+"?token="+this.token);

			//build query filter
			var query = new esri.tasks.Query();
			query.outSpatialReference = {"wkid": 102100};
			query.returnGeometry = true;
			query.outFields = this.queryServiceOutFields[spatialType];
			
			// build query string
			var queryString = "";
			
			// process column headers
			for(var i= 1; i< this.currentTableData[0].length;i++)
			{
				if(this.currentTableData[0][i].toLowerCase() != "total" && this.currentTableData[0][i].toLowerCase() != "median" )
				{
					if(queryString.length == 0)
						queryString += "(" + "lower("+this.queryServiceFields[this.currentColumnType] + ")" + " = " + "'" + this.currentTableData[0][i].toLowerCase() + "' ";
					else 
						queryString += " or " + "lower("+this.queryServiceFields[this.currentColumnType] + ")" + " = " + "'" + this.currentTableData[0][i].toLowerCase() + "' ";
				}
			}
			queryString += ") and (";
		
			//process selected row index
			//for(var i= 1; i< this.currentTableData.length;i++)
			//{
			//	if(i==1)
			queryString += "lower("+this.queryServiceFields[this.currentRowType] +")" + " = " + "'" + this.currentTableData[displayIndex][0].toLowerCase() + "' ";
			//	else 
			//		queryString += " or " + this.queryServiceFields[this.currentRowType] + " = " + "'" + this.currentTableData[i][0] + "' ";
			//}
			queryString += ")";
			
			query.where= queryString;
			
			var self = this;  // need to make sure closure has the proper context for the object
			queryTask.execute(query, function(fset) {
				self.receiveFeatureSet(fset,displayIndex,false);
			});
		
		
		};

		// show block groups on map if there is a match in the classificationData. 
		//	Use classificationData to determine symbology
		
		ccMap.prototype.receiveFeatureSet = function(featureSet,displayIndex,resetMapExtent) {
			//alert("receiveFeatureSet");
			this.currentQueryGraphics = featureSet;
			
			// determine extent of featureSet;
			this.currentQueryGraphicsExtent = this.calculateFeatureSetExtent(featureSet);
			
			this.showClassifiedFeatureSet(displayIndex, resetMapExtent);
		};
		
		ccMap.prototype.calculateFeatureSetExtent = function(featureSet) {
			var serviceExtent;
			for (var i=0; i<featureSet.features.length; i++) {
				var graphic = featureSet.features[i];
				if(i==0)
					serviceExtent = graphic.geometry.getExtent();
				else
				{
					var tempExtent = graphic.geometry.getExtent();
					if(serviceExtent.xmax < tempExtent.xmax)
						serviceExtent.xmax = tempExtent.xmax;
					if(serviceExtent.ymax < tempExtent.ymax)
						serviceExtent.ymax = tempExtent.ymax;
					if(serviceExtent.xmin > tempExtent.xmin)
						serviceExtent.xmin = tempExtent.xmin;
					if(serviceExtent.ymin > tempExtent.ymin)
						serviceExtent.ymin = tempExtent.ymin;
				}
			}
			return serviceExtent;
		};
		
		ccMap.prototype.showClassifiedFeatureSet = function(displayIndex, resetMapExtent) {
			if(this.currentQueryGraphics == null)
				return;
				
			if(this.currentDisplayIndex != null && this.currentDisplayIndex == displayIndex)
				return;
			else
				this.currentDisplayIndex = displayIndex;
				
			//remove all graphics on the maps graphics layer
			this.map.graphics.clear();
			
			// note to self -- I think I can probably remove this
			if(this.currentStudyAreaGraphic != null)
			{
				this.currentStudyAreaGraphic.symbol = this.studyAreaGraphicSymbol;
				this.map.graphics.add(this.currentStudyAreaGraphic);
			}
						
			if(resetMapExtent == true)
				if(this.currentQueryGraphicsExtent != null)
					this.map.setExtent(this.currentQueryGraphicsExtent.expand(1.2),true);
			
			var featureSet = this.currentQueryGraphics;
			var numFeatures = featureSet.features.length;
			
			if(this.classificationSymbols == null)
			{
		
			// create array of symbols
				this.classificationSymbols = new Array();
				for(var i=0;i<this.classifier.classSymbolData.length;i++)
				{
					var thisColor = new dojo.Color(this.classifier.classSymbolData[i].color);
					var thisColorRGB = thisColor.toRgb();
					thisColorRGB[3]=0.55;
					this.classificationSymbols[i] = new esri.symbol.SimpleFillSymbol(esri.symbol.SimpleFillSymbol.STYLE_SOLID, new esri.symbol.SimpleLineSymbol(esri.symbol.SimpleLineSymbol.STYLE_SOLID, new dojo.Color([0,0,0]), 1), new dojo.Color(thisColorRGB));
				}
			}
			//********************************************************************************************
			//
			// set symbols using classifier
			//
			//*********************************************************************************************
			var classificationArray = this.classifier.classifyByCol(this.currentTableData,this.currentDisplayIndex, this.currentClassifierIgnoreZero);
			var classificationType = null;
			if(this.currentClassifyByRowOrCol == this.classifyByRowOrCol.col)
				classificationType = this.currentColumnType;
			for (var i=0; i<numFeatures; i++) 
			{
			  var graphic = featureSet.features[i];
				// check to see if we have data for this graphic
				//if(classificationData.fipsData.hasOwnProperty(graphic.attributes.FIPS))
				//{
					graphic.symbol = this.classificationSymbols[classificationArray[graphic.attributes[this.queryServiceFields[classificationType]]][0]];
					graphic.attributes.dataValue = classificationArray[graphic.attributes[this.queryServiceFields[classificationType]]][1];
					this.map.graphics.add(graphic);
				//}
			}
			this.createClassificationLegend();
		};

		ccMap.prototype.showTooltip = function(evt){
        this.closeDialog();
		var valueLabel;
		if(this.currentOverallFilterType == this.spatialTypes.dataattributes && this.currentOverallFilterValue != null)
			valueLabel = this.currentOverallFilterValue;
		else if(this.currentClassifyByRowOrCol == this.classifyByRowOrCol.col && this.currentRowType == this.spatialTypes.dataattributes)
			valueLabel = this.currentTableData[this.currentDisplayIndex][0];
		
        //var tipContent = "hello";
		var tipContent ="<b>" + this.spatialDisplayTypeAlias[this.currentSpatialDisplayType] + "</b>: " + evt.graphic.attributes[this.queryServiceFields[this.currentSpatialDisplayType]]+
          "<br><b>" + valueLabel +"</b>: " + evt.graphic.attributes.dataValue;
          //"<br><b>Total Acres</b>: " +  evt.graphic.attributes.approxacre +
          //"<br><b>Avg. Field Depth</b>: " + evt.graphic.attributes.avgdepth + " meters";
        var dialog = new dijit.TooltipDialog({
          id: "tooltipDialog",
          content: tipContent,
          style: "position: absolute; width: 250px; font: normal normal bold 6pt Tahoma;z-index:100"
        });
        dialog.startup();

        dojo.style(dialog.domNode, "opacity", 0.85);
        dijit.placeOnScreen(dialog.domNode, {x: evt.pageX, y: evt.pageY}, ["TL", "BL"], {x: 10, y: 10});
      };

      ccMap.prototype.closeDialog = function() {
        var widget = dijit.byId("tooltipDialog");
        if (widget) {
          widget.destroy();
        }
	  };

		ccMap.prototype.createClassificationLegend = function() {
			var classificationLegendDescriptionText = "";
			if(this.currentOverallFilterType == this.spatialTypes.dataattributes)
				classificationLegendDescriptionText = this.currentOverallFilterValue;
			else if(this.currentRowType == this.spatialTypes.dataattributes)
				classificationLegendDescriptionText = this.currentTableData[this.currentDisplayIndex][0];

			var classificationContainer = $("div#classificationLegend");
			classificationContainer.empty();
			classificationContainer.append(
				$(document.createElement("div")).attr("class","classificationLegendDescriptionDiv")
				.text(classificationLegendDescriptionText)
			);
			if(this.classifier.currentInterval ==0)
			{
				var labelText = this.classifier.getClassLabel(0);
				classificationContainer.append(
				$(document.createElement("div")).attr("class","classificationLegendDiv")
						.append(
							$(document.createElement("div")).attr({
								"class": "color-swatch"
								,style:"background-color:"+this.classifier.classSymbolData[0].color})
						)
						.append(
							$(document.createElement('label'))
							.text(" "+labelText)
						)							
				)
			}
			else
			{
				for(var i = 0; i< this.classifier.classSymbolData.length;i++)
				{
					var labelText = this.classifier.getClassLabel(i);
					classificationContainer.append(
					$(document.createElement("div")).attr("class","classificationLegendDiv")
							.append(
								$(document.createElement("div")).attr({
									"class": "color-swatch"
									,style:"background-color:"+this.classifier.classSymbolData[i].color})
							)
							.append(
								$(document.createElement('label'))
								.text(" "+labelText)
							)							
					)
				}
			}
		};
	 
		
		//********************************************************************************************************************************
		//
		// junk -- waiting to delete
		//
		//********************************************************************************************************************************
		
		ccMap.prototype.queryAndDisplayDELETE =  function(tableData, spatialType, extent, displayIndex) {
			//this.classifier = classifier;
			this.currentDisplayIndex = null;
			this.currentTableData = tableData;
			if(extent==null || extent.length ==0)
			{
				this.currentStudyAreaGraphic = null;
				this.currentStudyAreaExtent = null;
				this.queryAndDisplayWithoutExtent(spatialType,displayIndex);
			}
			else
			{
				this.currentStudyAreaExtent = extent;			
				this.queryAndDisplayWithExtent1(spatialType,extent,displayIndex);
			}
		};
		
		ccMap.prototype.queryAndDisplayWithExtent1DELETE = function(spatialType,extent,displayIndex) {
			// query for service area geometry
			
			var queryTask = new esri.tasks.QueryTask(this.queryServices[this.spatialTypes.serviceareas]+"?token="+this.token);
			
			//build query filter
			var query = new esri.tasks.Query();
			query.outSpatialReference = {"wkid": 102100};
			query.returnGeometry = true;
			query.outFields = [""];
			var queryString = "lower(" + this.queryServiceFields[this.spatialTypes.serviceareas] + ")" + " = " + "'" + extent.toLowerCase() + "'";
			query.where= queryString;
						
			var self = this;  // need to make sure closure has the proper context for the object
			queryTask.execute(query, function(fset) {
				//alert("withextent1");
				self.queryAndDisplayWithExtent2(fset,spatialType,displayIndex);
			});

		};
		
		ccMap.prototype.queryAndDisplayWithExtent2DELETE = function(fset,spatialType,displayIndex) {
			
			// make sure I found a spatial extent
			if(fset.features.length != 1)
				return;
			else
				this.currentStudyAreaGraphic = fset.features[0];
				
			//build query task
			var queryTask = new esri.tasks.QueryTask(this.queryServices[spatialType]+"?token="+this.token);

			//build query filter
			var query = new esri.tasks.Query();
			query.outSpatialReference = {"wkid": 102100};
			query.returnGeometry = true;
			query.outFields = [""];
			
			// build query string
			var queryString = "";
			for(var i= 1; i< this.currentTableData[0].length;i++)
			{
				if(this.currentTableData[0][i].toLowerCase() != "total" && this.currentTableData[0][i].toLowerCase() != "median" )
				{
					if(queryString.length == 0)
						queryString += "lower(" + this.queryServiceFields[spatialType] + ")" + " = " + "'" + this.currentTableData[0][i].toLowerCase() + "' ";
					else 
						queryString += " or " + "lower(" + this.queryServiceFields[spatialType] + ")" + " = " + "'" + this.currentTableData[0][i].toLowerCase() + "' ";
				}
			}
			query.where= queryString;
			query.geometry = this.currentStudyAreaGraphic.geometry;
			query.spatialRelationship = esri.tasks.Query.SPATIAL_REL_CONTAINS;
			var self = this;  // need to make sure closure has the proper context for the object
			queryTask.execute(query, function(fset) {
				//alert(" extent 2 execute call back");
				self.receiveFeatureSet(fset,displayIndex,true);
			});
				
		};
	
		ccMap.prototype.queryAndDisplayWithoutExtentDELETE = function(spatialType,displayIndex) {
			//build query task
			var queryTask = new esri.tasks.QueryTask(this.queryServices[spatialType]+"?token="+this.token);

			//build query filter
			var query = new esri.tasks.Query();
			query.outSpatialReference = {"wkid": 102100};
			query.returnGeometry = true;
			query.outFields = [""];
			
			// build query string
			var queryString = "";
			for(var i= 1; i< this.currentTableData[0].length;i++)
			{
				if(this.currentTableData[0][i].toLowerCase() != "total" && this.currentTableData[0][i].toLowerCase() != "median" )
				{
					if(queryString.length == 0)
						queryString += "lower(" + this.queryServiceFields[spatialType] + ")" + " = " + "'" + this.currentTableData[0][i].toLowerCase() + "' ";
					else 
						queryString += " or " + "lower(" +this.queryServiceFields[spatialType] + ")" + " = " + "'" + this.currentTableData[0][i].toLowerCase() + "' ";
				}
			}
			query.where= queryString;
			
			var self = this;  // need to make sure closure has the proper context for the object
			queryTask.execute(query, function(fset) {
				//alert("execute call back");
				self.receiveFeatureSet(fset,displayIndex,true);
			});
		};

		// **** END WAITING TO DELETE ********************************************************************************
		
		
        ccMap._initialized = true;   
    }

	dojo.connect(this.layers, "onLoad", this, "getLegendGraphics");

}