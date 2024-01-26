var MuestraModal = function(){
	var mostrar = function(urlContenido){
    $("#MyModal").html('');
		$("#MyModal").load(urlContenido);
		$("#MyModal").modal('show');
	};
	return{mostrar: mostrar};
}();
