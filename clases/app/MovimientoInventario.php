<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MovimientoInventario
 *
 * @author Andres
 */
class MovimientoInventario {
    private $id;
    private $codigoProducto;
    private $idAlmacen;
    private $fechaHora;
    private $entrada;
    private $salida;
    private $saldo;
    private $tipoMovimiento;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->codigoProducto = $datos['codigoProducto'];
                $this->idAlmacen = $datos['idAlmacen'];
                $this->fechaHora = $datos['fechaHora'];
                $this->entrada = $datos['entrada'];
                $this->salida = $datos['salida'];
                $this->saldo = $datos['saldo'];
                $this->tipoMovimiento = $datos['tipoMovimiento'];
            } else {
                $cadenaSQL = "select id, codigoProducto, idAlmacen, fechaHora, entrada, salida, saldo, tipoMovimiento from movimientoInventario where id='$datos'";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $resultado[0]['id'];
                    $this->codigoProducto = $resultado[0]['codigoProducto'];
                    $this->idAlmacen = $resultado[0]['idAlmacen'];
                    $this->fechaHora = $resultado[0]['fechaHora'];
                    $this->entrada = $resultado[0]['entrada'];
                    $this->salida = $resultado[0]['salida'];
                    $this->saldo = $resultado[0]['saldo'];
                    $this->tipoMovimiento = $resultado[0]['tipoMovimiento'];
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getCodigoProducto() {
        return $this->codigoProducto;
    }
    
    function getProducto() {
        return new Productos($this->idAlmacen);
    }

    function getIdAlmacen() {
        return $this->idAlmacen;
    }

    function getFechaHora() {
        return $this->fechaHora;
    }

    function getEntrada() {
        return $this->entrada;
    }

    function getSalida() {
        return $this->salida;
    }

    function getSaldo() {
        return $this->saldo;
    }

    function getTipoMovimiento() {
        return $this->tipoMovimiento;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    function setIdAlmacen($idAlmacen) {
        $this->idAlmacen = $idAlmacen;
    }

    function setFechaHora($fechaHora) {
        $this->fechaHora = $fechaHora;
    }

    function setEntrada($entrada) {
        $this->entrada = $entrada;
    }

    function setSalida($salida) {
        $this->salida = $salida;
    }

    function setSaldo($saldo) {
        $this->saldo = $saldo;
    }

    function setTipoMovimiento($tipoMovimiento) {
        $this->tipoMovimiento = $tipoMovimiento;
    }

    public function guardar() {
        $cadenaSQL = "insert into movimientoInventario (codigoProducto, idAlmacen, fechaHora, entrada, salida, saldo, tipoMovimiento) values('{$this->codigoProducto}','{$this->idAlmacen}','{$this->fechaHora}','{$this->entrada}','{$this->salida}','{$this->saldo}','{$this->tipoMovimiento}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update movimientoInventario set codigoProducto='{$this->codigoProducto}', idAlmacen='{$this->idAlmacen}', fechaHora='{$this->fechaHora}', entrada='{$this->entrada}', salida='{$this->salida}', saldo='{$this->saldo}', tipoMovimiento='{$this->tipoMovimiento}' where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from movimientoInventario where id='{$this->id}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

     public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, codigoProducto, idAlmacen, fechaHora, entrada, salida, saldo, tipoMovimiento from movimientoInventario $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = MovimientoInventario::getLista($filtro, $orden);
        if(count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new MovimientoInventario($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

}