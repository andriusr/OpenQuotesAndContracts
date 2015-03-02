var OqcExternalContractsPositions = function() {
	return {
		defaultPositionTableName: 'positionsTable',	
	
		Position: function(id, name, qty, price, desc, type) {
			this.id = id;
			this.name = name;
			this.quantity = qty;
			this.price = price;
			this.description = desc;
			this.type = type;
			
		 	if ('number' == typeof(this.price)) {
		 		// format the price and replace the dot '.' by sugarDecimalSeperator (',' for example)
		 		this.price = this.price.toFixed(2).toString().replace('.', sugarDecimalSeperator);
			}	
		},
		
		createPositionsTable: function(containerId, tableId, positionsArray, readOnly) {
			var container = document.getElementById(containerId);
			
			var table = OqcCommon.getTable(tableId);
			if (readOnly) {
				table.appendChild(
					OqcCommon.getTableHeader(
						tableId,
						'listViewThS1',
						[languageStringsCommon['name'], languageStringsCommon['quantity'], languageStringsCommon['price'], languageStringsCommon['type'], languageStringsCommon['description']],
						['left', 'right', 'right', 'left', 'left'],
						false
					)
				);
			} else {
				table.appendChild(
					OqcCommon.getTableHeader(
						tableId,
						'listViewThS1',
						[languageStringsCommon['name'], languageStringsCommon['quantity'], languageStringsCommon['price'], languageStringsCommon['type'], languageStringsCommon['description'], OqcCommon.getTransparentGif()],
						['left', 'right', 'right', 'left', 'left'],
						false,
						0,
						[true, true, true, true, false, false]
					)
				);
			}
			
			for (var i=0; i<positionsArray.length; i++) {
				OqcExternalContractsPositions.addPosition(tableId, positionsArray[i], readOnly);
			}
			
			container.appendChild(table);
		},
		
		addPosition: function(tableId, position, readOnly) {
			var table = document.getElementById(tableId);
			
			if (readOnly) {
				var nameTag			= document.createTextNode(position.name);
				var quantityTag		= document.createTextNode(position.quantity);
				var priceTag		= document.createTextNode(position.price);
				var descriptionTag	= document.createTextNode(position.description);
				var typeTag		= document.createTextNode(position.type);
			
				table.appendChild(OqcCommon.getTableRow(position.id, 'oddListRowS1', [nameTag, quantityTag, priceTag, typeTag, descriptionTag], ['left', 'right', 'right', 'left', 'left']));
			} else {
				// do we have a bigger screen?
				var big = OqcCommon.hasBigScreen();
				
				var nameTag		= OqcCommon.getServiceInputField("positionName_" + position.id, "positionName_" + position.id, position.name, "text", big ? 50 : 20, "left");
				var quantityTag		= OqcCommon.getServiceInputField("positionQuantity_" + position.id, "positionQuantity_" + position.id, position.quantity, "text", 3, "right");
				var priceTag		= OqcCommon.getServiceInputField("positionPrice_" + position.id, "positionPrice_" + position.id, position.price, "text", 8, "right");
				var descriptionTag	= OqcCommon.getServiceInputField("positionDescription_" + position.id, "positionDescription_" + position.id, position.description, "text", big ? 40 : 20, "left");
				var hiddenIdTag		= OqcCommon.getServiceInputField("positionId_" + position.id, "positionIds[]", position.id, "hidden", 1, "left");
				var removeTag		= OqcCommon.getServiceInputField("remove_" + position.id, "removes[]", languageStringsCommon['delete'], "button", 1, "left");
				
				descriptionTag.setAttribute('maxlength', 255);
			
				var typeTranslation = SUGAR.language.get('app_list_strings', 'externalcontractmatter_list');
				
				var typeTag		= OqcCommon.getSelectField("positionType_" + position.id, "positionType[]",
					['software', 'hardware', 'furniture', 'service', 'innerservice', 'other'],
					[typeTranslation.software, typeTranslation.hardware, typeTranslation.furniture, typeTranslation.service, typeTranslation.innerservice, typeTranslation.other],
					position.type
				);
		
				removeTag.className = "button";
				removeTag.setAttribute('onClick', 'OqcCommon.removeTag("' + position.id + '"); OqcCommon.toggleTableDisplaying("' + tableId + '");');
				var nameValidationScript = OqcCommon.getValidationScript('positionName_' + position.id, languageStringsCommon['name'], 'varchar');
				var quantityValidationScript = OqcCommon.getValidationScript('positionQuantity_' + position.id, languageStringsCommon['quantity'], 'int');
				var priceValidationScript = OqcCommon.getValidationScript('positionPrice_' + position.id, languageStringsCommon['price'], 'currency');

				YAHOO.util.Event.addListener(nameTag, 'change', OqcCommon.setModifiedFlag);
				YAHOO.util.Event.addListener(quantityTag, 'change', OqcCommon.setModifiedFlag);
				YAHOO.util.Event.addListener(priceTag, 'change', OqcCommon.setModifiedFlag);
				YAHOO.util.Event.addListener(typeTag, 'change', OqcCommon.setModifiedFlag);
				YAHOO.util.Event.addListener(descriptionTag, 'change', OqcCommon.setModifiedFlag);
				YAHOO.util.Event.addListener(removeTag, 'click', OqcCommon.setModifiedFlag);
						
				table.appendChild(
					OqcCommon.getTableRow(
						position.id,
						'oddListRowS1', [
							new Array(nameTag, nameValidationScript, hiddenIdTag),
							new Array(quantityTag, quantityValidationScript),
							new Array(priceTag, priceValidationScript),
							typeTag,
							descriptionTag,
							removeTag
						],
						['left', 'right', 'right', 'left', 'left', 'left']
					)
				);
			}
		}
	};
}();
