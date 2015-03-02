function user_from_html(html_string) {
  html_string = html_string.replace(/&quot;/gi, '"');
  html_string = html_string.replace(/&lt;/gi, '<');
  html_string = html_string.replace(/&gt;/gi, '>');
  html_string = html_string.replace(/&#039;/, "'");
  
  return html_string;
}

function users_open_popup(initial_filter, callback_data, mod_name) {
	
	var objModule = new Object();
	objModule.module_name = mod_name;
	callback_data.passthru_data = objModule;
	
	open_popup("Users", 600, 400, '', true, false, callback_data);	
	
}


function userId(id, mod_name)
{
	return mod_name + id; 
}

function addModuleRowHtml(mod_name,mod_string) {
	row_count = document.getElementById('oqc_users').childElementCount;
	newRow = document.createElement('tr');
	newRow.id = mod_name;
	if (row_count%2 == 0) {
	newRow.setAttribute('class','yui-dt-even');
	} else {newRow.setAttribute('class','yui-dt-odd');}
	// Module name column
	newColumn=document.createElement('td');
	newColumn.setAttribute('style', 'padding: 4px 10px 2px 10px !important; text-align: center; font-size:10pt;');
	newColumn.innerHTML = mod_string;
	
	
		
	newRow.appendChild(newColumn);
	
	// Users column
	newColumn=document.createElement('td');
	newColumn.setAttribute('style', 'padding: 4px 10px 2px 10px !important; text-align: left;');
	newColumn.id = mod_name + 'users';	
	
	newList = document.createElement('ol');
	newList.id = mod_name + 'list';
	newList.setAttribute('style', 'padding-left:1.5em; padding-top:0.6em; margin:0px; font-size:10pt;');
	newColumn.appendChild(newList);	
	newRow.appendChild(newColumn);
	
	// Add users button column
	newColumn=document.createElement('td');
	add_button = document.createElement('div')
	add_button.setAttribute('style', 'padding: 4px 10px 2px 10px !important; text-align: center;');
	
	var add_link = '<input class="button" type="button" value="' + languageStrings.addUser + '" name="button" onClick="users_open_popup(initialFilterUsers,encodedRequestDataUsers, \'' + mod_name + '\')">';
	add_button.innerHTML = add_link;	
	newColumn.appendChild(add_button);
	newRow.appendChild(newColumn);
	
	document.getElementById('oqc_users').appendChild(newRow);
	
	
}

function addUserHtml(user_id, user_name, mod_name, user_status)
{
  new_user = document.createElement('li');
  new_user.setAttribute('style', 'padding-bottom: 0.4em; margin: 0px;');
  new_user.id = userId(user_id, mod_name); 
  new_user.innerHTML = user_name
  
  
  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'users_ids[]';
  hidden.value = mod_name+ ':' +user_id; 
  new_user.appendChild(hidden);
  
 
  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'user_status[]';
  hidden.id = 'status_' + mod_name+user_id;
  hidden.value = user_status; 
  new_user.appendChild(hidden);
  
  
  remove_link = document.createElement('a');
  remove_link.setAttribute('onClick', 'removeUser("' + user_id + '",\'' + mod_name + '\', false);');
  remove_link.id = 'removelink_' + mod_name + user_id;
  remove_link.setAttribute('onmouseover', 'document.getElementById("' + remove_link.id + '").style.cursor=\"pointer\";');
  remove_link.innerHTML = '<img class="img" width="10" height="10" border="0" src="custom/themes/default/images/minus_inline.gif"/><span style="padding-left:0.4em">' + languageStrings.delete + '</span>';
  remove_link.setAttribute('style', 'margin-left: 1em;');
  new_user.appendChild(remove_link);
  

  document.getElementById(mod_name + 'list').appendChild(new_user);
  
 }

function removeUser(user_id, mod_name, force)
{
//	alert('Hello');
//	return;
  del_id = userId(user_id, mod_name); 	
  del_user = document.getElementById(del_id);
  if (del_user != null)
  {
    user_status = userStatus(del_id);
    if ((user_status == 'new') || force) 
	{
	  document.getElementById(mod_name+'list').removeChild(del_user);
	} else
    if (user_status == 'saved') 
	{

	  user_markDeleted(user_id, mod_name, del_user)  
	}

	
  }
}


function restoreUser(user_id, user_name, mod_name, user_status)
{

  rest_id = userId(user_id, mod_name);
  removeUser(rest_id, true);

  addUserHtml(user_id, user_name, mod_name, 'saved');
}

function addUser(user_id, user_name, mod_name, allow_alert)
{
  user_status = userStatus(userId(user_id,mod_name));
  if (user_status == null)
  {
    
	addUserHtml(user_id, user_name, mod_name, 'new'); 	
  } else
  if (user_status == 'delete')
  {

	restoreUser(user_id, user_name, mod_name, 'new');		
  } else
  if (allow_alert)
  {

  	alert('User "' + user_from_html(user_name) + '" is already included.')
  }
}


function userStatus(id)
{
  user = document.getElementById(id);
  if (user)
    return document.getElementById('status_' + id).value; else
	return null;
}

function user_markDeleted(user_id, mod_name, element)
{
  user = document.createElement('div');
  //user_id = userId(user_id, mod_name); 

  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'users_ids[]';
  hidden.value = mod_name+ ':' +user_id; 
  user.appendChild(hidden);
  
  hidden = document.createElement('input');
  hidden.type = 'hidden';
  hidden.name = 'user_status[]';
  hidden.id = 'status_' + mod_name+user_id;
  hidden.value = 'delete'; 
  user.appendChild(hidden);

  document.getElementById(mod_name +'list').appendChild(user); // Löschmarkierung ins HTML einfügen
  document.getElementById(mod_name +'list').removeChild(element); // Element aus dem HTML löschen
}


function popup_return_user(popup_data)
{
  addUser(popup_data.name_to_value_array.user_id,
  popup_data.name_to_value_array.name,
  popup_data.passthru_data.module_name,
  true);
}


