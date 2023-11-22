<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConectorBD
 *
 * @author Andres
 */
class ConectorBD {
    
    private $sevidor;
    private $puerto;
    private $usuario;
    private $clave;
    private $baseDatos;
    public $conexion;

    function __construct() {
        $archivo = dirname(__FILE__) . '/../configuracion.ini';
        if (file_exists($archivo)) {
            $datos = parse_ini_file($archivo);
            $this->sevidor = $datos['servidor'];
            $this->puerto = $datos['puerto'];
            $this->usuario = $datos['usuario'];
            $this->clave = $datos['clave'];
            $this->baseDatos = $datos['baseDatos'];
        } else
            echo ' No se encontro el archivo de la configuracion ';
    }

    function conectar() {
        try {
            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            $this->conexion = new PDO("mysql:host={$this->sevidor};port={$this->puerto};dbname={$this->baseDatos}", $this->usuario, $this->clave, $opciones);
        } catch (Exception $exc) {
            echo "<p> error al conectarse con la base de datos {$exc->getMessage()}";
        }
    }

    function desconectar() {
        $this->conexion = null;
    }

    static function ejecutarQuery($cadenaSQL) {
        $conector = new ConectorBD();
        $conector->conectar();
        $sentencia = $conector->conexion->prepare($cadenaSQL);
        if (!$sentencia->execute()) {
            $resultado = "error al ejecutar $cadenaSQL";
        } else {
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        }
        $conector->desconectar();
        return $resultado;
    }

}