<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Horario
 *
 * @author Andres
 */
class Horario {
    
    private $id;
    private $dia;
    private $horaInicio;
    private $horaFin;
    private $nitEmpresa;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->dia = $datos['dia'];
                $this->horaInicio = $datos['horaInicio'];
                $this->horaFin = $datos['horaFin'];
                $this->nitEmpresa = $datos['nitEmpresa'];
            } else {
                $cadenaSQL = "select dia, horaInicio, horaFin, nitEmpresa from horario where id='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $datos;
                    $this->dia = $resultado[0]['dia'];
                    $this->horaInicio = $resultado[0]['horaInicio'];
                    $this->horaFin = $resultado[0]['horaFin'];
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

    function getHoraInicio() {
        return $this->horaInicio;
    }

    function getHoraFin() {
        return $this->horaFin;
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

    function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    function setHoraFin($horaFin) {
        $this->horaFin = $horaFin;
    }

    function setNitEmpresa($nitEmpresa) {
        $this->nitEmpresa = $nitEmpresa;
    }

    public function guardar() {
        $cadenaSQL = "insert into horario (dia, horaInicio, horaFin, nitEmpresa) values({$this->dia}','{$this->horaInicio}','{$this->horaFin}','{$this->nitEmpresa}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($nitAnterior) {
        $cadenaSQL = "update horario set dia='{$this->dia}', horaInicio='{$this->horaInicio}', horaFin='{$this->horaFin}', nitEmpresa='{$this->nitEmpresa}' where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from horario where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, dia, horaInicio, horaFin, nitEmpresa from horario $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Horario::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Horario($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

}