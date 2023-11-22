<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Devolucion
 *
 * @author Andres
 */
class Devolucion {
    
    private $codigo;
    private $nitCliente;
    private $nitVendedor;
    private $nitProveedor;
    private $fechaHoraDocumento;
    private $estado;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->codigo = $datos['codigo'];
                $this->nitCliente = $datos['nitCliente'];
                $this->nitVendedor = $datos['nitVendedor'];
                $this->nitProveedor = $datos['nitProveedor'];
                $this->fechaHoraDocumento = $datos['fechaHoraDocumento'];
                $this->estado = $datos['estado'];
            } else {
                $cadenaSQL = "select nitCliente, nitVendedor, nitProveedor, fechaHoraDocumento, estado from devolucion where codigo='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->codigo = $datos;
                    $this->nitCliente = $resultado[0]['nitCliente'];
                    $this->nitVendedor = $resultado[0]['nitVendedor'];
                    $this->nitProveedor = $resultado[0]['nitProveedor'];
                    $this->fechaHoraDocumento = $resultado[0]['fechaHoraDocumento'];
                    $this->estado = $resultado[0]['estado'];
                }
            }
        }
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNitCliente() {
        return $this->nitCliente;
    }

    function getNitVendedor() {
        return $this->nitVendedor;
    }

    function getNitProveedor() {
        return $this->nitProveedor;
    }

    function getFechaHoraDocumento() {
        return $this->fechaHoraDocumento;
    }

    function getEstado() {
        return $this->estado;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNitCliente($nitCliente) {
        $this->nitCliente = $nitCliente;
    }

    function setNitVendedor($nitVendedor) {
        $this->nitVendedor = $nitVendedor;
    }

    function setNitProveedor($nitProveedor) {
        $this->nitProveedor = $nitProveedor;
    }

    function setFechaHoraDocumento($fechaHoraDocumento) {
        $this->fechaHoraDocumento = $fechaHoraDocumento;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    public function guardar() {
        $cadenaSQL = "insert into devolucion (codigo, nitCliente, nitVendedor, nitProveedor, fechaHoraDocumento, estado) values('{$this->codigo}','{$this->nitCliente}','{$this->nitVendedor}','{$this->nitProveedor}','{$this->fechaHoraDocumento}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($codigoAnterior) {
        $cadenaSQL = "update devolucion set codigo='{$this->codigo}', nitCliente='{$this->nitCliente}', nitVendedor='{$this->nitVendedor}', nitProveedor='{$this->nitProveedor}', fechaHoraDocumento='{$this->fechaHoraDocumento}', estado='{$this->estado}' where codigo='$codigoAnterior'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from devolucion where codigo='{$this->codigo}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select codigo, codigo, nitCliente, nitVendedor, nitProveedor, fechaHoraDocumento, estado from devolucion $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Devolucion::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Devolucion($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

}