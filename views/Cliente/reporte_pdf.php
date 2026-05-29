<?php

function generarReporteClientes(array $clientes, int $total): void {
    $fpdfPath = __DIR__ . '/../../public/libs/fpdf/fpdf.php';

    if (!file_exists($fpdfPath)) {
        die('<p style="color:red;font-family:sans-serif;padding:20px">
             Error: FPDF no encontrado en <code>' . htmlspecialchars($fpdfPath) . '</code></p>');
    }

    require_once $fpdfPath;

    date_default_timezone_set('America/Mexico_City');
    $dias  = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
              'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    $fechaCompleta = $dias[date('w')] . ' ' . date('d') . ' de '
                   . $meses[date('n') - 1] . ' de ' . date('Y') . ' - ' . date('H:i:s');

    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();

    $pdf->SetFillColor(74, 0, 128);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(0, 15, 'Reporte de Clientes', 0, 1, 'C', true);

    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 8, 'Generado el: ' . $fechaCompleta, 0, 1, 'C');
    $pdf->Ln(4);

    $pdf->SetFillColor(122, 0, 212);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(20, 10, 'ID',          1, 0, 'C', true);
    $pdf->Cell(50, 10, 'Nombre',      1, 0, 'C', true);
    $pdf->Cell(50, 10, 'Ap. Paterno', 1, 0, 'C', true);
    $pdf->Cell(45, 10, 'Telefono',    1, 0, 'C', true);
    $pdf->Cell(80, 10, 'Direccion',   1, 0, 'C', true);
    $pdf->Cell(30, 10, 'CP',          1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 10);
    $fill = false;
    foreach ($clientes as $row) {
        $pdf->SetFillColor($fill ? 230 : 255, $fill ? 210 : 255, $fill ? 255 : 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(20, 9, $row['Id_cliente'],              1, 0, 'C', true);
        $pdf->Cell(50, 9, utf8_decode($row['Nombre']),     1, 0, 'L', true);
        $pdf->Cell(50, 9, utf8_decode($row['Ap_paterno']), 1, 0, 'L', true);
        $pdf->Cell(45, 9, $row['Telefono'],                1, 0, 'C', true);
        $pdf->Cell(80, 9, utf8_decode($row['Direccion']),  1, 0, 'L', true);
        $pdf->Cell(30, 9, $row['CP'],                      1, 1, 'C', true);
        $fill = !$fill;
    }

    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(74, 0, 128);
    $pdf->Cell(0, 8, 'Total de clientes registrados: ' . $total, 0, 1, 'R');

    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->SetTextColor(150, 150, 150);
    $pdf->Cell(0, 6, 'Sistema CRUD MVC - Reporte generado automaticamente', 0, 1, 'C');

    $pdf->Output('D', 'reporte_clientes_' . date('Y-m-d') . '.pdf');
    exit;
}
