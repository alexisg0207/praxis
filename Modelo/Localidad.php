<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Localidad
 *
 * @author luisa fernanda
 */
class Localidad {
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO localidad(id, nombre) VALUES ('$id', '$nombre')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE localidad SET nombre='$nombre' WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM localidad WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM localidad', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from localidad {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['id'],
                    'cell' =>[
                        'id' => $fila['id'],
                        'nombre' => $fila['nombre']
                    ]
                ];
            }
        }
        error_log(print_r($respuesta, true));
        echo json_encode($respuesta);
    }

    public function getSelect($param) {
        $json = FALSE;
        extract($param);
        $select = "";
        $select .= "<option value='0'>Seleccione una localidad</option>";
        foreach ($conexion->getPDO()->query("SELECT id, nombre FROM localidad ORDER BY nombre") as $fila) {
            $select .= "<option value='{$fila['id']}'>{$fila['nombre']}</option>";
        }
        echo $json ? json_encode($select) : ("<select id='$id'>$select</select>");
    }
}
