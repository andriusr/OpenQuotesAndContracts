var OqcExternalContractsDocuments = function() {
	return {
		waitingGifTag: document.getElementById('loadingGif'),
		tree: 0,
		url: '',
		
		init: function() {
			// init directory tree
			OqcExternalContractsDocuments.tree = new dhtmlXTreeObject('directoryTreeContainer', "100%", "100%", 0);
			OqcExternalContractsDocuments.tree.setImagePath("../../../include/oqc/dhtmlx/imgs/");
			OqcExternalContractsDocuments.tree.setXMLAutoLoading("../../../oqc/GetDirectoryStructure.php");
			OqcExternalContractsDocuments.tree.loadXML("../../../oqc/GetDirectoryStructure.php?id=0");
			
			// use a custom sort function behaving like a most file manager tools: sort files/directories by name, ignore case, put directories before files
			OqcExternalContractsDocuments.tree.setCustomSortFunction(function sort_func(a,b){
				var aIsFile = OqcExternalContractsDocuments.tree.getUserData(a, "selectable");
				var bIsFile = OqcExternalContractsDocuments.tree.getUserData(b, "selectable");
				
				if (!aIsFile && bIsFile) {
					// special case: a is directory, b is file: put b after a
					return -1;
				} else if (aIsFile && !bIsFile) {
					// special case a is file, b is directory: put a after b
					return +1;
				} else {
					// both a and b are files or directories. sort them and ignore case
		            a = (OqcExternalContractsDocuments.tree.getItemText(a)).toLowerCase();
		            b = (OqcExternalContractsDocuments.tree.getItemText(b)).toLowerCase();
		            
		            if (a==b)
		            	return 0;
		            else 
		            	return ((a>b)?+1:-1);
				}
	        });
			
			OqcExternalContractsDocuments.tree.attachEvent("onClick", function(id) {
				if (OqcCommon.tagExists('okButton')) {
					document.getElementById('okButton').disabled = !OqcExternalContractsDocuments.tree.getUserData(id, 'selectable');
				}
		        return true;
		    });
		    
		    if (OqcCommon.isDhtmlxProfessional(OqcExternalContractsDocuments.tree)) {
		    	OqcExternalContractsDocuments.tree.enableDistributedParsing(true);
		    
			    OqcExternalContractsDocuments.tree.attachEvent("onXLS", function(tree, id) {
			    	// xml loading started. display "loading.." gif.
			    	OqcExternalContractsDocuments.waitingGifTag.style.display = '';
			        return true;
			    });
			    
			    OqcExternalContractsDocuments.tree.attachEvent("onXLE", function(tree, id) {
			    	// xml loadiung finished. hide "loading.." gif.
			    	OqcExternalContractsDocuments.waitingGifTag.style.display = 'none';
			    	// sort tree beginning at id because we have new nodes when loading has finished
			    	OqcExternalContractsDocuments.tree.sortTree(id, "ASC", true);
			        return true;
			    });
			} else {
				// only standard edition is available. we hide the tag because otherwise it is visible the whole time showing 'loading..'
				OqcExternalContractsDocuments.waitingGifTag.style.display = 'none';
			}
		},

		closePopup: function() {
			var ID = OqcExternalContractsDocuments.tree.getSelectedItemId();
			var PATH = OqcExternalContractsDocuments.tree.getUserData(ID, 'fullpath');

			window.opener.popupCallback(CALLBACK_PARAMETER, PATH);
			
			window.close();
		},
		
		checkExistanceFor: function(o) {
			var name = o.name;
			var id = o.id;
			
			YAHOO.util.Connect.asyncRequest('GET', 'oqc/CheckFileExistance.php?n='+name+'&id='+id, {
                success: OqcExternalContractsDocuments.receivedFileExistance,
                failure: OqcExternalContractsDocuments.handleFailureReceivingFileExistance,
                argument: [name, id]
            });
		},
		
		receivedFileExistance: function(o) {
			var name = o.argument[0];
			var id = o.argument[1];
			
			var fileNotExists = "0" == o.responseText;
			
			if (fileNotExists) {
				document.getElementById(name + 'FileExistance').innerHTML = languageStringsDocuments.fileNotExists;
			}
		},
		
		handleFailureReceivingFileExistance: function(o) {
			window.alert("could not check file existance for " + o.name + " url=" + o.id);
		}
	};
}();
