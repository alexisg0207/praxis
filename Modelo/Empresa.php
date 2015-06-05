<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresa
 *
 * @author luisa fernanda
 */
class Empresa {
    
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO empresa(nit, nombre, localidad) VALUES ('$nit', '$nombre', '$localidad')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE empresa SET nombre='$nombre', localidad='$localidad' WHERE nit = '$nit'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        error_log(print_r($param,true));
        $sql = "DELETE FROM empresa WHERE nit = '$id'";
        error_log($sql);
        $conexion->getPDO()->exec($sql);
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion("SELECT COUNT(*)
                                               FROM empresa e LEFT JOIN responsable r 
                                               ON e.nit=r.empresa_nit ", $where, $rows, $page, $sidx, $sord);
        $sql = "SELECT nit, 
                       e.nombre as nombre, 
                       r.nombre||' '||r.apellido as responsable_nombre, 
                       r.id as responsable_id, localidad 
                FROM empresa e LEFT JOIN responsable r 
                ON e.nit=r.empresa_nit 
                {$respuesta['otras cláusulas']}";
        error_log($sql);
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['nit'],
                    'cell' => [
                        'nit' => $fila['nit'],
                        'nombre' => $fila['nombre'],
                        'localidad' => $fila['localidad'],
                        'responsable_nombre' => $fila['responsable_nombre'],
                        'responsable_id' => $fila['responsable_id']
                    ]
                ];
            }
        }
        //error_log(print_r($respuesta, true));
        echo json_encode($respuesta);
    }

    public function getSelect($param) {
        $json = FALSE;
        extract($param);
        $select = "";
        $select .= "<option value='0'>Seleccione una empresa</option>";
        foreach ($conexion->getPDO()->query("SELECT nit, nombre FROM empresa ORDER BY nombre") as $fila) {
            $select .= "<option value='{$fila['nit']}'>{$fila['nombre']}</option>";
        }
        echo $json ? json_encode($select) : ("<select id='$id'>$select</select>");
    }
    
}
