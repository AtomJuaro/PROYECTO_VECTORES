 var n=0;
$(function(){
	// Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
	$("#agregar").on('click', function(){
		$("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
		var value = parseInt($('#sOrden').html());
     	value++;

     	$('#sOrden').html(value);
	});
 
	// Evento que selecciona la fila y la elimina 
	$(document).on("click",".eliminar",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();

		var value = parseInt($('#sOrden').html());
     	value--;
     	$('#sOrden').html(value);
	});
});
 