<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib uri="http://www.fusioncharts.com/jsp/core" prefix="fc"%>
<%@ taglib prefix="tags" tagdir="/WEB-INF/tags"%>
<jsp:useBean id="chartData"
	class="com.fusioncharts.sampledata.BasicRenderData" />
<c:set var="folderPath" value="../../FusionCharts/" />
<c:set var="title" value="FusionCharts - Simple Column 3D Chart"
	scope="request" />
<c:set var="header1" value="FusionCharts - Examples" scope="request" />
<c:set var="header2" value="Basic example using pre-built Data.xml"
	scope="request" />
<c:set var="assetCSSPath" value="../assets/ui/css/" scope="request"/>
<c:set var="assetJSPath" value="../assets/ui/js/" scope="request"/>
<c:set var="assetImagePath" value="../assets/ui/images/" scope="request"/>
<%--
	This page demonstrates the ease of generating charts using FusionCharts.
	For this chart, we've used a pre-defined Data.xml (contained in /Data/ folder)
	Ideally, you would NOT use a physical data file. Instead you'll have 
	your own Bean to create the XML data document. Such examples are also present.
	For a head-start, we've kept this example very simple.
	--%>
<%--Create the chart - Column 3D Chart with data from Data/Data.xml --%>
<%--  
    chartId="myFirst";
	xmlUrl="Data/Data.xml";
	width="600";
	height="300";
	swfFilename = "../../FusionCharts/Column3D.swf";
 --%>
<tags:template1>
	<c:catch var="fcTagError">
		<fc:renderHTML chartId="${chartData.chartId}"
			swfFilename="${folderPath}${chartData.swfFilename}"
			width="${chartData.width}" height="${chartData.height}"
			debugMode="false" xmlUrl="${chartData.url}" />
	</c:catch>
	<c:if test="${not empty fcTagError}">
	 Tag Error! <br/>${fcTagError}
	</c:if>
</tags:template1>