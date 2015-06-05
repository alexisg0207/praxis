<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cambios
 *
 * @author luisa fernanda
 */
class Cambios {
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO cambios(id, convenio, descripcion, fecha, fecha_inicio, fecha_fin) VALUES ('$id', '$convenio', '$descripcion', '$fecha', '$fecha_inicio', '$fecha_fin')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE cambios SET nombre='$nombre' id='$id', convenio='$convenio', descripcion='$descripcion', fecha='$fecha', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin' WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM cambios WHERE codigo = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM cambios', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from cambios {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['id'],
                    'convenio' => $fila['convenio'],
                    'descripcion' => $fila['descripcion'],
                    'fecha' => $fila['fecha'],
                    'fecha_inicio' => $fila['fecha_inicio'],
                    'fecha_fin' => $fila['fecha_fin']                        
                ];
            }
        }
        echo json_encode($respuesta);
    }
    
}
