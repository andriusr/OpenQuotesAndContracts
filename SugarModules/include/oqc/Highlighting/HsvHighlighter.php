<?php
require_once("include/oqc/Highlighting/Highlightable.php");

class HsvHighlighter implements Highlightable {
	public function getHighlightningColor($max, $a) {
		if (empty($max) || empty($a)) {
			return "#ffffff"; // white
		}

		// calculate hsv color for contract row
		$h = 120 * ( 1 - $a / $max); // hue. 0 < h < 120 means that we allow all colors between red -> yellow -> green)
		$s = 0.5; // saturation
		$v = 1.0; // value
			
		return '#' . $this->hsvToRgbAsHex($h, $s, $v);
	}

	private function hsvToRgbAsHex($h, $s, $v) {
		// the next lines are from http://en.wikipedia.org/wiki/HSL_and_HSV#Conversion_from_HSV_to_RGB
		$h_i = floor($h/60) % 6;
		$f = $h/60 - floor($h/60);
		$p = $v * (1 - $s);
		$q = $v * (1 - $f * $s);
		$t = $v * (1 - (1 - $f) * $s);

		$r = $g = $b = 0;

		// multiply all color values with 255
		$v *= 255; $t *= 255; $p *= 255; $q *= 255;
		
		if (0 == $h_i) {
			return $this->rgbDecToHex($v, $t, $p);
		} else if (1 == $h_i) {
			return $this->rgbDecToHex($q, $v, $p);
		} else if (2 == $h_i) {
			return $this->rgbDecToHex($p, $v, $t);
		} else if (3 == $h_i) {
			return $this->rgbDecToHex($p, $q, $v);
		} else if (4 == $h_i) {
			return $this->rgbDecToHex($t, $p, $v);
		} else if (5 == $h_i) {
			return $this->rgbDecToHex($v, $p, $q);
		} else {
			return 'ffffff'; // white
		}
	}

	private function rgbDecToHex($r, $g, $b) {
		$hexR = $this->alignedDecToHex($r);
		$hexG = $this->alignedDecToHex($g);
		$hexB = $this->alignedDecToHex($b);

		return $hexR . $hexG . $hexB;
	}

	// this prepends a 0 if the decimal is not greater than 16. this makes sure that the resulting hexadecimal consists of two digits.
	// note that this method only cares about decimal values in [0;255]. prepending one zero is the maximum.
	private function alignedDecToHex($dec) {
		if ($dec > 16) {
			return dechex($dec);
		} else {
			return "0" . dechex($dec);
		}
	}
}
?>