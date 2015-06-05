$(document).ready(function(){

	crearTablaEmpresas();
	$("#tablaExternas").setGridWidth($('#cont-emp').width(), true);
});

function crearTablaEmpresas() {
    jqGridDeptos = jQuery("#tablaExternas").jqGrid({
        url:'controlador/fachada.php',
        datatype: "json",
        mtype: 'POST',
        postData: {
            clase: 'Practica_externa',
            oper:'select'
        },
        colNames:['Id', 'Id interno', 'Valor', 'Fecha inicio', 'Fecha fin', 'Estudiante', 'Convenio'],
        colModel:[
            {name:'idgen', index:'idgen', width:10, align:'center', editable:true, classes:"grid-col", 
                editoptions:{
                    size:37,
                    dataInit: function(elemento){
                        $(elemento).width(282)
                    }
                }
            },
            {name:'interna_id', index:'interna_id', width:10, editable:true, classes:"grid-col", 
                editoptions:{
                    size:37,
                    dataInit: function(elemento){
                        $(elemento).width(282)
                    }
                }
            },
            {name:'valor', index:'valor', width:15, align:'center', editable:true, classes:"grid-col",
                editoptions:{
	                dataInit: function(elemento){
                        $(elemento).width(282)
                    },
                }
            },
            {name:'fecha_inicio', index:'fecha_inicio', width:15, editable:true, classes:"grid-col", 
                edittype:'text',
                editoptions:{
                    size: 37, 
                    maxlengh: 10,
                    dataInit: function(elemento) {
                        $(elemento).datepicker({dateFormat: 'yy-mm-dd'})
                    },
                }
            },
            {name:'fecha_fin', index:'fecha_fin', width:15, align:'center', editable:true, classes:"grid-col", 
                edittype:'text',
                editoptions:{
                    size: 37, 
                    maxlengh: 10,
                    dataInit: function(elemento) {
                        $(elemento).datepicker({dateFormat: 'yy-mm-dd'})
                    },
                }
            },
            {name:'estudiante', index:'estudiante', width:25, editable:true, classes:"grid-col", 
                edittype: 'select',
                editoptions:{
                    dataInit: function(elemento) {
                        $(elemento).width(282)
                    },
                    dataUrl:'controlador/fachada.php?clase=Estudiante&oper=getSelect'
                }
            },
            {name:'convenio', index:'convenio', width:10, editable:true, classes:"grid-col", 
                edittype: 'select',
                editoptions:{
                    dataInit: function(elemento){
                        $(elemento).width(282)
                    },
                    dataUrl:'controlador/fachada.php?clase=Convenio&oper=getSelect'
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
        pager: '#pTablaExternas',
        sortname: 'idgen',
        viewrecords: true,
        sortorder: "asc",
        multiselect: false,
        shrinkToFit: true,
        autowidth: true,
        height: 'auto',
        editurl: "controlador/fachada.php?clase=Practica_externa",
		loadError: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        },
        onSelectRow: function(nit) {
        	//nada
        }
    }).jqGrid('navGrid', '#pTablaExternas', {
        refresh: true,
        edit: true,
        add: true,
        del: true,
        search: true
    },
    {   // Antes de enviar a Departamento->edit(...) se agrega un POST
        modal:true, jqModal:true,
        width:800,
        beforeShowForm: function(form) { 
            $('#tr_idgen', form).hide(); 
            $('#tr_interna_id', form).hide();
        },
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
        beforeShowForm: function(form) { 
            $('#tr_idgen', form).show(); 
            $('#tr_interna_id', form).show();
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