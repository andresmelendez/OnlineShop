<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresa
 *
 * @author Andres
 */
class Empresa {
    
    private $nit;
    private $nombreComercial;
    private $razonSocial;
    private $direccion;
    private $longitud;
    private $latitud;
    private $telefono;
    private $celular;
    private $email;
    private $logo;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->nit = $datos['nit'];
                $this->nombreComercial = $datos['nombreComercial'];
                $this->razonSocial = $datos['razonSocial'];
                $this->direccion = $datos['direccion'];
                $this->longitud = $datos['longitud'];
                $this->latitud = $datos['latitud'];
                $this->telefono = $datos['telefono'];
                $this->celular = $datos['celular'];
                $this->email = $datos['email'];
                $this->logo = $datos['logo'];
            } else {
                $cadenaSQL = "select nombreComercial, razonSocial, direccion, longitud, latitud, telefono, celular, email, logo from empresa where nit='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->nit = $datos;
                    $this->nombreComercial = $resultado[0]['nombreComercial'];
                    $this->razonSocial = $resultado[0]['razonSocial'];
                    $this->direccion = $resultado[0]['direccion'];
                    $this->longitud = $resultado[0]['longitud'];
                    $this->latitud = $resultado[0]['latitud'];
                    $this->telefono = $resultado[0]['telefono'];
                    $this->celular = $resultado[0]['celular'];
                    $this->email = $resultado[0]['email'];
                    $this->logo = $resultado[0]['logo'];
                }
            }
        }
    }

    function getNit() {
        return $this->nit;
    }

    function getNombreComercial() {
        return $this->nombreComercial;
    }

    function getRazonSocial() {
        return $this->razonSocial;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getLongitud() {
        return $this->longitud;
    }

    function getLatitud() {
        return $this->latitud;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCelular() {
        return $this->celular;
    }

    function getEmail() {
        return $this->email;
    }

    function getLogo() {
        return $this->logo;
    }

    function setNit($nit) {
        $this->nit = $nit;
    }

    function setNombreComercial($nombreComercial) {
        $this->nombreComercial = $nombreComercial;
    }

    function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setLongitud($longitud) {
        $this->longitud = $longitud;
    }

    function setLatitud($latitud) {
        $this->latitud = $latitud;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }

    public function __toString() {
        return $this->nombreComercial;
    }

    public function guardar() {
        $cadenaSQL = "insert into empresa (nit, nombreComercial, razonSocial, direccion, longitud, latitud, telefono, celular, email, logo) values('{$this->nit}','{$this->nombreComercial}','{$this->razonSocial}','{$this->direccion}','{$this->longitud}','{$this->latitud}','{$this->telefono}','{$this->celular}','{$this->email}','{$this->logo}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar($nitAnterior) {
        $cadenaSQL = "update empresa set nit='{$this->nit}', nombreComercial='{$this->nombreComercial}', razonSocial='{$this->razonSocial}', direccion='{$this->direccion}', longitud='{$this->longitud}', latitud='{$this->latitud}', telefono='{$this->telefono}', celular='{$this->celular}', email='{$this->email}', logo='{$this->logo}' where nit='$nitAnterior'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from empresa where nit='{$this->nit}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " where $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select nit, nombreComercial, razonSocial, direccion, longitud, latitud, telefono, celular, email, logo from empresa $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = Empresa::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new Empresa($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }

    public static function getListaEnOptions($filtro = null, $orden = null, $predeterminado = null) {
        $objetos = Empresa::getListaEnObjetos($filtro, $orden);
        $lista = "";
        if ($objetos != null) {
            for ($i = 0; $i < count($objetos); $i++) {
                $objeto = $objetos[$i];
                $auxiliar = $predeterminado === $objeto->getNit() ? "selected" : '';
                $lista .= "<option value='{$objeto->getNit()}' $auxiliar>{$objeto->getNombreComercial()}</option>";
            }
        }
        return $lista;
    }

}