<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Practica_externa
 *
 * @author luisa fernanda
 */
class Practica_externa {
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO practica_externa(id, convenio, localidad, practica) VALUES ('$id', '$convenio', '$localidad', $practica'");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE practica_externa SET convenio='$convenio', localidad='$localidad', practica='$practica' WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM practica_externa WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM practica_externa', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from practica_externa {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['id'],
                    'convenio' => $fila['convenio'],
                    'localidad' => $fila['localidad'],
                    'practica' => $fila['practica']
                ];
            }
        }
        echo json_encode($respuesta);
    }


}
