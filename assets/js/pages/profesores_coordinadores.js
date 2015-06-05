$(document).ready(function(){

	crearTablaEmpresas();
	$("#tablaProfesoresCoordinadores").setGridWidth($('#cont-emp').width(), true);
});

function crearTablaEmpresas() {
    jqGridDeptos = jQuery("#tablaProfesoresCoordinadores").jqGrid({
        url:'controlador/fachada.php',
        datatype: "json",
        mtype: 'POST',
        postData: {
            clase: 'Profesor_coordinador',
            oper:'select'
        },
        colNames:['Id','Nombre', 'Apellido', 'Documento'],
        colModel:[
            {name:'id', index:'id', width:10, align:'center', editable:true, classes:"grid-col", editoptions:{size:37,
                dataInit: function(elemento) {$(elemento).width(282)}
                }},
            {name:'nombre', index:'nombre', width:40, editable:true, classes:"grid-col", editoptions:{size:37,
                dataInit: function(elemento) {$(elemento).width(282)}
                }},
            {name:'apellido', index:'apellido', width:40, editable:true, classes:"grid-col", editoptions:{size:37,
                dataInit: function(elemento) {$(elemento).width(282)}
                }},
            {name:'documento', index:'documento', width:40, editable:true, classes:"grid-col", editoptions:{size:37,
                dataInit: function(elemento) {$(elemento).width(282)}
                }},
        ],
        rowNum:10,
        width:900,
        pager: '#pTablaProfesoresCoordinadores',
        sortname: 'id',
        viewrecords: true,
        sortorder: "asc",
        multiselect: false,
        shrinkToFit: true,
        autowidth: true,
        height: 'auto',
        editurl: "controlador/fachada.php?clase=Profesor_coordinador",
		loadError: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        },
        onSelectRow: function(nit) {
        	//nada
        }
    }).jqGrid('navGrid', '#pTablaProfesoresCoordinadores', {
        refresh: true,
        edit: true,
        add: true,
        del: true,
        search: true
    },
    {   // Antes de enviar a Departamento->edit(...) se agrega un POST
        modal:true, jqModal:true,
        width:800,
        beforeSubmit: function(postdata) {
//              acceder a los datos de la fila seleccionada:
//              var fila = $(this).getRowData($(this).getGridParam("selrow"));

//              agregar un parámetro a los datos enviados (ej. el ID introducido en el formulario de edición)
            //postdata.idNuevo = $('#id').val();
            return[true, ''];
        },
        beforeShowForm: function(form) { 
            $('#tr_id', form).hide(); 
        },
        afterSubmit: function (response, postdata) {
            var respuesta = jQuery.parseJSON(response.responseText);
            return [respuesta.ok, respuesta.mensaje, ''];
        }
    },
    {   // Antes de enviar a Departamento->add(...) se agrega un POST
        modal:true, jqModal:true,
        width:800,
        beforeShowForm: function(form) { 
            $('#tr_id', form).show(); 
        },
        afterSubmit: function (response, postdata) {
            var respuesta = jQuery.parseJSON(response.responseText);
            return [respuesta.ok, respuesta.mensaje, ''];
        }
    },
    {   modal:true, jqModal:true,
        width:800,
    },
    {multipleSearch:true, multipleGroup:true}
)}