function ccEqualIntervalClassifier(classSymbolData)
{
	this.classSymbolData = classSymbolData;
	this.currentMin = null;
	this.currentMax = null;
	this.currentInterval = null;
	if(typeof ccEqualIntervalClassifier._initialized == "undefined")
    {
		ccEqualIntervalClassifier.prototype.classify = function(tableData,index) {
			if(tableData.length <2)
				return;
			// determine min and max of data
			var dataMin = tableData[1][index];
			var dataMax = dataMin;
			
			for(var i = 2; i<tableData.length;i++)
			{
				if(tableData[i][index]>dataMax)
					dataMax = tableData[i][index];
				if(tableData[i][index]<dataMin)
					dataMin = tableData[i][index];
			}
			
			this.currentMin = dataMin;
			this.currentMax = dataMax;
			this.currentInterval = (dataMax - dataMin)/this.classSymbolData.length;
			
			// do classification
			var classificationArray = new Array();
			for(var i = 1; i<tableData.length;i++)
			{
				// floor may have handled the boundary conditions ok but this will make sure it works
				if(tableData[i][index] == this.currentMin)
					classificationArray(i) = 0;
				else if(tableData[i][index] == this.currentMax)
					classificationArray(i) = this.classSymbolData.length -1;
				else
					classificationArray(i) = Math.floor((tableData[i][index] - this.currentMin)/this.currentInterval);
			}	
			return classificationArray;
		};
		
		ccEqualIntervalClassifier.prototype.getClassLabel = function(classIndex) {
			if(this.currentMin == null || this.currentMax == null || this.currentInterval == null)
				return "";
			else if(this.currentInterval == 0)
			{
				var fixedNum=0;
				if(this.currentMin <= 1)
					fixedNum = 2;
				else if(this.currentMin <= 10)
					fixedNum = 1;
				//else
				//	fixedNum = 0;
				return Number(this.currentMin).toFixed(fixedNum);
			}
			else
			{
				var fixedNum=0;
				if(this.currentInterval <= 1)
					fixedNum = 2;
				else if(this.currentInterval <= 10)
					fixedNum = 1;
				//else
				//	fixedNum = 0;
			
				return Number(this.currentMin + classIndex * this.currentInterval).toFixed(fixedNum) + " - " + Number(this.currentMin + (classIndex + 1.0) * this.currentInterval).toFixed(fixedNum);
			}
		};
		
		ccEqualIntervalClassifier.prototype.classifyByCol = function(tableData,index,ignoreZero) {
			if(ignoreZero == "undefined")
				ignoreZero = false;
			if(tableData[0].length <2)
				return;
			// determine min and max of data and last valid index
			var dataMin; //= tableData[index][1];
			var dataMax; //= dataMin;
			var lastValidIndex = 0;
			var minmaxInitialized = false;
			for(var i = 1; i<tableData[0].length;i++)
			{
				if(tableData[0][i].toLowerCase() != "total" && tableData[0][i].toLowerCase() != "median" )
				{
					if(!ignoreZero || this.returnNumber(tableData[index][i])!=0)
					{	
						if(!minmaxInitialized)
						{
							dataMin = this.returnNumber(tableData[index][i]);
							dataMax = dataMin;
							minmaxInitialized = true;
						}
						else
						{
							if(this.returnNumber(tableData[index][i])>dataMax)
								dataMax = this.returnNumber(tableData[index][i]);
							if(this.returnNumber(tableData[index][i])<dataMin)
								dataMin = this.returnNumber(tableData[index][i]);
						}
					}
					lastValidIndex = i;
				}
			}
			
			this.currentMin = dataMin;
			this.currentMax = dataMax;
			this.currentInterval = (dataMax - dataMin)/this.classSymbolData.length;

			// do classification
			var classificationArray = new Array();
			
			if(this.currentInterval == 0)
			{
				for(var i = 1; i<=lastValidIndex;i++)
					classificationArray[tableData[0][i]] = [0,this.returnNumber(tableData[index][i])];
			}
			else
			{
				for(var i = 1; i<=lastValidIndex;i++)
				{
					// floor may have handled the boundary conditions ok but this will make sure it works
					if(this.returnNumber(tableData[index][i]) == this.currentMin)
						//classificationArray[tableData[0][i]] = [0,99];
						classificationArray[tableData[0][i]] = [0,this.returnNumber(tableData[index][i])];
					else if(this.returnNumber(tableData[index][i]) == this.currentMax)
						//classificationArray[tableData[0][i]] = [this.classSymbolData.length -1,100];
						classificationArray[tableData[0][i]] = [this.classSymbolData.length -1,this.returnNumber(tableData[index][i])];
					else
						//classificationArray[tableData[0][i]] = [Math.floor((tableData[index][i] - this.currentMin)/this.currentInterval),101];
						classificationArray[tableData[0][i]] = [Math.floor((this.returnNumber(tableData[index][i]) - this.currentMin)/this.currentInterval),this.returnNumber(tableData[index][i])];
				}	
			}
			return classificationArray;
		};	

		ccEqualIntervalClassifier.prototype.returnNumber = function(dataValue) {
			var thisType = typeof dataValue;
			if(thisType == "number")
				return dataValue;
			else if(thisType == "string")
			{
				var noComma = dataValue.replace(/,/g,'');
				return Number(noComma);
			}
			else
				return dataValue;
		};
        ccEqualIntervalClassifier._initialized = true;   
    }
}