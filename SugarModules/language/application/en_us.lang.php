 <?php
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2007 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

$app_list_strings["moduleList"]["oqc_ExternalContractCosts"] = 'ExternalContractCosts';
$app_list_strings["moduleList"]["oqc_ExternalContractDetailedCosts"] = 'ExternalContractDetailedCosts'; // 1.7.5 fixes bug in Roles table
$app_list_strings["moduleList"]["oqc_ExternalContractPositions"] = 'ExternalContractPositions';
$app_list_strings["moduleList"]["oqc_ExternalContract"] = 'External Contract';
$app_list_strings["moduleList"]["oqc_ArchivedExternalContract"] = 'Contract archive';
$app_list_strings["moduleList"]["oqc_Offering"] = 'Quotes';
$app_list_strings["moduleList"]["oqc_ServiceRecording"] = 'ServiceRecordings';
$app_list_strings["moduleList"]["oqc_Category"] = 'Categories';
$app_list_strings["moduleList"]["oqc_Product"] = 'Products';
$app_list_strings["moduleList"]["oqc_Contract"] = 'Contracts';
$app_list_strings["moduleList"]["oqc_Service"] = 'Services';
$app_list_strings["moduleList"]["oqc_EditedTextBlock"] = 'EditedTextBlocks';
$app_list_strings["moduleList"]["oqc_TextBlock"] = 'TextBlocks';
$app_list_strings["moduleList"]["oqc_Addition"] = 'Additions';
$app_list_strings["moduleList"]["oqc_ProductCatalog"] = 'ProductCatalog';
$app_list_strings["moduleList"]["oqc_Task"] = 'TeamTask';
$app_list_strings["oqc"]["months"] = array(
        1 => 'January',
        2 => 'February',
        3 => 'March', 
        4 => 'April',
        5 => 'May',
        6 => 'June', 
        7 => 'July', 
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',       
        12 => 'December'
);
$app_list_strings["oqc"]["common"]["new"] = "New";
$app_list_strings["oqc"]["common"]["cancel"] = "Cancel";
$app_list_strings["oqc"]["common"]["showReports"] = "Show Reports";
$app_list_strings["oqc"]["common"]["delete"] = "Delete";
$app_list_strings["oqc"]["common"]["select"] = "Select";
$app_list_strings["oqc"]["common"]["contract_number"] = "Contract Number";
$app_list_strings["oqc"]["common"]["name"] = "Name";
$app_list_strings["oqc"]["common"]["quantity"] = "Quantity";
$app_list_strings["oqc"]["common"]["price"] = "Price";
$app_list_strings["oqc"]["common"]["sum"] = "Sum";
$app_list_strings["oqc"]["common"]["description"] = "Description";
$app_list_strings["oqc"]["common"]["payment"] = "Payment";
$app_list_strings["oqc"]["common"]["year"] = "Year";
$app_list_strings["oqc"]["common"]["type"] = "Type";
$app_list_strings["oqc"]["common"]["in"] = "in";        	// following for lines are for the 
$app_list_strings["oqc"]["common"]["for"] = "for";		// 
$app_list_strings["oqc"]["common"]["until"] = "until";		// "sum in \euro 1.1.08 until 1.1.09 for 12 months" line
$app_list_strings["oqc"]["common"]["months"] = "month(s)";	// in the latex template

