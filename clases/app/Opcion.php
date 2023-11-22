<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opcion
 *
 * @author Andres
 */
class Opcion {
    
    private $id;
    private $nombre;
    private $descripcion;
    private $ruta;
    private $idPadre;
    private $icono;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->nombre = $datos['nombre'];
                $this->descripcion = $datos['descripcion'];
                $this->ruta = $datos['ruta'];
                $this->idPadre = $datos['idPadre'];
                $this->icono = $datos['icono'];
            } else {
                $cadenaSQL = "select nombre, descripcion, idPadre, ruta, icono from opcion where id='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0) {
                    $this->id = $datos;
                    $this->nombre = $resultado[0]['nombre'];
                    $this->descripcion = $resultado[0]['descripcion'];
                    $this->ruta = $resultado[0]['ruta'];
                    $this->idPadre = $resultado[0]['idPadre'];
                    $this->icono = $resultado[0]['icono'];
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

    function getRuta() {
        return $this->ruta;
    }

    function getIdPadre() {
        return $this->idPadre;
    }

    public function getMenu() {
        return new Opcion($this->getIdPadre());
    }
    
    function getIcono() {
        return $this->icono;
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

    function setRuta($ruta) {
        $this->ruta = $ruta;
    }

    function setIdPadre($idPadre) {
        $this->idPadre = $idPadre;
    }
    
    function setIcono($icono) {
        $this->icono = $icono;
    }

    public function __toString() {
        return $this->nombre;
    }

    public function guardar() {
        if ($this->idPadre == "") $this->idPadre = 'null';
        else $this->idPadre = $this->idPadre;
        if ($this->ruta == "") $this->ruta = 'null';
        else $this->ruta = "'{$this->ruta}'";
        $cadenaSQL = "insert into opcion (nombre, descripcion, ruta, idPadre, icono) values('{$this->nombre}','{$this->descripcion}',{$this->ruta},{$this->idPadre},'{$this->icono}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        if ($this->idPadre == "") $this->idPadre = 'null';
        else $this->idPadre = $this->idPadre;
        if ($this->ruta == "") $this->ruta = 'null';
        else $this->ruta = "'{$this->ruta}'";
        $cadenaSQL = "update opcion set nombre='{$this->nombre}', descripcion='{$this->descripcion}', ruta={$this->ruta}, idPadre={$this->idPadre}, icono={$this->icono} where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from opcion where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, nombre, descripcion, ruta, idPadre, icono from opcion $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function getOpciones() {
        return Opcion::getListaEnObjetos("idPadre={$this->id}", null);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $opciones = null;
        $resultado = Opcion::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $opcion = new Opcion($resultado[$i]);
                $opciones[] = $opcion;
            }
        }
        return $opciones;
    }

}