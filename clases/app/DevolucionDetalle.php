<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DevolucionDetalle
 *
 * @author Andres
 */
class DevolucionDetalle {
    
    private $id;
    private $codigoDevolucion;
    private $codigoProducto;
    private $idAlmacen;
    private $cantidad;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->codigoDevolucion = $datos['codigoDevolucion'];
                $this->codigoProducto = $datos['codigoProducto'];
                $this->idAlmacen = $datos['idAlmacen'];
                $this->cantidad = $datos['cantidad'];
            } else {
                $cadenaSQL = "select id, codigoDevolucion, codigoProducto, idAlmacen, cantidad from devolucionDetalle where id='$datos'";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $resultado[0]['id'];
                    $this->codigoDevolucion = $resultado[0]['codigoDevolucion'];
                    $this->codigoProducto = $resultado[0]['codigoProducto'];
                    $this->idAlmacen = $resultado[0]['idAlmacen'];
                    $this->cantidad = $resultado[0]['cantidad'];
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getCodigoDevolucion() {
        return $this->codigoDevolucion;
    }

    function getCodigoProducto() {
        return $this->codigoProducto;
    }
    
    function getProducto() {
        return new Productos($this->codigoProducto);
    }

    function getIdAlmacen() {
        return $this->idAlmacen;
    }

    function getCantidad() {
        return $this->cantidad;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigoDevolucion($codigoDevolucion) {
        $this->codigoDevolucion = $codigoDevolucion;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    function setIdAlmacen($idAlmacen) {
        $this->idAlmacen = $idAlmacen;
    }

    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function guardar() {
        $cadenaSQL = "insert into devolucionDetalle (codigoDevolucion, codigoProducto, idAlmacen, cantidad) values('{$this->codigoDevolucion}','{$this->codigoProducto}','{$this->idAlmacen}','{$this->cantidad}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update devolucionDetalle set codigoDevolucion='{$this->codigoDevolucion}', codigoProducto='{$this->codigoProducto}', idAlmacen='{$this->idAlmacen}', cantidad='{$this->cantidad}' where id='{$this->id}'";
        echo $cadenaSQL;
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from devolucionDetalle where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

     public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, codigoDevolucion, codigoProducto, idAlmacen, cantidad from devolucionDetalle $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $inventarios = null;
        $resultado = DevolucionDetalle::getLista($filtro, $orden);
        if(count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $inventario = new DevolucionDetalle($resultado[$i]);
                $inventarios[] = $inventario;
            }
        }
        return $inventarios;
    }

}