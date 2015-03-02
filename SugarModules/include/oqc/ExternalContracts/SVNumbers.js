var OqcExternalContractsSVNumbers = function() {
	return {
		defaultSVNumberTableName: 'svnumbersTable',
	
		// NOTE: id of svnumber can be id of existing contract
		SVNumber: function(id, name) { 
			this.id = id;
			this.name = name;
		},
		
		createSVNumbersTable: function(containerId, tableId, svnumbersArray, readOnly) {
			var container = document.getElementById(containerId);
			
			var table = OqcCommon.getTable(tableId);
			if (readOnly) {
				table.appendChild(OqcCommon.getTableHeader('svnumbers_header', 'listViewThS1', [languageStringsCommon['contract_number']], ['left'], ['80%', '20%']));
			} else {
				table.appendChild(
					OqcCommon.getTableHeader(
						'svnumbers_header',
						'listViewThS1',
						[languageStringsCommon['contract_number'], OqcCommon.getTransparentGif(),OqcCommon.getTransparentGif()],
						['left', 'left', 'left'],
						['60%', '20%','20%'],
						0,
						[true, false, false] 
					)
				);
			}
			
			for (var i=0; i<svnumbersArray.length; i++) {
				OqcExternalContractsSVNumbers.addSVNumber(tableId, svnumbersArray[i], readOnly);
			}
			
			container.appendChild(table);
		},
		
		addSVNumber: function(tableId, svnumber, readOnly) {
			var table = document.getElementById(tableId);
			
			if (!svnumber.id || '' == svnumber.id) {
				svnumber.id = OqcCommon.getRandomString();
			}
			
			if (readOnly) {
				var nameTag	= document.createTextNode(svnumber.name);
				
				table.appendChild(OqcCommon.getTableRow(svnumber.id, 'oddListRowS1', [nameTag], ['left']));
			} else {
				//var nameTag				= OqcCommon.getServiceInputField("svnumbersName_" + svnumber.id, "svnumberNames[]", svnumber.name, "text", 30, "left");
				var nameTag				= OqcCommon.getServiceInputField("svnumbersName_" + svnumber.id, "svnumbersName_" + svnumber.id, svnumber.name, "text", 30, "left");
				nameTag.setAttribute('maxlength', 255);
				nameTag.setAttribute('class', 'sqsEnabled');
				//var hiddenIdTag 		= OqcCommon.getServiceInputField("svnumbersId_" + svnumber.id, "svnumberIds[]", svnumber.id, "hidden", 1, "left");
				var hiddenIdTag 		= OqcCommon.getServiceInputField("svnumbersId_" + svnumber.id, "svnumbersId_" + svnumber.id, svnumber.id, "hidden", 1, "left");
				var removeTag			= OqcCommon.getServiceInputField("remove_" + svnumber.id, "removes[]", languageStringsCommon['delete'], "button", 1, "left");
				
				removeTag.className = "button";
				removeTag.setAttribute('onClick', 'removeFromValidate("EditView", "svnumbersName_' + svnumber.id + '"); OqcCommon.removeTag("' + svnumber.id + '"); OqcCommon.toggleTableDisplaying("' + tableId + '");');
				var selectTag			= OqcCommon.getServiceInputField("select_" + svnumber.id, "select_" + svnumber.id, languageStringsCommon['select'], "button", 1, "left");
				selectTag.className = "button";
				selectTag.setAttribute('onClick', 'open_popup("oqc_Contract", 600, 400, "", true, false, {"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"svnumbersId_' + svnumber.id+ '","svnumber":"svnumbersName_' + svnumber.id +'"}}, "single", true )');
				
				
				
		//		"open_popup( "oqc_Category", 600, 400, "", true, false, {"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":"relatedcategory_id","name":"oqc_relatedcategory_name"}}, "single", true );"
		
				var nameValidationScript = OqcCommon.getValidationScript('svnumbersName_' + svnumber.id, languageStringsCommon['name'], 'varchar');
				table.appendChild(OqcCommon.getTableRow(svnumber.id, 'oddListRowS1', [new Array(nameTag, nameValidationScript, hiddenIdTag), selectTag, removeTag], ['left', 'left','left']));

				// extend quicksearch variable sqs_objects to enable quicksearch directly on this new field (workaround for #369, #370)
				OqcCommon.addToSqsObjects([{oqc_module:'oqc_Contract',
													 fieldList: ['svnumber', 'is_latest', 'id'],
													 populateList: ['svnumbersName_' + svnumber.id, 'svnumbersId_' + svnumber.id, 'svnumbersId_' + svnumber.id],
													 valueList : ['', '1', '']
													 }]);
				
				YAHOO.util.Event.addListener(nameTag, 'change', OqcCommon.setModifiedFlag);
				YAHOO.util.Event.addListener(removeTag, 'click', OqcCommon.setModifiedFlag);
			}
		}
	};
}();
