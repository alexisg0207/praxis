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
class Practica_externa {
    function add($param) {
        extract($param);
        error_log(print_r($param, true));
        $conexion->getPDO()->exec("INSERT INTO practica(id, valor, fecha_inicio, fecha_fin, estudiante) values ('$idgen', '$valor', '$fecha_inicio', '$fecha_fin', '$estudiante');
                                   INSERT INTO practica_externa(id, convenio, practica) values ('$interna_id', '$convenio', '$idgen');");
        //$conexion->getPDO()->exec("INSERT INTO practica_interna(id, convenio, practica) VALUES ('$id', '$convenio', '$practica'");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        error_log(print_r($param, true));
        $conexion->getPDO()->exec("UPDATE practica SET valor='$valor', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', estudiante='$estudiante' WHERE id = '$idgen';
                                    UPDATE practica_externa SET convenio='$convenio', practica='$idgen' WHERE id='$interna_id';");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $rs = $conexion->getPDO()->query("SELECT practica FROM practica_externa WHERE id = '$id'");
        $fila = $rs->fetch(PDO::FETCH_ASSOC);
        $idg = $fila['practica'];
        $sql = "DELETE FROM practica_externa WHERE id = '$id'";
        $sql2 = "DELETE FROM practica WHERE id = '$idg'";
        //error_log($sql);
        //error_log($sql2);
        $conexion->getPDO()->exec($sql);
        $conexion->getPDO()->exec($sql2);
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*)
                                               FROM practica_externa pe INNER JOIN practica p
                                               ON pe.practica = p.id ', $where, $rows, $page, $sidx, $sord);
        $sql = "SELECT p.id AS idgen, pe.id AS interna_id, pe.convenio, p.valor, p.fecha_inicio, p.fecha_fin, p.estudiante
                FROM practica_externa pe INNER JOIN practica p
                ON pe.practica = p.id {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['interna_id'],
                    'cell' => [
                        'idgen' => $fila['idgen'],
                        'interna_id' => $fila['interna_id'],
                        'convenio' => $fila['convenio'],
                        'valor' => $fila['valor'],
                        'fecha_inicio' => $fila['fecha_inicio'],
                        'fecha_fin' => $fila['fecha_fin'],
                        'estudiante' => $fila['estudiante']
                    ]
                ];
            }
        }
        //error_log(print_r($respuesta, true));
        echo json_encode($respuesta);
    }


}