$app_list_strings["oqc"]["ExternalContracts"]["infinityHint"] = "<h2>Note</h2>You have selected <em>infinite</em> as the end of the contract. The contract will run until you cancel it. The cost tables show the expected costs for the next four years.";
$app_list_strings["oqc"]["Email"]["subject"] = "SugarCRM Ending Contracts Notification";
$app_list_strings["oqc"]["Email"]["hello"] = "Hello %s,<br /><br />\n\n";
$app_list_strings["oqc"]["Email"]["greetings"] = "<br />\nBest regards, SugarCRM :-)";
$app_list_strings["oqc"]["Email"]["introduction"] = "the following external contracts will run out soon:<br /><br />\n\n";
$app_list_strings["oqc"]["Email"]["notificationLine"] = "On %s ends \"%s\", <a href='%s'>see link</a>.<br />\n";
$app_list_strings["oqc"]["pdf"]["contract"]["title"] = "Contract";
$app_list_strings["oqc"]["pdf"]["contract"]["titleServices"] = "Services and Documentation";
$app_list_strings["oqc"]["pdf"]["contract"]["preamble"] = "Preamble"; // the preamble title 
$app_list_strings["oqc"]["pdf"]["contract"]["preambleText"] = "insert your preamble here"; // the actual preamble paragraph
$app_list_strings["oqc"]["pdf"]["contract"]["textblocksIntro"] = "Customer and company agree on the following rules."; // the text above the textblocks
$app_list_strings["oqc"]["pdf"]["contract"]["startDate"] = "Start Date";
$app_list_strings["oqc"]["pdf"]["contract"]["endDate"] = "End Date";
$app_list_strings["oqc"]["pdf"]["contract"]["deadline"] = "Deadline";
$app_list_strings["oqc"]["pdf"]["contract"]["periodOfNotice"] = "Period of notice";
$app_list_strings["oqc"]["pdf"]["contract"]["quote_title"] = "Quotation";
$app_list_strings["oqc"]["pdf"]["contract"]["addition_title"] = "Addition";

$app_list_strings["oqc"]["pdf"]["catalog"]["title"] = "Product Catalog";
$app_list_strings["oqc"]["pdf"]["catalog"]["publisherTitle"] = "Publisher";
$app_list_strings["oqc"]["pdf"]["catalog"]["services"] = "Products";
$app_list_strings["oqc"]["pdf"]["catalog"]["prices"] = "Prices";
$app_list_strings["oqc"]["pdf"]["catalog"]["price"] = "Price";
$app_list_strings["oqc"]["pdf"]["catalog"]["unit"] = "Unit/Recurrence";
$app_list_strings["oqc"]["pdf"]["catalog"]["position"] = "Position";
$app_list_strings["oqc"]["pdf"]["catalog"]["validityTitle"] = "Validity";
$app_list_strings["oqc"]["pdf"]["catalog"]["imageAppendixTitle"] = "Image Appendix";
$app_list_strings["oqc"]["pdf"]["catalog"]["contactTitle"] = "Your Contact";

