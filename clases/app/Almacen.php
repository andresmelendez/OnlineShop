<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Almacen
 *
 * @author Andres
 */
class Almacen {
    
    private $id;
    private $nombre;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->nombre = $datos['nombre'];
            } else {
                $cadenaSQL = "select nombre from almacen where id='$datos'  limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $datos;
                    $this->nombre = $resultado[0]['nombre'];
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

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function __toString() {
        return $this->nombre;
    }

    public function guardar() {
        $cadenaSQL = "insert into almacen (nombre) values('{$this->nombre}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update almacen set nombre='{$this->nombre}' where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from almacen where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, nombre from almacen $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Almacen::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Almacen($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

    public static function getListaEnOptions($filtro = null, $orden = null, $predeterminado = null) {
        $objetos = Almacen::getListaEnObjetos($filtro, $orden);
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