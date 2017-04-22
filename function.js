function print_array(array_name, my_array){
	document.write(array_name+":<br>")
	for(var a=0;a<my_array.length;a++){
		document.write("["+a+"]->"+my_array[a]+"<br>");
	}
	document.write("<br>");
}

function trim_array(my_array){
	for(var a=0;a<my_array.length;a++){
		my_array[a]=my_array[a].trim();
	}
}

function make_elements(drawing_node_array, drawing_edge_array){
	var node_array=new Array();
	var edge_array=new Array();
	
	for(var a=0;a<drawing_node_array.length;a++){
		node_array.push({
			data: {id: drawing_node_array[a], name: drawing_node_array[a]}
		});
	}
	
	for(var a=0;a<drawing_edge_array.length;a++){
		var temp=drawing_edge_array[a].split(",");
		edge_array.push({
			data: {id: drawing_edge_array[a], source: temp[0], target: temp[1]}
			//data: {source: temp[0], target: temp[1]}
		});
	}
	
	return [node_array, edge_array];
}

function make_node_string(node_array){
	var node_string="";
	for(var a=0;a<node_array.length;a++){
		if(a==node_array.length-1){
			node_string=node_string+node_array[a];
		}
		else{
			node_string=node_string+node_array[a]+",";
		}
	}
	return node_string;
}