$(document).ready(function(){

	crearTablaDependencias();
	$("#tablaDependencias").setGridWidth($('#cont-emp').width(), true);
});

function crearTablaDependencias() {
    jqGridDeptos = jQuery("#tablaDependencias").jqGrid({
        url:'controlador/fachada.php',
        datatype: "json",
        mtype: 'POST',
        postData: {
            clase: 'Dependencia',
            oper:'select'
        },
        colNames:['Codigo','Nombre'],
        colModel:[
            {name:'codigo', index:'codigo', width:10, align:'center', editable:true, classes:"grid-col", editoptions:{size:37,
                dataInit: function(elemento) {$(elemento).width(282)}
                }},
            {name:'nombre', index:'nombre', width:40, editable:true, classes:"grid-col", editoptions:{size:37,
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
        pager: '#pTablaDependencias',
        sortname: 'codigo',
        viewrecords: true,
        sortorder: "asc",
        multiselect: false,
        shrinkToFit: true,
        autowidth: true,
        height: 'auto',
        editurl: "controlador/fachada.php?clase=Dependencia",
		loadError: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        },
        onSelectRow: function(nit) {
        	//nada
        }
    }).jqGrid('navGrid', '#pTablaDependencias', {
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