
function IdManager(name, containerId){
    this.idSet = new Set();
    this.name = name;
    this.containerId = containerId;
}

IdManager.prototype.contains = function(id){
	return this.idSet.contains(id);
}

IdManager.prototype.add = function(id){
    this.idSet.add(id);
    
    if (tagExists(this.name + 'Remove' + id)) {
        removeTag(this.name + 'Remove' + id);
    }
    
    if (tagExists(this.containerId)) {
        var container = document.getElementById(this.containerId);
        var inputId = this.name + "Add" + id;
        
        if (!tagExists(inputId)) {
            var input = document.createElement("input");
            input.name = this.name + 'Add[]';
            input.type = 'hidden';
            input.id = inputId;
            input.value = id;
            
            container.appendChild(input);
        }
    }
    else {
        alert('Could not add the html code because container is undefined.');
    }
}

IdManager.prototype.remove = function(id){
    if (this.idSet.contains(id)) {
        this.idSet.remove(id);
    }
    
    if (tagExists(this.name + 'Add' + id)) {
        removeTag(this.name + 'Add' + id);
    }
    
    if (tagExists(this.containerId)) {
        var container = document.getElementById(this.containerId);
        var inputId = this.name + "Remove" + id;
        
        if (!tagExists(inputId)) {
            var input = document.createElement("input");
            input.name = this.name + 'Remove[]';
            input.type = 'hidden';
            input.id = inputId;
            input.value = id;
            
            container.appendChild(input);
        }
    }
    else {
        alert('Could not remove html code because container is undefined');
    }
}

function testIdManager(){
    var mgr = new IdManager('TestManager', 'TextManagerContainer');
    
    mgr.add('id1');
    mgr.add('id1');
    mgr.add('id2');
    mgr.add('id1');
    mgr.add('id1');
    mgr.add('id2');
    mgr.remove('id3');
    mgr.remove('id3');
    mgr.remove('id3');
    mgr.remove('id1');
    mgr.remove('id1');
    mgr.add('id1');
    mgr.remove('id1');
    mgr.remove('id2');
    mgr.remove('id3');
}