$app_list_strings["oqc"]["pdf"]["common"]["filenamePrefixCatalog"] = "Catalog";
$app_list_strings["oqc"]["pdf"]["common"]["seeFigure"] = "see figure";
$app_list_strings["oqc"]["pdf"]["common"]["onPage"] = "on page";
$app_list_strings["oqc"]["pdf"]["common"]["createdOn"] = "Created on";
$app_list_strings["oqc"]["pdf"]["common"]["customer"] = "Customer"; // your customer
$app_list_strings["oqc"]["pdf"]["common"]["company"] = "Company"; // your company
$app_list_strings["oqc"]["Services"]["selectImage"] = "Select another file to replace the current image:";
$app_list_strings["oqc"]["Services"]["currentImage"] = "Current image";
$app_list_strings["oqc"]["Services"]["unit"] = "Unit";
$app_list_strings["oqc"]["Services"]["description"] = "Description";
$app_list_strings["oqc"]["Services"]["name"] = "Name";
$app_list_strings["oqc"]["Services"]["quantity"] = "Quantity";
$app_list_strings["oqc"]["Services"]["price"] = "List price";
$app_list_strings["oqc"]["Services"]["discount"] = "Discount";
$app_list_strings["oqc"]["Services"]["discountPrice"] = "Price";
$app_list_strings["oqc"]["Services"]["vat"] = "VAT";
$app_list_strings["oqc"]["Services"]["vat_default"] = "Default VAT value";
$app_list_strings["oqc"]["Services"]["vat_legacy"] = "Legacy VAT value";
$app_list_strings["oqc"]["Services"]["oqc_position"] = "NO";
$app_list_strings["oqc"]["Services"]["sum"] = "Sum";
$app_list_strings["oqc"]["Services"]["gross"] = "Gross";
$app_list_strings["oqc"]["Services"]["net"] = "Net";
$app_list_strings["oqc"]["Services"]["netTotal"] = "Net Total:";
$app_list_strings["oqc"]["Services"]["grandTotal"] = "Grand Total:";
$app_list_strings["oqc"]["Services"]["onceTableTitle"] = "Products List";
$app_list_strings["oqc"]["Services"]["ongoingTableTitle"] = "Reccuring Expenses List";
$app_list_strings["oqc"]["Services"]["defaultDescription"] = "Product description";
$app_list_strings["oqc"]["Services"]["totalNegotiatedPrice"] = "Total negotiated price";
$app_list_strings["oqc"]["Services"]["add"] = "Add Standard Product";
$app_list_strings["oqc"]["Services"]["addRecurring"] = "Add Reccuring Expenses";
$app_list_strings["oqc"]["Services"]["addCustom"] = "Add Custom Product";
$app_list_strings["oqc"]["Services"]["addCustomService"] = "Add Custom Expense";
$app_list_strings["oqc"]["Services"]["addDefaultLines"] = "Add Default Items";
$app_list_strings["oqc"]["Services"]["delete"] = "Delete";
$app_list_strings["oqc"]["Services"]["cst_delete"] = "Delete";
$app_list_strings["oqc"]["Services"]["updatedVersionAvailable"] = "updateable";
$app_list_strings["oqc"]["Services"]["updateAll"] = "Update All";
$app_list_strings["oqc"]["Services"]["from"] = "from";
$app_list_strings["oqc"]["Services"]["to"] = "to";
$app_list_strings["oqc"]["Services"]["confirmDelete"] = "Do you really want to delete this product?";
$app_list_strings["oqc"]["Services"]["confirmUpdate"] = "Do you really want to update this product?";
$app_list_strings["oqc"]["Services"]["confirmUpdateAll"] = "Do you really want to update all products?";
$app_list_strings["oqc"]["Services"]["months"] = "month(s)";
$app_list_strings["oqc"]["Services"]["ongoingSum"] = "Sum for a period of %d months (from %s to %s)";
$app_list_strings["oqc"]["Services"]["discountUnits"] = "%or$";
$app_list_strings["oqc"]["Services"]["updateProduct"] = "Yes";
$app_list_strings["oqc"]["Services"]["donotupdateProduct"] = "No";
$app_list_strings["oqc"]["Services"]["update"] = "Update";
$app_list_strings["oqc"]["Services"]["addOption"] = "Add Option";
$app_list_strings["oqc"]["Services"]["action"] = "Action";
$app_list_strings["oqc"]["Services"]["imageHint"] = "The images displayed will be resized to 700 px width (requires GD extension to be installed) <br>Supported image types are .jpg, .png, .gif";
$app_list_strings["oqc"]["Services"]["update_file_confirm"] = "Update Product Technical Description file: ";
$app_list_strings["oqc"]["Services"]["zeitbezug"] = "Recurrence";
$app_list_strings["oqc"]["Documents"]["fileSelectionHint"] = "<small>You select files from %s.</small>";
$app_list_strings["oqc"]["Documents"]["popupTitle"] = "Please select a file";
$app_list_strings["oqc"]["Documents"]["title"] = '<h1 style="margin-bottom: 10px;">Please select a file:</h1>';
$app_list_strings["oqc"]["Documents"]["fileNotExists"] = '<span style="margin-left: 5px; color:red; font-weight: bold;">The file does not exist.</span>';
$app_list_strings["oqc"]["Textblocks"]["delete"] = "Delete";
$app_list_strings["oqc"]["Textblocks"]["freeText"] = "Enter Your text here:";
$app_list_strings["oqc"]["Textblocks"]["addTemplate"] = "Add Template";
$app_list_strings["oqc"]["Textblocks"]["addDefaultTemplates"] = "Add Default Templates";
$app_list_strings["oqc"]["Textblocks"]["dragdrop"] = "Use header for Drag&Drop";
$app_list_strings["oqc"]["Attachments"]["add"] = "Add Attachment";
$app_list_strings["oqc"]["Attachments"]["addDefault"] = "Add Default Attachment(s)";
$app_list_strings["oqc"]["Attachments"]["createNew"] = "Create New Attachment";
$app_list_strings["oqc"]["Attachments"]["delete"] = "Delete";
$app_list_strings["oqc"]["Attachments"]["default"] = "default";
$app_list_strings["oqc"]["Attachments"]["upload"] = "Upload New Revision";
$app_list_strings["oqc"]["ProductCatalog"]["addCategory"] = "Add";
$app_list_strings["oqc"]["ProductCatalog"]["saveCategory"] = "Save";
$app_list_strings["oqc"]["ProductCatalog"]["deleteCategory"] = "Delete";
$app_list_strings["oqc"]["ProductCatalog"]["categoryTree"] = "Categories Tree"; //1.7.5 addition
$app_list_strings["oqc"]["ProductCatalog"]["confirmDelete"] = "Do you want to delete the selected category with all its products and subcategories?";
$app_list_strings["oqc"]["ProductCatalog"]["navigationHint"] = "- Your changes are automatically saved.<br />- Use the arrow keys to navigate over the categories.<br />- Press F2 to edit the selected category.<br />";
$app_list_strings["oqc"]["ProductOptions"]["add"] = "Add Option";
$app_list_strings["oqc"]["ProductOptions"]["createNew"] = "Create New Attachment";
$app_list_strings["oqc"]["ProductOptions"]["delete"] = "Delete";

