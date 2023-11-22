<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuarios
 *
 * @author Andres
 */
class Usuarios {
    
    private $nit;
    private $nombres;
    private $apellidos;
    private $nombreComercial;
    private $celular;
    private $email;
    private $direccion;
    private $barrio;
    private $clave;
    private $idPerfil;
    private $tipoNegocios;
    private $tipoPrecios;
    private $codigoCiudad;
    private $cupo;
    private $descuentoComercial;
    private $descuentoFinanciero;
    private $bonificacion;
    private $estado;
    private $observaciones;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->nit = $datos['nit'];
                $this->nombres = $datos['nombres'];
                $this->apellidos = $datos['apellidos'];
                $this->nombreComercial = $datos['nombreComercial'];
                $this->celular = $datos['celular'];
                $this->email = $datos['email'];
                $this->direccion = $datos['direccion'];
                $this->barrio = $datos['barrio'];
                $this->clave = $datos['clave'];
                $this->idPerfil = $datos['idPerfil'];
                $this->tipoNegocios = $datos['tipoNegocios'];
                $this->tipoPrecios = $datos['tipoPrecios'];
                $this->codigoCiudad = $datos['codigoCiudad'];
                $this->cupo = $datos['cupo'];
                $this->descuentoComercial = $datos['descuentoComercial'];
                $this->descuentoFinanciero = $datos['descuentoFinanciero'];
                $this->bonificacion = $datos['bonificacion'];
                $this->estado = $datos['estado'];
                $this->observaciones = $datos['observaciones'];
            } else {
                $cadenaSQL = "select nombres, apellidos, nombreComercial, celular, email, direccion, barrio, clave, idPerfil, tipoNegocios, tipoPrecios, codigoCiudad, cupo, descuentoComercial, descuentoFinanciero, bonificacion, estado, observaciones from usuarios where nit='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->nit = $datos;
                    $this->nombres = $resultado[0]['nombres'];
                    $this->apellidos = $resultado[0]['apellidos'];
                    $this->nombreComercial = $resultado[0]['nombreComercial'];
                    $this->celular = $resultado[0]['celular'];
                    $this->email = $resultado[0]['email'];
                    $this->direccion = $resultado[0]['direccion'];
                    $this->barrio = $resultado[0]['barrio'];
                    $this->clave = $resultado[0]['clave'];
                    $this->idPerfil = $resultado[0]['idPerfil'];
                    $this->tipoNegocios = $resultado[0]['tipoNegocios'];
                    $this->tipoPrecios = $resultado[0]['tipoPrecios'];
                    $this->codigoCiudad = $resultado[0]['codigoCiudad'];
                    $this->cupo = $resultado[0]['cupo'];
                    $this->descuentoComercial = $resultado[0]['descuentoComercial'];
                    $this->descuentoFinanciero = $resultado[0]['descuentoFinanciero'];
                    $this->bonificacion = $resultado[0]['bonificacion'];
                    $this->estado = $resultado[0]['estado'];
                    $this->observaciones = $resultado[0]['observaciones'];
                }
            }
        }
    }

    function getNit() {
        return $this->nit;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getNombreComercial() {
        return $this->nombreComercial;
    }

    function getCelular() {
        return $this->celular;
    }

    function getEmail() {
        return $this->email;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getBarrio() {
        return $this->barrio;
    }

    function getClave() {
        return $this->clave;
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }
    
    public function getPerfil(){
        return new Perfil($this->idPerfil);
    }

    function getTipoNegocios() {
        return $this->tipoNegocios;
    }

    function getTipoPrecios() {
        return $this->tipoPrecios;
    }

    function getCodigoCiudad() {
        return $this->codigoCiudad;
    }
    
    public function getCiudad() {
        return new Ciudad($this->codigoCiudad);
    }

    function getCupo() {
        return $this->cupo;
    }

    function getDescuentoComercial() {
        return $this->descuentoComercial;
    }

    function getDescuentoFinanciero() {
        return $this->descuentoFinanciero;
    }

    function getBonificacion() {
        return $this->bonificacion;
    }

    function getEstado() {
        return $this->estado;
    }
    
    function getObservaciones() {
        return $this->observaciones;
    }

    function setNit($nit) {
        $this->nit = $nit;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setNombreComercial($nombreComercial) {
        $this->nombreComercial = $nombreComercial;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setBarrio($barrio) {
        $this->barrio = $barrio;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    function setTipoNegocios($tipoNegocios) {
        $this->tipoNegocios = $tipoNegocios;
    }

    function setTipoPrecios($tipoPrecios) {
        $this->tipoPrecios = $tipoPrecios;
    }

    function setCodigoCiudad($codigoCiudad) {
        $this->codigoCiudad = $codigoCiudad;
    }

    function setCupo($cupo) {
        $this->cupo = $cupo;
    }

    function setDescuentoComercial($descuentoComercial) {
        $this->descuentoComercial = $descuentoComercial;
    }

    function setDescuentoFinanciero($descuentoFinanciero) {
        $this->descuentoFinanciero = $descuentoFinanciero;
    }

    function setBonificacion($bonificacion) {
        $this->bonificacion = $bonificacion;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
    
    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    public function __toString() {
        return $this->nombres . ' ' . $this->apellidos;
    }
    
    public function getTotalFacturado($usuario){
        $cadenaSQL = "SELECT SUM(facturaDetalle.cantidadSolicitada * facturaDetalle.precio) AS totalFacturado FROM factura JOIN facturaDetalle ON factura.codigo = facturaDetalle.codigoFactura WHERE factura.estado = '1' AND factura.nitCliente = '$usuario'";
        $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
        if (is_array($resultado) && count($resultado) > 0) {
            return $resultado[0]['totalFacturado'];
        } else {
            return 0;
        }
    }
    
    public function getCupoCliente($usuario){
        $cadenaSQL = "select cupo from usuarios WHERE nit = '$usuario' limit 1";
        $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
        if (is_array($resultado) && count($resultado) > 0) {
            return $resultado[0]['cupo'];
        } else {
            return 0;
        }
    }

    public function guardar() {
        $this->clave = hash('sha3-512', $this->clave);
        $this->nombreComercial = !empty($this->nombreComercial) ? "'{$this->nombreComercial}'" : 'null';
        $this->celular = !empty($this->celular) ? "'{$this->celular}'" : 'null';
        $this->email = !empty($this->email) ? "'{$this->email}'" : 'null';
        $this->cupo = !empty($this->cupo) ? "'{$this->cupo}'" : 'null';
        $this->descuentoComercial = !empty($this->descuentoComercial) ? $this->descuentoComercial : 'null';
        $this->descuentoFinanciero = !empty($this->descuentoFinanciero) ? $this->descuentoFinanciero : 'null';
        $this->bonificacion = !empty($this->bonificacion) ? $this->bonificacion : 'null';
        $this->observaciones = !empty($this->observaciones) ? "'{$this->observaciones}'" : 'null';
        $cadenaSQL = "insert into usuarios (nit, nombres, apellidos, nombreComercial, celular, email, direccion, barrio, clave, idPerfil, tipoNegocios, tipoPrecios, codigoCiudad, cupo, descuentoComercial, descuentoFinanciero, bonificacion, estado, observaciones) values('{$this->nit}','{$this->nombres}','{$this->apellidos}',{$this->nombreComercial},{$this->celular},{$this->email},'{$this->direccion}','{$this->barrio}','{$this->clave}','{$this->idPerfil}','{$this->tipoNegocios}','{$this->tipoPrecios}','{$this->codigoCiudad}',{$this->cupo},{$this->descuentoComercial},{$this->descuentoFinanciero},{$this->bonificacion},'{$this->estado}',{$this->observaciones})";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($nitAnterior) {
        $this->clave = strlen($this->clave) < 32 ? "'" . hash('sha3-512', $this->clave) . "'" : "'{$this->clave}'";
        $this->nombreComercial = !empty($this->nombreComercial) ? "'{$this->nombreComercial}'" : 'null';
        $this->celular = !empty($this->celular) ? "'{$this->celular}'" : 'null';
        $this->email = !empty($this->email) ? "'{$this->email}'" : 'null';
        $this->cupo = !empty($this->cupo) ? $this->cupo : 'null';
        $this->descuentoComercial = !empty($this->descuentoComercial) ? $this->descuentoComercial : 'null';
        $this->descuentoFinanciero = !empty($this->descuentoFinanciero) ? $this->descuentoFinanciero : 'null';
        $this->bonificacion = !empty($this->bonificacion) ? $this->bonificacion : 'null';
        $this->observaciones = !empty($this->observaciones) ? "'{$this->observaciones}'" : 'null';
        $cadenaSQL = "update usuarios set nit='{$this->nit}', nombres='{$this->nombres}', apellidos='{$this->apellidos}', nombreComercial={$this->nombreComercial}, celular={$this->celular}, email={$this->email}, direccion='{$this->direccion}', barrio='{$this->barrio}', clave={$this->clave}, idPerfil='{$this->idPerfil}', tipoNegocios='{$this->tipoNegocios}', tipoPrecios='{$this->tipoPrecios}', codigoCiudad='{$this->codigoCiudad}', cupo={$this->cupo}, descuentoComercial={$this->descuentoComercial}, descuentoFinanciero={$this->descuentoFinanciero}, bonificacion={$this->bonificacion}, estado='{$this->estado}', observaciones={$this->observaciones} where nit='$nitAnterior'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from usuarios where nit='{$this->nit}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select nit, nombres, apellidos, nombreComercial, celular, email, direccion, barrio, clave, idPerfil, tipoNegocios, tipoPrecios, codigoCiudad, cupo, descuentoComercial, descuentoFinanciero, bonificacion, estado, observaciones from usuarios $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Usuarios::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Usuarios($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

    public static function getListaEnOptions($filtro = null, $orden = null, $predeterminado = null) {
        $objetos = Usuarios::getListaEnObjetos($filtro, $orden);
        $lista = "";
        if ($objetos != null) {
            for ($i = 0; $i < count($objetos); $i++) {
                $objeto = $objetos[$i];
                $auxiliar = $predeterminado === $objeto->getNit() ? "selected" : '';
                $lista .= "<option value='{$objeto->getNit()}' $auxiliar>{$objeto->getNombres()} {$objeto->getApellidos()}</option>";
            }
        }
        return $lista;
    }
    
    public static function validar($identificacion, $clave){
        $personas = Usuarios::getListaEnObjetos("nit='$identificacion' and clave='$clave'", null);
        if(is_array($personas)) return $personas[0];
        else return null;
    }

}