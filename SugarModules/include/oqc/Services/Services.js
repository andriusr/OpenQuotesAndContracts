 // Define custom textarea editor for Datatable
YAHOO.widget.BigTextAreaCellEditor = function (oConfigs) {
	YAHOO.widget.DataTable.Editors.bigtextarea.superclass.constructor.call(this,oConfigs);
}

YAHOO.widget.DataTable.Editors.bigtextarea = YAHOO.widget.BigTextAreaCellEditor;

YAHOO.lang.extend(YAHOO.widget.BigTextAreaCellEditor,YAHOO.widget.TextareaCellEditor, {
		width: null,
		height:null,
		move : function() {
			this.textarea.style.width = this.width ||
			this.getTdEl().offsetWidth + "px";
			this.textarea.style.height = this.height || "3em";
			YAHOO.widget.TextareaCellEditor.superclass.move.call(this);
		}
});

var OqcServices = function() {
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
            	// TODO test if this is required for other languages
                if (service.unit == popupReplyData.passthru_data.unit_pieces) {
                    service.unit = 'pieces';
                } else if (service.unit == popupReplyData.passthru_data.unit_hours) {
                    service.unit = 'hours';
                }
	
					// var isUnique = ('unique' == popupReplyData.passthru_data.addToServices);
					 var uniquelength = uniqueServicesDataTable.getRecordSet().getRecords().length;
					 var recurringlength = recurringServicesDataTable.getRecordSet().getRecords().length;
					 //1.7.8 recalculate price according currency settings
					 
					 var isUnique = service.is_recurring == '0' ? true : false;
              	 if (service.currency_id != oqc_current_id) {
	        			var calc_rate = parseFloat(oqc_ConversionRates[service.currency_id])/parseFloat(oqc_currency_rate);
	        			service.price = parseFloat(service.price.replace(decimalSeparator, '.'))/calc_rate;
                } else { service.price = parseFloat(service.price.replace(decimalSeparator, '.'));}
					 service.price = service.price.toString().replace('.', decimalSeparator);
					
                var r = {
                	  Position: isUnique ? (uniquelength-2) : (recurringlength-2),
                    Quantity: "1",
                    Tax: "default", //1.7.8 we set tax value to default, it will be retrieved&updated by getProductDescription
                    Name: service.name,
                    Unit: service.unit,
                    Price: service.price,
                    ProductId: service.productId,
                    Recurrence: isUnique ? ('once') : ('monthly'), // TODO check if this is the correct behaviour
                    Description: "", // set description initially empty. it cannot be retrieved from the popup but will be set by ajax in a second with getProductDescription()
                    Discount: "rel",
                    DiscountValue: "0",
                    DiscountedPrice: service.price,
                    Currency: oqc_current_id,
                    isSumRow: false
                };
                

                if (isUnique) {
                		
                    uniqueServicesDataTable.addRow(r, uniquelength-3);
                    OqcServices.getProductDescription(service.productId, uniqueServicesDataTable, 'unique');
                } else {
                    recurringServicesDataTable.addRow(r, recurringlength-3);
                    OqcServices.getProductDescription(service.productId, recurringServicesDataTable, 'recurring');
                }
            } else {
                alert('Extracted invalid product id: ' + selectedProduct.id);
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
                 	
         initServicesTable: function(servicePrefix, id, isUniqueServices, readOnly) {
            YAHOO.util.Event.addListener(window, "load", function() {
            
                // Custom cell formatter to show SplitButton with possible actions
                var actionButtonFormatter = function(elCell, oRecord, oColumn, oData) {
                 	
            	  		if (!oRecord.getData('isSumRow')) {
            	  			var row_id = oRecord.getId();
            	 			var button_id = 'action_' + row_id; 
        						elCell.innerHTML = '<div id="' + button_id + '" title="update"></div>';
        						if (!oRecord.getData('ProductId')) {
        							var action_menu = [
      							{text: languageStrings.cst_delete, value: 'OqcServices.deleteOneRow("' +servicePrefix+ '","'+oRecord.getId()+'")'}
      							]; 	
									var button_label = languageStrings.cst_delete;
        						}
        						 
        					   else if (oRecord.getData('Updateable')) {
        						
	    						var action_menu = [
      							{text: languageStrings.update, value: 'OqcServices.updateProduct("' +servicePrefix+ '","'+oRecord.getData('ProductId')+'", "'+oRecord.getId()+'")'},
									{text: languageStrings.addOption, value: 'OqcServices.selectOption("'+ servicePrefix + '","' + oRecord.getData('ProductId')+'")'},
      							{text: languageStrings.cst_delete, value: 'OqcServices.deleteOneRow("' +servicePrefix+ '","'+oRecord.getId()+'")'}
      							]; 
      							var button_label = languageStrings.update;
								} else {
								var action_menu = [
      							{text: languageStrings.addOption, value: 'OqcServices.selectOption("'+ servicePrefix + '","' + oRecord.getData('ProductId')+'")'},
      							{text: languageStrings.cst_delete, value: 'OqcServices.deleteOneRow("' +servicePrefix+ '","'+oRecord.getId()+'")'}
      							]; 	
									var button_label = languageStrings.addOption;
								}
      						var act_button = new YAHOO.widget.Button({ type: "split", label: button_label, lazyloadmenu: false, menu: action_menu, container: button_id });
      						
      						var button_menu =	act_button.getMenu();
        						button_menu.setInitialSelection();
      						act_button.set("selectedMenuItem", button_menu.activeItem);
       						act_button.subscribe("click", OqcServices.executeButton);
      						act_button.on("selectedMenuItemChange", OqcServices.selectMenu);
      					}
                                    	
        };
             	 var myColumnDefs;
                if (readOnly) {
                    var tax = {
                        key:"Tax",
                        label: languageStrings.vat,
                        formatter: function(elCell, oRecord, oColumn, oData) { 
                           if (!oRecord.getData('isSumRow')) {
                          	switch (oData) {
                            	case true :
                             	  elCell.innerHTML = OqcServices.getTax() * 100 + ' %';
                            	  break;
                            	case false :
                            	  elCell.innerHTML = '0 %';
                                break;
                              case "default" :
                               // oData = parseFloat(dropdownLabelsVat["default"].replace(decimalSeparator, '.')) / 100  ;	
                               // oRecord.setData('Tax', oData) ; 
                                elCell.innerHTML = dropdownLabelsVat["default"]; 
                                break;     
                              default :
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
                        formatter:  function(elCell, oRecord, oColumn, oData) { // "text",
                            // if (oRecord.getData('ProductId')) {
                            elCell.innerHTML = OqcCommon.getBeanLink('oqc_Product', oRecord.getData('Name'), oRecord.getData('ProductId'));
                        },
                        maxAutoWidth:200,
                        resizeable:true,
                        className:'description'
                    };
                    var description = {
                        key:"Description",
                        label: languageStrings.description,
                        formatter: function(elCell, oRecord, oColumn, oData) { // use this instead of normal text formatter to allow html markup within the description
                            if (!oRecord.getData('isSumRow')) {
                                elCell.innerHTML = oData;
                            }
                        },
                        resizeable:true,
                        maxAutoWidth:300,
                        className:'description'
                    };
                    var quantity = {
                        key:"Quantity",
                        label: languageStrings.quantity,
                        formatter:  function(elCell, oRecord, oColumn, oData) {
                            if (!oRecord.getData('isSumRow')) {
                            	if (oRecord.getData('Unit') == 'pieces') {
                                elCell.innerHTML = oData;}
                              else { elCell.innerHTML = YAHOO.util.Number.format(parseFloat(oData.replace(decimalSeparator, '.')), numberOptions);
                              }
                            }
                        },
                        resizeable:true,
                        className:'align-right',
                        hidden: false
                    };
                    var oqc_position = {
                        key:"Position",
                        label: languageStrings.oqc_position,
                        formatter:"number",
                        resizeable:true,
                        className:'align-right',
                        hidden: false
                    };
                    
                    var unit = { 
                    		key:"Unit",
                        label: languageStrings.unit,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                            if (!oRecord.getData('isSumRow')) {
                            	if (dropdownLabelsUnit[oData]) {
                                elCell.innerHTML = dropdownLabelsUnit[oData];
                             }
                             else {elCell.innerHTML = oData ;}
                            }
                        }
                    };
                    var recurrence = {
                        key:"Recurrence",
                        label: languageStrings.zeitbezug,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                            if (!oRecord.getData('isSumRow')) {
                                elCell.innerHTML = 'monthly' == oData ? dropdownLabelsRecurrence.monthly : dropdownLabelsRecurrence.annually;
                            }
                        }
                    };
                    var price = {
                        key:"Price",
                        label: languageStrings.price,
                        formatter: OqcServicesFormatting.localizedCurrencyFormatter,
                        resizeable:true,
                        className:'align-right'
                    };
                    var sum = {
                        key:"Sum",
                        label: languageStrings.sum,
                        formatter: OqcServicesFormatting.localizedCurrencyFormatter, // "currency",
                        resizeable:true,
                        className:'align-right'
                    };
                    var discount = {
                        key:"Discount",
                        label: languageStrings.discountUnits,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                            if (!oRecord.getData('isSumRow')) {
                                elCell.innerHTML = 'abs' == oData ? dropdownLabelsDiscountType.abs : dropdownLabelsDiscountType.rel;
                            }
                         },
                         sortable:false
                    };
                    var discountValue = {
                        key:"DiscountValue",
                        label: languageStrings.discount,
                        formatter: OqcServicesFormatting.discountValueCurrencyFormatter,
                        sortable:false,
                        resizeable:true,
                        className:'align-right'
                    };
                    var discountedPrice = {
                        key:"DiscountedPrice",
                        label: languageStrings.discountPrice,
                        formatter: OqcServicesFormatting.localizedCurrencyFormatter,
                        sortable: false,
                        resizeable: true,
                        className:'align-right'
                    };
                    
                     var updatedVersionAvailable = {
                        key:"Update",
                        label: languageStrings.update+"?",
                        formatter: function(elCell, oRecord, oColumn, oData) {
                            if (!oRecord.getData('isSumRow')) {
                            	if (oRecord.getData('Updateable')) {
                                elCell.innerHTML = "<center>"+languageStrings.updateProduct+"</center>";
                            } else {
                            	  elCell.innerHTML = "<center>"+languageStrings.donotupdateProduct+"</center>";
                            }
                           }
                        },
                        resizeable: true
                    };
                  
				
                    // readonly view has no editors and no delete button
                    myColumnDefs = (isUniqueServices) ?
                    [oqc_position, name, description, price, discountValue, discount, discountedPrice, quantity, unit, tax, sum, updatedVersionAvailable] :
                    [oqc_position, name, description, recurrence, price, discountValue, discount, discountedPrice, quantity, unit, tax, sum, updatedVersionAvailable];
                } else {
                    var tax = {
                        key:"Tax",
                        label: languageStrings.vat,
                        formatter: function(elCell, oRecord, oColumn, oData) { 
                          if (!oRecord.getData('isSumRow')) {
                          	switch (oData) {
                            	case true :
                             	  elCell.innerHTML = OqcServices.getTax() * 100 + '%';
                            	  break;
                            	case false :
                            	  elCell.innerHTML = '0 %';
                                break;
                              case "default" :
                               // oData = parseFloat(dropdownLabelsVat["default"].replace(decimalSeparator, '.')) / 100  ;	
                               // oRecord.setData('Tax', oData) ; 
                                elCell.innerHTML = dropdownLabelsVat["default"]; 
                                break;     
                              default :
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
                        editor: new YAHOO.widget.DropdownCellEditor({
                            dropdownOptions: OqcCommon.convertDropdownMenu(dropdownLabelsVat),
                            disableBtns:true
                        }),
                        className:'align-right'
                    };
                    var name = {
                        key:"Name",
                        label: languageStrings.name,
                        editor: new YAHOO.widget.TextboxCellEditor(),
                        formatter:  function(elCell, oRecord, oColumn, oData) {

                            // use this custom formatter instead of default text formatter to allow html input. this is used to make sum rows bold.

                            if (!oRecord.getData('isSumRow')) {
                                elCell.innerHTML = oData;
			   					 }
                        },
                        editor: new YAHOO.widget.BigTextAreaCellEditor({width:'30em',height:'10em'}),
                        maxAutoWidth:200,
                        resizeable:true,
                        className:'description'
                    };
                    var description = {
                        key:"Description",
                        label: languageStrings.description,
                        formatter: function(elCell, oRecord, oColumn, oData) { // use this instead of normal text formatter to allow html markup within the description
                            if (!oRecord.getData('isSumRow')) {
                                elCell.innerHTML = oData;
                            }
                        },
                        editor: new YAHOO.widget.BigTextAreaCellEditor({width:'30em',height:'10em'}),
                        resizeable:true,
                        maxAutoWidth:300,
                        className:'description'
                    };
                    var quantity = {
                        key:"Quantity",
                        label: languageStrings.quantity,
                        formatter:  function(elCell, oRecord, oColumn, oData) {
                            if (!oRecord.getData('isSumRow')) {
                            	if (oRecord.getData('Unit') == 'pieces') {
                                elCell.innerHTML = oData;}
                              else { elCell.innerHTML = YAHOO.util.Number.format(parseFloat(oData.replace(decimalSeparator, '.')), numberOptions);
                              }
                            }
                        },
                        editor: new YAHOO.widget.TextboxCellEditor({
                            validator: OqcServicesFormatting.quantityValidator
                            }),
                        resizeable:true,
                        className:'align-right',
                        hidden: false
                    };
                    var oqc_position = {
                        key:"Position",
                        label: languageStrings.oqc_position,
                        formatter:  function(elCell, oRecord, oColumn, oData) {
                       //     if (!oRecord.getData('isSumRow')) {
                                elCell.innerHTML = oData;
                       //     }
                        },
                        editor: new YAHOO.widget.TextboxCellEditor({
                            validator: OqcServicesFormatting.quantityValidator
                            }),
                        resizeable:true,
                        className:'align-right',
                        hidden: false
                       };
                    
                    var unit = {
                        key:"Unit",
                        label: languageStrings.unit,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                            if (!oRecord.getData('isSumRow')) {
                            	if (dropdownLabelsUnit[oData]) {
    											 elCell.innerHTML = dropdownLabelsUnit[oData];
  										}
  										else {elCell.innerHTML = oData;}
                            }
                        },
                        editor: new YAHOO.widget.DropdownCellEditor({
                            dropdownOptions: dropdownLabelsUnitArray,
                            disableBtns:true
                        })
                    };
                    var recurrence = {
                        key:"Recurrence",
                        label: languageStrings.zeitbezug,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                            if (!oRecord.getData('isSumRow')) {
                                elCell.innerHTML = 'monthly' == oData ? dropdownLabelsRecurrence.monthly : dropdownLabelsRecurrence.annually;
                            }
                        },
                        editor: new YAHOO.widget.DropdownCellEditor({
                            dropdownOptions:[
                            {
                                value:'monthly',
                                label: dropdownLabelsRecurrence.monthly
                                },

                                {
                                value:'annually',
                                label: dropdownLabelsRecurrence.annually
                                }
                            ],
                            disableBtns:true
                        })
                    };
                    var price = {
                        key:"Price",
                        label: languageStrings.price,
                        formatter: OqcServicesFormatting.localizedCurrencyFormatter,
                        editor: new YAHOO.widget.TextboxCellEditor({
                            validator: OqcServicesFormatting.numberValidator
                            }),
                        resizeable:true,
                        className:'align-right'
                    };
                    var sum = {
                        key:"Sum",
                        label: languageStrings.sum,
                        formatter: OqcServicesFormatting.localizedCurrencyFormatter, // "currency",
                        resizeable:true,
                        className:'align-right'
                    };
 
                    var discount = {
                        key:"Discount",
                        label: languageStrings.discountUnits,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                            if (!oRecord.getData('isSumRow')) {
                                elCell.innerHTML = 'abs' == oData ? dropdownLabelsDiscountType.abs : dropdownLabelsDiscountType.rel;
                            }
                        },
                        editor: new YAHOO.widget.DropdownCellEditor({
                            dropdownOptions:[
                            {
                                value:'abs',
                                label: dropdownLabelsDiscountType.abs
                                },

                                {
                                value:'rel',
                                label: dropdownLabelsDiscountType.rel
                                }
                            ],
                            disableBtns:true
                        })
                    };
                    var discountValue = {
                        key:"DiscountValue",
                        label: languageStrings.discount,
                        formatter: OqcServicesFormatting.discountValueCurrencyFormatter,
                        editor: new YAHOO.widget.TextboxCellEditor({
                            validator: OqcServicesFormatting.numberValidator
                            }),
                        resizeable:true,
                        className:'align-right'
                    };
                    var discountedPrice = {
                        key:"DiscountedPrice",
                        label: languageStrings.discountPrice,
                        formatter: OqcServicesFormatting.localizedCurrencyFormatter,
                        resizeable: true,
                        className:'align-right'
                    };
                     var updateBtn = {
                        key:"Update",
                        label: languageStrings.action,
                        formatter : actionButtonFormatter,
                        resizeable: false,
                        width : 95
                        
                    };
                 					
                    myColumnDefs = (isUniqueServices) ?
                    [oqc_position, name, description, price, discountValue, discount, discountedPrice, quantity, unit, tax, sum, updateBtn] :
                    [oqc_position, name, description, recurrence, price, discountValue, discount, discountedPrice, quantity, unit, tax, sum, updateBtn];
                }
			
                var myDataSource = new YAHOO.util.DataSource("oqc/GetServicesJSON.php?m="+moduleName+"&id="+id+"&u=" + ((isUniqueServices) ? ("1") : ("0"))); 
               
                //For Datasource only
                myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
                myDataSource.connXhrMode = "queueRequests";
		        
                myDataSource.responseSchema = {
                    resultsList: "ResultSet", // for JSON
                    fields: ["Position","Tax","Name", "Description","Quantity", "Unit", "Recurrence", "Price", "isSumRow", "ProductId", "Id", "Discount", "DiscountValue", "Updateable", "Currency"]
                };

                // local variable
                var myDataTable = new YAHOO.widget.DataTable(
                    servicePrefix+"Container",
                    myColumnDefs,
                    myDataSource,
                    {
                        caption: ((isUniqueServices) ? (languageStrings.onceTableTitle) : (languageStrings.ongoingTableTitle)),
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
			    
                if (!readOnly) {
                   
                   myDataTable.subscribe("cellClickEvent", function(obj) {
                    		var target = obj.target;
                    		record = myDataTable.getRecord(target).getData("isSumRow");
                    		if (!record) {
                    		this.onEventShowCellEditor(obj); }
                    	}); 
				
                    myDataTable.subscribe("editorSaveEvent",	function(oArgs) {
                    		OqcServices.sortRows(myDataTable);
                        OqcServices.updateSumAndSerializeTableData(myDataTable, servicePrefix);
                        
                    });
            
                    myDataTable.subscribe("rowAddEvent",		function(oArgs) {
                    	//	OqcServices.sortRows(myDataTable);
                        OqcServices.updateSumAndSerializeTableData(myDataTable, servicePrefix);
                    });

                }
					
                myDataTable.subscribe("initEvent", function(oArgs) {
                    
                    OqcServices.addSumFields(myDataTable);
                    OqcServices.updatePositions(myDataTable, false);  
                   // OqcServices.onLoadSetupCurrency(myDataTable);
                    OqcServices.updateSumAndSerializeTableData(myDataTable, servicePrefix);
                                    
                });
                myDataTable.subscribe("postRenderEvent",		function(oArgs) {
                       OqcServices.setClass(myDataTable);
                    });
			    	
                // overwrite global variable with datatable stored in local variable
                if (isUniqueServices) {
                    uniqueServicesDataTable = myDataTable;
                 
                } else {
                    recurringServicesDataTable = myDataTable;
                  
                }
                
            });
        },
		
        getTax: function() {
            return parseFloat(document.getElementById('tax').value)/100;
        },

        getSumFor: function(dataTable) {
            if (dataTable) {
                var sum = 0;
                var sumTax = 0;
                var sumWithoutTax = 0;
                var tax = OqcServices.getTax();
                var recordsArray = dataTable.getRecordSet().getRecords();
				
                for (var i=0; i<recordsArray.length-3; i++) { // skip the last three rows because these are the rows containing the sums.
                // 1.7.8 check if quantity is integer at first if units are pieces.
                	  if (recordsArray[i].getData('Unit') == 'pieces') {
                	  var calc_quantity			= parseInt(recordsArray[i].getData('Quantity'));
                	  recordsArray[i].setData('Quantity', calc_quantity.toString());
                	  } 
                	  else {
                    var calc_quantity			= parseFloat(recordsArray[i].getData('Quantity'));
                 	  }
                 	  //Update currency 
                 	  var serviceCurrency_id = recordsArray[i].getData('Currency');
                 	  if (serviceCurrency_id != oqc_current_id) {
	        					var calc_rate = parseFloat(oqc_ConversionRates[serviceCurrency_id])/parseFloat(oqc_currency_rate);
	        				} else { var calc_rate = 1.0;}
	        			  var calc_price = parseFloat(recordsArray[i].getData('Price').replace(decimalSeparator, '.'))/calc_rate;
                    if ('rel' == recordsArray[i].getData('Discount')) {
                    			var calc_discountValue = parseFloat(recordsArray[i].getData('DiscountValue').replace(decimalSeparator, '.'));}
                    	else { var calc_discountValue = parseFloat(recordsArray[i].getData('DiscountValue').replace(decimalSeparator, '.'))/calc_rate;}
                    var calc_discountedPrice	= ('rel' == recordsArray[i].getData('Discount')) ?
                    			((1-calc_discountValue/100)*calc_price) :
                    			(calc_price-calc_discountValue);
                    recordsArray[i].setData('Price', calc_price.toFixed(2));
                    recordsArray[i].setData('Currency', oqc_current_id);
                    if (recordsArray[i].getData('Discount') != "rel") {
                       		recordsArray[i].setData('DiscountValue', calc_discountValue.toFixed(2));	
                    }	
                    
                    
                    //1.7.8 make vat calculation compatible with the legacy on/off method
                    var tmp_vat = recordsArray[i].getData('Tax');
                   // alert (tmp_vat);
                    if (tmp_vat === true || tmp_vat === false) {
                     var	oqc_vat = tmp_vat ? tax : 0.0 ;
                    }
                    else if (tmp_vat == "default") {
                    	var oqc_vat = parseFloat(dropdownLabelsVat["default"].replace(decimalSeparator, '.')) / 100
                    	 recordsArray[i].setData('Tax', oqc_vat.toString());
                    }
                    else {
                    	  var oqc_vat = parseFloat(tmp_vat.toString().replace(decimalSeparator, '.'));
						  }
						 // alert (calc_vat);
                    recordsArray[i].setData('DiscountedPrice', calc_discountedPrice.toFixed(2));
						  // calculate sums using the discount price instead of the (list) price
                    var withoutTax = calc_quantity * calc_discountedPrice; // netto
                    var onlyTax = withoutTax * oqc_vat; // just the taxes
                    var withTax = withoutTax * (1+oqc_vat); // taxes plus netto price
							          
                    sum += withTax;
                    recordsArray[i].setData('Sum', withTax.toFixed(2));
                    //recordsArray[i].setData('Tax', oqc_vat.toString().replace('.', decimalSeparator));
						  sumTax += onlyTax;
                  
                    // we have to increase the netto price no matter if the tax flag is set or not
                    sumWithoutTax += withoutTax;
					
                    dataTable.updateRow(i, recordsArray[i].getData());
                }

                return {
                    "sumTax": sumTax.toString().replace('.', decimalSeparator),
                    "sumWithoutTax": sumWithoutTax.toString().replace('.', decimalSeparator),
                    "sum": sum.toString().replace('.', decimalSeparator)
                }
            } else {
                return null;
            }
        },

        updateSum: function(dataTable) {
            if (dataTable) {
                var sum = OqcServices.getSumFor(dataTable);
                
                if ("object" == typeof sum) {
                    var len = dataTable.getRecordSet().getRecords().length;
                    //var labels = SUGAR.language.get('app_list_strings', 'oqc').Services;

                    // TODO at this point we assume that the sum rows already exist. if not we will not updateRows but instead add them endlessly because of the subscription of the rowUpdateEvent.
                    // TODO to make sure that everything is fine the events should be subscribed after initialisation has finished.
                    dataTable.updateRow(len-3, {
                    		Position: "",
                        isSumRow: true,
                        Sum: sum.sumWithoutTax, 
                        Tax: "<b>" + languageStrings.netTotal + "</b>"
                    });
                    dataTable.updateRow(len-2, {
                    		Position: "",
                        isSumRow: true,
                        Sum: sum.sumTax,
                        Tax: "<b>" + languageStrings.sum + " " + languageStrings.vat + "</b>"
                    });
                    dataTable.updateRow(len-1, {
                    		Position: "",
                        isSumRow: true,
                        Sum: sum.sum,
                        Tax: "<b>" + languageStrings.grandTotal + "</b>"
                    });
                } else {
                    alert("getSumFor did not return an object");
                }
            }
        },
		
        updateSumAndSerializeTableData: function(dataTable, servicePrefix) {
        	//	OqcServices.sortRows(dataTable);
            OqcServices.updateSum(dataTable);
			   document.getElementById(servicePrefix + "JsonString").value = YAHOO.lang.JSON.stringify(dataTable.getRecordSet().getRecords());
            OqcServices.updateGrandTotal();
        },
		
        selectProduct: function(servicePrefix) {
           // encodedRequestData.passthru_data.addToServices = servicePrefix;
            
            if (servicePrefix == 'unique') {
            	var filter = servicesInitialFilter + '&is_recurring=0';
            } else {
            	var filter = servicesInitialFilter + '&is_recurring=1';
            }
            open_popup("oqc_Product", 1250, 800, filter, true, true, encodedRequestData);  //1.7.5 the same screen size as in Products.js
        },
        
        selectOption: function(servicePrefix,product_id) {
          //  encodedRequestData.passthru_data.addToServices = servicePrefix;
            open_popup("oqc_Product", 1250, 800, '&product_id=' + product_id + '&is_option=1', true, true, encodedRequestData);  //1.7.5 the same screen size as in Products.js
        },
        
         //1.7.8 function for including default (common) products like installation or shipment
        addDefaultLines: function(servicePrefix) {
      //  encodedRequestData.passthru_data.addToServices = servicePrefix;
        open_popup("oqc_Product", 1250, 800, "&status=default&is_option=0", true, true, encodedRequestData);	
        },
        
        // sets cursor to default for sum rows
        setClass: function(datatable) {
        		 var recordsArray = datatable.getRecordSet().getRecords();
			  	 for (var i=0; i<recordsArray.length; i++) {
        		 if (recordsArray[i].getData('isSumRow') == 1) {
        		  	 YAHOO.util.Dom.addClass(datatable.getTrEl(i), 'no_pointer'); }
        		 
        	 }
        },
        
         
        // rearange rows based on position value 
        sortRows: function(dataTable) {
        	 var recordsArray = dataTable.getRecordSet().getRecords();
        
        	 if (recordsArray.length == "4") {
        	 	return;}
        	var dataArray = Array();
        	var row_id = Array();
        	for (var i=0; i<recordsArray.length-3; i++) {
        		dataArray[i] = recordsArray[i].getData();
        		row_id[i] = recordsArray[i].getId();
        	} 
      	dataArray.sort(OqcServices.compareRows);
     		for (var ii=0; ii<dataArray.length; ii++) {
					
						dataArray[ii].Position = ii+1; 
						dataTable.updateRow(row_id[ii], dataArray[ii]);
        		  	 
					}
			
   
        },
        
        compareRows: function(a,b) {
        var a_pos = a.Position;
        var b_pos = b.Position;	
       //deal with non-numeric values- all these are not sorted
        if(isNaN(parseFloat(a_pos)) || !isFinite(a_pos)) { 
        		return 0; 
	       } 
	       else if(isNaN(parseFloat(b_pos)) || !isFinite(b_pos)) { 
               return 0; 
	        } 	
        if (parseFloat(a_pos)-parseFloat(b_pos) >= 0.0) {
        	return 1;}
        	else { return -1;} 	
        	
        },
        
        deleteOneRow: function(servicePrefix, row_id) {
        		
        		var isUnique = ('unique' == servicePrefix);
        		 if (isUnique) {
                	 uniqueServicesDataTable.deleteRow(row_id);
                    OqcServices.updatePositions(uniqueServicesDataTable, true);
                     OqcServices.updateSumAndSerializeTableData(uniqueServicesDataTable, servicePrefix);
                    
                   
                } else {
                    recurringServicesDataTable.deleteRow(row_id);
                    OqcServices.updatePositions(recurringServicesDataTable, true);
                    OqcServices.updateSumAndSerializeTableData(recurringServicesDataTable, servicePrefix);
                    
                }
        		
        },
        
        
        addCustomServiceRow: function(servicePrefix) {
        	
        		var uniquelength = uniqueServicesDataTable.getRecordSet().getRecords().length;
				var recurringlength = recurringServicesDataTable.getRecordSet().getRecords().length;
        		var isUnique = ('unique' == servicePrefix);
        		var cstm = {
        				  Position: isUnique ? (uniquelength-2) : (recurringlength-2),	
                    Quantity: "1",
                    Tax: "default",
                    Name: "",
                    Unit: "pieces",
                    Price: "1",
                    ProductId: "",
                    Recurrence: isUnique ? ('once') : ('monthly'), // TODO check if this is the correct behaviour
                    Description: "", 
                    Discount: "rel",
                    DiscountValue: "0",
                    DiscountedPrice: "",
                    Currency: OqcServices.getCurrencyId(),
                    isSumRow: false
                };
        			   if (isUnique) {
                		
                    uniqueServicesDataTable.addRow(cstm, uniquelength-3);
                   
                } else {
                    recurringServicesDataTable.addRow(cstm, recurringlength-3);
                    
                }
             	 
        },
		
        getProductDescription: function(productId, dataTable, servicePrefix) {
            var records = dataTable.getRecordSet().getRecords();
            var rowId = records[records.length-4].getId(); // the id of the last added row- 1.7.6 there is also 3 sum rows.
		
            YAHOO.util.Connect.asyncRequest('GET', 'oqc/GetProductDescription.php?id='+productId, {
                success: OqcServices.receiveProductDescription,
                failure: OqcServices.handleFailureReceivingProductDescription,
                argument: [rowId, dataTable, servicePrefix]
            });
        },

        receiveProductDescription: function(o) {
        		var response = JSON.parse(o.responseText);
            var description = response.Description;
            var oqc_vat = response["Vat"];
          
            var rowId = o.argument[0];
            var dataTable = o.argument[1];
            var servicePrefix = o.argument[2];
            var r = dataTable.getRecord(rowId);
            r.setData('Description', description);
            r.setData('Tax', oqc_vat);
            OqcServices.updateSumAndSerializeTableData(dataTable, servicePrefix);

            // we updated a product row and have to propagate that the product bean (the package) has changed. otherwise the changes are not saved at all. meaning this package would still only contain the old versions of the products.
            OqcCommon.setModifiedFlag();
            // If attachments are received, add them to the list
            var attachments = response.Attachments;
            if (document.getElementById('documents') && (attachments.length != 0)) {
            	 for (var i=0; i<attachments.length; i++) {
            	 	addTechDesc(attachments[i].id, attachments[i].document_name, attachments[i].document_revision_id, false , true);
            	 }
            }
        },

        handleFailureReceivingProductDescription: function(o) {
            alert("could not receive product description");
        },
        //1.7.7 Added possibility to update product version if something has changed
        
        updateProduct: function(prefix, productId, rowId, confirmed) {
        	if (prefix == 'unique') {
        	var dataTable = uniqueServicesDataTable;
         } else { var dataTable = recurringServicesDataTable;}

        	if (dataTable instanceof YAHOO.widget.DataTable && (rowId instanceof String || typeof rowId == "string")) {
        		// TODO check whether row exists
        		// var name = dataTable.getRecord(rowId).getData("Name");

        		if (confirmed || confirm(languageStrings.confirmUpdate)) {
		            YAHOO.util.Connect.asyncRequest('GET', 'oqc/GetLatestProductVersion.php?id='+productId, {
		                success: OqcServices.receivedLatestProductVersion,
		                failure: OqcServices.handleFailureReceivingLatestProductVersion,
		                argument: [rowId,prefix,dataTable]
		            });
        		}
        	}
        },
        
        receivedLatestProductVersion: function(o) {
            var response = JSON.parse(o.responseText);
            var rowId = o.argument[0];
            var prefix = o.argument[1];
            var dataTable = o.argument[2];
            //if (prefix == 'unique') {
        		//	var dataTable = uniqueServicesDataTable;
        		//} else { var dataTable = recurringServicesDataTable;}
        		 if (response.Currency_id != oqc_current_id) {
	        		response.Price = parseFloat(response.Price.replace(decimalSeparator, '.'))*parseFloat(oqc_currency_rate);
	        		response.PriceRecurring = parseFloat(response.PriceRecurring.replace(decimalSeparator, '.'))*parseFloat(oqc_currency_rate);
	        		response.Price = response.Price.toString().replace('.', decimalSeparator);
	        		response.PriceRecurring = response.PriceRecurring.toString().replace('.', decimalSeparator);
            }
            

            dataTable.updateRow(rowId, {
                Name: response.Name,
                Price: response.IsUnique ? response.Price : response.PriceRecurring,
             //   PriceRecurring: response.PriceRecurring,
                ProductId: response.ProductId,
                Tax: response.Tax,
                Unit: response.Unit,
                // since the record is not updated but completely rewritten by updateRow() we also have to transmit a quantity.
                // we just load and transmit the old quantity value.
                Quantity: dataTable.getRecord(rowId).getData('Quantity'),
                Position: dataTable.getRecord(rowId).getData('Position'),
                Recurrence: dataTable.getRecord(rowId).getData('Recurrence'),
                Description: response.Description, 
                Discount: dataTable.getRecord(rowId).getData('Discount'),
                DiscountValue: dataTable.getRecord(rowId).getData('DiscountValue'),
                DiscountedPrice: dataTable.getRecord(rowId).getData('Discountedprice'),
                Currency: dataTable.getRecord(rowId).getData('Currency'),
                isSumRow: false              
            });
				
            OqcServices.updateSumAndSerializeTableData(dataTable,prefix);

            // we updated a product row and have to propagate that the product bean (the package) has changed. otherwise the changes are not saved at all. meaning this package would still only contain the old versions of the products.
            OqcCommon.setModifiedFlag();
           
            // hide update button to indicate that product row is updated now
            OqcCommon.setTagVisible("updateButton_"+rowId, false);
             // If attachments are received, add them to the list
            var attachments = response.Attachments;
            if (document.getElementById('documents') && (attachments.length != 0)) {
            	 for (var i=0; i<attachments.length; i++) {
            	 	addTechDesc(attachments[i].id, attachments[i].document_name, attachments[i].document_revision_id, false , true);
            	 }
            }
            
        },

        handleFailureReceivingLatestProductVersion: function(o) {
            alert("could not receive latest product version data");
        },
        
        updatePositions: function(dataTable, force) {
        	 var len = dataTable.getRecordSet().getRecords().length;
        	 var recordsArray = dataTable.getRecordSet().getRecords();
        	 for (var i=0; i<len-3; i++) {
        	 	if (!recordsArray[i].getData('Position') || (recordsArray[i].getData('Position') == '0' || force == true)) {
        	 	//	alert('updating row'+recordsArray[i].getData('Name'));
        	 		dataTable.updateCell(recordsArray[i], 'Position', parseInt(i+1));
        	 	}
        	 	
        	 }	
        },
        
       updateGrandTotal: function() {
        var grandNetTotal = 0.0;
        var grandVatTotal = 0.0;
        var grandGrandTotal = 0.0;
        var uniqueData= JSON.parse(document.getElementById("uniqueJsonString").value);
        var recurringData= JSON.parse(document.getElementById("recurringJsonString").value);
        for (key in uniqueData) {
        	if (uniqueData[key]['_oData']) {
        	var dataset = uniqueData[key]['_oData'];
        	 if (dataset['isSumRow']) {
        	  switch (dataset['Tax']) {
        	 	case ("<b>" + languageStrings.netTotal + "</b>") :
        	 	grandNetTotal += parseFloat(dataset['Sum'].replace(decimalSeparator, '.'));
        	 	break;
        	 	
        	 	case ("<b>" + languageStrings.sum + " " + languageStrings.vat + "</b>") :
        	 	grandVatTotal += parseFloat(dataset['Sum'].replace(decimalSeparator, '.'));
        	 	break;
        	 	
        	 	case ("<b>" + languageStrings.grandTotal + "</b>") :
        	 	grandGrandTotal += parseFloat(dataset['Sum'].replace(decimalSeparator, '.'));
        	 	break;
        	 	default:
        	 	grandGrandTotal += 0.1;
        	 	break;       	 	
        	  }
          }
         }
        }
        for (key in recurringData) {
        	if (recurringData[key]['_oData']) {
        	var dataset = recurringData[key]['_oData'];
        	 if (dataset['isSumRow']) {
        	  switch (dataset['Tax']) {
        	 	case ("<b>" + languageStrings.netTotal + "</b>") :
        	 	grandNetTotal += parseFloat(dataset['Sum'].replace(decimalSeparator, '.'));
        	 	break;
        	 	
        	 	case ("<b>" + languageStrings.sum + " " + languageStrings.vat + "</b>") :
        	 	grandVatTotal += parseFloat(dataset['Sum'].replace(decimalSeparator, '.'));
        	 	break;
        	 	
        	 	case ("<b>" + languageStrings.grandTotal + "</b>") :
        	 	grandGrandTotal += parseFloat(dataset['Sum'].replace(decimalSeparator, '.'));
        	 	break;
        	 	default:
        	 	grandGrandTotal += 0.1;
        	 	break;       	 	
        	  }
          }
       }
        }
        
        if (OqcCommon.tagExists('total_cost_id')) {
                document.getElementById('total_cost_id').value = grandNetTotal.toFixed(2).toString().replace('.', decimalSeparator);
            }
        if (OqcCommon.tagExists('grand_total_vat_id')) {
                document.getElementById('grand_total_vat_id').value = grandVatTotal.toFixed(2).toString().replace('.', decimalSeparator);
            }
        if (OqcCommon.tagExists('grand_total_id')) {
                document.getElementById('grand_total_id').value = (grandVatTotal+grandNetTotal).toFixed(2).toString().replace('.', decimalSeparator);
            }
        
        
        
        },
        
        updateCurrency:function() {
        		newCurrency_id = OqcServices.getCurrencyId();
        		oqc_current_id = newCurrency_id;
        		currencyOptions.prefix = oqc_CurrencySymbols[newCurrency_id] + ' ';
        		oqc_currency_rate = oqc_ConversionRates[newCurrency_id];
         },
        
        getCurrencyId: function() {
        		var currency_dropdown = document.getElementsByName('currency_id');
        		var selectEl = currency_dropdown[0];
        //		alert(currency_dropdown[0]);
        		if (selectEl) {
        			return selectEl.options[selectEl.selectedIndex].value;
	
        		}	else { return '-99';}
        	
        	
        },
        
        
        addSumFields: function(dataTable) {
            dataTable.addRows([
            {
                isSumRow: true,
               
            },
            {
                isSumRow: true,
                
            },
            {
                isSumRow: true,
               
            }
            ]);
        }
    };
}();
