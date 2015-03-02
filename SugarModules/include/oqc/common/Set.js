function Set() {
	this.items = new Array();
}

Set.prototype.add = function(item) {
	if (!this.contains(item)) {
		this.items.push(item);
	}
}

Set.prototype.contains = function(item) {
	for (var i=0; i<this.items.length; i++) {
		if (item == this.items[i]) {
			return true;
		} 
	}
	return false;
}

Set.prototype.remove = function(item) {
	if (this.contains(item)) {
		for (var i=0; i<this.items.length; i++) {
			if (item == this.items[i]) {
				// override the item that should be deleted with the last in the set
				this.items[i] = this.items[this.items.length-1];
				break;
			}
		}
		// remove last element 
		this.items.pop();
	}
}

Set.prototype.isEmpty = function() {
	return this.items.length === 0;	
}

Set.prototype.getElements = function() {
	return this.items;	
}

function testSet() {
	var s = new Set();
	if (!s.isEmpty()) {
		alert('Nicht leer');
	}
	s.add('1');
	if (s.isEmpty()) {
		alert('Immernoch leer');
	}
	s.add('2');
	s.add('3');
	s.add('4');
	if (s.isEmpty()) {
		alert('Immernoch leer');
	}
	if (s.contains('4')) {
		s.remove('4');
		if (!s.contains('4')) {
			alert('Alles gut!');
			return;
		}
	}
	alert('TestSet Fehlgeschlagen');
}

// testSet();