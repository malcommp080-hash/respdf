<?php
$page_id    = 'ventas';
$page_title = 'Modificar Venta';
require_once 'views/layouts/header.php';
?>

<div class="ptitle">Modificar Venta</div>
<div class="psub">Editando venta ID #<?php echo $venta['Id_venta']; ?></div>

<div class="fcard" style="max-width:700px">
  <form action="<?php echo url('venta','actualizar'); ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $venta['Id_venta']; ?>">
    <div class="fgrid">
      <div class="fg"><label>Fecha</label>
        <input class="fc" type="date" name="fecha" value="<?php echo $venta['Fecha']; ?>"></div>
      <div class="fg"><label>Realización</label>
        <input class="fc" type="text" name="realizacion" value="<?php echo htmlspecialchars($venta['Realizacion']); ?>"></div>
      <div class="fg"><label>Total ($)</label>
        <input class="fc" type="number" step="0.01" name="total" value="<?php echo $venta['Total']; ?>"></div>
      <div class="fg"><label>Cliente</label>
        <select class="fc" name="id_cliente">
          <?php foreach ($clientes as $c): ?>
          <option value="<?php echo $c['Id_cliente']; ?>" <?php echo $c['Id_cliente'] == $venta['Id_cliente'] ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($c['Nombre'] . ' ' . $c['Ap_paterno']); ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="fg"><label>Total Piezas</label>
        <input class="fc" type="number" name="total_piezas" value="<?php echo $venta['Total_piezas']; ?>"></div>
    </div>
    <div style="display:flex;gap:10px">
      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
      <a href="<?php echo url('venta'); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Cancelar</a>
    </div>
  </form>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
