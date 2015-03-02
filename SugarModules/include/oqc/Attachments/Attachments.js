// Enspricht der Sugar-PHP-Funktion "from_html"
function from_html(html_string) {
  html_string = html_string.replace(/&quot;/gi, '"');
  html_string = html_string.replace(/&lt;/gi, '<');
  html_string = html_string.replace(/&gt;/gi, '>');
  html_string = html_string.replace(/&#039;/, "'");
  
  return html_string;
}

function documentId(id)
{
	return 'document_' + id; 
}

function setDisplayStyleById(id, displayStyle) {
  document.getElementById(id).style.display = displayStyle; // "none" oder "inline"
}

// Fügt ein Dokument ein 
function addDocumentHtml(doc_id, doc_name, doc_rev_id, doc_is_default, doc_status)
{
  new_document = document.createElement('li');
  new_document.setAttribute('style', 'padding-bottom: 0.4em; margin: 0px;');
//  new_document.setAttribute('onMouseOver', 'setDisplayStyleById(\'removelink_' + doc_id + '\', \'inline\');');
//  new_document.setAttribute('onMouseOut', 'setDisplayStyleById(\'removelink_' + doc_id + '\', \'none\');');

  new_document.id = documentId(doc_id); 

  // Dokument/Attachment-Name anzeigen und zum Download verlinken
  link = document.createElement('a');
  link.id = 'link_'+ doc_id;
  link.href = 'index.php?entryPoint=download&id=' + doc_rev_id + '&type=Documents'; 
  new_document.appendChild(link);

  // Name
  atc_name = document.createElement('span');
  atc_name.innerHTML = doc_name;
  link.appendChild(atc_name);
  
  if (doc_is_default) {
  	new_document.appendChild(document.createTextNode(" ( " + languageStringsAttachments['default'] + ")"));
  }  
  
  // Hiddenfield für die Dokumenten-ID
  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'document_ids[]';
  hidden.id = 'rev_' + doc_id;
  hidden.value = doc_rev_id; 
  new_document.appendChild(hidden);
  
  // Hiddenfield für die Dokumenten-Status
  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'document_status[]';
  hidden.id = 'status_' + doc_id;
  hidden.value = doc_status; 
  new_document.appendChild(hidden);
  
  update_link = document.createElement('a');
  update_link.setAttribute('onClick', 'uploadNewRevision("' + doc_id + '", "' + doc_name + '", "' + doc_rev_id + '");');
  update_link.id = 'updatelink_' + doc_id;
  update_link.setAttribute('onmouseover', 'document.getElementById("' + update_link.id + '").style.cursor=\"pointer\";');
  update_link.innerHTML = '<img class="img" width="10" height="10" border="0" src="custom/themes/default/images/refresh.gif"/><span style="padding-left:0.4em">' + languageStringsAttachments['upload'] + '</span>';
  update_link.setAttribute('style', 'margin-left: 1em;');
  // remove_link.setAttribute('style', 'margin-left: 1em; display:none;');
  new_document.appendChild(update_link);
  
  

  // Löschen-Link
  remove_link = document.createElement('a');
  remove_link.setAttribute('onClick', 'removeDocument("' + doc_id + '", false);');
  remove_link.id = 'removelink_' + doc_id;
  remove_link.setAttribute('onmouseover', 'document.getElementById("' + remove_link.id + '").style.cursor=\"pointer\";');
  remove_link.innerHTML = '<img class="img" width="10" height="10" border="0" src="custom/themes/default/images/minus_inline.gif"/><span style="padding-left:0.4em">' + languageStringsAttachments['delete'] + '</span>';
  remove_link.setAttribute('style', 'margin-left: 1em;');
  // remove_link.setAttribute('style', 'margin-left: 1em; display:none;');
  new_document.appendChild(remove_link);
  
  // Fertiges HTML in die Hauptseiten einfügen
  document.getElementById('documents').appendChild(new_document);
  
  Sortable.create('documents'); // Liste sortierbar machen (muss bei jeder Änderung der Liste erfolgen)
}

// Entfernt ein Dokument aus der Hauptseite
function removeDocument(document_id, force)
{
  del_document = document.getElementById(documentId(document_id));
  if (del_document != null)
  {
    doc_status = documentStatus(document_id);
    if ((doc_status == 'new') || force) 
	{
	  // Eintrag ist nur im HTML vorhanden aber noch nicht in Datenbank -> HTML einfach löschen
	  document.getElementById('documents').removeChild(del_document);
	} else
    if (doc_status == 'saved') 
	{
	  // Eintrag ist bereits in DB -> unsichtbare Markierung, dass Eintrag gelöscht werden soll
	  markDeleted(document_id, del_document)  
	}

	Sortable.create('documents'); // Liste sortierbar machen (muss bei jeder Änderung der Liste erfolgen) 
  }
}

function uploadNewRevision(doc_id, doc_name, doc_rev_id) 
{
	
	var doc_data = doc_id + '_' +doc_rev_id +'_' + doc_name ;
	//var bandymas;
	OqcCommon.setModifiedFlag();
	open_CreatePopup("DocumentRevisions", 950, 280, encodedRequestRevisionData, doc_data);
	//bandymas = window.document.forms['Editview'].record.value ;
	//bandymas = 'Testas';
 //alert(doc_id);
	
	
}

// Stellt ein bereits gespeichertes aber zuvor aus dem HTML gelöschtes Dokument wieder her
function restoreDocument(doc_id, doc_name, doc_rev_id, doc_is_default)
{
  // Dokument aus HTML entfernen...
  removeDocument(doc_id, true);
  // ...und neu einfügen mit dem Hinweis, dass es schon in DB steht
  addDocumentHtml(doc_id, doc_name, doc_rev_id, doc_is_default, 'saved');
}

function addDocument(doc_id, doc_name, doc_rev_id, doc_is_default, allow_alert)
{
  doc_status = documentStatus(doc_id);
  if (doc_status == null)
  {
    // Dokumente existiert noch nicht
	addDocumentHtml(doc_id, from_html(doc_name), doc_rev_id, doc_is_default, 'new'); 	
  } else
  if (doc_status == 'delete')
  {
    // Dokument wurde schon temporär gelöscht
	restoreDocument(doc_id, from_html(doc_name), doc_rev_id, doc_is_default, 'new');		
  } else
  if (allow_alert)
  {
    // Dokument existiert schon
  	alert('Document "' + from_html(doc_name) + '" is already attached.')
  }
}

// Adds technical description, used in Services.js- 2.1RC1

function addTechDesc(doc_id, doc_name, doc_rev_id, doc_is_default, allow_alert)
{
  doc_status = documentStatus(doc_id);
  if (doc_status == null)
  {
    // Dokumente existiert noch nicht
	addDocumentHtml(doc_id, from_html(doc_name), doc_rev_id, doc_is_default, 'new'); 	
  } else
  if (doc_status == 'delete')
  {
    // Dokument wurde schon temporär gelöscht
	restoreDocument(doc_id, from_html(doc_name), doc_rev_id, doc_is_default, 'new');		
  } else
  if (confirm(languageStrings.update_file_confirm + from_html(doc_name))) {
  		restoreDocument(doc_id, from_html(doc_name), doc_rev_id, doc_is_default, 'new');	
  	}
  
}

function addDefaultAttachments(attachments)
{
  for (i = 0; i < attachments.length; i++)
  {
  	addDocument(attachments[i]['id'], 
	  attachments[i]['document_name'], 
	  attachments[i]['document_revision_id'], 
	  attachments[i]['is_default'],
	  false);
  }	
}

// Gibt den Status eines Dokuments zurück (null, "new", "deleted", "saved")
function documentStatus(doc_id)
{
  doc = document.getElementById(documentId(doc_id));
  if (doc)
    return document.getElementById("status_" + doc_id).value; else
	return null;
}

// Entfernt das HTML zu dem Eintrag und fügt eine unsichtbare Markierung ein, dass das Dokument entfernt 
// werden soll.
function markDeleted(doc_id, element)
{
  doc = document.createElement('div');
  doc.id = documentId(doc_id); 

  // Hiddenfield für die Dokumenten-ID
  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'document_ids[]';
  hidden.value = doc_id; 
  doc.appendChild(hidden);
  
  // Hiddenfield für die Dokumenten-Status
  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'document_status[]';
  hidden.id = 'status_' + doc_id;
  hidden.value = 'delete'; 
  doc.appendChild(hidden);

  document.getElementById('documents').appendChild(doc); // Löschmarkierung ins HTML einfügen
  document.getElementById('documents').removeChild(element); // Element aus dem HTML löschen
}

function updateDocument(doc_id, doc_name, doc_rev_id)
{
//	alert('updating link');
  link = document.getElementById('link_'+doc_id);
  rev_input = document.getElementById('rev_'+doc_id);
  status_input = document.getElementById('status_'+doc_id);
  if (link && rev_input && status_input) {
  link.href = 'index.php?entryPoint=download&id=' + doc_rev_id + '&type=Documents';
  link.childNodes[0].innerHTML = doc_name;
  rev_input.value = doc_rev_id;
  status_input.value = 'new';
   }
    else {
	return alert('Could not update document link'); }

}

// Funktion wird vom PopUp-Fenster zur Dokumentenauswahl aufgerufen, wenn der Nutzer ein Dokument gewählt hat
function popup_return_document(popup_data)
{
	if ( popup_data.name_to_value_array.revision != '') {
		var doc_name = from_html(popup_data.name_to_value_array.document_name) + '_rev.' + popup_data.name_to_value_array.revision;
	} else {
		var doc_name = from_html(popup_data.name_to_value_array.document_name);
	}
  addDocument(popup_data.name_to_value_array.document_id,
  doc_name,
  popup_data.name_to_value_array.document_revision_id,
  popup_data.name_to_value_array.document_category_id == popup_data.passthru_data.default_category,
  true);
}

// Function to update Attachement revision id after uploading new revision- 1.7.7
function revision_return_document(popup_data)
{
	if ( popup_data.name_to_value_array.revision != '') {
		var doc_name = from_html(popup_data.name_to_value_array.document_name) + '_rev.' + popup_data.name_to_value_array.revision;
	} else {
		var doc_name = from_html(popup_data.name_to_value_array.document_name);
	}
  updateDocument(popup_data.name_to_value_array.document_id,
  doc_name,
  popup_data.name_to_value_array.document_revision_id);
}
