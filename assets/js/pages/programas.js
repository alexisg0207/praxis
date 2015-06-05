$(document).ready(function(){

	crearTablaEmpresas();
	$("#tablaProgramas").setGridWidth($('#cont-emp').width(), true);
});

function crearTablaEmpresas() {
    jqGridDeptos = jQuery("#tablaProgramas").jqGrid({
        url:'controlador/fachada.php',
        datatype: "json",
        mtype: 'POST',
        postData: {
            clase: 'Programa',
            oper:'select'
        },
        colNames:['Codigo', 'Nombre', 'Director'],
        colModel:[
            {name:'codigo', index:'codigo', width:10, align:'center', editable:true, classes:"grid-col",
                editoptions:{
                    dataInit: function(elemento){
                        $(elemento).width(282)
                    },
                }
            },
            {name:'nombre', index:'nombre', width:10, editable:true, classes:"grid-col", 
                editoptions:{
                    dataInit: function(elemento){
                        $(elemento).width(282)
                    },
                }
            },
            {name:'director', index:'director', width:15, align:'center', editable:true, classes:"grid-col",
                
                edittype:'select',
                editoptions:{
                    dataInit: function(elemento){
                        $(elemento).width(282)
                    },
                    dataUrl:'controlador/fachada.php?clase=Director&oper=getSelect'
                }
            }
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
        pager: '#pTablaProgramas',
        sortname: 'codigo',
        viewrecords: true,
        sortorder: "asc",
        multiselect: false,
        shrinkToFit: true,
        autowidth: true,
        height: 'auto',
        editurl: "controlador/fachada.php?clase=Programa",
		loadError: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        },
        onSelectRow: function(nit) {
        	//nada
        }
    }).jqGrid('navGrid', '#pTablaProgramas', {
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
            $('#tr_codigo', form).hide(); 
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
            $('#tr_codigo', form).show(); 
        },
        afterSubmit: function (response, postdata) {
            var respuesta = jQuery.parseJSON(response.responseText);
            return [respuesta.ok, respuesta.mensaje, ''];
        }
    },
    {   
        modal:true, 
        jqModal:true,
        width:800
    },
    {multipleSearch:true, multipleGroup:true}
)}