<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ciudad
 *
 * @author Andres
 */
class Ciudad {
    
    private $codigo;
    private $nombre;
    private $codigoDepartamento;
    private $porcentaje;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->codigo = $datos['codigo'];
                $this->nombre = $datos['nombre'];
                $this->codigoDepartamento = $datos['codigoDepartamento'];
                $this->porcentaje = $datos['porcentaje'];
            } else {
                $cadenaSQL = "select nombre, codigoDepartamento, porcentaje from ciudad where codigo='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->codigo = $datos;
                    $this->nombre = $resultado[0]['nombre'];
                    $this->codigoDepartamento = $resultado[0]['codigoDepartamento'];
                    $this->porcentaje = $resultado[0]['porcentaje'];
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

    function getCodigoDepartamento() {
        return $this->codigoDepartamento;
    }
    
    public function getDepartamento() {
        return new Departamento($this->codigoDepartamento);
    }
    
    function getPorcentaje() {
        return $this->porcentaje;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodigoDepartamento($codigoDepartamento) {
        $this->codigoDepartamento = $codigoDepartamento;
    }
    
    function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }

    public function __toString() {
        return $this->nombre;
    }

    public function guardar() {
        $this->porcentaje = !empty($this->porcentaje) ? $this->porcentaje : 0;
        $cadenaSQL = "insert into ciudad (codigo, nombre, codigoDepartamento, porcentaje) values('{$this->codigo}','{$this->nombre}','{$this->codigoDepartamento}',{$this->porcentaje})";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($codigoAnterior) {
        $this->porcentaje = !empty($this->porcentaje) ? $this->porcentaje : 0;
        $cadenaSQL = "update ciudad set codigo='{$this->codigo}', nombre='{$this->nombre}', codigoDepartamento='{$this->codigoDepartamento}', porcentaje='{$this->porcentaje}' where codigo='$codigoAnterior'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from ciudad where codigo='{$this->codigo}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select codigo, nombre, codigoDepartamento, porcentaje from ciudad $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Ciudad::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Ciudad($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

    public static function getListaEnOptions($filtro = null, $orden = null, $predeterminado = null) {
        $objetos = Ciudad::getListaEnObjetos($filtro, $orden);
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