$app_list_strings["oqc_externalcontract_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Product',
  'User' => 'User',
);
$app_list_strings["oqc_externalcontract_status_dom"] = array (
  'New' => 'New',
  'Assigned' => 'Assigned',
  'Closed' => 'Closed',
  'Pending Input' => 'Pending Input',
  'Rejected' => 'Rejected',
  'Duplicate' => 'Duplicate',
);
$app_list_strings["oqc_externalcontract_priority_dom"] = array (
  'P1' => 'High',
  'P2' => 'Medium',
  'P3' => 'Low',
);
$app_list_strings["oqc_externalcontract_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepted',
  'Duplicate' => 'Duplicate',
  'Closed' => 'Closed',
  'Out of Date' => 'Out of Date',
  'Invalid' => 'Invalid',
);


$app_list_strings["oqc_productcatalog_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Product',
  'User' => 'User',
);
$app_list_strings["oqc_productcatalog_status_dom"] = array (
  'New' => 'New',
  'Assigned' => 'Assigned',
  'Closed' => 'Closed',
  'Pending Input' => 'Pending Input',
  'Rejected' => 'Rejected',
  'Duplicate' => 'Duplicate',
);
$app_list_strings["oqc_productcatalog_priority_dom"] = array (
  'P1' => 'High',
  'P2' => 'Medium',
  'P3' => 'Low',
);
$app_list_strings["oqc_productcatalog_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepted',
  'Duplicate' => 'Duplicate',
  'Closed' => 'Closed',
  'Out of Date' => 'Out of Date',
  'Invalid' => 'Invalid',
);

