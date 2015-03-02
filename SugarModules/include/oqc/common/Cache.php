<?php
class Cache {
	private static $cache = array();
	public static $get = array();
	
	public static function put($key, $value) {
		if (!self::isBadKey($key)) {
			self::$cache[$key] = $value;
		}
		
		return $value;
	}
	
	public static function get($key) {
		if (array_key_exists($key, self::$get)) {
			self::$get[$key]++;
		} else {
			self::$get[$key] = 1;
		}
		
		return self::$cache[$key];
	}
	
	public static function contains($key) {
		return array_key_exists($key, self::$cache);
	}
	
	private static function isBadKey($key) {
		if (empty($key)) {
			return true;
		}
		
		$trimmed = trim($key);
		
		if (empty($trimmed)) {
			return true;
		}
		
		return false;
	}
}
?>