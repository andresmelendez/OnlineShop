<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grupo
 *
 * @author Andres
 */
class Grupo {
    
    private $id;
    private $nombre;
    private $idLinea;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->nombre = $datos['nombre'];
                $this->idLinea = $datos['idLinea'];
            } else {
                $cadenaSQL = "select nombre, idLinea from grupo where id='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $datos;
                    $this->nombre = $resultado[0]['nombre'];
                    $this->idLinea = $resultado[0]['idLinea'];
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
    
    function getIdLinea() {
        return $this->idLinea;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    function setIdLinea($idLinea) {
        $this->idLinea = $idLinea;
    }

    public function __toString() {
        return $this->nombre;
    }

    public function guardar() {
        $cadenaSQL = "insert into grupo (nombre, idLinea) values('{$this->nombre}','{$this->idLinea}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update grupo set nombre='{$this->nombre}', idLinea='{$this->idLinea}' where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from grupo where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, nombre, idLinea from grupo $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Grupo::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Grupo($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

    public static function getListaEnOptions($filtro = null, $orden = null, $predeterminado = null) {
        $objetos = Grupo::getListaEnObjetos($filtro, $orden);
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