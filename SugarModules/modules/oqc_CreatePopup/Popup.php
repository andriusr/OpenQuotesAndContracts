<?php
  /* Action muss "Popup" heißen, weil dafür in "include/MVC/View/views/view.config.php" definiert wird, dass kein header etc. angezeigt werden soll */
 // It simulates display() function of ClassicView 
if (isset($_REQUEST['moduletocreate'])) {
 if ($_REQUEST['moduletocreate'] == 'Documents') {
  	require ('modules/oqc_CreatePopup/DocumentsPopup.php');
 	}
 elseif ( $_REQUEST['moduletocreate'] == 'DocumentRevisions' ) {
 	require ('modules/oqc_CreatePopup/DocumentRevisionsPopup.php');
 	}
  	else { die('This module is not supported for oqc_CreatePopup') ;}
}
else { die('No module to create');}
?>


