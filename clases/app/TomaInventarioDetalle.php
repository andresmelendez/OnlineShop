<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TomaInventarioDetalle
 *
 * @author Andres
 */
class TomaInventarioDetalle {
    
    private $id;
    private $idTomaInventario;
    private $codigoProducto;
    private $idAlmacen;
    private $cantidadSistema;
    private $cantidadEncontrada;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->idTomaInventario = $datos['idTomaInventario'];
                $this->codigoProducto = $datos['codigoProducto'];
                $this->idAlmacen = $datos['idAlmacen'];
                $this->cantidadSistema = $datos['cantidadSistema'];
                $this->cantidadEncontrada = $datos['cantidadEncontrada'];
            } else {
                $cadenaSQL = "select id, idTomaInventario, codigoProducto, idAlmacen, cantidadSistema, cantidadEncontrada from tomaInventarioDetalle where id='$datos'";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $resultado[0]['id'];
                    $this->idTomaInventario = $resultado[0]['idTomaInventario'];
                    $this->codigoProducto = $resultado[0]['codigoProducto'];
                    $this->idAlmacen = $resultado[0]['idAlmacen'];
                    $this->cantidadSistema = $resultado[0]['cantidadSistema'];
                    $this->cantidadEncontrada = $resultado[0]['cantidadEncontrada'];
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getIdTomaInventario() {
        return $this->idTomaInventario;
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

    function getCantidadSistema() {
        return $this->cantidadSistema;
    }

    function getCantidadEncontrada() {
        return $this->cantidadEncontrada;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdTomaInventario($idTomaInventario) {
        $this->idTomaInventario = $idTomaInventario;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    function setIdAlmacen($idAlmacen) {
        $this->idAlmacen = $idAlmacen;
    }

    function setCantidadSistema($cantidadSistema) {
        $this->cantidadSistema = $cantidadSistema;
    }

    function setCantidadEncontrada($cantidadEncontrada) {
        $this->cantidadEncontrada = $cantidadEncontrada;
    }

    public function guardar() {
        $cadenaSQL = "insert into tomaInventarioDetalle (idTomaInventario, codigoProducto, idAlmacen, cantidadSistema, cantidadEncontrada) values('{$this->idTomaInventario}','{$this->codigoProducto}','{$this->idAlmacen}','{$this->cantidadSistema}','{$this->cantidadEncontrada}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update tomaInventarioDetalle set idTomaInventario='{$this->idTomaInventario}', codigoProducto='{$this->codigoProducto}', idAlmacen='{$this->idAlmacen}', cantidadSistema='{$this->cantidadSistema}', cantidadEncontrada='{$this->cantidadEncontrada}' where id='{$this->id}'";
        echo $cadenaSQL;
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from tomaInventarioDetalle where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

     public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, idTomaInventario, codigoProducto, idAlmacen, cantidadSistema, cantidadEncontrada from tomaInventarioDetalle $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = TomaInventarioDetalle::getLista($filtro, $orden);
        if(count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new TomaInventarioDetalle($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

}