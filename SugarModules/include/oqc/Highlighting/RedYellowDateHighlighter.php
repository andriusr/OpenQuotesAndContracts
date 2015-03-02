<?php
require_once("include/oqc/common/common.php");
require_once("include/oqc/Highlighting/Highlightable.php");

class RedYellowDateHighlighter implements Highlightable {
	const RED = '#ffa7a7';
	const YELLOW = '#fffa74';
	const NO_COLOR = '';
	
	var $nowTimestamp;
	
	function __construct() {
		$this->nowTimestamp = time();
	}
	
	public function getHighlightningColor($dateStr, $warningInterval) {
		$t = date_parse($dateStr);
		
		$redWarningDate = mktime(0, 0, 0, $t['month']-$warningInterval, $t['day'], $t['year']);
		$yellowWarningDate = mktime(0, 0, 0, $t['month']-2*$warningInterval, $t['day'], $t['year']);
		
		if ($this->nowTimestamp >= $redWarningDate) {
			return self::RED;
		} else if ($this->nowTimestamp >= $yellowWarningDate) {
			return self::YELLOW;
		}
		
		return self::NO_COLOR;
	}
}
?>