<?php

require_once '../../clasesGenericas/ConectorBD.php';
require_once '../../librerias/fpdf182/fpdf.php';
require_once '../../clases/app/Factura.php';
require_once '../../clases/app/FacturaDetalle.php';
require_once '../../clases/app/Usuarios.php';
require_once '../../clases/app/Ciudad.php';

$pedido = new Factura($_GET['codigoCompras']);
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);
$pdf->SetTextColor(240, 255, 240);
$pdf->SetFillColor(52, 122, 15);
$pdf->Cell(0, 10, 'OSSA DISTRIBUCIONES', 0, 0, 'C', 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Ln();
$pdf->Cell(0, 5, 'Nit: 87029712', 0, 0, 'C', 1);
$pdf->Ln();
$pdf->Cell(0, 5, 'Telefono: 314 814 1840', 0, 0, 'C', 1);
$pdf->Ln();
$pdf->Cell(0, 5, 'Direccion: Manzana H Casa 5 Barrio: Ezequiel Moreno', 0, 0, 'C', 1);
$pdf->Ln();
$pdf->Cell(0, 5, utf8_decode('San Juan de Pasto Nariño'), 0, 0, 'C', 1);
$pdf->Ln(20);

$pdf->SetFillColor(232, 232, 232);
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(3, 3, 3);
$pdf->Cell(5, 5, "Orden de compra No. {$pedido->getCodigo()}", 0, 1);
$pdf->Cell(5, 5, "Proveedor: {$pedido->getProveedor()->getNombreComercial()}({$pedido->getNitProveedor()})", 0, 1);
$pdf->Cell(5, 5, "Fecha hora: {$pedido->getFechaHoraDocumento()}", 0, 1);
$pdf->Ln(5);

$total = 0;
$pedidoDetalle = FacturaDetalle::getLista("codigoFactura='{$pedido->getCodigo()}'", 'descripcion');
if ($pedidoDetalle != null) {
    $pdf->SetLineWidth(1);
    $pdf->SetFillColor(52, 122, 15);
    $pdf->SetDrawColor(52, 122, 15);
    $pdf->SetTextColor(240, 255, 240);
    $pdf->SetLineWidth(.3);
    $pdf->SetFont('', 'B');
    $pdf->Cell(45, 8, 'Referencia', 1, 0, 'C', 1);
    $pdf->Cell(140, 8, 'Producto', 1, 0, 'C', 1);
    $pdf->Cell(20, 8, 'Cantidad', 1, 0, 'C', 1);
    $pdf->Cell(35, 8, 'Precio', 1, 0, 'C', 1);
    $pdf->Cell(35, 8, 'Valor total', 1, 1, 'C', 1);
    for ($j = 0; $j < count($pedidoDetalle); $j++) {
        $pedidoDetalles = $pedidoDetalle[$j];
        $cantidad = isset($_GET['tipo']) && $_GET['tipo'] === 'solicitado' ? $pedidoDetalles['cantidadSolicitada'] : $pedidoDetalles['cantidadRecibida'];
        $total += $cantidad * $pedidoDetalles['precio'];
        $pdf->SetTextColor(4, 4, 4);
        $pdf->Cell(45, 8, $pedidoDetalles['codigoDeBarras'], 1, 0, 'C');
        $pdf->Cell(140, 8, utf8_decode($pedidoDetalles['descripcion']), 1, 0, 'C');
        $pdf->Cell(20, 8, $cantidad, 1, 0, 'C');
        $pdf->Cell(35, 8, number_format($pedidoDetalles['precio']), 1, 0, 'C');
        $pdf->Cell(35, 8, number_format($cantidad * $pedidoDetalles['precio']), 1, 1, 'C');
    }
    $pdf->Ln(10);
    $pdf->Cell(5, 5, "Total: " . number_format($total), 0, 1);
    $pdf->SetLineWidth(1);
    $pdf->Line(10, $pdf->GetY() + 10, 285, $pdf->GetY() + 10);
    $pdf->Ln(20);
    $pdf->MultiCell(270, 5, "Observaciones: " . utf8_decode($pedido->getObservacion()));
}
$pdf->Output();