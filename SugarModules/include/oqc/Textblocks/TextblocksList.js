
var textblockMap = new Map();

var __textblocksContainer__ = 'textblocksContainer';
var __textblockIdContainer__ = 'textblockIdContainer';
var __textblockSequence__ = 'textblockSequence';
var __textblocksButtonsContainer__ = 'textblocksButtons';
var __textblocksWaitingGif__ = 'textblocksWaitingGif';



function Textblock(id, name, description, idOfOriginalTextblock) {
	this.id = id;
	this.name = name;
	this.description = description;
	this.idOfOriginalTextblock = idOfOriginalTextblock;	
}

function updateDescriptionFields() {
	
	var sequence = document.getElementById(__textblockSequence__);
   if (sequence) {
   	if(sequence.value != '') {
     		textBlockIds = sequence.value.trim().split(' ');
   		for (var i=0; i<textBlockIds.length; i++) {
   			descriptionTag = document.getElementById('description_' + textBlockIds[i]);
   			tinyDescription = tinyMCE.getInstanceById('tiny_description_' +textBlockIds[i]);
   			descriptionTag.value = tinyDescription.getContent();
   		}
   	}
	}					
				
}

function saveTextblocksSequence(){
    var container = document.getElementById(__textblocksContainer__);
    if (container) {
    	  var sequence = "";
        for (var i = 0; i < container.childNodes.length; i++) {
        	if (container.childNodes[i].tagName == "TABLE") {
			var id = container.childNodes[i].id;
			id = id.replace(/textblock_/, "");
            sequence += id + " ";
        }
        }
        
        var sequenceStore = document.getElementById(__textblockSequence__);
        if (sequenceStore) {
            sequenceStore.value = sequence;
        } else {
            alert('Could not resolve element with id "' + __textblockSequence__ + '"');
        }
    } else {
        alert('Could not resolve element with id "' + __textblocksContainer__ + '"');
    }
}

// check whether a textblock exists that references the given id 
// 
// if the user inserted a textblock before and edited its content, the reference to the original textblock is stored in the edited textblock.
// this method should make sure that the original textblock cannot be inserted anymore. 
function existsTextblockReferencingThisId(id) {
	var textblockIds = textblockMap.keys();
	for (var i=0; i<textblockIds.length; i++) {
		var textblock = textblockMap.get(textblockIds[i]);
		if (id == textblock.idOfOriginalTextblock) {
			return true;
		}
	}
	return false;
}