$app_list_strings["oqc_product_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Product',
  'User' => 'User',
);
$app_list_strings["oqc_product_status_list"] = array (
  'New' => 'New',
  'Assigned' => 'Assigned',
  'Closed' => 'Closed',
  'Pending Input' => 'Pending Input',
  'Rejected' => 'Rejected',
  'Duplicate' => 'Duplicate',
  'Default' => 'Default',
);
$app_list_strings["oqc_product_priority_dom"] = array (
  'P1' => 'High',
  'P2' => 'Medium',
  'P3' => 'Low',
);
$app_list_strings["oqc_product_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepted',
  'Duplicate' => 'Duplicate',
  'Closed' => 'Closed',
  'Out of Date' => 'Out of Date',
  'Invalid' => 'Invalid',
);
$app_list_strings["oqc_contract_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Product',
  'User' => 'User',
);
$app_list_strings["oqc_addition_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Product',
  'User' => 'User',
);
$app_list_strings["oqc_offering_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Product',
  'User' => 'User',
);
$app_list_strings["oqc_contract_status_dom"] = array (
  'Draft' => 'Draft',
  'Sent' => 'Sent',
  'Signed' => 'Signed',
  'Completed' => 'Completed',
);
$app_list_strings["oqc_offering_status_dom"] = array (
  'Draft' => 'Draft',
  'Sent' => 'Sent',
  'Accepted' => 'Accepted',
);
$app_list_strings["oqc_contract_priority_dom"] = array (
  'P1' => 'High',
  'P2' => 'Medium',
  'P3' => 'Low',
);
$app_list_strings["oqc_offering_priority_dom"] = array (
  'P1' => 'High',
  'P2' => 'Medium',
  'P3' => 'Low',
);
$app_list_strings["oqc_addition_priority_dom"] = array (
  'P1' => 'High',
  'P2' => 'Medium',
  'P3' => 'Low',
);
$app_list_strings["oqc_addition_status_dom"] = array (
  'New' => 'New',
  'Assigned' => 'Assigned',
  'Closed' => 'Closed',
  'Pending Input' => 'Pending Input',
  'Rejected' => 'Rejected',
  'Duplicate' => 'Duplicate',
);
$app_list_strings["oqc_contract_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepted',
  'Duplicate' => 'Duplicate',
  'Closed' => 'Closed',
  'Out of Date' => 'Out of Date',
  'Invalid' => 'Invalid',
);
$app_list_strings["oqc_offering_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepted',
  'Duplicate' => 'Duplicate',
  'Closed' => 'Closed',
  'Out of Date' => 'Out of Date',
  'Invalid' => 'Invalid',
);
$app_list_strings["oqc_addition_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepted',
  'Duplicate' => 'Duplicate',
  'Closed' => 'Closed',
  'Out of Date' => 'Out of Date',
  'Invalid' => 'Invalid',
);
$app_list_strings["unit_list"] = array (
  'pieces' => 'pieces',
  'hours' => 'hours',
  'kg' => 'kg',
  'm' => 'm',
);
$app_list_strings["discount_select_list"] = array (
  'rel' => '%',
  'abs' => 'abs',
);
$app_list_strings["contract_abbreviation_list"] = array (
  'Cnt' => 'Cnt',
  'ExCnt' => 'ExCnt',
  'InCnt' => 'InCnt',
);
$app_list_strings["quote_abbreviation_list"] = array (
  'Qt' => 'Qt',
  'ExQt' => 'ExQt',
  'InQt' => 'InQt',
 );
$app_list_strings["addition_abbreviation_list"] = array (
  'Ad' => 'Ad',
  'ExAd' => 'ExAd',
  'InAd' => 'InAd',
 );

