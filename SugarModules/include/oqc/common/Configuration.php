<?php
class Configuration {
	static private $instance;
	private $configArray;
	const FILE0 = 'include/oqc/conf/documents.properties';
	const FILE1 = '../include/oqc/conf/documents.properties';
	const FILE2 = '../conf/documents.properties'; 
	
	static public function getInstance() {
		if (null == self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function __construct() {
		// TODO this is a workaround: the locations of the configuration files are relative. this is a problem if Configuration.php is loaded from different locations. 
		if (file_exists(self::FILE0)) {
			$this->configArray = parse_ini_file(self::FILE0);
		} else if (file_exists(self::FILE1)) {
			$this->configArray = parse_ini_file(self::FILE1);
		} else {
			$this->configArray = parse_ini_file(self::FILE2);
		}
	}
	
	private function __clone() {
		// empty
	}
	
	public function get($key) {
		
		if (array_key_exists($key, $this->configArray)) {
			return $this->configArray[$key]; }
		else { return null ;}
	}
}
?>
