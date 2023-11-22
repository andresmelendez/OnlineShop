<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TomaInventario
 *
 * @author Andres
 */
class TomaInventario {
    
    private $id;
    private $nitResponsable;
    private $fechaHoraDocumento;
    private $estado;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->nitResponsable = $datos['nitResponsable'];
                $this->fechaHoraDocumento = $datos['fechaHoraDocumento'];
                $this->estado = $datos['estado'];
            } else {
                $cadenaSQL = "select nitResponsable, fechaHoraDocumento, estado from tomaInventario where id='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $datos;
                    $this->nitResponsable = $resultado[0]['nitResponsable'];
                    $this->fechaHoraDocumento = $resultado[0]['fechaHoraDocumento'];
                    $this->estado = $resultado[0]['estado'];
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getNitResponsable() {
        return $this->nitResponsable;
    }

    function getFechaHoraDocumento() {
        return $this->fechaHoraDocumento;
    }

    function getEstado() {
        return $this->estado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNitResponsable($nitResponsable) {
        $this->nitResponsable = $nitResponsable;
    }

    function setFechaHoraDocumento($fechaHoraDocumento) {
        $this->fechaHoraDocumento = $fechaHoraDocumento;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function guardar() {
        $cadenaSQL = "insert into tomaInventario (nitResponsable, fechaHoraDocumento, estado) values({$this->nitResponsable}','{$this->fechaHoraDocumento}','{$this->estado}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($nitAnterior) {
        $cadenaSQL = "update tomaInventario set nitResponsable='{$this->nitResponsable}', fechaHoraDocumento='{$this->fechaHoraDocumento}', estado='{$this->estado}' where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from tomaInventario where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, nitResponsable, fechaHoraDocumento, estado from tomaInventario $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = TomaInventario::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new TomaInventario($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

}