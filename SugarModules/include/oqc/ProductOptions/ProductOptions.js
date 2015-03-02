// Enspricht der Sugar-PHP-Funktion "from_html"
function option_from_html(html_string) {
  html_string = html_string.replace(/&quot;/gi, '"');
  html_string = html_string.replace(/&lt;/gi, '<');
  html_string = html_string.replace(/&gt;/gi, '>');
  html_string = html_string.replace(/&#039;/, "'");
  
  return html_string;
}

function options_open_popup(initial_filter, callback_data) {
	
	open_popup("oqc_Product", 1250, 800, initial_filter, true, true, callback_data);	
	
}


function option_documentId(id)
{
	return 'option_' + id; 
}

function option_setDisplayStyleById(id, displayStyle) {
  document.getElementById(id).style.display = displayStyle; // "none" oder "inline"
}

function option_updateCurrency() {
	var currency_dropdown = document.getElementsByName('currency_id');
   var selectEl = currency_dropdown[0];
   if (selectEl) {
		newCurrency_id = selectEl.options[selectEl.selectedIndex].value;
	}	else { newCurrency_id = '-99';}
   var oldCurrencySymbol = propt_currencyOptions.prefix;
   var oldConversionRate = oqc_option_currency_rate;
   oqc_option_current_id = newCurrency_id;
   propt_currencyOptions.prefix = oqc_CurrencySymbols[newCurrency_id];
   oqc_option_currency_rate = oqc_ConversionRates[newCurrency_id];
   var calc_rate = parseFloat(oldConversionRate)/parseFloat(oqc_option_currency_rate);
   var options_ids = document.getElementsByName('option_ids[]');
  
   for (var i=0; i<options_ids.length; i++) { 
   	var oldPrice = document.getElementById(options_ids[i].value + '_3').innerHTML.replace(oldCurrencySymbol, '');
   	oldPrice = oldPrice.replace(/\s+/g, '');
   	var updatedPrice = parseFloat(oldPrice.replace(decimalSeparator, '.'))/calc_rate;
	   updatedPrice = YAHOO.util.Number.format(updatedPrice, propt_currencyOptions);
	  	document.getElementById(options_ids[i].value+'_3').innerHTML = updatedPrice;
   }  		
}



function addOptionHtml(opt_id, opt_name, opt_url, opt_version, opt_status, opt_price, opt_is_recurring, opt_date_modified, opt_modified_by_name, row_status)
{
//create column values array
	var oqcOptionData = Array();
	//2.2RC2 opt_price should be of string type
	if (typeof(opt_price) == 'number') {
		opt_price += '';}
	opt_price = YAHOO.util.Number.format(parseFloat(opt_price.replace(decimalSeparator, '.')), propt_currencyOptions);
	//opt_price_recurring = YAHOO.util.Number.format(parseFloat(opt_price_recurring.replace(decimalSeparator, '.')), propt_currencyOptions);
	row_count = document.getElementById('oqc_product_options').childElementCount;
	oqcOptionData.push(opt_name, opt_version, opt_status, opt_price, opt_is_recurring, opt_date_modified, opt_modified_by_name);
	newRow = document.createElement('tr');
	newRow.id = 'option_row' + opt_id;
	if (row_count%2 == 0) {
	newRow.setAttribute('class','yui-dt-even');
	} else {newRow.setAttribute('class','yui-dt-odd');}
	
	for (var i=0; i<7; i++) {
	newColumn=document.createElement('td');
	newColumn.id = opt_id+'_'+i;
	
	if (i==0) {
	newColumn.setAttribute('style', 'padding: 4px 10px 2px 10px !important; text-align: left;');
	newColumn.innerHTML = '';	
	} else {
		newColumn.setAttribute('style', 'padding: 4px 10px 2px 10px !important; text-align: center;');	
		newColumn.innerHTML = oqcOptionData[i];
		}
	newRow.appendChild(newColumn);
	}
	delete_cell = document.createElement('td');
	delete_button = document.createElement('div')
	delete_button.setAttribute('style', 'padding: 4px 10px 2px 10px !important; text-align: center;');
	var delete_link = '<input class="button" type="button" onclick="removeOption(\'' + opt_id + '\', false);" value="Delete">';
	
	delete_button.innerHTML = delete_link;
  delete_cell.appendChild(delete_button);
 
	newRow.appendChild(delete_cell); 	
  
  
  //2.2RC1 checkbox for is_recurring
  check_box = document.createElement('div');
  check_box.setAttribute('style', 'padding: 4px 10px 2px 10px !important; text-align: center;');
  var checked = (opt_is_recurring == '1') ? 'checked=""' : '';
  var recurring = '<input class="checkbox" type="checkbox" disable="true" ' + checked +'>';
 // document.getElementById(opt_id+'_4').innerHTML = recurring; 
  
	hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'option_ids[]';
  hidden.value = opt_id; 
  newRow.appendChild(hidden);
  

  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'row_status[]';
  hidden.id = 'row_status_' + opt_id;
  hidden.value = row_status; 
  newRow.appendChild(hidden);
  
	document.getElementById('oqc_product_options').appendChild(newRow);
	
	// Dokument/Attachment-Name anzeigen und zum Download verlinken
  if (opt_url) {
  link = document.createElement('a');
  link.id = 'link_'+ opt_id;
  link.href = 'index.php?module=oqc_Product&record='+ opt_id + '&action=DetailView&return_module=oqc_Product';
  link.innerHTML = opt_name;
  document.getElementById(opt_id+'_0').appendChild(link); } else {
  	document.getElementById(opt_id+'_0').innerHTML = opt_name; 
  	
  	}

	document.getElementById(opt_id+'_4').innerHTML = recurring; 
	document.getElementById('options_table').setAttribute('style', 'display:"";')
	
  Sortable.create("oqc_product_options", {tag: "tr", containment: "oqc_product_options"}); 
}

// Entfernt ein Dokument aus der Hauptseite
function removeOption(opt_id, force)
{
//	alert('Hello');
//	return;
  del_option = document.getElementById('option_row' + opt_id);
  if (del_option != null)
  {
    opt_status = optionStatus(opt_id);
    if ((opt_status == 'new') || force) 
	{
	  // Eintrag ist nur im HTML vorhanden aber noch nicht in Datenbank -> HTML einfach löschen
	  document.getElementById('oqc_product_options').removeChild(del_option);
	} else
    if (opt_status == 'saved') 
	{
	  // Eintrag ist bereits in DB -> unsichtbare Markierung, dass Eintrag gelöscht werden soll
	  option_markDeleted(opt_id, del_option)  
	}

	Sortable.create("oqc_product_options", {tag: "tr", containment: "oqc_product_options"}); 
  }
}

/* function uploadNewOption(doc_id, doc_name, doc_rev_id) 
{
	
	var doc_data = doc_id + '_' +doc_rev_id +'_' + doc_name ;
	//var bandymas;
	OqcCommon.setModifiedFlag();
	open_CreatePopup("DocumentRevisions", 950, 280, encodedRequestRevisionData, doc_data);
	//bandymas = window.document.forms['Editview'].record.value ;
	//bandymas = 'Testas';
 //alert(doc_id);
	
	
} */

// Stellt ein bereits gespeichertes aber zuvor aus dem HTML gelöschtes Dokument wieder her
function restoreOption(opt_id, opt_name, opt_version, opt_status, opt_price, opt_price_recurring, opt_date_modified, opt_modified_by_name, row_status)
{
  // Dokument aus HTML entfernen...
  removeOption(opt_id, true);
  // ...und neu einfügen mit dem Hinweis, dass es schon in DB steht
  addOptionHtml(opt_id, opt_name, true, opt_version, opt_status, opt_price, opt_price_recurring, opt_date_modified, opt_modified_by_name, 'saved');
}

function addOption(opt_id, opt_name, opt_version, opt_status, opt_price, opt_price_recurring, opt_date_modified, opt_modified_by_name, allow_alert)
{
  o_status = optionStatus(opt_id);
  if (o_status == null)
  {
    // Dokumente existiert noch nicht
   
	addOptionHtml(opt_id, opt_name, true, opt_version, opt_status, opt_price, opt_price_recurring, opt_date_modified, opt_modified_by_name, 'new'); 	
  } else
  if (o_status == 'delete')
  {
    // Dokument wurde schon temporär gelöscht
	restoreOption(opt_id, opt_name, opt_version, opt_status, opt_price, opt_price_recurring, opt_date_modified, opt_modified_by_name, 'new');		
  } else
  if (allow_alert)
  {
    // Dokument existiert schon
  	alert('Option "' + option_from_html(opt_name) + '" is already attached.')
  }
}

/* function addDefaultOption(attachments)
{
  for (i = 0; i < attachments.length; i++)
  {
  	addOption(attachments[i]['id'], 
	  attachments[i]['document_name'], 
	  attachments[i]['document_revision_id'], 
	  attachments[i]['is_default'],
	  false);
  }	
} */

// Gibt den Status eines Dokuments zurück (null, "new", "deleted", "saved")
function optionStatus(opt_id)
{
  option = document.getElementById('option_row' + opt_id);
  if (option)
    return document.getElementById('row_status_' + opt_id).value; else
	return null;
}

// Entfernt das HTML zu dem Eintrag und fügt eine unsichtbare Markierung ein, dass das Dokument entfernt 
// werden soll.
function option_markDeleted(opt_id, element)
{
  doc = document.createElement('div');
  doc.id = 'option_row' + opt_id;

  // Hiddenfield für die Dokumenten-ID
  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'options_ids[]';
  hidden.value = opt_id; 
  doc.appendChild(hidden);
  
  // Hiddenfield für die Dokumenten-Status
  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'row_status[]';
  hidden.id = 'row_status_' + opt_id;
  hidden.value = 'delete'; 
  doc.appendChild(hidden);

  document.getElementById('oqc_product_options').appendChild(doc); // Löschmarkierung ins HTML einfügen
  document.getElementById('oqc_product_options').removeChild(element); // Element aus dem HTML löschen
}

/*function updateOption(doc_id, doc_name, doc_rev_id)
{
  link = document.getElementById('link_'+doc_id);
  if (link) {
  link.href = 'index.php?entryPoint=download&id=' + doc_rev_id + '&type=Documents'; }
    else {
	return alert('Could not update document link'); }

}*/

// Funktion wird vom PopUp-Fenster zur Dokumentenauswahl aufgerufen, wenn der Nutzer ein Dokument gewählt hat
function popup_return_option(popup_data)
{	
  if (popup_data.name_to_value_array.currency_id != oqc_option_current_id) {
	  var calc_rate = parseFloat(oqc_optionConversionRates[popup_data.name_to_value_array.currency_id])/parseFloat(oqc_option_currency_rate);
	  popup_data.name_to_value_array.price = parseFloat(popup_data.name_to_value_array.price.replace(decimalSeparator, '.'))/calc_rate;
  }
  addOption(popup_data.name_to_value_array.id,
  option_from_html(popup_data.name_to_value_array.name),
  popup_data.name_to_value_array.version,
  popup_data.name_to_value_array.status,
  popup_data.name_to_value_array.price,
  popup_data.name_to_value_array.is_recurring,
  popup_data.name_to_value_array.date_modified,
  popup_data.name_to_value_array.modified_by_name,
  true);
}


