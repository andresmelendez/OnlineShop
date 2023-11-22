/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Andres
 * Created: 29/06/2022
 */

create table empresa(
    nit varchar(12) primary key,
    nombreComercial varchar (50) not null,
    razonSocial varchar (50) not null,
    direccion varchar (80) not null,
    latitud float null,
    longitud float null,
    telefono varchar(10) not null,
    celular varchar(10) null,
    email varchar(80) null,
    logo varchar(100) null
);

create table horario(
    id int auto_increment primary key,
    dia char(1) not null,
    horaIncio time not null,
    horaFin time not null,
    nitEmpresa varchar(12) not null references empresa(nit) on delete restrict on update cascade
);

create table festivos(
    id int auto_increment primary key,
    nitEmpresa varchar(12) not null references empresa(nit) on delete restrict on update cascade,
    dia int not null,
    mes int not null
);

create table almacen(
    id int auto_increment primary key,
    nombre varchar(50)not null unique
);

create table medioDePago(
    id int auto_increment primary key,
    nombre varchar(50)not null unique,
    observaciones text null
);

create table unidadEmpaque(
    id int auto_increment primary key,
    unidad varchar(50)not null unique,
    observaciones text null
);

create table pais(
    codigo varchar(3) primary key,
    nombre varchar(50)not null unique
);

create table departamento(
    codigo varchar(3) primary key,
    nombre varchar(50)not null,
    codigoPais varchar(3) not null references pais(codigo) on delete restrict on update cascade
);

create table ciudad(
    codigo varchar(5) primary key,
    nombre varchar(50)not null,
    codigoDepartamento varchar(3) not null references departamento(codigo) on delete restrict on update cascade
);

create table impuesto(
    id int auto_increment primary key,
    nombre varchar(50) not null,
    porcentaje int not null
);

create table marca(
    id int auto_increment primary key,
    nombre varchar(50) not null
);

create table linea(
    id int auto_increment primary key,
    nombre varchar(50) not null
);

create table grupo(
    id int auto_increment primary key,
    nombre varchar(50) not null,
    idLinea int not null references linea(id) on delete restrict on update cascade
);

create table opcion (
    id int auto_increment primary key,
    nombre varchar(50) not null, 
    descripcion text null, 
    ruta text null, 
    idPadre int null references opcion(id) on delete restrict on update cascade,
    icono varchar(100) null
);

create table perfil (
    id int auto_increment primary key,
    nombre varchar(100) not null, 
    descripcion text null
);

create table opcionPerfil (
    id int auto_increment primary key,
    idPerfil int not null references perfil(id) on delete restrict on update cascade,
    idOpcion int not null references opcion(id) on delete restrict on update cascade
);

create table producto(
    codigo varchar(12) not null primary key,
    descripcion text not null,
    idMarca int null references marca(id) on delete restrict on update cascade,
    idGrupo int null references grupo(id) on delete restrict on update cascade,
    idImpuesto int null references impuesto(id) on delete restrict on update cascade,
    idUnidadCompra int null references unidadEmpaque(id) on delete restrict on update cascade,
    cantidadCompra int not null,
    idUnidadVenta int null references unidadEmpaque(id) on delete restrict on update cascade,
    cantidadVenta int not null,
    cantidadVolumen int not null,
    codigoDeBarras varchar(20) not null,
    precio int not null,
    costo int not null,
    promocion char(1) not null,
    tipoServicio char(1) not null,
    foto varchar(100) null,
    foto1 varchar(100) null,
    foto2 varchar(100) null,
    estado char(1) not null,
    caracteristicas text not null
);

create table descuentoProducto(
    id int auto_increment primary key,
    tipo char(1) null,
    nombreGrupo varchar(4) not null,
    margenXVolumen float not null,
    margenXEmpaque float not null,
    margenXTipo float not null
    
);

create table inventario(
    id int auto_increment primary key,
    idAlmacen int not null references almacen(id) on delete restrict on update cascade,
    codigoProducto varchar(12) not null references producto(codigo) on delete restrict on update cascade,
    stock int not null,
    stockMaximo int not null,
    stockMinimo int not null,
    pedido int not null,
    comprometido int not null
);

create table usuarios(
    nit varchar(12) not null primary key,
    nombres varchar(100) not null,
    apellidos varchar(100) not null,
    nombreComercial varchar(100) null,
    celular varchar(10) null,
    email varchar(80) null,
    direccion varchar(80) null,
    barrio varchar(80) null,
    clave varchar(128) not null,
    idPerfil int not null references perfil(id) on delete restrict on update cascade,
    tipoNegocios varchar(100) null,
    tipoPrecios char(1) null,
    codigoCiudad varchar(10) null references ciudad(codigo) on delete restrict on update cascade,
    cupo int null,
    descuentoComercial float null,
    descuentoFinanciero float null,
    bonificacion float null,
    estado char(1) not null
);

