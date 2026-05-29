<?php

class Venta {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $result = $this->db->query(
            'SELECT v.*, c.Nombre, c.Ap_paterno
             FROM venta v
             INNER JOIN cliente c ON v.Id_cliente = c.Id_cliente
             ORDER BY v.Id_venta DESC'
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare('SELECT * FROM venta WHERE Id_venta = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public function getLast5(): array {
        $result = $this->db->query(
            'SELECT v.Id_venta, v.Fecha, v.Total, v.Total_piezas,
                    c.Nombre, c.Ap_paterno
             FROM venta v
             INNER JOIN cliente c ON v.Id_cliente = c.Id_cliente
             ORDER BY v.Id_venta DESC LIMIT 5'
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function count(): int {
        return (int) $this->db->query('SELECT COUNT(*) FROM venta')->fetch_row()[0];
    }

    public function sumTotal(): string {
        $val = $this->db->query('SELECT SUM(Total) FROM venta')->fetch_row()[0];
        return $val ? number_format((float)$val, 2) : '0.00';
    }

    public function getPerMonth(): array {
        $result = $this->db->query(
            "SELECT DATE_FORMAT(Fecha,'%b %Y') AS mes,
                    COUNT(*) AS cantidad,
                    SUM(Total) AS total
             FROM venta
             GROUP BY DATE_FORMAT(Fecha,'%Y-%m'), DATE_FORMAT(Fecha,'%b %Y')
             ORDER BY MIN(Fecha) ASC
             LIMIT 6"
        );
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function crear(array $d): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO venta (Fecha, Realizacion, Total, Id_cliente, Total_piezas)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('ssdii',
            $d['fecha'], $d['realizacion'], $d['total'],
            $d['id_cliente'], $d['total_piezas']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function actualizar(array $d): bool {
        $stmt = $this->db->prepare(
            'UPDATE venta SET Fecha=?, Realizacion=?, Total=?,
             Id_cliente=?, Total_piezas=? WHERE Id_venta=?'
        );
        $stmt->bind_param('ssdiii',
            $d['fecha'], $d['realizacion'], $d['total'],
            $d['id_cliente'], $d['total_piezas'], $d['id']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function eliminar(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM venta WHERE Id_venta = ?');
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
