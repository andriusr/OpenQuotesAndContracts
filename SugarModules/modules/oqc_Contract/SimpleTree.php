<?php
class SimpleTree {
	const CLASSNAME = 'SimpleTree';
	private $id;
	private $children;

	public function __construct($id) {
		$this->id = $id;
		$this->children = array();
	}

	public function addChild($simpleTree) {
		if (is_object($simpleTree) && get_class($simpleTree) === self::CLASSNAME) {
			$this->children[] = $simpleTree;
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/*
	public function addChild($id) {
		if (!is_integer($id) && !is_string($id))
			return FALSE;

		$this->children[] = new SimpleTree($id);
		return true;
	}
	*/
	
	public function getId() {
		return $this->id;
	}

	// TODO does this method makes any sense??
	public function getAllElements() {
		$childArray = array();
		
		foreach ($this->children as $child) {
			$childArray[] = $child->getAllElements();			
		}

		return array($this->id => $childArray);
	}
	
	public function getChildren() {
		return $this->children;
	}
	
	public function getChildById($id) {
		if ($id === $this->id)
			return $this;

		foreach ($this->children as $child) {
			if (($found = $child->getChildById($id)) != FALSE) {
				return $found;
			}
		}

		return FALSE;
	}	
}


?>