create table productoUsuario(
    id int auto_increment primary key,
    nitUsuario varchar(12) null references usuarios(nit) on delete restrict on update cascade,
    codigoProducto varchar(12) not null references producto(codigo) on delete restrict on update cascade
);

create table factura(
    codigo varchar(12) primary key not null, 
    nitCliente varchar(12) null references usuarios(nit) on delete restrict on update cascade,
    nitVendedor varchar(12) null references usuarios(nit) on delete restrict on update cascade,
    nitProveedor varchar(12) null references usuarios(nit) on delete restrict on update cascade,
    idMedioDePago int null references medioDePago(id) on delete restrict on update cascade,
    fechaHoraDocumento timestamp not null, 
    fechaHoraAcopio timestamp null, 
    fechaHoraFacturacion timestamp null, 
    fechaHoraDespacho timestamp null, 
    fechaHoraEntrega timestamp null, 
    observacion text null, 
    total float not null,
    flete int not null,
    tipo char(1) not null,
    estado char not null
);

create table facturaDetalle(
    id int auto_increment primary key,
    codigoFactura varchar(12) not null references factura(codigo) on delete restrict on update cascade,
    codigoProducto varchar(12) not null references producto(codigo) on delete restrict on update cascade, 
    idAlmacen int not null references almacen(id) on delete restrict on update cascade,
    cantidadSolicitada int not null,
    cantidadRecibida int null,
    precio float not null
);

create table tomaInventario(
    id int auto_increment primary key,
    nitResponsable varchar(12) null references usuarios(nit) on delete restrict on update cascade,
    fechaHoraDocumento timestamp not null, 
    estado char not null
);

create table tomaInventarioDetalle(
    id int auto_increment primary key,
    idTomaInventario int not null references tomaInventario(id) on delete restrict on update cascade,
    codigoProducto varchar(12) not null references producto(codigo) on delete restrict on update cascade,
    idAlmacen int not null references almacen(id) on delete restrict on update cascade,
    cantidadSistema int not null,
    cantidadEncontrada int not null
);

create table movimientoInventario(
    id int auto_increment primary key,
    codigoProducto varchar(12) not null references producto(codigo) on delete restrict on update cascade,
    idAlmacen int not null references almacen(id) on delete restrict on update cascade,
    fechaHora timestamp not null, 
    entrada int not null,
    salida int not null,
    saldo int not null,
    tipoMovimiento char(1) not null
);

create table devolucion(
    codigo varchar(12) primary key not null, 
    nitCliente varchar(12) null references usuarios(nit) on delete restrict on update cascade,
    nitVendedor varchar(12) null references usuarios(nit) on delete restrict on update cascade,
    nitProveedor varchar(12) null references usuarios(nit) on delete restrict on update cascade,
    fechaHoraDocumento timestamp not null, 
    estado char not null
);

create table devolucionDetalle(
    id int auto_increment primary key,
    codigoDevolucion varchar(12) not null references factura(codigo) on delete restrict on update cascade,
    codigoProducto varchar(12) not null references producto(codigo) on delete restrict on update cascade, 
    idAlmacen int not null references almacen(id) on delete restrict on update cascade,
    cantidad int null
);

INSERT INTO perfil (nombre, descripcion) VALUES ('Administrador', 'Administrador del sistema de informacion');

INSERT INTO usuarios (nit, nombres, apellidos, nombreComercial, celular, email, direccion, barrio, clave, idPerfil, tipoNegocios, tipoPrecios, codigoCiudad, cupo, descuentoComercial, descuentoFinanciero, bonificacion, estado) VALUES ('1193255326', 'ANDRES FELIPE', 'ORTEGA MELENDEZ', NULL, '3127501056', NULL, NULL, 'CAICEDO', '2d1d9ae20492793ac9e3119a653aad006cffda97dd1d74dfa6ba6e25a44369977f3ff51539b818e73f4756a7a5f08f6ed8fd4473000b11bfc0032cbd7066fb9b', '1', 'SIN NEGOCIO', NULL, NULL, '0', '0', '0', '0', 'Y');

