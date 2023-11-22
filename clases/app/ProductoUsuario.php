<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductoUsuario
 *
 * @author Andres
 */
class ProductoUsuario {
    
    private $id;
    private $nitUsuario;
    private $codigoProducto;

    function __construct($datos) {
        if ($datos != null) {
            if (is_array($datos)) {
                $this->id = $datos['id'];
                $this->nitUsuario = $datos['nitUsuario'];
                $this->codigoProducto = $datos['codigoProducto'];
            } else {
                $cadenaSQL = "select nitUsuario, codigoProducto from productoUsuario where id='$datos' limit 1";
                $resultado = ConectorBD::ejecutarQuery($cadenaSQL);
                if (count($resultado) > 0 && is_array($resultado)) {
                    $this->id = $datos;
                    $this->nitUsuario = $resultado[0]['nitUsuario'];
                    $this->codigoProducto = $resultado[0]['codigoProducto'];
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getNitUsuario() {
        return $this->nitUsuario;
    }

    function getCodigoProducto() {
        return $this->codigoProducto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNitUsuario($nitUsuario) {
        $this->nitUsuario = $nitUsuario;
    }

    function setCodigoProducto($codigoProducto) {
        $this->codigoProducto = $codigoProducto;
    }

    public function guardar() {
        $cadenaSQL = "insert into productoUsuario (nitUsuario, codigoProducto) values('{$this->nitUsuario}','{$this->codigoProducto}')";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function modificar() {
        $cadenaSQL = "update productoUsuario set nitUsuario='{$this->nitUsuario}', codigoProducto='{$this->codigoProducto}' where id={$this->id}";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public function eliminar() {
        $cadenaSQL = "delete from productoUsuario where codigoProducto='{$this->codigoProducto}'";
        ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getLista($filtro = null, $orden = null) {
        if ($filtro != null) $filtro = " AND $filtro";
        if ($orden != null) $orden = " order by $orden";
        $cadenaSQL = "select id, nitUsuario, usuarios.nit, usuarios.nombreComercial, codigoProducto from usuarios left join productoUsuario on usuarios.nit = productoUsuario.nitUsuario $filtro $orden";
        return ConectorBD::ejecutarQuery($cadenaSQL);
    }

    public static function getListaEnObjetos($filtro = null, $orden = null) {
        $objetos = null;
        $resultado = ProductoUsuario::getLista($filtro, $orden);
        if (count($resultado) > 0 && is_array($resultado)) {
            for ($i = 0; $i < count($resultado); $i++) {
                $objeto = new ProductoUsuario($resultado[$i]);
                $objetos[] = $objeto;
            }
        }
        return $objetos;
    }
    
    public static function getListaEnOptions($filtro = null, $orden = null){
        $lista="";
        $objetos= ProductoUsuario::getLista($filtro, $orden);
        if($objetos != null){
            for ($i = 0; $i < count($objetos); $i++) {
                $objeto=$objetos[$i];
                $auxiliar="";
                if($objeto['nitUsuario'] != null) $auxiliar="checked";
                $lista .= "<div class='form-check form-check-inline col-lg-3 col-xl-3 col-md-5 col-sm-5 col-12 mx-4'><label class='form-check-label'><input class='form-check-input' type='checkbox' name='nitProveedor[]' value='{$objeto['nit']}' $auxiliar><span class='form-check-sign'>{$objeto['nombreComercial']}</span></label></div>";
            }
        }
        echo $lista;
    }

}