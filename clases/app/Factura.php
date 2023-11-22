<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Factura
 *
 * @author Andres
 */
class Factura {
    
    private $codigo;
    private $nitCliente;
    private $nitVendedor;
    private $nitProveedor;
    private $idMedioDePago;
    private $fechaHoraDocumento;
    private $fechaHoraAcopio;
    private $fechaHoraFacturacion;
    private $fechaHoraDespacho;
    private $fechaHoraEntrega;
    private $observacion;
    private $total;
    private $flete;
    private $tipo;
    private $estado;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->codigo = $datos['codigo'];
                $this->nitCliente = $datos['nitCliente'];
                $this->nitVendedor = $datos['nitVendedor'];
                $this->nitProveedor = $datos['nitProveedor'];
                $this->idMedioDePago = $datos['idMedioDePago'];
                $this->fechaHoraDocumento = $datos['fechaHoraDocumento'];
                $this->fechaHoraAcopio = $datos['fechaHoraAcopio'];
                $this->fechaHoraFacturacion = $datos['fechaHoraFacturacion'];
                $this->fechaHoraDespacho = $datos['fechaHoraDespacho'];
                $this->fechaHoraEntrega = $datos['fechaHoraEntrega'];
                $this->observacion = $datos['observacion'];
                $this->total = $datos['total'];
                $this->flete = $datos['flete'];
                $this->tipo = $datos['tipo'];
                $this->estado = $datos['estado'];
            } else {
                $cadenaSQL = "select nitCliente, nitVendedor, nitProveedor, idMedioDePago, fechaHoraDocumento, fechaHoraAcopio, fechaHoraFacturacion, fechaHoraDespacho, fechaHoraEntrega, observacion, total, flete, tipo, estado from factura where codigo='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->codigo = $datos;
                    $this->nitCliente = $resultado[0]['nitCliente'];
                    $this->nitVendedor = $resultado[0]['nitVendedor'];
                    $this->nitProveedor = $resultado[0]['nitProveedor'];
                    $this->idMedioDePago = $resultado[0]['idMedioDePago'];
                    $this->fechaHoraDocumento = $resultado[0]['fechaHoraDocumento'];
                    $this->fechaHoraAcopio = $resultado[0]['fechaHoraAcopio'];
                    $this->fechaHoraFacturacion = $resultado[0]['fechaHoraFacturacion'];
                    $this->fechaHoraDespacho = $resultado[0]['fechaHoraDespacho'];
                    $this->fechaHoraEntrega = $resultado[0]['fechaHoraEntrega'];
                    $this->observacion = $resultado[0]['observacion'];
                    $this->total = $resultado[0]['total'];
                    $this->flete = $resultado[0]['flete'];
                    $this->tipo = $resultado[0]['tipo'];
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
    
    public function getCliente(){
        return new Usuarios($this->nitCliente);
    }

    function getNitVendedor() {
        return $this->nitVendedor;
    }

    function getNitProveedor() {
        return $this->nitProveedor;
    }
    
    public function getProveedor(){
        return new Usuarios($this->nitProveedor);
    }

    function getIdMedioDePago() {
        return $this->idMedioDePago;
    }

    function getFechaHoraDocumento() {
        return $this->fechaHoraDocumento;
    }

    function getFechaHoraAcopio() {
        return $this->fechaHoraAcopio;
    }

    function getFechaHoraFacturacion() {
        return $this->fechaHoraFacturacion;
    }

    function getFechaHoraDespacho() {
        return $this->fechaHoraDespacho;
    }

    function getFechaHoraEntrega() {
        return $this->fechaHoraEntrega;
    }

    function getObservacion() {
        return $this->observacion;
    }

    function getTotal() {
        return $this->total;
    }

    function getFlete() {
        return $this->flete;
    }

    function getTipo() {
        return $this->tipo;
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

    function setIdMedioDePago($idMedioDePago) {
        $this->idMedioDePago = $idMedioDePago;
    }

    function setFechaHoraDocumento($fechaHoraDocumento) {
        $this->fechaHoraDocumento = $fechaHoraDocumento;
    }

    function setFechaHoraAcopio($fechaHoraAcopio) {
        $this->fechaHoraAcopio = $fechaHoraAcopio;
    }

    function setFechaHoraFacturacion($fechaHoraFacturacion) {
        $this->fechaHoraFacturacion = $fechaHoraFacturacion;
    }

    function setFechaHoraDespacho($fechaHoraDespacho) {
        $this->fechaHoraDespacho = $fechaHoraDespacho;
    }

    function setFechaHoraEntrega($fechaHoraEntrega) {
        $this->fechaHoraEntrega = $fechaHoraEntrega;
    }

    function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    function setTotal($total) {
        $this->total = $total;
    }

    function setFlete($flete) {
        $this->flete = $flete;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
    
    public function getProximoCodigo(){
        $anio = date("Y");
        $tipo = $this->tipo === '1' ? 'CP' : 'VT';
        $this->tipo = $this->tipo === '1' ? '1' : "2','3";
        $cadenaSQL="select max(codigo) as codigo from factura where tipo in ('{$this->tipo}') and codigo like '$tipo$anio%'";
        $resultado= ConectorBD::ejecutarQuery($cadenaSQL);
        try {
            if(count($resultado) > 0){
                if(isset($resultado[0]['codigo'])){
                    $numeroFactura=$resultado[0]['codigo'];
                }else{
                    $numeroFactura="$tipo$anio-00000";
                }
            }
        } catch (Exception $exc) {
            echo "<p> error {$exc->getMessage()}";
        }
        $numeroFactura++;
        return $numeroFactura;
    }
    
    public function getMovimientos($item = null) {
        $cadenaSQL = "SELECT T0.year, T0.mes, T0.meses, IFNULL(T1.cantidad, 0) AS cantidad FROM rangeDays T0 LEFT JOIN (SELECT YEAR(factura.fechaHoraDocumento) AS year, MONTH(factura.fechaHoraDocumento) AS mes, SUM(facturaDetalle.cantidadRecibida) AS cantidad FROM factura JOIN facturaDetalle ON facturaDetalle.codigoFactura = factura.codigo WHERE tipo IN ('2','3') AND estado = '2' AND factura.fechaHoraDocumento >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND facturaDetalle.codigoProducto = '$item' GROUP BY  YEAR(factura.fechaHoraDocumento), MONTH(factura.fechaHoraDocumento) ORDER BY year ASC, mes ASC) T1 ON T0.year = T1.year AND T0.mes = T1.mes";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function guardar() {
        $this->fechaHoraAcopio = !empty($this->fechaHoraAcopio) ? "'{$this->fechaHoraAcopio}'" : 'null';
        $this->fechaHoraDespacho = !empty($this->fechaHoraDespacho) ? "'{$this->fechaHoraDespacho}'" : 'null';
        $this->fechaHoraEntrega = !empty($this->fechaHoraEntrega) ? "'{$this->fechaHoraEntrega}'" : 'null';
        $this->fechaHoraFacturacion = !empty($this->fechaHoraFacturacion) ? "'{$this->fechaHoraFacturacion}'" : 'null';
        $this->nitCliente = !empty($this->nitCliente) ? "'{$this->nitCliente}'" : 'null';
        $this->nitVendedor = !empty($this->nitVendedor) ? "'{$this->nitVendedor}'" : 'null';
        $this->nitProveedor = !empty($this->nitProveedor) ? "'{$this->nitProveedor}'" : 'null';
        $this->idMedioDePago = !empty($this->idMedioDePago) ? "'{$this->idMedioDePago}'" : 'null';
        $cadenaSQL = "insert into factura (codigo, nitCliente, nitVendedor, nitProveedor, idMedioDePago, fechaHoraDocumento, fechaHoraAcopio, fechaHoraFacturacion, fechaHoraDespacho, fechaHoraEntrega, observacion, total, flete, tipo, estado) values('{$this->codigo}',{$this->nitCliente},{$this->nitVendedor},{$this->nitProveedor},{$this->idMedioDePago},'{$this->fechaHoraDocumento}',{$this->fechaHoraAcopio},{$this->fechaHoraFacturacion},{$this->fechaHoraDespacho},{$this->fechaHoraEntrega},'{$this->observacion}','{$this->total}','{$this->flete}','{$this->tipo}','{$this->estado}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($codigoAnterior) {
        $this->fechaHoraAcopio = !empty($this->fechaHoraAcopio) ? "'{$this->fechaHoraAcopio}'" : 'null';
        $this->fechaHoraDespacho = !empty($this->fechaHoraDespacho) ? "'{$this->fechaHoraDespacho}'" : 'null';
        $this->fechaHoraEntrega = !empty($this->fechaHoraEntrega) ? "'{$this->fechaHoraEntrega}'" : 'null';
        $this->fechaHoraFacturacion = !empty($this->fechaHoraFacturacion) ? "'{$this->fechaHoraFacturacion}'" : 'null';
        $this->nitCliente = !empty($this->nitCliente) ? "'{$this->nitCliente}'" : 'null';
        $this->nitVendedor = !empty($this->nitVendedor) ? "'{$this->nitVendedor}'" : 'null';
        $this->nitProveedor = !empty($this->nitProveedor) ? "'{$this->nitProveedor}'" : 'null';
        $this->idMedioDePago = !empty($this->idMedioDePago) ? "'{$this->idMedioDePago}'" : 'null';
        $cadenaSQL = "update factura set codigo='{$this->codigo}', nitCliente={$this->nitCliente}, nitVendedor={$this->nitVendedor}, nitProveedor={$this->nitProveedor}, idMedioDePago={$this->idMedioDePago}, fechaHoraDocumento='{$this->fechaHoraDocumento}', fechaHoraAcopio={$this->fechaHoraAcopio}, fechaHoraFacturacion={$this->fechaHoraFacturacion}, fechaHoraDespacho={$this->fechaHoraDespacho}, fechaHoraEntrega={$this->fechaHoraEntrega}, observacion='{$this->observacion}', total='{$this->total}', flete='{$this->flete}', tipo='{$this->tipo}', estado='{$this->estado}' where codigo='$codigoAnterior'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from factura where codigo='{$this->codigo}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select codigo, codigo, nitCliente, nitVendedor, nitProveedor, idMedioDePago, fechaHoraDocumento, fechaHoraAcopio, fechaHoraFacturacion, fechaHoraDespacho, fechaHoraEntrega, observacion, total, flete, tipo, estado, CASE WHEN factura.estado = '1' THEN 'Pendiente' WHEN factura.estado = '2' THEN 'Orden de compra' WHEN factura.estado = '3' THEN 'Cancelado' ELSE 'Desconocido' END as estadoPedido from factura $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Factura::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Factura($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

}