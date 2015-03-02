var OqcCommon = function() {
    return {
        typeOf: function(o) {
            var t = typeof(o);
            if (t == "object") {
                if (o.length && !o.type) { // input fields have the length attribute too. try to sort them out by their type attribute.
                    return "array";
                } else {
                    return "object";
                }
            } else {
                return t;
            }
        },
		
        getTable: function(id) {
            var table = document.createElement('table');
            table.id = id;
			
            table.className = "listView";
            table.setAttribute('cellspacing', '0');
            table.setAttribute('cellpadding', '0');
            table.style.width = '100%';
            table.style.marginBottom = '10px';
			
            return table;
        },
		
        getTableHeader: function(id, className, labelArray, alignArray, widthArray, title, requiredArray) {
            var tr = document.createElement('tr');
				
            if ('' != id) {
                tr.id = id;
            }
			
            for (var i=0; i<labelArray.length; i++) {
                var td = document.createElement('td');
                td.className = className;
                if (alignArray && alignArray[i]) {
                    td.style.textAlign = alignArray[i];
                }
                if (widthArray && widthArray[i]) {
                    td.style.width = widthArray[i];
                }
				
                if (typeof(labelArray[i]) == "string") {
                    td.appendChild(document.createTextNode(labelArray[i]));
                } else {
                    td.appendChild(labelArray[i]);
                }
		
                // add 'required' star
                if (requiredArray && requiredArray[i]) {
                    td.appendChild(OqcCommon.getRequiredTag());
                }
		
                tr.appendChild(td);
            }
			
            if (title && 'string' == typeof(title) && '' != title) {
                var th = document.createElement('th');
                th.colSpan = labelArray.length;
                th.appendChild(document.createTextNode(title));
			
                var trTitle = document.createElement('tr');
                trTitle.appendChild(th);
				
                var thead = document.createElement('thead');
                thead.appendChild(trTitle);
                thead.appendChild(tr);
                return thead;
            } else {
                return tr;
            }
        },
		
        getTableRow: function(id, className, cellContentArray, alignArray) {
            var tr = document.createElement('tr');
			
            tr.vAlign = 'top'; // TODO seems to have no effect
            tr.style.height = '20';
            // this cuts performance without any serious benefit. and does not work in this case anyway :-) see #367
            //tr.setAttribute('onmousedown', "setPointer(this, '', 'click', '#ffffff', '#f6f6f6', '');");
            //tr.setAttribute('onmouseout', "setPointer(this, '', 'out', '#ffffff', '#f6f6f6', '');");
            //tr.setAttribute('onmouseover', "setPointer(this, '', 'over', '#ffffff', '#f6f6f6', '');");
			
            if ('' != id) {
                tr.id = id;
            }
		
            for (var i=0; i<cellContentArray.length; i++) {
                var td = document.createElement('td');
                td.className = className;
                td.style.backgroundColor = '#ffffff';
                td.style.align = 'top';
                td.style.textAlign = alignArray[i];
                td.setAttribute('scope', 'row');
		
                if (cellContentArray[i] instanceof Array) {
                    for (var k=0; k<cellContentArray[i].length; k++) {
                        td.appendChild(cellContentArray[i][k]);
                    }
                } else {
                    td.appendChild(cellContentArray[i]);
                }
				
                tr.appendChild(td);
            }
			
            return tr;
        },
		
        // hides the table if it just has less than 2 children (=rows)
        // if the table has at least 2 children it made visible (again)
        toggleTableDisplaying: function(tableId) {
            var tableTag = document.getElementById(tableId);
            var hide = tableTag.childNodes.length < 2;
		
            if (hide) {
                tableTag.style.display = 'none';
            } else {
                tableTag.style.display = '';
            }
        },
		
        getTransparentGif: function(){
            var transparentGif = document.createElement('img');
            transparentGif.setAttribute('src', 'include/oqc/Services/transparent.gif');
            transparentGif.setAttribute('alt', 'transparent gif');
            transparentGif.setAttribute('width', '1px');
            transparentGif.setAttribute('height', '1px');
		    
            return transparentGif;
        },
		
        getRandomString: function() {
            var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
			
            /*
			 * ATTENTION:
			 * if you are running on php with suhosin enabled you should know the following:
			 * suhosin will drop all variables from REQUEST / POST arrays if their name exceeds
			 * the value configured in suhosin.get.max_name_length. the default is 64 which is because
			 * your form values will be dropped immediately when the generated ids are too long (e.g.
			 * maxLength = 64) because 64 < strlen(varName) + 64.
			 *
			 * we reduce the length of the id to make sure that no fields are dropped by suhosin (see #577). 
			 * var maxLength = 64;
			 * 
			 */
            var maxLength = 20;
            var randomString = '';
			
            for (var i=0; i<maxLength; i++) {
                var randomNumber = Math.floor(Math.random() * chars.length);
                randomString += chars.substring(randomNumber, randomNumber + 1);
            }
			
            return randomString;
        },
		
        getServiceInputField: function(id, name, value, type, size, textAlign){
            var inputField = document.createElement('input');
		    
            inputField.setAttribute('id', id);
            inputField.setAttribute('name', name);
            inputField.setAttribute('value', value);
            inputField.setAttribute('type', type);
            inputField.setAttribute('size', size);
            inputField.style.textAlign = textAlign;
		    
            return inputField;
        },
		
        removeTag: function(id) {
            var tag = document.getElementById(id);
            if (tag) {
                var parent = tag.parentNode;
                parent.removeChild(tag);
            }
        },
		
        removeChildrenFromNode: function(node) {
            if (node) {
                while(node.hasChildNodes()) {
                    node.removeChild(node.firstChild);
                }
            }
        },
		
        setTagVisible: function(id, visible) {
            if (!OqcCommon.tagExists(id)) {
                return;
            }
				
            var tag = document.getElementById(id);
            tag.style.display = (visible) ? ('') : ('none');
        },
		
        toggleTagVisibility: function(id) {
            if (!OqcCommon.tagExists(id)) {
                return;
            }
				
            var tag = document.getElementById(id);
            tag.style.display = ('' == tag.style.display) ? ('none') : ('');
        },
		
        tagExists: function(id) {
            var tag = document.getElementById(id);
            if (tag) {
                return true;
            } else {
                return false;
            }
        },
		
        // returns true if all tags with given ids exist otherwise false.
        tagsExists: function(idArray) {
            for (var i=0; i<idArray.length; i++) {
                if (!OqcCommon.tagExists(idArray[i])) {
                    return false;
                }
            }
            return true;
        },
		
        setFieldsReadonly: function(idArray, readonly) {
            for (var i=0; i<idArray.length; i++) {
                setReadonly(idArray[i], readonly);
            }
        },

        setAttributeConditional: function(tagId, condition, attribute, value) {
            if (OqcCommon.tagExists(tagId)) {
                tag = document.getElementById(tagId);
                if (condition) {
                    tag.setAttribute(attribute, value);
                } else {
                    tag.removeAttribute(attribute);
                }
            }
        },

        setReadonly: function(id, readonly) {
            this.setAttributeConditional(id, readonly, 'readonly', 'readonly');
			
            // simulate that the tag is disabled
            if (OqcCommon.tagExists(id)) {
                var tag = document.getElementById(id);
                tag.style.color = (readonly) ? ('gray') : ('black');
            }
        },

        setDisabled: function(id, disabled) {
            this.setAttributeConditional(id, disabled, 'disabled', true);
        },
		
        getSelectField: function(id, name, optionValues, optionTexts, selectedValue)  {
            var selectTag = document.createElement('select');
            selectTag.name = name;
            selectTag.id = id;
			
            for (var i=0; i<optionValues.length; i++) {
                var optionTag = document.createElement('option');
                optionTag.value = optionValues[i];
                optionTag.appendChild(document.createTextNode(optionTexts[i]));
				
                // mark this option as selected if it matches the selectedValue
                if (selectedValue && '' != selectedValue && selectedValue == optionTag.value) {
                    optionTag.selected = true;
                }
				
                selectTag.appendChild(optionTag);
            }
			
            return selectTag;
        },
		       
         getSqsObject: function(module, fieldList, populateList, valueList) {
            if ('' != module && fieldList && populateList) {
                var conditionsArray = new Array();
		
                for (var i=0; i<fieldList.length; i++) {
                    if ('id' != fieldList[i]) { // do not search on the id field
                        if (valueList && valueList[i]) {
                            conditionsArray[i] = {
                                "name": fieldList[i],
                                "op": "like_custom",
                                "begin": "%",
                                "end" : "%",
                                "value": valueList[i]
                                };
                        } else {
                            conditionsArray[i] = {
                                "name": fieldList[i],
                                "op": "like_custom",
                                "end": "%",
                                "value": ""
                            };
                        }
                    }
                }
			
                return {
                    "limit": "30",
                    "group": (module=='Users'|| module=='oqc_Contract') ? ('AND') : ("OR"),
                    "method": (module == 'Contacts') ? ("get_contact_array") : (module == 'Users' ? ("get_user_array") : ("query")), //1.7.7 make it work on 6.1.2
                    "modules": [module],
                    "order": fieldList[0],
                    "form" : "EditView", //1.7.7 Required for 6.1.2
                    "field_list": fieldList,
                    "populate_list": populateList,
                    "conditions": conditionsArray,
                    "no_match_text": "No Match"
                };
            }
		
            return 0;
        },
        
		
        /* creates a new entry in the sqs_objects array to enable quicksearch on a field.
		 * note: the quicksearch will be enabled on the field which id is stored as the first element in the populateList array
		 *
		 * qsArray should look like the following example 
		 * 	
		 * [
		 *  {module:'Contact', fieldList: ['name', 'id', 'first_name'], populateList: ['contact', 'contact_id']},
		 *  {module:'Accounts', fieldList: ['name', 'id'], populateList: ['company', 'company_id']},
		 *  {module:'Documents', fieldList: ['document_name', 'id'], populateList: ['signedcontractdocument', 'signedcontractdocument_id']},
		 * ]
		 * 
		 * it describes the fields that should have quicksearch enabled. the method iterates over the qsArray parameter to insert all items into the sqs_objects array. 
		 */
        addToSqsObjects: function(qsArray) {
            if (qsArray && 'array' == OqcCommon.typeOf(qsArray) && 0 < qsArray.length) {
                for (var i=0; i<qsArray.length; i++) {
                    if ('' != qsArray[i].oqc_module && qsArray[i].fieldList && qsArray[i].populateList
                        && OqcCommon.tagExists(qsArray[i].populateList[0]) && !sqs_objects[qsArray[i].populateList[0]])
                        {
                        if (qsArray[i].valueList) {
                            sqs_objects[qsArray[i].populateList[0]] = OqcCommon.getSqsObject(qsArray[i].oqc_module, qsArray[i].fieldList, qsArray[i].populateList, qsArray[i].valueList);
                        } else {
                            sqs_objects[qsArray[i].populateList[0]] = OqcCommon.getSqsObject(qsArray[i].oqc_module, qsArray[i].fieldList, qsArray[i].populateList, false);
                        }
						
                        var tag = document.getElementById(qsArray[i].populateList[0]);
                        tag.setAttribute('autocomplete', 'OFF');
                        //tag.className = 'sqsEnabled';
                    }
                }
                enableQS(true); // some (re-) initialisation to enable quicksearch on added fields (include/javascript/quicksearch.js)
            }
        },
		
        // returns the popular "red star" indicating that a field is required
        getRequiredTag: function() {
            var requiredTag = document.createElement('span');
            requiredTag.className = 'required';
            requiredTag.appendChild(document.createTextNode(' * '));
            return requiredTag;
        },
		
        // returns one of those tiny little validation scripts preventing the user from submitting a form that contains nothing but a lot of crap
        getValidationScript: function(id, label, dataType) {
            var validationScriptTag = document.createElement('script');
            validationScriptTag.setAttribute('type', 'text/javascript'); 
            validationScriptTag.text = "addToValidate('EditView', '" + id + "', '" + dataType + "', true, '" + label +"');";
 
            return validationScriptTag;
        },
		
        // returns one of those tiny little validation scripts preventing the user from submitting a form that contains nothing but a lot of crap
        // this specialised for validating date values
        getValidationBeforeScript: function(timeTag1, timeTag2, errorMessage) {
            var validationScriptTag = document.createElement('script');
            validationScriptTag.setAttribute('type', 'text/javascript'); 
            validationScriptTag.text = "addToValidateDateBefore('EditView', '" + timeTag1 + "', 'date', true, '" + errorMessage + "', '" + timeTag2 + "');";
            return validationScriptTag;
        },
		
        // iterate over options of combobox and return the number of selected items
        getNumberOfSelectedItemsInComboBox: function(id) {
            if (OqcCommon.tagExists(id)) {
                var selectedItems = 0;
                var options = document.getElementById(id).options;
		
                for (var i=0; i<options.length; i++) {
                    if (options[i].selected) {
                        selectedItems++;
                    }
                }
				
                return selectedItems;
            } else {
                alert("ComboBox '" + id + "' does not exist.");
            }
        },
		
        // Enspricht der Sugar-PHP-Funktion "from_html"
        from_html: function(html_string) {
            html_string = html_string.replace(/&quot;/gi, '"');
            html_string = html_string.replace(/&lt;/gi, '<');
            html_string = html_string.replace(/&gt;/gi, '>');
            html_string = html_string.replace(/&#039;/, "'");
		  
            return html_string;
        },
		
        getEmptyDiv: function(){
            var div = document.createElement('div');
            div.setAttribute('style', 'width:1px;height:1px; overflow: hidden;');
            div.appendChild(document.createTextNode(' '));
			
            return div;
        },
		
        getTagWithAttributes: function(tagName, attributeArray, valueArray, children) {
            var tag = document.createElement(tagName);
			
            for (var i=0; i<attributeArray.length; i++) {
                tag.setAttribute(attributeArray[i], valueArray[i]);
            }
			
            if (children) {
                if (children.length) {
                    for (var i=0; i<children.length; i++) {
                        tag.appendChild(children[i]);
                    }
                } else {
                    tag.appendChild(children);
                }
            }
			
            return tag;
        },
		
        getWaitingGif: function(id) {
            return this.getTagWithAttributes('img', ['src', 'id'], ['themes/default/images/sqsWait.gif', id]);
        },
	
        // returns the number of occurrences of a substring within a main string
        getSubstringCount: function(subString, mainString) {
            var occurrences = 0;
            for (var i=0; i<mainString.length; i++) {
                if (subString == mainString.substr(i, subString.length)) {
                    occurrences++;
                }
            }
            return occurrences;
        },
		
        // returns the number of occurrences of a substring within a main string
        repeatedIndexOf: function(times, subString, mainString) {
            var index = 0;
            for (var i=0; i<times; i++) {
                index += mainString.indexOf(subString);
                mainString = mainString.substr(subString.length, mainString.length);
            }
            return index;
        },
		
        // appends an element as child to a container specified by id
        addToContainer: function(element, containerId) {
            if (OqcCommon.tagExists(containerId)) {
                var containerTag = document.getElementById(containerId);
                containerTag.appendChild(element);
            }
        },
		
        // take a date object and a date format string like Y/m/d or d.m.Y.
        // returns a date string that is formatted like described by formatString.
        getFormattedDateStringFromDateObject: function(dateObject, formatString) {
            var formattedDateString = formatString;
			
            formattedDateString = formattedDateString.replace(/Y/, dateObject.getFullYear());
            formattedDateString = formattedDateString.replace(/m/, dateObject.getMonth()+1);
            formattedDateString = formattedDateString.replace(/d/, dateObject.getDate()); // getDate() returns number of day in month. wtf?
				
            return formattedDateString;
        },
		
        // TODO this only works if the dhtmlxtree_srnd.js file is loaded. if we have dhtmlxtree pro but did not load dhtmlxtree_srnd.js this method will return false although it should return true.
        isDhtmlxProfessional: function(tree) {
            return tree.enableSmartRendering;
        },
		
        // inserts the newTag as a sibling after the existing tag
        insertAfter: function(existingTag, newTag) {
            if (existingTag && newTag) {
                existingTag.parentNode.insertBefore(newTag, existingTag.nextSibling);
            } else {
                alert("OqcCommon.insertBefore: existingTag == null || newTag == null");
            }
        },
		
        // returns true if we have a 1600x???? resolution or more, otherwise false
        hasBigScreen: function() {
            return screen.width >= 1600;
        },
		
        setModifiedFlag: function() {
            if (OqcCommon.tagExists('isModified')) {
                document.getElementById('isModified').value = 'true';
            }
        },
		
        // returns the link to the detail view of the record described by beanName and recordId
        getBeanLink: function(beanName, name, recordId) {
            if ("string" == typeof name && "string" == typeof beanName && "" != name && "" != beanName) {
                if ("string" == typeof recordId && "" != recordId) {
		     return '<a target="_self" href="index.php?module='+beanName+'&action=DetailView&record='+recordId+'">'+name+'</a>';           
                } else {
                    return name;
                }
            } else {
                return ''; // cannot return anything good because received invalid name
            }
        },
        
        convertDropdownMenu: function(listobject) {
         var dropdownMenu=new Array() ;
        		for (var property in listobject) {
        			var item = { label: listobject[property],
        							 value : property };
        		dropdownMenu.push(item);
   //     		dropdownMenu = item ; 		
        		}
        return dropdownMenu;
        },	

        // originally for ticket #241
        // inspired by http://www.sugarcrm.com/forums/showthread.php?p=120859#post120859
        disableAutoSaveOnHittingReturnKey: function() {
            document.onkeypress = function(evt) {
                var evt = (evt) ? evt : ((event) ? event : null);
                var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                if ((evt.keyCode == 13) && (node.type == "text")) {
                    return false;
                }
            };
        },
        
    	  contact_accountChanged: function(field) {
				filter = '&account_name=' + document.getElementById('company').value; 
             open_popup('Contacts', 600, 400, filter, true, false, {'call_back_function':'set_return','form_name':'EditView','field_to_name_array':{'id':field+'_id','name':field}}, 'single', true);
         }
    };
}();

YAHOO.util.Event.addListener(window, "load", function() {
	if (document.getElementById('company')) {
		if (document.getElementById('btn_clientcontact')) {
      		document.getElementById('btn_clientcontact').onclick=function(){return OqcCommon.contact_accountChanged('clientcontact')};
       }
    	if (document.getElementById('btn_clienttechnicalcontact')) {
      		document.getElementById('btn_clienttechnicalcontact').onclick=function(){return OqcCommon.contact_accountChanged('clienttechnicalcontact')};
       }
	}
});