$app_list_strings["externalcontractsabbreviation_list"] = array (
  'VW-IT' => 'VW-IT',
  'VW-SO' => 'VW-SO',
);
$app_list_strings["zeitbezug_list"] = array (
  'once' => 'once',
  'monthly' => 'monthly',
  'annually' => 'annually',
);
$app_list_strings["periodofnotice_list"] = array (
  '6months' => 'six months',
  '3months' => 'three months',
  '1month' => 'one month',
);
$app_list_strings["externalcontracttype_list"] = array (
  'EVB-IT System' => 'IT system',
  'EVB-IT Kaufvertrag (Langfassung)' => 'IT contarct extended version',
  'EVB-IT Kaufvertrag (Kurzfassung)' => 'IT contract summary',
  'EVB-IT Dienstleistungsvertrag' => 'IT services contarct',
  'EVB-IT Überlassungsvertrag Typ A (Langfassung)' => 'IT employment contract extended version',
  'EVB-IT Überlassungsvertrag Typ A (Kurzfassung)' => 'IT employment contract summary',
  'individuell' => 'Personal',
);
$app_list_strings["externalcontractmatter_list"] = array (
  'software' => 'Software',
  'hardware' => 'Hardware',
  'furniture' => 'Furniture',
  'service' => 'Service',
  'innerservice' => 'Internal',
  'other' => 'Other',
);
$app_list_strings["ownershipsituation_list"] = array (
  'Handelsware' => 'Commodity',
  'Eigentum' => 'Property',
);
$app_list_strings["contractservicetype_list"] = array (
  'Beratung' => 'Consulting',
  'Projektleitungsunterstützung' => 'Project Management',
  'Schulung' => 'Training',
  'Einführungsunterstützung' => 'Product Installation',
  'Betreiberleistungen' => 'Warranty repair',
  'Benutzerunterstützungsleistungen' => 'Non-warranty repair',
  'sonstige Dienstleistung' => 'Other',
);
$app_list_strings["contractpaymentterms_list"] = array (
  'leer' => 'leer',
  'monatlich' => 'monthly',
  'quartalsweise' => 'quarterly',
  'halbjährlich' => 'half-yearly',
  'jährlich' => 'yearly',
  'einmalig' => 'once',
  'sonstige' => 'other',
);
$app_list_strings["agreementtype_list"] = array (
  'Kauf' => 'Purchase',
  'Miete' => 'Rent',
  'Leasing' => 'Leasing',
  'Wartung' => 'Maintenance',
  'Pflege' => 'Care',
);
$app_list_strings["endperiod_list"] = array (
  '3months' => '3 Months',
  '6months' => '6 Months',
  '9months' => '9 Months',
  '12months' => '12 Months',
  '24months' => '24 Months',
  '36months' => '36 Months',
  '48months' => '48 Months',
  'infinite' => 'infinite',
  'other' => 'other',
);
$app_list_strings["paymentinterval_list"] = array (
  'monthly' => 'monthly',
  'quarterly' => 'quarterly',
  'halfyearly' => 'half-yearly',
  'annually' => 'annually',
  'once' => 'once',
  'other' => 'other',
);
$app_list_strings["publish_state_list"] = array (
  'unknown' => '',
  'pending' => 'Pending',
  'published' => 'Published',
);
//1.7.6 modifications
$app_list_strings['document_category_dom']= array (
	'General' => 'General',
	'Addition' => 'Addition',
	'Contract' => 'Contract',
	'Product' => 'Product',
	'ProductCatalog' => 'Product Catalog',
	'Quote' => 'Quote',
	'ExternalContract' => 'External Contract',
	'' => '',
	);
$app_list_strings['document_subcategory_dom']= array (
	'Document' => 'Document',
	'Attachment' => 'Attachment',
	'Brochure' => 'Brochure',
	'Drawing' => 'Drawing',
	'Pdf' => 'Pdf',
	'Picture' => 'Picture',
	'Technical' => 'Technical description',
	'' => '',
	);	

