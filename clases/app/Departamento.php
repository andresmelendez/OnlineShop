<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Departamento
 *
 * @author Andres
 */
class Departamento {
    private $codigo;
    private $nombre;
    private $codigoPais;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->codigo = $datos['codigo'];
                $this->nombre = $datos['nombre'];
                $this->codigoPais = $datos['codigoPais'];
            } else {
                $cadenaSQL = "select nombre, codigoPais from departamento where codigo='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->codigo = $datos;
                    $this->nombre = $resultado[0]['nombre'];
                    $this->codigoPais = $resultado[0]['codigoPais'];
                }
            }
        }
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodigoPais() {
        return $this->codigoPais;
    }
    
    public function getPais() {
        return new Pais($this->codigoPais);
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodigoPais($codigoPais) {
        $this->codigoPais = $codigoPais;
    }

    public function __toString() {
        return $this->nombre;
    }

    public function guardar() {
        $cadenaSQL = "insert into departamento (codigo, nombre, codigoPais) values('{$this->codigo}','{$this->nombre}','{$this->codigoPais}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($codigoAnterior) {
        $cadenaSQL = "update departamento set codigo='{$this->codigo}', nombre='{$this->nombre}', codigoPais='{$this->codigoPais}' where codigo='$codigoAnterior'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from departamento where codigo='{$this->codigo}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select codigo, nombre, codigoPais from departamento $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Departamento::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Departamento($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

    public static function getListaEnOptions($filtro = null, $orden = null, $predeterminado = null) {
        $objetos = Departamento::getListaEnObjetos($filtro, $orden);
        $lista = "";
        if ($objetos != null) {
            for ($i = 0; $i < count($objetos); $i++) {
                $objeto = $objetos[$i];
                $auxiliar = $predeterminado === $objeto->getCodigo() ? "selected" : '';
                $lista .= "<option value='{$objeto->getCodigo()}' $auxiliar>{$objeto->getNombre()}</option>";
            }
        }
        return $lista;
    }

}