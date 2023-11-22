<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Perfil
 *
 * @author Andres
 */
class Perfil {
    
    private $id;
    private $nombre;
    private $descripcion;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->nombre = $datos['nombre'];
                $this->descripcion = $datos['descripcion'];
            } else {
                $cadenaSQL = "select nombre, descripcion from perfil where id=$datos";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0) {
                    $this->id = $datos;
                    $this->nombre = $resultado[0]['nombre'];
                    $this->descripcion = $resultado[0]['descripcion'];
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

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function __toString() {
        return $this->nombre;
    }

    public function guardarAccesos($accesos) {
        $cadenaSQL = " delete from opcionPerfil where idPerfil={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
        $valores = "({$this->id}," . str_replace(',', "),({$this->id},", $accesos . ')');
        $cadenaSQL = "insert into opcionPerfil(idPerfil, idOpcion) values $valores";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function guardar() {
        $cadenaSQL = "insert into perfil (nombre, descripcion) values('{$this->nombre}','{$this->descripcion}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update perfil set nombre='{$this->nombre}', descripcion='{$this->descripcion}' where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from perfil where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, nombre, descripcion from perfil $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function getOpciones() {
        $cadenaSQL = "select idOpcion from opcionPerfil where idPerfil={$this->id}";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Perfil::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Perfil($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

    public static function getListaEnOptions($filtro = null, $orden = null, $predeterminado = null) {
        $lista = "";
        $objetos = Perfil::getListaEnObjetos($filtro, $orden);
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