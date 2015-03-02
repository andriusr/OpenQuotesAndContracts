var OqcQS = function() {
    return {

  // creates a new entry in the sqs_objects array to enable quicksearch on a field.
		 
        addToSqsObjects: function(qsArray,formname) {
               for (var i=0; i<qsArray.length; i++) {
                    if (!sqs_objects[qsArray[i].populateList[0]])
                        {
                        if (qsArray[i].valueList) {
                            sqs_objects[qsArray[i].populateList[0]] = OqcQS.getSqsObject(qsArray[i].oqc_module, qsArray[i].fieldList, qsArray[i].populateList, qsArray[i].valueList, formname);
                        } else {
                            sqs_objects[qsArray[i].populateList[0]] = OqcQS.getSqsObject(qsArray[i].oqc_module, qsArray[i].fieldList, qsArray[i].populateList, false, formname);
                        }
                     }
                }
                enableQS(false); // some (re-) initialisation to enable quicksearch on added fields (include/javascript/quicksearch.js)
         },
        
         tagExists: function(id) {
            var tag = document.getElementById(id);
            if (tag) {
                return true;
            } else {
                return false;
            }
         },
        
        
			// get Form name - in Listview we have search form, in EditView- EditView form. They have different ids of QS fields
			getFormName: function() {
				theForms = document.getElementsByTagName("form");  
			//	alert(theForms[0].id + '_' + theForms[1].id);
				for(i=0;i<theForms.length;i++) {
					if (theForms[i].id == 'EditView') {
						return 'EditView';}
					else if (theForms[i].id == 'search_form') {
						return 'search_form';}
					else if (theForms[i].id == 'popup_query_form') {
						return 'popup_query_form';}
				}
				return '';
					
			
				
			},
			
			initQSfields: function(formname) {
			//TODO add also module check and add feilds based on result
			//alert(formname);
				if (formname == 'search_form') {
					var QSfields_basic = OqcQS.oqcQSfields();
					var QSfields_advanced = OqcQS.oqcQSfields();
					for(i=0;i<QSfields_basic.length;i++) {
						QSfields_basic[i].populateList[0] = QSfields_basic[i].populateList[0] + '_basic';
						QSfields_advanced[i].populateList[0] = QSfields_advanced[i].populateList[0] + '_advanced';
					}
					qsArray = QSfields_basic.concat(QSfields_advanced)
				}
				else if (formname == 'popup_query_form') {
					var QSfields_advanced = OqcQS.oqcQSfields();
					for(i=0;i<QSfields_advanced.length;i++) {
						QSfields_advanced[i].populateList[0] = QSfields_advanced[i].populateList[0] + '_advanced';
					}
					qsArray = QSfields_advanced;
				}
				
				else if (formname == 'EditView') {
				var qsArray = OqcQS.oqcQSfields();}
				else {return;}
				OqcQS.addToSqsObjects(qsArray, formname);
			},
			


			getSqsObject: function(module, fieldList, populateList, valueList, formname) {
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
                    "form" : formname, //1.7.7 Required for 6.1.2
                    "field_list": fieldList,
                    "populate_list": populateList,
                    "conditions": conditionsArray,
                    "no_match_text": "No Match"
                };
            }
		
            return 0;
        },



			oqcQSfields: function() {
				
			// TODO Unify field names so, there will be less fields with similar purpose
          var qsArray = [{
                oqc_module: 'Contacts',
                fieldList: ['first_name','last_name', 'id'],
                populateList: ['clientcontact', 'clientcontact_id', 'clientcontact_id']
                },

                {
                oqc_module: 'Contacts',
                fieldList: ["first_name",'last_name', 'id'],
                populateList: ['clienttechnicalcontact', 'clienttechnicalcontact_id','clienttechnicalcontact_id']
                },

                {
                oqc_module: 'Accounts',
                fieldList: ['name', 'id'],
                populateList: ['company', 'company_id']
                },

                {
                oqc_module: 'Documents',
                fieldList: ['document_name', 'id'],
                populateList: ['signedcontractdocument', 'signedcontractdocument_id']
                },

                {
                oqc_module: 'Users',
                fieldList: ['user_name',  'id'],
                populateList: ['technicalcontact', 'technicalcontact_id']
                },

                {
                oqc_module: 'Users',
                fieldList: ['user_name', 'id'],
                populateList: ['contactperson', 'contactperson_id']
                },
                
                {
                oqc_module:'Users',
                fieldList: ['user_name', 'id'],
                populateList: ['personincharge', 'personincharge_id']
            	 }, 
            
            	 { 
                oqc_module:'oqc_Category',
                fieldList: ['name', 'id'],
                populateList: ['oqc_relatedcategory_name','relatedcategory_id']
             	 },

            	 {
                oqc_module:'Users',
                fieldList: ['user_name', 'id'],
                populateList: ['assigned_employee', 'assigned_employee_id']
            	 },
            	 
            	 {
            	 oqc_module:'Accounts',
            	 fieldList: ['name', 'id'], 
            	 populateList: ['account', 'account_id']
            	 },
            	 
					 {
					 oqc_module:'Contacts', 
					 fieldList: ['first_name', 'last_name', 'id'], 
					 populateList: ['clientcontactperson', 'clientcontact_id', 'clientcontact_id']
					 },
					 
					 {
					 oqc_module:'Contacts', 
					 fieldList: ['first_name', 'last_name', 'id'], 
					 populateList: ['technicalcontactperson', 'technicalcontact_id', 'technicalcontact_id']
					 }
                ];
               // alert(qsArray.length);
                return qsArray;
           }
        
 
		};
}();



if(typeof sqs_objects == 'undefined') {
	var sqs_objects = new Array;}
YAHOO.util.Event.addListener(window, "load", function() {
	var oqcFormName = OqcQS.getFormName();
	OqcQS.initQSfields(oqcFormName);
	
	});
/*YAHOO.util.Event.onDOMReady(function(){
	var oqcFormName = OqcQS.getFormName();
	OqcQS.initQSfields(oqcFormName);
}); */




