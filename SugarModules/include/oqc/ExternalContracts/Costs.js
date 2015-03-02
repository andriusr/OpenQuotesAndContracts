
// taken from http://www.digital-web.com/articles/javascript_date_object_with_user_methods/
Date.prototype.addMonths= function(m) {
	var d = this.getDate();
	this.setMonth(this.getMonth() + m);

	if (this.getDate() < d)
	this.setDate(0);
};

Date.prototype.addYears = function(y) {
	var m = this.getMonth();
	this.setFullYear(this.getFullYear() + y);
	if (m < this.getMonth()) {
		this.setDate(0);
	}
}; 

var OqcExternalContractsCosts = function() {
	return {
		oldStartDate: '',
		oldEndDate: '',
		// Map for caching user input. It saves prices, descriptions, .. that already have been entered by the user and could be useful after the recreation of table rows.
		cache: new Map(),
		// timeout in milliseconds until costs tables are updated
		updateTimeout: 1000,
		defaultCostTableName: 'costsTable',
	
		Cost: function(id, category, desc, price, payment, year) {
			this.id = id;
			this.category = category;
			this.payment = payment;
			this.year = year;
			this.description = desc;
			this.price = price;
		
		 	if ('number' == typeof(price)) {
		 		// format the price and replace the dot '.' by sugarDecimalSeperator (',' for example)
		 		this.price = this.price.toFixed(2).toString().replace('.', sugarDecimalSeperator);
			}	
		},
		
		DetailedCost: function(id, price, month) {
			this.id = id;
			this.month = month;
			this.price = price;
		
		 	if ('number' == typeof(price)) {
		 		// format the price and replace the dot '.' by sugarDecimalSeperator (',' for example)
		 		this.price = this.price.toFixed(2).toString().replace('.', sugarDecimalSeperator);
			}	
		},
		
		createCostsTable: function(containerId, tableId, title, costsArray, readOnly) {
			var container = document.getElementById(containerId);
			
			var table = OqcCommon.getTable(tableId);
			table.appendChild(
				OqcCommon.getTableHeader(
					'costs_header',
					'listViewThS1',
					[languageStringsCommon['description'], languageStringsCommon['payment'], languageStringsCommon['sum'], languageStringsCommon['year']],
					['left', 'right', 'right', 'right'],
					/* 
					 * editview:
					 *   do not set colums widths, use automatically chosen width
					 * detailview:
					 *   set maximum width of description column to avoid that payment column is wrapped.     
					 */
					readOnly ? ['50%', '20%', '15%', '15%'] : false, 
					title,
					[false, true, true, true]
				)
			);
			
			for (var i=0; i<costsArray.length; i++) {
				OqcExternalContractsCosts.addCost(tableId, costsArray[i], readOnly, false);
			}
			
			container.appendChild(table);
		},
		
		addCost: function(tableId, cost, readOnly, insertAtTheTop) {
			var table = document.getElementById(tableId);
			
			if (readOnly) {
				var paymentTag		= document.createTextNode(SUGAR.language.get('app_list_strings', 'paymentinterval_list')[cost.payment]);
				var yearTag			= document.createTextNode(cost.year);
				var descriptionTag	= document.createTextNode(cost.description);

				if ('once' == cost.payment || 'annually' == cost.payment || 'other' == cost.payment) {
					var priceTag = document.createTextNode(cost.price);
					
					table.appendChild(
						OqcCommon.getTableRow(
							cost.id,
							'oddListRowS1',
							[descriptionTag, priceTag, paymentTag, yearTag],
							['left', 'right', 'right', 'right']
						)
					);
				} else {
					var detailTag = OqcCommon.getTagWithAttributes('input',
						['type', 'class', 'value', 'name', 'id', 'style', 'onclick'],
						['button', 'button', 'Detail', 'costDetail_' + cost.id, 'costDetail_' + cost.id, 'margin-left: 5px;', 'OqcCommon.toggleTagVisibility("detailedCostsTable_' + cost.id + '");']
					);
					var detailedCostsContainer = OqcExternalContractsCosts.getDetailedCostsList(OqcCommon.getTagWithAttributes('span', ['id', 'style'], ['detailedCostsTable_' + cost.id, 'display: none; text-align: right;']), cost);
					
					table.appendChild(
						OqcCommon.getTableRow(
							cost.id,
							'oddListRowS1',
							[descriptionTag, new Array(detailTag, detailedCostsContainer), paymentTag, yearTag],
							['left', 'right', 'right', 'right']
						)
					);
					
					// put braces around the price if it is invalid because the detailed costs are different from the cost price
					var priceTag = (OqcExternalContractsCosts.detailedCostsPricesAreEqualToCostPrice(cost)) ? (document.createTextNode(cost.price)) : (document.createTextNode('('+cost.price+')'));
					document.getElementById(cost.id).childNodes[1].insertBefore(priceTag, detailTag);
				}
			} else {
				// do we have a bigger screen?
				var big = OqcCommon.hasBigScreen();
				
				// field sizes are optimized for 1280x1024
				var categoryTag		= OqcCommon.getServiceInputField("costCategory_" + cost.id, "costCategories[]", cost.category, "hidden", 1, "left");
				var yearTag			= OqcCommon.getServiceInputField("costYear_" + cost.id, "costYears[]", cost.year, "text", 4, "right");
				var priceTag		= OqcCommon.getServiceInputField("costPrice_" + cost.id, "costPrices[]", cost.price, "text", big ? 10 : 6, "right");
				var descriptionTag	= OqcCommon.getServiceInputField("costDescription_" + cost.id, "costDescriptions[]", cost.description, "text", big ? 100 : 40, "left");
				var hiddenIdTag		= OqcCommon.getServiceInputField("costId_" + cost.id, "costIds[]", cost.id, "hidden", 1, "left");
				var detailTag		= OqcCommon.getTagWithAttributes('input',
					['type', 'class', 'value', 'name', 'id', 'style', 'onclick'],
					['button', 'button', 'Detail', 'costDetail_' + cost.id, 'costDetail_' + cost.id, 'margin-left: 5px;', 'OqcCommon.toggleTagVisibility("detailedCostsTable_' + cost.id + '");']
				);
				var detailedCostsContainer = OqcExternalContractsCosts.getDetailedCostsList(OqcCommon.getTagWithAttributes('span', ['id', 'style'], ['detailedCostsTable_' + cost.id, 'display: none; text-align: right;']), cost);
				
				var paymentIntervalTranslation = SUGAR.language.get('app_list_strings', 'paymentinterval_list');
				
				var paymentTag		= OqcCommon.getSelectField("costPayment_" + cost.id, "costPayment[]",
					['monthly', 'quarterly', 'halfyearly', 'annually', 'once', 'other'],
					[paymentIntervalTranslation.monthly, paymentIntervalTranslation.quarterly, paymentIntervalTranslation.halfyearly, paymentIntervalTranslation.annually, paymentIntervalTranslation.once, paymentIntervalTranslation.other],
					cost.payment
				);
					
				yearTag.setAttribute('readonly', 'readonly');
		
				descriptionTag.setAttribute('maxlength', 255);
		
				var priceValidationScript = OqcCommon.getValidationScript('costPrice_' + cost.id, languageStringsCommon['price'], 'currency');
				
				// this is a workaround that moves the table content to the top when the cost details are displayed
				var floatingTag1 = OqcCommon.getTransparentGif(); floatingTag1.style.height = '100%';
				var floatingTag2 = OqcCommon.getTransparentGif(); floatingTag2.style.height = '100%';
				var floatingTag3 = OqcCommon.getTransparentGif(); floatingTag3.style.height = '100%';
				descriptionTag.style.marginTop = '2px';				
				paymentTag.style.marginTop = '2px';
				yearTag.style.marginTop = '2px';
				
				var newCostRow = OqcCommon.getTableRow(
					cost.id,
					'oddListRowS1', [
						new Array(descriptionTag, hiddenIdTag, categoryTag, document.createElement('br'), floatingTag1),
						new Array(paymentTag, document.createElement('br'), floatingTag2),
						new Array(priceTag, priceValidationScript, detailTag, detailedCostsContainer),
						new Array(yearTag, document.createElement('br'), floatingTag3)
					],
					['left', 'right', 'right', 'right']
				);
				
				if (insertAtTheTop) {
					table.insertBefore(newCostRow, table.childNodes[1]); 
				} else {
					table.appendChild(newCostRow);
				}
				
				OqcCommon.setReadonly('costPrice_'+cost.id, !OqcExternalContractsCosts.detailedCostsPricesAreEqualToCostPrice(cost));
				
				// attach a change event on the paymentTag because the detailedCostsList probably has to be updated after the payment value has been changed
				YAHOO.util.Event.addListener(paymentTag, 'change', OqcExternalContractsCosts.updateDetailedCostsList);
				
				/* 
				 * if the user has not yet changed the detailed costs the price he enters in the main cost price field should be inserted into the detailed cost fields.
				 * this is needed because the finalcosts are calculated as a sum of detailed costs.
				 */
				YAHOO.util.Event.addListener(priceTag, 'change', OqcExternalContractsCosts.insertPriceChangeIntoDetailedCosts);
				
				YAHOO.util.Event.addListener(priceTag, 'change', OqcCommon.setModifiedFlag);
				YAHOO.util.Event.addListener(descriptionTag, 'change', OqcCommon.setModifiedFlag);
				YAHOO.util.Event.addListener(paymentTag, 'change', OqcCommon.setModifiedFlag);  
			}
		},
		
		existRowsForCategory: function(category) {
			var rows = document.getElementsByName('costCategories[]');
			
			if (rows && rows.length > 0) {
				for (var i=0; i<rows.length; i++) {
					if (category == rows[i].value) {
						return true;
					}
				}
			}
			return false;
		},
		
		setNumberOfRows: function(tableId, category, oldStartYear, newStartYear, oldEndYear, newEndYear) {
			var table = document.getElementById(tableId);
			
			var rowsExist = OqcExternalContractsCosts.existRowsForCategory(category);
			
			if (rowsExist) {
				// there are some already existing rows. we can use them to calculate the {start,end}YearDiffs.
			
				// handle change of startdate
				var startYearDiff = newStartYear - oldStartYear;
				var firstTableRow = table.childNodes[2]; // the first row under the table title rows
				
				if (startYearDiff > 0) {
					// remove cost rows from the top of the table
					for (var i=0; i<startYearDiff; i++) {
						if (document.getElementById(tableId).childNodes[1]) {
							OqcCommon.removeTag(document.getElementById(tableId).childNodes[1].id);
						}		
					}
				} else if (startYearDiff < 0) {
					// add startYearDiff cost rows at the top of the table
					for (var i=startYearDiff; i<0; i++) {
						var year = newStartYear - i - 1;
						OqcExternalContractsCosts.addCachedCostIfPossible(tableId, category, year, true);
					}
				}
			
				// handle change of enddate
				var endYearDiff = newEndYear - oldEndYear;
				
				if (endYearDiff < 0) {
					// remove cost rows from the bottom of the table
					for (var i=endYearDiff; i<0; i++) {
						OqcCommon.removeTag(table.lastChild.id);
					} 
				} else if (endYearDiff > 0) {
					// add endYearDiff cost rows at the bottom of the table
					for (var i=1; i<=endYearDiff; i++) {
						var year = oldEndYear + i;
						OqcExternalContractsCosts.addCachedCostIfPossible(tableId, category, year, false);
					}
				}
			} else {
				// no cost rows exist. create them "from scratch" because we cannot look at existing cost rows for calculating the {start,end}YearDiffs.
				var numberOfMissingRows = newEndYear - newStartYear + 1;
				
				for (var i=0; i<numberOfMissingRows; i++) {
					var year = newStartYear + i;
					OqcExternalContractsCosts.addCachedCostIfPossible(tableId, category, year, false);
				}
			}  
		},
		
		// try to load a cost from the cache and call addCost with it. if the cost does not exist in the cache call addCost with a new cost.
		addCachedCostIfPossible: function(tableId, category, year, insertAtTheTop) {
			// try to load row from cache
			if (this.cache.contains(category + year)) {
				// load cost row from cache
				var cachedCost = this.cache.get(category + year);
				var id = cachedCost.id;
				var price = cachedCost.price;
				var payment = cachedCost.payment;
				var description = cachedCost.description;
			
				OqcExternalContractsCosts.addCost(tableId, new OqcExternalContractsCosts.Cost(id, category, description, price, payment, year), false, insertAtTheTop);	
			} else {
				// create a new row
				OqcExternalContractsCosts.addCost(tableId, new OqcExternalContractsCosts.Cost(OqcCommon.getRandomString(), category, '', 0, 'monthly', year), false, insertAtTheTop);
			}
		},
		
		updateCostsSum: function() {
			var costsPriceTags = document.getElementsByName('costPrices[]');
			if (!costsPriceTags) {
				// return because no cost rows exist yet
				return;
			}
		
			var costsPaymentTags = document.getElementsByName('costPayment[]');
			var sum = 0;
		
			// determine start+end month of contract
			var startDateObj = getDateObject(document.getElementById('startdate').value);
			var startMonth = startDateObj.getMonth()+1;
			var endMonth = OqcExternalContractsCosts.getEndDate().getMonth() + 1;
		
			var selectedContractMatters = OqcCommon.getNumberOfSelectedItemsInComboBox('externalcontractmatter');
			if (0 == selectedContractMatters) {
				// return because no contract matters are selected and so no cost rows will exist
				return;
			}
		
			var numberOfRowsPerCost = parseInt(costsPriceTags.length) / parseInt(selectedContractMatters);
		
			{
				var detailedCostIdTags = document.getElementsByName('costIds[]');
				
				// iterate over cost ids
				for (var i=0; i<detailedCostIdTags.length; i++) {
					var id = detailedCostIdTags[i].value;
					var monthTags = document.getElementsByName('detailedCostMonth_'+id+'[]');

					// iterate over detailed cost months of this cost position
					for (var k=0; k<monthTags.length; k++) {
						var month = monthTags[k].value;
						// replace decimal seperator in detailed cost price with dot .
						var price = parseFloat(document.getElementById('detailedCostPrice_'+month+'_'+id).value.replace(sugarDecimalSeperator, '.'));
						// add detailed cost price to final cost sum 
						sum += price;
					}
				}
			}
			/*for (var i=0; i<costsPriceTags.length; i++) {
				var factor, costs;
				var costPaymentString = costsPaymentTags[i].value;
		
				if (1 == numberOfRowsPerCost) {
					// every cost consists of a single row. the contract lifetime starts and ends in the same year.
					if (startMonth == endMonth) {
						factor = OqcExternalContractsCosts.getFactorFromPaymentIntervalString(costsPaymentTags[i].value);
					} else {
						factor = Math.ceil((endMonth - startMonth + 1)/OqcExternalContractsCosts.getNumberOfMonthsFromPaymentIntervalString(costsPaymentTags[i].value));
					}
				} else if (0 == i % numberOfRowsPerCost) {
					// we are at a start date row
					factor = Math.ceil((13 - startMonth)/OqcExternalContractsCosts.getNumberOfMonthsFromPaymentIntervalString(costsPaymentTags[i].value));
				} else if (0 == (i+1) % numberOfRowsPerCost) {
					// we are at a ending year row
					factor = Math.ceil(endMonth/OqcExternalContractsCosts.getNumberOfMonthsFromPaymentIntervalString(costsPaymentTags[i].value));
				} else {
					factor = OqcExternalContractsCosts.getFactorFromPaymentIntervalString(costsPaymentTags[i].value);
				}
		
				// change numbers like '1,00' to '1.00' and convert them to float values 1.00 that can be used for multiplication
				costs = parseFloat(costsPriceTags[i].value.replace(sugarDecimalSeperator, '.'));
				sum += factor * costs; // TODO check content-type before adding!
			}*/
			
			var sumTag = document.getElementById('finalcosts');
			sumTag.value = sum.toFixed(2).toString().replace('.', sugarDecimalSeperator);
		},
		
		getNumberOfMonthsFromPaymentIntervalString: function(str) {
			return 12/OqcExternalContractsCosts.getFactorFromPaymentIntervalString(str);
		},
		
		getFactorFromPaymentIntervalString: function(str) { 
			if ('once' == str || 'annually' == str || 'other' == str) {
				return 1;
			} else if ('halfyearly' == str) {
				return 2;	
			} else if ('quarterly' == str) {
				return 4;		
			} else if ('monthly' == str) {
				return 12;
			}
		},
		
		// Iterate over all input fields of the cost rows and write the user input into the cache.
		updateCache: function() {
			var costsIdTags = document.getElementsByName('costIds[]');
			
			for (var i=0; i<costsIdTags.length; i++) {
				var id = costsIdTags[i].value;
				var year = document.getElementById('costYear_' + id).value;
				var price = document.getElementById('costPrice_' + id).value;
				var payment = document.getElementById('costPayment_' + id).value;
				var category = document.getElementById('costCategory_' + id).value;
				var description = document.getElementById('costDescription_' + id).value;
		
				this.cache.set(category + year, new OqcExternalContractsCosts.Cost(id, category, description, price, payment, parseInt(year)));
				
				// update cache for detailed costs list
				OqcExternalContractsCosts.updateCacheForDetailedCostPrice(id, category, year);
			}
		},
		
		// TODO this is damn slow at the moment
		updateCacheForDetailedCostPrice: function(id, category, year) {
			var detailedCostMonthTags = document.getElementsByName('detailedCostMonth_'+id+'[]');
			for (var i=0; i<detailedCostMonthTags.length; i++) {
				var month = detailedCostMonthTags[i].value;
				var price = document.getElementById('detailedCostPrice_'+month+'_'+id).value;
					
				this.cache.set(category + year + month, new OqcExternalContractsCosts.DetailedCost(id, price, month));
			}		
		},
		
		// returns the date until the contract will run
		getEndDate: function() {
			var period = document.getElementById('endperiod').value;
			var endDateValue = document.getElementById('enddate').value;
			var startDateValue = document.getElementById('startdate').value;
			
			if ('' != startDateValue && (('other' != period) || ('other' == period && '' != endDateValue))) {
				if ('other' == period) {
					var endDateObject = getDateObject(endDateValue);
					// 'other' has been selected. use enddate field directly.
					return endDateObject;
				// something else than other has been selected. use content of endperiod field to calculate the lifetime.
				} else {
					var startDateObject = getDateObject(startDateValue);
					
					if ('infinite' == period) {
						currentDate = new Date();
						startDateObject.setYear(currentDate.getFullYear());
					}
					
					var months = OqcExternalContractsCosts.monthStringToInt(period);
					startDateObject.addMonths(months);
					startDateObject.setDate(startDateObject.getDate()-1); // go back 1 day (NO, IT IS 'GO BACK ONE DATE'. OH MY GOD, DAMN!!)
					
					return startDateObject;
				}
			} else {
				return false;
			}
		},
		
		updateCostsTables: function() {
			var endDate = OqcExternalContractsCosts.getEndDate();
			
			if (endDate) {
				var newEndYear = endDate.getFullYear();
				
				// TODO make sure that startdate <= enddate
				var newStartYear = getDateObject(document.getElementById('startdate').value).getFullYear();
				
				// initialize old{Start,End}Year variables (if no tables exist yet)		
				var oldStartYear = newStartYear;
				var oldEndYear = newEndYear;
				
				// overwrite old{Start,End}Year variables if there are already existing cost tables
				if (document.getElementsByName('costYears[]') && document.getElementsByName('costYears[]').length > 0) {
					oldStartYear = parseInt(document.getElementsByName('costYears[]')[0].value); // year column of first table row 
					oldEndYear = parseInt(document.getElementsByName('costYears[]')[document.getElementsByName('costYears[]').length-1].value); // year column of last table row
				}
				
				var useEndPeriod = 'other' != document.getElementById('endperiod').value;
				var contractmatterTags = document.getElementById('externalcontractmatter');
		
				// correct number of rows for all visible cost tables
				for (var i=0; i<contractmatterTags.options.length; i++) {
					var categoryName = contractmatterTags.options[i].value;
					var tableId = 'costsTable_' + categoryName;
					
					if (contractmatterTags.options[i].selected) {
						var tableTitle =  contractmatterTags.options[i].text;
						
						if (!OqcCommon.tagExists(tableId)) {
							// create the table if it does not exist yet
							OqcExternalContractsCosts.createCostsTable('costsContainer', tableId, tableTitle, [], false);
						}
						
						OqcExternalContractsCosts.setNumberOfRows(tableId, categoryName, oldStartYear, newStartYear, oldEndYear, newEndYear);
					} else {
						OqcCommon.removeTag(tableId);
					}
				}
			
				OqcExternalContractsCosts.updateCostsSum();
				OqcExternalContractsCosts.updateCache();
			}
		
			// call this method automatically every (OqcExternalContractsCosts.updateTimeout) ms
			window.setTimeout('OqcExternalContractsCosts.updateCostsTables()', this.updateTimeout);
		},
		
		hideDateSelectionFields: function() {
			var periodTag = document.getElementById('endperiod');
			var endDateTag = document.getElementById('enddate');
			var dateSelectTag = document.getElementById('enddate_trigger');
			
			OqcCommon.setReadonly('enddate', 'other' != periodTag.value);
			OqcCommon.setTagVisible('enddate_trigger', 'other' == periodTag.value);
			// make the infinity explanation hint visible if there is at least one contract matter selected. make hint invisible otherwise. 
			OqcCommon.setTagVisible('infinityHint', 'infinite' == periodTag.value && 0 != OqcCommon.getNumberOfSelectedItemsInComboBox('externalcontractmatter'));

			if ('other' != periodTag.value) {
				endDateTag.value = OqcCommon.getFormattedDateStringFromDateObject(OqcExternalContractsCosts.getEndDate(), sugarDateFormat);
			}
		
			// show/hide description field if pay for expense is checked/unchecked
			var checkboxTag = document.getElementById('payforexpense');
			OqcCommon.setTagVisible('payforexpensedescription', checkboxTag.checked);
			
			window.setTimeout('OqcExternalContractsCosts.hideDateSelectionFields()', 250);
		},
		
		monthStringToInt: function(monthString) {
			if ('3months' == monthString) {
				return 3;
			} else if ('6months' == monthString) {
				return 6;
			} else if ('9months' == monthString) {
				return 9;
			} else if ('12months' == monthString) {
				return 12;
			} else if ('24months' == monthString) {
				return 24;
			} else if ('36months' == monthString) {
				return 36;
			} else if ('48months' == monthString || 'infinite' == monthString) { // the user selected 'infinite' -> assume that the contract runs the next four years
				return 48;
			} else {
				alert('Invalid month string: ' + monthString);
				return -1;
			}
		},
		
		// this method is called when the form is almost completely rendered. some time after the complete rendering of the page the addAutoCompletionToAllFields is called to overwrite sugarcrms quicksearch settings with those we need. note that sqs_objects is updated at runtime when new input fields are created (see SVNumers.js -> addSVNumber)
		callAddAutoCompletionToAllFieldsDeferred: function() {
			window.setTimeout('OqcExternalContractsCosts.addAutoCompletionToAllFields();', 2000);
		},
		
		addAutoCompletionToAllFields: function() {
			OqcCommon.addToSqsObjects([
				{oqc_module:'Accounts', fieldList: ['name', 'id'], populateList: ['account', 'account_id']},
				{oqc_module:'Contacts', fieldList: ['first_name', 'last_name', 'id'], populateList: ['clientcontactperson', 'clientcontact_id', 'clientcontact_id']},
				{oqc_module:'Contacts', fieldList: ['first_name', 'last_name', 'id'], populateList: ['technicalcontactperson', 'technicalcontact_id', 'technicalcontact_id']}
				// ['', ['name', 'id', 'first_name'], ['', '_id']],
			]);
		},
		
		getDetailedCostsList: function(container, cost) {
			var startDate = (readOnly) ? (getDateObject(startDateString)) : (getDateObject(document.getElementById('startdate').value));
			var endDate = (readOnly) ? (getDateObject(endDateString)) : (OqcExternalContractsCosts.getEndDate());
			
			if (cost.year < startDate.getFullYear() || cost.year > endDate.getFullYear()) {
				return container; // return an empty table if this cost year is before startdate or after enddate of the contract 
			}
			
			var date = new Date();
			var startYear = startDate.getFullYear(), startMonth = startDate.getMonth()+1;
			var endYear = endDate.getFullYear(), endMonth = endDate.getMonth()+1;

			/* number of months between payment
			 * if (cost.payment == 'monthly') ->  paymentInterval = 12 / 12 = 1 means that you have to pay every month
			 * if (cost.payment == 'quaterly') ->  paymentInterval = 12 / 4 = 3 means that you have to pay every third month
			 */
			var paymentInterval = 12 / OqcExternalContractsCosts.getFactorFromPaymentIntervalString(cost.payment);

			/* iterate over months. i represents the months 1..12 / jan..dec
			 * check if the current month (i) should be displayed or not (depending on paymentInterval, startdate, enddate
			 * we start at the paymentInterval -th month, increment it with paymentInterval until we reach dec. this simulates the different payment interval strings
			 */ 
			for (var i=paymentInterval; i<=12; i+=paymentInterval) {
				if ((startYear == endYear && ((i >= startMonth && i <= endMonth) || 12 == paymentInterval)) ||
					(startYear < endYear &&
						((cost.year == startYear && (i >= startMonth || 12 == paymentInterval)) ||
						(cost.year == endYear && (i <= endMonth || 12 == paymentInterval)) ||
						(cost.year > startYear && cost.year < endYear))))
				{
					// try to load the price of the detailed cost position from cache because maybe it has been entered before
					var cachedCost = OqcExternalContractsCosts.cache.get(cost.category + cost.year + i);
					
					if (12 == paymentInterval && cost.year == endYear) {
						// once, annually or other has been selected as paymentinterval string and we are in an end year row
						// use month of the enddate as payment month 
						date.setMonth(endMonth-1); // decrement endMonth because it runs from 1..12 but the month in javascripts date object runs from 0..11
					} else {
						date.setMonth(i-1); // decrement i because it runs from 1..12 but the month in javascripts date object runs from 0..11
					}
					
					var month = date.toLocaleString().split(' ')[2];

					var priceTag = OqcCommon.getTagWithAttributes(
						'input',
						['id','name','value','type','size','style'],
						["detailedCostPrice_"+i+"_"+cost.id, "detailedCostPrice_"+cost.id+"[]", (cachedCost && 'undefined' != typeof(cachedCost.price)) ? (cachedCost.price) : (cost.price), "text", 7, (readOnly) ? ("text-align: right; margin: 4px; border: 0px;") : ("text-align: right; margin: 4px;")],
						false
					);
					
					var monthTag = OqcCommon.getTagWithAttributes(
						'input',
						['value','type', 'size','style'],
						[month, 'text', 8, 'border: 0px;'],
						false
					);

					container.appendChild(document.createElement('br'));
					container.appendChild(priceTag);
					container.appendChild(monthTag);
					// hidden fields storing the month for this detailed cost position and the id of the detailed cost 
					container.appendChild(OqcCommon.getServiceInputField("detailedCostId_"+i+"_"+cost.id, 'detailedCostId_'+cost.id+'[]', (cachedCost != null) ? (cachedCost.id) : (OqcCommon.getRandomString()), "hidden", 1, "left"));
					container.appendChild(OqcCommon.getServiceInputField("detailedCostMonth_"+i+"_"+cost.id, "detailedCostMonth_"+cost.id+"[]", i, "hidden", 1, "left"));
					
					if (!readOnly) {
						YAHOO.util.Event.addListener(priceTag, 'change', OqcExternalContractsCosts.setCostPriceReadonly);
						YAHOO.util.Event.addListener(priceTag, 'change', OqcCommon.setModifiedFlag);
					}
				}
			}

			return container;
		},

		updateDetailedCostsList: function(event) {
			// if we call the method directly this.id should be undefined
			if (!this.id || 'startdate' == this.id || 'enddate' == this.id) { // {start|end}date has been changed. we have to iterate over all costs and update each row because we do not now exactly which rows should be updated
				var costIdTags = document.getElementsByName('costIds[]');
				
				for (var i=0; i<costIdTags.length; i++) {
					var id = costIdTags[i].value;
					var category = document.getElementById('costCategory_'+id).value;
					var year = document.getElementById('costYear_'+id).value;

					var cachedCost = OqcExternalContractsCosts.cache.get(category + year);
					if (cachedCost != null) {
						// delete old detailedCostsList from the container 
						var detailedCostsListContainer = document.getElementById('detailedCostsTable_' + id);
						OqcCommon.removeChildrenFromNode(detailedCostsListContainer);
						
						// insert the new list into the container of the list
						OqcExternalContractsCosts.getDetailedCostsList(detailedCostsListContainer, cachedCost);	
					}
				}
			} else { // the paymentinterval of a cost has been changed. we can access this.id to find out which cost row should be updated
				// get data neccessary to find cachedCost
				var id = this.id.split('_')[1];
				var category = document.getElementById('costCategory_'+id).value;
				var year = document.getElementById('costYear_'+id).value;
				var cachedCost = OqcExternalContractsCosts.cache.get(category + year);
	
				// update payment of cached cost because payment might have been changed right before this method has been called. we better do not trust the cached version of the cost.			
				cachedCost.payment = document.getElementById('costPayment_'+id).value;
	
				if (cachedCost != null) {
					// cachedCost has been found in cache
					
					// delete old detailedCostsList from the container 
					var detailedCostsListContainer = document.getElementById('detailedCostsTable_' + id);
					OqcCommon.removeChildrenFromNode(detailedCostsListContainer);
					
					// insert the new list into the container of the list
					OqcExternalContractsCosts.getDetailedCostsList(detailedCostsListContainer, cachedCost);
				}
				
				OqcExternalContractsCosts.cache.set(category + year, cachedCost);
			}
		},
		
		// set the cost price field readonly because a detailed cost price has been changed.
		setCostPriceReadonly: function(event) {
			var id = this.id.split('_')[2];
			OqcCommon.setReadonly('costPrice_'+id, true);
		},
		
		// return true if the prices of all detailed costs are equal to the price of the given cost
		// otherwise false
		detailedCostsPricesAreEqualToCostPrice: function(cost) {
			var monthTags = document.getElementsByName('detailedCostMonth_'+cost.id+'[]');
			
			for (var i=0; i<monthTags.length; i++) {
				var month = monthTags[i].value;
				var price = document.getElementById('detailedCostPrice_'+month+'_'+cost.id).value;
				
				if (cost.price != price) {
					return false; 
				}
			}
			
			return true;
		},
		
		// this method is used as a workaround for #474. changing the date with the calender widget does not fire the change event. so we cannot use the cool yahoo event library here. instead we look every second of the content of the input field has been changed and call the update method if neccessary. this is an event-less approach ^^
		checkIfDatesHaveDatesChanged: function() {
			var startDateValue = document.getElementById('startdate').value;
			var endDateValue = document.getElementById('enddate').value;
		
			if (startDateValue != OqcExternalContractsCosts.oldStartDate || endDateValue != OqcExternalContractsCosts.oldEndDate) { 
				OqcExternalContractsCosts.updateDetailedCostsList();
			}
			
			OqcExternalContractsCosts.oldStartDate = startDateValue;
			OqcExternalContractsCosts.oldEndDate = endDateValue;
			
			window.setTimeout('OqcExternalContractsCosts.checkIfDatesHaveDatesChanged();', OqcExternalContractsCosts.updateTimeout);
		},
		
		startDateChecking: function() {
			OqcExternalContractsCosts.oldStartDate = document.getElementById('startdate').value;
			OqcExternalContractsCosts.oldEndDate = document.getElementById('enddate').value;
			
			OqcExternalContractsCosts.checkIfDatesHaveDatesChanged();
		},
		
		insertPriceChangeIntoDetailedCosts: function(event) {
			var id = this.id.split('_')[1]; // id of the cost that price has been changed 
			var monthTags = document.getElementsByName('detailedCostMonth_' + id + '[]');
			
			for (var i=0; i<monthTags.length; i++) {
				var month = monthTags[i].value;
				document.getElementById('detailedCostPrice_' + month + '_' + id).value = this.value;
			}
		}
	};
}();
