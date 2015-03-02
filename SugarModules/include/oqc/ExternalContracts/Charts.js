var theDatasource;
var theDatasource2;

function initChart() {
	var myChart = new YAHOO.widget.PieChart( "chartsContainer1", theDatasource,
	{
		dataField: "price",
		categoryField: "category",
		style:
		{
			padding: 20,
			legend:
			{
				display: "right",
				padding: 10,
				spacing: 5,
				font:
				{
					family: "Arial",
					size: 13
				}
			}
		},
	});
	
	OqcCommon.removeTag('waitingGif');
	OqcCommon.removeTag('showReportsButton');
}

function initChart2() {
	var seriesDef = 
	[
		{
			xField: 'hardware',
			displayName: 'Year'		
		},
		{
			xField: 'software',
			displayName: 'software',
		},
		{
			xField: 'furniture',
			displayName: 'furniture',
		},
		{
			xField: 'service',
			displayName: 'service',
		},
	]; 
	
	var currencyAxis = new YAHOO.widget.NumericAxis();
	currencyAxis.labelFunction = function(value) {
	    return YAHOO.util.Number.format( value, {
        	suffix: ' EUR',
        	thousandsSeparator: '.',
        	decimalSeperator: ',',
        	//decimalPlaces: 2
    	})};
	
	var tag = document.getElementById('chartsContainer2');
	tag.style.height = '500px';
	tag.style.margin = '0 auto';
	
	var myChart2 = new YAHOO.widget.BarChart( "chartsContainer2", theDatasource2,
	{
		series: seriesDef,
		yField: 'year',
		xAxis: currencyAxis,
		style: {
			xAxis: {
				labelRotation: -90
			}
		},
		label: 'Expenses for external contracts per year',
	});
	
	OqcCommon.removeTag('waitingGif2');
	OqcCommon.removeTag('showReportsButton');
}

var handleFailure = function(o) {
	alert('could not get expenses');
	OqcCommon.removeTag('waitingGif');
}

var handleFailure2 = function(o) {
	alert('could not get expenses per year per');
	OqcCommon.removeTag('waitingGif2');
}

var createCharts = function(o) {
	YAHOO.widget.Chart.SWFURL = "include/oqc/Charts/charts.swf";
 	
	theData = JSON.parse(o.responseText);
	
	theDatasource = new YAHOO.util.DataSource(theData);
	theDatasource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
	theDatasource.responseSchema = {
	    fields: [ "price","category","year" ]
	};
	
	window.setTimeout("initChart()", 1000);
}

var createCharts2 = function(o) {
	YAHOO.widget.Chart.SWFURL = "include/oqc/Charts/charts.swf";
 	
	theData = JSON.parse(o.responseText);
	
	theDatasource2 = new YAHOO.util.DataSource(theData);
	theDatasource2.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
	theDatasource2.responseSchema = {
	    fields: ['year', 'hardware', 'software', 'furniture', 'service' ]
	};
	
	window.setTimeout("initChart2()", 1000);
}

function getExpenses(url) {
	OqcCommon.addToContainer(OqcCommon.getWaitingGif('waitingGif'), 'waitingGifContainer');
	var request = YAHOO.util.Connect.asyncRequest('GET', url, {success: createCharts, failure: handleFailure});
}

function getExpensesOfExternalContractsPerYear(url) {
	OqcCommon.addToContainer(OqcCommon.getWaitingGif('waitingGif2'), 'waitingGifContainer');
	var request = YAHOO.util.Connect.asyncRequest('GET', url, {success: createCharts2, failure: handleFailure2});
}
