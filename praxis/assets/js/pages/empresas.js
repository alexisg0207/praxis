$(document).ready(function(){

	crearTablaEmpresas();
	$("#tablaEmpresas").setGridWidth($('#cont-emp').width(), true);
});

function crearTablaEmpresas() {
    jqGridDeptos = jQuery("#tablaEmpresas").jqGrid({
        url:'controlador/fachada.php',
        datatype: "json",
        mtype: 'POST',
        postData: {
            clase: 'Empresa',
            oper:'select'
        },
        colNames:['Nit','Nombre', 'Localidad', 'Responsable'],
        colModel:[
            {name:'nit', index:'nit', width:10, align:'center', editable:true, classes:"grid-col", editoptions:{size:37,
                dataInit: function(elemento) {$(elemento).width(282)}
                }},
            {name:'nombre', index:'nombre', width:40, editable:true, classes:"grid-col", editoptions:{size:37,
                dataInit: function(elemento) {$(elemento).width(282)}
                }},
            {name:'localidad', index:'localidad', width:10, align:'center', editable:true, classes:"grid-col", 
             edittype:'select',
             editoptions:{
	                dataInit: function(elemento) {$(elemento).width(282)},
	                dataUrl:'controlador/fachada.php?clase=Localidad&oper=getSelect'
                }},
            {name:'responsable_nombre', index:'responsable_nombre', width:40, editable:false, classes:"grid-col", editoptions:{size:37,
                dataInit: function(elemento) {$(elemento).width(282)}
                }}
        ],
        /*{name:'fk_departamento', index:'fk_departamento', hidden: false, width:200, editable:true, edittype:'select',
                    editoptions: {
                        dataInit: function(elemento) {$(elemento).width(292)}, 
                        dataUrl:'controlador/fachada.php?clase=Departamento&oper=getSelect',
                        defaultValue: idDepto
                    }
                }*/
        rowNum:10,
        width:900,
        pager: '#pTablaEmpresas',
        sortname: 'nit',
        viewrecords: true,
        sortorder: "asc",
        multiselect: false,
        shrinkToFit: true,
        autowidth: true,
        height: 'auto',
        editurl: "controlador/fachada.php?clase=Empresa",
		loadError: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        },
        onSelectRow: function(nit) {
        	//nada
        }
    }).jqGrid('navGrid', '#pTablaEmpresas', {
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
        afterSubmit: function (response, postdata) {
            var respuesta = jQuery.parseJSON(response.responseText);
            return [respuesta.ok, respuesta.mensaje, ''];
        }
    },
    {   // Antes de enviar a Departamento->add(...) se agrega un POST
        modal:true, jqModal:true,
        width:800,
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