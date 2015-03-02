<?php
require_once('include/MVC/View/views/view.popup.php');
require_once('modules/oqc_ProductCatalog/oqc_ProductCatalog.php');
require_once('include/SearchForm/SearchForm2.php');
require_once('modules/oqc_Product/oqc_Product.php');
require_once('include/Popups/PopupSmarty.php');

class ProductSearchForm extends SearchForm {
	var $__where;
	
	function ProductSearchForm($seed, $module, $action = 'index', $where=array()) {
		parent::SearchForm($seed, $module, $action);
		$this->__where = $where;
		
	}
	
	function generateSearchWhere($add_custom_fields = false, $module='') {
		$a = parent::generateSearchWhere($add_custom_fields, $module);
		
	//	$GLOBALS['log']->error('Popup where clauses: '. var_export(array_merge($a, $this->__where),true));	
		return array_merge($a, $this->__where);
    }
  
}

class oqc_ProductPopupSmarty extends PopupSmarty {
	
	
	function oqc_ProductPopupSmarty($seed, $module) {
		parent::PopupSmarty($seed, $module);
	}
	//2.2RC1 This is copy of display() from PopupSmarty class, with override of header template with removal of clear button and from modification. Clear button causes issues in oqcProduct popups since it allows to view records that are not intended to be displayed
	
	function display($end = true, $oqcFormFields) {
        global $app_strings;
              
        if(!is_file($GLOBALS['sugar_config']['cache_dir'] . 'jsLanguage/' . $GLOBALS['current_language'] . '.js')) {
            require_once('include/language/jsLanguage.php');
            jsLanguage::createAppStringsCache($GLOBALS['current_language']);
        }
        $jsLang = '<script type="text/javascript" src="' . $GLOBALS['sugar_config']['cache_dir'] . 'jsLanguage/' . $GLOBALS['current_language'] . '.js?s=' . $GLOBALS['sugar_version'] . '&c=' . $GLOBALS['sugar_config']['js_custom_version'] . '&j=' . $GLOBALS['sugar_config']['js_lang_version'] . '"></script>';
        
        $this->th->ss->assign('data', $this->data['data']);
		$this->data['pageData']['offsets']['lastOffsetOnPage'] = $this->data['pageData']['offsets']['current'] + count($this->data['data']);
		$this->th->ss->assign('pageData', $this->data['pageData']);
        
        $navStrings = array('next' => $GLOBALS['app_strings']['LNK_LIST_NEXT'],
                            'previous' => $GLOBALS['app_strings']['LNK_LIST_PREVIOUS'],
                            'end' => $GLOBALS['app_strings']['LNK_LIST_END'],
                            'start' => $GLOBALS['app_strings']['LNK_LIST_START'],
                            'of' => $GLOBALS['app_strings']['LBL_LIST_OF']);
        $this->th->ss->assign('navStrings', $navStrings);
		
		//OQC 2.2RC1 assign variables for searchform 
		foreach($oqcFormFields as $field=>$value) {
			$this->th->ss->assign($field, $value);
			
		}	 
		// End of modification
		
		
		$associated_row_data = array();
		
		//C.L. - Bug 44324 - Override the NAME entry to not display salutation so that the data returned from the popup can be searched on correctly
		$searchNameOverride = !empty($this->seed) && $this->seed instanceof Person && (isset($this->data['data'][0]['FIRST_NAME']) && isset($this->data['data'][0]['LAST_NAME'])) ? true : false;
		
		global $locale;
		foreach($this->data['data'] as $val)
		{
			$associated_row_data[$val['ID']] = $val;
			if($searchNameOverride)
			{
			   $associated_row_data[$val['ID']]['NAME'] = $locale->getLocaleFormattedName($val['FIRST_NAME'], $val['LAST_NAME']);
			}
		}
		$is_show_fullname = showFullName() ? 1 : 0;
		$json = getJSONobj();
		$this->th->ss->assign('jsLang', $jsLang);
		$this->th->ss->assign('lang', substr($GLOBALS['current_language'], 0, 2));
		//2.2RC1 custom header
		$this->th->ss->assign('headerTpl', 'modules/oqc_Product/views/header62.tpl');
		//End of modification
        $this->th->ss->assign('footerTpl', 'include/Popups/tpls/footer.tpl');
        $this->th->ss->assign('ASSOCIATED_JAVASCRIPT_DATA', 'var associated_javascript_data = '.$json->encode($associated_row_data). '; var is_show_fullname = '.$is_show_fullname.';');
		$this->th->ss->assign('module', $this->seed->module_dir);
		$request_data = empty($_REQUEST['request_data']) ? '' : $_REQUEST['request_data'];
		$this->th->ss->assign('request_data', $request_data);
		$this->th->ss->assign('fields', $this->fieldDefs);
		$this->th->ss->assign('formData', $this->formData);
		$this->th->ss->assign('APP', $GLOBALS['app_strings']);
		$this->th->ss->assign('MOD', $GLOBALS['mod_strings']);
		$this->th->ss->assign('popupMeta', $this->_popupMeta);
        $this->th->ss->assign('current_query', base64_encode(serialize($_REQUEST)));
		$this->th->ss->assign('customFields', $this->customFieldDefs);
		$this->th->ss->assign('numCols', NUM_COLS);
		$this->th->ss->assign('massUpdateData', $this->massUpdateData);
		$this->th->ss->assign('jsCustomVersion', $GLOBALS['sugar_config']['js_custom_version']);
		$this->th->ss->assign('sugarVersion', $GLOBALS['sugar_version']);
        $this->th->ss->assign('should_process', $this->should_process);
		
		if($this->_create){
			$this->th->ss->assign('ADDFORM', $this->getQuickCreate());//$this->_getAddForm());
			$this->th->ss->assign('ADDFORMHEADER', $this->_getAddFormHeader());
			$this->th->ss->assign('object_name', $this->seed->object_name);
		}
		$this->th->ss->assign('LIST_HEADER', get_form_header($GLOBALS['mod_strings']['LBL_LIST_FORM_TITLE'], '', false));
		$this->th->ss->assign('SEARCH_FORM_HEADER', get_form_header($GLOBALS['mod_strings']['LBL_SEARCH_FORM_TITLE'], '', false));
		$str = $this->th->displayTemplate($this->seed->module_dir, $this->view, $this->tpl);
		return $str;
	}
   
 	
}


