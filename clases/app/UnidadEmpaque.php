<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UnidadEmpaque
 *
 * @author Andres
 */
class UnidadEmpaque {
    
    private $id;
    private $unidad;
    private $observaciones;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->unidad = $datos['unidad'];
                $this->observaciones = $datos['observaciones'];
            } else {
                $cadenaSQL = "select unidad, observaciones from unidadEmpaque where id='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $datos;
                    $this->unidad = $resultado[0]['unidad'];
                    $this->observaciones = $resultado[0]['observaciones'];
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getUnidad() {
        return $this->unidad;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUnidad($unidad) {
        $this->unidad = $unidad;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    public function __toString() {
        return $this->unidad;
    }

    public function guardar() {
        $cadenaSQL = "insert into unidadEmpaque (unidad, observaciones) values('{$this->unidad}','{$this->observaciones}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update unidadEmpaque set unidad='{$this->unidad}', observaciones='{$this->observaciones}' where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from unidadEmpaque where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, unidad, observaciones from unidadEmpaque $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = UnidadEmpaque::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new UnidadEmpaque($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

    public static function getListaEnOptions($filtro = null, $orden = null, $predeterminado = null) {
        $objetos = UnidadEmpaque::getListaEnObjetos($filtro, $orden);
        $lista = "";
        if ($objetos != null) {
            for ($i = 0; $i < count($objetos); $i++) {
                $objeto = $objetos[$i];
                $auxiliar = $predeterminado === $objeto->getId() ? "selected" : '';
                $lista .= "<option value='{$objeto->getId()}' $auxiliar>{$objeto->getUnidad()}</option>";
            }
        }
        return $lista;
    }

}