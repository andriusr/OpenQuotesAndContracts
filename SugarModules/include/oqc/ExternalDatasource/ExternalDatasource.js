var OqcExternalDatasource = function() {
	return {
		init: function() {
		    // Use an XHRDataSource
		    var oDS = new YAHOO.util.XHRDataSource("oqc/GetDataFromPerlaDummy.php");
		    // Max size of the local cache. Set to 0 to turn off caching. Caching is useful to reduce the number of server connections. Recommended
			// only for data sources that return comprehensive results for queries or when stale data is not an issue.
		    // TODO disabled cache: values from cache are not displayed probably because currently only the IDs are displayed instead of formatted names
		    oDS.maxCacheEntries = 0;
		    // Set the responseType
		    oDS.responseType = YAHOO.util.XHRDataSource.TYPE_JSON;
		    // Define the schema of the JSON results
		    oDS.responseSchema = {
		        resultsList : "ResultSet",
		        fields : ["id","first_name", "last_name"]
		    };

		    // Instantiate the AutoComplete
		    var autocomplete = new YAHOO.widget.AutoComplete("autocompleteInput", "autocompleteContainer", oDS);
		    
		    
		    // Enables query subset matching. When the DataSource's cache is enabled and queryMatchSubset is true, substrings of queries will return
			// matching cached results. For instance, if the first query is for "abc" susequent queries that start with "abc", like "abcd", will be
			// queried against the cache, and not the live data source. Recommended only for DataSources that return comprehensive results for queries
			// with very few characters.
		    autocomplete.queryMatchSubset = true;
		    
		    autocomplete.minQueryLength = 2;
		    // disable vertical animation. horizontal animation is disabled by default.
		    autocomplete.animVert = false; 
		    // Throttle requests sent
		    autocomplete.queryDelay = .5;
		    // from yui doc: For backward compatibility to pre-2.6.0 formatResults() signatures, setting resultsTypeList to true will take each object
			// literal result returned by DataSource and flatten into an array
		    autocomplete.resultTypeList = false; 
		    // The webservice needs additional parameters
		    autocomplete.generateRequest = function(sQuery) {
		        return "?q=" + sQuery;
		    };
		    autocomplete.formatResult = OqcExternalDatasource.formatMatchingLetters;
		    
		    autocomplete.itemSelectEvent.subscribe(function(sType, aArgs) {
		    	// Define an event handler to populate a hidden form field
				// when an item gets selected and populate the input field
		    	
			    var myAC = aArgs[0]; // reference back to the AC instance
			    var elLI = aArgs[1]; // reference to the selected LI element
			    var oData = aArgs[2]; // object literal of selected item's result data
			    
			    // update hidden form field with the selected item's ID
			    YAHOO.util.Dom.get("hiddenId").value = oData.id;
			    
			    myAC.getInputEl().value = oData.first_name + " " + oData.last_name;
			});
		},
		
		// Custom formatter to highlight the matching letters
		formatMatchingLetters: function(oResultData, sQuery, sResultMatch) {
		    var query = sQuery.toLowerCase(),
		        fname = oResultData.first_name,
		        lname = oResultData.last_name,
		        query = sQuery.toLowerCase(),
		        fnameMatchIndex = fname.toLowerCase().indexOf(query),
		        lnameMatchIndex = lname.toLowerCase().indexOf(query);
		        
		    if(fnameMatchIndex > -1) {
		        displayfname = OqcExternalDatasource.highlightMatch(fname, query, fnameMatchIndex);
		    }
		    else {
		        displayfname = fname;
		    }

		    if(lnameMatchIndex > -1) {
		        displaylname = OqcExternalDatasource.highlightMatch(lname, query, lnameMatchIndex);
		    }
		    else {
		        displaylname = lname;
		    }

		    return displayfname + " " + displaylname;
		},

		// Helper function for the formatter
		highlightMatch: function(full, snippet, matchindex) {
		    return full.substring(0, matchindex) + 
		            "<span class='match'>" + 
		            full.substr(matchindex, snippet.length) + 
		            "</span>" +
		            full.substring(matchindex + snippet.length);
		}
	};
}();




