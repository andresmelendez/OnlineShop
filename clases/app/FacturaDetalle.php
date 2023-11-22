<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FacturaDetalle
 *
 * @author Andres
 */
class FacturaDetalle {
    
    private $id;
    private $codigoFactura;
    private $codigoProducto;
    private $idAlmacen;
    private $cantidadSolicitada;
    private $cantidadRecibida;
    private $precio;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->codigoFactura = $datos['codigoFactura'];
                $this->codigoProducto = $datos['codigoProducto'];
                $this->idAlmacen = $datos['idAlmacen'];
                $this->cantidadSolicitada = $datos['cantidadSolicitada'];
                $this->cantidadRecibida = $datos['cantidadRecibida'];
                $this->precio = $datos['precio'];
            } else {
                $cadenaSQL = "select id, codigoFactura, codigoProducto, idAlmacen, cantidadSolicitada, cantidadRecibida, precio from facturaDetalle where id='$datos'";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $resultado[0]['id'];
                    $this->codigoFactura = $resultado[0]['codigoFactura'];
                    $this->codigoProducto = $resultado[0]['codigoProducto'];
                    $this->idAlmacen = $resultado[0]['idAlmacen'];
                    $this->cantidadSolicitada = $resultado[0]['cantidadSolicitada'];
                    $this->cantidadRecibida = $resultado[0]['cantidadRecibida'];
                    $this->precio = $resultado[0]['precio'];
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getCodigoFactura() {
        return $this->codigoFactura;
    }

    function getCodigoProducto() {
        return $this->codigoProducto;
    }
    
    function getProducto() {
        return new Producto($this->codigoProducto);
    }

    function getIdAlmacen() {
        return $this->idAlmacen;
    }

    function getCantidadSolicitada() {
        return $this->cantidadSolicitada;
    }

    function getCantidadRecibida() {
        return $this->cantidadRecibida;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigoFactura($codigoFactura) {
        $this->codigoFactura = $codigoFactura;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    function setIdAlmacen($idAlmacen) {
        $this->idAlmacen = $idAlmacen;
    }

    function setCantidadSolicitada($cantidadSolicitada) {
        $this->cantidadSolicitada = $cantidadSolicitada;
    }

    function setCantidadRecibida($cantidadRecibida) {
        $this->cantidadRecibida = $cantidadRecibida;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function guardar() {
        $cadenaSQL = "insert into facturaDetalle (codigoFactura, codigoProducto, idAlmacen, cantidadSolicitada, cantidadRecibida, precio) values('{$this->codigoFactura}','{$this->codigoProducto}','{$this->idAlmacen}','{$this->cantidadSolicitada}','{$this->cantidadRecibida}','{$this->precio}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update facturaDetalle set codigoFactura='{$this->codigoFactura}', codigoProducto='{$this->codigoProducto}', idAlmacen='{$this->idAlmacen}', cantidadSolicitada='{$this->cantidadSolicitada}', cantidadRecibida='{$this->cantidadRecibida}', precio='{$this->precio}' where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from facturaDetalle where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

     public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, codigoFactura, codigoProducto, producto.codigoDeBarras, descripcion, idAlmacen, cantidadSolicitada, cantidadRecibida, facturaDetalle.precio from facturaDetalle join producto ON producto.codigo = facturaDetalle.codigoProducto $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = FacturaDetalle::getLista($filtro, $orden);
        if(count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new FacturaDetalle($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

}