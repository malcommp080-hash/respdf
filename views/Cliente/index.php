<?php
$page_id    = 'clientes';
$page_title = 'Registro de Clientes';
require_once 'views/layouts/header.php';
?>

<div class="ptitle">Registro de Clientes</div>
<div class="psub"><?php echo $saludo; ?></div>

<?php if ($guardado): ?>
<div class="alert alert-ok"><i class="fas fa-check-circle"></i> Cliente guardado correctamente.</div>
<?php endif; ?>

<!-- FORMULARIO -->
<div class="fcard">
  <form action="<?php echo url('cliente'); ?>" method="post">
    <div class="fgrid">
      <div class="fg"><label>Nombre *</label>
        <input class="fc" type="text" name="nombre" placeholder="Nombre" required></div>
      <div class="fg"><label>Apellido Paterno *</label>
        <input class="fc" type="text" name="ap_paterno" placeholder="Apellido Paterno" required></div>
      <div class="fg"><label>Teléfono *</label>
        <input class="fc" type="text" name="telefono" placeholder="Teléfono" required></div>
      <div class="fg"><label>Contraseña *</label>
        <input class="fc" type="password" name="contrasena" placeholder="Contraseña" required></div>
      <div class="fg"><label>Dirección *</label>
        <input class="fc" type="text" name="direccion" placeholder="Dirección" required></div>
      <div class="fg"><label>Código Postal *</label>
        <input class="fc" type="text" name="cp" placeholder="Código Postal" required></div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
  </form>
</div>

<!-- TABLA -->
<div class="tcard">
  <div class="tcard-hdr">
    <div class="tcard-ttl"><i class="fas fa-users" style="color:var(--accent)"></i> Lista de Clientes</div>
    <a href="<?php echo url('cliente','reporte'); ?>" class="btn btn-sm btn-teal">
      <i class="fas fa-file-pdf"></i> Reporte PDF
    </a>
  </div>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Nombre</th><th>Ap. Paterno</th>
        <th>Teléfono</th><th>Dirección</th><th>CP</th>
        <th>Eliminar</th><th>Modificar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($clientes as $row): ?>
      <tr>
        <td><?php echo $row['Id_cliente']; ?></td>
        <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
        <td><?php echo htmlspecialchars($row['Ap_paterno']); ?></td>
        <td><?php echo htmlspecialchars($row['Telefono']); ?></td>
        <td><?php echo htmlspecialchars($row['Direccion']); ?></td>
        <td><?php echo htmlspecialchars($row['CP']); ?></td>
        <td>
          <a href="<?php echo url('cliente','eliminar',['id'=>$row['Id_cliente']]); ?>"
             class="ib ib-del"
             onclick="return confirm('¿Eliminar a <?php echo addslashes(htmlspecialchars($row['Nombre'])); ?>?')">
            <i class="fas fa-times"></i>
          </a>
        </td>
        <td>
          <a href="<?php echo url('cliente','editar',['id'=>$row['Id_cliente']]); ?>" class="ib ib-edit">
            <i class="fas fa-pencil-alt"></i>
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
