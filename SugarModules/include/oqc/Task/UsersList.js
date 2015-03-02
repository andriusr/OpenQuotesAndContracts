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

var OqcTask = function() {
    return {
    	
			attachmentsFormatter : function(elCell, oRecord, oColumn, oData) {
				
            	  			var container_id = 'user_documents_' + oRecord.getId(); 
            	 			var rd_only = oRecord.getData('isEdtRow') ? false : true;
            	 			elCell.innerHTML = '<ol style="padding-left:1.5em;padding-top:0.0em;margin:0px;font-size:10pt;" id="' + container_id +'"></ol>';
            	 			
        						//alert(oData.length);
        						if (document.getElementById(container_id)) {
        					  	var attachments = oData;
        					 	 	if (attachments.length) {
        					  			for (var i=0; i<attachments.length; i++) {
        					  				OqcTask.addDocumentHtml(attachments[i].id, attachments[i].document_name, attachments[i].document_revision_id, attachments[i].doc_status, container_id, rd_only)	
        					  		
        					  			}
           					   }
      						}
   		},
   		
   	      	
        initUsersTable: function(readOnly, isAdmin) {
        	//TODO make it work with AjaxUI
            YAHOO.util.Event.addListener(window, "load", function() {
            	
            var myColumnDefs;
               
 				if (readOnly) {
 					
               	  var name = {
                        key:"Name",
                        label: languageStrings.LBL_USER_NAME,
                        formatter: "text",
                        maxAutoWidth:200,
                        resizeable:true
                    };
                    var description = {
                        key:"Description",
                        label: languageStrings.LBL_COMMENT,
                        formatter: "text",
                      //	formatter: function(elCell, oRecord, oColumn, oData) { 
                            
                      //          elCell.innerHTML = oData;
                           
                      //  },
                        resizeable:true,
                        maxAutoWidth:300,
                        className:'description'
                    };
                    var accepted = {
                        key:"Accepted",
                        label: languageStrings.LBL_ACCEPTED,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                           
                            if (dropdownLabelsAccepted[oData]) {
                                elCell.innerHTML = dropdownLabelsAccepted[oData];
                             }
                             else {elCell.innerHTML = dropdownLabelsAccepted[languageStrings.LBL_ACCEPTED_DEFAULT] ;}
                        },
                        resizeable:true,
                     //   className:'align-right',
                        hidden: false
                    };
                    var oqc_position = {
                        key:"Position",
                        label: languageStrings.LBL_POSITION,
                        formatter:"number",
                        resizeable:true,
                        className:'align-right',
                        hidden: false
                    };
                    
                    var resolution = { 
                    		key:"Resolution",
                        label: languageStrings.LBL_RESOLUTION,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                           
                            if (dropdownLabelsResolution[oData]) {
                                elCell.innerHTML = dropdownLabelsResolution[oData];
                             }
                            else {elCell.innerHTML = dropdownLabelsResolution[languageStrings.LBL_RESOLUTION_DEFAULT] ;}
                            }
                       
                    };
                    var progress = {
                        key:"Progress",
                        label: languageStrings.LBL_PROGRESS,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                           
                            if (dropdownLabelsProgress[oData]) {
                                elCell.innerHTML = dropdownLabelsProgress[oData];
                             }
                             else {elCell.innerHTML = dropdownLabelsProgress[languageStrings.LBL_PROGRESS_DEFAULT] ;}
                         }
                    };
                    var attachments = {
                        key:"Attachments",
                        label: languageStrings.LBL_ATTACHMENTS,
                        formatter : OqcTask.attachmentsFormatter,
                        resizeable: true,
                       // width : 95
                        
                    };
                     var date_modified = {
                        key:"DateModified",
                        label: languageStrings.LBL_DATE_MODIFIED,
                        formatter:"text",
                        resizeable:true,
                      //  className:'align-right',
                      //  hidden: false
                    };
                    
                } else {
                	
                 var name = {
                        key:"Name",
                        label: languageStrings.LBL_USER_NAME,
                        formatter: "text",
                        maxAutoWidth:200,
                        resizeable:true
                    };
                    var description = {
                        key:"Description",
                        label: languageStrings.LBL_COMMENT,
                        formatter: function(elCell, oRecord, oColumn, oData) { 
                            
                                elCell.innerHTML = oData;
                           
                        },
                        editor: new YAHOO.widget.BigTextAreaCellEditor({width:'30em',height:'10em'}),
                        resizeable:true,
                        maxAutoWidth:300,
                        className:'description'
                    };
                    var accepted = {
                        key:"Accepted",
                        label: languageStrings.LBL_ACCEPTED,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                           
                            if (dropdownLabelsAccepted[oData]) {
                                elCell.innerHTML = dropdownLabelsAccepted[oData];
                             }
                             else {elCell.innerHTML = dropdownLabelsAccepted[languageStrings.LBL_ACCEPTED_DEFAULT] ;}
                        },
                        editor: new YAHOO.widget.DropdownCellEditor({
                            dropdownOptions: dropdownLabelsAcceptedArray,
                            disableBtns:true
                         }),
                        resizeable:true,
                       // className:'align-right',
                        hidden: false
                    };
                    
                   var oqc_position = {
                        key:"Position",
                        label: languageStrings.LBL_POSITION,
                        formatter:"number",
                        resizeable:true,
                        className:'align-right',
                        hidden: false
                    };
                    
                    var resolution = { 
                    		key:"Resolution",
                        label: languageStrings.LBL_RESOLUTION,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                           
                            if (dropdownLabelsResolution[oData]) {
                                elCell.innerHTML = dropdownLabelsResolution[oData];
                             }
                             else {elCell.innerHTML = dropdownLabelsResolution[languageStrings.LBL_RESOLUTION_DEFAULT] ;}
                            },
                        editor: new YAHOO.widget.DropdownCellEditor({
                            dropdownOptions: dropdownLabelsResolutionArray,
                            disableBtns:true
                         })
                       
                    };
                    var progress = {
                        key:"Progress",
                        label: languageStrings.LBL_PROGRESS,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                           
                            if (dropdownLabelsProgress[oData]) {
                                elCell.innerHTML = dropdownLabelsProgress[oData];
                             }
                             else {elCell.innerHTML = dropdownLabelsProgress[languageStrings.LBL_PROGRESS_DEFAULT] ;}
                         },
                        editor: new YAHOO.widget.DropdownCellEditor({
                            dropdownOptions: dropdownLabelsProgressArray,
                            disableBtns:true
                         }),
                    };
                    var attachments = {
                        key:"Attachments",
                        label: languageStrings.LBL_ATTACHMENTS,
                        formatter : OqcTask.attachmentsFormatter,
                        resizeable: true,
                       // width : 95
                        
                    };
                    
                    var date_modified = {
                        key:"DateModified",
                        label: languageStrings.LBL_DATE_MODIFIED,
                        formatter:"text",
                        resizeable:true,
                      //  className:'align-right',
                      //  hidden: false
                    };
                   
                    var delBtn = {
                        key:"Delete",
                        label: languageStrings.LBL_DELETE,
                        formatter: function(elCell, oRecord, oColumn, oData) {
                            if (isAdmin) {
                                elCell.innerHTML = "<input class='button' type='button' value='"+languageStrings.LBL_DELETE_USER+"'  onclick='OqcTask.deleteUserRow(\""+oRecord.getId()+"\");' />";
                            }
                        }
                    };
                }
					  
                myColumnDefs = (!isAdmin) ?
                 [oqc_position, name, accepted, progress, resolution, description, attachments, date_modified] :
                 [oqc_position, name, accepted, progress, resolution, description, attachments, date_modified, delBtn] ; 
                 
               // myColumnDefs = [oqc_position, name, description, finished, progress, resolution, attachments, delBtn] ;
                var myDataSource = new YAHOO.util.DataSource(oqc_USER_DATA);
                myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
                myDataSource.responseSchema = {
                    fields: ["Position", "Name", "Description", "Accepted", "Progress", "Resolution", "Attachments", "User_id", "isEdtRow", "DateModified"]
                };
                
                var myDataTable = new YAHOO.widget.DataTable(
                    "oqcUsersContainer",
                    myColumnDefs,
                    myDataSource,
                    {
                        caption: languageStrings.LBL_USRES_TABLE_NAME,
                        MSG_EMPTY : oqcYUIMessages.LBL_NO_RECORDS_MESSAGE,
                    		MSG_ERROR : oqcYUIMessages.LBL_DATA_ERROR_MESSAGE,
                    		MSG_LOADING : oqcYUIMessages.LBL_LOADING_MESSAGE
                        
                    }
                    );

              

                if (!readOnly) {
              
                    myDataTable.subscribe("cellClickEvent", function(obj) {
                    		var target = obj.target;
                    		record = myDataTable.getRecord(target).getData("isEdtRow");
                    		if (record) {
                    		this.onEventShowCellEditor(obj); }
                    	}); 
                    		 				
                    myDataTable.subscribe("editorSaveEvent",	function(oArgs) {
                        OqcTask.updateAndSerializeTableData(myDataTable);
                    });
                //    myDataTable.subscribe("rowDeleteEvent",		function(oArgs) {
                //        OqcTask.updateAndSerializeTableData(myDataTable);
                //    });
                    myDataTable.subscribe("rowAddEvent",		function(oArgs) {
                        OqcTask.updateAndSerializeTableData(myDataTable);
                    });
                    
                    myDataTable.subscribe("initEvent", function(oArgs) {
                		OqcTask.addDocuments(myDataTable);
                  	OqcTask.updateAndSerializeTableData(myDataTable);
                  	if (document.getElementById('conjugate')) {
                  	YAHOO.util.Event.addListener(document.getElementById('conjugate'), 'change', function() {
								OqcTask.updateAndSerializeTableData(myDataTable);
								});
							}
                		});

                } else {

                myDataTable.subscribe("initEvent", function(oArgs) {
                	OqcTask.addDocuments(myDataTable);
        //        	OqcTask.updateProgress(myDataTable);
                });
					 }
                     
                
                oqcUsersDataTable = myDataTable;
                
            });
        },

        updateAndSerializeTableData: function(dataTable) {
            OqcTask.updateProgress(dataTable);
            OqcTask.serializeData(dataTable);
            OqcTask.setButtonsAndClass(dataTable);
            
        },

        // store important data into hidden field
        serializeData: function(dataTable) {
            document.getElementById("oqcUsersJsonString").value = YAHOO.lang.JSON.stringify(dataTable.getRecordSet().getRecords());
        },

       
        
        handleUserPopUpClosed: function(popupReplyData) {
            var formName = popupReplyData.formName;
            var nameToValueArray = popupReplyData.name_to_value_array;
            var users = {};
		    
            for (var currentKey in nameToValueArray) {
                if (currentKey != 'toJSON') {
                    var displayValue = nameToValueArray[currentKey];
                    displayValue = displayValue.replace('&#039;', "'"); //restore escaped single quote.
                    displayValue = displayValue.replace('&amp;', "&"); //restore escaped &.
                    displayValue = displayValue.replace('&gt;', ">"); //restore escaped >.
                    displayValue = displayValue.replace('&lt;', "<"); //restore escaped <.
                    displayValue = displayValue.replace('&quot; ', "\""); //restore escaped \".
                    users[currentKey] = displayValue;
                }
            }
		    
            if (typeof users.name == "string") {
                var recordsArray = oqcUsersDataTable.getRecordSet().getRecords();
					 var tablelength = recordsArray.length;
					 var addUser = true ;
					 for (var i=0; i<tablelength; i++) { 
                 	  if (recordsArray[i].getData('User_id') == users.user_id) {
                	  	addUser = false;
                	  	break;
                	  }
                }
                	  	
						
					 if (addUser) {	
                var r = {
                	  Position: tablelength+1,
                    Name: users.name,
                    Accepted: languageStrings.LBL_ACCEPTED_DEFAULT,
                    Resolution: languageStrings.LBL_RESOLUTION_DEFAULT,
                    Progress: languageStrings.LBL_PROGRESS_DEFAULT,
                    Description: "",
                    Attachments: Array(),
                    User_id: users.user_id,
                    isEdtRow: users.user_id == current_user ? true : false,
                    DateModified: ""
                };
                oqcUsersDataTable.addRow(r, tablelength);
             //   OqcTask.updateAndSerializeTableData(oqcUsersDataTable);
             	} else {
             	alert('This user is already included: ' + users.name);	
             	}
               // OqcServices.getProductDescription(service.productId, uniqueServicesDataTable, 'unique');
                
            } else {
                alert('Extracted invalid user id: ' + users.user_id);
            }
        },
        
        getActiveContainerId: function() {
        	 var recordsArray = oqcUsersDataTable.getRecordSet().getRecords();
			 //var tablelength = oqcUsersDataTable.getRecordSet().getRecords().length;	
        	 for (var i=0; i<recordsArray.length; i++) {
        		 if (recordsArray[i].getData('isEdtRow') == "1") {
        		 	var row_id = recordsArray[i].getId();
             	var container_id = 'user_documents_' + row_id; 
        		 	return container_id;			  		
        		 }
			 }
			 return '' ;

        },
        
        setButtonsAndClass: function() {
        	var recordsArray = oqcUsersDataTable.getRecordSet().getRecords();
			 //var tablelength = oqcUsersDataTable.getRecordSet().getRecords().length;
			 var showButtons = false;	
        	 for (var i=0; i<recordsArray.length; i++) {
        		 if (recordsArray[i].getData('isEdtRow') == "1") {
        		 showButtons = true;	
        		 YAHOO.util.Dom.addClass(oqcUsersDataTable.getTrEl(i), 'colored');	
        		 } else {
        		 	 YAHOO.util.Dom.addClass(oqcUsersDataTable.getTrEl(i), 'no_pointer'); }
        		 
        	 }
        if (document.getElementById('oqc_attachment_buttons')) {
        	var button_container = document.getElementById('oqc_attachment_buttons'); 
        	if (showButtons) {
        		button_container.setAttribute('style', "display:'';");
        	} else { button_container.setAttribute('style', 'display:none;'); }
        }
        },

		//add atachment data to the cell data
		 handleDocumentPopUpClosed: function(popup_data) {
			 	
			 var attachment = {};
			 if ( popup_data.name_to_value_array.revision != '') {
				var doc_name = popup_data.name_to_value_array.document_name + '_rev.' + popup_data.name_to_value_array.revision;
			} else {
				var doc_name = popup_data.name_to_value_array.document_name;
			}
			
			 attachment.id = 	popup_data.name_to_value_array.document_id;
			 attachment.document_name = doc_name;
			 attachment.document_revision_id =  popup_data.name_to_value_array.document_revision_id;
			 attachment.doc_status = 'new';
			 var recordsArray = oqcUsersDataTable.getRecordSet().getRecords();
			 //var tablelength = oqcUsersDataTable.getRecordSet().getRecords().length;	
        	 for (var i=0; i<recordsArray.length; i++) {
        		 if (recordsArray[i].getData('isEdtRow') == "1") {
        		 	var row_id = recordsArray[i].getId();
        		 	var oData = recordsArray[i].getData('Attachments');
        		 	if (oData.length == null) {
        		 		oData = Array();
        		 	}
        		 	//alert(oData.length);
        		 	add_attachment = true;
        		 	for (var ii=0; ii< oData.length; ii++) {
        		 		if (oData[ii].document_revision_id == attachment.document_revision_id) {
        		 			add_attachment = false;
        		 			alert('Document "' + attachment.document_name + '" is already attached.')
        		 			break;
        		 		}
        		 	}
        		 	//alert('Document "' + attachment.document_name + '" is being Attached.')
        		 	if (add_attachment || oData.length == 0) {	
        		 		oData.push(attachment);
        		 		recordsArray[i].setData('Attachments', oData);
        		 		oqcUsersDataTable.updateRow(i, recordsArray[i].getData());
               	OqcTask.updateAndSerializeTableData(oqcUsersDataTable);
						OqcCommon.setModifiedFlag();
						break;	
        		 	}
        		 }	
             	
        	 }
		 },
		 
		 addDocuments : function(dataTable) {
			 var recordsArray = dataTable.getRecordSet().getRecords();
			 for (var i=0; i<recordsArray.length; i++) {
         		   
            var container_id = 'user_documents_' + recordsArray[i].getId(); 
            var rd_only = recordsArray[i].getData('isEdtRow') ? false : true;
        		//alert(oData.length);
        		var attachments = recordsArray[i].getData('Attachments');
        		if (attachments.length) {
        			for (var ii=0; ii<attachments.length; ii++) {
        				var doc = attachments[ii];	
        				OqcTask.addDocumentHtml(attachments[ii].id, attachments[ii].document_name, attachments[ii].document_revision_id, attachments[ii].doc_status, container_id, rd_only)	
       			}
        		}
      	 }			
                                    	
       },   	
		 
		 deleteDocument : function(doc_id) {
		 	
		 	var recordsArray = oqcUsersDataTable.getRecordSet().getRecords();
			 //var tablelength = oqcUsersDataTable.getRecordSet().getRecords().length;	
        	 for (var i=0; i<recordsArray.length; i++) {
        		 if (recordsArray[i].getData('isEdtRow') == "1") {
        		 	var row_id = recordsArray[i].getId();
        		 	var oData = recordsArray[i].getData('Attachments');
        		   delete_attachment = false;
        		 	for (var ii=0; ii< oData.length; ii++) {
        		 		if (oData[ii].id == doc_id) {
        		 			delete_attachment = true;
        		 			//alert('Document "' + doc_id + '" is being deleted.')
        		 			oData.splice(ii,1);
        		 	//		break;
        		 		}
        		 	}
        		 	if (delete_attachment) {	
        		 	//	oData.push(attachment);
        		 		recordsArray[i].setData('Attachments', oData);
        		 		oqcUsersDataTable.updateRow(i, recordsArray[i].getData());
        		 		OqcTask.updateAndSerializeTableData(oqcUsersDataTable);
						OqcCommon.setModifiedFlag();
						break;	
        		 	}
        		 }	
             	
        	 }
		 },
		 
		 deleteUserRow :function(row_id) {
		 	
		 	oqcUsersDataTable.deleteRow(row_id);
		 	OqcTask.updatePositions();
		 	OqcTask.updateAndSerializeTableData(oqcUsersDataTable);
		 	
		 },
		 
		 
		 updatePositions : function() {
		 	
		 	var recordsArray = oqcUsersDataTable.getRecordSet().getRecords();
			for (var i=0; i<recordsArray.length; i++) {
				recordsArray[i].setData('Position', i+1);
				oqcUsersDataTable.updateRow(i, recordsArray[i].getData());
			}
		 },
		 
		 addDocumentHtml: function(doc_id, doc_name, doc_rev_id, doc_status, container_id, readonly) {
			new_document = document.createElement('li');
			new_document.setAttribute('style', 'padding-bottom: 0.4em; margin: 0px;');
			new_document.id = 'document_' + doc_id; 
			
			link = document.createElement('a');
			link.id = 'link_'+ doc_id;
			link.href = 'index.php?entryPoint=download&id=' + doc_rev_id + '&type=Documents'; 
			new_document.appendChild(link);

			atc_name = document.createElement('span');
			atc_name.innerHTML = doc_name;
			link.appendChild(atc_name);
  
  
			if (!readonly) {
 
				remove_link = document.createElement('a');
				remove_link.setAttribute('onClick', 'OqcTask.deleteDocument("' + doc_id + '");');
				remove_link.id = 'removelink_' + doc_id;
				remove_link.setAttribute('onmouseover', 'document.getElementById(\'' + remove_link.id + '\').style.cursor=\"pointer\";');
				remove_link.innerHTML = '<img class="img" width="10" height="10" border="0" src="custom/themes/default/images/minus_inline.gif"/><span style="padding-left:0.4em">' + languageStrings.LBL_DELETE_HEADER + '</span>';
				remove_link.setAttribute('style', 'margin-left: 1em;');
				new_document.appendChild(remove_link);
  			}
  
  			document.getElementById(container_id).appendChild(new_document);
 
		  },
		 
		 updateProgress : function(dataTable) {
		 	var recordsArray = dataTable.getRecordSet().getRecords();
		 	var user_count = recordsArray.length;
		 	var progress = 0.0;
		 	var acceptance = 0.0;
		 	var sole_progress = 0.0;
		 	var sole_acceptance = 0.0;
		 	if (document.getElementById('conjugate')) {
		 		conjugate = document.getElementById('conjugate').checked; }
		 	else { conjugate = languageStrings.LBL_CONJUGATE_DEFAULT =='1' ? true : false;} //This is default setting.
		// 		if (document.getElementById('conjugate').checked == true) {
			
        	 for (var i=0; i<recordsArray.length; i++) {
      // First set Progress value dependent on Acceptance and Resolution
      		 if ((recordsArray[i].getData('Resolution') != "None") || (recordsArray[i].getData('Accepted') == "decline")) {
        	 	 	recordsArray[i].setData('Progress', "Completed");
        	 	 	dataTable.updateRow(i, recordsArray[i].getData());
        	 	 }
        		 else if (recordsArray[i].getData('Accepted') == "notAccepted") {
        	 	 	recordsArray[i].setData('Progress', "Not Started");
        	 	 	dataTable.updateRow(i, recordsArray[i].getData());
        	 	 }
        	 	 else if (recordsArray[i].getData('Accepted') == "accepted") {
        	 	 	recordsArray[i].setData('Progress', "In Progress");
        	 	 	dataTable.updateRow(i, recordsArray[i].getData());	
        	 	 }
        	 	 
        	 	
        		 if (recordsArray[i].getData('Progress') == "In Progress") {
        		 	sole_progress = 0.5;
        		 	progress += 0.5; }
        		 else if (recordsArray[i].getData('Progress') == "Completed") {
        		 	sole_progress = 1.0;
             	progress += 1.0; }
             if (recordsArray[i].getData('Resolution') == "Accepted") {
             	sole_acceptance = 1.0;
        		 	acceptance += 1.0; }
        		 else if (recordsArray[i].getData('Resolution') == "Corrected") {
        		 	sole_acceptance = 0.95;
             	acceptance += 0.95; }	  		
        	  }
        	 if (conjugate) {	
			 
		 		var P_average = progress/user_count*100;
		 		var A_average = acceptance/user_count*100;
		 	 } else {
		 	 	var P_average = sole_progress*100;
		 		var A_average = sole_acceptance*100;
		 	 }
		 	
		 	if (OqcCommon.tagExists('progress_id')) {
                document.getElementById('progress_id').value = P_average.toFixed(0).toString();
            }
        if (OqcCommon.tagExists('approval_ratio_id')) {
                document.getElementById('approval_ratio_id').value = A_average.toFixed(0).toString();
            }
		 	
		 	}
	
		 
		 
		 
		 
		 
		 
		 
		 
		}
}();