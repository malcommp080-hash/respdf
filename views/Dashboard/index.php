<?php
$page_id    = 'dashboard';
$page_title = 'Dashboard';
require_once 'views/layouts/header.php';
?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px">
  <div>
    <div class="ptitle" style="margin-bottom:2px">Dashboard</div>
    <div class="psub" style="margin-bottom:0"><?php echo $saludo; ?> — Resumen general del sistema</div>
  </div>
</div>

<!-- STAT CARDS -->
<div class="stat-grid">
  <div class="sc sc-teal">
    <div>
      <div class="sc-val"><?php echo $total_clientes; ?></div>
      <div class="sc-lbl">Clientes Registrados</div>
      <a href="<?php echo url('cliente'); ?>" class="sc-more" style="color:rgba(255,255,255,.85)">Ver clientes <i class="fas fa-arrow-right"></i></a>
    </div>
    <i class="fas fa-users sc-icon"></i>
  </div>
  <div class="sc sc-green">
    <div>
      <div class="sc-val"><?php echo $total_ventas; ?></div>
      <div class="sc-lbl">Ventas Totales</div>
      <a href="<?php echo url('venta'); ?>" class="sc-more" style="color:rgba(255,255,255,.85)">Ver ventas <i class="fas fa-arrow-right"></i></a>
    </div>
    <i class="fas fa-chart-bar sc-icon"></i>
  </div>
  <div class="sc sc-amber">
    <div>
      <div class="sc-val"><?php echo $total_prendas; ?></div>
      <div class="sc-lbl">Prendas</div>
      <a href="<?php echo url('prenda'); ?>" class="sc-more" style="color:rgba(255,255,255,.85)">Ver prendas <i class="fas fa-arrow-right"></i></a>
    </div>
    <i class="fas fa-tshirt sc-icon"></i>
  </div>
  <div class="sc sc-red">
    <div>
      <div class="sc-val">$<?php echo $monto_total; ?></div>
      <div class="sc-lbl">Monto Total Ventas</div>
      <a href="<?php echo url('venta'); ?>" class="sc-more" style="color:rgba(255,255,255,.85)">Más info <i class="fas fa-arrow-right"></i></a>
    </div>
    <i class="fas fa-dollar-sign sc-icon"></i>
  </div>
</div>

<!-- GRÁFICAS -->
<div class="chart-row">
  <div class="chart-card">
    <div class="ch-hdr">
      <div class="ch-ttl"><i class="fas fa-chart-bar" style="color:var(--accent)"></i> Ventas por Mes</div>
      <div class="ch-btns">
        <button class="ch-btn act" onclick="switchChart('bar',this)">Barras</button>
        <button class="ch-btn" onclick="switchChart('line',this)">Línea</button>
      </div>
    </div>
    <canvas id="graficaVentas" height="200"></canvas>
  </div>
  <div class="chart-card">
    <div class="ch-hdr">
      <div class="ch-ttl"><i class="fas fa-pie-chart" style="color:var(--accent2)"></i> Resumen</div>
    </div>
    <canvas id="graficaDonut" height="160"></canvas>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:14px;text-align:center">
      <div>
        <div style="font-size:10px;color:var(--muted)">Clientes</div>
        <div style="font-size:20px;font-weight:800;color:var(--accent)"><?php echo $total_clientes; ?></div>
      </div>
      <div>
        <div style="font-size:10px;color:var(--muted)">Ventas</div>
        <div style="font-size:20px;font-weight:800;color:var(--accent2)"><?php echo $total_ventas; ?></div>
      </div>
      <div>
        <div style="font-size:10px;color:var(--muted)">Prendas</div>
        <div style="font-size:20px;font-weight:800;color:var(--accent3)"><?php echo $total_prendas; ?></div>
      </div>
    </div>
  </div>
</div>

<!-- TABLAS ÚLTIMOS REGISTROS -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
  <div class="tcard">
    <div class="tcard-hdr">
      <div class="tcard-ttl"><i class="fas fa-users" style="color:var(--accent)"></i> Últimos Clientes</div>
      <a href="<?php echo url('cliente'); ?>" class="btn btn-sm btn-outline">Ver todos</a>
    </div>
    <table>
      <thead><tr><th>ID</th><th>Nombre</th><th>Teléfono</th></tr></thead>
      <tbody>
        <?php foreach ($ultimos_clientes as $c): ?>
        <tr>
          <td><?php echo $c['Id_cliente']; ?></td>
          <td><?php echo htmlspecialchars($c['Nombre'] . ' ' . $c['Ap_paterno']); ?></td>
          <td><?php echo htmlspecialchars($c['Telefono']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="tcard">
    <div class="tcard-hdr">
      <div class="tcard-ttl"><i class="fas fa-dollar-sign" style="color:var(--green)"></i> Últimas Ventas</div>
      <a href="<?php echo url('venta'); ?>" class="btn btn-sm btn-outline">Ver todas</a>
    </div>
    <table>
      <thead><tr><th>ID</th><th>Cliente</th><th>Total</th><th>Piezas</th></tr></thead>
      <tbody>
        <?php foreach ($ultimas_ventas as $v): ?>
        <tr>
          <td>#<?php echo $v['Id_venta']; ?></td>
          <td><?php echo htmlspecialchars($v['Nombre'] . ' ' . $v['Ap_paterno']); ?></td>
          <td>$<?php echo number_format($v['Total'], 2); ?></td>
          <td><?php echo $v['Total_piezas']; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
const labels  = <?php echo json_encode($labels); ?>;
const totales = <?php echo json_encode(array_map('floatval', $totales)); ?>;

const cfg = (type) => ({
  type,
  data: {
    labels,
    datasets: [{
      label: 'Ventas ($)',
      data: totales,
      backgroundColor: type === 'bar'
        ? 'rgba(79,142,247,.6)'
        : 'rgba(79,142,247,.15)',
      borderColor: '#4f8ef7',
      borderWidth: 2,
      borderRadius: type === 'bar' ? 6 : 0,
      tension: 0.4,
      fill: type === 'line',
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
      x: { ticks: { color: '#7a8099' }, grid: { color: '#1e2130' } },
      y: { ticks: { color: '#7a8099' }, grid: { color: '#1e2130' } }
    }
  }
});

let chartV = new Chart(document.getElementById('graficaVentas'), cfg('bar'));

function switchChart(type, btn) {
  document.querySelectorAll('.ch-btn').forEach(b => b.classList.remove('act'));
  btn.classList.add('act');
  chartV.destroy();
  chartV = new Chart(document.getElementById('graficaVentas'), cfg(type));
}

new Chart(document.getElementById('graficaDonut'), {
  type: 'doughnut',
  data: {
    labels: ['Clientes', 'Ventas', 'Prendas'],
    datasets: [{
      data: [<?php echo $total_clientes; ?>, <?php echo $total_ventas; ?>, <?php echo $total_prendas; ?>],
      backgroundColor: ['#4f8ef7','#22d3a5','#f7c948'],
      borderWidth: 0
    }]
  },
  options: {
    responsive: true,
    cutout: '70%',
    plugins: { legend: { labels: { color: '#7a8099', font: { size: 11 } } } }
  }
});
</script>

<?php require_once 'views/layouts/footer.php'; ?>
