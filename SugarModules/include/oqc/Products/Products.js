
var myDataTable;

var OqcProducts = function() {
    return {
    
        handlePopUpClosed: function(popupReplyData) {
            var formName = popupReplyData.formName;
            var nameToValueArray = popupReplyData.name_to_value_array;
            var service = {};
				    
            for (var currentKey in nameToValueArray) {
                if (currentKey != 'toJSON') {
                    var displayValue = nameToValueArray[currentKey];
                    displayValue = displayValue.replace('&#039;', "'"); //restore escaped single quote.
                    displayValue = displayValue.replace('&amp;', "&"); //restore escaped &.
                    displayValue = displayValue.replace('&gt;', ">"); //restore escaped >.
                    displayValue = displayValue.replace('&lt;', "<"); //restore escaped <.
                    displayValue = displayValue.replace('&quot; ', "\""); //restore escaped \".
                    service[currentKey] = displayValue;
                }
            }
				    
            if (typeof service.productId == "string" && 0 < service.productId.length) {
                // workaround translation issues
                if (service.zeitbezug == popupReplyData.passthru_data.zeitbezug_once)
                    service.zeitbezug = 'once';
                else if (service.zeitbezug == popupReplyData.passthru_data.zeitbezug_monthly)
                    service.zeitbezug = 'monthly';
                else if (service.zeitbezug == popupReplyData.passthru_data.zeitbezug_annually)
                    service.zeitbezug = 'annually';
				
                if (service.unit == popupReplyData.passthru_data.unit_pieces) {
                    service.unit = 'pieces';
                } else if (service.unit == popupReplyData.passthru_data.unit_hours) {
                    service.unit = 'hours';
                }
                
                if (service.oqc_vat == '') {
                	service.oqc_vat = 'default';}
				
              //  var isUnique = 'unique' == popupReplyData.passthru_data.addToServices;
              	 var isUnique = service.is_recurring == '0' ? true : false;
              	 if (service.currency_id != oqc_current_id) {
	        			var calc_rate = parseFloat(oqc_ConversionRates[service.currency_id])/parseFloat(oqc_currency_rate);
	        			service.price = parseFloat(service.price.replace(decimalSeparator, '.'))/calc_rate;
                }
                //alert(service.vat + service.oqc_vat);
                var r = {
                    Quantity: "1",
                    Tax: (service.oqc_vat != 'default') ? (parseFloat(service.oqc_vat.toString().replace(decimalSeparator, '.'))/100) : 'default',
                    Name: service.name,
                    Unit: service.unit,
                    IsUnique: isUnique,
                    // not necessary since price correction is done in RowAdd event handling
                    Price: isUnique ? service.price : "0",
                    PriceRecurring: isUnique ? "0" : service.price,
                    ProductId: service.productId,
                    //							Recurrence: ('unique' == popupReplyData.passthru_data.addToServices) ? ('once') : ('ongoing'),
                    //							Description: service.description,
                    CancellationPeriod: service.cancellationperiod,
                    MonthsGuaranteed: service.monthsguaranteed,
                    Currency_id: oqc_current_id
                };
             //   alert('Vat value: ' + service.oqc_vat);
					 var uniquelength = uniqueServicesDataTable.getRecordSet().getRecords().length;
                uniqueServicesDataTable.addRow(r, uniquelength-3);

                // we added a product. set the modified flag to propagate that a change occured.
                OqcCommon.setModifiedFlag();
                OqcProducts.showChangeAlert();
            } else {
                alert('Extracted invalid product id: ' + service.productID);
            }
        },
				
        selectMenu: function(event) {
            	 	oMenuItem = event.newValue;
            	 	this.set("label", oMenuItem.cfg.getProperty("text"));
						this.blur();
                 	},
        executeButton: function(event) {
 
 						var btnValue= this.get("selectedMenuItem").value;
 //         	 		alert('Button value is: ' + btnValue);
						this.blur();
          	 		eval(btnValue);
                  		
                 	}, 
                 	
        selectOption: function(product_id) {
            open_popup("oqc_Product", 1250, 800, '&product_id=' + product_id + '&is_option=1', true, true, encodedRequestData);
        },       	
				
        initServicesTable: function(servicePrefix, id, isUniqueServices, readOnly) {
            YAHOO.util.Event.addListener(window, "load", function() {
            	
            	var actionButtonFormatter = function(elCell, oRecord, oColumn, oData) {
                 	
            	  		if (!oRecord.getData('sum')) {
            	  			var row_id = oRecord.getId();
            	 			var button_id = 'action_' + row_id; 
        						elCell.innerHTML = '<div id="' + button_id + '" title="update"></div>';
        						if (!oRecord.getData('ProductId')) {
        							var action_menu = [
      							{text: languageStrings.cst_delete, value: 'OqcProducts.deleteProduct("'+oRecord.getId()+'")'}
      							]; 	
									var button_label = languageStrings.cst_delete;
        						}
        						 
        					   else if (oRecord.getData('UpdatedVersionAvailable')) {
        						
	    						var action_menu = [
      							{text: languageStrings.update, value: 'OqcProducts.updateProduct("'+oRecord.getData('ProductId')+'", "'+oRecord.getId()+'")'},
									{text: languageStrings.addOption, value: 'OqcProducts.selectOption("' + oRecord.getData('ProductId')+'")'},
      							{text: languageStrings.cst_delete, value: 'OqcProducts.deleteProduct("'+oRecord.getId()+'")'}
      							]; 
      							var button_label = languageStrings.update;
								} else {
								var action_menu = [
      							{text: languageStrings.addOption, value: 'OqcProducts.selectOption("' + oRecord.getData('ProductId')+'")'},
      							{text: languageStrings.cst_delete, value: 'OqcProducts.deleteProduct("'+oRecord.getId()+'")'}
      							]; 	
									var button_label = languageStrings.addOption;
								}
      						var act_button = new YAHOO.widget.Button({ type: "split", label: button_label, lazyloadmenu: false, menu: action_menu, container: button_id });
      						
      						var button_menu =	act_button.getMenu();
        						button_menu.setInitialSelection();
      						act_button.set("selectedMenuItem", button_menu.activeItem);
       						act_button.subscribe("click", OqcProducts.executeButton);
      						act_button.on("selectedMenuItemChange", OqcProducts.selectMenu);
      					}
                                    	
        };
     
                var myColumnDefs;
  
               var tax = {
                        key:"Tax",
                        label: languageStrings.vat,
                        formatter: function(elCell, oRecord, oColumn, oData) { // use custom formatter instead of "checkbox" to make sure we can disable it in detailview
                            if (!oRecord.getData('sum')) {
                            	
                            	switch (oData) {
                            	case "default" :
                                oData = parseFloat(dropdownLabelsVat["default"].replace(decimalSeparator, '.')) / 100  ;	
                                oRecord.setData('Tax', oData) ; 
                                elCell.innerHTML = dropdownLabelsVat["default"]; 
                                break;
                              case false :
                            	  elCell.innerHTML = '0 %';
                                break;     
                              default:
                                oData = oData.toString();
                                if (dropdownLabelsVat[oData]) { 
                                elCell.innerHTML = dropdownLabelsVat[oData];}
                                else if (typeof oData == "string") {
                                	 elCell.innerHTML = parseFloat(oData.replace(decimalSeparator, '.')) * 100 + ' %'; }
                                else { elCell.innerHTML = dropdownLabelsVat["default"]; }
                                break; 
                                    
                           	}
                          	}

                            else {elCell.innerHTML = oData;}
                        },
                        className:'align-right'
                    };
                var name = {
                    key:"Name",
                    label: languageStrings.name,
                    formatter: function(elCell, oRecord, oColumn, oData) {
                        // use this custom formatter instead of default text formatter to allow html input. this is used to make sum rows bold.

                        if (oRecord.getData('sum'))
                            // just show the name if:
                            // - we are in edit view or
                            // - we just show a sum row
                            elCell.innerHTML = '';
                        else // show as link in both detail and edit view
                            elCell.innerHTML = OqcCommon.getBeanLink('oqc_Product', oData, oRecord.getData('ProductId'));
                    },
                    sortable:false,
                    resizeable:true
                };
                var unit = {
                    key:"Unit",
                    label: languageStrings.unit,
                    formatter: function(elCell, oRecord, oColumn, oData) {
                        if (!oRecord.getData('sum')) {
                        	if (dropdownLabelsUnit[oData]) {
                            elCell.innerHTML = dropdownLabelsUnit[oData];
                         }
                         else { elCell.innerHTML = oData;}
                        }
                    },
                    className:'align-right'
                };
                // TODO display proper translated labels
                var price = {
                    label: languageStrings.price,
                    formatter: OqcProducts.localizedCurrencyFormatter,
                    children: [
                    {
                        key: "Price",
                        label: SUGAR.language.get('oqc_Product', 'LBL_ONCE'),
                        className: 'align-right'
                    },

                    {
                        key: "PriceRecurring",
                        label: SUGAR.language.get('oqc_Product', 'LBL_MONTHLY'),
                        className: 'align-right'
                    }
                    ]
                };
                var cancellationPeriod = {
                    key:"CancellationPeriod",
                    label: SUGAR.language.get('oqc_Product', 'LBL_CANCELLATIONPERIOD'),
                    formatter: "number",
                    className:'align-right'
                };
                var monthsGuaranteed = {
                    key:"MonthsGuaranteed",
                    label: SUGAR.language.get('oqc_Product', 'LBL_MONTHSGUARANTEED'),
                    formatter: "number",
                    className:'align-right'
                };
                var sum = {
                        label: languageStrings.sum,
                        formatter: OqcProducts.localizedCurrencyFormatter, // "currency",
                        children: [
                    		{key: "Sum",
                         label: SUGAR.language.get('oqc_Product', 'LBL_ONCE'),
                         className: 'align-right'
                    		},
                    		{key: "SumRecurring",
                         label: SUGAR.language.get('oqc_Product', 'LBL_MONTHLY'),
                         className: 'align-right'
                    		}
                    		],
                        resizeable:true,
                        className:'align-right'
                    };

                // readonly view has no editors and no delete button
                if (readOnly) {
                    var quantity = {
                        key:"Quantity",
                        label: languageStrings.quantity,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                        	if (!oRecord.getData('sum')) {
                              if (oRecord.getData('Unit') == 'pieces') {
                                
                                 elCell.innerHTML = oData;	
                              }
                              else { 
                              var value = YAHOO.util.Number.format(parseFloat(oData.replace(decimalSeparator, '.')), numberOptions);
                              elCell.innerHTML = value;
                              }
                           }
                        },
                        resizeable:true,
                        sortable:false,
                        className:'align-right'
                    };
                    var updatedVersionAvailable = {
                        key:"UpdatedVersionAvailable",
                        label: languageStrings.update + "?",
                        formatter: function(elCell, oRecord, oColumn, oData) {
                        	 if (!oRecord.getData('sum')) {
                            	if (oRecord.getData('UpdatedVersionAvailable')) {
                                elCell.innerHTML = "<center>"+languageStrings.updateProduct+"</center>";
                            } else {
                            	  elCell.innerHTML = "<center>"+languageStrings.donotupdateProduct+"</center>";
                            }
                           }
                        },
                        resizeable: true
              
                    };

                    myColumnDefs = [name, quantity, unit, price, tax, sum, cancellationPeriod, monthsGuaranteed, updatedVersionAvailable];
                }
                else {
                    // buttons are only required in editview
                    var updateBtn = {
                        key:"Update",
                        label: languageStrings.action,
                        formatter: actionButtonFormatter,
                        resizeable: false,
                        width : 95
                   };
                    var quantity = {
                        key:"Quantity",
                        label: languageStrings.quantity,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                            if (!oRecord.getData('sum')) {
                                // if oData is undefined ignore the new value and set content of input field to old value
                                // this is used when updateProduct is called. it does not want to overwrite the quantity.
                                var value = oData ? oData : elCell.lastChild.value;
                                if (oRecord.getData('Unit') == 'pieces') {
                                
                                 elCell.innerHTML = "<input size='4' class='text' type='text' value='"+value+"' style='text-align:right' />";	
                                }
                              else { 
                              value = YAHOO.util.Number.format(parseFloat(value.replace(decimalSeparator, '.')), numberOptions);
                              elCell.innerHTML = "<input size='4' class='text' type='text' value='"+value+"' style='text-align:right' />";
                              }
                            }
                        },
                        editor: new YAHOO.widget.TextboxCellEditor({
                            validator: OqcProducts.quantityValidator
                        }),
                        resizeable:true,
                        sortable:false
                       // className:'align-right'
                    };
                    myColumnDefs = [name, quantity, unit, price, tax, sum, cancellationPeriod, monthsGuaranteed, updateBtn];
                }

					 // TODO evaluate security (xss, access control)
                var myDataSource = new YAHOO.util.DataSource("oqc/GetProductsJSON.php?m="+moduleName+"&id="+id+"&u=" + ((isUniqueServices) ? ("1") : ("0")));
				        	        
                // JSON
                myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
                myDataSource.connXhrMode = "queueRequests";
				        
                myDataSource.responseSchema = {
                    // ResultNode: "ResultSet", // for XML
                    resultsList: "ResultSet", // for JSON
                    fields: ["Tax", "Name", "Description","Quantity", "Unit", "Price", "PriceRecurring", "CancellationPeriod", "MonthsGuaranteed", "Sum", "ProductId", "UpdatedVersionAvailable", "IsUnique", "Currency_id"]
                };

                // local variable
                myDataTable = new YAHOO.widget.DataTable(
                    servicePrefix+"Container",
                    myColumnDefs,
                    myDataSource,
                    {
                        //caption: ((isUniqueServices) ? (languageStrings.onceTableTitle) : (languageStrings.ongoingTableTitle)),
                        currencyOptions: currencyOptions,
                        numberOptions: { // used for quantity field
                            decimalPlaces: 0, // yui default
                            thousandsSeparator: thousandsSeparator
                        },
                        dateOptions: {
                            format: dateFormat,
                            locale: 'de' // TODO
                        },
                        MSG_EMPTY : languageStrings.LBL_NO_RECORDS_MESSAGE,
                    		MSG_ERROR : languageStrings.LBL_DATA_ERROR_MESSAGE,
                    		MSG_LOADING : languageStrings.LBL_LOADING_MESSAGE
                    }
                    );
                
                myDataTable.subscribe("initEvent", function(oArgs) {
                	// initial loading has finished -> update records
                	  OqcProducts.initPrices(myDataTable);
                    OqcProducts.addSumFields();
                    //OqcProducts.updateSumAndSerializeTableData(myDataTable);
                    
                    if (readOnly) {
                    	// only update sum do not try to serialize because in detailview the hidden field needed for serialization does not exist
                    	OqcProducts.updateSum(myDataTable);
                    } else {
                    	// subscribe events when initialisation has been finished. it is neccessary to do event registration after initialisation because the sum rows have to exist before updateSum-method works correctly.
                    	OqcProducts.updateSumAndSerializeTableData(myDataTable);
                    	
                    	myDataTable.subscribe("cellClickEvent", myDataTable.onEventShowCellEditor); // neccessary for editor showing

                        myDataTable.subscribe("editorSaveEvent", function(oArgs) {
                            OqcProducts.updateSumAndSerializeTableData(myDataTable);
                        });
                        myDataTable.subscribe("rowDeleteEvent", function(oArgs) {
                            OqcProducts.updateSumAndSerializeTableData(myDataTable);
                        });

                        // handle RowAddEvent for Detail and EditView because prices have to be corrected in both cases.
                        myDataTable.subscribe("rowAddEvent", function(oArgs) {
                        	// a row has been added from a product popup
                        	//OqcProducts.initPricesForSingleRecord(oArgs.record, myDataTable);
                        	
                        	OqcProducts.updateSumAndSerializeTableData(myDataTable);
                        });
                    }
                });
					    
                // overwrite global variable with datatable stored in local variable
                uniqueServicesDataTable = myDataTable;
            });
        },
       
        initPrices: function(dataTable) {
        	
            var records = dataTable.getRecordSet().getRecords();

            for (var i=0; i<records.length; i++) {
            	OqcProducts.initPricesForSingleRecord(records[i], dataTable);
            }
        },
        
        initPricesUpdate: function(dataTable) {
        	
            var records = dataTable.getRecordSet().getRecords();
			//When there is sum rows we need to update only regular rows
            for (var i=0; i<records.length-3; i++) {
            	OqcProducts.initPricesForSingleRecord(records[i], dataTable);
            }
        },
        
        initPricesForSingleRecord: function(record, dataTable) {
        	if (record instanceof YAHOO.widget.Record) {
        		var productCurrency_id = record.getData("Currency_id");
        		if (record.getData("IsUnique")) {
        			record.setData("PriceRecurring", "0");
        			if (productCurrency_id != oqc_current_id) {
	        			var calc_rate = parseFloat(oqc_ConversionRates[productCurrency_id])/parseFloat(oqc_currency_rate);
	        		
	        			var newPrice = parseFloat(record.getData("Price").replace(decimalSeparator, '.'))/calc_rate;
	        			record.setData("Price", newPrice.toFixed(2));
	        		//	record.setData("Currency_id", oqc_current_id);
	        	 		
	        	 	}
	        	} else {
	        		record.setData("Price", "0");
	        		if (productCurrency_id != oqc_current_id) {
	        			var calc_rate = parseFloat(oqc_ConversionRates[productCurrency_id])/parseFloat(oqc_currency_rate);
	        		
	        			var newPrice = parseFloat(record.getData("PriceRecurring").replace(decimalSeparator, '.'))/calc_rate;
	        			record.setData("PriceRecurring", newPrice.toFixed(2));
	        		//	record.setData("Currency_id", oqc_current_id);
	        	 		
	        	 	}
	        	}
	        
	        
	        	record.setData("Currency_id", oqc_current_id);
	        	dataTable.updateRow(record.getId(), record._oData);
        	} else {
        		Window.alert("Bad Paramenter for initPricesForSingleRecord");
        	}
        },
        
        
        quantityValidator: function(value, currentValue, DataInstance) {
        	
        		OqcCommon.setModifiedFlag();
            OqcProducts.showChangeAlert();
        		 if (DataInstance.getRecord().getData('Unit') == 'pieces') {
        	
            	var i = parseInt(value);

            	if (isNaN(i)) { // if value cannot be converted to an integer by parseInt it returns NaN
            	 alert('Incorrect number format');
                return "1"; // entered invalid value -> fallback to default: 1
            	} else {
                		return i.toString(); // return integer value because quantity is valid
            	  }
         	 }
         		else { return OqcProducts.numberValidator(value, currentValue);
         		}
         	
        },
        
       
        		
        // TODO invalid values should prevent user from saving/closing editor instead of falling back to default values which could be very confusing.
        // this method expects a localized currency value string like '1,23'
        // it checks for the format and returns a proper formatted string with two decimal places like "1,23"
        localizedCurrencyValidator: function(value) {
            var exprWithSeparator = new RegExp('(\\d+)' + decimalSeparator + '(\\d+)');
            var match = exprWithSeparator.exec(value);
					
            if (null == match) {
                var exprWithoutSeparator = new RegExp('^\\d+$');
											
                if (exprWithoutSeparator.exec(value)) {
                    return value.toString() + decimalSeparator + "00"; // appending ",00" to the value to make sure it has 2 decimal places
                } else {
                    return null; // entered invalid value -> return null
                }
            } else {
                // make sure the value has 2 decimal places
                var secondPart = RegExp.$2;
						
                if (1 == secondPart.length) {
                    secondPart = secondPart + "0";
                } else if (2 < secondPart.length) {
                    secondPart = secondPart.substr(0, 2);
                }
					
                return RegExp.$1 + decimalSeparator + secondPart;
            }
        },
				
        // this method expects a proper formatted value like "1,23". it gets values from the validator function.
        // and tries to display it like "$1,23". to make sure that thousand separators are added too we use yahoos currency format function Number.format.
        localizedCurrencyFormatter: function(elCell, oRecord, oColumn, oData) {
        	 if (oData) {
            var value = ("string" == typeof oData) ?
            (YAHOO.util.Number.format(parseFloat(oData.replace(decimalSeparator, '.')), currencyOptions)) :
            (oRecord.getData(oColumn.key)); // display the previous value from the record set because the value entered is invalid

            if (oRecord.getData('sum')) {
                elCell.innerHTML = '<b>' + value + '</b>'; // make currency bold if we are in a sum row
            } else {
                elCell.innerHTML = value;
            }
          }
        },

        updateSumAndSerializeTableData: function(dataTable) {
            OqcProducts.updateSum(dataTable);
            OqcProducts.serializeTableData(dataTable);
        },
							
        serializeTableData: function(dataTable) {
            // this serializes the table data and writes it into the hidden field
            document.getElementById("uniqueJsonString").value = YAHOO.lang.JSON.stringify(dataTable.getRecordSet().getRecords());
        },
				
        selectProduct: function(servicePrefix) {
            //encodedRequestData.passthru_data.addToServices = servicePrefix;
            if (servicePrefix == 'unique') {
            	var filter = servicesInitialFilter + '&is_recurring=0';
            } else {
            	var filter = servicesInitialFilter + '&is_recurring=1';
            }
            // make popup a lot bigger optimized for bigger screens
            open_popup("oqc_Product", 1250, 800, filter, true, true, encodedRequestData);
            //open_popup("oqc_Product", 1250, 800, servicesInitialFilter, true, true, encodedRequestData, "single", true);
        },
				
        getSumFor: function(dataTable, priceColumn) {
            var sum = 0;
            var sumTax = 0;
            var sumWithoutTax = 0;
            var sumColumn = (priceColumn == "Price") ? "Sum" : "SumRecurring" ;
						
 //           var tax = parseFloat(document.getElementById('tax').value)/100;
            var recordsArray = dataTable.getRecordSet().getRecords();
            var len = recordsArray.length;
						
            for (var i=0; i<len-3; i++) { // ignore the last three entries in the recordsArray because they contain the sums
            	
            
                var calc_price = parseFloat(recordsArray[i].getData(priceColumn).toString().replace(decimalSeparator, '.'));
                var calc_withoutTax = parseFloat(recordsArray[i].getData('Quantity')) * calc_price; // netto
                var tmp_vat = recordsArray[i].getData('Tax');
                var oqc_vat = parseFloat(tmp_vat.toString().replace(decimalSeparator, '.'));
					 var calc_onlyTax = calc_withoutTax * oqc_vat;
                var calc_withTax = calc_withoutTax * (1+oqc_vat); // taxes plus netto price
							          
                    sum += calc_withTax;
                    recordsArray[i].setData(sumColumn, calc_withTax.toFixed(2));
						  sumTax += calc_onlyTax;
                  
                    // we have to increase the netto price no matter if the tax flag is set or not
                    sumWithoutTax += calc_withoutTax;
					}
						
            return {
                "count": len,
                "sumTax": sumTax.toString().replace('.', decimalSeparator),
                "sumWithoutTax": sumWithoutTax.toString().replace('.', decimalSeparator),
                "sum": (sumTax+sumWithoutTax).toString().replace('.', decimalSeparator)
            };
        },
				
        updateSum: function(dataTable) {
            if (dataTable) {
                var price = OqcProducts.getSumFor(dataTable, 'Price');
                var priceRecurring = OqcProducts.getSumFor(dataTable, 'PriceRecurring');
					 var recordsArray = dataTable.getRecordSet().getRecords();
                var len = dataTable.getRecordSet().getRecords().length;
                for (var i=0; i<len-3; i++) {
                	
                dataTable.updateRow(i, recordsArray[i].getData());
             	 }
               
                dataTable.updateRow(len-3, {
                    sum: true,
                    Sum: price.sumWithoutTax,
                    SumRecurring: priceRecurring.sumWithoutTax,
                    Tax: "<b>" + languageStrings.netTotal + "</b>"
                });
                dataTable.updateRow(len-2, {
                    sum: true,
                    Sum: price.sumTax,
                    SumRecurring: priceRecurring.sumTax,
                    Tax: "<b>" + languageStrings.sum + " " + languageStrings.vat + "</b>"
                });
                dataTable.updateRow(len-1, {
                    sum: true,
                    Sum: price.sum,
                    SumRecurring: priceRecurring.sum,
                    Tax: "<b>" + languageStrings.grandTotal + "</b>"
                });
            }
        },
       		
        addSumFields: function() {
            myDataTable.addRows([
            // fields with value of magic are used to hide the usual contents for the columns. this is a workaround because spanning across multiple columns is not supported.
            {
                sum: true
            },
            {
                sum: true
            },
            {
                sum: true
            }
            ]);
        },

        updateProduct: function(productId, rowId, confirmed) {
        	var dataTable = uniqueServicesDataTable;

        	if (dataTable instanceof YAHOO.widget.DataTable && (rowId instanceof String || typeof rowId == "string")) {
        		// TODO check whether row exists
        		var name = dataTable.getRecord(rowId).getData("Name");

        		if (confirmed || confirm(languageStrings.confirmUpdate)) {
		            YAHOO.util.Connect.asyncRequest('GET', 'oqc/GetLatestProductVersion.php?id='+productId, {
		                success: OqcProducts.receivedLatestProductVersion,
		                failure: OqcProducts.handleFailureReceivingLatestProductVersion,
		                argument: [rowId]
		            });
        		}
        	}
        },

        receivedLatestProductVersion: function(o) {
            var response = JSON.parse(o.responseText);
            var rowId = o.argument[0];
            if (response.Currency_id != oqc_current_id) {
	        		response.Price = parseFloat(response.Price.replace(decimalSeparator, '.'))*parseFloat(oqc_currency_rate);
	        		response.PriceRecurring = parseFloat(response.PriceRecurring.replace(decimalSeparator, '.'))*parseFloat(oqc_currency_rate);
            }

            myDataTable.updateRow(rowId, {
                CancellationPeriod: response.CancellationPeriod,
                MonthsGuaranteed: response.MonthsGuaranteed,
                Name: response.Name,
                Price: response.IsUnique ? response.Price : "0",
                PriceRecurring: response.IsUnique ? "0" : response.PriceRecurring,
                ProductId: response.ProductId,
                Tax: response.Tax,
                Unit: response.Unit,
                // since the record is not updated but completely rewritten by updateRow() we also have to transmit a quantity.
                // we just load and transmit the old quantity value.
                Quantity: myDataTable.getRecord(rowId).getData('Quantity'),
                IsUnique: response.IsUnique,
                Currency_id : oqc_current_id
            });

            OqcProducts.updateSumAndSerializeTableData(myDataTable);

            // we updated a product row and have to propagate that the product bean (the package) has changed. otherwise the changes are not saved at all. meaning this package would still only contain the old versions of the products.
            OqcCommon.setModifiedFlag();
            OqcProducts.showChangeAlert();
 
        },

        handleFailureReceivingLatestProductVersion: function(o) {
            alert("could not receive latest product version data");
        },

        updateAllProducts: function() {
        	if (confirm(languageStrings.confirmUpdateAll)) {
	            var records = myDataTable.getRecordSet().getRecords();
	
	            // just do the ajax call updateProduct for each product
	            for (var i=0; i<records.length-3; i++) { // do not look at the last three rows because they are the sum rows.
	                var productId = records[i].getData('ProductId');
	                var rowId = records[i].getId();
	
	                OqcProducts.updateProduct(productId, rowId, true);
	            }
	
	            // hide update all button to indicate all products have been updated
	            OqcCommon.setTagVisible('updateAllButton', false);
        	}
        },

        deleteProductImage: function(imageId, imageDeletedFieldId) {
            if (OqcCommon.tagExists(imageId) && OqcCommon.tagExists(imageDeletedFieldId)) {
                OqcCommon.setModifiedFlag();
                
                var imageDeletedTag = document.getElementById(imageDeletedFieldId);
                imageDeletedTag.value = "1"; // this indicates that the image has been deleted for the controller

                OqcCommon.setTagVisible(imageId, false);
            } else {
                alert("one of the following elements could not be found: " + imageId + ", " + imageDeletedFieldId);
            }
        },
        
        deleteProduct: function(id) {
        	var dataTable = uniqueServicesDataTable;
        	
        	if (dataTable instanceof YAHOO.widget.DataTable && (id instanceof String || typeof id == "string")) {
        		// TODO check wether record exists
        		var r = dataTable.getRecord(id);
        		
        		var name = r.getData("Name");
        		
        		if (confirm(languageStrings.confirmDelete)) {
        			dataTable.deleteRow(id);	
        		}
        	}
        },
        
        showChangeAlert: function() {
        	var fields = ['price', 'monthsguaranteed', 'cancellationperiod'];
        	
        	for (var i=0; i<fields.length; i++) {
        		var id = fields[i];
        		if (OqcCommon.tagExists(id)) {
        			var tag = document.getElementById(id);
        			// overwrite previous style value.
        			tag.setAttribute('style', 'background-color:yellow;');
        		} else {
        		//	alert("field " + id + " does not exist.");
        		}
        	}
        },
        
         getCurrencyId: function() {
        		var currency_dropdown = document.getElementsByName('currency_id');
        		var selectEl = currency_dropdown[0];
        //		alert(currency_dropdown[0]);
        		if (selectEl) {
        			return selectEl.options[selectEl.selectedIndex].value;
	
        		}	else { return '-99';}
        	
        	
        },
        
        updateCurrency:function(dataTable) {
        		newCurrency_id = OqcProducts.getCurrencyId();
        		oqc_current_id = newCurrency_id;
        		currencyOptions.prefix = oqc_CurrencySymbols[newCurrency_id] + ' ';
        		oqc_currency_rate = oqc_ConversionRates[newCurrency_id];
         	OqcProducts.initPricesUpdate(dataTable);
        	
        	
        },
        
        
         //1.7.6 checks if cell has valid number entered
        numberValidator: function(newValue, currentValue) {
        		var myRegExp = new RegExp("^-{0,1}\\d*\\" + decimalSeparator +"{0,1}\\d+$", "g");
        		
            if (myRegExp.test(newValue)) {
                return newValue.replace( decimalSeparator, '.' ) ; 
            } else {
            	 alert('Incorrect number format');
                return currentValue;
            }
        }
        
        
    };
}();
