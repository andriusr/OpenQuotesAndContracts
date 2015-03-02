var OqcServicesFormatting = function() {
    return {
        // this method expects a proper formatted value like "1,23". it gets values from the validator function.
        // and tries to display it like "$1,23". to make sure that thousand separators are added too we use yahoos currency format function Number.format.
        localizedCurrencyFormatter: function(elCell, oRecord, oColumn, oData) {
            if (oRecord.getData('isSumRow') && "string" == typeof oData && "" == YAHOO.util.Number.format(parseFloat(oData.replace(decimalSeparator, '.')), currencyOptions)) {
                // this handles the case where we want to put something like "<b>Some String</b>" into a currency field
                elCell.innerHTML = oData;
            } else {
                var value = ("string" == typeof oData) ?
                (YAHOO.util.Number.format(parseFloat(oData.replace(decimalSeparator, '.')), currencyOptions)) :
                (oRecord.getData(oColumn.key)); // display the previous value from the record set because the value entered is invalid

                if (oRecord.getData('isSumRow')) {
                    if ("string" == typeof value) {
                        elCell.innerHTML = '<b>' + value + '</b>'; // make currency bold if we are in a sum row
                    } else {
                        elCell.innerHTML = '';
                    }
                } else {
                    elCell.innerHTML = value;
                }
            }
        },
        
        discountValueCurrencyFormatter: function(elCell, oRecord, oColumn, oData) {
            if (oRecord.getData('isSumRow')) {
               elCell.innerHTML = '';
            } else {
                 if (oRecord.getData('Discount') == 'abs') {
                 elCell.innerHTML = YAHOO.util.Number.format(parseFloat(oData.replace(decimalSeparator, '.')), currencyOptions);
                    }
                else {
                    elCell.innerHTML = YAHOO.util.Number.format(parseFloat(oData.replace(decimalSeparator, '.')), numberOptions)
                }
            }
        },

        quantityValidator: function(value, currentValue, DataInstance) {
        		 if (DataInstance.getRecord().getData('Unit') == 'pieces') {
        	
            	var i = parseInt(value);

            	if (isNaN(i)) { // if value cannot be converted to an integer by parseInt it returns NaN
            	 alert('Incorrect number format');
                return "1"; // entered invalid value -> fallback to default: 1
            	} else {
                		return i.toString(); // return integer value because quantity is valid
            	  }
         	 }
         		else { return OqcServicesFormatting.numberValidator(value, currentValue);
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
        //1.7.6 checks if cell has valid number entered
        numberValidator: function(newValue, currentValue) {
        		var myRegExp = new RegExp("^-{0,1}\\d*\\" + decimalSeparator +"{0,1}\\d+$", "g");
        		
            if (myRegExp.test(newValue)) {
                return newValue.replace(decimalSeparator, '.') ; 
            } else {
            	 alert('Incorrect number format');
                return currentValue;
            }
        }
    }
}();