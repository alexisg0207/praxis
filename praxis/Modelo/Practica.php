<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Practica
 *
 * @author luisa fernanda
 */
class Practica {

    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO practica(id, valor, fecha_inicio, fecha_fin, estudiante) VALUES ('$id', '$valor', '$fecha_inicio', '$fecha_fin', '$estudiante')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE practica SET estudiante='$estudiante', valor='$valor', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin' WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM practica WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM practica', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from practica {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['id'],
                    'valor' => $fila['valor'],
                    'fecha_inicio' => $fila['fecha_inicio'],
                    'fecha_fin' => $fila['fecha_fin'],
                    'estudiante' => $fila['estudiante']
                ];
            }
        }
        echo json_encode($respuesta);
    }
    
}