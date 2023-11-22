<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Inventario
 *
 * @author Andres
 */
class Inventario {
    
    private $id;
    private $idAlmacen;
    private $codigoProducto;
    private $stock;
    private $stockMaximo;
    private $stockMinimo;
    private $comprometido;
    private $pedido;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->idAlmacen = $datos['idAlmacen'];
                $this->codigoProducto = $datos['codigoProducto'];
                $this->stock = $datos['stock'];
                $this->stockMaximo = $datos['stockMaximo'];
                $this->stockMinimo = $datos['stockMinimo'];
                $this->comprometido = $datos['comprometido'];
                $this->pedido = $datos['pedido'];
            } else {
                $cadenaSQL = "select id, idAlmacen, codigoProducto, stock, stockMaximo, stockMinimo, comprometido, pedido from inventario where id='$datos'";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $resultado[0]['id'];
                    $this->idAlmacen = $resultado[0]['idAlmacen'];
                    $this->codigoProducto = $resultado[0]['codigoProducto'];
                    $this->stock = $resultado[0]['stock'];
                    $this->stockMaximo = $resultado[0]['stockMaximo'];
                    $this->stockMinimo = $resultado[0]['stockMinimo'];
                    $this->comprometido = $resultado[0]['comprometido'];
                    $this->pedido = $resultado[0]['pedido'];
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getIdAlmacen() {
        return $this->idAlmacen;
    }

    function getCodigoProducto() {
        return $this->codigoProducto;
    }
    
    function getProducto() {
        return new Productos($this->codigoProducto);
    }

    function getStock() {
        return $this->stock;
    }

    function getStockMaximo() {
        return $this->stockMaximo;
    }

    function getStockMinimo() {
        return $this->stockMinimo;
    }

    function getComprometido() {
        return $this->comprometido;
    }

    function getPedido() {
        return $this->pedido;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdAlmacen($idAlmacen) {
        $this->idAlmacen = $idAlmacen;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    function setStock($stock) {
        $this->stock = $stock;
    }

    function setStockMaximo($stockMaximo) {
        $this->stockMaximo = $stockMaximo;
    }

    function setStockMinimo($stockMinimo) {
        $this->stockMinimo = $stockMinimo;
    }

    function setComprometido($comprometido) {
        $this->comprometido = $comprometido;
    }

    function setPedido($pedidoOC) {
        $this->pedido = $pedidoOC;
    }

    public function guardar() {
        $cadenaSQL = "insert into inventario (idAlmacen, codigoProducto, stock, stockMaximo, stockMinimo, comprometido, pedido) values('{$this->idAlmacen}','{$this->codigoProducto}','{$this->stock}','{$this->stockMaximo}','{$this->stockMinimo}','{$this->comprometido}','{$this->pedido}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update inventario set idAlmacen='{$this->idAlmacen}', codigoProducto='{$this->codigoProducto}', stock='{$this->stock}', stockMaximo='{$this->stockMaximo}', stockMinimo='{$this->stockMinimo}', comprometido='{$this->comprometido}', pedido='{$this->pedido}' where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from inventario where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

     public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, idAlmacen, codigoProducto, stock, stockMaximo, stockMinimo, comprometido, pedido, stock - comprometido AS disponible from inventario $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $inventarios = null;
        $resultado = Inventario::getLista($filtro, $orden);
        if(count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $inventario = new Inventario($resultado[$i]);
                $inventarios[] = $inventario;
            }
        }
        return $inventarios;
    }

}