//1.7.5 addition
$app_list_strings["document_purpose_list"] = array (
  'Internal' => 'For Internal Use',
  'Catalog' => 'For Product Catalog',
  'Customer' => 'For Customer',
  'Distributor' => 'For Distributor',
  '' => '',
);
$app_list_strings["shipment_terms_list"] = array (
  'Default' => '',
  'EXW' => 'EXW',
  'FCA' => 'FCA',
  'CPT' => 'CPT',
  'CIP' => 'CIP',
  'DDU' => 'DDU',
  'DDP' => 'DDP',
);
$app_list_strings["oqc_vat_list"] = array (
  'default' => '19%',
  '0.0' => '0%',
  '0.05' => '5%',
  '0.12' => '12%',
);
$app_list_strings["oqc_templates_list"] = array (
  'Contract' => 'Contract',
  'Offering' => 'Quote',
  'Offering2' => 'Quote new',
  'Addition' => 'Addition',
);
$app_list_strings["oqc_catalog_templates_list"] = array (
  'ProductCatalog' => 'ProductCatalog',
  'ProductCatalog2' => 'Descriptions only',
  'ProductCatalog3' => 'Pricelist only',
  'ProductCatalog4' => 'Reserved',
);

$app_list_strings["oqc_task_status_list"] = array (
    'Not Started' => 'Not Started',
    'In Progress' => 'In Progress',
    'Completed' => 'Completed',
    'Pending Input' => 'Pending Input',
    'Deferred' => 'Deferred',
);

$app_list_strings["oqc_task_user_status_list"] = array (
    'Not Started' => 'Not Started',
    'In Progress' => 'In Progress',
    'Completed' => 'Completed',
);

$app_list_strings["oqc_task_resolution_list"] = array (
    'None' => 'None',
    'Accepted' => 'Approved',
    'Corrected' => 'Approved with corrections',
    'Rejected' => 'Rejected',
    'Duplicate' => 'Duplicate',
    'Out of Date' => 'Out of Date',
    'Invalid' => 'Not applicable',
    'Other' => 'Other',
);

$app_list_strings["oqc_task_priority_list"] = array (
        'High' => 'High',
        'Medium' => 'Medium',
        'Low' => 'Low',
);

$app_list_strings["record_type_display_notes"]["oqc_Task"] =  'TeamTask';
    

$app_list_strings["oqc_parent_type_display_list"] = array (
    'oqc_Product' => 'Product',
    'oqc_Offering' => 'Quote',
    'oqc_Contract' => 'Contract',
    'oqc_Addition' => 'Addition',
    'oqc_Task' => 'TeamTask',
    'oqc_ProductCatalog' => 'Product Catalog',
);

$app_list_strings["oqc_task_finished_list"] = array (
        'InProgress' => 'No',
        'Finished' => 'Yes',
);

$app_list_strings["oqc_task_accepted_list"] = array (
        'notAccepted' => 'Not Accepted',
        'accepted' => 'Accepted',
        'decline' => 'Declined',
);
$app_list_strings["oqc_task_abbreviation_list"] = array (
  'Tsk' => 'Tsk',
  'Apr' => 'Apr',
  'Sgn' => 'Sgn',
 );
$app_list_strings["oqc_reminder_interval_options"] = array (
    '-2' => 'once',
    '1' => 'once a day',
    '3' => 'once in 3 days',
    '7' => 'once a week',
);
$app_strings['LBL_OQC_PRODUCT_DELETE'] = 'This product is no longer available';
$app_strings['LBL_OQC_PRODUCT_INACTIVE'] = 'This product is not active';
$app_strings['LBL_NO_RECORDS_MESSAGE'] = 'No Products found';
$app_strings['LBL_DATA_ERROR_MESSAGE'] = 'Data Error';
$app_strings['LBL_LOADING_MESSAGE'] = 'Loading...';
 
//Some default settings DO NOT TRANSLATE!
$app_list_strings['oqc_dropdowns_default']['oqc_parent_type_default_key'] = 'oqc_Task';
$app_list_strings['oqc_dropdowns_default']['oqc_priority_default_key'] = 'Medium';
$app_list_strings['oqc_dropdowns_default']['oqc_remind_default_key'] = '1';



?>


