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
        $conexion->getPDO()->exec("INSERT INTO empresa(nit, nombre, localidad, representante) VALUES ('$nit', '$nombre', '$localidad', '$representante')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE empresa SET nombre='$nombre', localidad='$localidad', representante='$representante' WHERE nit = '$nit'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $sql = "DELETE FROM empresa WHERE nit = '$nit'";
        error_log($sql);
        $conexion->getPDO()->exec($sql);
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM empresa', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from empresa {$respuesta['otras cláusulas']}";
        error_log($sql);
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'nit' => $fila['nit'],
                    'nombre' => $fila['nombre'],
                    'localidad' => $fila['localidad'],
                    'representante' => $fila['representante']
                ];
            }
        }
        echo json_encode($respuesta);
    }

    public function getSelect($param) {
        $json = FALSE;
        extract($param);
        $select = "";
        $select .= "<option value='0'>Seleccione una empresa</option>";
        foreach ($conexion->getPDO()->query("SELECT nit, nombre FROM empresa ORDER BY nombre") as $fila) {
            $select .= "<option value='{$fila['codigo']}'>{$fila['nombre']}</option>";
        }
        echo $json ? json_encode($select) : ("<select id='$id'>$select</select>");
    }
    
}
