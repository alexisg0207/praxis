<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asignatura
 *
 * @author luisa fernanda
 */
class Asignatura {
    
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO asignatura(programa, nombre, coordinador, codigo_u) VALUES ('$programa', '$nombre', '$coordinador', '$codigo_u')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE asignatura SET programa='$programa', nombre='$nombre', coordinador='$coordinador', codigo_u='$codigo_u' WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM asignatura WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM asignatura', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from asignatura {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['id'],
                    'programa' => $fila['programa'],
                    'nombre' => $fila['nombre'],
                    'coordinador' => $fila['coordinador'],
                    'codigo_u' => $fila['codigo_u']
                ];
            }
        }
        echo json_encode($respuesta);
    }

}