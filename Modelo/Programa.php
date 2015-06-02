<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Programa
 *
 * @author luisa fernanda
 */
class Programa {
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO programa(codigo, nombre, director) VALUES ('$codigo', '$nombre', '$director')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE programa SET nombre='$nombre', director='$director' WHERE codigo = '$codigo'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM programa WHERE codigo = '$codigo'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM programa', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from programa {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'codigo' => $fila['codigo'],
                    'nombre' => $fila['nombre'],
                    'director' => $fila['director']
                ];
            }
        }
        echo json_encode($respuesta);
    }


}
