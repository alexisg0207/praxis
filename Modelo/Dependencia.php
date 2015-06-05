<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dependencia
 *
 * @author luisa fernanda
 */
class Dependencia {
    
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO dependencia(codigo, nombre) VALUES ('$codigo', '$nombre')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE dependencia SET nombre='$nombre' WHERE codigo = '$codigo'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM dependencia WHERE codigo = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM dependencia', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from dependencia {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['codigo'],
                    'cell' => [
                        'codigo' => $fila['codigo'],
                        'nombre' => $fila['nombre']
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
        $select .= "<option value='0'>Seleccione una dependencia</option>";
        foreach ($conexion->getPDO()->query("SELECT codigo, nombre FROM dependencia ORDER BY nombre") as $fila) {
            $select .= "<option value='{$fila['codigo']}'>{$fila['nombre']}</option>";
        }
        echo $json ? json_encode($select) : ("<select id='$id'>$select</select>");
    }

}