function addTextblock(textblock){
	if (!textblockMap.contains(textblock.id) && !existsTextblockReferencingThisId(textblock.id)) { 
        var randomId = OqcCommon.getRandomString();
        var container = document.getElementById(__textblocksContainer__);
        
        if (container) {
            var tdName = document.createElement('td');
            	 tdName.id = "name_"+textblock.id;
            	 tdName.setAttribute('class', 'listViewThS1');
            	 tdName.style.fontWeight = 'bold';
            	 tdName.style.verticalAlign = 'middle';
            	 tdName.appendChild(document.createTextNode(textblock.name));
            	 
            var tdDelete = document.createElement('td');
            	 tdDelete.setAttribute('style', 'text-align: right;');
            	 tdDelete.setAttribute('class', 'listViewThS1');
            	 
            var tddragDrop = document.createElement('span');
            tddragDrop.style.paddingLeft = '100px';
            tddragDrop.style.color = 'red';
            tddragDrop.style.position = 'absolute';
            tddragDrop.appendChild(document.createTextNode(languageStringsTextblocks.dragdrop));
            tdName.appendChild(tddragDrop);
                      
            var tdDescription = document.createElement('td');
            tdDescription.setAttribute('colspan', 3);
            tdDescription.setAttribute('valign', 'top');
            tdDescription.setAttribute('nowrap', 'nowrap');
            tdDescription.setAttribute('bgcolor', '#ffffff');
            tdDescription.setAttribute('scope', 'row');
         
            var divEditor = document.createElement('textarea');
            divEditor.setAttribute('id', "description_"+ textblock.id);
            divEditor.name = "description_"+ textblock.id;
            divEditor.style.height = '207px';
            divEditor.style.width = '580px';
            divEditor.value = textblock.description; 
            
            tdDescription.appendChild(divEditor);
                       
				var deleteButton = document.createElement('input');
				deleteButton.className = 'button';
				deleteButton.type = 'button';
				deleteButton.value = languageStringsTextblocks['delete'];
				deleteButton.onclick = 'deleteTextblock(' + textblock.id + ');'; // <--- does not work in firefox 
				deleteButton.setAttribute('onClick', "deleteTextblock('" + textblock.id + "');"); // <--- works in firefox
			
            tdDelete.appendChild(deleteButton);
           
            
            var tr1 = document.createElement('tr');
            var tr2 = document.createElement('tr');
            
            tr1.appendChild(tdName);
            tr1.appendChild(tdDelete);
            
            tr2.appendChild(tdDescription);
            
            var table = document.createElement('table');
                       
				table.id = 'textblock_' + textblock.id;
				var table_id = 'textblock_' + textblock.id;
				table.style.width = '580px';
				table.style.border = '1px';
				table.style.marginBottom = '10px';
				table.className = 'edit view';
            table.setAttribute('cellspacing', '0');
            table.setAttribute('cellpadding', '0');

            table.appendChild(tr1);
            table.appendChild(tr2);
            container.appendChild(table);
    
            // create editor 
            
           tinyMCE.execCommand('mceAddControl',false,divEditor.id); 
     
         saveTextblocksSequence();
         YAHOO.util.Event.addListener(document.getElementById(tdName.id),'mousedown',doSortable); 
	      YAHOO.util.Event.addListener(document.getElementById(tdName.id),'mouseup',undoSortable); 
			textblockMap.set(textblock.id, textblock);
        } else {
            alert('Could not resolve element with id "' + __textblocksContainer__ + '"');
        }
    } 
}

function addReadOnlyTextblock(textblock){
	
        var container = document.getElementById(__textblocksContainer__);
        
        if (container) {
            var tdName = document.createElement('td');
            	 tdName.id = "name_"+textblock.id;
              	 tdName.style.fontWeight = 'bold';
            	 tdName.style.verticalAlign = 'middle';
            	 tdName.style.border = 'none';
              	 tdName.appendChild(document.createTextNode(textblock.name));
            	 
           
                      
            var tdDescription = document.createElement('td');
            tdDescription.setAttribute('valign', 'top');
            tdDescription.setAttribute('nowrap', 'nowrap');
            tdDescription.style.border = 'none';
       
            var divEditor = document.createElement('textarea');
            divEditor.setAttribute('id', "description_"+ textblock.id);
            divEditor.name = "description_"+ textblock.id;
            divEditor.style.height = '207px';
            divEditor.style.width = '580px';
            divEditor.value = textblock.description; 
            
            tdDescription.appendChild(divEditor);
                       
				         
            
            var tr1 = document.createElement('tr');
            var tr2 = document.createElement('tr');
            
            tr1.appendChild(tdName);
            tr2.appendChild(tdDescription);
            
            var table = document.createElement('table');
                       
				table.id = 'textblock_' + textblock.id;
				var table_id = 'textblock_' + textblock.id;
				table.style.width = '580px';
				table.style.border = 'none';
				table.style.marginBottom = '10px';
				table.className = 'view list';
            table.setAttribute('cellspacing', '0');
            table.setAttribute('cellpadding', '0');

            table.appendChild(tr1);
            table.appendChild(tr2);
            container.appendChild(table);
    
            // create editor 
            
           tinyMCE.execCommand('mceAddControl',true,divEditor.id); 
     
         } else {
            alert('Could not resolve element with id "' + __textblocksContainer__ + '"');
        }
     
}

function makeSortable() {
	 Sortable.create(__textblocksContainer__, {
                ghosting: false,
                reverteffect: false,
                starteffect: false,
                endeffect: false,
                tag: 'table'
            }); 
}

