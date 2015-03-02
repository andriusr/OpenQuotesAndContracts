<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('include/utils.php');
require_once('modules/Documents/Document.php');
require_once('modules/DocumentRevisions/DocumentRevision.php');


function downloadLink($id)
{
	//return 'download.php?id=' . $id . '&type=Documents'; // Sugar 5.0
	return 'index.php?entryPoint=download&id=' . $id . '&type=Documents'; // Sugar 5.2
}

function buildAttachmentsArray($attachments)
{
	$attachment_array = array();
	foreach ($attachments as $attachment) 
	{
      if ($attachment->category_id == 'ContractAttachment')
      {
		$is_default = 1;
      } else
      {
		$is_default = 0;      	
      }
	  	$rev_number = $attachment->revision ? ('_rev.' . $attachment->revision) : '';
	  	$rev_id = $attachment->doc_rev_id ? $attachment->doc_rev_id : $attachment->document_revision_id;
      $attachment_array[] = array('document_name' => from_html($attachment->document_name).$rev_number,
	                              'document_revision_id' => $rev_id,
	                              'file_url' => downloadLink($rev_id),
      					//		  'revision' => $attachment->revision,
	                              'id' => $attachment->id,
	                              'is_default' => $is_default,
	  );	
	}
	
	return $attachment_array;
}

function get_all_linked_attachments($attachmentsequence) {
	$attachmentIds = explode(' ', trim($attachmentsequence));
	$attachments = array();

	foreach ($attachmentIds as $id) {
		$attachment = new Document();

		if ($attachment->retrieve($id)) {
			$attachments[] = $attachment;
		}
	}

	return $attachments;
}

function get_all_linked_attachment_revisions($attachmentsequence) {
	$attachmentIds = explode(' ', trim($attachmentsequence));
	$attachments = array();

	foreach ($attachmentIds as $id) {
		$revision = new DocumentRevision();
		if (!$revision->retrieve($id)) {
		// if in old format try to recover by document id	
			
		$attachment = new Document();

		if ($attachment->retrieve($id)) {
			$attachment->revision = '';
			$attachment->doc_rev_id = '';
			$attachments[] = $attachment;
		}
		} else {
			$attachment = new Document();
			if ($attachment->retrieve($revision->document_id)) {
			$attachment->revision = $revision->revision;
			$attachment->doc_rev_id = $revision->id;
			$attachments[] = $attachment;
		}
			
			}
	}

	return $attachments;
}



function getAttachmentsHtml($focus, $name, $value, $view) 
{
    if ('EditView' != $view && 'DetailView' != $view) {
        return ""; // skip the rest of the method if another view calls this method
    }

    global $app_list_strings;
    
	$smarty = new Sugar_Smarty;

	if (isset($focus->attachmentsequence)) {
	$c = get_all_linked_attachment_revisions($focus->attachmentsequence);   
	// smarty mit Werten befüllen 
	$smarty->assign('attachments', buildAttachmentsArray($c));
	} else { $smarty->assign('attachments', array()); }
		
	
	// setup the popup link
	$popup_request_data = array(
			'call_back_function' => 'popup_return_document',
	'field_to_name_array' => array(
				"id" => "document_id",
				"document_name" => "document_name",
				"document_revision_id" => "document_revision_id",
				"category_id" => "document_category_id",
				"revision" => "revision",
	        ),
			'passthru_data' => array(
	          'default_category' => $app_list_strings['document_subcategory_dom'][''],
	        )
		);
	$revision_request_data = array(
	//		'call_back_function' => 'poptest', // 'popup_return_document',
			'call_back_function' => 'revision_return_document',
	'field_to_name_array' => array(
				"id" => "document_id",
				"document_name" => "document_name",
				"document_revision_id" => "document_revision_id",
				"category_id" => "document_category_id",
				"revision" => "revision",
	        ),
			'passthru_data' => array(
	          'default_category' => $app_list_strings['document_subcategory_dom'][''],
	        )
		);	
	$json = getJSONobj();
	$encoded_request_data = $json->encode($popup_request_data);
	$encoded_revision_request_data = $json->encode($revision_request_data);
	$languageStrings = $json->encode($app_list_strings["oqc"]["Attachments"]);

	$smarty->assign('moduleName', getCurrentModuleName());
	$smarty->assign('languageStringsAttachments', $languageStrings);
	$smarty->assign('open_popup_encoded_request_data', $encoded_request_data);
	$smarty->assign('create_popup_encoded_request_data', $encoded_request_data);
	$smarty->assign('upload_revision_encoded_request_data', $encoded_revision_request_data);	
	$smarty->assign('initialFilter', "\"&deleted=0\""); // Todo: Hier nur Dokumente zulassen, die für Vertragsanhänge erlaubt sind	

	return $smarty->fetch('include/oqc/Attachments/' . $view . '.html');    
}
 
?>
