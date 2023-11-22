<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Festivos
 *
 * @author Andres
 */
class Festivos {
    
    private $id;
    private $dia;
    private $mes;
    private $nitEmpresa;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->dia = $datos['dia'];
                $this->mes = $datos['mes'];
                $this->nitEmpresa = $datos['nitEmpresa'];
            } else {
                $cadenaSQL = "select dia, mes, nitEmpresa from festivos where id='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $datos;
                    $this->dia = $resultado[0]['dia'];
                    $this->mes = $resultado[0]['mes'];
                    $this->nitEmpresa = $resultado[0]['nitEmpresa'];
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getDia() {
        return $this->dia;
    }

    function getMes() {
        return $this->mes;
    }

    function getNitEmpresa() {
        return $this->nitEmpresa;
    }
    
    public function getEmpresa() {
        return new Empresa($this->nitEmpresa);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDia($dia) {
        $this->dia = $dia;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function setNitEmpresa($nitEmpresa) {
        $this->nitEmpresa = $nitEmpresa;
    }

    public function guardar() {
        $cadenaSQL = "insert into festivos (dia, mes, nitEmpresa) values({$this->dia}','{$this->mes}','{$this->nitEmpresa}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($nitAnterior) {
        $cadenaSQL = "update festivos set dia='{$this->dia}', mes='{$this->mes}', nitEmpresa='{$this->nitEmpresa}' where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from festivos where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, dia, mes, nitEmpresa from festivos $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Festivos::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Festivos($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

}