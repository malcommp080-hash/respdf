<?php

class VentaController {
    private $model;
    private $clienteModel;

    public function __construct() {
        $this->model        = new Venta();
        $this->clienteModel = new Cliente();
    }

    public function index() {
        $guardado = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $req = ['fecha','realizacion','total','id_cliente','total_piezas'];
            if ($this->allSet($req)) {
                $this->model->crear([
                    'fecha'        => $_POST['fecha'],
                    'realizacion'  => trim($_POST['realizacion']),
                    'total'        => (float)$_POST['total'],
                    'id_cliente'   => (int)$_POST['id_cliente'],
                    'total_piezas' => (int)$_POST['total_piezas'],
                ]);
                $guardado = true;
            }
        }

        $ventas   = $this->model->getAll();
        $clientes = $this->clienteModel->getAll();
        require_once 'views/Venta/index.php';
    }

    public function editar() {
        $id    = (int)($_GET['id'] ?? 0);
        $venta = $this->model->getById($id);
        if (!$venta) { header('Location: index.php?controller=venta'); exit; }
        $clientes = $this->clienteModel->getAll();
        require_once 'views/Venta/modificar.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->actualizar([
                'id'           => (int)$_POST['id'],
                'fecha'        => $_POST['fecha'],
                'realizacion'  => trim($_POST['realizacion']),
                'total'        => (float)$_POST['total'],
                'id_cliente'   => (int)$_POST['id_cliente'],
                'total_piezas' => (int)$_POST['total_piezas'],
            ]);
        }
        header('Location: index.php?controller=venta');
        exit;
    }

    public function eliminar() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) $this->model->eliminar($id);
        header('Location: index.php?controller=venta');
        exit;
    }

    private function allSet(array $keys): bool {
        foreach ($keys as $k) {
            if (!isset($_POST[$k]) || $_POST[$k] === '') return false;
        }
        return true;
    }
}
