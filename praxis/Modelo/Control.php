<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Control
 *
 * @author luisa fernanda
 */
class Control {
    
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO control(codigo, descripcion, fecha, practica) VALUES ('$codigo', '$descripcion', '$fecha', '$practica')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE control SET descripcion='$descripcion', fecha='$fecha', practica='$practica' WHERE codigo = '$codigo'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM control WHERE codigo = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM control', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from control {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'codigo' => $fila['codigo'],
                    'descripcion' => $fila['descripcion'],
                    'fecha' => $fila['fecha'],
                    'practica' => $fila['practica']
                ];
            }
        }
        echo json_encode($respuesta);
    }
    
}
