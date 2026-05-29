<?php
$page_id    = 'restaurar';
$page_title = 'Respaldo y Restauración';
require_once 'views/layouts/header.php';
?>

<div class="ptitle">Respaldo y Restauración</div>
<div class="psub">Gestiona la base de datos del sistema</div>

<!-- RESPALDO -->
<div class="fcard" style="max-width:500px;margin-bottom:24px">
  <div class="tcard-ttl" style="margin-bottom:14px">
    <i class="fas fa-download" style="color:var(--accent2)"></i> Respaldar Base de Datos
  </div>
  <p style="font-size:13px;color:var(--muted);margin-bottom:16px">
    Descarga un archivo <code>.sql</code> con toda la información actual de la base de datos.
  </p>
  <a href="<?php echo url('respaldo','descargar'); ?>" class="btn btn-success">
    <i class="fas fa-download"></i> Descargar Respaldo
  </a>
</div>

<!-- RESTAURAR -->
<?php if (!empty($mensaje)): ?>
<div class="alert alert-ok"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($mensaje); ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
<div class="alert alert-err"><i class="fas fa-times-circle"></i> <?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<div class="alert alert-warn" style="margin-bottom:18px">
  <i class="fas fa-exclamation-triangle"></i>
  <strong>Advertencia:</strong> La restauración sobreescribirá la base de datos actual. No se puede deshacer.
</div>

<div class="fcard" style="max-width:500px">
  <div class="tcard-ttl" style="margin-bottom:14px">
    <i class="fas fa-upload" style="color:var(--orange)"></i> Restaurar Base de Datos
  </div>
  <form action="<?php echo url('respaldo','restaurar'); ?>" method="post" enctype="multipart/form-data">
    <div class="fg" style="margin-bottom:16px">
      <label>Selecciona un archivo .sql</label>
      <input class="fc" type="file" name="archivo_sql" accept=".sql" required>
    </div>
    <div style="display:flex;gap:10px">
      <button type="submit" class="btn btn-orange"><i class="fas fa-upload"></i> Restaurar</button>
      <a href="<?php echo url('dashboard'); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Cancelar</a>
    </div>
  </form>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
