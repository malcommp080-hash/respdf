<?php

class Cliente {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $result = $this->db->query('SELECT * FROM cliente ORDER BY Id_cliente DESC');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM cliente WHERE Id_cliente = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public function getLast5(): array {
        $result = $this->db->query(
            'SELECT Id_cliente, Nombre, Ap_paterno, Telefono, Direccion
             FROM cliente ORDER BY Id_cliente DESC LIMIT 5'
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function count(): int {
        return (int) $this->db->query('SELECT COUNT(*) FROM cliente')->fetch_row()[0];
    }

    public function getAllForReport(): array {
        $result = $this->db->query(
            'SELECT Id_cliente, Nombre, Ap_paterno, Telefono, Direccion, CP FROM cliente'
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function crear(array $d): bool {
        $hash = password_hash($d['contrasena'], PASSWORD_DEFAULT);
        $stmt = $this->db->prepare(
            'INSERT INTO cliente (Nombre, Ap_paterno, Telefono, Contrasena, Direccion, CP)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('ssssss',
            $d['nombre'], $d['ap_paterno'], $d['telefono'],
            $hash, $d['direccion'], $d['cp']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function actualizar(array $d): bool {
        if (!empty($d['contrasena'])) {
            $hash = password_hash($d['contrasena'], PASSWORD_DEFAULT);
            $stmt = $this->db->prepare(
                'UPDATE cliente SET Nombre=?, Ap_paterno=?, Telefono=?,
                 Contrasena=?, Direccion=?, CP=? WHERE Id_cliente=?'
            );
            $stmt->bind_param('ssssssi',
                $d['nombre'], $d['ap_paterno'], $d['telefono'],
                $hash, $d['direccion'], $d['cp'], $d['id']
            );
        } else {
            $stmt = $this->db->prepare(
                'UPDATE cliente SET Nombre=?, Ap_paterno=?, Telefono=?,
                 Direccion=?, CP=? WHERE Id_cliente=?'
            );
            $stmt->bind_param('sssssi',
                $d['nombre'], $d['ap_paterno'], $d['telefono'],
                $d['direccion'], $d['cp'], $d['id']
            );
        }
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function eliminar(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM cliente WHERE Id_cliente = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
