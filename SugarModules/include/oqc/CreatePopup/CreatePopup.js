var popup_request_data;

function open_CreatePopup(module_name, width, height, oqc_data, metadata)
{
	// set the variables that the popup will pull from
	window.document.popup_request_data = oqc_data;
	popup_request_data = oqc_data;
	//popup_request_data

	// launch the popup
	URL = 'index.php?'
	    + 'module=oqc_CreatePopup'
	    //+ '&return_action=ReturnBean'
		+ '&moduletocreate=' + module_name
		+ '&action=Popup';
	
	windowName = 'popup_create_window';
	
	windowFeatures = 'width=' + width
		+ ',height=' + height
		+ ',resizable=1,scrollbars=1';

	if (metadata != '' && metadata != 'undefined') {
		URL+='&metadata='+metadata;	
	}
	
	win = window.open(URL, windowName, windowFeatures);
	win.document.popup_request_data = oqc_data;

	if(window.focus)
	{
		// put the focus on the popup if the browser supports the focus() method
		win.focus();
	}

	return win;
}


function find_item(my_array, itemname)
{
	for (i in my_array)
	{
		for (ii in my_array[i]) 
		{
			if (ii == itemname)
			{
				return my_array[i][ii];
			}
		} 
	}
	
	return "";
}

function find_entity()
{
	var form_name = 'oqc_CreateAttachment';
	function success(data) {
        var bean = eval(data.responseText);
		
		var reply_data = new Array();
		reply_data["name_to_value_array"] = new Array();		
		reply_data["name_to_value_array"]["document_id"] = find_item(bean, 'id');
		reply_data["name_to_value_array"]["document_name"] = find_item(bean, 'document_name');
		reply_data["name_to_value_array"]["document_revision_id"] = find_item(bean, 'document_revision_id');
		reply_data["name_to_value_array"]["document_category_id"] = find_item(bean, 'category_id');
		reply_data["name_to_value_array"]["revision"] = find_item(bean, 'revision');
		reply_data["passthru_data"] = window.opener.popup_request_data.passthru_data;
		var a = eval("window.opener." + opener.popup_request_data.call_back_function);
		a(reply_data);
		window.close();
	}
	function failure(data) {
	}

	window.document.forms[form_name].module.value = ''; 
	window.document.forms[form_name].action.value = '';
	YAHOO.util.Connect.setForm(form_name);
	YAHOO.util.Connect.asyncRequest('POST', 'oqc/FindEntity.php', {success: success, failure: failure});
	return false;
}

function save_popup_and_close(popup_reply_data)
{
	var form_name = 'oqc_CreateAttachment';
	var uploadHandler = {
  		//handle upload case. This function will be invoked after file upload is finished.
  		upload: function(response) {
			find_entity();
  		}
	};

	window.document.forms[form_name].return_module.value = ''; // window.document.forms[form_name].module.value;
	window.document.forms[form_name].action.value = 'Save';
	YAHOO.util.Connect.setForm(form_name, true); // FileUpload aktivieren
	var cObj = YAHOO.util.Connect.asyncRequest('POST', 'index.php', uploadHandler);
	return false;
}

function upload_and_close(popup_reply_data)
{
	var form_name = 'DocumentRevisionEditView';
	var uploadHandler = {
  		//handle upload case. This function will be invoked after file upload is finished.
  		upload: function(response) {
			finalise_upload();
  		}
	};

	window.document.forms[form_name].return_module.value = ''; // window.document.forms[form_name].module.value;
	window.document.forms[form_name].action.value = 'Save';
	YAHOO.util.Connect.setForm(form_name, true); // FileUpload aktivieren
	var cObj = YAHOO.util.Connect.asyncRequest('POST', 'index.php', uploadHandler);
	return false;
}

function upload_and_close_63(popup_reply_data)
{
	var form_name = 'oqc_UploadRevision';
	var uploadHandler = {
  		//handle upload case. This function will be invoked after file upload is finished.
  		upload: function(response) {
			finalise_upload_63();
  		}
	};

	window.document.forms[form_name].return_module.value = ''; // window.document.forms[form_name].module.value;
	window.document.forms[form_name].action.value = 'Save';
	YAHOO.util.Connect.setForm(form_name, true); // FileUpload aktivieren
	var cObj = YAHOO.util.Connect.asyncRequest('POST', 'index.php', uploadHandler);
	return false;
}


function finalise_upload()
{
	var form_name = 'DocumentRevisionEditView';
	function success(data) {
        var bean = eval(data.responseText);
		
		var reply_data = new Array();
		reply_data["name_to_value_array"] = new Array();		
		reply_data["name_to_value_array"]["document_id"] = find_item(bean, 'id');
		reply_data["name_to_value_array"]["document_name"] = find_item(bean, 'document_name');
		reply_data["name_to_value_array"]["document_revision_id"] = find_item(bean, 'document_revision_id');
		reply_data["name_to_value_array"]["document_category_id"] = find_item(bean, 'document_category_id');
		reply_data["name_to_value_array"]["revision"] = find_item(bean, 'revision');
		reply_data["passthru_data"] = opener.popup_request_data.passthru_data
			
		var a = eval("window.opener." + opener.popup_request_data.call_back_function);
		a(reply_data);
		window.close();
	}
	function failure(data) {
	}

	//window.document.forms[form_name].module.value = ''; 
	//window.document.forms[form_name].action.value = '';
	YAHOO.util.Connect.setForm(form_name);
	var cObj = YAHOO.util.Connect.asyncRequest('POST', 'oqc/GetLatestRevision.php', {success: success, failure: failure});
//	alert ('New Revision upload finished');
	//window.close();
	return;
	
}

function finalise_upload_63()
{
	var form_name = 'oqc_UploadRevision';
	function success(data) {
        var bean = eval(data.responseText);
		
		var reply_data = new Array();
		reply_data["name_to_value_array"] = new Array();		
		reply_data["name_to_value_array"]["document_id"] = find_item(bean, 'id');
		reply_data["name_to_value_array"]["document_name"] = find_item(bean, 'document_name');
		reply_data["name_to_value_array"]["document_revision_id"] = find_item(bean, 'document_revision_id');
		reply_data["name_to_value_array"]["document_category_id"] = find_item(bean, 'document_category_id');
		reply_data["name_to_value_array"]["revision"] = find_item(bean, 'revision');
		reply_data["passthru_data"] = opener.popup_request_data.passthru_data
			
		var a = eval("window.opener." + opener.popup_request_data.call_back_function);
		a(reply_data);
		window.close();
	}
	function failure(data) {
	}

	//window.document.forms[form_name].module.value = ''; 
	//window.document.forms[form_name].action.value = '';
	YAHOO.util.Connect.setForm(form_name);
	var cObj = YAHOO.util.Connect.asyncRequest('POST', 'oqc/GetLatestRevision.php', {success: success, failure: failure});
	//alert ('New Revision upload finished');
	//window.close();
	return;
	
}


