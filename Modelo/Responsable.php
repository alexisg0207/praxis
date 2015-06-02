<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Responsable
 *
 * @author luisa fernanda
 */
class Responsable {
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO responsable(id, nombre, empresa_nit, apellido) VALUES ('$id', '$nombre', '$empresa_nit', '$apellido')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE responsable SET nombre='$nombre', empresa_nit='$empresa_nit', apellido='$apellido' WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM responsable WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM responsable', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from responsable {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['id'],
                    'nombre' => $fila['nombre'],
                    'apellido' => $fila['apellido'],
                    'empresa_nit' => $fila['empresa_nit']
                ];
            }
        }
        echo json_encode($respuesta);
    }
}
