<?php

class PrendaController {
    private $model;

    public function __construct() {
        $this->model = new Prenda();
    }

    public function index() {
        $guardado = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['prendas'], $_POST['num_piezas']) && $_POST['prendas'] !== '') {
                $this->model->crear([
                    'prendas'    => trim($_POST['prendas']),
                    'num_piezas' => (int)$_POST['num_piezas'],
                ]);
                $guardado = true;
            }
        }

        $saludo  = $this->saludo();
        $prendas = $this->model->getAll();
        require_once 'views/Prenda/index.php';
    }

    public function editar() {
        $id     = (int)($_GET['id'] ?? 0);
        $prenda = $this->model->getById($id);
        if (!$prenda) { header('Location: index.php?controller=prenda'); exit; }
        require_once 'views/Prenda/modificar.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->actualizar([
                'id'         => (int)$_POST['id'],
                'prendas'    => trim($_POST['prendas']),
                'num_piezas' => (int)$_POST['num_piezas'],
            ]);
        }
        header('Location: index.php?controller=prenda');
        exit;
    }

    public function eliminar() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) $this->model->eliminar($id);
        header('Location: index.php?controller=prenda');
        exit;
    }

    private function saludo(): string {
        $hora = (int)date('H');
        if ($hora >= 6 && $hora < 12)      return '☀️ ¡Buenos días!';
        elseif ($hora >= 12 && $hora < 19) return '🌤️ ¡Buenas tardes!';
        else                                return '🌙 ¡Buenas noches!';
    }
}