var doSortable = function(o) {
	 
	var container = document.getElementById(__textblocksContainer__);
    if (container) {
    	 for (var i = 0; i < container.childNodes.length; i++) {
        	if (container.childNodes[i].tagName == "TABLE") {
			var id = container.childNodes[i].id;
			var editor_id = id.replace(/textblock/, "description");
			//2.0 avoid iframe resizing when remove tinyMCE instance
			var editorheight = document.getElementById(id).clientHeight - 30;
			tinyMCE.execCommand('mceRemoveControl',false,editor_id); 
			var editordiv = document.getElementById(editor_id);
			editordiv.style.height = editorheight+'px';
			}
	    }	
		makeSortable();
	 }
}

var undoSortable = function(o) {
   Sortable.destroy( __textblocksContainer__);
	var container = document.getElementById(__textblocksContainer__);
    if (container) {
    	 for (var i = 0; i < container.childNodes.length; i++) {
        	if (container.childNodes[i].tagName == "TABLE") {
			var id = container.childNodes[i].id;
			var editor_id = id.replace(/textblock/, "description");
			
			//recreate instance
			tinyMCE.execCommand('mceAddControl',false,editor_id); 
			}
	    }	
	saveTextblocksSequence();	
	 }
}

function deleteTextblock(id) {
	textblockMap.remove(id);
	
	// remove the textblock from the textblock sequence
	if (OqcCommon.tagExists(__textblockSequence__)) {
		var textblocksSequence = document.getElementById(__textblockSequence__);
		textblocksSequence.value = textblocksSequence.value.replace(id, '');
		textblocksSequence.value = textblocksSequence.value.replace(/^\s+|\s+$/g, '');
	}
	
	if (OqcCommon.tagExists("textblock_" + id)) {
		tinyMCE.execCommand("mceRemoveControl", false, "description_" + id);
		
		OqcCommon.removeTag("textblock_" + id);
	}
}

var handleSuccess = function(o){
	
	if(o.responseText !== undefined){
		var textblocks = JSON.parse(o.responseText);
		
		for (var i=0; i<textblocks.length; i++) {
			var textblock = new Textblock(textblocks[i].id, textblocks[i].title, textblocks[i].description);
			addTextblock(textblock);
		}
	}
	
	OqcCommon.removeTag(__textblocksWaitingGif__);
}

// TODO error handling
var handleFailure = function(o){
	if(o.responseText !== undefined){
		alert('failure');
	}
}

function handleTextblocksPopUpClosed(popupReplyData){
    var formName = popupReplyData.formName;
    var nameToValueArray = popupReplyData.name_to_value_array;
    var textblock = new Textblock();
    
    for (var currentKey in nameToValueArray) {
        if (currentKey != 'toJSON') {
            var displayValue = nameToValueArray[currentKey];
            displayValue = displayValue.replace('&#039;', "'"); //restore escaped single quote.
            displayValue = displayValue.replace('&amp;', "&"); //restore escaped &.
            displayValue = displayValue.replace('&gt;', ">"); //restore escaped >.
            displayValue = displayValue.replace('&lt;', "<"); //restore escaped <.
            displayValue = displayValue.replace('&quot; ', "\""); //restore escaped \".
            textblock[currentKey] = displayValue;
        }
    }
    var request = YAHOO.util.Connect.asyncRequest('GET', "oqc/GetTextblockDescription.php?id="+textblock.id, {success: handleSuccess, failure: handleFailure});

}

function addDefaultTextBlocks() {
	if (OqcCommon.tagExists(__textblocksButtonsContainer__)) {
		var container = document.getElementById(__textblocksButtonsContainer__);
		container.appendChild(OqcCommon.getWaitingGif(__textblocksWaitingGif__));
		var request = YAHOO.util.Connect.asyncRequest('GET', "oqc/GetCurrentTextblocks.php", {success: handleSuccess, failure: handleFailure});	
	} else {
		alert('Could not find element with id ' + __textblocksButtonsContainer__);
	}
}

