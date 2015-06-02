<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Director
 *
 * @author luisa fernanda
 */
class Director {
    
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO director(codigo, nombre, documento, apellido) VALUES ('$codigo', '$nombre', '$documento', '$apellido')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE director SET nombre='$nombre', documento='$documento', apellido='$apellido' WHERE codigo = '$codigo'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM director WHERE codigo = '$codigo'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM director', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from director {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'codigo' => $fila['codigo'],
                    'nombre' => $fila['nombre'],
                    'documento' => $fila['documento'],
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
        $select .= "<option value='0'>Seleccione un director</option>";
        foreach ($conexion->getPDO()->query("SELECT codigo, nombre, apellido FROM director ORDER BY nombre") as $fila) {
            $select .= "<option value='{$fila['codigo']}'>{$fila['nombre']}&nbsp;{$fila['apellido']}</option>";
        }
        echo $json ? json_encode($select) : ("<select id='$id'>$select</select>");
    }

}
