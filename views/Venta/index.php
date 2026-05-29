<?php
$page_id    = 'ventas';
$page_title = 'Registro de Ventas';
require_once 'views/layouts/header.php';
?>

<div class="ptitle">Registro de Ventas</div>
<div class="psub">Registra y consulta las ventas realizadas</div>

<?php if ($guardado): ?>
<div class="alert alert-ok"><i class="fas fa-check-circle"></i> Venta registrada correctamente.</div>
<?php endif; ?>

<!-- FORMULARIO -->
<div class="fcard">
  <form action="<?php echo url('venta'); ?>" method="post">
    <div class="fgrid">
      <div class="fg"><label>Fecha *</label>
        <input class="fc" type="date" name="fecha" required></div>
      <div class="fg"><label>Realización *</label>
        <input class="fc" type="text" name="realizacion" placeholder="Descripción" required></div>
      <div class="fg"><label>Total ($) *</label>
        <input class="fc" type="number" name="total" step="0.01" placeholder="0.00" required></div>
      <div class="fg"><label>Cliente *</label>
        <select class="fc" name="id_cliente" required>
          <option value="">-- Selecciona Cliente --</option>
          <?php foreach ($clientes as $c): ?>
          <option value="<?php echo $c['Id_cliente']; ?>">
            <?php echo $c['Id_cliente'] . ' - ' . htmlspecialchars($c['Nombre'] . ' ' . $c['Ap_paterno']); ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="fg"><label>Total Piezas *</label>
        <input class="fc" type="number" name="total_piezas" placeholder="0" required></div>
    </div>
    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Venta</button>
  </form>
</div>

<!-- TABLA -->
<div class="tcard">
  <div class="tcard-hdr">
    <div class="tcard-ttl"><i class="fas fa-list" style="color:var(--green)"></i> Lista de Ventas</div>
  </div>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Fecha</th><th>Realización</th>
        <th>Total</th><th>Cliente</th><th>Piezas</th>
        <th>Eliminar</th><th>Modificar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($ventas as $row): ?>
      <tr>
        <td>#<?php echo $row['Id_venta']; ?></td>
        <td><?php echo $row['Fecha']; ?></td>
        <td><?php echo htmlspecialchars($row['Realizacion']); ?></td>
        <td>$<?php echo number_format($row['Total'], 2); ?></td>
        <td><?php echo htmlspecialchars($row['Nombre'] . ' ' . $row['Ap_paterno']); ?></td>
        <td><?php echo $row['Total_piezas']; ?></td>
        <td>
          <a href="<?php echo url('venta','eliminar',['id'=>$row['Id_venta']]); ?>"
             class="ib ib-del"
             onclick="return confirm('¿Eliminar esta venta?')">
            <i class="fas fa-times"></i>
          </a>
        </td>
        <td>
          <a href="<?php echo url('venta','editar',['id'=>$row['Id_venta']]); ?>" class="ib ib-edit">
            <i class="fas fa-pencil-alt"></i>
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
