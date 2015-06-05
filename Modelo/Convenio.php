<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Convenio
 *
 * @author luisa fernanda
 */
class Convenio {
    function add($param) {
        extract($param);
        $conexion->getPDO()->exec("INSERT INTO convenio(id, fecha_inicio, fecha_fin, documentacion, razon, nit_empresa) VALUES ('$id', '$fecha_inicio', '$fecha_fin', '$documentacion', '$razon', '$nit_empresa')");
        echo $conexion->getEstado();
    }

    function edit($param) {
        extract($param);
        $conexion->getPDO()->exec("UPDATE convenio SET id='$id', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', documentacion='$documentacion', razon='$razon', nit_empresa='$nit_empresa' WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function del($param) {
        extract($param);
        $conexion->getPDO()->exec("DELETE FROM convenio WHERE id = '$id'");
        echo $conexion->getEstado();
    }

    function select($param) {
        extract($param);
        $where = $conexion->getWhere($param);
        $respuesta = $conexion->getPaginacion('SELECT COUNT(*) FROM convenio', $where, $rows, $page, $sidx, $sord);
        
        $sql = "SELECT * from convenio {$respuesta['otras cláusulas']}";
        error_log($sql);
        
        if (($rs = $conexion->getPDO()->query($sql))) {
            while ($fila = $rs->fetch(PDO::FETCH_ASSOC)) {
                $respuesta['rows'][] = [
                    'id' => $fila['id'],
                    'cell' => [
                        'id' => $fila['id'],
                        'fecha_inicio' => $fila['fecha_inicio'],
                        'fecha_fin' => $fila['fecha_fin'],
                        'documentacion' => $fila['documentacion'],
                        'razon' => $fila['razon'],
                        'nit_empresa' => $fila['nit_empresa']
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
        $select .= "<option value='0'>Seleccione una empresa</option>";
        foreach ($conexion->getPDO()->query("SELECT id, nit_empresa FROM convenio ORDER BY id") as $fila) {
            $select .= "<option value='{$fila['id']}'>{$fila['nit_empresa']}</option>";
        }
        echo $json ? json_encode($select) : ("<select id='$id'>$select</select>");
    }

}