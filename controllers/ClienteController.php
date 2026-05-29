<?php

class ClienteController {
    private $model;

    public function __construct() {
        $this->model = new Cliente();
    }

    public function index() {
        $guardado = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $req = ['nombre','ap_paterno','telefono','contrasena','direccion','cp'];
            if ($this->allSet($req)) {
                $this->model->crear([
                    'nombre'     => trim($_POST['nombre']),
                    'ap_paterno' => trim($_POST['ap_paterno']),
                    'telefono'   => trim($_POST['telefono']),
                    'contrasena' => $_POST['contrasena'],
                    'direccion'  => trim($_POST['direccion']),
                    'cp'         => trim($_POST['cp']),
                ]);
                $guardado = true;
            }
        }

        $saludo   = $this->saludo();
        $clientes = $this->model->getAll();
        require_once 'views/Cliente/index.php';
    }

    public function editar() {
        $id      = (int)($_GET['id'] ?? 0);
        $cliente = $this->model->getById($id);
        if (!$cliente) { header('Location: index.php'); exit; }
        require_once 'views/Cliente/modificar.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->actualizar([
                'id'         => (int)$_POST['id'],
                'nombre'     => trim($_POST['nombre']),
                'ap_paterno' => trim($_POST['ap_paterno']),
                'telefono'   => trim($_POST['telefono']),
                'contrasena' => $_POST['contrasena'] ?? '',
                'direccion'  => trim($_POST['direccion']),
                'cp'         => trim($_POST['cp']),
            ]);
        }
        header('Location: index.php?controller=cliente');
        exit;
    }

    public function eliminar() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) $this->model->eliminar($id);
        header('Location: index.php?controller=cliente');
        exit;
    }

    public function reporte() {
        require_once 'views/Cliente/reporte_pdf.php';
        generarReporteClientes($this->model->getAllForReport(), $this->model->count());
    }

    private function saludo(): string {
        $hora = (int)date('H');
        if ($hora >= 6 && $hora < 12)      return '☀️ ¡Buenos días!';
        elseif ($hora >= 12 && $hora < 19) return '🌤️ ¡Buenas tardes!';
        else                                return '🌙 ¡Buenas noches!';
    }

    private function allSet(array $keys): bool {
        foreach ($keys as $k) {
            if (!isset($_POST[$k]) || $_POST[$k] === '') return false;
        }
        return true;
    }
}
