 var OqcCatalog = function() {
		return {
			
			isMac: function() {
				return /Mac/.test(navigator.platform); },

			initTree: function(container, treeData, readOnly) {
		//		alert('starting dynatree first line');
				// Create some dummy data for first-time editing
				if (treeData == '' && readOnly) {
					treeData = [{title: languageStrings.LBL_NO_DATA}];
	
				} else if ( treeData == '' && !readOnly) {
					
					treeData = [{title: languageStrings.LBL_NEW_NODE_TITLE,
									 isFolder: true,
									  key: OqcCommon.getRandomString(),
									  isProduct: false,
									  isOption: false,
									  icon: 'Category_notempty.gif',
          							children: [
           					 		{title: languageStrings.LBL_DRAG_HINT,
           					 		 key: OqcCommon.getRandomString(),
           					 		 isProduct: false,
									  	 isOption: false,
									  	 icon: 'Category_empty.gif'
           					 		 }]
								  }];
					OqcCatalog.addHiddenFieldForCategoryDescription(treeData[0].key, languageStrings.LBL_NEW_DESCRIPTION_TEXT);
					OqcCatalog.addHiddenFieldForCategoryDescription(treeData[0].children[0].key, languageStrings.LBL_NEW_DESCRIPTION_TEXT);
				}
				if (readOnly) {
					$(container).dynatree({
				
						children: treeData,
						clickFolderMode : 1,
						onActivate: function(node) {
           				OqcCatalog.showCategoryDescription(container);
      				},
      				onDblClick: function(node, event) {
				
      				if (node.isExpanded()) {
         				node.expand(false);}
         				else {node.expand(true);}
        				
    					},
    					onClick: function(node, event) {
							if( event.ctrlKey ){
      						if( node.data.href) {
         						window.location.href = node.data.href;}
         					}
      						
    					},
					});
				} else {
					$(container).dynatree({
				
						children: treeData,
						clickFolderMode : 1,
						onClick: function(node, event) {
							if( event.shiftKey ){
        						OqcCatalog.editNode(container, node);
        						return false;
      					}
      					if( event.ctrlKey ){
      						if( node.data.href) {
         						window.location.href = node.data.href;}
         					}
      						
    					},
    					dnd: {
     						onDragStart: function(node) {
        						return true;
      					},
      					onDragStop: function(node) {
        
      					},
      					autoExpandMS: 500,
      					preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
      					onDragEnter: function(node, sourceNode) {
      						
      						if (sourceNode.data.isOption) {
      							return ['before', 'after'] ;}
      						if (sourceNode.data.isProduct && node.data.isProduct) {
      							return ['before', 'after'] ;}
      						if (sourceNode.data.isProduct && node.getLevel() == 1) {
      						return 'over';}
      				
        					return true;
      					},
      					onDragOver: function(node, sourceNode, hitMode) {
       
        					if(node.isDescendantOf(sourceNode)){
          				return false;
          				}
          				if (sourceNode.data.isOption) {
      							if (!node.isDescendantOf(sourceNode.getParent())) {
      								return false;}
      					}
      					if (sourceNode.data.isProduct && node.data.isOption) {
      						return false;}
      				
      					if (!sourceNode.data.isProduct && !sourceNode.data.isOption) {
      						if (node.data.isProduct || node.data.isOption) {
      							return false;}
      					}
          				},
      					onDrop: function(node, sourceNode, hitMode, ui, draggable) {
        
      					sourceNode.move(node, hitMode);
      					OqcCatalog.storeTreeStructure(container);
      					parNode = sourceNode.getParent();
      					if (parNode) {
      					parNode.data.isFolder = true;
      					parNode.render();}
       
      					},
      					onDragLeave: function(node, sourceNode) {
        
      					}
    					},
    					onActivate: function(node) {
       
        					OqcCatalog.updateTinyEditorContent(container);
        					node.data.wasActive = true;
            			OqcCatalog.storeTreeStructure(container);
      				},
      				onDblClick: function(node, event) {
				
      					if (node.isExpanded()) {
         				node.expand(false);}
         				else {node.expand(true);}
        				
    					}
    				
					});
					
				OqcCatalog.initHiddenFields(container);	
					
					
				}
			},
			
			editNode: function(container, node) {
				if (node.data.isOption) {
					alert(languageStrings.LBL_OPTION_NO_EDIT);
				} else {
  				var prevTitle = node.data.title,
    			tree = node.tree;
  // Disable dynatree mouse- and key handling
  				tree.$widget.unbind();
  // Replace node with <input>
  				$(".dynatree-title", node.span).html("<input id='editNode' value='" + prevTitle + "'>");
  // Focus <input> and bind keyboard handler
  				$("input#editNode")
    				.focus().select()
    				.keydown(function(event){
      			switch( event.which ) {
      				case 27: // [esc]
        // discard changes on [esc]
       				$("input#editNode").val(prevTitle);
        				$(this).blur();
        				break;
      			case 13: // [enter]
        		// simulate blur to accept new value
        				$(this).blur();
        		//		OqcCatalog.storeTreeStructure(container);
        				break;
      			}
    			}).blur(function(event){
      // Accept new value, when user leaves <input>
      		var title = $("input#editNode").val();
      			node.setTitle(title);
      			OqcCatalog.storeTreeStructure(container);
      // Re-enable mouse and keyboard handlling
      		tree.$widget.bind();
      		node.focus();
    			});
    		}
			},
			
			storeCategoryDescription: function(container) {
				if ($(container).dynatree("getActiveNode")) {
				var node_id = $(container).dynatree("getActiveNode").data.key;}
				else {return;}
    	
				if (OqcCommon.tagExists('categoryDescription_' + node_id)) {
						var descriptionTag = document.getElementById('categoryDescription_' + node_id);
						descriptionTag.value =   tinyMCE.getInstanceById('categoryDescription').getContent();
						
				}
			},
			
			compactifyNode: function(jsonObj) {
				var compactObj = new Array;
        			for (var i=0; i<jsonObj.length; i++) {
        			compactObj[i] = {},
        			compactObj[i].key = jsonObj[i].key;
        			compactObj[i].title = jsonObj[i].title;
        			compactObj[i].isProduct = jsonObj[i].isProduct;	
        			compactObj[i].isOption = jsonObj[i].isOption;
        			if (jsonObj[i].wasActive) {
        				compactObj[i].wasActive = jsonObj[i].wasActive;
        			}
        			if (jsonObj[i].children) {
        				compactObj[i].children = OqcCatalog.compactifyNode(jsonObj[i].children);	
        			}	else {compactObj[i].children = '';}
        				
        			}
				return compactObj;
				
			},
			
			
			storeTreeStructure: function(container){
    			if (OqcCommon.tagExists("categoryHiddenField")) {
        			var categoryHiddenFieldTag = document.getElementById("categoryHiddenField");
        			var jsonObj = $(container).dynatree("getTree").toDict().children; //take just part that contains visible nodes; it is array of objects
        			//compactify the structure - keep the information that is needed only
        			var compactObj = new Array;
        			for (var i=0; i<jsonObj.length; i++) {
        			compactObj[i] = {},
        			compactObj[i].key = jsonObj[i].key;
        			compactObj[i].title = jsonObj[i].title;
        			compactObj[i].isProduct = jsonObj[i].isProduct;	
        			compactObj[i].isOption = jsonObj[i].isOption;
        			if (jsonObj[i].wasActive) {
        				compactObj[i].wasActive = jsonObj[i].wasActive;
        			}
        			if (jsonObj[i].children) {
        				compactObj[i].children = OqcCatalog.compactifyNode(jsonObj[i].children);	
        			}	else {compactObj[i].children = '';}
        				
        			}
        			var jsonStr = YAHOO.lang.JSON.stringify(compactObj);
        			categoryHiddenFieldTag.value = jsonStr;
    			}
			},
			
			updateTinyEditorContent: function(container){
    			var node_id = $(container).dynatree("getActiveNode").data.key;

    			if (node_id) {
        			if (OqcCommon.tagExists("categoryDescription_" + node_id)) {
            		var description = document.getElementById("categoryDescription_" + node_id).value; 
	        			if (OqcCommon.tagExists("categoryDescription")) {
	            		tinyMCE.getInstanceById('categoryDescription').setContent(description);
	        			}
	    			} else {
	   				if (OqcCommon.tagExists("categoryDescription")) {
	            		tinyMCE.getInstanceById('categoryDescription').setContent('');
	        			}
	    			}
   			 } 
    		},
    		
    		showCategoryDescription: function(container){
    			var description = $(container).dynatree("getActiveNode").data.description;

    			if (description) {
        				if (OqcCommon.tagExists("oqc_category_description")) {
	            		tinyMCE.getInstanceById("oqc_category_description").setContent(description);
	        			}
	    		} 
    		},
    		
    		addNode: function(container, new_node_id){
   
       		var rootNode = $(container).dynatree("getRoot");
      		var childNode = rootNode.addChild({
        			title: languageStrings.LBL_NEW_NODE_TITLE,
        			key: new_node_id,
        			icon: 'Category_empty.gif',
        			isOption: false,
        			isProduct: false
        		});
			   OqcCatalog.addHiddenFieldForCategoryDescription(new_node_id, languageStrings.LBL_NEW_DESCRIPTION_TEXT);
        		OqcCatalog.updateTinyEditorContent();
        		OqcCatalog.storeTreeStructure(container);
			},
			
			deleteNode: function(container){
				var node = $(container).dynatree("getActiveNode");
				if (node.data.isProduct || node.data.isOption) {
					alert(languageStrings.LBL_PRODUCT_NO_DELETE);
					return ;
				}
    			if ( node ) {
        			if ((node.hasChildren() === false) || confirm(languageStrings.LBL_CONFIRM_DELETE)) {
        				node_id = node.data.key;
            		if (OqcCommon.tagExists("deletedCategories")) {
               		var deletedCategoriesTag = document.getElementById("deletedCategories");
               		deletedCategoriesTag.value = deletedCategoriesTag.value + " " + node_id;
               		node.remove();
               		OqcCatalog.storeTreeStructure(container);
            		} else {
                	alert("Could not resolve element with id 'deletedCategories'");
                	return;
            		}
              	}
        		}
    		},
			
			addHiddenFieldForCategoryDescription: function(node_id, description){
    			if (OqcCommon.tagExists("categoryHiddenFieldContainer")) {
    				if (!OqcCommon.tagExists("categoryDescription_" + node_id)) {
        				var hiddenDescriptionField = document.createElement("input");
        				hiddenDescriptionField.type = "hidden";
        				hiddenDescriptionField.id = "categoryDescription_" + node_id;
        				hiddenDescriptionField.name = "categoryDescription_" + node_id;
        				hiddenDescriptionField.value = description;
        
        				var categoryHiddenFieldContainerTag = document.getElementById("categoryHiddenFieldContainer");
        				categoryHiddenFieldContainerTag.appendChild(hiddenDescriptionField);
        			}
    			}
			},

			initHiddenFields: function(container){
				$(container).dynatree("getRoot").visit(function(node){
    				OqcCatalog.addHiddenFieldForCategoryDescription(node.data.key, node.data.description);
					});
				
				
			},
			
			expandAll: function(container) {
			var expandButton = document.getElementById("oqc_toggleExpand");
			if (expandButton.name == 'expand') {	
				
				$(container).dynatree("getRoot").visit(function(node){
    			node.expand(true);
				});
				expandButton.value = languageStrings.LBL_COLLAPSE_ALL;
				expandButton.name = 'collapse';
				expandButton.blur();
			}
			else {
				$(container).dynatree("getRoot").visit(function(node){
    			node.expand(false);
				});
				expandButton.value = languageStrings.LBL_EXPAND_ALL;
				expandButton.name = 'expand';
				expandButton.blur();
			}	
			}
	
		};
}();
