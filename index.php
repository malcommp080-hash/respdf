<?php

date_default_timezone_set('America/Mexico_City');

require_once 'config/database.php';
require_once 'models/Database.php';
require_once 'models/Cliente.php';
require_once 'models/Venta.php';
require_once 'models/Prenda.php';
require_once 'controllers/ClienteController.php';
require_once 'controllers/VentaController.php';
require_once 'controllers/PrendaController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/RespaldoController.php';


function url(string $ctrl, string $action = 'index', array $params = []): string {
    $u = BASE_URL . '?controller=' . $ctrl . '&action=' . $action;
    foreach ($params as $k => $v) {
        $u .= '&' . urlencode($k) . '=' . urlencode($v);
    }
    return $u;
}

$controller = isset($_GET['controller']) ? preg_replace('/[^a-zA-Z]/', '', $_GET['controller']) : 'dashboard';
$action     = isset($_GET['action'])     ? preg_replace('/[^a-zA-Z]/', '', $_GET['action'])     : 'index';

switch ($controller) {

    case 'cliente':
        $ctrl = new ClienteController();
        switch ($action) {
            case 'index':     $ctrl->index();      break;
            case 'editar':    $ctrl->editar();     break;
            case 'actualizar':$ctrl->actualizar(); break;
            case 'eliminar':  $ctrl->eliminar();   break;
            case 'reporte':   $ctrl->reporte();    break;
            default:          $ctrl->index();      break;
        }
        break;

    case 'venta':
        $ctrl = new VentaController();
        switch ($action) {
            case 'index':     $ctrl->index();      break;
            case 'editar':    $ctrl->editar();     break;
            case 'actualizar':$ctrl->actualizar(); break;
            case 'eliminar':  $ctrl->eliminar();   break;
            default:          $ctrl->index();      break;
        }
        break;

    case 'prenda':
        $ctrl = new PrendaController();
        switch ($action) {
            case 'index':     $ctrl->index();      break;
            case 'editar':    $ctrl->editar();     break;
            case 'actualizar':$ctrl->actualizar(); break;
            case 'eliminar':  $ctrl->eliminar();   break;
            default:          $ctrl->index();      break;
        }
        break;

    case 'respaldo':
        $ctrl = new RespaldoController();
        switch ($action) {
            case 'index':     $ctrl->index();      break;
            case 'descargar': $ctrl->descargar();  break;
            case 'restaurar': $ctrl->restaurar();  break;
            default:          $ctrl->index();      break;
        }
        break;

    case 'dashboard':
    default:
        $ctrl = new DashboardController();
        $ctrl->index();
        break;
}
