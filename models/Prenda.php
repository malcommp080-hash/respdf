<?php

class Prenda {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $result = $this->db->query('SELECT * FROM prendas ORDER BY Id_prendas DESC');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM prendas WHERE Id_prendas = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public function count(): int {
        return (int) $this->db->query('SELECT COUNT(*) FROM prendas')->fetch_row()[0];
    }

    public function crear(array $d): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO prendas (Prendas, Num_piezas) VALUES (?, ?)'
        );
        $stmt->bind_param('si', $d['prendas'], $d['num_piezas']);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function actualizar(array $d): bool {
        $stmt = $this->db->prepare(
            'UPDATE prendas SET Prendas=?, Num_piezas=? WHERE Id_prendas=?'
        );
        $stmt->bind_param('sii', $d['prendas'], $d['num_piezas'], $d['id']);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function eliminar(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM prendas WHERE Id_prendas = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
