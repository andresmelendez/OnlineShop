<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DescuentoProducto
 *
 * @author Andres
 */
class DescuentoProducto {
    
    private $id;
    private $tipo;
    private $nombreGrupo;
    private $margenXVolumen;
    private $margenXEmpaque;
    private $margenXTipo;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->tipo = $datos['tipo'];
                $this->nombreGrupo = $datos['nombreGrupo'];
                $this->margenXVolumen = $datos['margenXVolumen'];
                $this->margenXEmpaque = $datos['margenXEmpaque'];
                $this->margenXTipo = $datos['margenXTipo'];
            } else {
                $cadenaSQL = "select tipo, nombreGrupo, margenXVolumen, margenXEmpaque, margenXTipo from descuentoProducto where id='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0) {
                    $this->id = $datos;
                    $this->tipo = $resultado[0]['tipo'];
                    $this->nombreGrupo = $resultado[0]['nombreGrupo'];
                    $this->margenXVolumen = $resultado[0]['margenXVolumen'];
                    $this->margenXEmpaque = $resultado[0]['margenXEmpaque'];
                    $this->margenXTipo = $resultado[0]['margenXTipo'];
                }
            }
        }
    }

    
    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getNombreGrupo() {
        return $this->nombreGrupo;
    }

    function getMargenXVolumen() {
        return $this->margenXVolumen;
    }

    function getMargenXEmpaque() {
        return $this->margenXEmpaque;
    }

    function getMargenXTipo() {
        return $this->margenXTipo;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setNombreGrupo($nombreGrupo) {
        $this->nombreGrupo = $nombreGrupo;
    }

    function setMargenXVolumen($margenXVolumen) {
        $this->margenXVolumen = $margenXVolumen;
    }

    function setMargenXEmpaque($margenXEmpaque) {
        $this->margenXEmpaque = $margenXEmpaque;
    }

    function setMargenXTipo($margenXTipo) {
        $this->margenXTipo = $margenXTipo;
    }

    public function guardar() {
        $cadenaSQL = "insert into descuentoProducto (tipo, nombreGrupo, margenXVolumen, margenXEmpaque, margenXTipo) values('{$this->tipo}','{$this->nombreGrupo}',{$this->margenXVolumen},{$this->margenXEmpaque},'{$this->margenXTipo}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update descuentoProducto set tipo='{$this->tipo}', nombreGrupo='{$this->nombreGrupo}', margenXVolumen={$this->margenXVolumen}, margenXEmpaque={$this->margenXEmpaque}, margenXTipo={$this->margenXTipo} where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from descuentoProducto where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, tipo, nombreGrupo, margenXVolumen, margenXEmpaque, margenXTipo from descuentoProducto $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = DescuentoProducto::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new DescuentoProducto($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

}