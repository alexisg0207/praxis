<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profesor_coordinador
 *
 * @author luisa fernanda
 */
class Profesor_coordinador {
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO profesor_coordinador(id, nombre, documento, apellido) VALUES ('$id', '$nombre', '$documento', '$apellido')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE profesor_coordinador SET nombre='$nombre', documento='$documento', apellido='$apellido' WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM profesor_coordinador WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM profesor_coordinador', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from profesor_coordinador {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['id'],
                    'documento' => $fila['documento'],
                    'nombre' => $fila['nombre'],
                    'apellido' => $fila['apellido']
                ];
            }
        }
        echo json_encode($respuesta);
    }

    public function getSelect($param) {
        $json = FALSE;
        extract($param);
        $select = "";
        $select .= "<option value='0'>Seleccione un coordinador</option>";
        foreach ($conexion->getPDO()->query("SELECT id, nombre, apellido FROM profesor_coordinador ORDER BY nombre") as $fila) {
            $select .= "<option value='{$fila['id']}'>{$fila['nombre']}&nbsp;{$fila['apellido']}</option>";
        }
        echo $json ? json_encode($select) : ("<select id='$id'>$select</select>");
    }

}
