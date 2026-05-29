<?php

class DashboardController {
    public function index() {
        $clienteModel = new Cliente();
        $ventaModel   = new Venta();
        $prendaModel  = new Prenda();

        $hora = (int)date('H');
        if ($hora >= 6 && $hora < 12)      $saludo = '☀️ ¡Buenos días!';
        elseif ($hora >= 12 && $hora < 19) $saludo = '🌤️ ¡Buenas tardes!';
        else                                $saludo = '🌙 ¡Buenas noches!';

        $ventasMes      = $ventaModel->getPerMonth();
        $labels         = array_column($ventasMes, 'mes');
        $totales        = array_column($ventasMes, 'total');
        $total_clientes = $clienteModel->count();
        $total_ventas   = $ventaModel->count();
        $total_prendas  = $prendaModel->count();
        $monto_total    = $ventaModel->sumTotal();
        $ultimos_clientes = $clienteModel->getLast5();
        $ultimas_ventas   = $ventaModel->getLast5();

        require_once 'views/Dashboard/index.php';
    }
}
