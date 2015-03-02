<?php
class DirectoryPrinter {
	function __construct() {
		require_once('Configuration.php');
		$conf = Configuration::getInstance();
		
		$this->storageDirectory = $conf->get('storageDirectory');
		$this->rootDirStringLength = strlen($this->storageDirectory);
	}
	
	private function getSubDirectories($dir) {
		$subDirectories = array();

		$entries = glob("$dir/*");
		foreach ($entries as $entry) {
			if ($entry != '.' && $entry != '..' && is_dir($entry)) {
				$subDirectories[] = $entry;
			}
		}
		
		return $subDirectories;
	}
	
	private function hasChildren($directory) {
		// this directory has children if it contains more files than . and ..
		$realFiles = array_diff(scandir($directory), array('.', '..'));
		return !empty($realFiles);
	}

	private function getFilesInDirectory($dir) {
		return array_filter(glob("$dir/*"), 'is_file');
	}

	private function getFilesInDirectoryAsJSONInternal($dir) {
		if (!file_exists($dir) || !is_dir($dir)) {
			return '[]';
		}

		$json = '[';

		// add json formatted, recursive directory listing
		$subDirectories	= $this->getSubDirectories($dir);
		foreach ($subDirectories as $subDirectory) {
			$id = uniqid();
			$text = $subDirectory;
			$items = $this->getFilesInDirectoryAsJSONInternal($subDirectory);

			$json .= "{id: '$id', text: '$text', item: $items},";
		}
	
		// add json formatted listing of files
		$files = $this->getFilesInDirectory($dir);
		foreach ($files as $file) {
			$id = uniqid();
			$text = $file;

			$json .= "{id: '$id', text: '$text', item: []},";
		}

		$json .= "]";

		return $json;
	}

	public function getFilesInDirectoryAsJSON($dir) {
		return "{id: 0, item: " . $this->getFilesInDirectoryAsJSONInternal($dir) . "}\n";
	}

	private function getFilesInDirectoryAsXMLInternal($dir) {
		if (!file_exists($dir) || !is_dir($dir)) {
			return "";
		}

		$break = "";
		$xml = "";

		// add xml formatted, recursive directory listing
		$subDirectories	= $this->getSubDirectories($dir);

		foreach ($subDirectories as $subDirectory) {
			$text = substr($subDirectory, 1 + strrpos($subDirectory, '/')); // only print name of the directory without the path infront of it.
			$subDirectoryWithoutRoot = substr($subDirectory, $this->rootDirStringLength);
			$hasChildren = $this->hasChildren($subDirectory) ? '1' : '0';
			$id = urlencode($subDirectoryWithoutRoot);
			// replace "+" sign with space " " because the parent ids contain spaces instead of +. the plus is replaced by a space already in the REQUEST array. this is a workaround and should be improved.
			$id = str_replace('+', ' ', $id);
			
			// write filename into text attribute too because if dhtmlxtree pro editition is not available itemtext cannot be read
			$xml .= "<item child='$hasChildren' id='$id' im0='folderClosed.gif' im1='folderOpen.gif' im2='folderClosed.gif'>$break"; 
			$xml .= "<itemtext><![CDATA[".$text."]]></itemtext>$break";
			$xml .= "<userdata name='fullpath'><![CDATA[".utf8_encode($subDirectoryWithoutRoot)."]]></userdata>$break";
			$xml .= "</item>$break";
		}
	
		// add xml formatted listing of files
		$files = $this->getFilesInDirectory($dir);
		foreach ($files as $file) {
			$id = uniqid();
			$text = basename($file);
			$fileWithoutRoot = substr($file, $this->rootDirStringLength);

			$xml .= "<item id='$id'>$break"; // write filename into text attribute too because if dhtmlxtree pro editition is not available itemtext cannot be read
			$xml .= "<itemtext><![CDATA[".$text."]]></itemtext>$break"; 
			$xml .= "<userdata name='fullpath'><![CDATA[".$fileWithoutRoot."]]></userdata>$break";
			$xml .= "<userdata name='selectable'>true</userdata>$break";
			$xml .=" </item>$break";
		}

		return $xml;
	}

	public function getFilesInDirectoryAsXML($dir) {
		$xml = "<?xml version='1.0' encoding='UTF8'?>";
		$xml .= "<tree id='$dir'>";
		
		if (is_numeric($dir) && 0 === intval($dir)) {
			$xml .= $this->getFilesInDirectoryAsXMLInternal($this->storageDirectory);
		} else {
			$dir = urldecode($dir);
			$xml .= $this->getFilesInDirectoryAsXMLInternal($this->storageDirectory . $dir); // make sure the configured storage directory ends with /
		}
		
		$xml .= "</tree>";
		
		return $xml;
	}
}
?>
