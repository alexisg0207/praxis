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
        $conexion->getPDO()->exec("DELETE FROM programa WHERE codigo = '$id'");
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
                    'id' => $fila['codigo'],
                    'cell' => [
                        'codigo' => $fila['codigo'],
                        'nombre' => $fila['nombre'],
                        'director' => $fila['director']
                    ]
                ];
            }
        }
        echo json_encode($respuesta);
    }

    public function getSelect($param) {
        $json = FALSE;
        extract($param);
        $select = "";
        $select .= "<option value='0'>Seleccione un estudiante</option>";
        foreach ($conexion->getPDO()->query("SELECT codigo, nombre FROM programa ORDER BY nombre") as $fila) {
            $select .= "<option value='{$fila['codigo']}'>{$fila['nombre']}</option>";
        }
        echo $json ? json_encode($select) : ("<select id='$id'>$select</select>");
    }


}
