<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Estudiante
 *
 * @author luisa fernanda
 */
class Estudiante {
    
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO estudiante(codigo, documento, nombre, apellido, asignatura) VALUES ('$codigo', '$documento', '$nombre', '$apellido', '$asignatura')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE estudiante SET documento='$documento', nombre='$nombre', apellido='$apellido', asignatura='$asignatura' WHERE codigo = '$codigo'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM estudiante WHERE codigo = '$codigo'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM estudiante', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from estudiante {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'codigo' => $fila['codigo'],
                    'documento' => $fila['documento'],
                    'nombre' => $fila['nombre'],
                    'apellido' => $fila['apellido'],
                    'asignatura' => $fila['asignatura']
                ];
            }
        }
        echo json_encode($respuesta);
    }
}
