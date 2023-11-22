<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Producto
 *
 * @author Andres
 */
class Producto {
    
    private $codigo;
    private $descripcion;
    private $idMarca;
    private $idGrupo;
    private $idImpuesto;
    private $idUnidadCompra;
    private $cantidadCompra;
    private $idUnidadVenta;
    private $cantidadVenta;
    private $cantidadVolumen;
    private $codigoDeBarras;
    private $precio;
    private $costo;
    private $promocion;
    private $tipoServicio;
    private $foto;
    private $foto1;
    private $foto2;
    private $estado;
    private $caracteristicas;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->codigo = $datos['codigo'];
                $this->descripcion = $datos['descripcion'];
                $this->idMarca = $datos['idMarca'];
                $this->idGrupo = $datos['idGrupo'];
                $this->idImpuesto = $datos['longitud'];
                $this->idUnidadCompra = $datos['idUnidadCompra'];
                $this->cantidadCompra = $datos['cantidadCompra'];
                $this->idUnidadVenta = $datos['idUnidadVenta'];
                $this->cantidadVenta = $datos['cantidadVenta'];
                $this->cantidadVolumen = $datos['cantidadVolumen'];
                $this->codigoDeBarras = $datos['codigoDeBarras'];
                $this->precio = $datos['precio'];
                $this->costo = $datos['costo'];
                $this->promocion = $datos['promocion'];
                $this->tipoServicio = $datos['tipoServicio'];
                $this->foto = $datos['foto'];
                $this->foto1 = $datos['foto1'];
                $this->foto2 = $datos['foto2'];
                $this->estado = $datos['estado'];
                $this->caracteristicas = $datos['caracteristicas'];
            } else {
                $cadenaSQL = "select descripcion, idMarca, idGrupo, idImpuesto, idUnidadCompra, cantidadCompra, idUnidadVenta, cantidadVenta, cantidadVolumen, codigoDeBarras, precio, costo, promocion, tipoServicio, foto, foto1, foto2, estado, caracteristicas from producto where codigo='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->codigo = $datos;
                    $this->descripcion = $resultado[0]['descripcion'];
                    $this->idMarca = $resultado[0]['idMarca'];
                    $this->idGrupo = $resultado[0]['idGrupo'];
                    $this->idImpuesto = $resultado[0]['idImpuesto'];
                    $this->idUnidadCompra = $resultado[0]['idUnidadCompra'];
                    $this->cantidadCompra = $resultado[0]['cantidadCompra'];
                    $this->idUnidadVenta = $resultado[0]['idUnidadVenta'];
                    $this->cantidadVenta = $resultado[0]['cantidadVenta'];
                    $this->cantidadVolumen = $resultado[0]['cantidadVolumen'];
                    $this->codigoDeBarras = $resultado[0]['codigoDeBarras'];
                    $this->precio = $resultado[0]['precio'];
                    $this->costo = $resultado[0]['costo'];
                    $this->promocion = $resultado[0]['promocion'];
                    $this->tipoServicio = $resultado[0]['tipoServicio'];
                    $this->foto = $resultado[0]['foto'];
                    $this->foto1 = $resultado[0]['foto1'];
                    $this->foto2 = $resultado[0]['foto2'];
                    $this->estado = $resultado[0]['estado'];
                    $this->caracteristicas = $resultado[0]['caracteristicas'];
                }
            }
        }
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getIdMarca() {
        return $this->idMarca;
    }

    function getIdGrupo() {
        return $this->idGrupo;
    }
    
    public function getGrupo(){
        return new Grupo($this->idGrupo);
    }

    function getIdImpuesto() {
        return $this->idImpuesto;
    }
    
    function getImpuesto(){
        return new Impuesto($this->idImpuesto);
    }

    function getIdUnidadCompra() {
        return $this->idUnidadCompra;
    }

    function getCantidadCompra() {
        return $this->cantidadCompra;
    }

    function getIdUnidadVenta() {
        return $this->idUnidadVenta;
    }

    function getCantidadVenta() {
        return $this->cantidadVenta;
    }
    
    function getCantidadVolumen() {
        return $this->cantidadVolumen;
    }

    function getCodigoDeBarras() {
        return $this->codigoDeBarras;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getCosto() {
        return $this->costo;
    }

    function getPromocion() {
        return $this->promocion;
    }
    
    function getTipoServicio() {
        return $this->tipoServicio;
    }

    function getFoto() {
        return $this->foto;
    }

    function getFoto1() {
        return $this->foto1;
    }

    function getFoto2() {
        return $this->foto2;
    }

    function getEstado() {
        return $this->estado;
    }

    function getCaracteristicas() {
        return $this->caracteristicas;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setIdMarca($idMarca) {
        $this->idMarca = $idMarca;
    }

    function setIdGrupo($idGrupo) {
        $this->idGrupo = $idGrupo;
    }

    function setIdImpuesto($idImpuesto) {
        $this->idImpuesto = $idImpuesto;
    }

    function setIdUnidadCompra($idUnidadCompra) {
        $this->idUnidadCompra = $idUnidadCompra;
    }

    function setCantidadCompra($cantidadCompra) {
        $this->cantidadCompra = $cantidadCompra;
    }

    function setIdUnidadVenta($idUnidadVenta) {
        $this->idUnidadVenta = $idUnidadVenta;
    }

    function setCantidadVenta($cantidadVenta) {
        $this->cantidadVenta = $cantidadVenta;
    }
    
    function setCantidadVolumen($cantidadVolumen) {
        $this->cantidadVolumen = $cantidadVolumen;
    }

    function setCodigoDeBarras($codigoDeBarras) {
        $this->codigoDeBarras = $codigoDeBarras;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setCosto($costo) {
        $this->costo = $costo;
    }

    function setPromocion($promocion) {
        $this->promocion = $promocion;
    }
    
    function setTipoServicio($tipoServicio) {
        $this->tipoServicio = $tipoServicio;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setFoto1($foto1) {
        $this->foto1 = $foto1;
    }

    function setFoto2($foto2) {
        $this->foto2 = $foto2;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setCaracteristicas($caracteristicas) {
        $this->caracteristicas = $caracteristicas;
    }

    public function __toString() {
        return $this->descripcion;
    }

    public function guardar() {
        $cadenaSQL = "insert into producto (codigo, descripcion, idMarca, idGrupo, idImpuesto, idUnidadCompra, cantidadCompra, idUnidadVenta, cantidadVenta, cantidadVolumen, codigoDeBarras, precio, costo, promocion, tipoServicio, foto, foto1, foto2, estado, caracteristicas) values('{$this->codigo}','{$this->descripcion}','{$this->idMarca}','{$this->idGrupo}','{$this->idImpuesto}','{$this->idUnidadCompra}','{$this->cantidadCompra}','{$this->idUnidadVenta}','{$this->cantidadVenta}','{$this->cantidadVolumen}','{$this->codigoDeBarras}','{$this->precio}','{$this->costo}','{$this->promocion}','{$this->tipoServicio}','{$this->foto}','{$this->foto1}','{$this->foto2}','{$this->estado}','{$this->caracteristicas}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($codigoAnterior) {
        $cadenaSQL = "update producto set codigo='{$this->codigo}', descripcion='{$this->descripcion}', idMarca='{$this->idMarca}', idGrupo='{$this->idGrupo}', idImpuesto='{$this->idImpuesto}', idUnidadCompra='{$this->idUnidadCompra}', cantidadCompra='{$this->cantidadCompra}', idUnidadVenta='{$this->idUnidadVenta}', cantidadVenta='{$this->cantidadVenta}', cantidadVolumen='{$this->cantidadVolumen}', codigoDeBarras='{$this->codigoDeBarras}', precio='{$this->precio}', costo='{$this->costo}', promocion='{$this->promocion}', tipoServicio='{$this->tipoServicio}', foto='{$this->foto}', foto1='{$this->foto1}', foto2='{$this->foto2}', estado='{$this->estado}', caracteristicas='{$this->caracteristicas}' where codigo='$codigoAnterior'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from producto where codigo='{$this->codigo}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select codigo, descripcion, idMarca, idGrupo, idImpuesto, idUnidadCompra, cantidadCompra, idUnidadVenta, cantidadVenta, cantidadVolumen, codigoDeBarras, precio, costo, promocion, tipoServicio, foto, foto1, foto2, estado, caracteristicas from producto $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }
    
    public static function getPreciosCompras($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "SELECT codigo, descripcion, costo, impuesto.porcentaje, ROUND(costo - ((costo * (IFNULL(usuarios.descuentoFinanciero, 0) / 100)) + (costo * (IFNULL(usuarios.bonificacion, 0) / 100)) + (costo *(IFNULL(usuarios.descuentoComercial, 0) / 100))) + (costo*(impuesto.porcentaje / 100))) AS precio, inventario.stock - inventario.comprometido AS disponible, inventario.pedido, producto.cantidadVenta, foto FROM producto JOIN productoUsuario ON producto.codigo = productoUsuario.codigoProducto JOIN usuarios ON usuarios.nit = productoUsuario.nitUsuario JOIN impuesto ON impuesto.id = producto.idImpuesto JOIN inventario ON inventario.codigoProducto = producto.codigo $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }
    
    public static function getPreciosVentas($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "SELECT DISTINCT codigo, descripcion, producto.cantidadVenta, producto.cantidadVolumen, ROUND(producto.precio / (100 - descuentoProducto.margenXTipo) * 100) AS precio, inventario.stock - inventario.comprometido AS disponible, margenXVolumen, margenXEmpaque, producto.foto FROM producto JOIN inventario ON inventario.codigoProducto = producto.codigo JOIN grupo ON grupo.id = producto.idGrupo JOIN descuentoProducto ON descuentoProducto.nombreGrupo = SUBSTRING(producto.codigo, 1, 4) AND margenXTipo > 0 $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Producto::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Producto($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

    public static function getListaEnOptions($filtro = null, $orden = null, $predeterminado = null) {
        $objetos = Producto::getListaEnObjetos($filtro, $orden);
        $lista = "";
        if ($objetos != null) {
            for ($i = 0; $i < count($objetos); $i++) {
                $objeto = $objetos[$i];
                $auxiliar = $predeterminado === $objeto->getCodigo() ? "selected" : '';
                $lista .= "<option value='{$objeto->getCodigo()}' $auxiliar>{$objeto->getDescripcion()}</option>";
            }
        }
        return $lista;
    }

}