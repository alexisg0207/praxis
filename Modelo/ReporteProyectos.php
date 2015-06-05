<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReporteProyectos
 *
 * @author Marcela
 */
//YA FUNCIONAAAAAAAAAAAAAAAAA !!!!!!!! LUNES 10 DE NOVIEMBRE DEL 2014
class ReporteProyectos extends Reporte {
    
    public function __construct() {
       
    }
    
    public function generarReporte($param) {
        echo ':)';
        extract($param);
        $this->crearLibro($param);
       
        $objWorksheet = $this->objPHPExcel->getActiveSheet(0); // activar la primera hoja... se pueden crear otras y activarlas: $this->objPHPExcel->setActiveSheetIndex($i);
        $this->objPHPExcel->getActiveSheet()->setTitle('Convenio Practica'); //Establecer nombre 
        
        //$objWorksheet->getStyle("A2:C2")->applyFromArray($this->getBordes());
        $objWorksheet->setCellValue('A1', 'CONVENIOS');
        $objWorksheet->setCellValue('B1', 'PRACTICAS');

        $sql = "SELECT C.id convenio, P.id practica FROM convenio C, practica_externa P WHERE C.id = P.convenio ORDER BY C.id";
        $i = 2;
        foreach ($conexion->getPDO()->query($sql) as $fila) {
            $objWorksheet->setCellValueByColumnAndRow(0, $i, $fila['convenio']);
            $objWorksheet->setCellValueByColumnAndRow(1, $i, $fila['practica']);

            $i++;
        }
         $this->objPHPExcel->createSheet(1);
         $this->objPHPExcel->setActiveSheetIndex(1); //Seleccionar la pestaña deseada
          $this->objPHPExcel->getActiveSheet()->setTitle('Convenio Empresa Representante'); //Establecer nombre 
        $objWorksheet1=$this->objPHPExcel->getActiveSheet();
      
        $objWorksheet1->setCellValue('A1', 'CONVENIO');
  
        $objWorksheet1->setCellValue('B1', 'EMPRESA');
        $objWorksheet1->setCellValue('C1', 'REPRESENTANTE');

        $sql1 = "SELECT C.id convenio, E.nombre empresa, R.nombre nrepresentante, R.apellido arepresentante FROM convenio C, empresa E, responsble R WHERE C.nit_empresa=E.nit AND R.empresa_nit=E.nit";
        $i = 2;
        
        foreach ($conexion->getPDO()->query($sql1) as $fila) {
            
            $objWorksheet1->setCellValueByColumnAndRow(0, $i, $fila['convenio']);
            $objWorksheet1->setCellValueByColumnAndRow(1, $i, $fila['empresa']);
            $objWorksheet1->setCellValueByColumnAndRow(2, $i, $fila['nrepresentante'].' '.$fila['arepresentante']);

            $i++;
        }
        $this->objPHPExcel->createSheet(2);
         $this->objPHPExcel->setActiveSheetIndex(2); //Seleccionar la pestaña deseada
          $this->objPHPExcel->getActiveSheet()->setTitle('Informe Practicas'); //Establecer nombre 
        $objWorksheet=$this->objPHPExcel->getActiveSheet();
        

        $objWorksheet->setCellValue('A1', 'PRACTICA');
        $objWorksheet->setCellValue('B1', 'TIPO');
        $objWorksheet->setCellValue('C1', 'LOCALIDAD');
        $objWorksheet->setCellValue('D1', 'ESTUDIANTE');
        $objWorksheet->setCellValue('E1', 'DIRECTOR');
        $objWorksheet->setCellValue('F1', 'PROFESOR');

        $sql = "SELECT p.id practica_externa,'Externa' as tipo,l.nombre localidad,e.codigo cestudiante,e.nombre nestudiante,e.apellido aestudiante,
       d.nombre ndirector,d.apellido adirector,pf.nombre nprofesor,pf.apellido aprofesor
FROM practica_externa p,localidad l,estudiante e,director d,profesor_coordinador pf,practica pr,programa pg,asignatura as \"at\"
WHERE p.localidad = l.id and
      pr.id = p.practica and
      pr.estudiante = e.codigo and
      at.id = e.asignatura and
      pf.id = at.coordinador and
      pg.codigo = at.programa and
      pg.director = d.codigo
      UNION
SELECT p.id practica_interna,'Interna' as tipo,'Manizales' as localidad,e.codigo cestudiante,e.nombre nestudiante,e.apellido aestudiante,
       d.nombre ndirector,d.apellido adirector,pf.nombre nprofesor,pf.apellido aprofesor
FROM practica_interna p,estudiante e,director d,profesor_coordinador pf,practica pr,programa pg,asignatura as \"at\"
WHERE pr.id = p.practica and
      pr.estudiante = e.codigo and
      at.id = e.asignatura and
      pf.id = at.coordinador and
      pg.codigo = at.programa and
      pg.director = d.codigo
      ORDER BY tipo";
        $i = 2;
        foreach ($conexion->getPDO()->query($sql) as $fila) {
            $objWorksheet->setCellValueByColumnAndRow(0, $i, $fila['practica_externa']);
            $objWorksheet->setCellValueByColumnAndRow(1, $i, $fila['tipo']);
            $objWorksheet->setCellValueByColumnAndRow(2, $i, $fila['localidad']);
            $objWorksheet->setCellValueByColumnAndRow(3, $i, $fila['cestudiante'].' '.$fila['nestudiante'].' '.$fila['aestudiante']);
            $objWorksheet->setCellValueByColumnAndRow(4, $i,$fila['ndirector'].' '.$fila['adirector']);
            $objWorksheet->setCellValueByColumnAndRow(5, $i,$fila['nprofesor'].' '.$fila['aprofesor']);

            $i++;
        }
        $this->guardar();
        //UtilConexion::descargar($this->nombreArchivo);
        echo json_encode(['ok' => TRUE, 'archivo' => $this->nombreArchivo]);
        
   }

    
    
   

}
