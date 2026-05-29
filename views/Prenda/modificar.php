<?php
$page_id    = 'prendas';
$page_title = 'Modificar Prenda';
require_once 'views/layouts/header.php';
?>

<div class="ptitle">Modificar Prenda</div>
<div class="psub">Editando ID #<?php echo $prenda['Id_prendas']; ?></div>

<div class="fcard" style="max-width:500px">
  <form action="<?php echo url('prenda','actualizar'); ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $prenda['Id_prendas']; ?>">
    <div class="fg" style="margin-bottom:13px"><label>Prenda</label>
      <input class="fc" type="text" name="prendas" value="<?php echo htmlspecialchars($prenda['Prendas']); ?>"></div>
    <div class="fg" style="margin-bottom:16px"><label>Núm. Piezas</label>
      <input class="fc" type="number" name="num_piezas" value="<?php echo $prenda['Num_piezas']; ?>" min="0"></div>
    <div style="display:flex;gap:10px">
      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
      <a href="<?php echo url('prenda'); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Cancelar</a>
    </div>
  </form>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
