<?php

/**
 * Description of Reporte
 * 
 * Ojo con este detalle:
 *      set_time_limit(1800);
 *      ini_set('memory_limit', '1024M');
 * 
 * Todo lo que sea reutilizable definirlo aquí: estilos, ... qué se yo, por ejempo getBordes
 *
 * @author Carlos Cuesta Iglesias
 */
abstract class Reporte {

    protected $objPHPExcel;
    protected $nombreArchivo;

    public function crearLibro($param) {
        
        extract($param);
        $this->objPHPExcel = new PHPExcel();

        $this->objPHPExcel->getProperties()
                ->setCreator("Universidad de Caldas")
                ->setLastModifiedBy("Universidad de Caldas")
                ->setTitle("Practicas")
                ->setSubject("Practicas")
                ->setDescription("Descripcion de las practicas Universidad de Caldas")
                ->setKeywords("Practicas")
                ->setCategory('Proyecto de Ingenieria de Software I');
        $this->nombreArchivo =  'Reportes.xlsx';
    }

    abstract public function generarReporte($param);

    /**
     * El formato de bordes de las tablas que se generan para Excel
     * @return array La definición de los bordes
     */
    protected function getBordes() {
        return array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
    }

    protected function guardar() {
        $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
        $objWriter->save(TMP_PATH . $this->nombreArchivo);
        $this->objPHPExcel->disconnectWorksheets();
        unset($this->objPHPExcel);
        unset($objWriter);
    }

  

}
