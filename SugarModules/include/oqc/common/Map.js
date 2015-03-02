// TODO die Set.js laden

function Map() {
	this.keySet = new Set();
	this.mapper = new Object();
}

Map.prototype.set = function(key, value) {
	this.keySet.add(key);
	this.mapper[key] = value;
}

Map.prototype.get = function(key) {
	if (this.keySet.contains(key)) {
		return this.mapper[key];
	} else {
		return "0"; // TODO return something else telling that an error occured (no such element exc.)
	}
}

Map.prototype.keys = function() {
	return this.keySet.getElements();
}

Map.prototype.values = function() {
	var values = new Array();
	
	var keys = this.keys();
	for (var i=0; i<keys.length; i++) {
		var value = this.get(keys[i]);
		values.push(value);
	}
	
	return values;
}


Map.prototype.contains = function(key) {
	return this.keySet.contains(key);
}

Map.prototype.remove = function(key) {
	this.keySet.remove(key);
	this.mapper[key] = 0; // TODO set to undef
}

function testMap() {
	var m = new Map();
	
	m.set('3', '9');
	m.set('2', '4');
	m.set('1', '1');
	
	var a = m.keys();
	if (3 != a.length) {
		alert('does not contain 3 keys');
	}
	
	var b = m.values();
	if (3 != b.length) {
		alert('does not have 3 values');
	}
	
	if (!m.contains('1')) {
		alert('does not contain');
	}
	if ('1' != m.get('1')) {
		alert('not equal 1');
	}
	m.remove('1');
	if (m.contains('1')) {
		alert('still contains');
	}
}

// testMap();
