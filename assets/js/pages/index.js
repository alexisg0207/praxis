$(document).ready(function(){

	//Obtener de base de datos

  	Morris.Donut({
	  element: 'donut-practicas',
	  resize: true,
	  colors: [
	  	"#4D864D",
	  	"#B8CFB8"
	  ],
	  data: [
	    {label: "Practicas externas", value: 12},
	    {label: "Practicas internas", value: 20}
	  ]
	});

	//Obtener de base de datos

	Morris.Line({
	  element: 'line-historial-practicas',
	  resize: true,
	  data: [
	    { y: '2012', a: 80},
	    { y: '2013', a: 100},
	    { y: '2014', a: 120}
	  ],
	  xkey: 'y',
	  ykeys: ['a'],
	  labels: ['Número de practicas'],
	  lineColors: ['#00CC66'],
	  pointFillColors: ['#008F47']
	});

	mostrarTabla1();
	mostrarTabla2();
});

function mostrarTabla1(){
	var htmlString="";
	for(i=1; i< 6;i++){
		htmlString+="<tr><td>Empresa "+i+"</td><td>Fecha "+i+"</td><td>Razon "+i+"</td><td>Responsable "+i+"</td></tr>";
	}
	$("#table1").html(htmlString);
}

function mostrarTabla2(){
	var htmlString="";
	for(i=1; i< 6;i++){
		htmlString+="<tr><td>Estudiante "+i+"</td><td>Empresa "+i+"</td><td>Fecha "+i+"</td></tr>";
	}
	$("#table2").html(htmlString);
}