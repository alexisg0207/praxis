$(document).ready(function(){
	mostrarTabla(0);
	
});

function mostrarTabla(pagina){
	$.ajax({
		url: 'Controlador/fachada.php',
		type: 'POST',
		data: {
			clase: 'Empresa',
			oper: 'select',
			rows: 15,
			page: pagina,
			json: true
		},
		success:function (data) {
			stringHtml="";
			var parsed = JSON.parse(data);
			var row = parsed.rows;
			stringHtml = "";
			$.each(row, function(i, item){
				stringHtml+="<tr>"+
					"	<td>"+item.nit+"</td>"+
					"	<td><input type='checkbox' class='rows-check'></td>"+
					"	<td><strong>"+item.nombre+"</strong></td>"+
					"	<td>"+item.localidad+"</td>"+
					"	<td>"+item.representante+"</td>"+
					"	<td>"+
					"		<div class='btn-group btn-group-xs'>"+
					"			<a name='delete' data-toggle='tooltip' title='Delete' value="+item.nit+" class='btn btn-default'>"+
					"				<i class='fa fa-trash-o'></i>"+
					"			</a>"+
					"			<a name='edit' data-toggle='tooltip' title='Edit' value="+item.nit+" class='btn btn-default'>"+
					"				<i class='fa fa-edit'></i>"+
					"			</a>"+
					"		</div>"+
					"	</td>"+
					"</tr>";
				});
			$("#table").html(stringHtml);
			asignarAcciones();
		},
		error:function (e) {
			console.log(e);
		}
	});
}

//<li><a class="md-trigger" data-modal="logout-modal"><i class="icon-logout-1"></i> Logout</a></li>

function asignarAcciones(){
	$("a[name='delete']").each(function(i){
		$(this).click(function(){
			$.ajax({
				url: 'Controlador/fachada.php',
				type: 'POST',
				data: {
					clase: 'Empresa',
					oper: 'del',
					nit: $(this).attr("value"),
					json: true
				},
				success:function (data) {
					mostrarTabla();
				},
				error:function (e) {
					console.log(e);
				}
			});
		});
	});
}