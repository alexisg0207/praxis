<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Practica_interna
 *
 * @author luisa fernanda
 */
class Practica_interna {
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO practica_interna(id, dependencia, practica) VALUES ('$id', '$dependencia', '$practica'");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE practica_interna SET dependencia='$dependencia', practica='$practica' WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM practica_interna WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM practica_interna', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from practica_interna {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['id'],
                    'dependencia' => $fila['dependencia'],
                    'practica' => $fila['practica']
                ];
            }
        }
        echo json_encode($respuesta);
    }


}