class oqc_ProductViewPopup extends ViewPopup {
	function oqc_ProductViewPopup() {
		
		/* not needed anymore because products are now global
		$_REQUEST['catalog_id_advanced'] = oqc_ProductCatalog::activeCatalogId();
		$_REQUEST['query'] = 'true';
		*/
		
		parent::ViewPopup();
	}
	
	function display() {
		// this is a copy of ViewPopup::display() except the marked region at the bottom. have fun reading it :)
		//////////////////////////////////////////////////////////////////////////////////////////////////
		
		global $popupMeta, $mod_strings, $sugar_version;
		if(isset($_REQUEST['metadata']) && strpos($_REQUEST['metadata'], "..") !== false)
			die("Directory navigation attack denied.");
		if(!empty($_REQUEST['metadata']) && $_REQUEST['metadata'] != 'undefined' && file_exists('modules/' . $this->module . '/metadata/' . $_REQUEST['metadata'] . '.php')) // if custom metadata is requested
			require_once('modules/' . $this->module . '/metadata/' . $_REQUEST['metadata'] . '.php');
		elseif(file_exists('custom/modules/' . $this->module . '/metadata/popupdefs.php'))
	    	require_once('custom/modules/' . $this->module . '/metadata/popupdefs.php');
	    elseif(file_exists('modules/' . $this->module . '/metadata/popupdefs.php'))
	    	require_once('modules/' . $this->module . '/metadata/popupdefs.php');	
	    
	    if(!empty($popupMeta) && !empty($popupMeta['listviewdefs'])){
	    	if(is_array($popupMeta['listviewdefs'])){
	    		//if we have an array, then we are not going to include a file, but rather the 
	    		//listviewdefs will be defined directly in the popupdefs file
	    		$listViewDefs[$this->module] = $popupMeta['listviewdefs'];
	    	}else{
	    		//otherwise include the file
	    		require_once($popupMeta['listviewdefs']);
	    	}
	    }elseif(file_exists('custom/modules/' . $this->module . '/metadata/listviewdefs.php')){
			require_once('custom/modules/' . $this->module . '/metadata/listviewdefs.php');
		}elseif(file_exists('modules/' . $this->module . '/metadata/listviewdefs.php')){
			require_once('modules/' . $this->module . '/metadata/listviewdefs.php');
		}
		
		//check for searchdefs as well
		if(!empty($popupMeta) && !empty($popupMeta['searchdefs'])){
	    	if(is_array($popupMeta['searchdefs'])){
	    		//if we have an array, then we are not going to include a file, but rather the 
	    		//searchdefs will be defined directly in the popupdefs file
	    		$searchdefs[$this->module]['layout']['advanced_search'] = $popupMeta['searchdefs'];
	    	}else{
	    		//otherwise include the file
	    		require_once($popupMeta['searchdefs']);
	    	}
	    }else if(empty($searchdefs) && file_exists('modules/'.$this->module.'/metadata/searchdefs.php'))
	    	require_once('modules/'.$this->module.'/metadata/searchdefs.php');
		
        if(!empty($this->bean) && isset($_REQUEST[$this->module.'2_'.strtoupper($this->bean->object_name).'_offset'])) {//if you click the pagination button, it will poplate the search criteria here
            if(!empty($_REQUEST['current_query_by_page'])) {
                $blockVariables = array('mass', 'uid', 'massupdate', 'delete', 'merge', 'selectCount', 'lvso', 'sortOrder', 'orderBy', 'request_data', 'current_query_by_page');
                $current_query_by_page = unserialize(base64_decode($_REQUEST['current_query_by_page']));
                foreach($current_query_by_page as $search_key=>$search_value) {
                    if($search_key != $this->module.'2_'.strtoupper($this->bean->object_name).'_offset' && !in_array($search_key, $blockVariables)) {
                        $_REQUEST[$search_key] = $search_value;
                    }
                }
            }
        }
        
		if(!empty($listViewDefs) && !empty($searchdefs)){
	//		require_once('include/Popups/PopupSmarty.php');
			$displayColumns = array();
			$filter_fields = array();
			$whereClauses = array();
			$initialFilterClauses = array();
			$popup = new oqc_ProductPopupSmarty($this->bean, $this->module);
			
			
			// exclude product with given id and products that contain other products (packages)
			//////////////////////////////////////////////////////////////////////////////////////////////////
			$formFields = array();
			if (isset($_REQUEST['not_this_product_id']) && !empty($_REQUEST['not_this_product_id'])) {
				$formFields['not_this_product_id'] = $_REQUEST['not_this_product_id'];
				$whereClauses = array(
					$this->bean->table_name.".id != '{$_REQUEST['not_this_product_id']}'",
					$this->bean->table_name.".active != '0'",
					$this->bean->table_name.".is_latest != '0'",
					 //1.7.5 and 1.7.6 show only active and latest revision products in ProductPopup
				);
				
			}
			else { 
					$formFields['not_this_product_id'] = '';
					$whereClauses = array(
					$this->bean->table_name.".active != '0'",
					$this->bean->table_name.".is_latest != '0'", //1.7.5 show only active and latest revision products in ProductPopup
				);
			}
			if (isset($_REQUEST['is_option']) && $_REQUEST['is_option'] != '')	{
				$formFields['is_option'] = $_REQUEST['is_option'];
				//if isset product_id found all options that are associated with this product 2.0
				if (isset($_REQUEST['product_id']) && !empty($_REQUEST['product_id'])) {
					$product = new oqc_Product();
					if ($product->retrieve($_REQUEST['product_id'])) {
						$formFields['product_id'] = $_REQUEST['product_id'];
						if (!empty($product->optionssequence)){
							$optionsIds = explode(' ', $product->optionssequence);
	               	$productClauses = array();
							foreach ($optionsIds as $optionId) {
		//						$option = new oqc_Product();
                        $latestOptionId = $product->getLatestRevisionFromId($optionId);
								$productClauses[] = $this->bean->table_name.".id = '{$latestOptionId}'";
							}
						$productClause = implode(' or ', $productClauses);
						$whereClauses[] = '('.$productClause.')';
						} else {
							$whereClauses[] = $this->bean->table_name.".id = ''";	
							}
					} else {
						$whereClauses[] = $this->bean->table_name.".id = ''";	
						}
					}
				$whereClauses[] = $this->bean->table_name.".is_option = '{$_REQUEST['is_option']}'";
				
			}   else {
				// 2.0 If user push Clear button then no Products will be displayed ! Its is real Clear Button! :-)	
//				$whereClauses[] = $this->bean->table_name.".id = ''";	
				$whereClauses[] = $this->bean->table_name.".is_option = '0'";
				$formFields['is_option'] = 0;	
			} 
			if (isset($_REQUEST['is_recurring']) && $_REQUEST['is_recurring'] != '') {
				$formFields['is_recurring'] = $_REQUEST['is_recurring'];
				if ($_REQUEST['is_recurring'] == '0') {
					$whereClauses[] = $this->bean->table_name.".is_recurring = '0'";	
				} else { $whereClauses[] = $this->bean->table_name.".is_recurring = '1'";}
				
			}
			
			if (isset($_REQUEST['status']) && !empty($_REQUEST['status']))	{
				$formFields['status'] = $_REQUEST['status'];
				$initialFilterClauses = array(
					$this->bean->table_name.".status = '{$_REQUEST['status']}'",
				);
			
			}
			$finalwhereClauses = array_merge($whereClauses, $initialFilterClauses);	
			//$GLOBALS['log']->error('Popup where clauses: '. var_export($finalwhereClauses,true));	
			$popup->searchForm = new ProductSearchForm($this->bean, $this->module, "index", $finalwhereClauses);	
		
				
			//////////////////////////////////////////////////////////////////////////////////////////////////
			
			foreach($listViewDefs[$this->module] as $col => $params) {
	        	$filter_fields[strtolower($col)] = true;
				 if(!empty($params['related_fields'])) {
                    foreach($params['related_fields'] as $field) {
                        //id column is added by query construction function. This addition creates duplicates
                        //and causes issues in oracle. #10165
                        if ($field != 'id') {
                            $filter_fields[$field] = true;
                        }
                    }
                }
	        	if(!empty($params['default']) && $params['default'] && $col != 'TEAM_NAME')
	           		$displayColumns[$col] = $params;
	    	}
	    	$popup->displayColumns = $displayColumns;
	    	$popup->filter_fields = $filter_fields;
	    	//check to see if popupdes contains searchdefs
	    	$popup->_popupMeta = $popupMeta;
         $popup->listviewdefs = $listViewDefs;
	    	$popup->searchdefs = $searchdefs;
	    	

	    	if(isset($_REQUEST['query'])){
	    	//2.2RC1 we unset Request fields for which we already produced sql query
	    		foreach ($formFields as $field=>$value) {
	    			unset($_REQUEST[$field]);
	    			
	    			}
				$popup->searchForm->populateFromRequest(); 	
	    	}
			$massUpdateData = '';
			if(isset($_REQUEST['mass'])) {
				foreach(array_unique($_REQUEST['mass']) as $record) {
					$massUpdateData .= "<input style='display: none' checked type='checkbox' name='mass[]' value='$record'>\n";
				}		
			}
			$popup->massUpdateData = $massUpdateData;
			global $theme, $image_path;
			
			// 2.2RC1 PopupGeneric does not handle currency field properly- currency is always formatted with default currency symbol
			 if(floatval(substr($sugar_version,0,3)) > 6.4) {
			$popup->setup('modules/oqc_Product/views/oqcProductPopup65.tpl');
			}
			
			elseif(floatval(substr($sugar_version,0,3)) > 6.3) {
				$popup->setup('modules/oqc_Product/views/oqcProductPopup64.tpl');
			
			}
			elseif ((floatval(substr($sugar_version,0,3)) >= 6.0) && (floatval(substr($sugar_version,0,3)) <= 6.3)) {
				$popup->setup('modules/oqc_Product/views/oqcProductPopup62.tpl');
				
				}
			else { 
			$popup->setup('include/Popups/tpls/PopupGeneric.tpl');
			
			} 
			
			//$popup->setup('include/Popups/tpls/PopupGeneric.tpl');
			
			

			
			insert_popup_header($theme);
			
			 //Quick Search support
         $sqsJavascript = '<script type="text/javascript" src="include/oqc/QuickSearch/oqcQS.js"></script>';
			echo $sqsJavascript;
			
			echo $popup->display(true, $formFields);

		}else{
			if(file_exists('modules/' . $this->module . '/Popup_picker.php')){
				require_once('modules/' . $this->module . '/Popup_picker.php');
			}else{
				require_once('include/Popups/Popup_picker.php');
			}
		
			$popup = new Popup_Picker();
			$popup->_hide_clear_button = true;
			echo $popup->process_page();
		}
	}
}
?>