ALTER TABLE horario ADD FOREIGN KEY(nitEmpresa) REFERENCES empresa(nit) ON UPDATE CASCADE;
ALTER TABLE festivos ADD FOREIGN KEY(nitEmpresa) REFERENCES empresa(nit) ON UPDATE CASCADE;
ALTER TABLE departamento ADD FOREIGN KEY(codigoPais) REFERENCES pais(codigo) ON UPDATE CASCADE;
ALTER TABLE ciudad ADD FOREIGN KEY(codigoDepartamento) REFERENCES departamento(codigo) ON UPDATE CASCADE;
ALTER TABLE grupo ADD FOREIGN KEY(idLinea) REFERENCES linea(id) ON UPDATE CASCADE;
ALTER TABLE opcionPerfil ADD FOREIGN KEY(idPerfil) REFERENCES perfil(id) ON UPDATE CASCADE;
ALTER TABLE opcionPerfil ADD FOREIGN KEY(idOpcion) REFERENCES opcion(id) ON UPDATE CASCADE;
ALTER TABLE producto ADD FOREIGN KEY(idGrupo) REFERENCES grupo(id) ON UPDATE CASCADE;
ALTER TABLE producto ADD FOREIGN KEY(idMarca) REFERENCES marca(id) ON UPDATE CASCADE;
ALTER TABLE producto ADD FOREIGN KEY(idImpuesto) REFERENCES impuesto(id) ON UPDATE CASCADE;
ALTER TABLE producto ADD FOREIGN KEY(idUnidadCompra) REFERENCES unidadEmpaque(id) ON UPDATE CASCADE;
ALTER TABLE producto ADD FOREIGN KEY(idUnidadVenta) REFERENCES unidadEmpaque(id) ON UPDATE CASCADE;
ALTER TABLE inventario ADD FOREIGN KEY(idAlmacen) REFERENCES almacen(id) ON UPDATE CASCADE;
ALTER TABLE inventario ADD FOREIGN KEY(codigoProducto) REFERENCES producto(codigo) ON UPDATE CASCADE;
ALTER TABLE usuarios ADD FOREIGN KEY(idPerfil) REFERENCES perfil(id) ON UPDATE CASCADE;
ALTER TABLE usuarios ADD FOREIGN KEY(codigoCiudad) REFERENCES ciudad(codigo) ON UPDATE CASCADE;
ALTER TABLE productoUsuario ADD FOREIGN KEY(nitUsuario) REFERENCES usuarios(nit) ON UPDATE CASCADE;
ALTER TABLE productoUsuario ADD FOREIGN KEY(codigoProducto) REFERENCES producto(codigo) ON UPDATE CASCADE;
ALTER TABLE factura ADD FOREIGN KEY(nitCliente) REFERENCES usuarios(nit) ON UPDATE CASCADE;
ALTER TABLE factura ADD FOREIGN KEY(nitVendedor) REFERENCES usuarios(nit) ON UPDATE CASCADE;
ALTER TABLE factura ADD FOREIGN KEY(nitProveedor) REFERENCES usuarios(nit) ON UPDATE CASCADE;
ALTER TABLE factura ADD FOREIGN KEY(idMedioDePago) REFERENCES medioDePago(id) ON UPDATE CASCADE;
ALTER TABLE facturaDetalle ADD FOREIGN KEY(codigoFactura) REFERENCES factura(codigo) ON UPDATE CASCADE;
ALTER TABLE facturaDetalle ADD FOREIGN KEY(codigoProducto) REFERENCES producto(codigo) ON UPDATE CASCADE;
ALTER TABLE facturaDetalle ADD FOREIGN KEY(idAlmacen) REFERENCES almacen(id) ON UPDATE CASCADE;
ALTER TABLE tomaInventario ADD FOREIGN KEY(nitResponsable) REFERENCES usuarios(nit) ON UPDATE CASCADE;
ALTER TABLE tomaInventarioDetalle ADD FOREIGN KEY(idTomaInventario) REFERENCES tomaInventario(id) ON UPDATE CASCADE;
ALTER TABLE tomaInventarioDetalle ADD FOREIGN KEY(codigoProducto) REFERENCES producto(codigo) ON UPDATE CASCADE;
ALTER TABLE tomaInventarioDetalle ADD FOREIGN KEY(idAlmacen) REFERENCES almacen(id) ON UPDATE CASCADE;
ALTER TABLE movimientoInventario ADD FOREIGN KEY(codigoProducto) REFERENCES producto(codigo) ON UPDATE CASCADE;
ALTER TABLE movimientoInventario ADD FOREIGN KEY(idAlmacen) REFERENCES almacen(id) ON UPDATE CASCADE;
ALTER TABLE devolucion ADD FOREIGN KEY(nitCliente) REFERENCES usuarios(nit) ON UPDATE CASCADE;
ALTER TABLE devolucion ADD FOREIGN KEY(nitVendedor) REFERENCES usuarios(nit) ON UPDATE CASCADE;
ALTER TABLE devolucion ADD FOREIGN KEY(nitProveedor) REFERENCES usuarios(nit) ON UPDATE CASCADE;
ALTER TABLE devolucionDetalle ADD FOREIGN KEY(codigoDevolucion) REFERENCES devolucion(codigo) ON UPDATE CASCADE;
ALTER TABLE devolucionDetalle ADD FOREIGN KEY(codigoProducto) REFERENCES producto(codigo) ON UPDATE CASCADE;
ALTER TABLE devolucionDetalle ADD FOREIGN KEY(idAlmacen) REFERENCES almacen(id) ON UPDATE CASCADE;