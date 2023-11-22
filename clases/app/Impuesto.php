<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Impuesto
 *
 * @author Andres
 */
class Impuesto {
    
    private $id;
    private $nombre;
    private $porcentaje;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->nombre = $datos['nombre'];
                $this->porcentaje = $datos['porcentaje'];
            } else {
                $cadenaSQL = "select nombre, porcentaje from impuesto where id='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $datos;
                    $this->nombre = $resultado[0]['nombre'];
                    $this->porcentaje = $resultado[0]['porcentaje'];
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }
    
    function getPorcentaje() {
        return $this->porcentaje;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }

    public function __toString() {
        return $this->nombre;
    }

    public function guardar() {
        $cadenaSQL = "insert into impuesto (nombre, porcentaje) values('{$this->nombre}','{$this->porcentaje}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update impuesto set nombre='{$this->nombre}', porcentaje='{$this->porcentaje}' where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from impuesto where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, nombre, porcentaje from impuesto $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Impuesto::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Impuesto($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

    public static function getListaEnOptions($filtro = null, $orden = null, $predeterminado = null) {
        $objetos = Impuesto::getListaEnObjetos($filtro, $orden);
        $lista = "";
        if ($objetos != null) {
            for ($i = 0; $i < count($objetos); $i++) {
                $objeto = $objetos[$i];
                $auxiliar = $predeterminado === $objeto->getId() ? "selected" : '';
                $lista .= "<option value='{$objeto->getId()}' $auxiliar>{$objeto->getNombre()}</option>";
            }
        }
        return $lista;
    }

}