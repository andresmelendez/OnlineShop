<?php

require_once '../../clasesGenericas/ConectorBD.php';
require_once '../../librerias/fpdf182/fpdf.php';
require_once '../../clases/app/Factura.php';
require_once '../../clases/app/FacturaDetalle.php';
require_once '../../clases/app/Usuarios.php';
require_once '../../clases/app/Ciudad.php';

$factura = new Factura($_GET['codigoPedido']);
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);
$pdf->SetTextColor(240, 255, 240);
$pdf->SetFillColor(52, 122, 15);
$pdf->Cell(0, 10, 'DISTRIBUCIONES OSSA', 0, 0, 'C', 1);
$pdf->Ln(20);

$pdf->SetFillColor(232, 232, 232);
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(3, 3, 3);
$pdf->Cell(5, 5, "Codigo: {$factura->getCodigo()}", 0, 1);
$pdf->Cell(5, 5, 'Cliente: ' . utf8_decode($factura->getCliente()->getNombres() . ' ' . $factura->getCliente()->getApellidos()), 0, 1);
$pdf->Cell(5, 5, 'Direccion: ' . utf8_decode("{$factura->getCliente()->getDireccion()} {$factura->getCliente()->getBarrio()} {$factura->getCliente()->getCiudad()->getNombre()}"), 0, 1);
$pdf->Cell(5, 5, 'Celular: ' . utf8_decode($factura->getCliente()->getCelular()), 0, 1);
$pdf->Cell(5, 5, "Fecha hora: {$factura->getFechaHoraDocumento()}", 0, 1);
$pdf->Ln(5);

$facturaDetalle = FacturaDetalle::getLista("codigoFactura='{$factura->getCodigo()}'", 'descripcion');
if ($facturaDetalle != null) {
    $pdf->SetLineWidth(1);
    $pdf->SetFillColor(52, 122, 15);
    $pdf->SetDrawColor(52, 122, 15);
    $pdf->SetTextColor(240, 255, 240);
    $pdf->SetLineWidth(.3);
    $pdf->SetFont('', 'B');
    $pdf->Cell(45, 8, 'Codigo', 1, 0, 'C', 1);
    $pdf->Cell(140, 8, 'Producto', 1, 0, 'C', 1);
    $pdf->Cell(20, 8, 'Cantidad', 1, 0, 'C', 1);
    $pdf->Cell(35, 8, 'Precio', 1, 0, 'C', 1);
    $pdf->Cell(35, 8, 'Valor total', 1, 1, 'C', 1);
    for ($j = 0; $j < count($facturaDetalle); $j++) {
        $facturaDetalles = $facturaDetalle[$j];
        $pdf->SetTextColor(4, 4, 4);
        $pdf->Cell(45, 8, $facturaDetalles['codigoProducto'], 1, 0, 'C');
        $pdf->Cell(140, 8, utf8_decode($facturaDetalles['descripcion']), 1, 0, 'C');
        $pdf->Cell(20, 8, $facturaDetalles['cantidadSolicitada'], 1, 0, 'C');
        $pdf->Cell(35, 8, number_format($facturaDetalles['precio']), 1, 0, 'C');
        $pdf->Cell(35, 8, number_format($facturaDetalles['cantidadSolicitada'] * $facturaDetalles['precio']), 1, 1, 'C');
    }
    $pdf->Ln(10);
    $pdf->Cell(5, 5, "Subtotal: " . number_format($factura->getTotal()), 0, 1);
    $pdf->Cell(5, 5, "Flete: " . number_format($factura->getFlete()), 0, 1);
    $pdf->Cell(5, 5, "Total: " . number_format($factura->getTotal() + $factura->getFlete()), 0, 1);
    $pdf->SetLineWidth(1);
    $pdf->Line(10, $pdf->GetY() + 10, 285, $pdf->GetY() + 10);
    $pdf->Ln(20);
    $pdf->MultiCell(270, 5, "Observaciones: " . utf8_decode($factura->getObservacion()));
}
$pdf->Output();